/**
 *  Project: KanFF
 *  File: tasks.js for pages about tasks
 *  Author: Samuel Roland
 *  Creation date: 15.10.2020
 */

var optionsOpened = false

//Load the latest copy of task data to restore the form before modifications
function reloadCurrentTaskWithoutModification() {
    response.data.task = task
    loadTaskDetailsWithData(response, "true")
}

function declareEventsForTasks() {
    //bottom line of divTask have to be hidden if divTask is not on hover and displayed if on hover
    declareChangeHiddenStateOnOneChildOnParentHover("divTask", "mouseover", "divTaskBottomLine", false)
    declareChangeHiddenStateOnOneChildOnParentHover("divTask", "mouseout", "divTaskBottomLine", true)
    declareSeeMoreOrLessButtonsEvents()

    //On click on .divTask display the task details
    $(".divTask").on("click", function (event) {
        if (optionsOpened == false && getRealParentHavingId(event.target).getAttribute("data-clickdisabled") != "true") {   //if options of the task are not opened and if the click is not disabled
            displayTaskDetails(event.target)
        } else {
            displayTaskDetails(null)
        }
    })

    $(".divTask").on("mouseout", function (event) {
        optionsOpened = false
    })

    Array.prototype.forEach.call(document.getElementsByClassName("icon-task-triangle"), function (icon) {
        icon.addEventListener("click", function (event) {
            //event.stopPropagation()
            optionsOpened = !optionsOpened
        })
    })
    $(".optTaskDelete").on("click", tryDeleteTask)
    $("#btnSaveTaskDetails").on("click", tryUpdateTask)
    $("#btnCancelTaskDetails").on("click", reloadCurrentTaskWithoutModification)

    $(".iconresponsible").on("click", changeResponsible)

    //Drag and drop events:
    //Inspired from: https://javascript.info/mouse-drag-and-drop
    //Inspired from: https://www.geeksforgeeks.org/how-to-determine-which-element-the-mouse-pointer-move-over-using-javascript/

    $(".divTask").on("mousedown", function (event) {    //when the mouse goes down on a divTask, all next events on mouse will concern this task
        let lastEvent = event   //save the last event information at mousedown (because if the mouse scroll directly, the lastEvent will not be defined)
        task = event.target
        task = getRealParentHavingId(task)  //if clicked on inner HTML of .divTask

        if (task.getAttribute("data-canedit") == "true") {
            //Manage task position on mousemove and scroll. Events are declared on document and not on .divTask, because the task can leave the mouse with a quick movement of the mouse.
            document.addEventListener("mousemove", onMouseMove)
            document.addEventListener("scroll", onMouseMove)

            function onMouseMove(event) {
                realWorkState = getRealParentHavingId(task, "workstate-")   //get the workstate parent of the task (before movement)

                if (realWorkState.querySelector(".divBlankTaskFix") === null) { //if there is not yet any .divBlankTaskFix, create it
                    blankTask = document.createElement("div")
                    blankTask.classList.add("divBlankTaskFix")
                    blankTask.classList.add("borderformodifiabletask")
                    task.insertAdjacentElement("beforebegin", blankTask)
                }
                if (event.type == "mousemove") {
                    logIt("move task for mousemove")
                    lastEvent = event   //save the last event information
                    moveHTMLElementAt(task, lastEvent.pageX, lastEvent.pageY)
                    //Position is absolute because the coordinates are relative to page zone (not the client zone)
                    task.classList.remove("positionfixed")
                    task.classList.add("positionabsolute")
                } else {    //else event.type will be "scroll"
                    logIt("move task for scroll")
                    moveHTMLElementAt(task, lastEvent.clientX, lastEvent.clientY)   //the lastEvent is used because event scroll doesn't give client position information (the position if fixed on the client)
                    //Position need to be fixed because the coordinates are relative to client zone (not the page zone). The task doesn't move on the client zone.
                    task.classList.remove("positionabsolute")
                    task.classList.add("positionfixed")
                }
                checkIsOverAWorkState(lastEvent)    //after have moved, check if is over a workstate (to display the .divBlankTask inside it)
            }

            $(".divTask").on("mouseup", function (event) {
                blankTaskChosen = null  //the blankTask chosen for new position (old position or new position)
                blankTaskChosen = document.querySelector(".divBlankTask")   //if a .divBlankTask exist, the task will change workstate (in the workstate where this .divBlankTask exists)
                if (blankTaskChosen == null) {  //if not found
                    blankTaskChosen = document.querySelector(".divBlankTaskFix")    //stay at old position (same workstate)
                }
                if (blankTaskChosen != null) {  //last check because if the task hasn't moved, the no blank task will exist
                    moveDraggedTaskToBlankTaskChosen(task, blankTaskChosen)

                    if (mustStartUpdate) {
                    //TODO: update the state of the task
                    workstate = getRealParentHavingId(task, "workstate")
                    newState = workstate.id.substr(workstate.id.lastIndexOf("-"))
                    work = getRealParentHavingId(task, "Work-")
                    workid = work.getAttribute("data-id")
                    taskid = task.getAttribute("data-id")
                    tryUpdateTaskState(workid, taskid, newState)

                    //Disable very shortly the click possibility
                    tryChangeState(taskid, newState, workid)
                    }
                    //Disable very shortly the click possibility to avoid click event (click event select the task and display its details in the right panel, but we don't want it)
                    taskDisabled = event.target
                    taskDisabled = getRealParentHavingId(taskDisabled)
                    taskDisabled.setAttribute("data-clickdisabled", true)
                    setTimeout(function () {    //in 20ms enable click for all tasks in the page
                        document.querySelector(".divTask[data-clickdisabled='true']").setAttribute("data-clickdisabled", false)
                    }, 20)
                }
            })

            //replace the blankTask chosen by the dragged task
            function moveDraggedTaskToBlankTaskChosen(taskToMove, blankTaskElement) {
                blankTaskElement.insertAdjacentElement("beforebegin", taskToMove)  //place the task at the left of the blankTask
                taskToMove.classList.remove("positionabsolute")   //remove position absolute
                taskToMove.classList.remove("positionfixed")   //remove position fixed
                taskToMove.style = "" //remove style (left and top position)

                manageBlankTaskToWorkColumn(null, false, true)   //remove all
            }

            document.addEventListener("mouseup", function () {
                //launch moveDraggedTaskToBlankTaskChosen() again because mouseup event on task may not have been launched if
                // the mouse was not directly on the task at this event (if task is dragged under the menu for ex.)
                blankTask = document.querySelector(".divBlankTaskFix")
                if (blankTask != null) {    //little check because the mouseup event is launched on each HTML element of the task (approximately 5 times)
                    moveDraggedTaskToBlankTaskChosen(task, document.querySelector(".divBlankTaskFix"))
                }

                //events "mousemove", "scroll" and "mouseup" are deleted because the task has been released
                document.removeEventListener('mousemove', onMouseMove);
                document.removeEventListener('scroll', onMouseMove);
                task.onmouseup = null
            });

            $(".divTask").on("dragstart", function () { //disable default dragstart event (by default the browser makes a transparent clone of the draggable element)
                return false;
            });

            // centers the element at (pageX, pageY) coordinates (the cursor will be in the middle of the element)
            function moveHTMLElementAt(element, pageX, pageY) {
                logIt("move at " + pageX + ":" + pageY)
                logIt(pageX - element.offsetWidth / 2 + 'px')
                element.style.left = pageX - element.offsetWidth / 2 + 'px';    //position = mouse X position - half width of the element
                element.style.top = pageY - element.offsetHeight / 2 + 'px';
            }

            //Check if the task (his top right corner) is above a workstate and manage blankTask in this workstate
            function checkIsOverAWorkState(event) {
                logIt(event)
                //Search if a workstate is under the task
                realWorkState = document.elementFromPoint(event.clientX + 61, event.clientY - 61)  //corner at top right of the task to find the element behind
                if (realWorkState !== null) {   //if right corner of the task is not outside of the window
                    realWorkState = getRealParentHavingId(realWorkState, "workstate")
                }
                //If a workstate is found:
                if (realWorkState != null) {
                    manageBlankTaskToWorkColumn(realWorkState, false)   //remove all .divBlankTask
                    manageBlankTaskToWorkColumn(realWorkState, true)    //add a .divBlankTask in this workstate
                }
            }
        }
    })
}

//manage blank task for work column (give the workstate html element, boolean value to add or not, and if you wants to remove both blank task types
function manageBlankTaskToWorkColumn(workstate, add, removeBothBlankTaskTypes = false) {
    if (add == true) {
        if (workstate.querySelector(".divBlankTaskFix") === null) { //only if the workstate in the same that where the task is previous fixed position
            //Create a normal blank task in this workstate
            blankTask = document.createElement("div")
            blankTask.classList.add("divBlankTask")
            blankTask.classList.add("borderformodifiabletask")
            workstate.appendChild(blankTask)
        }
    } else {
        $(".divBlankTask").remove() //remove normal blank tasks (no workstate specified because all blank task must disappear)
        if (removeBothBlankTaskTypes == true) {    //remove both types
            $(".divBlankTaskFix").remove()
        }
    }
}

/* 3 functions to update the task state */
function tryUpdateTaskState(workid, taskid, newState) {
    updateTaskState(workid, taskid, newState)
}

function updateTaskState(workid, taskid, newState) {
    //TODO: the ajax request
}

function updateTaskStateCallback(response) {
    //TODO: manage the response
}

function closeRightPanel() {
    managedivRightPanel(false)
}

//After the DOM has been loaded:
$(document).ready(function () {
    if (queryActionIncludes("kanban")) { //init only if page is kanban
        declareEventsForTasks()

        $("#btnCreateTask").on("click", tryCreateTask)  //try to create the task
        $("#btnCancelCreate").on("click", closeRightPanel)  //close right panel when the user want to cancel task creation

        //Extract value from url:
        url = window.location.toString()
        opt = url.substr(url.indexOf("opt=") + 4, 1)
        hash = window.location.hash.toString()

        //if url is correctly build (hash not empty. action=kanban, hash start with #t- or #w- and and if opt is not), then display right panel with the right form (in opt)
        if (hash != "" && url.indexOf("action=kanban") != -1 && (hash.startsWith("#t-") || hash.startsWith("#w-")) && url.indexOf("opt=0") == -1) {
            switch (opt) {
                case "1":   //opt 1 = idFormToDisplay => divTaskDetails
                    task = document.getElementById("Task-" + hash.substr(hash.indexOf("#t-") + 3, hash.length)) //get the element ("Task-"+ task.id) with its id in the hash
                    logIt(task)
                    if (task != null) {    //if task found with the id in the hash
                        displayTaskDetails(task)
                        manageActiveTasks(task)
                    } else {
                        managedivRightPanel(false)     //close details because there is no task to display
                        manageActiveTasks(null)
                        window.location.hash = ""   //remove the bad hash with the unknown id
                    }
                    break;
                case "2":   //opt 1 = idFormToDisplay => divTaskCreate
                    work = document.getElementById("Work-" + hash.substr(hash.indexOf("#w-") + 3)) //get the element ("Work-"+ task.id) with its id in the hash
                    logIt(work)
                    if (work != null) {    //if work found with the id in the hash
                        loadTaskCreateForm(work.getAttribute("data-id"))
                    } else {
                        managedivRightPanel(false)     //close details because there is no work to display
                        window.location.hash = ""   //remove the bad hash with the unknown id
                    }
                    break;
            }

        } else {
            managedivRightPanel(false)
        }

        //.onclickCloseDetails object can close divRightPanel on click event
        $(".onclickCloseDetails").on("click", function (event) {
            managedivRightPanel(false)
            manageActiveTasks(null)     //unactive all tasks
        })


        //On keyup on #inputnamecreate the task name is loaded
        $("#inputnamecreate").on("keyup", function (event) {
            loadTaskNameForCreate()
        })
        loadTaskNameForCreate()
        $("#inputnamecreate").on("keydown", createTaskIfEnterKey)
        $("#typecreate").on("keydown", createTaskIfEnterKey)
        $("#workcreate").on("keydown", createTaskIfEnterKey)
    }
})

//create the task if the key enter is pressed
function createTaskIfEnterKey(event) {
    if (event.key.toLowerCase() == "enter" && inputnamecreate.value != "") {    //if enter key is pressed and value is not null
        tryCreateTask() //try to create the task like (same as if button "save" was clicked)
    }
}

//load task name from #inputnamecreate to spannamecreate
function loadTaskNameForCreate() {
    spannamecreate.innerText = inputnamecreate.value
}

//Declare click event for btnSeeMoreOrLessTasks to change the text and start function manageVisibilityTasks()
function declareSeeMoreOrLessButtonsEvents() {
    $(".btnSeeMoreOrLessTasks").on("click", function (event) {
        btn = event.target
        manageVisibilityTasks(btn, (btn.innerText === "Voir plus"))    //display or hide the end part of tasks depending on the current text on the button
        invertInnerText(btn, "Voir plus", "Voir moins")
    })
}

//Manage visibility of tasks after the 6th task (display is boolean value to say display or hide)
function manageVisibilityTasks(btn, display) {
    parentwork = btn.parentNode.parentNode  //get the divWorkState div that is the parent of each tasks done
    var tasksOfTheWork = parentwork.getElementsByClassName("divTask");  //get all the tasks in this work and right column
    nbtasks = 0 //initialize tasks counter
    Array.prototype.forEach.call(tasksOfTheWork, function (task) {
        nbtasks++
        if (display === true) {
            task.hidden = false;
        } else {
            if (nbtasks > 6) {
                task.hidden = true
            }
        }
    })
}

function displayTaskDetails(task) {
    if (task != null) {
        task = getRealParentHavingId(task)
        if (task != null) {
            this.task = task
            id = task.getAttribute("data-id")
            window.location.hash = "t-" + id
            changeOptInUrl(1)   //change opt in the url
            testa = new XMLHttpRequest()
            testa.onreadystatechange = function () {
                if (testa.readyState == XMLHttpRequest.DONE && testa.status == 200) {
                    response = JSON.parse(testa.responseText)
                    loadTaskDetailsWithData(response, task.getAttribute("data-canedit"))   //load data in the divRightPanel
                    managedivRightPanel(true, 1)  //display when ajax call is finished and data has been loaded
                    checkTextFieldToCheck()
                    manageActiveTasks(null)     //unactive all tasks
                    manageActiveTasks(task)     //active the clicked task
                }
            }
            testa.open("GET", "?action=getTask&id=" + id)
            testa.send()
        } else {
            window.location.hash = ""
        }
    }
}

//load the divRightPanel form with the array of data task
function loadTaskDetailsWithData(response, canEditTask) {
    task = response.data.task
    logIt(task)

    //Fill basic fields:
    number.innerText = task.number
    inputname.value = task.name
    spanname.innerText = task.name
    description.value = task.description
    type.options.selectedIndex = task.type
    urgency.value = task.urgency
    link.value = task.link
    state.innerText = task.statename
    workname.value = task.work.name

    //Deadline management
    if (task.deadline != null) {
        deadline.value = task.deadline.substr(0, task.deadline.indexOf(" "))    //remove H:i:s part
    } else {
        deadline.value = "" //set null
    }
    //TODO: add H:m support

    //Responsible management if exists
    if (task.responsible != null) {
        responsible.value = buildFullNameWithUser(task.responsible)
        initials.innerText = task.responsible.initials
    } else {
        responsible.value = ""
        initials.innerText = "?"
    }

    //Display the creator in small text
    if (task.hasOwnProperty("creator")) {
        creator.innerText = "Tâche créé par " + buildFullNameWithUser(task.creator)
    } else {
        creator.innerText = ""
    }

    //Completion date if exists and if task is done
    if (task.completion_date != null && task.state == 3) {
        spancompletion.innerText = "le " + task.completion
    } else {
        spancompletion.innerText = ""
    }
    if (canEditTask == 'true') {    //if the user can edit the task
        //Enable all fields of the form
        subElements = divTaskDetails.getElementsByTagName("*")
        Array.prototype.forEach.call(subElements, function (el) {
            if (el.tagName == "INPUT" || el.tagName == "TEXTAREA" || el.tagName == "SELECT") {
                if (el.hasAttribute("readonly") == false) { //disable only if the input is not readonly (because readonly inputs must always be disabled).
                    el.disabled = false
                }
            }
        })
        document.querySelector("#divTaskDetails .panelRightStandardBottomLine").removeAttribute("hidden")   //show the panelRightStandardBottomLine
    } else {
        //Disable all fields of the form
        subElements = divTaskDetails.getElementsByTagName("*")
        Array.prototype.forEach.call(subElements, function (el) {
            if (el.tagName == "INPUT" || el.tagName == "TEXTAREA" || el.tagName == "SELECT") {
                if (el.hasAttribute("readonly") == false) { //disable only if the input is not readonly (because readonly inputs must always be disabled). So we just live "" instead of replacing by "true".
                    el.disabled = true
                }
            }
        })
        document.querySelector("#divTaskDetails .panelRightStandardBottomLine").setAttribute("hidden", "true")  //hide the panelRightStandardBottomLine
    }
}

//build the fullname string with firstname and lastname of a user
function buildFullNameWithUser(user) {
    fullname = ""
    if (user.hasOwnProperty("firstname") && user.hasOwnProperty("lastname")) {
        fullname = user.firstname + " " + user.lastname
    }
    return fullname
}

//Manage (display or hide) active task(s). If null all tasks will be unactived, else the task element will be active (with adding .activeTask css class)
function manageActiveTasks(taskToActive) {
    logIt("hide all tasks")
    if (taskToActive == null) {
        var els = document.getElementsByClassName("divTask");
        Array.prototype.forEach.call(els, function (onetask) {
            onetask.classList.remove("activeTask")
        })
    } else {
        taskToActive.classList.add("activeTask")
    }
}

/* 3 functions to manage creation of task in JS and Ajax */
function tryCreateTask() {
    //ALl asked value (name, type and work) are required
    if (inputnamecreate.value != "" && typecreate.value != "" && workcreate.value != "") {
        createTask()
    } else {    //data missing (local message)
        displayResponseMsg("Données manquantes. Création de la tâche impossible.", false)
    }
}

function createTask() {
    data = getArrayFromAFormFieldsWithName("divTaskCreate")
    sendRequest("POST", "?action=createTask", createTaskCallback, data)
}

function createTaskCallback(response) {
    manageResponseStatus(response)
    //TODO: include condition to check status before and display error message
    if (response.data != null) {
        newtask = response.data.task
        htmlTask = document.importNode(createElementFromHTML(document.querySelector("#templateTask").innerHTML), true)  //copy html content from the template

        //Fill fields that divTask need:
        htmlTask.querySelector(".number").innerHTML = newtask.number
        htmlTask.querySelector(".name").innerHTML = newtask.name
        htmlTask.id = "Task-" + newtask.id
        htmlTask.setAttribute("data-id", newtask.id)
        theTaskPlusBtnAside = document.getElementById("Work-" + newtask.work.id).querySelector(".leftcolumn .divTaskPlusButton")

        //Add the html just before the plus button
        theTaskPlusBtnAside.insertAdjacentElement('beforebegin', htmlTask);

        declareEventsForTasks() //redeclare event for tasks (for new tasks)

        //Manage right panel:
        if (chkSerialCreation.checked) {    //if serial mode enabled
            inputnamecreate.value = ""  //empty the name
            typecreate.options.selectedIndex = 0    //set the first option by default (index 0 is not equal to value 0 !)
            loadTaskCreateForm()    //reload task create form to focus on input name
        } else {    //display divTaskDetails with details of task
            managedivRightPanel(true, 1)    //display details form
            loadTaskDetailsWithData(response, "true")   //load data for details | canEdit is true because else the user could not create the task
            manageActiveTasks(document.getElementById("Task-" + newtask.id))    //active new task created
        }
    }
}

/* 3 functions to manage update of task in JS and Ajax */
function tryUpdateTask() {
    if (checkAllValuesAreNotEmpty([inputname.value, urgency.value, type.value])) {
        updateTask()
    }
}

function updateTask() {
    data = getArrayFromAFormFieldsWithName("divTaskDetails")
    //data.id = task.id
    data.id = 1
    sendRequest("POST", "?action=updateTask", updateTaskCallback, data)
}

function updateTaskCallback(response) {
    isSuccess = manageResponseStatus(response)
    loadTaskDetailsWithData(response, "true")
}

/* 3 functions to manage deletion of task in JS and Ajax */
function tryDeleteTask(event) {
    opt = event.target
    event.stopPropagation()
    opt = getRealParentHavingId(opt)
    logIt(opt)
    deleteTask(opt.getAttribute("data-id"))
}

function deleteTask(id) {
    data = {id: id}
    sendRequest("POST", "?action=deleteTask", deleteTaskCallback, data)
}

function deleteTaskCallback(response) {
    isSuccess = manageResponseStatus(response)
    if (isSuccess) {
        id = response.data.reference.id
        document.getElementById("Task-" + id).remove()
        managedivRightPanel(false)
        //TODO: close right panel only if task deleted is displayed
        manageActiveTasks(null)
    }
}

/* 2 functions to change the responsible of a task in JS and Ajax */

//TODO: complete the 2 followings functions
function changeResponsible(event) {
    event.stopPropagation()
    icon = event.target
    taskHTML = getRealParentHavingId(icon, "Task-")

    data = {}
    data.id = taskHTML.getAttribute("data-id")
    if (icon.classList.contains("addresponsible")) {    //if icon is "add responsible"
        data.responsible_id = userloggedid.innerText   //insert id of the user logged
    } else {    //else the icon is "remove responsible"
        data.responsible_id = ""
    }
    sendRequest("POST", "?action=updateTask", changeResponsibleCallback, data)
}

function changeResponsibleCallback(response) {
    isSuccess = manageResponseStatus(response)
    if (isSuccess) {
        //Extract needed information and html elements
        taskData = response.data.task
        taskHTML = document.getElementById("Task-" + taskData.id)
        logIt(taskHTML)
        divTaskResponsibleZone = taskHTML.querySelector(".divTaskResponsibleZone")  //zone displayed or hidden
        spanWithTooltip = taskHTML.querySelector(".responsible")    //span of the tooltip

        //Set responsible values in the tooltip in the kanban
        if (taskData.responsible != null) { //a responsible must be displayed
            spanWithTooltip.setAttribute("data-original-title", buildFullNameWithUser(taskData.responsible) + " (" + taskData.responsible.username + ")")  //set the tooltip text with the fullname and username
            spanWithTooltip.innerHTML = taskData.responsible.initials   //set innertext of the tooltip with the initials
            divTaskResponsibleZone.classList.remove("visibilityhidden") //display it

        } else {  //responsible will be hidden (default value is applied, in case of other errors showing it)
            spanWithTooltip.setAttribute("data-original-title", "Undefined user")
            spanWithTooltip.innerHTML = "000"
            divTaskResponsibleZone.classList.add("visibilityhidden")    //hide it
        }
        invertResponsibleIconsAddOrRemove(taskHTML) //invert the 2 icons
        if (taskHTML.classList.contains("activeTask")) {    //load the task in details only if the task is active (else the user is updating another task)
            loadTaskDetailsWithData(response, "true")   //reload the task details with the new information (to change the responsible in the task details if displayed)
        }
    }
}

function invertResponsibleIconsAddOrRemove(taskHTML) {
    invertHiddenState(taskHTML.querySelector(".iconresponsible.removeresponsible"))
    invertHiddenState(taskHTML.querySelector(".iconresponsible.addresponsible"))
}

/* 2 functions to change the responsible of a task in JS and Ajax */

//TODO: complete the 3 followings functions
function tryChangeState(taskid, newState, workId) {
    //build data for body request
    data = {
        "id": taskid,
        "state": newState,
        "work": workId
    }
    changeState(data)
}

function changeState(data) {   //change state and/or work of a task
    sendRequest("POST", "?action=updateTask", changeStateCallback, data)
}

function changeStateCallback(response) {
    isSuccess = manageResponseStatus(response)

    //In all cases, move the task to the right position (depending on response.data.task to be correct with data at server-side).
    taskData = response.data.task
    taskHTML = document.getElementById("Task-" + taskData.id)
    if (taskHTML.classList.contains("activeTask")) {    //load the task in details only if the task is active (else the user is updating another task)
        loadTaskDetailsWithData(response, "true")   //reload the task details with the new information (to change the responsible in the task details if displayed)
    }
    moveTaskHTMLToCorrectPlaceInTheKanban(taskHTML, response.data.task)
}

function moveTaskHTMLToCorrectPlaceInTheKanban(taskHTML, taskData) {
    if (taskData != undefined) {
        workStateParent = document.getElementById("workstate-" + taskData.work_id + "-" + taskData.state)   //get the workstate parent of the task (their id respect this structure: workstate-<workid>-<state>)
        workStateParent.appendChild(taskHTML)   //the taskHTML will be transfered from his current place to the workStateParent (so no need to delete old element)
    }
}

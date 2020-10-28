/**
 *  Project: KanFF
 *  File: tasks.js for pages about tasks
 *  Author: Samuel Roland
 *  Creation date: 15.10.2020
 */
function declareEventsForTasks() {
    //bottom line of divTask have to be hidden if divTask is not on hover and displayed if on hover
    declareChangeHiddenStateOnOneChildOnParentHover("divTask", "mouseover", "divTaskBottomLine", false)
    declareChangeHiddenStateOnOneChildOnParentHover("divTask", "mouseout", "divTaskBottomLine", true)
    declareSeeMoreOrLessButtonsEvents()

    //On click on .divTask display the task details
    $(".divTask").on("click", function (event) {
        displayTaskDetails(event.target)
    })

}

//After the DOM has been loaded:
$(document).ready(function () {
    declareEventsForTasks()

    btnSave.addEventListener("click", tryCreateTask)

    //Extract value from url:
    url = window.location.toString()
    opt = url.substr(url.indexOf("opt=") + 4, 1)
    hash = window.location.hash.toString()

    //if url is correctly build (hash not empty. action=kanban, hash start with #t- or #w- and and if opt is not), then display right panel with the right form (in opt)
    if (hash != "" && url.indexOf("action=kanban") != -1 && (hash.startsWith("#t-") || hash.startsWith("#w-")) && url.indexOf("opt=0") == -1) {
        switch (opt) {
            case "1":   //opt 1 = idFormToDisplay => divTaskDetails
                task = document.getElementById("Task-" + hash.substr(hash.indexOf("#t-") + 3, hash.length)) //get the element ("Task-"+ task.id) with its id in the hash
                log(task)
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
                log(work)
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
})

//load task name from #inputnamecreat to spannamecreate
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
                loadTaskDetailsWithData(response)   //load data in the divRightPanel
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

//load the divRightPanel form with the array of data task
function loadTaskDetailsWithData(response) {
    task = response.data.task
    number.innerText = task.number
    log(task)
    inputname.value = task.name
    spanname.innerText = task.name
    description.value = task.description
    type.options.selectedIndex = task.type
    urgency.value = task.urgency
    if (task.deadline != null) {
        deadline.value = task.deadline.substr(0, task.deadline.indexOf(" "))    //remove H:i:s part
    }

    //Responsible and creator fullnames if set
    if (task.hasOwnProperty("responsible")) {
        responsible.value = buildFullNameWithUser(task.responsible)
        initials.innerText = task.responsible.initials
    } else {
        responsible.value = ""
        initials.innerText = "?"
    }

    if (task.hasOwnProperty("creator")) {
        creator.innerText = "Tâche créé par " + buildFullNameWithUser(task.creator)
    } else {
        creator.innerText = ""
    }

    link.value = task.link
    state.innerText = task.statename
    workname.value = task.work.name

    //Completion date if exists and if task is done
    if (task.completion_date != null && task.state == 3) {
        spancompletion.innerText = "le " + task.completion
    } else {
        spancompletion.innerText = ""
    }
}

//Just log text in the console
function log(text) {
    console.log(text)
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
    log("hide all tasks")
    if (taskToActive == null) {
        var els = document.getElementsByClassName("divTask");
        Array.prototype.forEach.call(els, function (onetask) {
            onetask.classList.remove("activeTask")
        })
    } else {
        taskToActive.classList.add("activeTask")
    }
}

function createTask() {
    data = getArrayFromAFormFieldsWithName("divTaskCreate")
    sendRequest("POST", "?action=createTask", createTaskWhenCreated, data)

}

function tryCreateTask() {
    //TODO: check data in the form, display error message, receive ajax response, manage form, manage serial mode behavior and task DOM creation
    createTask()
}

function createTaskWhenCreated(response) {
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

        //Manage window displaying
        declareEventsForTasks() //redeclare event for tasks (for new tasks)
        managedivRightPanel(true, 1)    //display details
        loadTaskDetailsWithData(response)   //load data for details
        manageActiveTasks(document.getElementById("Task-" + newtask.id))    //active new task created
    }
}

//Source: Thanks to https://stackoverflow.com/questions/494143/creating-a-new-dom-element-from-an-html-string-using-built-in-dom-methods-or-pro
function createElementFromHTML(htmlString) {
    var div = document.createElement('div');
    div.innerHTML = htmlString.trim();

    // Change this to div.childNodes to support multiple top-level nodes
    return div.firstChild;
}
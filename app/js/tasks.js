/**
 *  Project: KanFF
 *  File: tasks.js for pages about tasks
 *  Author: Samuel Roland
 *  Creation date: 15.10.2020
 */

//After the DOM has been loaded:
$(document).ready(function () {
    //bottom line of divTask have to be hidden if divTask is not on hover and displayed if on hover
    declareChangeHiddenStateOnOneChildOnParentHover("divTask", "mouseover", "divTaskBottomLine", false)
    declareChangeHiddenStateOnOneChildOnParentHover("divTask", "mouseout", "divTaskBottomLine", true)
    declareSeeMoreOrLessButtonsEvents()
    onClickDisplayDetails()

    //.onclickCloseDetails object can close divDetails on click event
    $(".onclickCloseDetails").on("click", function (event) {
        manageDivDetails(false)
        manageActiveTasks(null)     //unactive all tasks
    })
})

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

//Events click on tasks will display the details and get the complete informations with an Ajax call
function onClickDisplayDetails() {
    $(".divTask").on("click", function (event) {
        task = getRealParentHavingId(event.target)
        id = task.getAttribute("data-id")
        testa = new XMLHttpRequest()
        testa.onreadystatechange = function () {
            if (testa.readyState == XMLHttpRequest.DONE && testa.status == 200) {
                response = JSON.parse(testa.responseText)
                loadTaskDetailsWithData(response)   //load data in the divDetails
                manageDivDetails(true)  //display when ajax call is finished and data has been loaded
                manageActiveTasks(null)     //unactive all tasks
                manageActiveTasks(task)     //active the clicked task
            }
        }
        testa.open("GET", "?action=getTask&id=" + id)
        testa.send()
    })
}

//load the divDetails form with the array of data task
function loadTaskDetailsWithData(task) {
    number.innerText = task.number
    log(task)
    inputname.value = task.name
    spanname.innerText = task.name
    description.innerText = task.description
    type.options.selectedIndex = task.type
    urgency.value = task.urgency
    deadline.value = task.deadline.substr(0, task.deadline.indexOf(" "))    //remove H:i:s part

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
        spancompletion.innerText = "Terminé le " + task.completion
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
    if (taskToActive == null) {
        var els = document.getElementsByClassName("divTask");
        Array.prototype.forEach.call(els, function (onetask) {
            onetask.classList.remove("activeTask")
        })
    } else {
        taskToActive.classList.add("activeTask")
    }
}
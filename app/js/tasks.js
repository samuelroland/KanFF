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
})

//Declare click event for btnSeeMoreOrLessTasks to change the text and start function manageVisibilityTasks()
function declareSeeMoreOrLessButtonsEvents() {
    $(".btnSeeMoreOrLessTasks").on("click", function (event) {
        btn = event.target
        if (btn.innerText === "Voir plus") {
            btn.innerText = "Voir moins"
            manageVisibilityTasks(btn, true)    //display the end part of tasks
        } else {
            btn.innerText = "Voir plus"
            manageVisibilityTasks(btn, false)   //hide the end part of tasks
        }
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
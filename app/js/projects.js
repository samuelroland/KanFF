/**
 *  Project: KanFF
 *  File: projects.js for pages about projects
 *  Author: Samuel Roland
 *  Creation date: 08.09.2020
 */
//After the DOM has been loaded:
$(document).ready(function () {
    //Declare events:
    $(".oneLog").on("click", function (sender) {
        parent.setAttribute("data-open", changeState(parent.getAttribute("data-open")))
        logLoadVisibility(sender.target.id)
    })

    //Declare on event click hidden management for 2 triangles depending on if log is opened or not
    declareChangeHiddenStateOnOneElementOnHoverOnConditionWithAttribute("oneLog", "click", "triangletop", "data-open", "true", false)
    declareChangeHiddenStateOnOneElementOnHoverOnConditionWithAttribute("oneLog", "click", "trianglebottom", "data-open", "true", true)

    //Declare on event mouseover hidden management for 2 triangles depending on if log is opened or not
    declareChangeHiddenStateOnOneElementOnHoverOnConditionWithAttribute("oneLog", "mouseover", "triangletop", "data-open", "true", false)
    declareChangeHiddenStateOnOneElementOnHoverOnConditionWithAttribute("oneLog", "mouseover", "trianglebottom", "data-open", "true", true)

    //One mouse out hide the 2 triangles in all cases
    declareChangeHiddenStateOnOneElementOnHover("oneLog", "mouseout", "trianglebottom", true)
    declareChangeHiddenStateOnOneElementOnHover("oneLog", "mouseout", "triangletop", true)
})

//Declare events on a parent, to manage hidden state of a child of this parent
function declareChangeHiddenStateOnOneElementOnHoverOnConditionWithAttribute(parentclassname, eventname, childname, attributename, valueofattribute, hiddenAtThisEventAndCondition) {
    $("." + parentclassname).on(eventname, function (sender) {
        parent = sender.target
        while (parent.id == "" || parent.id == null) {
            parent = parent.parentNode
        }
        child = parent.querySelector("." + childname);
        if (parent.getAttribute(attributename) == valueofattribute) {
            child.hidden = hiddenAtThisEventAndCondition
        } else {
            child.hidden = !hiddenAtThisEventAndCondition
        }
    })
}


function changeState(state) {
    if (state == "false") {
        return true
    } else {
        return false
    }
}

function logLoadVisibility(idParent) {
    //parent = document.getElementById(idParent)
    shortDesc = parent.querySelector(".shortdescription")
    longDesc = parent.querySelector(".longdescription")
    if (shortDesc.hidden === false) {
        shortDesc.hidden = true
        longDesc.hidden = false
    } else {
        shortDesc.hidden = false
        longDesc.hidden = true
    }
}
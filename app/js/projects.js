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
        //On click, invert the state of data-open attribute and invert the description visible
        parent.setAttribute("data-open", getInvertState(parent.getAttribute("data-open")))
        logLoadVisibility(sender.target.id)
    })

    //Declare on event click hidden management for 2 triangles depending on if log is opened or not
    declareChangeHiddenStateOnOneChildOnParentHover("oneLog", "click", "triangletop", false, "data-open", "true")
    declareChangeHiddenStateOnOneChildOnParentHover("oneLog", "click", "trianglebottom", true, "data-open", "true")

    //Declare on event mouseover hidden management for 2 triangles depending on if log is opened or not
    declareChangeHiddenStateOnOneChildOnParentHover("oneLog", "mouseover", "triangletop", false, "data-open", "true")
    declareChangeHiddenStateOnOneChildOnParentHover("oneLog", "mouseover", "trianglebottom", true, "data-open", "true")

    //One mouse out hide the 2 triangles in all cases
    declareChangeHiddenStateOnOneChildOnParentHover("oneLog", "mouseout", "trianglebottom", true)
    declareChangeHiddenStateOnOneChildOnParentHover("oneLog", "mouseout", "triangletop", true)
})

//Declare eventlistener on a parent, to manage hidden state of a child of this parent, with a condition on an attribute or not
function declareChangeHiddenStateOnOneChildOnParentHover(parentclassname, eventname, childname, hiddenvalue, attributename = null, valueofattribute = null) {
    $("." + parentclassname).on(eventname, function (event) {
        parent = event.target
        while (parent.id == "" || parent.id == null) {  //get the real parent (event can be produced on childrens and not on the parent directly. The parent must have an id.
            parent = parent.parentNode
        }
        child = parent.querySelector("." + childname);  //select the only child inside this parent with its class name
        if (attributename != null) {   //if attribute name is not null, then the use of the condition is asked
            if (parent.getAttribute(attributename) == valueofattribute) {
                child.hidden = hiddenvalue
            } else {
                child.hidden = !hiddenvalue
            }
        } else {  //no condition, so apply value in all cases
            child.hidden = hiddenvalue;
        }
    })
}

//Get the invert state of a pseudo boolean value (!value doesn't work with attribute)
function getInvertState(state) {
    if (state == "false") {
        return true
    } else {
        return false
    }
}

//Invert the visibility of the 2 descriptions (one short and one long) of a log. One is hidden and one is displayed.
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
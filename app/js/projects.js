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
        parent = getRealParentHavingId(sender.target)

        //On click, invert the state of data-open attribute and invert the description visible
        parent.setAttribute("data-open", getInvertState(parent.getAttribute("data-open")))
        invertHiddenState(parent, "shortdescription")
        invertHiddenState(parent, "longdescription")
    })

    $(".btnSeeMoreOrLessWorks").on("click", function (event) {
        parent = getRealParentHavingId(event.target)
        if (event.target.innerText === "Afficher contenu") {    //if the user want to display content
            window.location.hash = "#" + parent.id  //go to work anchor
        }
        invertHiddenState(parent, "divWorkContent")
        invertInnerText(event.target, "Afficher contenu", "Masquer contenu")
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
        parent = getRealParentHavingId(event.target)
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

//Get the invert state of a pseudo boolean value (!value doesn't work with attribute) from an data-* attribute
function getInvertState(state) {
    if (state == "false") {
        return true
    } else {
        return false
    }
}

//Invert hidden state of a child element
function invertHiddenState(parent, classNameOfChild) {
    obj = parent.querySelector("." + classNameOfChild)
    obj.hidden = !obj.hidden
}

//Invert the inner text of an element (if one is set, set the other one)
function invertInnerText(obj, firsttext, secondtext) {
    if (obj.innerText === firsttext) {
        obj.innerText = secondtext;
    } else {
        obj.innerText = firsttext
    }
}

//Get the real parent (event can be produced on childrens and not on the parent directly. The parent is the first parentNode that have an id.)
function getRealParentHavingId(parent) {
    while (parent.id == "" || parent.id == null) {
        parent = parent.parentNode
    }
    return parent
}
/**
 *  Project: KanFF
 *  File: tasks.js for pages about tasks
 *  Author: Samuel Roland
 *  Creation date: 15.10.2020
 */

//Declare events on a parent, to manage hidden state of a child of this parent
function declareChangeHiddenStateOnOneElementOnHover(parentclassname, eventname, childname, hiddenatthisevent) {
    $("." + parentclassname).on(eventname, function (sender) {
        parent = sender.target
        while (parent.id == "" || parent.id == null) {
            parent = parent.parentNode
        }
        child = parent.querySelector("." + childname);
        child.hidden = hiddenatthisevent;
    })
}

//After the DOM has been loaded:
$(document).ready(function () {
    declareChangeHiddenStateOnOneElementOnHover("divTask", "mouseover", "divTaskBottomLine", false)
    declareChangeHiddenStateOnOneElementOnHover("divTask", "mouseout", "divTaskBottomLine", true)
})

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
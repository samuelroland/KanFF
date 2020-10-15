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
})
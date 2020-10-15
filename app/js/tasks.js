/**
 *  Project: KanFF
 *  File: tasks.js for pages about tasks
 *  Author: Samuel Roland
 *  Creation date: 15.10.2020
 */
//After the DOM has been loaded:
$(document).ready(function () {
    $(".divTask").on("mouseover", function (sender) {
        parent = sender.target
        while (parent.id == "" || parent.id == null) {
            parent = parent.parentNode
        }
        bottomLine = parent.querySelector(".divTaskBottomLine");
        bottomLine.hidden = false;
    })
    $(".divTask").on("mouseout", function (sender) {
        parent = sender.target
        while (parent.id == "" || parent.id == null) {
            parent = parent.parentNode
        }
        bottomLine = parent.querySelector(".divTaskBottomLine");
        bottomLine.hidden = true;
    })
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
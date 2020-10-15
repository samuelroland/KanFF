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
        parent = sender.target
        while (parent.id == "" || parent.id == null) {
            parent = parent.parentNode
        }
        console.log(parent.getAttribute("data-open"))
        console.log(!(parent.getAttribute("data-open")))
        console.log(parent)
        parent.setAttribute("data-open", changeState(parent.getAttribute("data-open")))
        if (parent.getAttribute("data-open") == "true") {
            //alert("hey")
            triangletop.hidden = false
            trianglebottom.hidden = true
        } else {
            //alert("hey2")
            triangletop.hidden = true
            trianglebottom.hidden = false
        }
        logLoadVisibility(sender.target.id)
    })
    $(".oneLog").on("mouseover", function (sender) {
        parent = sender.target
        while (parent.id == "" || parent.id == null) {
            parent = parent.parentNode
        }

        trianglebottom = parent.querySelector(".trianglebottom")
        triangletop = parent.querySelector(".triangletop")
        if (parent.getAttribute("data-open") == "true") {
            //alert("hey4")
            triangletop.hidden = false
            trianglebottom.hidden = true
        } else {
            //alert("hey3")
            triangletop.hidden = true
            trianglebottom.hidden = false
        }
    })
    $(".oneLog").on("mouseout", function (sender) {
        parent = sender.target
        while (parent.id == "" || parent.id == null) {
            parent = parent.parentNode
        }

        //Hide all triangles:
        trianglebottom = parent.querySelector(".trianglebottom")
        triangletop = parent.querySelector(".triangletop")
        trianglebottom.hidden = true
        triangletop.hidden = true
    })
})

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
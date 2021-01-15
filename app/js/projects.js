/**
 *  Project: KanFF
 *  File: projects.js for pages about projects
 *  Author: Samuel Roland
 *  Creation date: 08.09.2020
 */
//After the DOM has been loaded:
$(document).ready(function () {
    if (queryActionIncludes("createAProject")) {
        minDate = $("#end").attr("min", start.value);

        $("#start").on("change", function (sender) {
            $("#end").attr("min", sender.target.value) // Minimum value of end is greater of start
            if (start.value > end.value && end.value !== "") {
                console.log(end.value)
                end.value = start.value
            }
        })
    }
    //Declare events:
    $(".oneLog").on("click", function (sender) {
        parent = getRealParentHavingId(sender.target)

        //On click, invert the state of data-open attribute and invert the description visible
        parent.setAttribute("data-open", getInvertState(parent.getAttribute("data-open")))
        invertHiddenStateOnChild(parent, "shortdescription")
        invertHiddenStateOnChild(parent, "longdescription")
    })

    $(".btnSeeMoreOrLessWorks").on("click", function (event) {
        parent = getRealParentHavingId(event.target)
        //TODO: scroll to an ideal work position
        invertHiddenStateOnChild(parent, "divWorkContent")
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

    $(".divTaskPlusButton").on("click", function (sender) {
        parent = getRealParentHavingId(sender.target)   //get the plus button div (parent of the icon)
        loadTaskCreateForm(parent.getAttribute("data-work"))    //load the form with the id in the attribute data-work in the div button
    })

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
function invertHiddenStateOnChild(parent, classNameOfChild) {
    obj = parent.querySelector("." + classNameOfChild)
    obj.hidden = !obj.hidden
}

//Invert hidden state of an element (overload function)
function invertHiddenState(obj) {
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
function getRealParentHavingId(parent, mustContains = "") {
    if (parent == null) {
        return null
    }
    if (mustContains == "") {
        //while the parent with an id and while the parent is not the body tag (if is body no parent have been found)
        while ((parent.id == "" || parent.id == null) && parent.toString() != "[object HTMLDocument]") {
            parent = parent.parentNode
        }
        return parent
    } else {
        //while the parent with an id that contains the given string and while the parent is not the body tag (if is body no parent have been found)
        while ((parent.id == "" || parent.id == null || parent.id.indexOf(mustContains) == -1) && parent.toString() != "[object HTMLDocument]") {
            parent = parent.parentNode
        }
        return parent
    }
}

//Get the real parent (event can be produced on childrens and not on the parent directly. The parent is the first parentNode that have an id.)
function getRealParentHavingGivenAttribute(parent, attribute, mustContains = "") {
    if (parent == null) {
        return null
    }
    if (mustContains == "") {
        //while the parent with an id and while the parent is not the body tag (if is body no parent have been found)
        while (parent.getAttribute(attribute) == null && parent.toString() != "[object HTMLDocument]") {
            parent = parent.parentNode
        }
        return parent
    } else {
        //while the parent with an id that contains the given string and while the parent is not the body tag (if is body no parent have been found)
        while ((parent.getAttribute(attribute) == null || parent.getAttribute(attribute).indexOf(mustContains) == -1) && parent.toString() != "[object HTMLDocument]") {
            parent = parent.parentNode
        }
        return parent
    }
}

//Manage (display or hide) divRightPanel
function managedivRightPanel(display, idFormToDisplay = 1) {
    switch (idFormToDisplay) {
        case 1:
            formToDisplay = "divTaskDetails"
            break;
        case 2:
            formToDisplay = "divTaskCreate"
            break;
        case 3:
            formToDisplay = "divWorkDetails"
            break;
    }

    //hide or display the wanted child (task details, work details or create a task):
    $("#divRightPanel").children().hide()    //hide all
    $("#" + formToDisplay.toString()).show()    //show the form to display

    inputnamecreate.value = ""  //clear name input
    loadTaskNameForCreate() //load task name in divTaskCreate

    divRightPanel.hidden = !display
    if (display) {
        window.history.replaceState({}, "", window.location.toString().replace("opt=0", "opt=" + idFormToDisplay));  //change opt to 1 (details open) in the url without refresh page
        divKanban.classList.remove("withoutdetails")
    } else {
        window.history.replaceState({}, "", window.location.toString().replace("opt=" + 1, "opt=0"));  //change opt to 0 (details closed) in the url without refresh page
        window.history.replaceState({}, "", window.location.toString().replace("opt=" + 2, "opt=0"));  //change opt to 0 (details closed) in the url without refresh page
        divKanban.classList.add("withoutdetails")
        window.location.hash = "" //clear other the id in the hash
        manageActiveTasks(null) //unactive all tasks
    }
}

//load task creation form
function loadTaskCreateForm(idwork = null) {
    managedivRightPanel(true, 2)    //open right panel and display divTaskCreate
    manageActiveTasks(null)

    changeOptInUrl(2)   //change opt in url
    inputnamecreate.focus() //focus on the name field to be ready to start typing
    //TODO: scroll to an ideal work position where the task is at top of the divKanban but not hidden.
    if (idwork != null) {   //select the given work only if given
        $("#workcreate").val(idwork)  //select the good option on #work with the attribute value of option markup
    }
}

//change var opt in the querystring without refresh page
function changeOptInUrl(newOpt = 0) {
    //replace all possibles opt with default value (0)
    window.history.replaceState({}, "", window.location.toString().replace("opt=" + 1, "opt=0"));
    window.history.replaceState({}, "", window.location.toString().replace("opt=" + 2, "opt=0"));

    //Set the wanted opt
    window.history.replaceState({}, "", window.location.toString().replace("opt=0", "opt=" + newOpt));
}
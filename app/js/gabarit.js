/**
 *  Project: KanFF
 *  File: gabarit.js javascript file for gabarit code. is present on every page.
 *  Author: Samuel Roland
 *  Creation date: 13.11.2020
 */
//========= Counter management =========

//Declare event keyup for start reload counter
//TODO: refactor the entire file
$(document).ready(function () {
    $(".textFieldToCheck").on("keyup", function () { //on event keyup on a input with class .textFieldToCheck
        checkTextFieldToCheck()
    })
    //Init tooltip in the page:
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    //#btnCancelFeedback on click delete text and close dropup
    if (document.getElementById("btnCancelFeedback") != null) {
        document.getElementById("btnCancelFeedback").addEventListener("click", function () {
            txtFeedback.value = ""
        })
    }

    $(".passToCheckWithPattern").on("change", function (event) { //on event keyup on a input with class .textFieldToCheck
        checkTextsPatternMatches()
        check2ValuesAreIdentical()
        formCheckNoErrorMessages(event.target)
    })

    $(".secondValueIdenticalToCheck").on("change", function (event) { //on event keyup on a input with class .textFieldToCheck
        check2ValuesAreIdentical()
        formCheckNoErrorMessages(event.target)
    })
    $(".formCheckNoErrorMessages button[type=submit]").onclick = function (event) {
        //event.preventDefault()
        formCheckNoErrorMessages(event.target)
    }
    $(".formCheckNoErrorMessages input").onchange = function () {
        formCheckNoErrorMessages(document.querySelector(".formCheckNoErrorMessages"))
    }


    //#btnSendFeedback on click check form and send if verified
    if (document.getElementById("btnSendFeedback") != null) {
        document.getElementById("btnSendFeedback").addEventListener("click", sendFeedback)
    }
    $("#txtFeedbackInfos").on("click", function () { //when click on infos, display or hide detailed informations
        invertHiddenState(divFeedbackInfos)
    })
    $("#spanFeedbackEmail").on("click", function () { //when click on response span, display or hide the email input
        invertHiddenState(divFeedbackEmail)
    })
    $("#chkFeedbackEmail").on("click", function () { //when click on checkbox for response, display or hide the email input
        divFeedbackEmail.hidden = chkFeedbackEmail.checked
    })
})

//send feedback from the gabarit:
function sendFeedback() {
    if (txtFeedback.value != "" && txtFeedbackSubject.value != "") {
        data = getArrayFromAFormFieldsWithName("frmFeedback")
        if (chkFeedbackEmail.checked == false) {    //if there email will not be sent
            data['email'] = null    //set null (but don't remove the field)
        }

        if (chkFeedbackEmail.checked == true && txtFeedbackEmail.value != "" && isEmailFormat(txtFeedbackEmail.value) || chkFeedbackEmail.checked == false) {    //send only if is checked and email is not empty, or is not checked
            sendRequest("POST", "?action=sendFeedback", sendFeedbackCallback, data)
        } else {
            displayResponseMsg("Envoi impossible. Email invalide.", false)
        }
    } else {
        displayResponseMsg("Envoi impossible. Sujet et contenu requis.", false)
    }
}

//manage the response of the feedback sent
function sendFeedbackCallback(response) {
    manageResponseStatus(response)
    inpSub = document.querySelector("input[name='subject']")
    inpContent = document.querySelector("textarea[name='content']")

    if (response.status == "success") {
        inpSub.value = ""
        inpContent.value = ""
    }
}

//When the page is loaded, start the check for remove bad text counter initialisation (called 0/50 instead of 0/100 for example)
document.addEventListener('DOMContentLoaded', function () {
    checkTextFieldToCheck()
})


//All elements with class "clickable" that have a "data-href" attribute to know the link that have to be opened.
document.addEventListener('DOMContentLoaded', function () {
    var els = document.getElementsByClassName("clickable");
    Array.prototype.forEach.call(els, function (el) {
        el.addEventListener('click', function (evt) {
            console.log(evt.target)
            if (evt.target.getAttribute('data-href') == null) {
                if (evt.target.parentNode.getAttribute('data-href') != null) {
                    window.location = evt.target.parentNode.getAttribute('data-href')
                }
            } else {
                window.location = evt.target.getAttribute('data-href')
            }
        })
    })

    var els2 = document.getElementsByClassName("linkToCopy");
    Array.prototype.forEach.call(els2, function (el) {
        el.addEventListener('click', function (evt) {
            link = evt.target
            if (link.tagName == "IMG") {
                link = link.parentNode
            }
            href = link.getAttribute('data-hrefcopy')
            if (href != null) {
                navigator.clipboard.writeText(href)
                displayResponseMsg("Lien de la section copié dans le presse papiers.")
            }
        })
    })
    $(".linkOfTOC").on("click", adjustAutoScrollWithHashIn30Ms) //all links in TOC must have adjustment of scroll after
    adjustAutoScrollWithHashIn30Ms()
})

//Start adjustAutoScrollWithHash() in 30ms
function adjustAutoScrollWithHashIn30Ms() {
    setTimeout(adjustAutoScrollWithHash, 30)    //30ms is important for asynchronous
}

//Adjust auto scroll with anchor (scroll in top direction to display the title under the menu)
function adjustAutoScrollWithHash() {
    //Thanks to: https://stackoverflow.com/questions/4086107/fixed-page-header-overlaps-in-page-anchors#answer-28824157
    if (window.location.hash != "" && queryActionIncludes("manual")) {
        var offset = $(':target').offset();
        var scrollto = offset.top - 90; // minus fixed header height
        $('html, body').animate({scrollTop: scrollto}, 0);
    }
}

//Declare event keyup at start. Remove space in real time for inputs with the class .removeSpaceInRT
$(document).ready(function () {
    $(".removeSpaceInRT").on("keyup", function (txt) {
        inp = txt.target
        while (inp.value.search(" ") != -1) {   //while there are spaces in the string, remove them
            inp.value = inp.value.replace(" ", "")
        }
    })
})

//Declare event keyup at start. Trim values when user quit inputs with the class .trimItOnChange
$(document).ready(function () {
    $(".trimItOnChange").on("change", function (txt) {
        inp = txt.target
        inp.value = inp.value.trim()
    })
})

//Reload the counter, for input text and textarea with class .textFieldToCheck and a associated counter
function checkTextFieldToCheck() {
    els = document.getElementsByClassName("textFieldToCheck");
    Array.prototype.forEach.call(els, function (txt) {
        thefield = txt   //get the field as object
        nblength = thefield.value.length    //get the length of the string inserted

//Get the <p> counter associated with the field. rebuild the name of p with pCounter then the name of thefield with an upper case at start of the string
        idOfP = "pCounter" + thefield.name.substr(0, 1).toUpperCase() + thefield.name.substr(1).toLowerCase()
        p = document.getElementById(idOfP)

        p.innerText = nblength + "/" + thefield.maxLength   //Change the content of the counter with the new length
        if (thefield.maxLength - nblength < thefield.maxLength / 5) {   //if the difference is lower than the fifth of the maxlength:
            if (thefield.classList.contains("counterVisibleOnlyIfFastMaxLength")) {
                p.hidden = false;
            }
            p.classList.add("redCounter")   //put the counter in red
        } else {
            p.classList.remove("redCounter")    //remove the red of the counter
            if (thefield.classList.contains("counterVisibleOnlyIfFastMaxLength")) {
                p.hidden = true;
            }
        }
    })
}

//Check that pattern of text (regex) matches their value, if not display the error message (id is in data-msg-id):
function checkTextsPatternMatches() {
    els = document.getElementsByClassName("passToCheckWithPattern");
    Array.prototype.forEach.call(els, function (inp) {
        pError = document.getElementById(inp.getAttribute("data-msg-id"))
        pError.hidden = testRegex(inp.pattern, inp.value)
    })
}

//Check that 2 values of are valid
function check2ValuesAreIdentical() {
    els = document.getElementsByClassName("secondValueIdenticalToCheck");   //the second values identical to check
    Array.prototype.forEach.call(els, function (secondElement) {
        firstElement = document.getElementById(secondElement.getAttribute("data-firstvalue"))

        firstValue = getValueOrInnerText(firstElement)
        secondValue = getValueOrInnerText(secondElement)

        logIt(secondElement.getAttribute("data-dontdisplayifempty"))
        pError = document.getElementById(secondElement.getAttribute("data-msg-id"))
        if (secondValue == "" && secondElement.getAttribute("data-dontdisplayifempty") == "true") {
            pError.hidden = true    //if empty and must not display if empty, set as hidden
        } else {
            pError.hidden = (firstValue === secondValue)
        }
    })
}

//TODO: comment and refactor this function
function formCheckNoErrorMessages(clickedElement) {
    parentform = getRealParentHavingId(clickedElement)
    btn = parentform.querySelector("button[type=submit]")
    var allMessagesAreHidden = true
    var els = parentform.querySelectorAll("p.errormsg")
    Array.prototype.forEach.call(els, function (el) {
        if (el.hidden == false) {
            btn.disabled = true
            allMessagesAreHidden = false
        }
    })
    logIt(allMessagesAreHidden)
    if (allMessagesAreHidden == true) {
        btn.disabled = false
    }
}

//Get value of an element (if input or textarea it contains a value, if not it contains an innerText)
function getValueOrInnerText(obj) {
    if (obj.tagName == "INPUT" || obj.tagName == "TEXTAREA") {
        value = obj.value
    } else {
        value = obj.innerText
    }

    return value
}
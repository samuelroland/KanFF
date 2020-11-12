/**
 *  Project: KanFF
 *  File: global.js javascript global file. is present on every page.
 *  Author: Team
 *  Creation date: 26.04.2020
 */

//========= Counter management =========

//Declare event keyup for start reload counter


$(document).ready(function () {
    $(".textFieldToCheck").on("keyup", function (txt) { //on event keyup on a input with class .textFieldToCheck
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

    //#btnSendFeedback on click check form and send if verified
    if (document.getElementById("btnSendFeedback") != null) {
        document.getElementById("btnSendFeedback").addEventListener("click", function (sender) {
            if (txtFeedback.value != "") {
                //TODO: send the ajax query
                data = getArrayFromAFormFieldsWithName("frmFeedback")
                if (chkFeedbackEmail.checked == false) {    //if there email will not be sent
                    data['email'] = null    //set null (but don't remove the field)
                }

                if (chkFeedbackEmail.checked == true && txtFeedbackEmail.value != "" && isEmailFormat(txtFeedbackEmail.value) || chkFeedbackEmail.checked == false) {    //send only if is checked and email is not empty, or is not checked
                    sendRequest("POST", "?action=sendFeedback", manageResponseOfSendFeedback, data)
                }
            }
        })
    }
    $("#txtFeedbackInfos").on("click", function () { //when click on infos, display or hide detailed informations
        invertHiddenState(divFeedbackInfos)
    })
    $("#spanFeedbackEmail").on("click", function () { //when click on infos, display or hide the email input
        invertHiddenState(divFeedbackEmail)
    })
})

//manage the response of the feedback sent
function manageResponseOfSendFeedback(response) {
    manageResponseStatus(response)
    inpSub = document.querySelector("input[name='subject']")
    inpContent = document.querySelector("textarea[name='content']")

    if (response.status == "success") {
        inpSub.value = ""
        inpContent.value = ""
    }
}

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
})

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

//Get an array with key corresponding to name fields and with value, of a form (sending with Ajax
function getArrayFromAFormFieldsWithName(formname) {
    frm = document.getElementById(formname)
    subelements = frm.getElementsByTagName("*")
    finalArray = []
    Array.prototype.forEach.call(subelements, function (el) {
        if (el.name != undefined && el.name != "") {
            if (el.value != null) {
                finalArray[removeNumbersInString(el.name)] = el.value
            }
        }
    })
    return finalArray
}

//Remove all numbers in a string
function removeNumbersInString(text) {
    for (i = 0; i < 10; i++) {
        text = text.replaceAll(i, "")
    }
    return text
}

//Send a HTTP request (with an Ajax call):
function sendRequest(verb, url, callback, data) {
    reqHttp = new XMLHttpRequest()  //Create XHR Object

    //Start function on change of readyState
    reqHttp.onreadystatechange = function () {
        if (reqHttp.readyState == XMLHttpRequest.DONE && reqHttp.status == 200) {   //if request is done and is success (HTTP status, not response status)
            callback(JSON.parse(reqHttp.responseText))  //launch the callback function with response text received
        }
    }
    reqHttp.open(verb, url)   //open the request with a verb (GET, POST, ...) and an URL
    reqHttp.setRequestHeader("Content-Type", "application/json")   //set header content type as json data

    if (data != null) { //if body is the request is not null
        if (Array.isArray(data)) {  //if it's an array
            formatedData = JSON.stringify(Object.assign({}, data))  //stringify in JSON the Array converted in Object
        } else {
            formatedData = JSON.stringify(data) //stringify in JSON the Object
        }
        reqHttp.send(formatedData)  //send the query with formated data
    } else {
        reqHttp.send()  //send the query without any body
    }
}

//display a temporary message on topright
function displayResponseMsg(val, checkmark = true, color = "black") {
    //Take the message depending if started directly as a callback of an Ajax call (response sent in parameter), or started by an other function (message sent in parameter)
    if (val.hasOwnProperty("data")) {
        msg = val.data.message
    } else {
        msg = val
    }
    logIt(val)
    htmlMsg = document.importNode(createElementFromHTML(document.querySelector("#templateMsg").innerHTML), true)  //copy html content from the template

    //Fill text:
    htmlMsg.querySelector(".msgText").innerHTML = msg
    htmlMsg.querySelector(".msgText").style.color = color
    if (checkmark === false) {
        checkMark = htmlMsg.querySelector(".checkmark")
        redCross = htmlMsg.querySelector(".redcross")

        checkMark.hidden = true
        redCross.hidden = false
    }


    setTimeout(function () {
        divTempMessages.firstChild.classList.replace("visible", "hidden")
        setTimeout(function () {
            divTempMessages.firstChild.remove()
        }, 1500)
    }, 3000)   //remove the first child of the list of temp messages in 4.5 seconds. At this time the first message will be the current htmlMsg (because precedent msg will removed just before).

    //display the message
    htmlMsg.classList.add("hidden")
    divTempMessages.appendChild(htmlMsg)
    htmlMsg.classList.replace("hidden", "visible")
}

function checkAllValuesAreNotEmpty(values) {
    Array.prototype.forEach.call(values, function (val) {
        if (val == null || val == undefined) {
            return false
        }
    })
    return true
}

//manage the response status
function manageResponseStatus(response) {
    status = response.status
    switch (status) {
        case "success":
            if (response.data.hasOwnProperty("message")) {  //if contain a message (a success message) display it
                displayResponseMsg(response.data.message)
            }
            isSuccess = true
            break;
        case "fail":
            if (response.data.hasOwnProperty("error")) {    //failed queries must contain error index
                displayResponseMsg("Erreur " + response.data.code + ": " + response.data.error, false)
            } else {
                displayResponseMsg("Erreur indéfinie")
            }
            isSuccess = false
            break
        case "error":   //TODO with specs
            if (response.hasOwnProperty("message")) {
                displayResponseMsg(response.message, false, "red")
            }
            isSuccess = false
            break;
        default:
            displayResponseMsg("Unknown status '" + response.status + "' of the response")
    }
    return isSuccess
}

//is the needle included in the action in the querystring ?
function queryActionIncludes(needle) {
    if (needle == "") {    //the needle can't be empty
        return false
    }
    querystring = window.location.search    //get the querystring
    action = querystring.split("&")[0]  //get the first parameter in the querystring (that must be in all cases the action=x
    action = action.toLowerCase()   //set to lowercase because updateTask and tasks contain the work "task" but the
    return (action.includes(needle))
}

//Source: Thanks to https://stackoverflow.com/questions/494143/creating-a-new-dom-element-from-an-html-string-using-built-in-dom-methods-or-pro
function createElementFromHTML(htmlString) {
    var div = document.createElement('div');
    div.innerHTML = htmlString.trim();

    // Change this to div.childNodes to support multiple top-level nodes
    return div.firstChild;
}

//Just log text in the console
function logIt(text) {
    console.log(text)
}

//test if string is a valid email
function isEmailFormat(testemail) {
    result = testRegex("^[A-z0-9._%+-]+@[A-z0-9.-]+\\.[A-z]{2,}$", testemail)   //test the
    logIt("isEmailFormat: " + result)
    return result
}

//test a regex with a string
function testRegex(regex, string) {
    patt = new RegExp(regex)
    return patt.test(string)
}
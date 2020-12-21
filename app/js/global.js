/**
 *  Project: KanFF
 *  File: global.js javascript global file. is present on every page.
 *  Author: Team
 *  Creation date: 26.04.2020
 */

//TODO: precise and enhance funcitons names

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
            response = reqHttp.responseText
            if (response.substr(0, 1) != "{" || response.substr(response.length - 1, 1) != "}") { //if the response doesn't start or end with JSON data, this means that debug data are displayed above and/or under
                posStartOfJSON = response.lastIndexOf("\\end/{") + 5    //search the position of the JSON data
                lengthForJSON = response.lastIndexOf("}") - posStartOfJSON + 1  //search the end of the JSON data to calculate the length
                response = response.substr(posStartOfJSON, lengthForJSON)   //extract the JSON data
                logIt("Extracted response: \n" + response)
            }
            if (isJson(response)) { //check that extracted text is JSON
                callback(JSON.parse(response))  //launch the callback function with response in parameter
            } else {
                displayResponseMsg("Erreur interne: le serveur n'a pas répondu...") //JSON data is missing or displaydebug() result has been "broken"
            }
        }
    }
    reqHttp.open(verb, url)   //open the request with a verb (GET, POST, ...) and an URL
    reqHttp.setRequestHeader("Content-Type", "application/json")   //set header content type as json data
    reqHttp.setRequestHeader("X-Ajax", "true")   //set an information in the header to say that the request is an Ajax call

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
    result = true   //default value
    Array.prototype.forEach.call(values, function (val) {
        if (val === null || val === undefined || val === "") {
            result = false
        }
    })
    logIt("checkAllValuesAreNotEmpty:" + result)
    return result;
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
function queryActionIncludes(needle, notInAction = false) {
    if (needle == "") {    //the needle can't be empty
        return false
    }
    querystring = window.location.search    //get the querystring
    action = querystring.split("&")[0]  //get the first parameter in the querystring (that must be in all cases the action=x
    action = action.toLowerCase()   //set to lowercase because updateTask and tasks contain the work "task" but the
    if (notInAction == false) {
        return (action.includes(needle.toLowerCase()))
    } else {
        return (window.location.search.indexOf(needle) !== -1)
    }
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

//Thanks to: https://stackoverflow.com/questions/9804777/how-to-test-if-a-string-is-json-or-not#answer-9804835
function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

//display tr ".tr-emptytable" if the table is empty
function displayTrEmptyTableMsgIfTableIsEmpty(tableid) {
    tbl = document.getElementById(tableid)
    nbElement = tbl.children[1].children.length - 1     //-1 because .tr-emptytable is counted
    if (nbElement == 0) {   //if table is empty, display msg
        trEmptyTableMsg = tbl.querySelector(".tr-emptytable")
        trEmptyTableMsg.hidden = false
    }
}


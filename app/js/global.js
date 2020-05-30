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
            p.classList.add("redCounter")   //put the counter in red
        } else {
            p.classList.remove("redCounter")    //remove the red of the counter
        }
    })
}

//When the page is loaded, start the check for remove bad text counter initialisation (called 0/50 instead of 0/100 for example)
document.addEventListener('DOMContentLoaded', function () {
    checkTextFieldToCheck()
})


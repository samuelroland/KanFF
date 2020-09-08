/**
 *  Project: KanFF
 *  File: users.js for pages about users
 *  Author: Samuel Roland
 *  Creation date: 08.09.2020
 */

//After the DOM has been loaded:
$(document).ready(function () {
    //Declare events:
    inpFirstname.addEventListener("keyup", validateSigninFields)
    inpLastname.addEventListener("keyup", validateSigninFields)
})

function validateSigninFields() {
    //Prepare variables:
    initials = ""
    //Get firstname and lastname and trim them to remove space during the writing (for initials it necessary).
    firstname = inpFirstname.value.trim()   //trim to remove space during the writing
    lastname = inpLastname.value.trim()

    //Load the initials:
    initials = firstname.substr(0, 1) + lastname.substr(0, 1) + lastname.substr(lastname.length - 1)
    inpInitials.value = initials.toUpperCase()

    //Set the first char to upper for firstname and lastname
    inpFirstname.value = setFirstCharToUpper(inpFirstname.value)
    inpLastname.value = setFirstCharToUpper(inpLastname.value)

}

//Function to set the first char to uppercase of the text send
function setFirstCharToUpper(text) {
    return text.substr(0, 1).toUpperCase() + text.substr(1).toLowerCase()
}
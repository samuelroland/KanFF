/**
 *  Project: KanFF
 *  File: users.js for pages about users
 *  Author: Samuel Roland
 *  Creation date: 08.09.2020
 */

//After the DOM has been loaded:
$(document).ready(function () {
    //Declare events:
    if (queryActionIncludes("signin")) {
        inpFirstname.addEventListener("keyup", validateSigninFields)
        inpLastname.addEventListener("keyup", validateSigninFields)
        inpUsername.addEventListener("change", validateSigninFields)
        inpPassword1.addEventListener("change", validateSigninFields)
        inpPassword2.addEventListener("change", validateSigninFields)
    }
})

function validateSigninFields() {
    error = false   //there is no error by default
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

    //Check that passwords are the same:
    if (inpPassword1.value != "" && inpPassword2.value != "") {
        test = (inpPassword1.value === inpPassword2.value)    //value for hidden is the result of the comparison between password 1 and 2
        pErrorPassword.hidden = test
        if (test == false) {
            error = true
        }
    }

    //Check that password respect security criterions:
    if (inpPassword1.value != "") { //only the first one is checked, so we don't need to wait on the second to display the error message
        test = testRegex("^(?=.*[A-Za-z])(?=.*\\d).{8,}$", inpPassword1.value)  //attention to the \\ before the d!
        pErrorRegexPassword.hidden = test
        if (test == false) {
            error = true
        }
    }

    //Check that username is alphanumeric (include underscore):
    if (inpUsername.value !== "") {
        test = testRegex("^[a-zA-Z0-9_]*$", inpUsername.value)
        pErrorUsername.hidden = test
        if (test == false) {
            error = true
        }
    }

    manageSubmitButton(error)
}

//Function to set the first char to uppercase of the text send
function setFirstCharToUpper(text) {
    return text.substr(0, 1).toUpperCase() + text.substr(1).toLowerCase()
}

function manageSubmitButton(isDisabled) {
    inpSubmit.disabled = isDisabled
}

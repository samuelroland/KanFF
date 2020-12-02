/**
 *  Project: KanFF
 *  File: members.js for pages about members
 *  Author: Samuel Roland
 *  Creation date: 31.10.2020
 */

document.addEventListener("DOMContentLoaded", init)

function init() {
    if (window.location.toString().includes("members")) {
        btnMembersEditMode.addEventListener("click", manageEditMode)
        $(".sltAccountState").on("change", tryChangeAccountState)
    }
    $(".icnChangeStatus").on("click", tryChangeStatus)  //present everywhere because is in the gabarit
}

/* 3 functions to manage change of the user status in JS and Ajax */
function tryChangeStatus() {
    if (pStatus.querySelector("textarea") == null) {    //if input doesn't exist, create it with the current innerText
        input = document.createElement("textarea")
        input.rows = 5
        input.classList.add("fullwidth")
        input.classList.add("font-italic")
        input.maxLength = 200
        input.value = pStatus.innerText
        input.setAttribute("data-modified", "false")    //at start the content is not modified
        input.addEventListener("input", function (event) {  //but if the content change (event "input") set this data-modified to true
            inp = event.target
            inp.setAttribute("data-modified", "true")
        })
        pStatus.innerHTML = ""
        pStatus.appendChild(input)
    } else {    //else recreate the em markup with the content of the input
        textHasChanged = pStatus.querySelector("textarea").getAttribute("data-modified")
        em = document.createElement("em")
        em.innerText = pStatus.querySelector("textarea").value
        pStatus.innerHTML = ""
        pStatus.appendChild(em)
        if (textHasChanged == "true") { //change request only if the status has been modified
            changeStatus(em.innerText)  //send the request
        }
    }

    //Invert hidden state on icon when click on one of them (to create an alternance with the 2 icons checkmark and modifiy)
    invertHiddenStateOnChild(document.getElementById("spChangeStatusIcon"), "checkmark")
    invertHiddenStateOnChild(document.getElementById("spChangeStatusIcon"), "modify")
}

//send the request to change status on the server
function changeStatus(newStatus) {
    sendRequest("POST", "?action=changeStatus", changeStatusCallback, {"status": newStatus})
}

//callbak for changeStatus request
function changeStatusCallback(response) {
    isSuccess = manageResponseStatus(response)
    //In all cases, set the content of displayed status like the status present on the server (updated or not)
    em = document.createElement("em")
    em.innerText = response.data.user.status
    pStatus.innerHTML = ""
    pStatus.appendChild(em)
}

//manage the edit mode (btn #btnMembersEditMode)
function manageEditMode() {
    btnEditMode = btnMembersEditMode
    invertInnerText(btnEditMode, "Mode édition", "Mode lecture seule")  //invert text of the button
    invertHiddenState(inpDivPassword) //display or hide #inpDivPassword (with "?" and password input")

    //change disabled state of .sltAccountState elements (actual disabled state is taken in the first .sltAccountState element
    $(".sltAccountState").attr("disabled", !document.querySelector(".sltAccountState").disabled)
}

/* 3 functions to manage change of the state of a user account in JS and Ajax */

//onchange on a .sltAccountState, try to change account state:
function tryChangeAccountState(event) {
    //Get informations for confirmation text and password check
    slt = event.target
    fullname = getRealParentHavingId(slt).querySelector(".memberfullname").innerText
    newstatetext = slt.options[slt.selectedIndex].innerText
    pwd = inpPassword.value

    if (pwd == "") {  //if there is no password given
        slt.value = slt.getAttribute("data-startstate") //set at the current state
        inpPassword.focus() //focus the password input
        displayResponseMsg("Mot de passe non rempli", false)    //display error msg
    } else {
        //popup a confirmation:
        confirmation = confirm("Confirmez-vous vouloir changer l'état de " + fullname + " à '" + newstatetext + "' ?")
        if (confirmation == true) { //if confirmation has been validated
            changeAccountState(slt) //send the request
        } else {    //if confirmation is "cancel", set the value as origin for the select and display cancellation message
            slt.value = slt.getAttribute("data-startstate")
            displayResponseMsg("Changement d'état annulé.")
        }
    }
}

//send request (ajax call) to change account state
function changeAccountState(slt) {
    iduser = slt.getAttribute("data-user")
    pwd = inpPassword.value

    if (checkAllValuesAreNotEmpty([slt.value, pwd])) {  //last minute check
        sendRequest("POST", "?action=updateAccountState", accountStateCallback, {
            'id': iduser,
            'state': slt.value,
            'password': pwd
        })
    }
}

//manage account state response
function accountStateCallback(response) {
    isSuccess = manageResponseStatus(response)
    //TODO: display success message or reselect the first value:
    if (isSuccess == true) {
        user = response.data.user
        lastSlt = document.querySelector("select[data-user='" + user.id + "']")
        lastSlt.style.backgroundColor = "#d9edff"
        lastSlt.disabled = true
    } else {
        if (response.data.hasOwnProperty("user")) {
            user = response.data.user
            lastSlt = document.querySelector("select[data-user='" + user.id + "']")
            lastSlt.value = user.state
        }
    }

}
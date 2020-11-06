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
        $(".sltAccountState").on("change", changeAccountState)
    }
    $("#icnChangeStatus").on("click", changeStatusDropdown)
}
}

//manage the edit mode (btn #btnMembersEditMode)
function manageEditMode() {
    btnEditMode = btnMembersEditMode
    invertInnerText(btnEditMode, "Mode édition", "Mode lecture seule")  //invert text of the button
    invertHiddenState(inpDivPassword) //display or hide #inpDivPassword (with "?" and password input")

    //change disabled state of .sltAccountState elements (actual disabled state is taken in the first .sltAccountState element
    $(".sltAccountState").attr("disabled", !document.querySelector(".sltAccountState").disabled)
}

//onchange on a .sltAccountState, send request (ajax call) to change account state
function changeAccountState(event) {
    slt = event.target
    iduser = slt.getAttribute("data-user")
    pwd = inpPassword.value

    if (pwd == "") {  //if there is no password given
        slt.value = slt.getAttribute("data-startstate") //set at the current state
        inpPassword.focus() //focus the password input
        displayResponseMsg("Mot de passe non rempli", false)    //display error msg
    } else {    //else the ajax call can be sent
        if (checkAllValuesAreNotEmpty([slt.value, pwd])) {
            sendRequest("POST", "?action=updateAccountState", manageAccountStateResponse, {
                'id': iduser,
                'state': slt.value,
                'password': pwd
            })
        }
    }

}

//manage account state response
function manageAccountStateResponse(response) {
    isSuccess = manageResponseStatus(response)
    //TODO: display success message or reselect the first value:
    if (isSuccess == true) {
        user = response.data.user
        lastSlt = document.querySelector("select[data-user='" + user.id + "']")
        lastSlt.disabled = true
    }
    if (isSuccess == false) {
        if (response.data.hasOwnProperty("user")) {
            user = response.data.user
            lastSlt = document.querySelector("select[data-user='" + user.id + "']")
            lastSlt.value = user.state
        }
    }

}
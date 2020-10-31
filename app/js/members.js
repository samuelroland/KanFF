/**
 *  Project: KanFF
 *  File: members.js for pages about members
 *  Author: Samuel Roland
 *  Creation date: 31.10.2020
 */

document.addEventListener("DOMContentLoaded", init)

function init() {
    btnMembersEditMode.addEventListener("click", manageEditMode)
    $(".sltAccountState").on("change", changeAccountState)
}

//manage the edit mode (btn #btnMembersEditMode)
function manageEditMode() {
    btnEditMode = btnMembersEditMode
    invertInnerText(btnEditMode, "Mode édition", "Mode lecture seule")  //invert text of the button
    invertHiddenState(inpDivPassword) //display or hide #inpDivPassword (with "?" and password input")

    //change disabled state of .sltAccountState elements (actual disabled state is taken in the first .sltAccountState element
    $(".sltAccountState").attr("disabled", !document.querySelector(".sltAccountState").disabled)
}

//Onclick on a .sltAccountState, send request (ajax call) to change account
function changeAccountState(event) {
    slt = event.target
    if (checkAllValuesAreNotEmpty([slt.value])) {
        sendRequest("POST", "?action=updateAccountState", manageAccountStateResponse, [{'state': slt.value}])
    }
}

//manage account state response
function manageAccountStateResponse(response) {
    //TODO: if there is no response, create artificial response with internal error (? not sure, and about internet connexion?)
    manageResponseStatus(response)
    //TODO: display success message or reselect the first value:
    user = response.data.user
    if (response.status == "fail") {
        lastSlt = document.querySelector("select[data-user='" + user.id + "']")
        lastSlt.value = user.state
    }
}
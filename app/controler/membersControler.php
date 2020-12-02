<?php
/**
 *  Project: KanFF
 *  File: groupsControler.php function controler for the groups
 *  Author: Samuel Roland
 *  Creation date: 30.05.2020
 */

require_once "model/groupsModel.php";

//display the page groups
function members($option)
{
    $members = getAllUsersByInscriptionDesc();   //get all users with sorting by inscription date

    foreach ($members as $key => $member) {
        if ($member['state_modifier_id'] != null) {
            $members[$key]['state_modifier'] = $members[$member['state_modifier_id']];
        }
    }

    //Countings and sorting of the users:
    $nbUnapprovedUsers = 0;
    foreach ($members as $member) {
        $state = $member['state'];
        $onbreak = $member['on_break'];
        if ($state == USER_STATE_UNAPPROVED) {
            $nbUnapprovedUsers++;
        }
        switch ($option) {
            case "2":
                //On break members
                if ($onbreak != 1) {
                    unset($members[$member['id']]);
                }
                break;
            case "3":
                //Archived members
                if ($state != USER_STATE_ARCHIVED) {
                    unset($members[$member['id']]);
                }
                break;
            case "4":
                //Admin members
                if ($state != USER_STATE_ADMIN) {
                    unset($members[$member['id']]);
                }
                break;
            case "5":
                //Non approved members
                if ($state != USER_STATE_UNAPPROVED) {
                    unset($members[$member['id']]);
                }
                break;
            case "6":
                //Banned members
                if ($state != USER_STATE_BANNED) {
                    unset($members[$member['id']]);
                }
                break;
            default:    //option 1 by default
                //Active members (approved, admin, no other states and not onbreak):
                if ($state != USER_STATE_ADMIN && $state != USER_STATE_APPROVED) {
                    unset($members[$member['id']]);
                }
                if ($onbreak == 1) {
                    unset($members[$member['id']]);
                }
                //Change $option to default:
                $option = 1;
                break;
        }
    }

    require_once "view/members.php";
}

function memberDetails($id)
{
    $user = getUserById($id);
    require_once "view/member.php";
}

//update the account state of a member
function updateAccountState($data)  //Ajax call
{
    displaydebug($data);

    //if values are not null
    if (isAtLeastEqual("", [$data['state'], $data['password'], $data['id']]) == false) {

        //check that user password is right
        if (checkUserPassword($_SESSION['user']['id'], $data['password'])) {

            $user = getUserById($data['id']);
            $thisChangeOfStateIsPossible = canChangeUserState($user['state'], $data['state']) && (isAtLeastEqual($data['state'], USER_LIST_STATE));

            //is this change of state possible (go from current state to next state is authorized and the state exists)
            if ($thisChangeOfStateIsPossible) {
                updateUser(['state' => $data['state']], $data['id']);   //update only the state on the user

                //success response with fullname and new state
                $response = getApiResponse(API_SUCCESS, ['user' => unsetPasswordsInArrayOn2Dimensions($user), 'message' => "Etat de " . buildFullNameOfUser($user) . " changé en " . convertUserState($data['state'])]);
            } else {    //not authorized
                $dataAPI = getApiDataContentError("Impossible de changer vers cet état-là.", 33);
                $user = getUserById($data['id']);
                $dataAPI['user'] = unsetPasswordsInArrayOn2Dimensions($user);
                $response = getApiResponse(API_FAIL, $dataAPI);
            }
        } else {    //password invalid
            $dataAPI = getApiDataContentError("Mot de passe pour activer le mode édition erroné", 15);
            $user = getUserById($data['id']);
            $dataAPI['user'] = unsetPasswordsInArrayOn2Dimensions($user);
            $response = getApiResponse(API_FAIL, $dataAPI);
        }
    } else {    //missing data
        $dataAPI = getApiDataContentError("Données manquantes", 17);
        $user = getUserById($data['id']);
        if (empty($user) == false) {    //to prevent empty value if id is inexistant, because the user will be empty
            $dataAPI['user'] = unsetPasswordsInArrayOn2Dimensions($user);
        }
        $response = getApiResponse(API_FAIL, $dataAPI);
    }

    echo json_encode($response);
}

//change the status text of the user logged
function changeStatus($data)  //Ajax call
{
    $data['status'] = trimIt($data['status']);  //trim the text

    if (chkLength($data['status'], 200)) {  //maxlength is 200 chars
        updateUser(['status' => $data['status']], $_SESSION['user']['id']); //update the user status
        $msg = "Statut modifié!";   //default response msg is "status modified"
        if ($data['status'] == "") {
            $msg = "Statut vidé.";  //and if status is empty, msg is "status emptied"
        }
        //response is the new user updated and the success message
        $response = getApiResponse(API_SUCCESS, ['user' => unsetPasswordsInArrayOn2Dimensions(getUserById($_SESSION['user']['id'])), 'message' => $msg]);
    } else {
        $dataError = getApiDataContentError("Données invalides.", 33);    //basic invalid data error
        $response = getApiResponse(API_FAIL, array_merge(['user' => $_SESSION['user']], $dataError)); //response contains error and user information (to have the state)
    }
    echo json_encode($response);
}

?>
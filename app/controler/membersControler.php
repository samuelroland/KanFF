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
                //On break members (approved or admin)
                if ($onbreak != 1 || isAtLeastEqual($state, [USER_STATE_ADMIN, USER_STATE_APPROVED]) == false) {
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
                if ($onbreak == 1 || isAtLeastEqual($state, [USER_STATE_ADMIN, USER_STATE_APPROVED]) == false) {
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
    if ($user != false) {
        $groups = getAllGroupsByUser($id);
        $loggedUserGroups = getAllGroupsByUser($_SESSION['user']['id']);
        $contributions['inrun'] = getContributionsByUser($id, true);
        $contributions['old'] = getContributionsByUser($id, false);
        //Seperate each work contributed by project in contributions:
        foreach ($contributions['inrun'] as $key => $contribution) {
            $formatedContributions['inrun'][$contribution['projectid']][] = $contribution;
        }
        foreach ($contributions['old'] as $key => $contribution) {
            $formatedContributions['old'][$contribution['projectid']][] = $contribution;
        }
        require_once "view/member.php";
    } else {
        $subject = "L'utilisateur demandé est introuvable.";
        $message = "L'id: '" . $id . "' n'éxiste pas.
        Veuillez réessayer.";
        errorPage($subject, $message);
    }
}

//update the account state of a member
function updateAccountState($data)  //Ajax call
{
    setHTTPHeaderForAPIResponse();
    displaydebug($data);
    $currentUser = getUserById($data['id']);
    if (checkAdmin()) {
        //if values are not null
        if (isAtLeastEqual("", [$data['state'], $data['anonymous'], $data['password'], $data['id']], true) == false) {

            //check that user password is right
            if (checkUserPassword($_SESSION['user']['id'], $data['password'])) {

                $thisChangeOfStateIsPossible = canChangeUserState($currentUser['state'], $data['state']) && (isAtLeastEqual($data['state'], USER_LIST_STATE));

                //is this change of state possible (go from current state to next state is authorized and the state exists)
                if ($thisChangeOfStateIsPossible) {
                    $thereIsMoreThanMinimumRequired = true; //default value to not block other requests
                    if ($data['state'] != USER_STATE_ADMIN && $currentUser['state'] == USER_STATE_ADMIN) {  //if the admin will be something else than admin
                        $thereIsMoreThanMinimumRequired = (count(getAllUsersAdmins()) > USERS_NB_ADMINS_MIN);
                    }

                    if ($thereIsMoreThanMinimumRequired) {   //if there is more admin than minimum required, the admin logged can continue to remove admins.
                        $dataToUpdate = ['state' => $data['state'], 'state_modification_date' => timeToDT(time())]; //the modification date is required
                        if ($data['anonymous'] == false) {
                            $dataToUpdate['state_modifier_id'] = $_SESSION['user']['id'];
                        } else {
                            $dataToUpdate['state_modifier_id'] = null; //make value null
                        }
                        updateUser($dataToUpdate, $data['id']);   //update only the state on the user

                        $newUser = getUserById($data['id']);
                        $newUser['state_modifier'] = $_SESSION['user']; //the modifier can only be the admin logged
                        $newUser['sentence_modification_state'] = buildSentenceAccountStateLastChange($newUser, false, false);

                        //success response with fullname and new state
                        $msg = interpolateArrayValuesInAString(USER_STATE_SUCCESS, ["fullname" => buildFullNameOfUser($currentUser), "state" => convertUserState($data['state'])]);
                        $response = getApiResponse(API_SUCCESS, ['user' => unsetPasswordsInArrayOn2Dimensions($newUser), 'message' => $msg]);
                    } else {
                        $dataAPI = getApiDataContentError(interpolateArrayValuesInAString(USER_STATE_UPDATE_FAIL_ADMINS_MIN, ["nbadmins" => USERS_NB_ADMINS_MIN, "adminOrAdmins" => " admin" . ((USERS_NB_ADMINS_MIN > 1) ? "s" : "")]));
                        $dataAPI['user'] = unsetPasswordsInArrayOn2Dimensions($currentUser);
                        $response = getApiResponse(API_FAIL, $dataAPI);
                    }
                } else {    //not authorized
                    $dataAPI = getApiDataContentError(USER_STATE_UPDATE_COMBINATION_DENIED);
                    $dataAPI['user'] = unsetPasswordsInArrayOn2Dimensions($currentUser);
                    $response = getApiResponse(API_FAIL, $dataAPI);
                }
            } else {    //password invalid
                $dataAPI = getApiDataContentError(USER_STATE_UPDATE_PWD_EDITION_MODE_FAIL);
                $currentUser = getUserById($data['id']);
                $dataAPI['user'] = unsetPasswordsInArrayOn2Dimensions($currentUser);
                $response = getApiResponse(API_FAIL, $dataAPI);
            }
        } else {    //missing data
            $dataAPI = getApiDataContentError(COMMON_MISSING_DATA_SENT);
            $currentUser = getUserById($data['id']);
            if (empty($currentUser) == false) {    //to prevent empty value if id is inexistant, because the user will be empty
                $dataAPI['user'] = unsetPasswordsInArrayOn2Dimensions($currentUser);
            }
            $response = getApiResponse(API_FAIL, $dataAPI);
        }
    } else {
        $dataAPI = getApiDataContentError(COMMON_ACTION_DENIED_BECAUSE_NOT_ADMIN);
        $dataAPI['user'] = unsetPasswordsInArrayOn2Dimensions($currentUser);
        $response = getApiResponse(API_FAIL, $dataAPI);
    }

    echo json_encode($response);
}

//change the status text of the user logged
function changeStatus($data)  //Ajax call
{
    setHTTPHeaderForAPIResponse();
    $data['status'] = trimIt($data['status']);  //trim the text

    if (checkStringLengthOnly($data['status'], 200)) {  //maxlength is 200 chars
        updateUser(['status' => $data['status']], $_SESSION['user']['id']); //update the user status
        $msg = UPDATESTATUS_SUCCESS;   //default response msg is "status modified"
        if ($data['status'] == "") {
            $msg = UPDATESTATUS_SUCCESS_EMPTIED;  //and if status is empty, msg is "status emptied"
        }
        //response is the new user updated and the success message
        $response = getApiResponse(API_SUCCESS, ['user' => unsetPasswordsInArrayOn2Dimensions(getUserById($_SESSION['user']['id'])), 'message' => $msg]);
    } else {
        $dataError = getApiDataContentError(COMMON_INVALID_DATA_SENT);    //basic invalid data error
        $response = getApiResponse(API_FAIL, array_merge(['user' => $_SESSION['user']], $dataError)); //response contains error and user information (to have the state)
    }
    echo json_encode($response);
}

//delete an unapproved member taken by id
function deleteUnapprovedUser($data)    //Ajax call
{
    setHTTPHeaderForAPIResponse();
    //Take ressources needed for validations:
    $isAdmin = checkAdmin();
    $userToDelete = getUserById($data['id']);   //if id doesn't exist, it will be false
    $passwordVerification = checkUserPassword($_SESSION['user']['id'], $data['password']);

    //Structure of validation (depending on the possible errors):
    if ($isAdmin && $userToDelete != false && $userToDelete['state'] == USER_STATE_UNAPPROVED && $passwordVerification) {    //if user logged is admin and if the member to delete is unapproved and exists, and if password of admin is valid
        deleteUser($data['id']);    //delete the user
        $userToDelete = unsetPasswordsInArrayOn2Dimensions($userToDelete);
        $callback = getUserById($data['id']);
        if ($callback == false) {   //if callback user is empty, the user has been deleted
            $msg = interpolateArrayValuesInAString(DELETEUNAPPROVEDUSER_SUCCESS, ["fullname" => buildFullNameOfUser($userToDelete)]);
            $response = getApiResponse(API_SUCCESS, ['user' => $userToDelete, 'message' => $msg]);
        } else {    //the user hasn't been deleted because of an SQL error (like foreign key doesn't accept deletion of their reference...)
            $msg = DELETEUNAPPROVEDUSER_FAIL;
            $response = getApiResponse(API_ERROR, null, $msg);
        }
    } else { //permission denied
        if ($passwordVerification == false) {   //because of the password
            $dataError = getApiDataContentError(COMMON_CONFIRMATION_PWD_ERROR);    //validation password wrong
        } else {    //because of other reasons
            $dataError = getApiDataContentError(COMMON_ACTION_DENIED);    //permission denied message
        }
        $response = getApiResponse(API_FAIL, $dataError); //response contains error only
    }
    echo json_encode($response);
}

?>
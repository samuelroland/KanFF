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
    $members = getAllUsersByInscriptionDesc();   //get all users without any sorting

    //Countings and sorting of the users:
    $nbUnapprovedUsers = 0;
    foreach ($members as $member) {
        $state = $member['state'];
        if ($state == USER_STATE_UNAPPROVED) {
            $nbUnapprovedUsers++;
        }
        switch ($option) {
            case "2":
                if ($state != USER_STATE_ONBREAK) {
                    unset($members[$member['id']]);
                }
                break;
            case "3":
                if ($state != USER_STATE_ARCHIVED) {
                    unset($members[$member['id']]);
                }
                break;
            case "4":
                if ($state != USER_STATE_ADMIN) {
                    unset($members[$member['id']]);
                }
                break;
            case "5":
                if ($state != USER_STATE_UNAPPROVED) {
                    unset($members[$member['id']]);
                }
                break;
            default:    //option 1 by default
                if ($state != USER_STATE_ADMIN && $state != USER_STATE_APPROVED) {
                    unset($members[$member['id']]);
                }
                //Change $option to default:
                $option = 1;
                break;
        }
    }

    require_once "view/members.php";
}

//display the page create a group or create the group (depends on the data sent)
function createUseasdfr($group)
{
    $dataerror = false; //no error
    if ($group != null) {
        //If the required informations exist and if they are valid:
        if (isset($group['name'], $group['password'], $group['visibility']) && chkLength($group['name'], 50) && $group['visibility'] > 0 && $group['visibility'] < 13) {
            if (isset($group['context'])) {
                if (chkLength($group['context'], 200) == false) {
                    $dataerror = true;
                }
            }
            if (isset($group['description'])) {
                if (chkLength($group['description'], 200) == false) {
                    $dataerror = true;
                }
            }
            $group['restrict_access'] = chkToTinyint($group['restrict_access']);

            //Check password for important action
            if (checkUserPassword($_SESSION['user']['id'], $group['password'])) {

                unset($group['password']);  //unset for not include it in the creation of the group
                $group['status'] = "Créé le " . date("d M y");
                $group['creator_id'] = $_SESSION['user']['id'];
                $group['creation_date'] = timeToDT(time());

                createGroup($group);
                flshmsg(16);    //"group well created" msg
                groups();   //back to groups page
            } else {
                flshmsg(15);    //password error for action
                $dataerror = false; //unset error to protect the flshmsg of password error
                require_once "view/createAGroup.php";
            }
            displaydebug($group);
        } else {
            $dataerror = true;
        }
        if ($dataerror) {
            flshmsg(14);
            require_once "view/createAGroup.php";
        }
        displaydebug($dataerror);
        displaydebug($_SESSION);
    } else {
        require_once "view/createAGroup.php";
    }
}

?>
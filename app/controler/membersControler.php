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

?>
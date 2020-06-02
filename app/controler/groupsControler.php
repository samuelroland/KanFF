<?php
/**
 *  Project: KanFF
 *  File: groupsControler.php function controler for the groups
 *  Author: Samuel Roland
 *  Creation date: 30.05.2020
 */

require_once "model/groupsModel.php";

//display the page groups
function groups()
{
    //getAllGroups();
    require_once "view/groups.php";
}

//display the page create a group or create the group (depends on the data sent)
function createAGroup($group)
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
            }
        } else {
            $dataerror = true;
        }
        if ($dataerror) {
            flshmsg(14);
        }
        displaydebug($dataerror);
        displaydebug($_SESSION);
    } else {
        require_once "view/createAGroup.php";
    }
}

?>
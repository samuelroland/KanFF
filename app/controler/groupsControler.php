<?php
/**
 *  Project: KanFF
 *  File: groupsControler.php function controler for the groups
 *  Author: Samuel Roland
 *  Creation date: 30.05.2020
 */

//display the page groups
function groups()
{
    //getAllGroups();
    require_once "view/groups.php";
}

//display the page groups or create the groupe (depends on the data sent)
function createAGroup($group)
{
    if ($group != null) {
        //If the required informations exist
        if (isset($group['name'], $group['password'], $group['visibility'])) {
            //Check password first:
            if (checkUserPassword($_SESSION['user']['id'], $group['password'])) {
                //Check length of the values:
                if (strlen($group['name']) <= 50 && chkLength($group['context'], 200) && chkLength($group['group'], 200)) {

                }
            }
        }
    } else {
        require_once "view/createAGroup.php";
    }
}

?>
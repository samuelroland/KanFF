<?php
/**
 *  Project: KanFF
 *  File: projectsControler.php controler functions for the tasks
 *  Author: Samuel Roland
 *  Creation date: 22.07.2020
 */

//require_once "model/projectsModel.php";

//display the page groups
function tasks()
{
    /*
    $groups = getAllGroups();
    $fieldsToConvert = ["name", "description", "context", "status"];
    $groups = specialCharsConvertFromAnArray($groups, $fieldsToConvert);
    displaydebug($groups);
    */
    require_once "view/tasks.php";
}

//display the page create a group or create the group (depends on the data sent)
function createATask($group)
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
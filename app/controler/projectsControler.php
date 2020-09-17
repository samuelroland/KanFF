<?php
/**
 *  Project: KanFF
 *  File: projectsControler.php controler functions for the projects
 *  Author: Samuel Roland
 *  Creation date: 22.07.2020
 */

//require_once "model/projectsModel.php";

// Display the page groups
function projects()
{
    /*
    $groups = getAllGroups();
    $fieldsToConvert = ["name", "description", "context", "status"];
    $groups = specialCharsConvertFromAnArray($groups, $fieldsToConvert);
    displaydebug($groups);
    */
    require_once "view/projects.php";
}

// Display the page create a group or create the group (depends on the data sent)
function createAProject($newProject)
{
    if (empty($newProject) != false) {
        $error = false;
        $newProject['name'] = trimIt($newProject['name']);

        if (checkUserPassword($_SESSION['user']['id'], $newProject['password']) == false) {
            $error = 8;
        }
    } else {
        require_once "view/projects.php";
    }
}

?>
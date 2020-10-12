<?php
/**
 *  Project: KanFF
 *  File: projectsControler.php controler functions for the projects
 *  Author: Samuel Roland
 *  Creation date: 22.07.2020
 */

require_once "model/projectsModel.php";

// Display the page groups
function projects($option)
{
    switch ($option) {
        case 1:
            $projects = getAllProjectsVisible($_SESSION['user']['id']);
            $description = "Tous les projets actuels (non-archivés) du collectif qui sont visibles pour vous.";
            break;
        case 2:
            $projects = getAllProjectsContributed($_SESSION['user']['id']);
            $description = "Tous les projets auxquels vous avez contribué dans ce collectif et qui sont visibles pour vous. (Contribué signifie techniquement que vous avez effectué au moins une tâche).";
            break;
        case 3:
            $projects = getAllArchivedProjects($_SESSION['user']['id']);
            $description = "Tous les projets archivés du collectif qui sont visibles pour vous. Ils ont été archivés parce qu'il n'était plus d'actualité (et qu'ils étaient terminés, abandonnés ou annulés).";
            break;
    }

    $groups = indexAnArrayById(getAll("groups"));
    foreach ($projects as $key => $project) {
        $participates = getByCondition("participate", ["id" => $project['id']], "participate.project_id=:id and participate.state in (2, 3) order by participate.state desc", true);
        foreach ($participates as $key2 => $participate) {
            $participates[$key2]['group'] = $groups[$participate['group_id']];
        }
        $projects[$key]['participate'] = $participates;
    }

    //TODO: fix bug with substrText() after specialCharsConvertFromAnArray() ...
    //$fieldsToConvert = ["name", "description", "start", "end", "state", "value", "effort", "visible", "project_id", "creator_id", "creation_date"];
    //$projects = specialCharsConvertFromAnArray($projects, $fieldsToConvert);

    require_once "view/projects.php";
}

// Display the page create a project or create the project (depends on the data sent)
function createAProject($newProject)
{
    $groups = getAllGroups();
    displaydebug($groups);
    if (empty($newProject) == false) {
        $error = false;
        $newProject['name'] = trimIt($newProject['name']);

        if (checkUserPassword($_SESSION['user']['id'], $newProject['password']) == false) {
            $error = 8;
        }

        //Then depending on errors or on success:
        if ($error != false) {
            flshmsg($error);
            require "view/createAProject.php";  //view values sent inserted
        } else {
            createOne("projects", $newProject);
            displaydebug($newProject);
            flshmsg(9);
        }
    } else {
        require_once "view/createAProject.php";
    }
}

function projectDetails($id, $option)
{
    if ($option == null) {
        $option = 2;
    }
    $project = getOneProject($id);
    $users = getAllUsers();
    $logs = getAllLogs($project['id']);
    foreach ($logs as $key => $log) {
        $logs[$key]['user'] = $users[$log['user_id']];
    }
    require_once "view/project.php";
}

function kanban($id){
    $project = getOneProject($id);
    require_once "view/kanban.php";
}
?>
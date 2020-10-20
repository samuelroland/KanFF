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

function kanban($id, $opt)
{
    $isInsideTheProject = isAUserInsideAProject($id, $_SESSION['user']['id']);
    $users = getAllUsers();
    $project = getOneProject($id);
    $works = indexAnArrayById(getAllWorksByProject($id));
    $tasks = getAllTasksByProject($id);
    foreach ($tasks as $task) {
        $task['responsible'] = $users[$task['responsible_id']];
        $works[$task['work_id']]['tasks'][] = $task;
    }

    foreach ($works as $key => $work) {
        $works[$key]['hasWritingRightOnTasks'] = hasWritingRightOnTasksOfAWork($isInsideTheProject, $work);
        if ($isInsideTheProject != true) {  //if is not inside the project, the filter apply, else no filter
            if ($work['visible'] != 1) {    //unset the work is not visible
                unset($works[$key]);
            }
        }
    }
    displaydebug($isInsideTheProject);
    displaydebug($works);

    $project['works'] = $works;
    require_once "view/kanban.php";
}

//return true or false, if the user is inside the project (inside groups that participate to the project)
function isAUserInsideAProject($projectid, $userid)
{
    $result = getGroupsParticipatingToAProjectByMember($projectid, $userid);
    if (count($result) >= 1) {
        return true;
    } else {
        return false;
    }
}

//Return true or false, if the user has writing right on tasks of a work depending on the settings of the work
function hasWritingRightOnTasksOfAWork($isInTheProject, $work)
{
    $open = $work['open'];
    $visible = $work['visible'];

    if ($isInTheProject) {
        return true;
    }
    if ($visible == 1) {
        if ($open == 1) {
            return true;
        }
    }
    return false;
}

//Ajax call to get one task in JSON
function getTask($id)
{
    //TODO: check permissions (if the project is visible) before send the task
    //TODO: return error or empty if task is not found
    $task = getOneTask($id);
    $task['statename'] = convertTaskState($task['state'], true);
    $task['work'] = getOneWork($task['work_id']);
    if ($task['responsible_id'] != null) {
        $task['responsible'] = unsetPasswordsInArrayOn2Dimensions(getUserById($task['responsible_id']));
    }
    if ($task['creator_id'] != null) {
        $task['creator'] = unsetPasswordsInArrayOn2Dimensions(getUserById($task['creator_id']));
    }
    if ($task['completion_date'] != null) {
        $task['completion'] = DTToHumanDate($task['completion_date'], "simpletime");
    }
    echo json_encode($task);
}

?>
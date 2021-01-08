<?php
/**
 *  Project: KanFF
 *  File: projectsControler.php controler functions for the projects
 *  Author: Samuel Roland
 *  Creation date: 22.07.2020
 */

require_once "model/projectsModel.php";
require_once "model/participateModel.php";

// Display the page groups
function projects($option)
{
    $projectsOfLoggedUser = getAllProjectsIdWhereUserIsInside($_SESSION['user']['id']);
    $users = getAllUsers();
    $works = getAllWorks();
    $worksByProject = [];
    foreach ($works as $work) {
        $worksByProject[$work['project_id']][] = $work;
    }

    switch ($option) {
        case 1:
            $projects = getAllProjectsVisible($_SESSION['user']['id']);
            $description = "Tous les projets actuels (non-archivés) du collectif qui sont visibles pour vous.";
            break;
        case 2:
            $projects = getAllProjectsContributed($_SESSION['user']['id']);
            $description = "Tous les projets auxquels vous avez contribué dans ce collectif et qui sont visibles pour vous." . createToolTipWithPoint("Contribué signifie techniquement que vous avez effectué au moins une tâche.", "icon-xsmall m-2");
            break;
        case 3:
            $projects = getAllArchivedProjects($_SESSION['user']['id']);
            $description = "Tous les projets archivés du collectif qui sont visibles pour vous." . createToolTipWithPoint("Ils ont été archivés parce qu'il n'était plus d'actualité. Seuls les projets terminés, abandonnés ou annulés, peuvent être archivés.", "icon-xsmall m-2");
            break;
    }

    $groups = indexAnArrayById(getAll("groups"));
    foreach ($projects as $key => $project) {
        $participates = getByCondition("participate", ["id" => $project['id']], "participate.project_id=:id and participate.state in (2, 3) order by participate.state desc", true);
        foreach ($participates as $key2 => $participate) {
            $participates[$key2]['group'] = $groups[$participate['group_id']];
        }
        $projects[$key]['participate'] = $participates;
        if (is_null($project['responsible_id'])) {
            $projects[$key]['responsible'] = null;
        } else {
            $projects[$key]['responsible'] = $users[$project['responsible_id']];
        }
        //Check all works of the project to find if some works need help (external or internal)
        $needExternalHelp = false;
        $needInternalHelp = false;
        foreach ($worksByProject[$project['id']] as $work) {    //if at least one of the works need help, the need help icon will be displayed
            if ($work['need_help'] == WORK_NEEDHELP_OUTER) {
                $needExternalHelp = true;
            }
            if ($work['need_help'] == WORK_NEEDHELP_INNER) {
                $needInternalHelp = true;
            }
            if ($work['need_help'] == WORK_NEEDHELP_BOTH) {
                $needExternalHelp = true;
                $needInternalHelp = true;
            }
        }
        $projects[$key]['needExternalHelp'] = $needExternalHelp;
        $projects[$key]['needInternalHelp'] = $needInternalHelp;

        $projects[$key]['works'] = $worksByProject[$project['id']];

        $projects[$key]['isUserLoggedInside'] = (in_array($project['id'], $projectsOfLoggedUser));
    }

    //TODO: fix bug with substrText() after specialCharsConvertFromAnArray() ...
    //$fieldsToConvert = ["name", "description", "start", "end", "state", "value", "effort", "visible", "project_id", "creator_id", "creation_date"];
    //$projects = specialCharsConvertFromAnArray($projects, $fieldsToConvert);

    require_once "view/projects.php";
}

// Display the page create a project or create the project (depends on the data sent)
function createAProject($data)
{
    if (empty($data) == false) {
        $error = false;

        //Check length of name, description and goal
        $newProject['name'] = trimIt($data['name']);
        $newProject['description'] = trimIt($data['description']);
        $newProject['goal'] = trimIt($data['goal']);
        displaydebug($newProject);
        //Check length of name, description and goal
        if (areAreAllEqualTo(true, [checkStringLengthNotEmpty($newProject['name'], 70), checkStringLengthNotEmpty($newProject['description'], 1000), checkStringLengthNotEmpty($newProject['goal'], 1000)]) == false) {
            $error = 10;
        }

        //Check that the user is in the given group
        if (isMemberInAGroup($_SESSION['user']['id'], $data['manager_id']) == false) {
            $error = 10;
        } else {
            $newProject['manager_id'] = $data['manager_id'];
        }

        if (checkUserPassword($_SESSION['user']['id'], $data['password']) == false) {
            $error = 8;
        }

        // Default values (not in the form)
        $newProject['archived'] = 0;
        $newProject['logbook_content'] = PROJECTS_DEFAULT_TEXT_LOGBOOK_CONTENT;
        $newProject['responsible_id'] = null;
        $newProject['state'] = PROJECT_LIST_STATE[0];

        //Convert checkbox values to tinyint
        $newProject['visible'] = chkToTinyint($data['visible']);
        $newProject['logbook_visible'] = chkToTinyint($data['logbook_visible']);

        $newProject['importance'] = checkIntMinMax($data['importance'], 1, 5);
        $newProject['urgency'] = checkIntMinMax($data['urgency'], 1, 5);
        if ($newProject['importance'] == false || $newProject['urgency'] == false) {
            $error = 10;
        }

        //Verify start and end date
        $newProject['start'] = timeToDT(strtotime($data['start']));
        if ($newProject['start'] == false) {
            $error = 10;
        }

        $newProject['end'] = null;  //default value
        if ($data['end'] != "") {
            $newProject['end'] = strtotime($data['end']);
            $newProject['end'] = timeToDT($newProject['end']);
            if ($newProject['end'] == false) {
                $error = 10;
            }
            //Check that end date are bigger than start date
            if ($newProject['start'] >= $newProject['end']) {
                $error = 10;
            }
        }

        displaydebug($newProject);
        //Then depending on errors or on success:
        if ($error != false) {
            flshmsg($error);
            $groups = getAllGroupsByUser($_SESSION['user']['id']);
            require "view/createAProject.php";  //view values sent inserted
        } else {
            $insertedId = createOne("projects", $newProject);
            $projectBack = getOneProject($insertedId);
            displaydebug($projectBack);
            if (empty($projectBack) == false) {
                $idInsertedForParticipate = createGroupParticipationToAProject($insertedId, $projectBack['manager_id']);
                if (empty(getOneParticipate($idInsertedForParticipate)) != null) {
                    flshmsg(9);
                } else {
                    flshmsg(45);    //Internal error when participate was created
                }
            } else {
                flshmsg(55);    //Internal error when project was created
            }


            require "view/projects.php";
        }
    } else {
        $groups = getAllGroupsByUser($_SESSION['user']['id']);
        require_once "view/createAProject.php";
    }
}

function createGroupParticipationToAProject($projectid, $managerid)
{
    $participate = [
        "group_id" => $managerid,
        "project_id" => $projectid,
        "start" => timeToDT(time()),
        "end" => null,
        "state" => PARTICIPATE_STATE_CREATOR
    ];
    displaydebug($participate);
    $idResult = createParticipate($participate);
    if ($idResult != null) {
        return $idResult;
    } else {
        return false;
    }
}

function projectDetails($id, $option)
{
    if ($option == null) {
        $option = 2;
    }
    //TODO: check visibility of the project and if isMember
    $project = getOneProject($id);
    $works = getAllWorksByProject($id);
    if (empty($project) == false) {
        $users = getAllUsers();
        $groups = getAllGroupsByProject($id);
        $logs = getAllLogs($project['id']);
        foreach ($logs as $key => $log) {
            $logs[$key]['user'] = $users[$log['user_id']];
        }
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

    $totalEffort = 0;
    $totalValue = 0;
    $providedEffort = 0;
    $generatedValue = 0;
    foreach ($works as $key => $work) {
        $totalEffort += $work['effort'];
        $totalValue += $work['value'];
        if ($work['state'] == WORK_STATE_DONE) {
            $providedEffort += $work['effort'];
            $generatedValue += $work['value'];
        }
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


?>

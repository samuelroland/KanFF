<?php
/**
 *  Project: KanFF
 *  File: tasksControler.php controler functions for the tasks
 *  Author: Samuel Roland
 *  Creation date: 22.07.2020
 */

require_once "model/tasksModel.php";

//display the page Tasks
function tasks()
{
    require_once "view/tasks.php";
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

//Ajax call to create one task
function createATask($data)
{
    $task = [];
    //TODO: check that work is writable and in the good project
    $isInsideTheProject = isAUserInsideAProject($data['project'], $_SESSION['user']['id']);
    $work = getOneWork($data['work']);

    //Check that the work exist and that the user have the permissions to create a task in this work
    $hasPermissionToCreate = false; //default value
    if ($work['project_id'] == $data['project'] && hasWritingRightOnTasksOfAWork($isInsideTheProject, $work) && $work['state'] != WORK_STATE_DONE) {
        $hasPermissionToCreate = true;
    }

    //Check that data sent are valid
    if (chkLength($data['name'], 100) && $data['name'] != "" && isAtLeastEqual($data['type'], TASK_LIST_TYPE) && $hasPermissionToCreate) {
        $task['name'] = $data['name'];
        $task['type'] = $data['type'];
        $task['work_id'] = $data['work'];

        //Then generate other fields:
        $task['number'] = getTasksNextUniqueNumber();
        $task['state'] = TASK_STATE_TODO;
        $task['urgency'] = 0;
        $task['creator_id'] = $_SESSION['user']['id'];

        //Then create the task:
        $id = createTask($task);

        echo json_encode(getOneTask($id));
    } else {
        if ($hasPermissionToCreate == false) {
            //TODO: return error message in JSON: work not found (or "you don't have permissions" ??)
        } else {
            //TODO: return error message in JSON: invalid data
        }
    }
}

?>
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
    setHTTPHeaderForAPIResponse();
    //TODO: check permissions (if the project is visible) before send the task
    //TODO: return error or empty if task is not found
    $task = getOneTask($id);
    $task = createTaskComplementFields($task);
    echo json_encode(getApiResponse(API_SUCCESS, ['task' => $task]));
}

//create complements fields of a task (creator, repsonsible, completion in simpletime, work, state in text)
function createTaskComplementFields($task)
{
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
    return $task;
}

//Ajax call to create one task
function createATask($data)
{
    setHTTPHeaderForAPIResponse();
    displaydebug($data);
    $task = [];
    $hasPermissionToCreate = null; //default value
    if (isset($data['project'], $data['work'])) {
        //TODO: check that work is writable and in the good project
        $isInsideTheProject = isAUserInsideAProject($data['project'], $_SESSION['user']['id']);
        $work = getOneWork($data['work']);

        //Check that the work exist and that the user have the permissions to create a task in this work
        if ($work['project_id'] == $data['project'] && hasWritingRightOnTasksOfAWork($isInsideTheProject, $work) && $work['state'] != WORK_STATE_DONE) {
            $hasPermissionToCreate = true;
        } else {
            $hasPermissionToCreate = false;
        }
    }
    //Check that data sent are valid
    if (checkStringLengthNotEmpty($data['name'], 100) && isAtLeastEqual($data['type'], TASK_LIST_TYPE) && $hasPermissionToCreate) {
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

        $newtask = getOneTask($id);
        $newtask = createTaskComplementFields($newtask);

        $msg = interpolateArrayValuesInAString(CREATEATASK_SUCCESS, ["number" => $task['number']]);
        $t = getApiResponse(API_SUCCESS, ['task' => $newtask, 'message' => $msg]);
        echo json_encode($t);
        die();
    } else {
        if ($hasPermissionToCreate === false) {
            //TODO: return error message in JSON: work not found (or "you don't have permissions" ??)
            $response = getApiResponse(API_FAIL, getApiDataContentError(COMMON_ACTION_DENIED));
        } else {
            //TODO: return error message in JSON: invalid data
            $response = getApiResponse(API_FAIL, getApiDataContentError(COMMON_INVALID_DATA_SENT));
        }

    }
    echo json_encode($response);
}

//Ajax call to update one task
function updateATask($data)
{
    setHTTPHeaderForAPIResponse();
    $error = false;
    displaydebug($data, true, true);
    $task = [];
    $hasPermissionToUpdate = null; //default value
    if (isset($data, $id)) {
        //TODO: check that the user can update the task
        //TODO: get the project_id of the task
        $isInsideTheProject = isAUserInsideAProject(getProjectIdByTask($id), $_SESSION['user']['id']);
        $work = getOneWork($data['work']);

        //Check that the work exist and that the user have the permissions to create a task in this work
        if (hasWritingRightOnTasksOfAWork($isInsideTheProject, $work) && $work['state'] != WORK_STATE_DONE) {
            $hasPermissionToUpdate = true;
        } else {
            $hasPermissionToUpdate = false;
        }
    }
    /**
     * Validation Data
     */
    //Check type of update
    $total = 0;
    for ($i = 0; $i == count($data); $i++) {
        if (isset($data[1])) {
            $total += 1;
        }
    }

    //Check if value needed aren't empty
    if (isAtLeastEqual("", [$data["name"], $data["state"], $data["urgency"]])) {
        $error = true;
    }

    /**Check strings's length*/

    $error = setErrorValueIfNotTrue(!isAtLeastEqual("", $data["description"]) && !checkStringLengthOnly($data['description'], 2000), $error);

    $error = setErrorValueIfNotTrue((!isAtLeastEqual("", $data["link"]) && !checkStringLengthOnly($data['link'], 2000)), $error);

    //Check if
    $error = (!checkStringLengthNotEmpty($data['name'], 100));

    /**En of checking strings's lenght*/


    if (isAtLeastEqual($data['type'], TASK_LIST_TYPE) && $hasPermissionToUpdate && !$error) {

        //use state only if state = true
        if ($data['state']) {
            if (isset($data['state'])) {
                if (is_int($data['state'])) {
                    $task['state'] = $data['state'];
                } else {
                    //TODO: API
                }
            }


        } elseif ($data['responsible_id']) {

            if (is_int($data['responsible_id'])) {
                $task['responsible_id'] = $data['responsible_id'];
            } else {
                //TODO: API
            }

        } else {
            //TODO: update TOUT
            //Check Data
            if (is_int($data['urgency']) && is_int($data['type']) && is_int($data['name'])) {

            }
        }


        //check if below's var are in right type (INT, STRING...)
        $error = setErrorValueIfNotTrue(isAtLeastEqual(false, [is_int($data['urgency']), is_int($data['type']), is_int($data['responsible_id'])]) == false, $error);
        //TODO: mettre les variable de data dans les tasks correspondante
        //Then generate other fields:
        $task['state'] = TASK_STATE_TODO;
        $task['urgency'] = 0;

        //Then create the task:
        updateTasks($data['work_id'], $id);

        $task = getOneTask($id);
        $msg = interpolateArrayValuesInAString(UPDATEATASK_SUCCESS, ["number" => $task['number']]);
        $response = getApiResponse(API_SUCCESS, ['task' => $task, 'message' => $msg]);
        echo json_encode($response);
    } else {
        if ($hasPermissionToUpdate === false) {
            //TODO: return error message in JSON: work not found (or "you don't have permissions" ??)
            $response = getApiResponse(API_FAIL, getApiDataContentError(COMMON_ACTION_DENIED));
        } else {
            //TODO: return error message in JSON: invalid data
            $response = getApiResponse(API_FAIL, getApiDataContentError(COMMON_INVALID_DATA_SENT));
        }
        echo json_encode($response);
    }

    //free space
    $taskIsFound = null;
    $hasPermissionToUpdate = null;
    if (isset($data, $data['id'])) {
        $id = $data['id'];
        $projectid = getProjectIdByTask($id);   //the parent project taken by a task id
        $taskIsFound = ($projectid != null);    //task exist if the parent project is found
        if ($taskIsFound) { //search other information only if the task is found
            $isInsideTheProject = isAUserInsideAProject($projectid, $_SESSION['user']['id']);
            $work = getOneWork($data['work']);

            //Check that the work exist and that the user have the permissions to create a task in this work
            $hasPermissionToUpdate = (hasWritingRightOnTasksOfAWork($isInsideTheProject, $work));
        }
    }
    if ($hasPermissionToUpdate === true && $taskIsFound === true) {
        //Go to the chosen update mode (update responsible, update state, update general)
        if (isset($data['type'])) {

        } else if (isset($data['responsible_id'])) {

        } else {

        }
        echo json_encode($response);
    }

}


//Ajax call to delete a task
function deleteATask($data)
{
    setHTTPHeaderForAPIResponse();
    displaydebug($data);
    $task = getOneTask($data['id']);
    $hasPermissionToDelete = null; //default value
    if (isset($data) && empty($task) == false) {
        $isInsideTheProject = isAUserInsideAProject(getProjectIdByTask($data['id']), $_SESSION['user']['id']);
        $work = getOneWork($task['work_id']);

        //Check that the work exist and that the user have the permissions to create a task in this work
        if (hasWritingRightOnTasksOfAWork($isInsideTheProject, $work) && $work['state'] != WORK_STATE_DONE) {
            $hasPermissionToDelete = true;
        } else {
            $hasPermissionToDelete = false;
        }
    }

    if ($hasPermissionToDelete) {
        deleteTasks($data['id']);
        $response = getApiResponse(API_SUCCESS, ["reference" => ["id" => $data['id']], "message" => interpolateArrayValuesInAString(DELETEATASK_SUCCESS, $task)]);
    } else {
        $response = getApiResponse(API_FAIL, getApiDataContentError(COMMON_ACTION_DENIED));
        //TODO: error about invalid data (and export message to messages.php)
    }
    echo json_encode($response);
}

?>
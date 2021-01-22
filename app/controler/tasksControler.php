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
    $taskIsFound = null;
    $hasPermissionToUpdate = null;
    $msg = null;
    $success = false;   //the query has succeed or not (by default not)
    if (isset($data, $data['id'])) {
        $id = $data['id'];
        $currentTask = getOneTask($data['id']);
        $taskIsFound = ($currentTask != null);    //task exist if the parent project is found

        if ($taskIsFound) { //search other information only if the task is found
            $projectid = getProjectIdByTask($id);   //the parent project taken by a task id
            $isInsideTheProject = isAUserInsideAProject($projectid, $_SESSION['user']['id']);
            $work = getOneWork($currentTask['work_id']);
            $hasPermissionToUpdate = (hasWritingRightOnTasksOfAWork($isInsideTheProject, $work));

            //Check that the work exist and that the user have the permissions to create a task in this work
            if ($hasPermissionToUpdate === true) {
                //Go to the chosen update mode (update responsible, update state, update general)
                if (isset($data['responsible_id'])) {   //update responsible
                    $newResponsible = false;
                    if ($data['responsible_id'] == "") {    //little conversion because "" is not equal to null for MySQL
                        $data['responsible_id'] = null;
                    }
                    if ($data['responsible_id'] != null) {  //execute the sql query only if responsible is not null
                        $newResponsible = getUserById($data['responsible_id']);
                    }
                    if ($newResponsible != false || $data['responsible_id'] == null) {  //the responsible must be a valid user or null
                        $task['responsible_id'] = $data['responsible_id'];
                        $success = true;
                        if ($task['responsible_id'] != null) {
                            $msg = interpolateArrayValuesInAString(UPDATEATASK_RESPONSIBLE_SET_SUCCESS, ["number" => $currentTask['number'], "fullname" => buildFullNameOfUser($newResponsible)]);
                        } else {
                            $msg = interpolateArrayValuesInAString(UPDATEATASK_RESPONSIBLE_REMOVED_SUCCESS, ["number" => $currentTask['number']]);
                        }
                    }
                } else if (isset($data['state'])) { //update state
                    if (in_array($data['state'], TASK_LIST_STATE)) {    //if the new state is valid
                        $task['state'] = $data['state'];    //take the new state value
                        $success = true;

                        if ($data['work'] != $currentTask['work_id'] && $data['work'] != "") {   //update the work_id only if the work_id has been changed
                            if ((hasWritingRightOnTasksOfAWork($isInsideTheProject, getOneWork($data['work'])))) {   //if the user has the permission to write on the new work
                                $task['work_id'] = $data['work'];
                            } else {
                                $msg = COMMON_ACTION_DENIED;
                                $success = false;
                            }
                        }
                        //no $msg because no message on update is returned if success
                    }
                } else {    //update general
                    //Check if value needed aren't empty
                    if (isAtLeastEqual("", [$data["name"], $data["type"], $data["urgency"]]) == false) {
                        //Make advanced validations of each value
                        $validations = [
                            checkStringLengthNotEmpty(trimIt($data['name']), 100),
                            checkStringLengthOnly(trimIt($data['description']), 2000),
                            checkStringLengthOnly(trimIt($data["link"]), 2000),
                            checkIntMinMax($data['urgency'], 0, 5),
                            in_array($data['type'], TASK_LIST_TYPE),
                            ((strtotime($data['deadline']) != false) || $data['deadline'] == "")
                        ];
                        if (areAreAllEqualTo(true, $validations)) {   //list of validations before update
                            $task['name'] = trimIt($data['name']);
                            $task['description'] = trimIt($data['description']);
                            $task['link'] = trimIt($data['link']);
                            $task['urgency'] = $data['urgency'];
                            $task['type'] = $data['type'];
                            $task['deadline'] = timeToDT(strtotime($data['deadline']));
                            $success = true;
                            $msg = interpolateArrayValuesInAString(UPDATEATASK_GENERAL_SUCCESS, ["number" => $currentTask['number']]);
                        }
                    }
                }

                //After all manipulations
                if ($success == true) {
                    updateTask($task, $id);
                    $updatedTask = getOneTask($id);
                    $updatedTask = completeTaskDataForForeignKeys($updatedTask);
                    $response = getApiResponse(API_SUCCESS, ["task" => $updatedTask, "message" => $msg]);
                } else {
                    $msg = COMMON_INVALID_DATA_SENT;
                }
            } else {    //no permission
                $msg = COMMON_ACTION_DENIED;
            }
        } else {    //task not found
            $msg = UPDATEATASK_FAIL_TASK_NOT_FOUND;
        }
    } else {    //error in data sent
        $msg = COMMON_INVALID_DATA_SENT;
    }
    if ($success == false) {    //if not success, build the fail api response
        $response = getApiResponse(API_FAIL, getApiDataContentError($msg));
    }
    echo json_encode($response);    //finally print the response in JSON
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

//Complete the $task data for foreign keys (responsible and creator)
function completeTaskDataForForeignKeys($task)
{
    //Add responsible
    if ($task['responsible_id'] != null) {
        $task['responsible'] = getUserById($task['responsible_id']);
    } else {
        $task['responsible'] = null;
    }

    //Add creator
    if ($task['creator_id'] != null) {
        $task['creator'] = getUserById($task['creator_id']);
    } else {
        $task['creator'] = buildFullNameOfUser(["firstname" => "Compte", "lastname" => "supprimé"]);
    }

    //Add work (never null)
    $task['work'] = getOneWork($task['work_id']);

    $task = unsetPasswordsInArrayOn2Dimensions($task);  //unset passwords for responsible and creator
    return $task;
}

?>
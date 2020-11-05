<?php
/**
 *  Project: KanFF
 *  File: tasksControler.php controler functions for the tasks
 *  Author: Samuel Roland
 *  Creation date: 22.07.2020
 */

require_once "model/tasksModel.php";
define("API_SUCCESS", 1);
define("API_FAIL", 2);
define("API_ERROR", 3);

function getApiResponse($status, $data, $message = "Error...")
{
    if (isAtLeastEqual($status, [API_SUCCESS, API_FAIL, API_ERROR]) == false) {
        die("$status not possible for \$status");
    }
    $statusPossible = [API_SUCCESS => "success", API_FAIL => "fail", API_ERROR => "error"];
    $response['status'] = $statusPossible[$status];
    if ($data !== false) {
        $response['data'] = $data;
    }
    if ($status == API_ERROR) {
        $response['message'] = $message;
    }
    return $response;
}

function getApiDataContentError($error, $code, $position = "topright")
{
    $data['error'] = $error;
    $data['code'] = $code;
    $data['position'] = $position;
    return $data;
}

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

    echo json_encode(getApiResponse(API_SUCCESS, ['task' => $task]));
}

//Ajax call to create one task
function createATask($data)
{
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

        getTask($id);   //return the task like if it was asked with ?action=getTask
    } else {
        if ($hasPermissionToCreate === false) {
            //TODO: return error message in JSON: work not found (or "you don't have permissions" ??)
            $response = getApiResponse(API_FAIL, ["error" => getFlashMessageById(11), "code" => 11, "position" => "top"]);
        } else {
            //TODO: return error message in JSON: invalid data
            $response = getApiResponse(API_FAIL, ["error" => getFlashMessageById(10), "code" => 10, "position" => "top"]);
        }
        echo json_encode($response);
    }
}

//Ajax call to update one task
function updateATask($data)
{
    var_dump($data);
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
    //Check that data sent are valid
    if (chkLength($data['name'], 100) && $data['name'] != "" && isAtLeastEqual($data['type'], TASK_LIST_TYPE) && $hasPermissionToUpdate) {

        //unset useless var
        unsetVar($data['number']);
        unsetVar($data['id']);
        unsetVar($data['creator_id']);
        unsetVar($data['work_id']);
        unsetVar($data['completion_date']);

        //check if below's var are in right type (INT, STRING...)
        $test1=is_int($data['urgency']);
        $test2=is_int($data['type']);
        $test3=is_int($data['responsible_id']);

        if (!$test1&&!$test2&&!$test3){
            //TODO: API repond qu'un ou plusieurs valeur(s) demandée(s) a/ont un problème de type
        }

        //check if the needed value aren't empty
        $test1=setVarTask('name',$data,$task);
        $test2=setVarTask('urgency',$data,$task);
        if (isset($data['state'])){if ($data['state']){$task['state'] = $data['state'];$test3=true;}}


        if (!$test1&&!$test2&&!$test3){
            //TODO: API repond qu'une ou plusieurs valeur(s) demandée(s) est/sont vide(s)
        }



        setVarTask('type',$data,$task);
        //Then generate other fields:
        $task['state'] = TASK_STATE_TODO;
        $task['urgency'] = 0;
        $task['creator_id'] = $_SESSION['user']['id'];

        //Then create the task:
        updateTasks($data['work_id'],$id);

        $task = getOneTask($id);
        $response = getApiResponse(API_SUCCESS, ['task' => $task]);
        echo json_encode($response);
    } else {
        if ($hasPermissionToUpdate === false) {
            //TODO: return error message in JSON: work not found (or "you don't have permissions" ??)
            $response = getApiResponse(API_FAIL, ["error" => getFlashMessageById(11), "code" => 11, "position" => "top"]);
        } else {
            //TODO: return error message in JSON: invalid data
            $response = getApiResponse(API_FAIL, ["error" => getFlashMessageById(10), "code" => 10, "position" => "top"]);
        }
        echo json_encode($response);
    }
}

//unset var if not empty
function unsetVar($var){
    if (isset($var)){
        unset($var);
    }
}
//set var if not empty
function setVarTask($nameOfVar,$data,$task){
    if (isset($nameOfVar)){
        $task[$nameOfVar] = $data[$nameOfVar];
        return true;
    }else{
        return false;
    }
}

//Ajax call to delete a task
function deleteATask($data)
{
    displaydebug($data);
    $task = getOneTask($data['id']);
    $hasPermissionToUpdate = null; //default value
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
        $response = getApiResponse(API_SUCCESS, ["reference" => ["id" => $data['id']]]);
    } else {
        $response = getApiResponse(API_FAIL, getApiDataContentError("no permission", 155));
        //TODO: error about invalid data (and export message to flashmessages.json)
    }
    echo json_encode($response);
}

?>
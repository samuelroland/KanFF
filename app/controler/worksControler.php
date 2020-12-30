<?php
/**
 *  Project: KanFF
 *  File: worksControler.php controler functions for the works
 *  Author: Samuel Roland
 *  Creation date: 22.07.2020
 */

require_once "model/worksModel.php";

//display the page groups
function works()
{

}

function createAWork($data)
{
    $hasPermissionToCreate = null; //default value
    if (isset($data[''])) {
        //TODO: Check the perssion of the current user
        //Check if the current user is in the project
        if (isAUserInsideAProject($data["project_id"], $_SESSION["user"]["id"])) {
            $hasPermissionToCreate = true;
        } else {
            $hasPermissionToCreate = false;
        }
    }
    //TODO: Check that data sent are valid (type, not null, lenght)
    //Check that data sent are valid
    //Not null ?


    if (!isAtLeastEqual("", [$data['type'], $data["name"], $data["start"], $data["end"], $data["value"], $data["effort"], $data["visible"], $data["open"], $data["inbox"], $data["repetitive"], $data["need_help"], $data["project_id"]]) && $hasPermissionToCreate) {
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

        $t = getApiResponse(API_SUCCESS, ['task' => $newtask, 'message' => "Tâche " . $task['number'] . " créée avec succès."]);
        echo json_encode($t);
        die();
    } else {
        if ($hasPermissionToCreate === false) {
            //TODO: return error message in JSON: work not found (or "you don't have permissions" ??)
            $response = getApiResponse(API_FAIL, ["error" => getFlashMessageById(11), "code" => 11, "position" => "top"]);
        } else {
            //TODO: return error message in JSON: invalid data
            $response = getApiResponse(API_FAIL, ["error" => getFlashMessageById(10), "code" => 10, "position" => "top"]);
        }

    }
    echo json_encode($response);
}

//Return true or false, if the user has writing right on tasks of a work depending on the settings of the work
function hasWritingRightOnTasksOfAWork($isInTheProject, $work)
{
    $open = $work['open'];
    $visible = $work['visible'];
    if (isAtLeastEqual($work['state'], [WORK_STATE_DONE, WORK_STATE_TODO]) == false) {
        if ($isInTheProject) {
            return true;
        }
        if ($visible == 1) {
            if ($open == 1) {
                return true;
            }
        }
    }
    return false;
}


?>
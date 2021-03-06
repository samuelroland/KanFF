<?php
/**
 *  Project: KanFF
 *  File: tasksModel.php functions model for the tasks
 *  Author: Benoit Pierrehumbert
 *  Creation date: 23.09.2020
 */

//Get one task with his id
function getOneTask($id)
{
    return getOne("tasks", $id);
}

//Get all tasks
function getAllTasks()
{
    return getAll("tasks");
}

//Get one task whith conditions
function getOneByConditionTasks($conditions, $params)
{
    return getByCondition("tasks", $params, $conditions, false);
}

//Get more than one task whith conditions
function getAllByConditionTasks($conditions, $params)
{
    return getByCondition("tasks", $params, $conditions, true);
}

function getAllTasksByWork($idWorks)
{
    $query = "SELECT tasks.* FROM	tasks
INNER join works ON tasks.work_id = works.id
WHERE	works.id = :id";
    $params = ['id' => $idWorks];
    return Query($query, $params, true);
}

//Get all the tasks by project id
function getAllTasksByProject($id)
{
    $query = "SELECT tasks.* FROM tasks
INNER join works ON works.id = tasks.work_id
INNER join projects ON projects.id = works.project_id
WHERE projects.id = :id";
    $params = ['id' => $id];
    return Query($query, $params, true);
}

function getTasksNextUniqueNumber()
{
    $tasks = getAllTasks();
    $uniquenumber = 0;
    if (isset($tasks)) {
        foreach ($tasks as $task) {
            if ($uniquenumber < $task["number"]) {
                $uniquenumber = $task["number"];
            }
        }
    }
    return $uniquenumber + 1;
}

//Create Work
function createTask($task)
{
    return createOne("tasks", $task);
}

//Update one task with his id
function updateTask($task, $id)
{
    updateOne("tasks", $id, $task);
}

//Delete one task with his id
function deleteTasks($id)
{
    deleteOne("tasks", $id);
}

?>

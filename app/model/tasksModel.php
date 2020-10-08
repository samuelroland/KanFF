<?php
/**
 *  Project: KanFF
 *  File: tasksModel.php functions model for the tasks
 *  Author: Benoit Pierrehumbert
 *  Creation date: 23.09.2020
 */

//Get one task with his id
function getOneTasks($id)
{
    require getOne("tasks", $id);
}

//Get all tasks
function getAllTasks()
{
    return getAll("tasks");
}

//Get one task whith conditions
function getOneByConditionTasks($conditions,$params){
    return getByCondition("tasks", $params, $conditions, false);
}

//Get more than one task whith conditions
function getAllByConditionTasks($conditions,$params){
    return getByCondition("tasks", $params, $conditions, true);
}



//Create Work
function createTasks($Work)
{
    createOne("tasks", $Work);
}

//Update one task with his id
function updateTasks($Work, $id)
{
    updateOne("tasks", $id, $Work);
}

//Delete one task with his id
function deleteTasks($id)
{
    deleteOne("tasks", $id);
}

?>

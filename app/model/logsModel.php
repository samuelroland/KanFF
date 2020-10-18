<?php
/**
 *  Project: KanFF
 *  File: logsModel.php functions model for the logs
 *  Author: Benoit Pierrehumbert
 *  Creation date: 23.09.2020
 */

//Get one log with his id
function getOnelog($id)
{
    return getOne("logs", $id);
}

//Get all logs
function getAllLogs()
{
    return getAll("logs");

}

//Get one log whith conditions
function getOneByConditionLogs($conditions,$params){
    return getByCondition("logs", $params, $conditions, false);
}

//Get more than one log whith conditions
function getAllByConditionLogs($conditions,$params){
    return getByCondition("logs", $params, $conditions, true);
}


//Create log
function createlog($log)
{
    createOne("logs", $log);
}

//Update one log with his id
function updatelog($log, $id)
{
    updateOne("logs", $id, $log);
}

//Delete one log with his id
function deletelog($id)
{
    deleteOne("logs", $id);
}

?>

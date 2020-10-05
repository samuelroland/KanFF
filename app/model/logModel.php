<?php
/**
 *  Project: KanFF
 *  File: logModel.php model for the log
 *  Author: Samuel Roland
 *  Creation date: 05.10.2020
 */

//Get all logs of a project
function getAllLogs($projectId)
{
    $query = "SELECT * FROM log
where log.project_id = :id
order by date;";
    return indexAnArrayById(Query($query, ["id" => $projectId], true));
}

// Get one User
function getOneLog($id)
{
    return getOne("log", $id);
}

//Create log
function createLog($newlog)
{
    createOne("log", $newlog);
}

//Update one log with his id
function updateLog($editLog, $id)
{
    updateOne("log", $id, $editLog);
}

//Delete one log with his id
function deleteLog($id)
{
    deleteOne("log", $id);
}

?>

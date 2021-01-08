<?php
/**
 *  Project: KanFF
 *  File: participateModel.php model for participate table
 *  Author: Samuel Roland
 *  Creation date: 07.01.2021
 */

//Get all participate
function getAllParticipates()
{
    $result = getAll("participate");
    return indexAnArrayById($result);
}

// Get one participate
function getOneParticipate($id)
{
    return getOne("participate", $id);
}

//Create participate
function createParticipate($newParticipate)
{
    return createOne("participate", $newParticipate);
}

//Update one participate with his id
function updateParticipate($editParticipate, $id)
{
    updateOne("participate", $id, $editParticipate);
}

//Delete one participate with his id
function deleteParticipate($id)
{
    deleteOne("participate", $id);
}

?>

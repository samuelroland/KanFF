<?php
/**
 *  Project: KanFF
 *  File: worksModel.php functions model for the works
 *  Author: Benoit Pierrehumbert
 *  Creation date: 23.09.2020
 */

//Get one Work with his id
function getOneWork($id)
{
    require getOne("works", $id);
}

//Get all Works
function getAllWorks()
{
    return getAll("works");

}

//Get one work whith conditions
function getOneByConditionWorks($criterions,$params){
    return getByCondition("users", $params, $criterions, false);
}

//Get more than one work whith conditions
function getAllByConditionWorks($criterions,$params){
    return getByCondition("users", $params, $criterions, true);
}

//Get all works of one sepcific project
function getAllWorksByProject($params){
    $query='';
    return Query($query, $params, true);
}

//Create Work
function createWork($Work)
{
    createOne("works", $Work);
}

//Update one Work with his id
function updateWork($Work, $id)
{
    updateOne("works", $id, $Work);
}

//Delete one Work with his id
function deleteWork($id)
{
    deleteOne("works", $id);
}

?>

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
    return getOne("works", $id);
}

//Get all Works
function getAllWorks()
{
    return getAll("works");
}

//Get one work whith conditions
function getOneByConditionWorks($conditions, $params)
{
    return getByCondition("works", $params, $conditions, false);
}

//Get more than one work whith conditions
function getAllByConditionWorks($conditions, $params)
{
    return getByCondition("works", $params, $conditions, true);
}

//Get all works of one sepcific project
function getAllWorksByProject($project_id)
{
    $query = "SELECT * FROM works WHERE works.project_id =:id
    Order By works.inbox desc, works.state, works.start, works.end;";
    $params = ['id' => $project_id];
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

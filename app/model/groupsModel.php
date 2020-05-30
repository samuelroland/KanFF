<?php
/**
 *  Project: KanFF
 *  File: groupsModel.php functions model for the groups
 *  Author: Samuel Roland
 *  Creation date: 30.05.2020
 */

//Get one group with his id
function getOneGroup($id)
{
    $table = "users";
    $group = getByCriterion($table, $params, $criterions);
    return $group;
}

//Get all groups
function getAllGroups()
{
    $table = "groups";
    $groups = getAll($table);
    return $groups;
}

?>

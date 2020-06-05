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
    require getOne("groups", $id);
}

//Get all groups that are: visible and ordered by creation_date
function getAllGroups()
{
    $query = "
    SELECT groups.id, groups.name, groups.description, groups.context, groups.email, groups.image, groups.restrict_access, groups.status, groups.visibility, groups.creator_id, groups.creation_date, groups.creator_id, users.initials AS creator_initials FROM `groups`
INNER JOIN users ON users.id = groups.creator_id
WHERE groups.visibility = 1
ORDER BY groups.creation_date DESC";

    return Query($query, null, true);

}

//Create group
function createGroup($group)
{
    createOne("groups", $group);
}

//Update one group with his id
function updateGroup($group, $id)
{
    updateOne("groups", $id, $group);
}

//Delete one group with his id
function deleteGroup($id)
{
    deleteOne("groups", $id);
}

?>

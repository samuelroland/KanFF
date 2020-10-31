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
    return getOne("groups", $id);
}

//Get all groups that are: visible and ordered by creation_date
function getAllGroups()
{
    $listOfVisibilityAccepted = GROUP_LIST_VISIBILITY;
    foreach ($listOfVisibilityAccepted as $key => $oneOption) {
        if ($oneOption == GROUP_VISIBILITY_INVISIBLE) {
            unset($listOfVisibilityAccepted[$key]);
        }
    }

    $query = "
    SELECT `groups`.*, users.initials AS creator_initials FROM `groups`
INNER JOIN users ON users.id = `groups`.creator_id
WHERE `groups`.visibility in (" . implode(", ", $listOfVisibilityAccepted) . ")
ORDER BY `groups`.creation_date DESC";

    return Query($query, null, true);

}

//Get all groups for one user
function getAllGroupsByUser($idUser)
{
    $query = "SELECT `groups`.*,`join`.state  FROM	`groups`
INNER join `join` ON `join`.group_id = `groups`.id
INNER join users ON users.id = `join`.user_id
WHERE	users.id = :id AND `join`.state IN (" . JOIN_STATE_INVITATION_ACCEPTED . "," . JOIN_STATE_APPROVED . ")
ORDER BY `join`.start DESC";
    $params = ['id' => $idUser];
    return Query($query, $params, true);
}

//get all groups archived (state is archived)
function getAllGroupsArchived()
{
    $query = "SELECT * from `groups`
where groups.state = ".GROUP_STATE_ARCHIVED.";";
    return Query($query, $params, true);
}

//Get all members for one group ordred by accepted status
function getUsersFromAGroup($idGroup)
{
    $query = "SELECT `users`.*,`join`.state  FROM	`users`
INNER join `join` ON `users`.id = `join`.user_id
INNER join `groups` ON `join`.group_id = `groups`.id
WHERE	`groups`.id =:id AND `join`.state IN (" . JOIN_STATE_INVITATION_ACCEPTED . "," . JOIN_STATE_APPROVED . ")
ORDER BY `join`.start DESC";
    $params = ['id' => $idGroup];
    return Query($query, $params, true);
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

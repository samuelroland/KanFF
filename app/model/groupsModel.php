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

//Get all visible groups for one user
function getAllVisibleGroupsByUser($idUser)
{
    $query = "SELECT `groups`.*, `joindetailedmember`.start as entrydate, COUNT(joinall.id) AS nbusers FROM `groups`
INNER join `join` joindetailedmember ON `joindetailedmember`.group_id = `groups`.id
INNER join `join` joinall ON `joinall`.group_id = `groups`.id
INNER join users detailedmember ON detailedmember.id = `joindetailedmember`.user_id
INNER join users allusers ON allusers.id = `joinall`.user_id
WHERE	detailedmember.id = :id AND `joindetailedmember`.state IN (".implode(", ", [JOIN_STATE_INVITATION_ACCEPTED, JOIN_STATE_APPROVED]).") AND `joinall`.state IN (7, 8)
GROUP BY `joindetailedmember`.id
ORDER BY `joindetailedmember`.start DESC";
    $params = ['id' => $idUser];
    return Query($query, $params, true);
}

//Get all  groups for one user
function getAllGroupsByUser($idUser)
{
    $query = "SELECT `groups`.*, `joindetailedmember`.start as entrydate, COUNT(joinall.id) AS nbusers FROM `groups`
INNER join `join` joindetailedmember ON `joindetailedmember`.group_id = `groups`.id
INNER join `join` joinall ON `joinall`.group_id = `groups`.id
INNER join users detailedmember ON detailedmember.id = `joindetailedmember`.user_id
INNER join users allusers ON allusers.id = `joinall`.user_id
WHERE	detailedmember.id = :id 
GROUP BY `joindetailedmember`.id
ORDER BY `joindetailedmember`.start DESC";
    $params = ['id' => $idUser];
    return Query($query, $params, true);
}

//get all groups archived (state is archived)
function getAllGroupsArchived()
{
    $query = "SELECT * from `groups`
where groups.state = " . GROUP_STATE_ARCHIVED . ";";
    return Query($query, $params, true);
}

//Get all members for one group ordred by accepted status
function getUsersFromAGroup($idGroup)
{
    $query = "SELECT `users`.*,`join`.state as joinstate FROM	`users`
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

//is the member in a group
function isMemberInAGroup($userid, $groupid)
{
    $query = "SELECT `users`.*,`join`.state  FROM	`users`
INNER join `join` ON `users`.id = `join`.user_id
INNER join `groups` ON `join`.group_id = `groups`.id
WHERE	`groups`.id =:groupid AND `join`.state IN (" . JOIN_STATE_INVITATION_ACCEPTED . "," . JOIN_STATE_APPROVED . ") AND users.id = :userid";
    $params = ['groupid' => $groupid, 'userid' => $userid];
    $result = Query($query, $params, true);
    return !(empty($result));
}

?>

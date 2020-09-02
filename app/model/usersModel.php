<?php
/**
 *  Project: KanFF
 *  File: usersModel.php model for the users
 *  Author: LPO
 *  Creation date: 01.05.2020
 */

// TODO: change the informations of the cartouche !!!!!!!


// Gets the logs in the database and return them
function getLogs()
{

}

// Creates the logs in the database
function createLogs($data)
{

}

//Get all users
function getAllUsers()
{
    return indexAnArrayById(getAll("users"));
}

// Get one User
function getUser($infoLogin)
{
    $table = "users";
    $params = ["infoLogin" => $infoLogin];
    $conditions = "username=:infoLogin OR email=:infoLogin OR initials=:infoLogin";
    $user = getByCondition($table, $params, $conditions, false);
    return $user;
}

//Get one user with his id
function getUserById($id)
{
    return getOne("users", $id);
}

//Create user
function createUser($user)
{
    createOne("users", $user);
}

//Update one user with his id
function updateUser($user, $id)
{
    updateOne("users", $id, $user);
}

//Delete one user with his id
function deleteUser($id)
{
    deleteOne("users", $id);
}

function getAllUsersActive()
{
    $query = "SELECT * FROM users 
WHERE users.state in (" . USER_STATE_ADMIN . ", " . USER_STATE_APPROVED . ")
ORDER BY users.inscription desc";
    displaydebug($query);
    return Query($query, [], true);
}


?>

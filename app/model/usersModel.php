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

// Add the new user in the database
function addUser($user)
{
    //createOne(users,,$user);
}

// Get one User
function getUser($infoLogin)
{
    $table = "users";
    $params = ["infoLogin" => $infoLogin];
    $criterions = "username=:infoLogin OR email=:infoLogin OR initials=:infoLogin";
    $user = getByCondition($table, $params, $criterions, false);
    return $user;
}

function getUserById($id)
{
    return getOne("users", $id);
}

function createUser($user)
{
    createOne("users", $user);
}

?>

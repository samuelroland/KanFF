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
    var_dump($table);
    $params =
        [
            "username" => $infoLogin,
            "email" => $infoLogin
        ];
    var_dump($params);
    $criterions = "username=:username OR email=:email";
    $user = getByCriterion($table,$params,$criterions);
    die($user);
    //return $user;

}

?>

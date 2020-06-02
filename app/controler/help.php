<?php
/**
 *  Project: KanFF
 *  File: help.php controler for generating common contents
 *  Author: Samuel Roland
 *  Creation date: 26.04.2020
 */

function checkUserPassword($id, $password)
{
    require_once "controler/loginControler.php";
    $user = getUserById($id);
    return password_verify($password, $user['password']);
}

//Check length of a string that must not be greater than the max given but less or equal
function chkLength($string, $max)
{
    return (strlen($string) <= $max);
}

//Convert the value "on" or null sent with a checkbox in a form, to a tinyint value
function chkToTinyint($value)
{
    return (is_null($value)) ? "0" : "1";
}

//Declare the flashmessage with his number
function flshmsg($number)
{
    $_SESSION['flashmsg'] = $number;
}

//Convert a timestamp in the DATETIME format
function timeToDT($timestamp)
{
    return date("Y-m-d H:i:s", $timestamp);
}

?>
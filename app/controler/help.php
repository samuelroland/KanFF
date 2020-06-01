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

function chkLength($string, $max)
{
    return strlen($string) <= $max;
}

?>
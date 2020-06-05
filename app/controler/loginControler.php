<?php
/**
 *  Project: KanFF
 *  File: loginControler.php controler for all the accounts login or the account create
 *  Author: Luís Pedro Pinheiro
 *  Creation date: 26.04.2020
 */

require "model/usersModel.php";

// This funtion will try to Login Using the provided data
function login($infoLogin, $password)
{
    // TODO: Code the Login function
    // If trying to login it checks the data, else load the page
    if ($infoLogin != "") {
        if (strlen($infoLogin) == 3) {//If the infoLogin is initials, then convert it to upper case
            $infoLogin = strtoupper($infoLogin);
        }
        $UserLog = getUser($infoLogin);
        if (password_verify($password, $UserLog['password'])) {
            unset($UserLog['password']);    //unset password to not save it in the session
            $_SESSION['user'] = $UserLog;   //save all informations of the users in the session
            displaydebug($_SESSION);
            require_once 'view/home.php';
        } else {
            $_SESSION['error'] = 1;
            require_once 'view/login.php';
        }
    } else {
        require_once 'view/login.php';
    }
}

// function to logout the user from de current session
function logout()
{
    unset($_SESSION['user']);
    login(null, null);
}

?>

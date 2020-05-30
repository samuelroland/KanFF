<?php
/**
 *  Project: KanFF
 *  File: loginControler.php controler for all the accounts login or the account create
 *  Author: Luís Pedro Pinheiro
 *  Creation date: 26.04.2020
 */

require "model/usersModel.php";

//This funtion will redirect to the signin page or redirect to the signin page
function signin($firstname, $lastname, $initials, $username, $password, $password2, $email, $phoneNumber, $bio)
{
    // If trying to create an account, else load the page
    if ($username != "" || $email != "") {
        // Checks if password and password2 are equal
        if ($password == $password2) {
            // Hash the password for higher security
            $hash = password_hash($password, PASSWORD_DEFAULT);

            /* if (getUser($username) != '')
             {
                 $_SESSION['error'] = 2;
                 require_once 'view/signin.php';
             }*/
            // Saves the user in an array
            $newUser = [
                "firstname" => $firstname,
                "lastname" => $lastname,
                "initials" => $initials,
                "username" => $username,
                "password" => $hash,
                "email" => $email,
                "phoneNumber" => $phoneNumber,
                "bio" => $bio];
            var_dump($newUser);
            //addUser($newUser);

            var_dump($_SESSION);
            require_once "view/login.php";
        } else {
            $_SESSION['error'] = 2;
            require_once 'view/signin.php';
        }
    } else {
        require_once 'view/signin.php';
    }
}

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

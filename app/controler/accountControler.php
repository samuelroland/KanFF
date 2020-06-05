<?php
/**
 *  Project: KanFF
 *  File: accountControler.php
 *  Author: Kevin Vaucher et Luís Pedro Pinheiro
 *  Creation date: 18.05.2020
 */

function editAccount(){
    require_once "view/editAccount.php";
}

//This funtion will redirect to the signin page or redirect to the signin page
function signin($firstname, $lastname, $initials, $username, $password, $password2, $email, $phoneNumber, $bio)
{
    // If trying to create an account, else load the page
    if ($username != "" || $email != "") {
        // Checks if password and password2 are equal
        if ($password == $password2) {
            // Hash the password for higher security
            $hash = password_hash($password, PASSWORD_DEFAULT);

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
            addUser($newUser);

            require_once "view/login.php";
        } else {
            $_SESSION['error'] = 2;
            require_once 'view/signin.php';
        }
    } else {
        require_once 'view/signin.php';
    }
}

<?php
/**
 *  Project: KanFF
 *  File: index.php the only php file that receives queries
 *  Author: Team
 *  Creation date: 26.04.2020
 */

session_start();

// Include all controllers
require "controler/Help.php";   //controler to generate common contents
require "controler/loginControler.php";

//Extract values sent by GET
extract($_GET); //vars:


//Extract values sent by POST
    extract($_POST); //vars:


//Extract the action of the querystring
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

//depending on the chosen action
switch ($action) {
//This function tries to signin using the infomations given
    case"signin":
        signin($firstname, $lastname, $initials, $username, $password, $password2, $email, $phoneNumber, $bio);
        break;
//This function tries to Login using the infomations given
    case"tryLogin":
        tryLogin();
        break;

//This function tries to Login using the infomations given
    case"tryLogout":
        tryLogout();
        break;

    default: // unknown action
        //TODO: if user connected, then redirect to dashboard page, if not redirect to login page
        login();    //return to the login page
        break;
}


?>

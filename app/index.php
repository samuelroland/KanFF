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
require "controler/controler.php";
//Extract values sent by GET or POST


//Extract the action of the querystring
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = "default";
}

//depending on the chosen action
switch ($action) {
    case "home":
        break;
    default: // unknown action
        //Login page
        break;

//This function displays the signin
    case 'displaySignin':
        signin();
        break;

    //This function displays the Login
    case 'displayLogin':
        login();
        break;

//This function tries to signin using the infomations given
    case"trySignin":
        trySignin();
        break;


//This function tries to Login using the infomations given
case"trySignin":
        tryLogin();
        break;
}


?>

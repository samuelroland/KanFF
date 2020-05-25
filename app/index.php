<?php
/**
 *  Project: KanFF
 *  File: index.php the only php file that receives queries
 *  Author: Team
 *  Creation date: 26.04.2020
 */

session_start();
error_reporting(0); //Hide all error with the php code and html/css/js code
// Include all controllers
require "controler/Help.php";   //controler to generate common contents
require "controler/loginControler.php"; //controler for login functions
require "controler/accountControler.php"; // controler to modify account settings
require "model/localFilesModel.php";    //model for local files functions
require "model/CRUDModel.php";//default model CRUD
//require  "controler/testCRUDmodel.php";//controler for test CRUDmodel functions
require "view/helpers.php";     //functions for helpers functions

// Extract values sent by GET
extract($_GET); //vars:
displaydebug($_GET);

// Extract values sent by POST
extract($_POST); //vars:
displaydebug($_POST);

if(isset($_POST))
{
    $firstname = $_POST["name"];
    $lastname = $_POST["surname"];
    $initials = $_POST["ini"];
    $username = $_POST["user"];
    $password = $_POST["password"];
    $password2 = $_POST["passwordc"];
    $email = $_POST["email"];
    $phoneNumber = $_POST["nb_phone"];
    $bio = $_POST['bio'];
    $infoLogin = $_POST['infoLogin'];
}

// Extract the action of the querystring
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

// Depending on the chosen action
switch ($action) {
// This function tries to signin using the infomations given
    case"signin":
        signin($firstname, $lastname, $initials, $username, $password, $password2, $email, $phoneNumber, $bio);
        break;
// This function tries to Login using the infomations given
    case"login":
        login($infoLogin,$password);
        break;

// This function tries to Login using the infomations given
    case"tryLogout":
        tryLogout();
        break;

//This function test the good working of CrudModel
    case "testCRUD":
        testCRUD();
    default: // Unknown action
        // TODO: if user connected, then redirect to dashboard page, if not redirect to login page
        login($infoLogin,$password);    // Return to the login page
        break;

    case "editAccount":
        editAccount();
        break;
}


?>

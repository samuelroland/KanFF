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
require "view/helpers.php";     //functions for helpers functions
require "controler/help.php";   //controler to generate common contents
require "controler/loginControler.php"; //controler for login functions
require "controler/accountControler.php"; // controler to modify account settings
require "controler/dashboardControler.php"; // controler for the dashboard page
require "controler/groupsControler.php"; // controler for the dashboard page
require "model/localFilesModel.php";    //model for local files functions
require "model/CRUDModel.php";//default model CRUD
//require  "controler/testCRUDmodel.php";//controler for test CRUDmodel functions

// Extract the action of the querystring
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

// Extract values sent by GET
extract($_GET); //vars:
displaydebug($_GET);

// Extract values sent by POST
extract($_POST); //vars:
displaydebug($_POST);

if (isset($_POST)) {
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

if ($action == "createAGroup") {
    $group = $_POST;
}

//If user is not logged, actions authorized are login and signin.
if (!isset($_SESSION['user'])) {
    // Depending on the chosen action
    switch ($action) {
        // try login using the infomations given
        case"login":
            login($infoLogin, $password);
            break;
        // try signin using the infomations given
        case"signin":
            signin($firstname, $lastname, $initials, $username, $password, $password2, $email, $phoneNumber, $bio);
            break;
        default:
            //Default action: return to the login page
            login(null, null);
            break;
    }
} else {    //if user is logged
    // Depending on the chosen action
    switch ($action) {
        case"logout":
            logout();
            break;
        //This function test the good working of CrudModel
        case "testCRUD":
            testCRUD();
        case "editAccount":
            editAccount();
            break;
        case "groups":
            groups();
            break;
        case "createAGroup":
            createAGroup($group);
            break;

        default: // if action is unknown, return back to the dashboard
            dashboard();
            break;
    }
}


?>

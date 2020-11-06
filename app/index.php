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
require_once "view/helpers.php";     //functions for helpers functions
require_once "controler/help.php";   //controler to generate common contents
require "controler/loginControler.php"; //controler for login functions
require "controler/accountControler.php"; // controler to modify account settings
require "controler/dashboardControler.php"; // controler for the dashboard page
require "controler/groupsControler.php"; // controler for the groups
require "controler/membersControler.php"; // controler for the members
require "controler/projectsControler.php"; // controler for the projects
require "controler/logControler.php"; // controler for the projects
require "controler/tasksControler.php"; // controler for the projects
require "controler/worksControler.php"; // controler for the projects
require "controler/eventsControler.php"; // controler for the projects
require "controler/adminControler.php"; // controler for the projects
require "model/localFilesModel.php";    //model for local files functions
require "model/CRUDModel.php";//default model CRUD
//require  "controler/testCRUDmodel.php";//controler for test CRUDmodel functions

$isAdmin = checkAdmin();

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

//Extract values from post data sent with ajax calls
$data = (array)json_decode(file_get_contents("php://input"));
displaydebug($data);

displaydebug($_SESSION);

if (isset($_POST)) {
    $password = $_POST["password"];
    $infoLogin = $_POST['infoLogin'];
}

//If user is not logged, actions authorized are login and signin.
if (!isset($_SESSION['user']['id'])) {
    // Depending on the chosen action
    switch ($action) {
        // try login using the infomations given
        case"login":
            login($infoLogin, $password);
            break;
        // try signin using the infomations given
        case"signin":
            signin($_POST);
            break;
        case "about":
            about();
            break;
        case "sendFeedback":    //Ajax call to send a feedback with the feedback form
            setHTTPHeaderForAPIResponse();
            sendFeedback($data);
            break;
        default:
            //Default action: return to the login page
            login(null, null);
            break;
    }
} else {    //if user is logged
    if (checkLimitedAccess()) {  //if not authorized to access to internal data:
        switch ($action) {
            case"logout":
                logout();
                break;
            case "editAccount":
                editAccount($_POST);
                break;
            case "about":
                about();
                break;
            case "sendFeedback":    //Ajax call to send a feedback with the feedback form
                setHTTPHeaderForAPIResponse();
                sendFeedback($data);
                break;
            default:
                limitedAccessInfo();
        }
    } else {    //if there is no access limitation, then all actions (made as logged user) can be started
        switch ($action) {
            case"logout":
                logout();
                break;
            case "editAccount":
                editAccount($_POST);
                break;
            case "groups":
                $option = $_GET['option'];
                if ($option == null || isAtLeastEqual($option, [1, 2, 3]) == false) {
                    $option = 1;
                }
                groups($option);
                break;
            case "group":
                groupDetails($_GET['id']);
                break;
            case "members":
                $option = $_GET['option'];
                if ($isAdmin == false && ($option == 5 || $option == 6)) {
                    $option = 1;
                }
                members($option);
                break;
            case "member":
                memberDetails($_GET['id']);
                break;
            case "updateAccountState": //Ajax call to update the account state of a member
                setHTTPHeaderForAPIResponse();
                updateAccountState($data);
                break;
            case "changeStatus": //Ajax call to change the status of the user logged
                setHTTPHeaderForAPIResponse();
                changeStatus($data);
                break;
            case "createAGroup":
                createAGroup($_POST);
                break;
            case "createAProject":
                createAProject($_POST);
                break;
            case "projects":
                $option = $_GET['option'];
                if ($option == null || isAtLeastEqual($option, [1, 2, 3]) == false) {
                    $option = 1;
                }
                projects($option);
                break;
            case "project":
                projectDetails($_GET['id'], $_GET['option']);
                break;
            case "kanban":
                kanban($_GET['id'], $_GET['opt']);
                break;
            case "calendar":
                calendar();
                break;
            case "tasks":
                tasks();
                break;
            case "getTask": //Ajax call to get one task
                setHTTPHeaderForAPIResponse();
                getTask($_GET['id']);
                break;
            case "createTask":  //Ajax call to create one task
                setHTTPHeaderForAPIResponse();
                createATask($data);
                break;
            case "updateTask":  //Ajax call to update one task
                setHTTPHeaderForAPIResponse();
                updateATask($data);
                break;
            case "deleteTask":  //Ajax call to delete one task
                setHTTPHeaderForAPIResponse();
                deleteATask($data);
                break;
            case "about":
                about();
                break;
            case "sendFeedback":    //Ajax call to send a feedback with the feedback form
                setHTTPHeaderForAPIResponse();
                sendFeedback($data);
                break;
            case "":    //if no action it's the dashboard
                dashboard();
                break;
            default: // if action is unknown, return back to the dashboard
                if ($action != "signin" && $action != "login") {    //signin et login doesn't make sense when the user is logged but it's not unknown actions so the message is not displayed.
                    flshmsg(0);
                }
                dashboard();
                break;
        }
    }
}

?>

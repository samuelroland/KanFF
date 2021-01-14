<?php
/**
 *  Project: KanFF
 *  File: index.php the only php file that receives queries
 *  Author: Team
 *  Creation date: 26.04.2020
 */

session_start();    //start the session system

// Include all controllers and global php files
require_once "controler/constants.php";     //global constants
require_once "messages.php";     //constants for messages displayed after actions
require_once "view/helpers.php";     //functions for helpers functions
require_once "controler/help.php";   //controler to generate common contents
require_once "controler/accountControler.php"; // controler to modify account settings
require_once "controler/dashboardControler.php"; // controler for the dashboard page
require_once "controler/groupsControler.php"; // controler for the groups
require_once "controler/membersControler.php"; // controler for the members
require_once "controler/projectsControler.php"; // controler for the projects
require_once "controler/logControler.php"; // controler for the projects
require_once "controler/tasksControler.php"; // controler for the projects
require_once "controler/worksControler.php"; // controler for the projects
require_once "controler/adminControler.php"; // controler for the projects
require_once "model/localFilesModel.php";    //model for local files functions
require_once "model/CRUDModel.php";//default model CRUD
//require_once "controler/eventsControler.php"; // controler for the projects

$isAdmin = checkAdmin();    //check if is admin and reload the session

// Extract the action of the querystring
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

//Get values from post data sent with Ajax calls
$data = (array)json_decode(file_get_contents("php://input"));

//displaydebug all input values and the session content
displaydebug($_GET);
displaydebug($_POST);
displaydebug($data);
displaydebug($_SESSION);

$isAjax = isAjax();

//If user is not logged, actions authorized are login and signin.
if (!isset($_SESSION['user']['id'])) {
    // Depending on the chosen action
    switch ($action) {
        // try login using the infomations given
        case"login":
            login($_POST['infoLogin'], $_POST["password"]);
            break;
        // try signin using the infomations given
        case"signin":
            signin($_POST);
            break;
        case "about":
            about();
            break;
        case "sendFeedback":    //Ajax call to send a feedback with the feedback form
            sendFeedback($data);
            break;
        case "manual":
            manual();
            break;
        default:
            if ($isAjax) {
                $apiData = getApiDataContentError(COMMON_ACTION_DENIED_LOGGED_OUT);
                $response = getApiResponse(API_FAIL, $apiData);
                echo json_encode($response);
            } else {
                //Default action: return to the login page
                login(null, null);
            }
            break;
    }
} else {    //if user is logged
    if (checkLimitedAccess()) {  //if not authorized to access to internal data:
        switch ($action) {
            case"logout":
                logout();
                break;
            case "myAccount":
                myAccount($_POST);
                break;
            case "deleteAccount":
                deleteAccount($_POST);
                break;
            case "about":
                about();
                break;
            case "sendFeedback":    //Ajax call to send a feedback with the feedback form
                sendFeedback($data);
                break;
            case "manual":
                manual();
                break;
            default:
                if ($isAjax) {
                    $apiData = getApiDataContentError(COMMON_ACTION_DENIED_LIMITED_ACCESS);
                    $response = getApiResponse(API_FAIL, $apiData);
                    echo json_encode($response);
                } else {
                    limitedAccessInfo();
                }
        }
    } else {    //if there is no access limitation, then all actions (made as logged user) can be started
        switch ($action) {
            case"logout":
                logout();
                break;
            case "myAccount":
                myAccount($_POST);
                break;
            case "deleteAccount":
                deleteAccount($_POST);
                break;
            case "archiveAccount":
                archiveAccount($_POST);
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
                updateAccountState($data);
                break;
            case "changeStatus": //Ajax call to change the status of the user logged
                changeStatus($data);
                break;
            case "deleteUnapprovedUser": //Ajax call to delete an unapproved member (for spam)
                deleteUnapprovedUser($data);
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
                if (isset($opt) == false) {
                    $opt = 0;
                } else {
                    $opt = $_GET['opt'];
                }
                kanban($_GET['id'], $opt);
                break;
            case "getTask": //Ajax call to get one task
                getTask($_GET['id']);
                break;
            case "createTask":  //Ajax call to create one task
                createATask($data);
                break;
            case "updateTask":  //Ajax call to update one task
                updateATask($data);
                break;
            case "deleteTask":  //Ajax call to delete one task
                deleteATask($data);
                break;
            case "about":
                about();
                break;
            case "sendFeedback":    //Ajax call to send a feedback with the feedback form
                sendFeedback($data);
                break;
            case "manual":
                manual();
                break;
            /* Actions for future versions
             case "calendar":
                calendar();
                break;
            case "tasks":
                tasks();
                break;
            */
            default:
                if ($isAjax) {
                    $apiData = getApiDataContentError(COMMON_ACTION_UNKNOWN);
                    $response = getApiResponse(API_FAIL, $apiData);
                    echo json_encode($response);
                } else {
                    // if action is unknown, return back to the dashboard
                    if ($action != "signin" && $action != "login" && isset($_GET['action'])) {    //signin et login doesn't make sense when the user is logged but it's not unknown actions so the message is not displayed.
                        flshmsg(COMMON_404);
                    }
                    dashboard();
                }
                break;
        }
    }
}

?>

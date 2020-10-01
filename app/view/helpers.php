<?php
/**
 *  Project: KanFF
 *  File: helpers.php view for generating common contents. linked to Help.php
 *  Author: Team
 *  Creation date: 26.04.2020
 */

//define constants value of users.state, identical to values in the database:
define("USER_STATE_UNAPPROVED", 0);
define("USER_STATE_APPROVED", 1);
define("USER_STATE_ONBREAK", 2);
define("USER_STATE_ARCHIVED", 3);
define("USER_STATE_ADMIN", 4);
define("USER_LIST_STATE", [USER_STATE_UNAPPROVED, USER_STATE_APPROVED, USER_STATE_ONBREAK, USER_STATE_ARCHIVED, USER_STATE_ADMIN]);

//define constants of groups.state, identical to values in the database:
define("GROUP_STATE_ONSTARTUP", 0);
define("GROUP_STATE_ACTIVE", 1);
define("GROUP_STATE_ONBREAK", 2);
define("GROUP_STATE_ARCHIVED", 3);
define("GROUP_LIST_STATE", [GROUP_STATE_ONSTARTUP, GROUP_STATE_ACTIVE, GROUP_STATE_ONBREAK, GROUP_STATE_ARCHIVED]);

//define constants of projects.state, identical to values in the database:
define("PROJECT_STATE_UNDERREFLECTION", 0);
define("PROJECT_STATE_UNDERPLANNING", 1);
define("PROJECT_STATE_SEMIACTIVEWORK", 2);
define("PROJECT_STATE_ACTIVEWORK", 3);
define("PROJECT_STATE_ONBREAK", 4);
define("PROJECT_STATE_REPORTED", 5);
define("PROJECT_STATE_ABANDONNED", 6);
define("PROJECT_STATE_CANCELLED", 7);
define("PROJECT_STATE_DONE", 8);
define("PROJECT_LIST_STATE", [PROJECT_STATE_UNDERREFLECTION, PROJECT_STATE_UNDERPLANNING, PROJECT_STATE_SEMIACTIVEWORK, PROJECT_STATE_ACTIVEWORK, PROJECT_STATE_ONBREAK, PROJECT_STATE_REPORTED, PROJECT_STATE_ABANDONNED, PROJECT_STATE_CANCELLED, PROJECT_STATE_DONE]);

//define constants of works.state, identical to values in the database:
define("WORK_STATE_TODO", 1);
define("WORK_STATE_INRUN", 2);
define("WORK_STATE_ONBREAK", 3);
define("WORK_STATE_DONE", 4);
define("WORK_LIST_STATE", [WORK_STATE_TODO, WORK_STATE_INRUN, WORK_STATE_ONBREAK, WORK_STATE_DONE]);

//define constants of tasks.state, identical to values in the database:
define("TASK_STATE_TODO", 1);
define("TASK_STATE_INRUN", 2);
define("TASK_STATE_DONE", 3);
define("TASK_LIST_STATE", [TASK_STATE_TODO, TASK_STATE_INRUN, TASK_STATE_DONE]);


//get the flashmessage with the messageid stored in the session.
function flashMessage($withHtml = true)
{
    if (isset($_SESSION["flashmsg"])) { //if flashmessage exists
        $message = getFlashMessageById($_SESSION['flashmsg']);  //get message from JSON file flashmessages.json
        if ($withHtml) {
            $content = "<div id='flashmessage' class='flashmessage'>" . $message . "</div>";
        } else {
            $content = $message;
        }
    }
    unset($_SESSION["flashmsg"]);   //après avoir affiché le message, le message ne doit pas réapparaitre.
    return $content;
}

//display a var (with var_dump()) for debug, only if debug mode is enabled
function displaydebug($var)
{
    require ".const.php";   //get the $debug variable
    if ($debug == true) {   //if debug mode enabled
        if (substr($_SERVER['SERVER_SOFTWARE'], 0, 7) != "PHP 7.3") {  //if version is not 7.3 (var_dump() don't have the same design)
            echo "<pre><small>" . print_r($var, true) . "</small></pre>";   //print with line break and style of <pre>
        } else {
            var_dump($var); //else to a simple var_dump() of PHP 7.3
        }
    }
}

//Convert the user state in french
function convertUserState($int)
{
    switch ($int) {
        case USER_STATE_UNAPPROVED:
            return "non approuvé";
        case USER_STATE_APPROVED:
            return "approuvé";
        case USER_STATE_ONBREAK:
            return "en pause";
        case USER_STATE_ARCHIVED:
            return "archivé";
        case USER_STATE_ADMIN:
            return "admin";
        default:
            return "ERROR UNKNOWN STATE";
    }
}

//Convert the group state in french
function convertGroupState($int)
{
    switch ($int) {
        case GROUP_STATE_ONSTARTUP:
            return "en démarrage";
        case GROUP_STATE_ACTIVE:
            return "actif";
        case GROUP_STATE_ONBREAK:
            return "en pause";
        case GROUP_STATE_ARCHIVED:
            return "archivé";
        default:
            return "ERROR UNKNOWN STATE";
    }
}

//Convert the project state in french
function convertProjectState($int)
{
    switch ($int) {
        case PROJECT_STATE_UNDERREFLECTION:
            return "en cours de réflexion";
        case PROJECT_STATE_UNDERPLANNING:
            return "en planification";
        case PROJECT_STATE_SEMIACTIVEWORK:
            return "travail semi-actif";
        case PROJECT_STATE_ACTIVEWORK:
            return "travail actif";
        case PROJECT_STATE_ONBREAK:
            return "travail en pause";
        case PROJECT_STATE_REPORTED:
            return "reporté";
        case PROJECT_STATE_ABANDONNED:
            return "abandonné";
        case PROJECT_STATE_CANCELLED:
            return "annulé";
        case PROJECT_STATE_DONE:
            return "terminé";
        default:
            return "ERROR UNKNOWN STATE";
    }
}

//Convert the work state in french
function convertWorkState($int)
{
    switch ($int) {
        case WORK_STATE_TODO:
            return "à faire";
        case WORK_STATE_INRUN:
            return "en cours";
        case WORK_STATE_ONBREAK:
            return "en pause";
        case WORK_STATE_DONE:
            return "terminé";   //ou fini ??
        default:
            return "ERROR UNKNOWN STATE";
    }
}
//Convert the task state in french
function convertTaskState($int)
{
    switch ($int) {
        case TASK_STATE_TODO:
            return "à faire";
        case TASK_STATE_INRUN:
            return "en cours";
        case TASK_STATE_DONE:
            return "terminé";   //ou fini ??
        default:
            return "ERROR UNKNOWN STATE";
    }
}

//Done you can use it
function setFirstCharToUpperCase($string)
{
    $string = strtoupper(replaceAccentChars(substr($string, 0, 1))) . substr($string, 1);
    $string = str_replace(
            array('é', 'è', 'ù', 'â', 'ê', 'î', 'ô', 'û', 'ä', 'ë', 'ï', 'ö', 'ü', 'à', 'æ', 'œ', 'ç'),
            array('É', 'È', 'Ù', 'Â', 'Ê', 'Î', 'Ô', 'Û', 'Ä', 'Ë', 'Ï', 'Ö', 'Ü', 'À', 'Æ', 'Œ', 'Ç'),
            substr($string, 0, 2)
        ) . substr($string, 2);
    return $string;
}

//tasks too or identical to works.state ?

?>
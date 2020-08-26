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

//define constants of groups.state, identical to values in the database:
define("GROUP_STATE_ONSTARTUP", 0);
define("GROUP_STATE_ACTIVE", 1);
define("GROUP_STATE_ONBREAK", 2);
define("GROUP_STATE_ARCHIVED", 3);

//define constants of projects.state, identical to values in the database:
define("PROJECT_STATE_UNDERREFLECTION", 0);
define("PROJECT_STATE_UNDERPLANNING", 1);
define("PROJECT_STATE_SEMIACTIVEWORK", 2);
define("PROJECT_STATE_ACTIVEWORK", 3);
define("PROJECT_STATE_ONBREAK", 4);
define("PROJECT_STATE_REPORTED", 5);
define("PROJECT_STATE_ABANDONNED", 6);
define("PROJECT_STATE_CANCELLED", 7);
define("PROJECT_STATE_COMPLETED", 8);

//define constants of works.state, identical to values in the database:
define("WORK_STATE_TODO", 1);
define("WORK_STATE_INRUN", 2);
define("WORK_STATE_ONBREAK", 3);
define("WORK_STATE_COMPLETED", 4);

//get the flashmessage with the messageid stored in the session.
function flashMessage($withHtml = true)
{
    //TODO: export list of message in a json file for separate languages
    if (isset($_SESSION["flashmsg"])) { //if flashmessage exists
        switch ($_SESSION['flashmsg']) {
            case 1: //erreur identifiants
                $message = "Les identifiants de connexion ne concordent pas. Veuillez retenter la connexion.";
                break;
            case 2: //erreur email déjà pris
                $message = "Cet email est déjà utilisé par un autre utilisateur... Veuillez recommencer avec un autre email.";
                break;
            case 3: //erreurs de permissions en cas de bidouille des formulaires.
                $message = "Action non autorisée avec ces permissions... mêlez vous de vos oignons.";
                break;
        }
        if ($withHtml) {
            $content = "<div id='flashmessage' class='alert alert-dark flashmessage'>" . $message . "</div>";
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
        var_dump($var);
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
        case PROJECT_STATE_COMPLETED:
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
        case WORK_STATE_COMPLETED:
            return "terminé";   //ou fini ??
        default:
            return "ERROR UNKNOWN STATE";
    }
}

//tasks too or identical to works.state ?

?>
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
define("USER_STATE_ARCHIVED", 2);
define("USER_STATE_BANNED", 3);
define("USER_STATE_ADMIN", 4);
define("USER_LIST_STATE", [USER_STATE_UNAPPROVED, USER_STATE_APPROVED, USER_STATE_ARCHIVED, USER_STATE_BANNED, USER_STATE_ADMIN]);

//define constants of join.state, identical to values in the database:
define("JOIN_STATE_UNAPPROVED", 1);
define("JOIN_STATE_REFUSED", 2);
define("JOIN_STATE_INVITATION", 3);
define("JOIN_STATE_LEFT", 4);
define("JOIN_STATE_INVITATION_REFUSED", 5);
define("JOIN_STATE_BANNED", 6);
define("JOIN_STATE_INVITATION_ACCEPTED", 7);
define("JOIN_STATE_APPROVED", 8);
define("JOIN_LIST_STATE", [JOIN_STATE_UNAPPROVED, JOIN_STATE_REFUSED, JOIN_STATE_INVITATION, JOIN_STATE_LEFT, JOIN_STATE_INVITATION_REFUSED, JOIN_STATE_BANNED, JOIN_STATE_INVITATION_ACCEPTED, JOIN_STATE_APPROVED]);

//define constants of groups.state, identical to values in the database:
define("GROUP_STATE_ONSTARTUP", 0);
define("GROUP_STATE_ACTIVE", 1);
define("GROUP_STATE_ONBREAK", 2);
define("GROUP_STATE_ARCHIVED", 3);
define("GROUP_LIST_STATE", [GROUP_STATE_ONSTARTUP, GROUP_STATE_ACTIVE, GROUP_STATE_ONBREAK, GROUP_STATE_ARCHIVED]);

//define constants of groups.visibility, identical to values in the database:
define("GROUP_VISIBILITY_INVISIBLE", 1);
define("GROUP_VISIBILITY_TITLE", 2);
define("GROUP_VISIBILITY_STANDARD", 3);
define("GROUP_VISIBILITY_TOTAL", 4);
define("GROUP_LIST_VISIBILITY", [GROUP_VISIBILITY_INVISIBLE, GROUP_VISIBILITY_TITLE, GROUP_VISIBILITY_STANDARD, GROUP_VISIBILITY_TOTAL]);

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

//define constants of participate.state, identical to values in the database:
define("PARTICIPATE_STATE_INVITATION", 1);
define("PARTICIPATE_STATE_INVITATION_ACCEPTED", 2);
define("PARTICIPATE_STATE_CREATOR", 3);
define("PARTICIPATE_STATE_LEFT", 4);
define("PARTICIPATE_STATE_INVITATION_REFUSED", 5);
define("PARTICIPATE_STATE_BANNED", 6);
define("PARTICIPATE_LIST_STATE", [PARTICIPATE_STATE_INVITATION, PARTICIPATE_STATE_INVITATION_ACCEPTED, PARTICIPATE_STATE_CREATOR, PARTICIPATE_STATE_LEFT, PARTICIPATE_STATE_INVITATION_REFUSED, PARTICIPATE_STATE_BANNED]);

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
function displaydebug($var, $needPrint_r = false)
{
    require ".const.php";   //get the $debug variable
    if ($debug == true) {   //if debug mode enabled
        if (substr($_SERVER['SERVER_SOFTWARE'], 0, 7) != "PHP 7.3") {  //if version is not 7.3 (var_dump() don't have the same design)
            echo "<pre><small>" . print_r($var, true) . "</small></pre>";   //print with line break and style of <pre>
        } else {
            if ($needPrint_r == false) {
                var_dump($var); //else to a simple var_dump() of PHP 7.3
            } else {
                echo "<pre><small>" . print_r($var, true) . "</small></pre>";
            }

        }
    }
}

//Convert the user state in french
function convertUserState($int, $needFirstCharToUpper = false)
{
    switch ($int) {
        case USER_STATE_UNAPPROVED:
            $txt = "non approuvé";
            break;
        case USER_STATE_APPROVED:
            $txt = "approuvé";
            break;
        case USER_STATE_ARCHIVED:
            $txt = "archivé";
            break;
        case USER_STATE_BANNED:
            $txt = "banni";
            break;
        case USER_STATE_ADMIN:
            $txt = "admin";
            break;
        default:
            $txt = "ERROR UNKNOWN STATE";
    }
    $txt = manageIfApplyOnFirstChar($txt, $needFirstCharToUpper);
    return $txt;
}

//Convert the user state in french
function convertJoinState($int, $needFirstCharToUpper = false)
{
    switch ($int) {
        case JOIN_STATE_UNAPPROVED:
            $txt = "non approuvé";
            break;
        case JOIN_STATE_REFUSED:
            $txt = "refusé";
            break;
        case JOIN_STATE_INVITATION:
            $txt = "invitation";
            break;
        case JOIN_STATE_LEFT:
            $txt = "quitté";
            break;
        case JOIN_STATE_INVITATION_REFUSED:
            $txt = "invitation refusée";
            break;
        case JOIN_STATE_BANNED:
            $txt = "banni";
            break;
        case JOIN_STATE_INVITATION_ACCEPTED:
            $txt = "invitation acceptée";
            break;
        case JOIN_STATE_APPROVED:
            $txt = "approuvé";
            break;
        default:
            $txt = "ERROR UNKNOWN STATE";
    }
    $txt = manageIfApplyOnFirstChar($txt, $needFirstCharToUpper);
    return $txt;
}

//Convert the group state in french
function convertGroupState($int, $needFirstCharToUpper = false)
{
    switch ($int) {
        case GROUP_STATE_ONSTARTUP:
            $txt = "en démarrage";
            break;
        case GROUP_STATE_ACTIVE:
            $txt = "actif";
            break;
        case GROUP_STATE_ONBREAK:
            $txt = "en pause";
            break;
        case GROUP_STATE_ARCHIVED:
            $txt = "archivé";
            break;
        default:
            $txt = "ERROR UNKNOWN STATE";
    }
    $txt = manageIfApplyOnFirstChar($txt, $needFirstCharToUpper);
    return $txt;
}

//Convert the group visibility in french
function convertGroupVisibility($int, $needFirstCharToUpper = false)
{
    switch ($int) {
        case GROUP_VISIBILITY_INVISIBLE:
            $txt = "Invisible";
            break;
        case GROUP_VISIBILITY_TITLE:
            $txt = "Titre uniquement";
            break;
        case GROUP_VISIBILITY_STANDARD:
            $txt = "Standard";
            break;
        case GROUP_VISIBILITY_TOTAL:
            $txt = "Totalement visible";
            break;
        default:
            $txt = "ERROR UNKNOWN STATE";
    }
    $txt = manageIfApplyOnFirstChar($txt, $needFirstCharToUpper);
    return $txt;
}

//Convert the project state in french
function convertProjectState($int, $needFirstCharToUpper = false)
{
    switch ($int) {
        case PROJECT_STATE_UNDERREFLECTION:
            $txt = "en cours de réflexion";
            break;
        case PROJECT_STATE_UNDERPLANNING:
            $txt = "en planification";
            break;
        case PROJECT_STATE_SEMIACTIVEWORK:
            $txt = "travail semi-actif";
            break;
        case PROJECT_STATE_ACTIVEWORK:
            $txt = "travail actif";
            break;
        case PROJECT_STATE_ONBREAK:
            $txt = "travail en pause";
            break;
        case PROJECT_STATE_REPORTED:
            $txt = "reporté";
            break;
        case PROJECT_STATE_ABANDONNED:
            $txt = "abandonné";
            break;
        case PROJECT_STATE_CANCELLED:
            $txt = "annulé";
            break;
        case PROJECT_STATE_DONE:
            $txt = "terminé";
            break;
        default:
            $txt = "ERROR UNKNOWN STATE";
    }
    $txt = manageIfApplyOnFirstChar($txt, $needFirstCharToUpper);
    return $txt;
}

//Convert the participate state in french
function convertParticipateState($int, $needFirstCharToUpper = false)
{
    switch ($int) {
        case PARTICIPATE_STATE_INVITATION:
            $txt = "invitation";
            break;
        case PARTICIPATE_STATE_INVITATION_ACCEPTED:
            $txt = "invitation acceptée";
            break;
        case PARTICIPATE_STATE_CREATOR:
            $txt = "créateur";
            break;
        case PARTICIPATE_STATE_LEFT:
            $txt = "quitté";
            break;
        case PARTICIPATE_STATE_INVITATION_REFUSED:
            $txt = "invitation refusée";
            break;
        case PARTICIPATE_STATE_BANNED:
            $txt = "banni";
            break;
        default:
            $txt = "ERROR UNKNOWN STATE";
    }
    $txt = manageIfApplyOnFirstChar($txt, $needFirstCharToUpper);
    return $txt;
}

//Convert the work state in french
function convertWorkState($int, $needFirstCharToUpper = false)
{
    switch ($int) {
        case WORK_STATE_TODO:
            $txt = "à faire";
            break;
        case WORK_STATE_INRUN:
            $txt = "en cours";
            break;
        case WORK_STATE_ONBREAK:
            $txt = "en pause";
            break;
        case WORK_STATE_DONE:
            $txt = "terminé";   //ou fini ??
            break;
        default:
            $txt = "ERROR UNKNOWN STATE";
    }
    $txt = manageIfApplyOnFirstChar($txt, $needFirstCharToUpper);
    return $txt;
}

//Convert the task state in french
function convertTaskState($int, $needFirstCharToUpper = false)
{
    switch ($int) {
        case TASK_STATE_TODO:
            $txt = "à faire";
            break;
        case TASK_STATE_INRUN:
            $txt = "en cours";
            break;
        case TASK_STATE_DONE:
            $txt = "terminé";   //ou fini ??
            break;
        default:
            $txt = "ERROR UNKNOWN STATE";
    }
    $txt = manageIfApplyOnFirstChar($txt, $needFirstCharToUpper);
    return $txt;
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

//Apply (or not) the first char function (to avoid this comparison on each "convert" function.
function manageIfApplyOnFirstChar($txt, $needFirstCharToUpper)
{
    if ($needFirstCharToUpper == false) {
        return $txt;
    } else {
        return setFirstCharToUpperCase($txt);
    }
}

//Get HTML code to mention an user with initials clickable (for user details) and with a tooltip to show full name:
function mentionUser($basicUser, $css = "text-info")
{
    //TODO: add tooltip on initials hover with full name (and username?)
    //TODO: remove link if user has limited access
    if (checkLimitedAccess()) {
        $mention = "<span class='cursorpointer $css d-inline' data-fallbackPlacement='flip' data-toggle='tooltip' data-title='" . $basicUser['firstname'] . " " . $basicUser['lastname'] . " " . (($basicUser['username'] != "") ? "(" . $basicUser['username'] . ")" : "") . "' data-placement='top' data-delay='1'>{$basicUser['initials']}</span>";
    } else {
        $mention = "<span class='cursorpointer clickable $css d-inline' data-fallbackPlacement='flip' data-toggle='tooltip' data-title='" . $basicUser['firstname'] . " " . $basicUser['lastname'] . " " . (($basicUser['username'] != "") ? "(" . $basicUser['username'] . ")" : "") . "' data-placement='top' data-delay='1' data-href='?action=member&id={$basicUser['id']}'>{$basicUser['initials']}</span>";
    }

    return $mention;
}

//Get HTML code to create a tooltip with or without a link
function createToolTip($innerText, $tooltipText, $link = false, $type = "top")
{
    $html = "<span class=' d-inline " . (($link != false) ? "linkInternal clickable cursorpointer" : "") . "' data-fallbackPlacement='flip' data-toggle='tooltip' data-title=\"" . $tooltipText . "\" data-placement='$type' data-delay='1' " . (($link != false) ? "data-href='$link'" : "") . ">{$innerText}</span>";
    return $html;
}

function createElementWithFixedLines($text, $nbLines)
{
    $html = "<span class='txtFixedLines' style='-webkit-line-clamp: $nbLines;'>$text</span>";
    return $html;
}

function getHTMLPastille($cssColor)
{
    return "<div class='pastillecircle' style='
    background-color: $cssColor;'></div>";
}

//tasks too or identical to works.state ?

?>
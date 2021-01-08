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

//define constants of works.need_help, identical to values in the database:
define("WORK_NEEDHELP_NONE", 0);
define("WORK_NEEDHELP_INNER", 1);
define("WORK_NEEDHELP_OUTER", 2);
define("WORK_NEEDHELP_BOTH", 3);
define("WORK_LIST_NEEDHELP", [WORK_NEEDHELP_NONE, WORK_NEEDHELP_INNER, WORK_NEEDHELP_OUTER, WORK_NEEDHELP_BOTH]);

//define constants of tasks.state, identical to values in the database:
define("TASK_STATE_TODO", 1);
define("TASK_STATE_INRUN", 2);
define("TASK_STATE_DONE", 3);
define("TASK_LIST_STATE", [TASK_STATE_TODO, TASK_STATE_INRUN, TASK_STATE_DONE]);

//define constants of tasks.type, identical to values in the database:
define("TASK_TYPE_NONE", 0);
define("TASK_TYPE_QUESTION", 1);
define("TASK_TYPE_INFORMATION", 2);
define("TASK_TYPE_PROPOSITION", 3);
define("TASK_TYPE_IDEA", 4);
define("TASK_TYPE_REFLEXION", 5);
define("TASK_LIST_TYPE", [TASK_TYPE_NONE, TASK_TYPE_QUESTION, TASK_TYPE_INFORMATION, TASK_TYPE_PROPOSITION, TASK_TYPE_IDEA, TASK_TYPE_REFLEXION]);

define("UNWANTED_CHARS_ARRAY", array('Š' => 'S', 'š' => 's', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
        'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U',
        'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c',
        'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o',
        'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y', 'Ğ' => 'G', 'İ' => 'I', 'Ş' => 'S', 'ğ' => 'g', 'ı' => 'i', 'ş' => 's', 'ü' => 'u')
);

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
    $isAjax = ($_SERVER['HTTP_X_AJAX'] == 'true');  //if the request is an Ajax call, the debug is different
    require ".const.php";   //get the $debug variable
    if ($debug == true) {   //if debug mode enabled
        echo "\n";
        if ($isAjax) {
            print_r($var);  //only print_r() because text is not interpreted in Network panel of the browser
            echo "\\end/";  //each print_r() must end with "\end/" to be able to find the real JSON response in the middle of debug data
        } else {
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

//Convert the work need_help in french
function convertWorkNeedhelp($int, $needFirstCharToUpper = false)
{
    switch ($int) {
        case WORK_NEEDHELP_NONE:
            $txt = "Pas besoin";
            break;
        case WORK_NEEDHELP_INNER:
            $txt = "Besoin d'aide interne";
            break;
        case WORK_NEEDHELP_OUTER:
            $txt = "Besoin d'aide externe";
            break;
        case WORK_NEEDHELP_BOTH:
            $txt = "Besoin d'aide interne et externe";
            break;
        default:
            $txt = "ERROR UNKNOWN STATE";
    }
    $txt = manageIfApplyOnFirstChar($txt, $needFirstCharToUpper);
    return $txt;
}

//Convert the work need_help to the name of the icon
function convertWorkNeedhelpIcon($int)
{
    switch ($int) {
        case WORK_NEEDHELP_NONE:
            $txt = false;
            break;
        case WORK_NEEDHELP_INNER:
            $txt = "help_orange.png";
            break;
        case WORK_NEEDHELP_OUTER:
            $txt = "help_yellow.png";
            break;
        case WORK_NEEDHELP_BOTH:
            $txt = "help_orangeyellow.png";
            break;
        default:
            $txt = "ERROR UNKNOWN STATE";
    }
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

//Convert the task type in french
function convertTaskType($int, $needFirstCharToUpper = false)
{
    switch ($int) {
        case TASK_TYPE_NONE:
            $txt = "autre"; //TBD
            break;
        case TASK_TYPE_QUESTION:
            $txt = "question";
            break;
        case TASK_TYPE_INFORMATION:
            $txt = "information";
            break;
        case TASK_TYPE_PROPOSITION:
            $txt = "proposition";
            break;
        case TASK_TYPE_IDEA:
            $txt = "idée";
            break;
        case TASK_TYPE_REFLEXION:
            $txt = "réflexion";
            break;
        default:
            $txt = "ERROR UNKNOWN STATE";
    }
    $txt = manageIfApplyOnFirstChar($txt, $needFirstCharToUpper);
    return $txt;
}

//Set the first char of a string to uppercase
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
    //TODO: if needed manage linkInternal or linkExternal... some css adjustments for block may be applied
    $html = "<span class=' d-inline " . (($link != false) ? "linkInternal clickable cursorpointer" : "") . "' data-fallbackPlacement='flip' data-toggle='tooltip' data-title=\"" . $tooltipText . "\" data-placement='$type' data-delay='1' " . (($link != false) ? "data-href='$link' " : "") . ((contains($link, "?action=manual")) ? "data-target='_blank'" : "") . ">{$innerText}</span>";
    return $html;
}

//Get HTML code to create a tooltip on a question mark icon (point.png)
function createToolTipWithPoint($tooltipText, $pointClasses = "icon-small m-2", $link = false, $type = "top")
{
    $innerText = printAnIcon("point.png", "", "question mark icon", $pointClasses, false);
    $html = createToolTip($innerText, $tooltipText, $link, $type);
    return $html;
}

//Get HTML code to create a tooltip on a question mark icon (point.png)
function createManualLink($section, $concernFullPage = true, $cssOnManualIcon = "icon-xsmall", $tooltipType = "top")
{
    $html = createToolTip(printAnIcon("manual.png", "", "manual icon", $cssOnManualIcon, false), "Aide sur " . (($concernFullPage) ? "la page " : "") . $section, "?action=manual#" . createKeyNameForElementId($section));
    return $html;
}

//Create HTML inline element for a text displayed at maximum on $nbLines lines. (like a long text displayed on maximum 4 lines in a div).
function createElementWithFixedLines($text, $nbLines, $cssClassesInAddition = "", $withTextAsTitle = false)
{
    $html = "<span class='txtFixedLines $cssClassesInAddition' style='-webkit-line-clamp: $nbLines;' " . (($withTextAsTitle == true) ? "title='" . $text . "'" : "") . ">$text</span>";
    return $html;
}

//Create a pastille (a little colored circle). $cssColor is a valid css color string (ex: "red" or "#ff0e5d")
function getHTMLPastille($cssColor)
{
    return "<div class='pastillecircle' style='background-color: $cssColor;'></div>";
}

//print (or return) an icon with a file, a title, alt attribute, and personalized or default css classes
function printAnIcon($iconname, $title, $alt, $cssClasses = "icon-small ml-2 mr-2", $echo = true, $id = "", $hidden = false)
{
    if ($id != "") {    //if not null
        $id = "id='$id'";   ///build attribute string
    }   //if null the $id will just be "" so attribute id will not exist at all.
    $html = "<img title=\"" . $title . "\" class=\"$cssClasses\" src='view/medias/icons/$iconname' $id alt='$alt' " . (($hidden) ? "hidden" : "") . ">";
    if ($echo) {
        echo $html;
    } else {
        return $html;
    }
}

//Print a WIP Page informations (for beta versions only).
function printPageWIPTextInfo()
{
    echo "<span class='text-danger'><strong>Page en cours de construction.</strong></span>";
}

//Build full name of the user with firstname and lastname (and a space between)
function buildFullNameOfUser($user)
{
    if (isAtLeastEqual("", [$user['firstname'], $user['lastname']]) == false) {
        return $user['firstname'] . " " . $user['lastname'];
    } else {
        return false;
    }
}

//Build sentence "Defined as approved,
function buildSentenceAccountStateLastChange($user, $middleBreak = false, $introductionIncluded = true)
{
    //INFO: unapproved user don't have state_modifier_id and state_modification_date. All other state must be associated with the date (and the admin id is facultative).
    if ($user['state'] == USER_STATE_UNAPPROVED) {  //if unapproved, the state hasn't been changed yet (no information at all)
        $sentence = "Aucun changement d'état pour l'instant.";
    } else {
        $sentence = "";
        if ($introductionIncluded) {
            $sentence .= "Défini comme <em>" . convertUserState($user['state']) . "</em>" . (($middleBreak == true) ? "<br>" : "");
        }
        $sentence .= " le " . DTToHumanDate($user['state_modification_date'], "simpletime");  //the date must be not null if state has changed
        if ($user['state_modifier_id'] != null) {   //the admin can be anonyme
            $sentence .= " par " . mentionUser($user['state_modifier']);
        } else {
            $sentence .= " (Admin anonyme).";
        }
    }
    return $sentence;
}

function MDToHTML($raw)
{
    require_once "extensions/parsedown/Parsedown.php";
    $Parsedown = new Parsedown();
    return $Parsedown->text($raw);
}

//Get the title in html (including the id attribute), if the line is a title (no other possibility to add the id to the title in markdown).
function getTitleWithIdAttributeInHTMLIfIsTitle($line, $startWith, $markup)
{
    if (startwith($line, $startWith) == false) {    //if the line is not a title
        return $line;   //return the unchanged line
    } else {
        $text = trimIt(substr($line, strpos($line, $startWith) + strlen($startWith), strrpos($line, "</") - strpos($line, $startWith) - strlen($startWith)));  //get the text after the space (the space is after the symbol at the start of line)
        $id = createKeyNameForElementId($text);    //convert to lowercase, replace accent chars, and replace " " and "'"
        $result = "<div class='flexdiv  box-verticalaligncenter'><$markup id='" . $id . "' class=''>" . $text . "</$markup>";  //ex: "<h1 id='introduction'>Introduction</h1>"

        //Add the copylink icon:
        $result .= createCopyLinkIconForManual($text);

        $result .= "</div>";
        return $result;
    }

}

//Create HTML element with a copylink icon for a link to a section of the manual
function createCopyLinkIconForManual($section)
{
    return "<span data-hrefcopy='" . $_SERVER['HTTP_HOST'] . "/?action=manual#" . createKeyNameForElementId($section) . "' class='cursorpointer linkToCopy'>" . printAnIcon("copylinkmini.png", "Copier le lien vers cette section", "copy lin icon", "icon-xsmall m-2 noborder mt-3 copylink", false) . "</span>";
}

//Get table of content element in Markdown, if the line is a title
function getTableOfContentElementInMDIfIsTitle($line, $startWith, $level)
{
    if (startwith($line, $startWith) == false) {    //if line is not a markdown title, return "" to add nothing to the list
        return "";
    } else {
        $tabs = "";
        for ($i = 0; $i < $level - 1; $i++) {   //create tabulations before each TOC line to create the different levels of titles
            $tabs .= "  ";
        }
        /*if ($level != 1) {
            $tabs .= "-";
        }*/
        $text = trimIt(substr($line, strpos($line, $startWith) + strlen($startWith), strrpos($line, "</") - strpos($line, $startWith) - strlen($startWith)));  //get the text after the space (the space is after the symbol at the start of line)
        $id = createKeyNameForElementId($text);
        $result = "$tabs- [$text](#$id)\n";  //ex: "    - [Introduction](#introduction)" (here with 1 tab if title is level 2).
        return $result;
    }
}

function createKeyNameForElementId($text)
{
    $anchor = clearAllNonAlphabeticalChars(strtolower(replaceAccentChars(str_replace(" ", "-", str_replace("'", "-", trimIt($text))))), "-");
    return $anchor;
}

function clearAllNonAlphabeticalChars($text, $exceptions = "")
{
    $characters = str_split('0123456789abcdefghijklmnopqrstuvwxyz' . $exceptions);

    $newText = "";
    foreach (str_split($text) as $char) {
        if (in_array($char, $characters) == true) {
            $newText .= $char;
        }
    }
    return $newText;
}

//Return if the string start with the specified substring
function startwith($text, $with)
{
    return (substr($text, 0, strlen($with)) == $with);
}

function contains($haystack, $needle)
{
    return (strpos($haystack, $needle) !== false);
}

//Get inline JS for a link to copy on click
function getInlineJSForALinkToCopy($link, $linkIsJS = false, $responseMsg = "Lien copié dans le presse-papiers.")
{
    //Inline JS is sensible to chars " and ' (little securization even if these data are not user input. It's useful to avoid that the text given in dev contain " or '
    $link = htmlspecialchars($link, ENT_QUOTES);  //transform '
    $link = htmlentities($link);  //transform "
    $responseMsg = htmlspecialchars($responseMsg, ENT_QUOTES);  //transform '
    $responseMsg = htmlentities($responseMsg);  //transform "
    $singleQuoteAroundLinkOrNot = (($linkIsJS) ? "" : "'"); //is there single quotes around the link or not ? if not, it's javascript in the link (useful to get value of another input)

    //The final string is in JS: copy given link then display response msg given
    return ' onclick="navigator.clipboard.writeText(' . $singleQuoteAroundLinkOrNot . $link . $singleQuoteAroundLinkOrNot . '); displayResponseMsg(\'' . $responseMsg . '\');" ';
}

//Get inline JS for a link to copy on click
function getInlineJSForALinkToOpen($link, $linkIsJS = false, $target = null)
{
    //Inline JS is sensible to chars " and ' (little securization even if these data are not user input. It's useful to avoid that the text given in dev contain " or '
    $link = htmlspecialchars($link, ENT_QUOTES);  //transform '
    $link = htmlentities($link);  //transform "
    $singleQuoteAroundLinkOrNot = (($linkIsJS) ? "" : "'"); //is there single quotes around the link or not ? if not, it's javascript in the link (useful to get value of another input)

    //The final string is in JS: copy given link then display response msg given
    return ' onclick="goToLink(' . $singleQuoteAroundLinkOrNot . $link . $singleQuoteAroundLinkOrNot . ', \'' . $target . '\');" ';
}

?>

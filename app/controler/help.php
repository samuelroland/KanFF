<?php
/**
 *  Project: KanFF
 *  File: help.php controler for generating common contents
 *  Author: Samuel Roland
 *  Creation date: 26.04.2020
 */

define("ARRAY_ACCENT_CHARS", array('Š' => 'S', 'š' => 's', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
        'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U',
        'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c',
        'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o',
        'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y', 'Ğ' => 'G', 'İ' => 'I', 'Ş' => 'S', 'ğ' => 'g', 'ı' => 'i', 'ş' => 's', 'ü' => 'u')
);
//Check that the password sent is the password of the user logged. The function is not useful for the logins, but it's useful to check the password when the user make an important action that need to be validated.
function checkUserPassword($id, $password)
{
    require_once "controler/accountControler.php";    //WIP useful
    $user = getUserById($id);
    return password_verify($password, $user['password']);   //return true ou false
}

//Check length of a string that must not be greater than the max given but less or equal
function chkLength($string, $max)
{
    return (strlen($string) <= $max);
}

//Convert the value "on" or null sent with a checkbox in a form, to a tinyint value
function chkToTinyint($value)
{
    return (is_null($value)) ? "0" : "1";
}

//is value sent by a checkbox valid ? (can be "on" or empty) but no other possibilities.
function isCheckboxValueValid($value)
{
    return ($value == "on" || $value == "");
}

//Define the next flashmessage with his number
function flshmsg($number)
{
    $_SESSION['flashmsg'] = $number;
}

//Convert a timestamp in the DATETIME format
function timeToDT($timestamp)
{
    return date("Y-m-d H:i:s", $timestamp);
}

function DTToHumanDate($datetime, $mode = "simpleday", $isTimestamp = false)
{
    $timestamp = $datetime;

    if ($isTimestamp == false) {
        $timestamp = strtotime($datetime);
    }
    switch ($mode) {
        case "simpleday":
            return date("d.m.Y", $timestamp);
            break;
        case "simpletime":
            return date("d.m.Y à H:i", $timestamp);
            break;
        case "completeday":
            return date("j F Y", $timestamp);
            break;
        case "completetime":
            return date("j F Y à H:i:s", $timestamp);
            break;
        default:
            return "ERROR!";
            break;
    }
}

//Convert special chars from values of an array of array, to html entities:
function specialCharsConvertFromAnArray($items, $fields)
{
    //INFO: $fields is the list of the field to convert
    foreach ($items as $index => $item) {
        //For each item scan each value
        foreach ($item as $key => $value) {
            //If the key is in the fields list
            if (in_array($key, $fields)) {
                //Convert it to an html entity
                $item[$key] = htmlentities($value, ENT_QUOTES);
            }
        }
        $items[$index] = $item;
    }
    return $items;
}

//Substring a string cleverly (depend on spaces or not) without cut a word, to return a string that is equal or less long than the max defined
function substrText($text, $max, $nospace = false, $points = true)
{
    //if string is already less or equal than the max:
    if (strlen($text) <= $max) {
        return $text;
    }
    //If points are asked, the max is 4 chars shorter because "... " is 4 chars long
    if ($points == true) {
        $max -= 4;
    }

    if ($nospace) {
        $text = substr($text, 0, $max); //normal substring independantly of the spaces included
    } else {
        $text = substr($text, 0, $max + 1); //substring without condition. Include the potential space at the top end
        $position = strripos($text, " ");   //search the last space of the string
        $text = substr($text, 0, $position);    //substring the text up to 1 char before the last position of the space
    }

    if ($points) {  //if points enabled, add 3 little points
        if ($nospace) {
            $text .= "...";
        } else {
            $text .= " ...";
        }

    }
    return $text;
}

//Trim value of spaces, tab, ... in " \t\n\r\0\x0B"
function trimIt($string)
{
    return trim($string, " \t\n\r\0\x0B");
}

//replace accent chars like é, à, ... with the corresponding letter without accent.
function replaceAccentChars($string)
{
    return strtr($string, ARRAY_ACCENT_CHARS);
}

function indexAnArrayById($array)
{
    $newarray = [];
    foreach ($array as $item) {
        $newarray[$item['id']] = $item;
    }
    return $newarray;
}

//Return true or false if the user logged is an admin
function checkAdmin()
{
    $isAdmin = false;

    //Update session with data informations to reload admin field:
    $uptodateUser = getUserById($_SESSION['user']['id']);
    unset($uptodateUser['password']);
    $_SESSION['user'] = $uptodateUser;
    //TODO: check efficiency with all fields instead of just admin

    if ($_SESSION['user']['state'] == USER_STATE_ADMIN) {
        $isAdmin = true;
    }
    return $isAdmin;
}

//Return true or false if the user has limited access (because the state is not approved or is not admin)
function checkLimitedAccess()
{
    $hasLimitedAccess = false;

    $state = $_SESSION['user']['state'];
    if ($state != USER_STATE_APPROVED && $state != USER_STATE_ADMIN) {  //if not authorized to access to internal data:
        $hasLimitedAccess = true;   //has a limited access
    }
    return $hasLimitedAccess;
}

//Check that each key of an simple array is not empty (useful to check that all not null fields have been sent):
function checkThatEachKeyIsNotEmpty($array)
{
    foreach ($array as $item) {
        if ($item == null) {
            return false;
        }
    }
    return true;
}

function isAtLeastEqual($value, $possibilities)
{
    foreach ($possibilities as $possibility) {
        if ($value == $possibility) {
            return true;
        }
    }
    return false;
}

//Compare 2 dates (datetime format) with day precision and return -1, 0 or 1
function compare2DatesWithDayPrecision($date1, $date2)
{
    //Set dates in timestamp with day precisions (at the end, no difference between "2020-05-01 05:06:08" et "2020-05-01 10:15:00"
    $date1 = strtotime(date("Y-m-d", strtotime($date1)));
    $date2 = strtotime(date("Y-m-d", strtotime($date2)));

    if ($date1 == -1 || $date2 == -1) {
        die("compare2DatesWithDayPrecision: Error of conversion.");
    }
    if ($date1 == $date2) {
        return 0;
    } else if ($date1 < $date2) {
        return -1;
    } else {
        return 1;
    }
}

//Unset password in an array on 2 dimensions (1st: $array['password'] and 2nd: $array[$key]['password'])
function unsetPasswordsInArrayOn2Dimensions($array)
{
    if (isset($array['password'])) {
        unset($array['password']);
    }
    foreach ($array as $key => $item) {
        if (isset($item['password'])) {
            unset($item['password']);
        }
        $array[$key] = $item;
    }
    return $array;
}

//check with a simple basic regex if email is valid
function isEmailFormat($text)
{
    //Thanks to: https://www.regular-expressions.info/email.html
    return (!!preg_match('/^[A-z0-9._%+-]+@[A-z0-9.-]+\.[A-z]{2,}$/', strtoupper($text)));  //!! for bool value
}

//Send feedback with data sent with Ajax
function sendFeedback($data)
{
    $versions = getVersionsApp();
    require ".const.php";
    if ($feedbackForm != true) {
        die("Feedback form is disabled");
    }
    if (isEmailFormat($emailSourceForFeedback) && isEmailFormat($emailForFeedback)) {

        if (isAtLeastEqual("", [$data['subject'], $data['content']]) == false && chkLength($data['content'], 6000) && chkLength($data['subject'], 100)) {
            $to = $emailForFeedback;
            $subject = "Retour KanFF: " . time();
            $cookies = $_COOKIE;
            unset($cookies['PHPSESSID']);   //remove cookie for the session
            ob_start();
            print_r($cookies);
            $printCookies = ob_get_clean();
            $technicalInformations = ["Sent at: " . date("Y-m-d H:i:s", time()), $_SERVER['HTTP_USER_AGENT'], $_SERVER['HTTP_REFERER'], $versions[count($versions) - 1]['version'], $printCookies];

            $headers = array(
                'From' => $emailSourceForFeedback,
                'X-Mailer' => 'PHP/' . phpversion()
            );

            //Reply email
            $data['email'] = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
            if (is_null($data['email']) == false && $data['email'] != false) { //if email is not null and if sanitize has not failed

                $technicalInformations[] = "Reply-To: " . $data['email'] . ((isEmailFormat($data['email']) == false) ? "  EMAIL INVALID! Reply-To not defined..." : "");   //save the email in the technical informations (because not displayed in all cases in the mail client)
                if (isEmailFormat($data['email'])) { //do not save the email if not strict email valid (because will be displayed)
                    $headers['Reply-To'] = $data['email'];  //set email as reply to
                    $_SESSION['feedback']['email'] = $data['email'];
                }
            }

            $introTechInformations = "Technical informations:\n" . implode("
            ", $technicalInformations); //implode technical informations for introduction

            $message = "Subject: \n" . $data['subject'] . "\n\nContent:\n" . $data['content'];  //the message is the subject + the content of the feedback

            //Build the final email content (with technical informations, message, json data)
            $content = $introTechInformations . "\n\n---------------------------------------------------------------------\n" . $message . "\n---------------------------------------------------------------------\nJSON:\n" . json_encode(array_merge($data, $technicalInformations));    //the final total content of the email
            $result = mail($to, $subject, $content, $headers);  //send the final email

            if (!$result) {
                $errorMessage = error_get_last()['message'];
            }
            displaydebug($errorMessage);
            displaydebug($result);

            $response = getApiResponse(API_SUCCESS, ['message' => "Feedback envoyé."]);
        } else {
            $response = getApiResponse(API_FAIL, getApiDataContentError("Données invalides. Echec d'envoi du feedback.", 152));
        }
    } else {
        $response = getApiResponse(API_ERROR, null, "Mauvaise configuration côté serveur pour l'envoi de feedback. Contacter l'admin de l'instance.");
    }
    echo json_encode($response);
}

//Set the headers of the HTTP request for API response (from an Ajax call):
function setHTTPHeaderForAPIResponse()
{
    header("Content-Type: application/json");
}

//get bool value to know if an admin can change the state of a user from $current to $next (because change approved by non-approved is not permitted for example)
function canChangeUserState($current, $next)
{
    if ($next == $current) {
        return true;
    } else if ($current == USER_STATE_UNAPPROVED && $next == USER_STATE_APPROVED) {
        return true;
    } else if ($current == USER_STATE_APPROVED && $next != USER_STATE_UNAPPROVED) {
        return true;
    } else if (isAtLeastEqual($current, [USER_STATE_ARCHIVED, USER_STATE_BANNED, USER_STATE_APPROVED]) && isAtLeastEqual($next, [USER_STATE_ARCHIVED, USER_STATE_BANNED, USER_STATE_APPROVED])) {
        return true;
    } else if ($current == USER_STATE_ADMIN && $next == USER_STATE_APPROVED) {
        return true;
    }
    return false;
}

//set value for error if error is not true. if error is true, return true to not change value
function setErrorValueIfNotTrue($newValue, $currentValue)
{
    if ($currentValue == true) {
        return $currentValue;
    } else {
        return $newValue;
    }
}

//Check that a string match with a regular expression (regex):
function checkRegex($string, $regex)
{
    $regex = "/" . $regex . "/";    //transform regex raw format, with adding slash at start and end
    return preg_match($regex, $string);
}

//Check validity of names (alphabetical and "-" and " " authorized only):
function checkNamesValidity($name)
{
    $regex = USER_NAMES_REGEX;
    return checkRegex($name, $regex);
}

function manual()
{
    require ".const.php";

    $linkImages = "https://raw.githubusercontent.com/samuelroland/KanFF/develop/doc";
    //Get the documentation content:
    if ($dev == true) {
        $doc = file_get_contents("../doc/kanff-doc-user-fr.md");
    } else {
        $doc = file_get_contents("$linkImages/kanff-doc-user-fr.md");
    }
    $msg = null;
    if ($doc == null){
        $msg = "Source du mode d'emploi non trouvée... L'affichage est donc impossible.";
    }
    $doc = MDToHTML($doc);

    //Manage and work on the content:
    $lines = explode("\n", $doc);   //explode the documentation to work with each line separately
    $toc = "\n\n";  //insert line break at start and end of TOC to avoid error in interpretation of Parsedown.
    foreach ($lines as $key => $line) {
        $toc .= getTableOfContentElementInMDIfIsTitle($line, "<h1>", 1);  //concat the markdown text of the list element to the TOC if the line is title level 1
        $line = getTitleWithIdAttributeInHTMLIfIsTitle($line, "<h1>", "h1");    //get the html text of the title with his attribute id if the line is title level 1
        $toc .= getTableOfContentElementInMDIfIsTitle($line, "<h2>", 2);
        $line = getTitleWithIdAttributeInHTMLIfIsTitle($line, "<h2>", "h2");
        $toc .= getTableOfContentElementInMDIfIsTitle($line, "<h3>", 3);
        $line = getTitleWithIdAttributeInHTMLIfIsTitle($line, "<h3>", "h3");
        $lines[$key] = $line;   //save final value of line (updated if is title, no change if not).
    }
    $toc .= "\n";   //insert line break at start and end of TOC to avoid error in interpretation of Parsedown.

    foreach ($lines as $key => $line) {
        $line = str_replace("img src=\"img/", "img src=\"$linkImages/img/", $line);
        $lines[$key] = $line;
    }
    $doc = implode("\n", $lines);
    $doc = str_replace("[INSERT TOC HERE]", MDToHTML($toc), $doc);    //insert the table of content in the documentation
    require_once "view/manual.php";
}

?>
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
    require_once "controler/loginControler.php";    //WIP useful
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

function DTToHumanDate($datetime, $mode = "simpleday")
{
    switch ($mode) {
        case "simpleday":
            return date("d.m.Y", strtotime($datetime));
            break;
        case "simpletime":
            return date("d.M.Y à H:i", strtotime($datetime));
            break;
        case "completeday":
            return date("j F Y", strtotime($datetime));
            break;
        case "completetime":
            return date("j F Y à H:i:S", strtotime($datetime));
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
        $text .= " ...";
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

//Return true or false if the user logged is an admin or not.
function checkAdmin()
{
    $isAdmin = false;
    if ($_SESSION['user']['state'] == USER_STATE_ADMIN) {
        $isAdmin = true;
    }
    return $isAdmin;
}

?>
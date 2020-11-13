# Helpers functions


## Helpers.php

Build fullname of the user with firstname and lastname (and a space between)
   
    function buildFullNameOfUser($user)
#### Parameters:
- $user: must contain firstname and lastname index.
#### Return: string
##
Returns the entire string with first letter of the given variable in uppercase
   
    function setFirstCharToUpperCase($string)
#### Parameters:
- $string: a string.
#### Return: string
##
Show the content of $_SESSION["flashmsg"]
   
    function flashMessage($withHtml = true)
#### Parameters:
- $withHtml: false if we want to display the message without html
#### Return: void
##
Show the content of $_SESSION["flashmsg"]
   
    function flashMessage($withHtml = true)
#### Parameters:
- $withHtml: false if we want to display the message without html
#### Return: void
##
Display a var (with var_dump()) for debug, only if debug mode is enabled
   
    function displaydebug($var, $needPrint_r = false)
#### Parameters:
- $var: must contain var we want to display
- $needPrint_r: true if we want to print_r the var
#### Return: void
##
Convert[x][y] [x] is the table where the field[y] is located, we want to convert [y] to text
   
       function convertXY($int, $needFirstCharToUpper = false)
- convertUserState
- convertJoinState
- convertGroupState
- convertGroupVisibility
- convertProjectState
- convertParticipateState
- convertWorkState
- convertWorkNeedhelp
- convertWorkNeedhelpIcon
- convertTaskState
- convertTaskType
#### Parameters:
- $int: must contain the int
- $needFirstCharToUpper: true if we want an upper lettre at the start of the word
#### Return: void
 
##
Return the given string with an upper char for first letter depends on [needFirstCharToUpper]
   
    function manageIfApplyOnFirstChar($txt, $needFirstCharToUpper)
#### Parameters:
- $txt: must contain the text that we want to trim
- $needFirstCharToUpper: true if we want an upper letter at the start of the word
#### Return: string
##
Display the firstname and lastname 
   
    function mentionUser($basicUser, $css = "text-info")
#### Parameters:
- $basicUser: must contain the user we want to diplay with the hover
- $css: must contain a css class
#### Return: string

## help.php

Verify if given format is correct
   
    function isEmailFormat($text)
#### Parameters:
- $text: must contain the text that we want to check if it is an email
#### Return: string

##
Return the given string without space at start and end
   
    function trimIt($string)
#### Parameters:
- $string: must contain the text that we want to trim
#### Return: string
##
Return true if it find the value in all the possibilities
   
    function isAtLeastEqual($value, $possibilities)
#### Parameters:
- $value: must contain the value we want to test is in possibilities
- $possibilities: must contain the possibilities
#### Return: bool

## global.php
##
Return the given string without all numbers
   
    function removeNumbersInString(text)
#### Parameters:
- text: must contain the text that we want to remove numbers
#### Return: string
##
Check length of text in input (type = text), if the string's is more than 4/5 of the max length, counter appears in red.
If the string's length = max lenght, writing will be blocked
   
    function checkTextFieldToCheck()
#### Parameters:
- none
#### Return: void
##
Give an array constitute by values from the [formname]
   
    function getArrayFromAFormFieldsWithName(formname)
#### Parameters:
- formname: must contain the name of form we want to extract the array
#### Return: void
##
Send a request with ajax
   
    function sendRequest(verb, url, callback, data)
#### Parameters:
- verb: must contain a verb like: create, read, update, delete (CRUD) 
- url: must contain the url where the request
- callback: must contain the name of function we want to call after request
- data: must contain the data we want to send with ajax request
#### Return: string
##
Return the given string without all numbers
   
    function displayResponseMsg(val, checkmark = true, color = "black")
#### Parameters:
- val: must contain the text that we want display
- checkmark: must contain a bool that tell to us if the checkmark is a tick or a cross
- color: must contain a css color that decide what is the text's color
#### Return: string
##
Return false if one of the [values] is empty
   
    function checkAllValuesAreNotEmpty(values)
#### Parameters:
- values: must contain the values we want to tests
#### Return: string
##
Return if [needle] is contain in the things after "action=" in the querystring 
   
    function queryActionIncludes(needle)
#### Parameters:
- needle: must contain the text that we want to check if is contained in querystring
#### Return: bool
##
Create a div with a DOM object inside from a string with html code
   
    function createElementFromHTML(htmlString)
#### Parameters:
- htmlString: must contain the text that we want to put in the div
#### Return: the div with the object created inside
##
Write in console the given text
   
    function logIt(text)
#### Parameters:
- text: must contain the text that we want to write in console
#### Return: void
##
Return a bool if the string tested with regex return true
   
    function testRegex(regex, string)
#### Parameters:
- regex: must contain a regex
- string: must contain a string
#### Return: string





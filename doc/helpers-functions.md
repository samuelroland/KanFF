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
- convertUserState()
- convertJoinState()
- convertGroupState()
- convertGroupVisibility()
- convertProjectState()
- convertParticipateState()
- convertWorkState()
- convertWorkNeedhelp()
- convertWorkNeedhelpIcon()
- convertTaskState()
- convertTaskType()
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

---
Check the password of a user for an important action
   
    checkUserPassword($id, $password)
#### Parameters:
- $id: id of the user
- $password: password sent for the important action
#### Return: bool. Result of password_verifiy()

---
Check the length of string doesn't exceed max of chars authorized (usually max defined by the database)

    chkLength($string, $max)
#### Parameters:
- $string: string to test
- $max: nb max of chars authorized
#### Return: bool. true if respect the maximum, and false is not.

---
Convert a checkbox sent value to TINYINT format (0 if null and 1 if not) (checkbox input are not sent if not checked!)

    chkToTinyint($value)
#### Parameters:
- $value: value of the checkbox (like $data['visible'] from the input type checkbox)
#### Return: int 0 or 1.

---
Set the flashmessage in the session with its number, that will be displayed in a view or in the gabarit

    flshmsg($number)
#### Parameters:
- $number: number of the flashmessage (number in flashmessages.json)
#### Return: int 0 or 1.

---
Convert a timestamp date to datetime format (like 1605472805 in "2020-11-15 20:40:05"). Is useful for the database because all dates are stored in datetime

    timeToDT($timestamp)
#### Parameters:
- $timestamp: the timestamp date
#### Return: string reprensenting the datetime

---
Convert a datetime date to a "human displayable date" 

    DTToHumanDate($datetime, $mode = "simpleday", $isTimestamp = false)
#### Parameters:
- $datetime: the datetime date
- $mode: the format for date() chosen (possibilities: simpleday = "d.m.Y", simpletime = "d.m.Y à H:i", completeday = "j F Y", completetime = "j F Y à H:i:S")
- $isTimestamp: if the date is a timestamp instead of a datetime, the parameter can be set to true
#### Return: string with the date formatted with the chosen mode

---
Convert all chosen fields in a 2d array to html entities

    specialCharsConvertFromAnArray($items, $fields)
#### Parameters:
- $items: the 2d array (ex: [["name" => "test<p>", "description" => "truc"], ["name" => "<a>html test <script>", "description" => "truc"]])
- $fields: 1D array of all fields to convert (ex: ["name", "description"])
#### Return: the array $items after conversion


---
Substring a text cleverly with conditions

    substrText($text, $max, $nospace = false, $points = true)
#### Parameters:
- $text: the text
- $max: maximum of length
- $nospace: if the string can be stopped on another char than a space char (or if words must not be cut).
- $points: add or not points "..." at the end of the string (max length of text alone will be $max - 4)
#### Return: return the sub-string extracted

---
Return the given string without space, tab, line break, and null byte, at the start and end of the string.
   
    function trimIt($string)
#### Parameters:
- $string: must contain the text that we want to trim
#### Return: string the text trimed.

---
Replace accented chars with their equivalent without any accent
   
    function replaceAccentChars($string)
#### Parameters:
- $string: text with accents ("élève" will be converted in "eleve")
#### Return: string without accent

---
Index a 2D array from a select query on a database
   
    function indexAnArrayById($array)
#### Parameters:
- $array: the array
#### Return: array with each subarray indexed with value of the field id in this subarray.

---
Is the user logged an admin
   
    function checkAdmin()
#### Parameters:
none
the state of the user will be updated in the session
#### Return: bool

---
Check if user has limited access (if banned, archived or unapproved) or not
   
    function checkLimitedAccess()
#### Parameters:
none
#### Return: bool for question "has limited access"

---
Check that each key of sub array of an 2D array is not null
   
    function checkThatEachKeyIsNotEmpty($array)
#### Parameters:
- $array: array 2D
--> Useful to check that a set of fields are not null before a creation in the database (create an $array only with these fields)
#### Return: bool. true if no null value. else return false.

---
Is a value at least equal to one element in a list
   
    function isAtLeastEqual($value, $possibilities)
#### Parameters:
- $value: must contain the value we want to test if is in possibilities
- $possibilities: must contain the possibilities as 1D array (like [1, 5, 6])
#### Return: bool. true if in the list and false if not

---
Compare 2 dates with day precision
   
    function compare2DatesWithDayPrecision($date1, $date2)
#### Parameters:
- $date1: first date
- $date2: second date
#### Return: int value: 0 if dates are on the same day, -1 if date1 is before date2, 1 if date1 is after date2 

---
Unset passwords in the 2 dimensions of a 2D array
   
    function unsetPasswordsInArrayOn2Dimensions($array)
#### Parameters:
- $array: array 2D (1D not accepted)
#### Return: the arrays without any password

---
Is the email respecting the email format (with a regex)
   
    function isEmailFormat($text)
#### Parameters:
- $text: the email
#### Return: bool

---
Send a email with a feedback sent through the feedback form
   
    function sendFeedback($data)
#### Parameters:
- $data: array with body of POST. it must contain $data['subject'],  $data['content'] and $data['email']. email can be null if response is not asked.
#### Return: JSON API response with success of failed message.

---
Set the HTTP Header for API response (like Content-Type and other values if needed)

    function setHTTPHeaderForAPIResponse()
#### Parameters:
none
#### Return: void

---
Return if we can change the user state from the current to next wanted (no all changes are authorized)

    function canChangeUserState($current, $next)
#### Parameters:
- $current: current state
- $next: wanted new state
#### Return: bool

---
Get error value if not true

    function setErrorValueIfNotTrue($newValue, $currentValue)
#### Parameters:
- $newValue: new value got from the last test of validity
- $currentValue: current value of $error in the long list of validation
#### Return: bool. false if $newValue is false, $current value if $newCalue is true

## global.js
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





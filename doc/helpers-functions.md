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
- text: must contain the text that we want to remove numbers
#### Return: string
##
Return the given string without all numbers
   
    function removeNumbersInString(text)
#### Parameters:
- text: must contain the text that we want to remove numbers
#### Return: string
##
Return the given string without all numbers
   
    function removeNumbersInString(text)
#### Parameters:
- text: must contain the text that we want to remove numbers
#### Return: string
##
Return the given string without all numbers
   
    function removeNumbersInString(text)
#### Parameters:
- text: must contain the text that we want to remove numbers
#### Return: string




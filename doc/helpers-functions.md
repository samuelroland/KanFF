# Helpers functions


## Helpers.php

Build fullname of the user with firstname and lastname (and a space between)
   
    function buildFullNameOfUser($user)
#### Parameters:
- $user: must contain firstname and lastname index.
Return: string
##
Returns the first letter of the given variable in uppercase
   
    function setFirstCharToUpperCase($string)
#### Parameters:
- $string: a string.
Return: string
 

## help.php

Verify if gived format is correct
   
    function isEmailFormat($text)
#### Parameters:
- $text: must contain the text that we want to check if it is an email
Return: string

##
Return the given string without space at start and end
   
    function trimIt($string)
#### Parameters:
- $string: must contain the text that we want to trim
Return: string
##
Return true if it find the value in all the possibilities
   
    function isAtLeastEqual($value, $possibilities)
#### Parameters:
- $value: must contain the value we want to test is in possibilities
- $possibilities²: must contain the possibilities
Return: bool

## global.php
Return the given string without space at start and end
   
    function trimIt($string)
#### Parameters:
- $string: must contain the text that we want to trim
Return: string
##
Return the given string without space at start and end
   
    function trimIt($string)
#### Parameters:
- $string: must contain the text that we want to trim
Return: string
##
Return the given string without space at start and end
   
    function removeNumbersInString(text)
#### Parameters:
- text: must contain the text that we want to remove numbers
Return: string



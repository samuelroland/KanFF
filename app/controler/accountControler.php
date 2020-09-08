<?php
/**
 *  Project: KanFF
 *  File: accountControler.php
 *  Author: Kevin Vaucher et Luís Pedro Pinheiro
 *  Creation date: 18.05.2020
 */

function editAccount()
{
    require_once "view/editAccount.php";
}

//This funtion will redirect to the signin page or redirect to the signin page
function signin($post)
{
    if (empty($post) == false) {    //if data have been sent
        $error = false; //no error by default

        //Get the variables, trim them and define the variables that are not sent (because not in the form)
        $newUser['username'] = trimIt($post['username']);
        $newUser['initials'] = getUniqueInitials($post['firstname'], $post['lastname']);
        $newUser['firstname'] = trimIt($post['firstname']);
        $newUser['lastname'] = trimIt($post['lastname']);
        $newUser['password'] = $post['password'];   //only to check it's not empty

        //All not null values are set so we can test if these informations are not missing:
        if (checkThatEachKeyIsNotEmpty($newUser) == false) {
            $error = 5; //data error
        }

        //Optionnals variables
        $newUser['chat_link'] = trimIt($post['chat_link']);
        $newUser['email'] = trimIt($post['email']);
        $newUser['phonenumber'] = trimIt($post['phonenumber']);
        $newUser['biography'] = trimIt($post['biography']);

        $password1 = $post['password'];
        $password2 = $post['passwordc'];

        //Generate others values:
        $newUser['inscription'] = timeToDT(time());
        $newUser['status'] = "Arrivé le " . DTToHumanDate(time(), true, "simpleday");
        $newUser['state'] = USER_STATE_UNAPPROVED;  //by default unapproved
        $newUser['password'] = password_hash($post['password'], PASSWORD_DEFAULT);

        //Check initials if error has occured:
        if ($newUser['initials'] == false) {    //no unique combination for initials have been found
            $error = 4; //data not unique
        }

        //Check that the 2 passwords are the same:
        if ($password1 != $password2) {
            $error = 5; //data error
        }

        //Check the Regex on it:
        if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d).{8,}$/", $password1)) {
            $error = 5; //data error
        }

        //Is username not already taken ?
        if (empty(searchUserByUsername($newUser['username'])) == false) {
            $error = 4; //data not unique
        }
        //Is email not already taken ?
        if (empty(searchUserByEmail($newUser['email'])) == false) {
            $error = 4; //data not unique
        }

        //Then depending on errors or on success:
        if ($error != false) {
            flshmsg($error);
            require "view/signin.php";  //view values sent inserted
        } else {
            createOne("users", $newUser);
            flshmsg(6);
            login($newUser['initials'], $password1);
        }
    } else {    //if no data, load the page as normal
        require "view/signin.php";
    }
}

function getUniqueInitials($firstname, $lastname)
{
    //Create initials:
    $initials = substr($firstname, 0, 1) . substr($lastname, 0, 1) . substr($lastname, strlen($lastname) - 1);
    $initials = strtoupper($initials);  //set to upper case

    //Search a user with same initials:
    $userWithSameInitials = searchUserByInitials($initials);
    if ($userWithSameInitials == null) {
        $choosedInitials = $initials;
    } else {
        //If already used, test the second rule:
        $initials = substr($firstname, 0, 1) . substr($lastname, 0, 1) . substr($lastname, 1, 1);
        $initials = strtoupper($initials);  //set to upper case
        $userWithSameInitials = searchUserByInitials($initials);
        if ($userWithSameInitials == null) {
            $choosedInitials = $initials;
        } else {
            return false;   //it's impossible to have unique initials with this user
        }
    }
    return $choosedInitials;
}

function searchUserByInitials($initials)
{
    return getByCondition("users", ["initials" => $initials], "initials =:initials", false);
}

function searchUserByUsername($username)
{
    return getByCondition("users", ["username" => $username], "username =:username", false);
}

function searchUserByEmail($email)
{
    return getByCondition("users", ["email" => $email], "email =:email", false);
}


function checkThatEachKeyIsNotEmpty($array)
{
    foreach ($array as $item) {
        if ($item == null) {
            return false;
        }
    }
    return true;
}
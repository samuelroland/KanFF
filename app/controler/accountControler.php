<?php
/**
 *  Project: KanFF
 *  File: accountControler.php
 *  Author: Kevin Vaucher et Luís Pedro Pinheiro
 *  Creation date: 18.05.2020
 */

function editAccount($post)
{
    if (empty($post) == false) {    //if data have been sent
        $error = false; //no error by default

        if (checkUserPassword($_SESSION['user']['id'], $post["password"])) {
            //Get the variables, trim them and define the variables that are not sent (because not in the form)
            $editUser['username'] = trimIt($post['username']);
            $editUser['initials'] = getUniqueInitials(trimIt($post['firstname']), trimIt($post['lastname']));
            $editUser['firstname'] = trimIt($post['firstname']);
            $editUser['lastname'] = trimIt($post['lastname']);
            $editUser['password'] = $post['newpassword'];   //only to check it's not empty

            //All not null values are set so we can test if these informations are not missing:
            if (checkThatEachKeyIsNotEmpty($editUser) == false) {
                $error = 5; //data error
            }

            //Optionnals variables
            $editUser['chat_link'] = trimIt($post['chat_link']);
            $editUser['email'] = trimIt($post['email']);
            $editUser['phonenumber'] = trimIt($post['phonenumber']);
            $editUser['biography'] = trimIt($post['biography']);
            $editUser['status'] = trimIt($post['status']);

            //Onbreak management:
            $editUser['on_break'] = chkToTinyint($post['on_break']);   //on break value from checkbox

            //TODO: check that the 2 passwords are equal that the current one is right, before make the change
            $password1 = $post['newpassword'];
            $password2 = $post['newpasswordc'];

            //Generate others values:
            $editUser['password'] = password_hash($post['newpassword'], PASSWORD_DEFAULT);

            //Check initials if error has occured:
            if ($editUser['initials'] == false) {    //no unique combination for initials have been found
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

            //Is username already taken ?
            if (empty(searchUserByUsername($editUser['username'])) == false) {
                $error = 4; //data not unique
            }
            //Is email already taken ?
            if (empty(searchUserByEmail($editUser['email'])) == false) {
                $error = 4; //data not unique
            }

            //Then depending on errors or on success:
            if ($error != false) {
                flshmsg($error);
                require "view/editAccount.php";  //view values sent inserted
            } else {
                updateOne("users", $_SESSION['user']['id'], $editUser);
                displaydebug($editUser);
                flshmsg(6);
                unset($_SESSION['user']);   // Clears the session
                login($editUser['initials'], $password1);
            }
        } else {
            flshmsg(8);
            require "view/editAccount.php";
        }

    } else {    //if no data, load the page as normal
        $user = getUserById($_SESSION['user']['id']);
        if ($user['state_modifier_id'] != null) {
            $user['state_modifier'] = getUserById($user['state_modifier_id']);  //get the user modifier
        }
        require "view/editAccount.php";
    }
}

//This funtion will redirect to the signin page or redirect to the signin page
function signin($post)
{
    if (empty($post) == false) {    //if data have been sent
        $error = false; //no error by default

        //Get the variables, trim them and define the variables that are not sent (because not in the form)
        $newUser['username'] = trimIt($post['username']);
        $newUser['initials'] = getUniqueInitials(trimIt($post['firstname']), trimIt($post['lastname']));
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
        $newUser['status'] = "Arrivé.e le " . DTToHumanDate(time(), "simpleday", true);   //simple day and a timestamp is sent (not a DateTime)
        $newUser['state'] = USER_STATE_UNAPPROVED;  //by default unapproved
        $newUser['password'] = password_hash($post['password'], PASSWORD_DEFAULT);
        $newUser['on_break'] = 0;   //not on break
        $newUser['state_modifier_id'] = null;   //state not modified
        $newUser['state_modification_date'] = null;   //state not modified

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

        //Is username already taken ?
        if (empty(searchUserByUsername($newUser['username'])) == false) {
            $error = 4; //data not unique
        }
        //Is email already taken ?
        if (empty(searchUserByEmail($newUser['email'])) == false) {
            $error = 4; //data not unique
        }

        //Then depending on errors or on success:
        if ($error != false) {
            flshmsg($error);
            require "view/signin.php";  //view values sent inserted
        } else {
            createOne("users", $newUser);
            displaydebug($newUser);
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

function limitedAccessInfo()
{
    $state = $_SESSION['user']['state'];
    $user = $_SESSION['user'];
    switch ($state) {
        case USER_STATE_UNAPPROVED:
            $message = "Votre compte a été créé mais n'est pas encore approuvé et vous n'avez donc pas encore accès aux informations internes. Veuillez contacter un.e admin afin de vous faire approuver.";
            break;
        case USER_STATE_BANNED:
            $message = "Votre compte a été banni de ce collectif par un.e admin. Vous n'avez plus accès aux informations internes.";
            break;
        case USER_STATE_ARCHIVED:
            $message = "Votre compte est archivé (vous l'avez défini vous même ou alors un.e admin l'a défini). Pour désarchiver votre compte (et retrouver l'accès aux données internes), veuillez contacter un.e admin afin que votre compte soit désarchivé.";
            break;
    }
    if ($user['state_modifier_id'] != null) {
        $user['state_modifier'] = getUserById($user['state_modifier_id']);  //get the user modifier
    }
    require_once "view/limitedAccess.php";
}
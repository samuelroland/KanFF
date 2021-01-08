<?php
/**
 *  Project: KanFF
 *  File: accountControler.php file for controler functions about the management of the account of a user (login, signin, editAccount, ...)
 *  Author: Kevin Vaucher et Luís Pedro Pinheiro
 *  Creation date: 18.05.2020
 */
require "model/usersModel.php";

define("USER_PASSWORD_REGEX", "^(?=.*[A-Za-z])(?=.*\d).{8,}$"); //Regular expression for users passwords
define("USER_PASSWORD_CONDITIONS", "Le mot de passe doivent contenir: 8 caractères minimum + au moins une lettre et un chiffre");   //text explaining the conditions to create a valid password (valid with the regex)

define("USER_NAMES_REGEX", "^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð '-]{2,100}$"); //Regular expression for users names (thanks to https://stackoverflow.com/questions/2385701/regular-expression-for-first-and-last-name#answer-2385967)

function editAccount($post)
{
    $userBase = getUserById($_SESSION['user']['id']);
    $user = $userBase;
    $msg = null; //no msg by default

    if (empty($post) == false) {    //if data have been sent
        if (isAtLeastEqual("", [$post['currentpassword'], $post['newpassword'], $post['newpasswordc']]) == false) {   //if the 3 passwords are present, it's a password update
            if (checkUserPassword($_SESSION['user']['id'], $post['currentpassword'])) {   //if passwords are valid
                if (checkRegex($post['newpassword'], USER_PASSWORD_REGEX) && $post['newpassword'] == $post['newpasswordc']) {
                    if ($post['currentpassword'] == $post['newpassword']) {
                        $msg = 15;  //current password and new password can not be equal
                    } else {
                        updateOne("users", $_SESSION['user']['id'], ['password' => password_hash($post['newpassword'], PASSWORD_DEFAULT)]); //update the password
                        $msg = 14;  //update password succeed
                    }
                } else {
                    $msg = 5; //password invalid --> invalid data
                }
            } else {
                $msg = 16;   //current password is wrong
            }
        } else if (isset($post['firstname'], $post['lastname'], $post['username'], $post['status'], $post['email'], $post['phonenumber'], $post['biography'])) { //if data are set for general update

            //Get the variables, trim them and define the variables that are not sent (because not in the form)
            $editUser['username'] = trimIt($post['username']);
            $editUser['firstname'] = trimIt($post['firstname']);
            $editUser['lastname'] = trimIt($post['lastname']);

            //All not null values are set so we can test if these informations are not missing:
            if (checkThatEachKeyIsNotEmpty($editUser) == false) {
                $msg = 5; //data error
            }

            //Check the length of all strings
            if (strlen($editUser['username']) < 4 || chkLength($editUser['username'], 15) == false) {
                $msg = 5; //data error
            }
            if (chkLength($editUser['firstname'], 100) == false) {
                $msg = 5; //data error
            }
            if (chkLength($editUser['lastname'], 100) == false) {
                $msg = 5; //data error
            }
            if (chkLength($editUser['status'], 200) == false) {
                $msg = 5; //data error
            }
            if (chkLength($editUser['email'], 254) == false) {
                $msg = 5; //data error
            }
            if (chkLength($editUser['phonenumber'], 20) == false) {
                $msg = 5; //data error
            }
            if (chkLength($editUser['chat_link'], 2000) == false) {
                $msg = 5; //data error
            }
            if (chkLength($editUser['biography'], 2000) == false) {
                $msg = 5; //data error
            }

            if (checkNamesValidity($editUser['firstname']) == false || checkNamesValidity($editUser['lastname']) == false) {   //check validity of firstname and lastname
                $msg = 5; //data error
            } else {    //generate initials only if firstname and lastname are valid
                //If firstname or lastname have changed, generate initials again
                if ($editUser['firstname'] != $userBase['firstname'] || $editUser['lastname'] != $userBase['lastname']) {
                    $editUser['initials'] = getUniqueInitials($editUser['firstname'], $editUser['lastname']);
                    //Check initials if error has occurred:
                    if ($editUser['initials'] == false) {    //no unique combination for initials have been found
                        $msg = 4; //data not unique
                    }
                }
            }

            //Optionnals variables
            $editUser['chat_link'] = trimIt($post['chat_link']);
            $editUser['email'] = trimIt($post['email']);
            $editUser['phonenumber'] = trimIt($post['phonenumber']);
            $editUser['biography'] = trimIt($post['biography']);
            $editUser['status'] = trimIt($post['status']);

            if ($editUser['email'] != "" && isEmailFormat($editUser['email']) == false) {
                $msg = 5; //data error
            }

            //Onbreak management:
            if (isCheckboxValueValid($post['on_break'])) {
                $editUser['on_break'] = chkToTinyint($post['on_break']);   //on break value from checkbox
            } else {
                $msg = 5; //data error
            }

            //Is username already taken ?
            if (empty(searchUserByUsername($editUser['username'])) == false && $editUser['username'] != $userBase['username']) {
                $msg = 4; //data not unique
            }
            //Is email already taken ?
            if (empty(searchUserByEmail($editUser['email'])) == false && $editUser['email'] != $userBase['email']) {
                $msg = 4; //data not unique
            }

            if ($msg == null) {   //if no error, then update the general information
                updateOne("users", $_SESSION['user']['id'], $editUser);
                $user = getUserById($_SESSION['user']['id']);
                displaydebug($editUser);
                unset($user['password']);
                $_SESSION['user'] = $user;
                $msg = 13; //update has succeed
            }

        } else {    //if data are not valid to update password and for general update
            $msg = 5; //invalid data
        }
    } else {    //if no data, load the page as normal
        $user = getUserById($_SESSION['user']['id']);

    }

    //Final action (set flashmessage if exist and go to the view):
    if ($msg != null) {
        flshmsg($msg);
    }
    $user = userItemLoadExtraFields($user);
    require "view/editAccount.php"; //in all cases, the view will be displayed (independently of all possibles errors or content of $user)
}

//Load extra field for a user (state modifier)
function userItemLoadExtraFields($user)
{
    if ($user['state_modifier_id'] != null) {
        $user['state_modifier'] = getUserById($user['state_modifier_id']);  //get the user modifier
    }
    return $user;
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
        $newUser['status'] = "Arrivé·e le " . DTToHumanDate(time(), "simpleday", true);   //simple day and a timestamp is sent (not a DateTime)
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
    $firstname = replaceAccentChars($firstname);
    $lastname = replaceAccentChars($lastname);
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
            $message = "Votre compte a été créé mais n'est pas encore approuvé et vous n'avez donc pas encore accès aux informations internes. Veuillez contacter un·e admin afin de vous faire approuver.";
            break;
        case USER_STATE_BANNED:
            $message = "Votre compte a été banni de ce collectif par un·e admin. Vous n'avez plus accès aux informations internes.";
            break;
        case USER_STATE_ARCHIVED:
            $message = "Votre compte est archivé (vous l'avez défini vous même ou alors un·e admin l'a défini). Pour désarchiver votre compte (et retrouver l'accès aux données internes), veuillez contacter un·e admin afin que votre compte soit désarchivé.";
            break;
    }
    if ($user['state_modifier_id'] != null) {
        $user['state_modifier'] = getUserById($user['state_modifier_id']);  //get the user modifier
    }
    require_once "view/limitedAccess.php";
}

// This funtion will try to Login Using the provided data
function login($infoLogin, $password)
    // If trying to login it checks the data, else load the page
{
    if ($infoLogin != "") {
        $infoLogin = trimIt($infoLogin);
        if (strlen($infoLogin) == 3) {// If the infoLogin is initials, then convert it to upper case
            $infoLogin = strtoupper($infoLogin);
        }
        $UserLog = getUser($infoLogin);
        if (password_verify($password, $UserLog['password'])) {
            unset($UserLog['password']);    // Unset password to not save it in the session
            $_SESSION['user'] = $UserLog;   // Save all informations of the users in the session
            displaydebug($_SESSION);    // Function that will display a var_dump if the debug mode is active
            if (checkLimitedAccess()) {
                limitedAccessInfo();    //go directly to limited access info page
            } else {
                dashboard();    //go to default page if has no limitation of access
            }

        } else {
            flshmsg(1);
            require_once 'view/login.php';
        }
    } else {
        require_once 'view/login.php';
    }
}

// Function to logout the user from de current session
function logout()
{
    unset($_SESSION['user']);   // Clears the session
    unset($_SESSION['feedback']);   // Unset feedback data
    login(null, null);
}

function deleteAccount($post)
{
    defineConstantsSentences();
    if (empty($post)) {
        //display the view if no data
        $option = "delete";
        require_once "view/bigActionOnAccount.php";
    } else {
        checkRightForCallFlashMessagesDeleteArchive($post,"delete");
    }
}

function archiveAccount($post)
{
    defineConstantsSentences();
    if (checkUserHasRightsForBigActionOnAccount()) {// Check if user can archive his account
        if (empty($post)) {
            //display the view if no data
            $option = "archive";
            require_once "view/bigActionOnAccount.php";
        } else {
            checkRightForCallFlashMessagesDeleteArchive($post,"archive");
        }
    } else {
        limitedAccessInfo();
    }
}


//check creditential to call flashmessages for delete and archive
function checkRightForCallFlashMessagesDeleteArchive($post,$option){
    if ($option=="delete"){
        $textToCopy=USER_SENTENCES_DELETE["textToCopy"];
    }else{
        $textToCopy=USER_SENTENCES_ARCHIVE["textToCopy"];
    }
    $userid = $_SESSION["user"]["id"];
    //check if textToCopy is correctly copied and if password send is the one
    if ($post["sentence"] == $textToCopy && checkUserPassword($userid, $post["password"])) {
        switch ($option) {//success messages for delete or archive account
            case "delete":
                deleteUser($userid);
                unset($_SESSION['user']);
                flshmsg(18);
                login(null, null);
                break;
            case "archive":
                flshmsg(19);
                archiveUser($userid);
                limitedAccessInfo();
                break;
        }


    } else {
        if ($post["sentence"] == $textToCopy) {
            flshmsg(8);
        }
        elseif (checkUserPassword($_SESSION["user"]["id"], $post["password"])) {
            flshmsg(17);
        }
        elseif (!checkUserPassword($_SESSION["user"]["id"], $post["password"])&&$post["sentence"] != $textToCopy) {
            flshmsg(17);
            flshmsg(8);
        }

        require_once "view/bigActionOnAccount.php";
    }//if sentence or password isn't correct
}
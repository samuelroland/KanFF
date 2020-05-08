<?php
/**
 *  Project: KanFF
 *  File: Help.php controler for generating common contents
 *  Author: Samuel Roland
 *  Creation date: 26.04.2020
 */

//Fonction qui nous permets de Créer un compte et e stocker dans la base de données
//This funtion will redirect to de signin page

function signin($firstname, $lastname, $initials, $username, $password, $password2, $email, $phoneNumber, $bio)
{

    // If trying to create an account, else load the page
    if ($username != "" || $email != "")
    {
        // Checks if password and password2 are equal
        if ($password == $password2)
        {
            // Hash the password for higher security
            $hash = password_hash($password, PASSWORD_DEFAULT);

           /* if (getUser($username) != '')
            {
                $_SESSION['error'] = 2;
                require_once 'app/view/signin.php';
            }*/
            //addUser($firstname, $lastname, $initials, $username, $hash, $email, $phoneNumber, $bio);
        }
        else{
            $_SESSION['error'] = 2;
            require_once 'app/view/signin.php';
        }
    }else{
        echo ("bug");
        require_once 'app/view/signin.php';
    }
}

function login()
{

    require_once 'app/view/login.php';
}
//This funtion will try to Login Using the provided data
function tryLogin(){

    //Pour Luis

}

//This funtion will try to signin and create the data in the BD
function trySignin()
{
    // le if est encore a voir vu qu'on a pas de BD encore
    if (isset($_POST["user"]) && isset($_POST["password"]) && isset($_POST["email"])  != "" && $_POST["user"] != "" && $_POST["password"] != "" && $_POST["email"] != "") {


        $liste = getLogs();
        $Lastid = 0;
        foreach ($liste as $user) {
            $id = $user["id"];

            if ($id > $Lastid) {
                $Lastid = $id;
            }
        }
        $Lastid++;
        $liste[] = ["id" => $Lastid, "user" => $_POST["user"], "password" => $_POST["password"],"email" => $_POST["email"]];
        createLogs($liste);
    }
    // il faut encore créer la page d'inscription
    require_once 'app/view/signin.php';
    $_POST["user"] = null;
    unset($_POST["password"]);
}
//This funtion will try to Logout from de current session
function Logout(){

    require_once 'app/view/home.php';

}

function tryLogout(){

    //Faire avec Luis

}

?>

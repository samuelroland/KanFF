<?php
/**
 *  Project: KanFF
 *  File: Help.php controler for generating common contents
 *  Author: Samuel Roland
 *  Creation date: 26.04.2020
 */

//Fonction qui nous permets de Créer un compte et e stocker dans la base de données
//This funtion will redirect to de signin page
function signin()
{

    require_once 'app/view/signin.php';
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
?>

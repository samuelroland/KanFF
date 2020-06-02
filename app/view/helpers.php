<?php
/**
 *  Project: KanFF
 *  File: helpers.php view for generating common contents. linked to Help.php
 *  Author: Team
 *  Creation date: 26.04.2020
 */

//get the flashmessage with the messageid stored in the session.
function flashMessage()
{
    //TODO: export list of message in a json file for separate languages
    if (isset($_SESSION["flashmsg"])) { //if flashmessage exists
        switch ($_SESSION['flashmsg']) {
            case 1: //erreur identifiants
                $message = "Les identifiants de connexion ne concordent pas. Veuillez retenter la connexion.";
                break;
            case 2: //erreur email déjà pris
                $message = "Cet email est déjà utilisé par un autre utilisateur... Veuillez recommencer avec un autre email.";
                break;
            case 3: //erreurs de permissions en cas de bidouille des formulaires.
                $message = "Action non autorisée avec ces permissions... mêlez vous de vos oignons.";
                break;
        }
        $content = "<div id='flashmessage' class='alert alert-dark bg-info'>" . $message . "</div>";
    }
    unset($_SESSION["flashmessage"]);   //après avoir affiché le message, le message ne doit pas réapparaitre.
    return $content;
}

//display a var (with var_dump()) for debug, only if debug mode is enabled
function displaydebug($var)
{
    require ".const.php";   //get the $debug variable
    if ($debug == true) {   //if debug mode enabled
        var_dump($var);
    }
}

?>
<?php
/**
 *  Project: KanFF
 *  File: messages.php the messages displayed after actions
 *  Author: Team
 *  Creation date: 13.01.2021
 */

//Messages at the top of the gabarit or in the views (displayed through the session):

//COMMON for the whole app (not related to a page or table of the db)
define("COMMON_404", "Page demandée inconnue... Vous avez été redirigé vers le dashboard.");
define("COMMON_INVALID_DATA_SENT", "Données invalides. Veuillez retenter.");
define("COMMON_MISSING_DATA_SENT", "Données manquantes. Veuillez retenter.");
define("COMMON_ACTION_DENIED", "Action non autorisée avec ces permissions.");
define("COMMON_ACTION_DENIED_BECAUSE_NOT_ADMIN", "Action non autorisée car vous n'êtes pas admin.");
define("COMMON_CONFIRMATION_PWD_ERROR", "Mot de passe de confirmation pour une action importante erroné. Veuillez retenter.");
define("COMMON_VALIDATION_SENTENCE_ERROR", "La phrase de vérification insérée n'est pas correcte.... Veuillez ressayer");

//USERS
define("LOGIN_FAIL", "Les identifiants de connexion ne concordent pas. Veuillez retenter la connexion.");
define("SIGNIN_EMAIL_NOT_UNIQUE", "Cet email est déjà utilisé par un autre utilisateur... Veuillez recommencer avec un autre email.");
define("SIGNIN_SOME_FIELDS_NOT_UNIQUE", "Les initiales, l'email ou le nom d'utilisateur, est déjà utilisé par un autre utilisateur... Veuillez utiliser des données différentes.");
define("SIGNIN_SUCCESS", "Votre compte a été créé avec succès! Vous avez été directement connecté à votre compte.");
define("MYACCOUNT_SUCCESS", "Informations du compte mises à jour.");
define("MYACCOUNT_UPDATE_PWD_SUCCESS", "Mot de passe mis à jour.");
define("MYACCOUNT_UPDATE_PWD_FAIL_SAME", "Echec de mise à jour du mot de passe. Le nouveau mot de passe doit être différent de l'ancien.");
define("MYACCOUNT_UPDATE_PWD_FAIL_BAD_CURRENT", "Echec de mise à jour du mot de passe. Le mot de passe actuel est erroné.");
define("DELETEACCOUNT_SUCCESS", "Votre compte à été supprimé avec succès!");
define("ARCHIVEACCOUNT_SUCCESS", "Votre compte à été archivé avec succès!");

//JOIN

//GROUPS
define("CREATEAGROUP_SUCCESS", "Le groupe a été créé avec succès. Vous l'avez rejoint automatiquement.");

//PARTICIPATE


//PROJECTS
define("CREATEAPROJECT_SUCCESS", "Votre projet a été créé avec succès!");

//WORKS

//TASKS

//LOG


//--------------------------------------------
//Messages for Ajax calls:

//COMMON for the whole app (not related to a page or table of the db)
define("COMMON_ACTION_DENIED_LOGGED_OUT", "Vous êtes déconnecté·e, l'action est interdite.");
define("COMMON_ACTION_DENIED_LIMITED_ACCESS", "Vous êtes en accès limité, l'action est interdite.");
define("COMMON_ACTION_UNKNOWN", "L'action demandée n'existe pas.");

//USERS
define("USER_STATE_UPDATE_FAIL_ADMINS_MIN", "Ce changement d'état est impossible car il doit rester au moins {nbadmins} {adminOrAdmins} dans le collectif.");
define("USER_STATE_UPDATE_COMBINATION_DENIED", "Impossible de changer vers cet état-là.");
define("USER_STATE_UPDATE_PWD_EDITION_MODE_FAIL", "Mot de passe pour activer le mode édition erroné");
define("USER_STATE_SUCCESS", "Etat de {fullname} changé en {state}");
define("UPDATESTATUS_SUCCESS", "Statut modifié.");
define("UPDATESTATUS_SUCCESS_EMPTIED", "Statut vidé.");
define("DELETEUNAPPROVEDUSER_SUCCESS", "Le compte de {fullname} a bien été supprimé.");
define("DELETEUNAPPROVEDUSER_FAIL", "Erreur interne. Echec de la suppression dans la base de données.");

//JOIN

//GROUPS

//PARTICIPATE

//PROJECTS

//WORKS

//TASKS
define("CREATEATASK_SUCCESS", "Tâche {number} créée avec succès.");
define("UPDATEATASK_SUCCESS", "Tâche {number} mise à jour.");
define("DELETEATASK_SUCCESS", "Tâche {number} supprimée avec succès.");

//LOG

//FEEDBACK
define("SENDFEEDBACK_SUCCESS", "Feedback envoyé.");
define("SENDFEEDBACK_INVALID_DATA_SENT", "Données invalides. Echec d'envoi du feedback.");
define("SENDFEEDBACK_INVALID_EMAILS_CONFIGURATION", "Mauvaise configuration côté serveur pour l'envoi de feedback. Contacter l'admin de l'instance.");

?>
<?php
/**
 *  Project, KanFF
 *  File, messages.php the messages displayed in the app (after actions)
 *  Author, Team
 *  Creation date, 13.01.2021
 */

//Messages at the top of the gabarit or in the views (displayed through the session):
define("COMMON_404", "Page demandée inconnue... Vous avez été redirigé vers le dashboard.");
define("LOGIN_FAIL", "Les identifiants de connexion ne concordent pas. Veuillez retenter la connexion.");
define("SIGNIN_EMAIL_NOT_UNIQUE", "Cet email est déjà utilisé par un autre utilisateur... Veuillez recommencer avec un autre email.");
define("SIGNIN_SOME_FIELDS_NOT_UNIQUE", "Les initiales, l'email ou le nom d'utilisateur, est déjà utilisé par un autre utilisateur... Veuillez utiliser des données différentes.");
define("SIGNIN_SUCCESS", "Votre compte a été créé avec succès! Vous avez été directement connecté à votre compte.");
define("CREATEAPROJECT_SUCCESS", "Votre projet a été créé avec succès!");
define("COMMON_INVALID_DATA_SENT", "Données invalides. Veuillez retenter.");
define("COMMON_ACTION_DENIED", "Action non autorisée avec ces permissions.");
define("COMMON_CONFIRMATION_PWD_ERROR", "Mot de passe de confirmation pour une action importante erroné. Veuillez retenter.");
define("MYACCOUNT_SUCCESS", "Informations du compte mises à jour.");
define("MYACCOUNT_UPDATE_PWD_SUCCESS", "Mot de passe mis à jour.");
define("MYACCOUNT_UPDATE_PWD_FAIL_SAME", "Echec de mise à jour du mot de passe. Le nouveau mot de passe doit être différent de l'ancien.");
define("MYACCOUNT_UPDATE_PWD_FAIL_BAD_CURRENT", "Echec de mise à jour du mot de passe. Le mot de passe actuel est erroné.");
define("COMMON_VALIDATION_SENTENCE_ERROR", "La phrase de vérification insérée n'est pas correcte.... Veuillez ressayer");
define("DELETEACCOUNT_SUCCESS", "Votre compte à été supprimé avec succès!");
define("ARCHIVEACCOUNT_SUCCESS", "Votre compte à été archivé avec succès!");
define("CREATEAGROUP_SUCCESS", "Le groupe a été créé avec succès. Vous l'avez rejoint automatiquement.");

//Messages for Ajax calls:
define("CREATETASK_SUCCESS", "x")

?>
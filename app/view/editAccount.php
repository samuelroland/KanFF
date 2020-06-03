<?php
/**
 *  Project: KanFF
 *  File: edditAccount.php page to allow user to modify his account settings
 *  Author: Kevin Vaucher
 *  Creation date: 18.05.2020
 */
$title = "Mon compte";
ob_start();
?>
    <h1><?= $title ?></h1>
    <p>Voici les informations de votre compte sur l'instance Blason. C'est sur cette page que vous pouvez gérer votre
        compte.<br> Vous pouvez modifier vos informations pour la plupart et aussi archiver ou supprimer votre compte
        (attention supprimer est une action irréversible !)</p>
    <br>
    <form>
        <table>
            <tbody>
            <tr><b>Informations principales</b></tr>
            <tr>
                <td><label for="firstname">Prénom : </label><input value="Josette" name="firstname" type="text"
                                                                   id="firstname"></td>
            </tr>
            <tr>
                <td><label for="lastname">Lastname : </label><input value="Richard" name="lastname" type="text"
                                                                    id="lastname"></td>
            </tr>
            <tr>
                <td><label for="initials">Initiales : </label><input value="JRD" name="initials" type="text"
                                                                     id="initials"></td>
            </tr>
            <tr>
                <td><label for="registerdate">Date d'inscription : </label><input value="2020-03-02" name="registerdate"
                                                                                  type="text" id="registerdate"></td>
            </tr>
            <tr>
                <td><label for="username">Username : </label><input value="jojosette" name="username" type="text" id="username"></td>
            </tr>
            </tbody>
        </table>
        <br>
        <table>
            <tbody>
            <tr><b>Changement du mot de passe</b></tr>
            <tr>
                <td><label for="actualpassword">Actuel : </label><input value="MonMotdepa$332" name="actualpassword" type="text" id="actualpassword"></td>
            </tr>
            <tr>
                <td><label for="password">Mot de passe : </label><input value="MonMotDepa$332" name="password" type="text" id="password"></td>
            </tr>
            <tr>
                <td><label for="confirmationpassword">Confirmation : </label><input value="MonMotdepa$332" name="confirmationpassword" type="text" id="confirmationpassword"></td>
            </tr>
            </tbody>
        </table>
        <br>
        <table>
            <tbody>
            <tr><b>Champs facultatifs</b></tr>
            <tr>
                <td><label for="email">Email : </label><input value="perrick.beaujolet@hotmail.com" name="email"
                                                              type="text" id="email" size="25px"></td>
            </tr>
            <tr>
                <td><label for="phonenumber">N. Téléphone : </label><input value="0791234567" name="phonenumber"
                                                                           type="text" id="phonenumber"></td>
            </tr>
            <tr>
                <td><label for="bio">Biographie : </label><input value="Etudiant, en études d'éléctronique à l'EPFL, je milite depuis 4 ans ..." name="bio" type="text" id="bio" size="60px"></td>
            </tr>
            </tbody>
        </table>
    </form>

<?php
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>
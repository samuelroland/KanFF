<?php
/**
 *  Project: KanFF
 *  File: edditAccount.php page to allow user to modify his account settings
 *  Author: Kevin Vaucher
 *  Creation date: 18.05.2020
 */
$title = "KanFF - Modifier le compte";
ob_start();
?>

<form>
    <table>
        <tbody>
        <tr>
            <td><label for="username">Username : </label><input value="Pseudo123" name="username" type="text" id="username"></td>
        </tr>
        <tr>
            <td><label for="firstname">Firstname : </label><input value="Pierrick" name="firstname" type="text" id="firstname"></td>
        </tr>
        <tr>
            <td><label for="lastname">Lastname : </label><input value="Beaujolet" name="lastname" type="text" id="lastname"></td>
        </tr>
        <tr>
            <td><label for="email">E-mail : </label><input value="perrick.beaujolet@hotmail.com" name="email" type="text" id="email" size="25px"></td>
        </tr>
        <tr>
            <td><label for="phonenumber">Phonenumber : </label><input value="0791234567" name="phonenumber" type="text" id="phonenumber"></td>
        </tr>
        <tr>
            <td><label for="bio">Bio : </label><input value="Bonsoir." name="bio" type="text" id="bio"></td>
        </tr>
        <tr>
            <td><label for="password">Password : </label><input value="Pa$$w0rd" name="password" type="text" id="password"></td>
        </tr>
        </tbody>
    </table>
</form>

<?php
$content = ob_get_clean();
require "gabarit.php";
?>
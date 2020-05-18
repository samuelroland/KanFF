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
            <td><label for="username">Username : </label><input name="username" type="text" id="username"></td>
        </tr>
        <tr>
            <td><label for="firstname">Firstname : </label><input name="firstname" type="text" id="firstname"></td>
        </tr>
        <tr>
            <td><label for="lastname">Lastname : </label><input name="lastname" type="text" id="lastname"></td>
        </tr>
        <tr>
            <td><label for="email">E-mail : </label><input name="email" type="text" id="email"></td>
        </tr>
        <tr>
            <td><label for="phonenumber">Phonenumber : </label><input name="phonenumber" type="text" id="phonenumber"></td>
        </tr>
        <tr>
            <td><label for="bio">Bio : </label><input name="bio" type="text" id="bio"></td>
        </tr>
        <tr>
            <td><label for="password">Password : </label><input name="password" type="text" id="password"></td>
        </tr>
        </tbody>
    </table>
</form>

<?php
$content = ob_get_clean();
require "gabarit.php";
?>
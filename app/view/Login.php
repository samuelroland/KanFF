<?php
ob_start();


?>

    <div class="container">
        <h1>Login</h1>
        <form action="index.php?action=tryLogIn" method="post">
            <a>Connexion</a>
            Utilisateur ou Email <input type="text" name="user" placeholder="Username or email"  required="required" />
            <br>
            Mot de passe <input type="password" name="password" placeholder="Password" required="required" />
            <br>
            <button type="submit" class="btn btn-primary btn-block btn-large">Login</button>
            <p>Pas encore de compte sur cette instance Blason?</p>
            <p>Créez un copte et rejoignez ensuite un collectif!</p>
        </form>
    </div>
<?php
$content = ob_get_clean();
require "gabarit.php";
?>
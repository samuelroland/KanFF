<?php
ob_start();


?>

<div class="container">
    <h1>Sign In</h1>
    <form class="" action="index.php?action=tryLogIn" method="post">
        <p>Champs Requis</p>
        Nom d'utilisateur <input class="" type="text" name="user" placeholder="Username"  required="required" />
        Prénom <input type="text" name="name" placeholder="Name"  required="required" />
        Nom <input type="text" name="surname" placeholder="Surname"  required="required" />
        Initiales <input type="text" name="ini" placeholder="Initials"  required="required" />
        Mot de Passe <input type="password" name="password" placeholder="Password" required="required" />
        Mot de Passe Confirmation <input type="password" name="passwordc" placeholder="password confirmation" required="required" />
        <p>Champs facultatifs</p>
        Nom d'utilisateur <input class="" type="text" name="email" placeholder="Email"  required="required" />
        N°télephone <input class="" type="text" name="nb_phone" placeholder="Phone"  required="required" />
        Biographie <input class="" type="text" name="bio" placeholder=""  required="required" />

        <button type="submit" class="btn btn-primary btn-block btn-large">Sign In</button>
    </form>
</div>
<?php
$content = ob_get_clean();
require "gabarit.php";
?>



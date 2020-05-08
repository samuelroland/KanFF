<?php
ob_start();


?>

<div class="container">
    <h1>Sign In</h1>
        <form class="" action="index.php?action=tryLogIn" method="post">
            <h6>Informations principales:</h6>
        <div class="form-row">
            <div class="form-group col-md-6">
                Nom d'utilisateur <input class="" type="text" name="user" placeholder="Username"  required="required" />
                Prénom <input type="text" name="name" placeholder="Name"  required="required" />
            </div>

            <div class="form-group col-md-6">
                Nom <input type="text" name="surname" placeholder="Surname"  required="required" />
                Initiales <input type="text" name="ini" placeholder="Initials"  required="required" />
            </div>
        </div>
        <div class="form-group">
            Mot de Passe <input type="password" name="password" placeholder="Password" required="required" />
            Mot de Passe Confirmation <input type="password" name="passwordc" placeholder="password confirmation" required="required" />
        </div>
        <h6>Champs facultatifs:</h6>

        <div class="form-group">
            Nom d'utilisateur <input class="" type="text" name="email" placeholder="Email"  required="required" />
            N°télephone <input class="" type="text" name="nb_phone" placeholder="Phone"  required="required" />
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
            Biographie <input class="" type="text" name="bio" placeholder=""  required="required" />

            </div>
            <button type="submit" class="btn btn-primary btn-block btn-large">Création du compte</button>
            <a href="index.php?action=displayLogin"><p>Avez vous un compte? Connectez vous</p></a>
    </form>
</div>
<?php
$content = ob_get_clean();
require "gabarit.php";
?>



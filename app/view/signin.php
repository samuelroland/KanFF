<?php
ob_start();


?>
<div class="text-center"><img src="view/medias/logos/temp-logo.png" alt="logoLog" class="logoLog"> <br><span class="versiontext"></span>
<div class="container">

    <h1>Sign In</h1>
        <form class="" action="index.php?action=signin" method="post">
            <h6>Informations principales:</h6>
        <div class="form-row">
            <div class="form-group col-md-6">
                Nom d'utilisateur <input minlength="4" maxlength="20" class="" type="text" name="user" placeholder="Username"  required="required" />
                Prénom <input minlength="2" maxlength="254" type="text" name="name" placeholder="Name"  required="required" />
            </div>
            <div class="form-group col-md-6">
                Nom <input minlength="2" maxlength="254" type="text" name="surname" placeholder="Surname"  required="required" />
                Initiales <input type="text" name="ini" placeholder="Initials"  required="required" />
            </div>
        </div>
        <div class="form-group">
            Mot de Passe <input type="password" name="password" placeholder="Password" required="required" />
            Mot de Passe Confirmation <input type="password" name="passwordc" placeholder="password confirmation" required="required" />
        </div>
        <h6>Champs facultatifs:</h6>
        <div class="form-group">
            Email <input  class="" type="text" name="email" placeholder="Email"  required="required" />
            N°télephone <input class="" type="text" name="nb_phone" placeholder="Phone"  required="required" />
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">Biographie <input maxlength="254" class="" type="text" name="bio" placeholder=""  required="required" />

            <?php
                if(isset($_SESSION['error']))
                {
                    if ($_SESSION['error'] = 1)
                    {
                        echo "<br><p class='alert-warning'>Les mots de passe introduits ne se correspondent pas</p>";
                    }
                    if ($_SESSION["error"] = 2)
                    {
                        echo "<br><p class='alert-warning'>Les initiales introduites sont déjà existantes</p>";
                    }

                    unset($_SESSION['error']);
                }
            ?>

            </div>
            <button type="submit" class="btn btn-primary btn-block btn-large">Création du compte</button>
            <a href="index.php?action=login"><p>Avez vous un compte? Connectez vous</p></a>
        </div>
</form>

<?php
$content = ob_get_clean();
require "gabarit.php";
?>



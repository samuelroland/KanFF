<?php
ob_start();


?>
<div class="text-center"><img src="view/medias/logos/temp-logo.png" alt="logoLog" class="logoLog"> <br><span
            class="versiontext"></span>
    <div class="container form-group">

        <h1>Sign In</h1>
        <form style="align-self: auto" class="" action="?action=signin" method="post">
            <h5>Informations principales:</h5>
            <div class="">
                <div class=>
                    Prénom <input minlength="2" maxlength="254" type="text" name="name" placeholder="Name"
                                  required="required"/>
                </div>
                <BR>
                <div class="">
                    Nom <input minlength="2" maxlength="254" type="text" name="surname" placeholder="Surname"
                               required="required"/>
                </div>
                <BR>
                <div class="">
                    Initiales <input type="text" name="ini" placeholder="Initials" required="required"/>
                </div>
                <BR>
                <h5>Identification:<span title="Inserer le text volu" class="glyphicon glyphicon-question-sign"></span>
                </h5>
                <div class="">
                    Nom d'utilisateur <input minlength="4" maxlength="20" class="" type="text" name="user"
                                             placeholder="Username" required="required"/>
                </div>
                <BR>
                <div class="">
                    Mot de Passe <input type="password" name="password" placeholder="Password" required="required"/>
                </div>
                <BR>
                <div class="">
                    Mot de Passe Confirmation <input type="password" name="passwordc"
                                                     placeholder="password confirmation" required="required"/> <span
                            title="Inserer le text volu"
                            class="glyphicon glyphicon-question-sign"></span>
                </div>
                <BR>
                <h5>Champs facultatifs:</h5>
                <div class="">
                    Email <input class="" type="text" name="email" placeholder="Email" required="required"/>
                </div>
                <BR>
                <div class="">
                    N°télephone <input class="" type="text" name="nb_phone" placeholder="Phone" required="required"/>
                </div>
                <BR>
                <div class="">
                    <div class="">Biographie <input maxlength="254" class="" type="text" name="bio"
                                                                       placeholder="" required="required"/>

                        <?php
                        if (isset($_SESSION['error'])) {
                            if ($_SESSION['error'] = 1) {
                                echo "<br><p class='alert-warning'>Les mots de passe introduits ne se correspondent pas</p>";
                            }
                            if ($_SESSION["error"] = 2) {
                                echo "<br><p class='alert-warning'>Les initiales introduites sont déjà existantes</p>";
                            }

                            unset($_SESSION['error']);
                        }
                        ?>

                    </div>
                    <BR>
                    <button type="submit" class="btn btn-primary btn-block ">Création du compte</button>
                    <a href="/?action=login"><p>Avez vous un compte? Connectez vous</p></a>
                </div>
        </form>
    </div>
    <?php
    $content = ob_get_clean();
    require "gabarit.php";
    ?>



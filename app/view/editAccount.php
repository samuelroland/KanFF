<?php
/**
 *  Project: KanFF
 *  File: edditAccount.php page to allow user to modify his account settings
 *  Author: Kevin Vaucher
 *  Creation date: 18.05.2020
 */
//Define css classes for repetitives markups, to change it quickly
$cssForSpan = "col-md-5 col-sm-5 box-verticalaligncenter";
$cssForInput = "col-md-5 col-sm-7 form-control";
$cssForDivZone = "pl-3";
$cssForDivField = "row pt-1";

$title = "Mon compte";
ob_start();
?>
    <div class="float-left">
    <h1 class="float-left pt-4"><?= $title ?></h1>
        <BR>
    <p class="float-left">Voici les informations de votre compte sur l'instance Blason. C'est sur cette page que vous
        pouvez gérer votre compte. Vous pouvez modifier vos informations pour la plupart et aussi archiver ou supprimer
        votre compte (attention supprimer est une action irréversible!)</p>
    <div class="box-aligleft pt-4"></div>
    <div class="form-group">

        <form style="align-self: auto" class="pt-3 float-left" action="?action=signin" method="post">
            <h5 class="pt-3">Informations principales:</h5>
            <div class="<?= $cssForDivZone ?>">
                <div class="<?= $cssForDivField ?>">
                    <span class="<?= $cssForSpan ?>">Prénom</span>
                    <input class="<?= $cssForInput ?>" minlength="2" maxlength="254" type="text" name="name"
                           placeholder="Josette"
                           required/>
                </div>
                <div class=" <?= $cssForDivField ?>">
                    <span class="<?= $cssForSpan ?>">Nom</span>
                    <input class="<?= $cssForInput ?>" minlength="2" maxlength="254" type="text" name="surname"
                           placeholder="Richard" required/>
                </div>
                <div class="<?= $cssForDivField ?>">
                    <span class="<?= $cssForSpan ?>">Initiales </span>
                    <input class="<?= $cssForInput ?>" type="text" placeholder="JRD" readonly/>
                    <img title="Les initiales sont uniques et générées automatiquement donc non modifiables"
                         src="view/medias/icons/point.png" alt="50px" width="35" height="35" class="">
                </div>
                <div class="<?= $cssForDivField ?>">
                    <span class="<?= $cssForSpan ?>">Date d'inscription </span>
                    <input class="<?= $cssForInput ?>" type="date" placeholder="" readonly/>
                    <img title="Date d'inscription non modifiable"
                         src="view/medias/icons/point.png" alt="50px" width="35" height="35" class="">
                </div>

                    <div class="<?= $cssForDivField ?>">
                        <span class="<?= $cssForSpan ?>">Nom d'utilisateur/trice</span>
                        <input class="<?= $cssForInput ?>" minlength="4" maxlength="20" type="text" name="user"
                               placeholder="josette27" required/>
                    </div>

                    <div class="<?= $cssForDivField ?>">
                        <span class="<?= $cssForSpan ?>">Statut</span>
                        <span class=""><textarea style="resize: none" name="Statut" id="txtStatut" rows="2" placeholder="tbd"
                                                          class="fullwidth  form-control"
                                                          title="Votre Statut"></textarea></span>

                    </div>



                    <div class="<?= $cssForDivField ?>">
                        <span class=" <?= $cssForSpan ?>">Etat du compte </span>
                        <input class="<?= $cssForInput ?>" type="text" placeholder="Aprouvé" readonly/>
                        <img title="Cet état peut être non aprouvé, aprouvé, archivé ou admin"
                             src="view/medias/icons/point.png" alt="50px" width="35" height="35" class="">


                </div>
                <h5 class="pt-3">Changement de mot de passe:<span title="Inserer le text volu"
                                                                  class="glyphicon glyphicon-question-sign"></span>
                </h5>

                <div class="<?= $cssForDivField ?>">
                    <span class="<?= $cssForSpan ?>">Actuel</span>
                    <input class="<?= $cssForInput ?>" type="password" name="password" placeholder="" required/>
                    <img title="Iserez le mot de passe catuel" src="view/medias/icons/point.png" alt="50px" width="35"
                         height="35" class="">
                </div>
                <div class="<?= $cssForDivField ?>">
                    <span class="<?= $cssForSpan ?>">Mot de passe</span>
                    <input class="<?= $cssForInput ?>" type="password" name="password" placeholder="" required/>
                    <img title="Les critères de sécurité du mot de passe sont:
                - yy caractères
                - caractères minuscules, majuscules, spéciaux, chiffres.
                - ... TBD" src="view/medias/icons/point.png" alt="50px" width="35" height="35" class="">
                </div>

                <div class="<?= $cssForDivField ?>">
                    <span class="<?= $cssForSpan ?>">Confirmation</span>
                    <input class="<?= $cssForInput ?>" type="password" name="passwordc" placeholder="" required
                           title="Confirmation du mot de passe"/>
                    <span title="Inserer le text volu" class=" glyphicon-question-sign"></span>
                </div>
            </div>

            <h5 class="pt-3">Champs facultatifs:</h5>
            <div class="<?= $cssForDivZone ?>">
                <div class="<?= $cssForDivField ?>">
                    <span class="<?= $cssForSpan ?>">Email</span>
                    <input class="<?= $cssForInput ?>" type="email" name="email"
                           placeholder="josette.richard@assoc.ch"/>
                </div>

                <div class="<?= $cssForDivField ?>">
                    <span class="<?= $cssForSpan ?>">N°téléphone</span>
                    <input class="<?= $cssForInput ?>" type="" name="nb_phone" placeholder="Phone"/>
                </div>

                    <div class="<?= $cssForDivField ?>">
                        <span class="<?= $cssForSpan ?>">Lien messagerie instantanée</span>
                        <input class="<?= $cssForInput ?>" type="email" name="email"
                               placeholder="t.me/josette27"/>
                        <img title="Lien publique contenant votre pseudo publique. Fonctionne pour certaines messageries uniquement.
Ex: pseudo = jeanrichard alors sur Telegram: t.me/jeanrichard"
                             src="view/medias/icons/point.png" alt="50px" width="35" height="35" class="">
                    </div>


                <div class="<?= $cssForDivField ?>">

                    <span style="left: auto" class="<?= $cssForSpan ?>">Biographie</span>
                    <span class=" "><textarea  style="resize: none" id="txtBiography" rows="2" placeholder="tbd"
                                                      class=" fullwidth form-control "
                                                      title="Votre biographie"></textarea></span>

                    <?php
                    if (isset($_SESSION['error'])) {
                        if ($_SESSION['error'] == 1) {
                            echo "<br><p class='alert-warning'>Les mots de passe introduits ne se correspondent pas</p>";
                        }
                        if ($_SESSION["error"] == 2) {
                            echo "<br><p class='alert-warning'>Les initiales introduites sont déjà existantes</p>";
                        }

                        unset($_SESSION['error']);
                    }
                    ?>
                </div>
            </div>
    </div>
        <div class=" float-left">
            <p class="">Ces informations seront visibles à tous les membres approuvés de l'instance, dans le but d'avoir
                un ou des moyens de contact et une description pour les nouvelles personnes, qui ne connaissent pas les
                autres membres. </p>

            <div class=" box-alignright pt-3">
                <button type="submit" class="btn btn-primary">Enresgistrer</button>
            </div>
            <div class="float-left">
                <p class="">Zone danger - actions irréversibles ou à grosses conséquences techniques.</p>
                <div class="box-alignright pt-3">
                    <button type="submit" class="btn btn-primary">Supprimer son compte</button>
                </div>
                <div class="  box-alignright pt-3">
                    <button type="submit" class=" btn btn-primary">Archiver son compte</button>
                </div>
            </div>
        </form>
    </div>
    </div>
    </div>
<?php
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>
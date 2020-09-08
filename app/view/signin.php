<?php
ob_start();
$title = "Créer un compte";
$instanceinfos = getInstanceInfos();

//Define css classes for repetitives markups, to change it quickly
$cssForSpan = "col-md-5 col-sm-5 box-verticalaligncenter";
$cssForInput = "col-md-5 col-sm-7 form-control";
$cssForDivZone = "pl-3";
$cssForDivField = "row pt-1";
?>
<p class="aligncenter"><?= $instanceinfos['collective']['msg'] ?></p>

<div class="form-group">
    <h1 class="aligncenter"><?= $title ?></h1>
    <p>Les informations demandées permettent de vous identifier et seront visibles aux autres membres du collectif (sauf
        mot de passe). Les informations facultatives ne sont pas utile à l'application. Avant de créer un compte, vous
        pouvez vous renseigner sur <a href="/?action=about">cette instance <?= $instanceinfos['instance']['name'] ?></a>
        si besoin.</p>
    <form style="align-self: auto" class="" action="/?action=signin" method="POST">
        <h5 class="pt-3">Informations principales:</h5>
        <div class="<?= $cssForDivZone ?>">
            <div class="<?= $cssForDivField ?>">
                <span class="<?= $cssForSpan ?>">Prénom</span>
                <input id="inpFirstname" class="<?= $cssForInput ?> textFieldToCheck trimItOnChange" minlength="2"
                       maxlength="100" type="text"
                       name="firstname" placeholder="Josette" required/>
                <p id="pCounterFirstname" class="m-2"></p>
            </div>
            <div class="<?= $cssForDivField ?>">
                <span class="<?= $cssForSpan ?>">Nom</span>
                <input id="inpLastname" class="<?= $cssForInput ?> textFieldToCheck trimItOnChange" minlength="2"
                       maxlength="100" type="text"
                       name="lastname"
                       placeholder="Richard" required/>
                <p id="pCounterLastname" class="m-2"></p>
            </div>
            <div class="<?= $cssForDivField ?>">
                <span class="<?= $cssForSpan ?>">Initiales</span>
                <input id="inpInitials" class="<?= $cssForInput ?>" type="text" placeholder="JRD" readonly disabled/>
                <img title="Les initiales sont uniques et générées automatiquement.
Format: première lettre du prénom + la première lettre du nom + la dernière lettre du nom/2ème lettre du nom (en cas de conflit)."
                     src="view/medias/icons/point.png" alt="point icon" width="35" height="35" class="mr-2 ml-2">
            </div>
        </div>
        <h5 class="pt-3">Identification:
        </h5>
        <div class="<?= $cssForDivZone ?>">
            <div class="<?= $cssForDivField ?>">
                <span class="<?= $cssForSpan ?>">Nom d'utilisateur/trice</span>
                <input id="inpUsername" class="<?= $cssForInput ?> textFieldToCheck removeSpaceInRT trimItOnChange"
                       minlength="4"
                       maxlength="15" type="text"
                       name="username" pattern="^[a-zA-Z0-9_]*$"
                       placeholder="josette27" required/>
                <p id="pCounterUsername" class="m-2"></p>
            </div>

            <div class="<?= $cssForDivField ?>">
                <span class="<?= $cssForSpan ?>">Mot de passe</span>
                <input id="inpPassword1" class="<?= $cssForInput ?>" type="password" name="password" placeholder=""
                       required pattern="^(?=.*[A-Za-z])(?=.*\d).{8,}$"/>
                <img title="Les mots de passes doivent contenir:
- 8 caractères minimum
- au moins une lettre et un chiffre" src="view/medias/icons/point.png" alt="point icon" width="35" height="35" class="mr-2 ml-2">
            </div>

            <div class="<?= $cssForDivField ?>">
                <span class="<?= $cssForSpan ?>">Confirmation</span>
                <input id="inpPassword2" class="<?= $cssForInput ?>" type="password" name="passwordc" placeholder=""
                       required
                       title="Confirmation du mot de passe"/>
                <p class="errormsg" id="pErrorUsername" hidden>Le nom d'utilisateur/trice doit être alphanumérique
                    (lettre et nombres, tirets du bas acceptés).</p>
                <p class="errormsg" id="pErrorRegexPassword" hidden>Les mots de passe doivent respecter les critères de
                    sécurité (voir "?")</p>
                <p class="errormsg" id="pErrorPassword" hidden>Les 2 mots de passe doivent être
                    identiques.</p>
            </div>
        </div>

        <h5 class="pt-3">Champs facultatifs:</h5>
        <div class="<?= $cssForDivZone ?>">
            <div class="<?= $cssForDivField ?>">
                <span class="<?= $cssForSpan ?>">Email</span>
                <input class="<?= $cssForInput ?> removeSpaceInRT trimItOnChange" type="email" name="email" minlength="5" maxlength="254"
                       placeholder="josette.richard@assoc.ch"/>
            </div>

            <div class="<?= $cssForDivField ?>">
                <span class="<?= $cssForSpan ?>">N°téléphone</span>
                <input class="<?= $cssForInput ?> trimItOnChange" type="string" name="phonenumber" placeholder="+41 088 965 35 56"
                       minlength="4" maxlength="20"/>
            </div>

            <div class="<?= $cssForDivField ?>">
                <span class="<?= $cssForSpan ?>">Lien messagerie instantanée</span>
                <input class="<?= $cssForInput ?> trimItOnChange" type="text" name="chat_link" placeholder="t.me/josette27"/>
                <img title="Lien publique contenant votre pseudo publique. Fonctionne pour certaines messageries uniquement.
Ex: pseudo = jeanrichard alors sur Telegram: t.me/jeanrichard" src="view/medias/icons/point.png" alt="point icon"
                     width="35" height="35" class="mr-2 ml-2">
            </div>

            <div class="<?= $cssForDivField ?>">
                <span class="<?= $cssForSpan ?>">Biographie</span>
                <span class="fullwidth col-lg-12">
                    <textarea name="biography" id="txtBiography" rows="4" maxlength="2000"
                              placeholder="Dans le milieu associatif, depuis 10 ans déjà, je suis à dans Assoc depuis 2015 et j'aide plusieurs heures par semaines. La partie contact médias m'intéresse beaucoup. Je suis photographe de métier, mais aussi céramiste et je cultive un petit potager..."
                              class="fullwidth form-control textFieldToCheck trimItOnChange"
                              title="Votre biographie"></textarea>
                </span>
                <p id="pCounterBiography" class="mt-2 mb-2 col-lg-12"></p>
            </div>

        </div>
        <?= flashMessage(); ?>
        <div class="vertical-center box-alignright pt-3">
            <button type="submit" class="btn btn-primary" id="inpSubmit">Création du compte</button>
        </div>

    </form>
    <p class="flex-1 nomargin">Déjà un compte ? <a href="/?action=login">Connexion.</a></p>
</div>

<?php
$contenttype = "restricted";
$content = ob_get_clean();

require "gabarit.php";
?>



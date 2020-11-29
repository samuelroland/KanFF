<?php
/**
 *  Project: KanFF
 *  File: edditAccount.php page to allow user to modify his account settings
 *  Author: Kevin Vaucher
 *  Creation date: 18.05.2020
 */
//Define css classes for repetitives markups, to change it quickly
$cssForSpan = "col-md-5 col-sm-5 box-verticalaligncenter spanForForm";
$cssForInput = "col-md-5 col-sm-7 form-control inputForForm";
$cssForDivZone = "pl-3";
$cssForDivField = "row pt-1";
$title = "Mon compte";

$instanceinfos = getInstanceInfos();
$instance = $instanceinfos['instance'];

$list = "";

foreach (USER_LIST_STATE as $state) {
    $statesInLangage[] = convertUserState($state);    //preparation of states in language (not in int)
}
$list = implode(", ", $statesInLangage) . ".";  //implode the array of state in language with ", " as glue
if (empty($data) == false) {    //if data has been sent
    $user = array_merge($user, $data);
}
ob_start();
?>
    <div class="<?= $cssForDivZone ?>">
        <div class="">
            <div class="flexdiv">
                <h1 class="flex-1"><?= $title ?></h1>
                <div class="flex-1 d-block">
                    <button class="btn btn-primary float-right clickable" data-href="?action=about">Détails de
                        l'instance <?= $instance['name'] ?></button>
                </div>
            </div>
            <p class="">Voici les informations de votre compte sur l'instance <?= $instance['name'] ?>. Vous pouvez
                gérer votre compte mais aussi archiver ou
                supprimer votre compte.</p>
            <?php printPageWIPTextInfo(); ?>

            <form class="pt-1" action="?action=editAccount" method="POST">
                <hr class="hrlight">
                <h4>Informations principales</h4>
                <div class="<?= $cssForDivField ?>">
                    <span class="<?= $cssForSpan ?>">Prénom</span>
                    <input id="inpFirstname"
                           class="<?= $cssForInput ?> textFieldToCheck counterVisibleOnlyIfFastMaxLength trimItOnChange"
                           minlength="2"
                           maxlength="75" type="text"
                           name="firstname" placeholder="Josette" required value="<?= $user['firstname'] ?>"/>
                    <p id="pCounterFirstname" class="m-2"></p>
                </div>

                <div class=" <?= $cssForDivField ?>">
                    <span class="<?= $cssForSpan ?>">Nom</span>
                    <input id="inpLastname"
                           class="<?= $cssForInput ?> textFieldToCheck counterVisibleOnlyIfFastMaxLength trimItOnChange"
                           minlength="2"
                           maxlength="75" type="text"
                           name="lastname"
                           placeholder="Richard" required value="<?= $user['lastname'] ?>"/>
                    <p id="pCounterLastname" class="m-2"></p>
                </div>
                <div class="<?= $cssForDivField ?>">
                    <span class="<?= $cssForSpan ?>">Initiales </span>
                    <input class="<?= $cssForInput ?>" type="text" value="<?= $user['initials'] ?>" readonly
                           disabled/>
                    <?= createToolTipWithPoint("Les initiales sont générées automatiquement et non modifiables.", "icon-middlesmall ml-2 mr-2 m-2", false, "right") ?>
                </div>
                <div class="<?= $cssForDivField ?>">
                    <span class="<?= $cssForSpan ?>">Date d'inscription </span>
                    <input class="<?= $cssForInput ?>" type="date"
                           value="<?= date("Y-m-d", strtotime($user['inscription'])) ?>" readonly disabled/>
                    <?= createToolTipWithPoint("La date d'inscription sur cette instance est non modifiable.", "icon-middlesmall ml-2 mr-2 m-2", false, "right"); ?>

                </div>

                <div class="<?= $cssForDivField ?>">
                    <span class="<?= $cssForSpan ?>">Nom d'utilisateur·ice</span>
                    <input id="inpUsername"
                           class="<?= $cssForInput ?> textFieldToCheck removeSpaceInRT trimItOnChange"
                           minlength="4"
                           maxlength="15" type="text"
                           name="username" pattern="^[a-zA-Z0-9_]*$"
                           placeholder="josette27" required value="<?= $user['username'] ?>"/>
                    <p id="pCounterUsername" class="m-2"></p>
                </div>

                <div class="<?= $cssForDivField ?>">
                    <span class="<?= $cssForSpan ?>">Statut</span>
                    <div class="spanTextArea">
                        <div class="flexdiv">
                        <textarea name="status" id="txtStatut" rows="2"
                                  placeholder="Exemple: Cette semaine, je suis très investie dans le crowdfunding et la gestion des emails. L'effort à fournir est important mais ça me plaît."
                                  maxlength="200"
                                  class="flex-1 fullwidth form-control textFieldToCheck trimItOnChange d-inline"
                                  title="Statut"><?= $user['status'] ?></textarea>
                            <?= createToolTipWithPoint("Votre statut est une information courte qui peut changer régulièrement, et qui explique en quelques phrases ce que vous faites ces temps-ci au sein du collectif.", "icon-middlesmall ml-2 mr-2 m-2", false, "right") ?>
                        </div>
                        <p id="pCounterStatus" class="mt-2 mb-2"></p>
                    </div>
                </div>


                <div class="<?= $cssForDivField ?>">
                    <span class=" <?= $cssForSpan ?>">Etat du compte </span>
                    <input class="<?= $cssForInput ?>" type="text" readonly disabled
                           value="<?= convertUserState($user['state']) ?>"/>
                    <?= createToolTipWithPoint("Cet état peut être: " . $list, "icon-middlesmall ml-2 mr-2 m-2", false, "right") ?>

                </div>
                <div class="<?= $cssForDivField ?>">
                    <span class=" <?= $cssForSpan ?>">Changement d'état</span>
                    <span class=" <?= $cssForSpan ?> col-md-5 col-sm-7 d-block" type="text" readonly><?php
                        if ($user['state_modification_date'] != null || $user['state_modifier_id'] != null) {
                            echo "Défini comme " . convertUserState($user['state']);
                            if ($user['state_modification_date'] != null) {
                                echo " le " . DTToHumanDate($user['state_modification_date'], "simpletime");
                            }
                            if ($user['state_modifier_id'] != null) {
                                echo " par " . mentionUser($user['state_modifier']);
                            }
                        } else {
                            echo "Aucun changement d'état pour l'instant.";
                        }

                        ?></span>
                    <div class="">
                        <?= createToolTipWithPoint("Information concernant le dernier changement d'état", "icon-middlesmall ml-2 mr-2 m-2", false, "right") ?>
                    </div>
                </div>

                <div class="<?= $cssForDivField ?>">
                    <span class=" <?= $cssForSpan ?>">En pause</span>
                    <div class="col-md-5 col-sm-7 box-aligncenter inputForForm">
                        <input type="checkbox" name="on_break"
                               id="inpOnBreak" <?= ($user['on_break'] == 1) ? "checked" : "" ?>/>
                    </div>

                    <?= createToolTipWithPoint("Se mettre en pause indique que vous n'êtes plus disponible pour le collectif, mais ne vous restreint pas dans l'utilisation. Vous serez sous 'En pause' dans la page membres.
Vous pouvez laisser une information dans votre statut concernant la raison de votre pause et la date de votre retour.", "icon-middlesmall ml-2 mr-2 m-2", false, "right") ?>

                </div>

                <h4 class="pt-3">Champs facultatifs</h4>

                <div class="<?= $cssForDivField ?>">
                    <span class="<?= $cssForSpan ?>">Email</span>
                    <input class="<?= $cssForInput ?>" type="email" name="email"
                           placeholder="josette.richard@assoc.ch" value="<?= $user['email'] ?>" maxlength="254"/>
                </div>

                <div class="<?= $cssForDivField ?>">
                    <span class="<?= $cssForSpan ?>">N° de téléphone</span>
                    <input class="<?= $cssForInput ?>" type="text" name="phonenumber" minlength="4" maxlength="20"
                           value="<?= $user['phonenumber'] ?>"/>
                </div>

                <div class="<?= $cssForDivField ?>">
                    <span class="<?= $cssForSpan ?>">Lien messagerie instantanée</span>
                    <input class="<?= $cssForInput ?>" type="text" name="chat_link"
                           placeholder="t.me/josette27" value="<?= $user['chat_link'] ?>" maxlength="2000"/>
                    <?= createToolTipWithPoint("Lien permettant de vous écrire en privé via la messagerie instanée de votre collectif.", "icon-middlesmall ml-2 mr-2 m-2", false, "right") ?>

                </div>


                <div class="<?= $cssForDivField ?>">
                    <span class="<?= $cssForSpan ?>">Biographie</span>
                    <div class="spanTextArea">
                        <div class="flexdiv">
                        <textarea name="biography" id="txtBiography" rows="5"
                                  maxlength="2000"
                                  placeholder="Exemple: Dans le milieu associatif, depuis 10 ans déjà, je suis à dans Assoc depuis 2015 et j'aide plusieurs heures par semaines. La partie contact médias m'intéresse beaucoup. Je suis photographe de métier, mais aussi céramiste et je cultive un petit potager... J'ai rejoins Assoc parce que mes idées sont très proches de ce collectif."
                                  class="fullwidth form-control textFieldToCheck trimItOnChange flex-1"
                                  title="Votre biographie"><?= $user['biography'] ?></textarea>
                            <?= createToolTipWithPoint("La biographie décrit en quelques mots qui vous êtes, ce qui vous intéresse dans ce collectif et pourquoi vous l'avez rejoint.", "icon-middlesmall ml-2 mr-2 m-2", false, "right") ?>
                        </div>
                        <p id="pCounterBiography" class="mt-2 mb-2"></p>
                    </div>

                </div>
                <p class="">Ces informations (mot de passe et changement d'état exclus) sont visibles à l'entièreté des
                    membres du collectif de l'instance. Les champs facultatifs donne un moyen de contact aux autres
                    membres.</p>
                <div data-href="?action=editAccount" class="clickable btn btn-light">Annuler</div>
                <button type="submit" data-href="?action=editAccount" class="btn btn-primary">Enregistrer</button>
            </form>


            <form action="?action=editAccount" class="formCheckNoErrorMessages" id="frmUpdatePassword" method="POST">
                <div class="pt-3">
                    <hr class="hrlight">
                    <h4>Changement du mot de passe</h4>
                    <span>Le nouveau mot de passe doit être différent de l'actuel.</span>
                    <div class="<?= $cssForDivField ?>">
                        <span class="<?= $cssForSpan ?>">Mot de passe actuel</span>
                        <input class="<?= $cssForInput ?>" type="password" name="currentpassword" placeholder=""
                               required
                               title="Mot de passe actuel"/>
                    </div>

                    <div class="<?= $cssForDivField ?>">
                        <span class="<?= $cssForSpan ?>">Nouveau mot de passe</span>
                        <input class="<?= $cssForInput ?> passToCheckWithPattern" type="password"
                               data-msg-id="pErrorNewPasswordC" name="newpassword" id="newFirstPassword" placeholder=""
                               required
                               pattern="<?= USER_PASSWORD_REGEX ?>"
                               title="Nouveau mot de passe"/>
                        <?= createToolTipWithPoint(USER_PASSWORD_CONDITIONS, "icon-middlesmall ml-2 mr-2 m-2", false, "right") ?>
                    </div>

                    <div class="<?= $cssForDivField ?>">
                        <span class="<?= $cssForSpan ?>">Confirmation</span>
                        <input class="<?= $cssForInput ?> secondValueIdenticalToCheck" type="password"
                               name="newpasswordc" data-firstvalue="newFirstPassword" data-dontdisplayifempty="true"
                               data-msg-id="pError2DifferentPasswords" placeholder="" required
                               pattern="<?= USER_PASSWORD_REGEX ?>"
                               title="Confirmation du nouveau mot de passe"/>
                        <?= createToolTipWithPoint("Le nouveau mot de passe doit être confirmé pour éviter les fautes de frappes.", "icon-middlesmall ml-2 mr-2 m-2", false, "right") ?>
                    </div>

                    <p class="errormsg mt-2" id="pErrorNewPasswordC" hidden>Les mots de passe doivent respecter les
                        critères de sécurité (voir "?")</p>
                    <p class="errormsg mt-2" id="pError2DifferentPasswords" hidden>Les mots de passe doivent être
                        identiques</p>
                </div>
                <div class="pt-3">
                    <button type="submit" class="btn btn-primary">Changer</button>
                </div>
            </form>


            <div class="pt-3">
                <hr class="hrlight">
                <h4 class="d-inline text-danger">Zone danger</h4>
                <div class="  pt-3">
                    <button type="submit" class=" btn btn-dark">Archiver mon compte...</button>
                </div>
                <div class=" pt-3">
                    <button type="submit" class="btn btn-dark">Supprimer mon compte...</button>
                </div>
            </div>

        </div>
    </div><br><br>

<?php
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>
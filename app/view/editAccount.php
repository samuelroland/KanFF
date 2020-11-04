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
ob_start();
?>
    <div class="<?= $cssForDivZone ?>">
    <div class="">
        <div class="flexdiv">
            <h1 class="flex-1"><?= $title ?></h1>
            <div class="flex-1 d-block">
                <button class="btn btn-primary float-right clickable" data-href="?action=about">Détails de cette instance <?=$instance['name']  ?></button>
            </div>
        </div>
        <p class="">Voici les informations de votre compte sur l'instance Blason. C'est sur cette page que vous
            pouvez gérer votre compte. Vous pouvez modifier vos informations pour la plupart et aussi archiver ou
            supprimer
            votre compte (attention supprimer est une action irréversible!)</p>
        <?php printPageWIPTextInfo(); ?>
        <div class="form-group">
            <form class="" action="?action=signin" method="post">
                <h5 class="pt-3">Informations principales:</h5>
                    <div class="<?= $cssForDivField ?>">
                        <span class="<?= $cssForSpan ?>">Prénom</span>
                            <input id="inpFirstname" class="<?= $cssForInput ?> textFieldToCheck trimItOnChange" minlength="2"
                                   maxlength="75" type="text"
                                   name="firstname" placeholder="Josette" required value="<?= $user['firstname'] ?>"/>
                            <p id="pCounterFirstname" class="m-2"></p>
                        </div>


                    <div class=" <?= $cssForDivField ?>">
                        <span class="<?= $cssForSpan ?>">Nom</span>
                        <input id="inpLastname" class="<?= $cssForInput ?> textFieldToCheck trimItOnChange" minlength="2"
                               maxlength="75" type="text"
                               name="lastname"
                               placeholder="Richard" required value="<?= $user['lastname'] ?>"/>
                        <p id="pCounterLastname" class="m-2"></p>
                    </div>
                    <div class="<?= $cssForDivField ?>">
                        <span class="<?= $cssForSpan ?>">Initiales </span>
                        <input class="<?= $cssForInput ?>" type="text" value="<?= $user['initials'] ?>" readonly
                               disabled/>
                        <?= createToolTip(printAnIcon("point.png", "", "question mark icon", "icon-small ml-2 mr-2 m-2", false), "Généreées automatiquement et donc non modifiables", false) ?>
                    </div>
                    <div class="<?= $cssForDivField ?>">
                        <span class="<?= $cssForSpan ?>">Date d'inscription </span>
                        <input class="<?= $cssForInput ?>" type="date"
                               value="<?= date("Y-m-d", strtotime($user['inscription'])) ?>" readonly disabled/>
                        <?= createToolTip(printAnIcon("point.png", "", "question mark icon", "icon-small ml-2 mr-2 m-2", false), "Date d'inscription sur cette instance non modifiable", false) ?>

                    </div>

                    <div class="<?= $cssForDivField ?>">
                        <span class="<?= $cssForSpan ?>">Nom d'utilisateur/trice</span>
                        <input id="inpUsername" class="<?= $cssForInput ?> textFieldToCheck removeSpaceInRT trimItOnChange"
                               minlength="4"
                               maxlength="15" type="text"
                               name="username" pattern="^[a-zA-Z0-9_]*$"
                               placeholder="josette27" required value="<?= $user['username'] ?>"/>
                        <p id="pCounterUsername" class="m-2"></p>
                    </div>

                    <div class="<?= $cssForDivField ?>">
                        <span class="<?= $cssForSpan ?>">Statut</span>
                        <span class="spanTextArea"><textarea name="Statut" id="txtStatut" rows="2" placeholder="tbd" maxlength="200"
                                                             class=" fullwidth form-control textFieldToCheck trimItOnChange"
                                                             title="Votre Statut"><?= $user['status'] ?></textarea>
                        <p id="pCounterStatut" class="mt-2 mb-2 col-lg-12"></p>
                        </span>

                    </div>




                    <div class="<?= $cssForDivField ?>">
                        <span class=" <?= $cssForSpan ?>">Etat du compte </span>
                        <input class="<?= $cssForInput ?>" type="text" readonly disabled
                               value="<?= convertUserState($user['state']) ?>"/>
                        <?= createToolTip(printAnIcon("point.png", "", "question mark icon", "icon-small ml-2 mr-2 m-2", false), "Cet état peut être" , false) ?>

                    </div>
                    <div class="<?= $cssForDivField ?>">
                        <span class=" <?= $cssForSpan ?>">Changement d'état</span>
                        <span class=" <?= $cssForSpan ?> col-md-5 col-sm-7 d-block" type="text" readonly><?php
                            if ($user['state_modification_date'] != null || $user['state_modifier_id'] != null) {
                                echo "Défini comme " . convertUserState($user['state']);
                                if ($user['state_modification_date'] != null) {
                                    echo " le " . DTToHumanDate($user['state_modification_date']);
                                }
                                if ($user['state_modifier_id'] != null) {
                                    echo " par " . mentionUser($user['state_modifier']);
                                }
                            } else {
                                echo "Aucun changement d'état pour l'instant.";
                            }

                            ?></span>
                        <div  class="">
                        <?= createToolTip(printAnIcon("point.png", "", "question mark icon", "icon-small ml-2 mr-2 m-2", false), "Information concernant le dernier changement d'état", false) ?>
                        </div>
                    </div>

                    <div class="<?= $cssForDivField ?>">
                        <span class=" <?= $cssForSpan ?>">En pause</span>
                        <input class="<?= $cssForInput ?> " type="checkbox" id="inpOnBreak"
                               readonly disabled <?= ($user['on_break'] == 1) ? "checked" : "" ?>/>

                        <?= createToolTip(printAnIcon("point.png", "", "question mark icon", "icon-small ml-2 mr-2 m-2", false), "Mettre son compte en pause, indique que vous n'êtes plus disponible pour le collectif, mais ne vous restreint pas dans l'utilisation. Vous apparaîtrez dans la partie 'Membres en pause' de la liste des membres.
Il peut être utile de laisser une information dans votre statut, concernant la raison et de la date prévue de votre retour.", false) ?>

                    </div>

                <h5 class="pt-3">Champs facultatifs:</h5>

                    <div class="<?= $cssForDivField ?>">
                        <span class="<?= $cssForSpan ?>">Email</span>
                        <input class="<?= $cssForInput ?>" type="email" name="email"
                               placeholder="josette.richard@assoc.ch" value="<?= $user['email'] ?>"/>
                    </div>

                    <div class="<?= $cssForDivField ?>">
                        <span class="<?= $cssForSpan ?>">N°téléphone</span>
                        <input class="<?= $cssForInput ?>" type="text" name="nb_phone"
                               value="<?= $user['phonenumber'] ?>"/>
                    </div>

                    <div class="<?= $cssForDivField ?>">
                        <span class="<?= $cssForSpan ?>">Lien messagerie instantanée</span>
                        <input class="<?= $cssForInput ?>" type="email" name="email"
                               placeholder="t.me/josette27" value="<?= $user['chat_link'] ?>"/>
                        <?= createToolTip(printAnIcon("point.png", "", "question mark icon", "icon-small ml-2 mr-2 m-2", false), "Lien permettant de vous écrire en privé via la messagerie instanée de votre collectif.", false) ?>

                    </div>


                    <div class="<?= $cssForDivField ?>">
                        <span class="<?= $cssForSpan ?>">Biographie</span>
                        <span class="spanTextArea">    <textarea name="biography" id="txtBiography" rows="4" maxlength="2000"
                                                                 placeholder="Dans le milieu associatif, depuis 10 ans déjà, je suis à dans Assoc depuis 2015 et j'aide plusieurs heures par semaines. La partie contact médias m'intéresse beaucoup. Je suis photographe de métier, mais aussi céramiste et je cultive un petit potager..."
                                                                 class="fullwidth form-control textFieldToCheck trimItOnChange"
                                                                 title="Votre biographie"><?= $user['biography'] ?></textarea>
                            <p id="pCounterBiography" class="mt-2 mb-2 col-lg-12"></p>
                        </span>

                        <?= flashMessage(); ?>
                    </div>
                </div>

        <div class="">
            <p class="">Ces informations seront visibles à tous les membres approuvés de l'instance, dans le but d'avoir
                un ou des moyens de contact et une description pour les nouvelles personnes, qui ne connaissent pas les
                autres membres. </p>

            <div class="  pt-3">
                <button type="submit" class="btn btn-primary">Enresgistrer</button>
            </div>
            <h5 class="pt-3">Changement du mot de passe:</h5>
            <div class="<?= $cssForDivField ?>">
                <span class="<?= $cssForSpan ?>">Mot de passe actuel</span>
                <input class="<?= $cssForInput ?>" type="password" name="newpasswordc" placeholder="" required
                       title="Confirmation du mot de passe"/>
            </div>

            <div class= "<?= $cssForDivField ?>">
                <span class="<?= $cssForSpan ?>">nouveau mot de passe</span>
                <input class="<?= $cssForInput ?>" type="password" name="newpassword" placeholder="" required/>
                <?= createToolTip(printAnIcon("point.png", "", "question mark icon", "icon-small ml-2 mr-2 m-2", false), "Les mots de passes doivent contenir:
- 8 caractères minimum
- au moins une lettre et un chiffre", false) ?>
            </div>


            <div class="<?= $cssForDivField ?>">
                <span class="<?= $cssForSpan ?>">Confirmation</span>
                <input class="<?= $cssForInput ?>" type="password" name="newpasswordc" placeholder="" required
                       title="Confirmation du mot de passe"/>
            </div>
        </div>
        <div class="  pt-3">
            <button type="submit" class=" btn btn-primary">Changer</button>
        </div>

        <div class=" pt-3">
            <div class="">
                <p class="">Zone danger - actions irréversibles ou à grosses conséquences techniques.</p>
                <div class=" pt-3">
                    <button type="submit" class="btn btn-primary">Supprimer son compte</button>
                </div>
                <div class="  pt-3">
                    <button type="submit" class=" btn btn-primary">Archiver son compte</button>
                </div>
            </div>
            </div>
            </form>
        </div>
    </div>
    </div>
    </div>

<?php
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>
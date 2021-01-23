<?php
ob_start();
$title = "Créer un groupe"
?>
    <h1><?= $title ?></h1>
<?php printPageWIPTextInfo(); ?>
    <br><span>Sur cette page vous pouvez créer un nouveau groupe sur cette instance. Les informations sont modifiables plus tard si besoin.</span>
    <form action="?action=createAGroup" method="POST" class="pt-4">
        <h4>Nom</h4>
        <input type="text" class="form-control smalltextinput textFieldToCheck" name="name" id="txtName"
               maxlength="50" value="<?= $group['name'] ?>" required>
        <span id="pCounterName">0/50</span>
        <div class="divDescription row pt-3">
            <div class="col-lg-3 col-md-12"><h4>Description</h4></div>
            <div class="col-12">
                <textarea class="fullwidth textFieldToCheck form-control" name="description"
                          id="txtDescription"
                          rows="2"
                          maxlength="200" minlength="3"
                          placeholder="Sur quel thématique/domaine travaille le groupe ? Quel est son objectif dans le collectif ? Comment le groupe est-il organisé ? ..."><?= $group['description'] ?></textarea>
            </div>
        </div>
        <span id="pCounterDescription">0/200</span>

        <div class="divContext row pt-3">
            <div class="col-lg-3 col-md-12"><h4>Contexte</h4></div>
            <div class="col-12">
                <textarea class="fullwidth textFieldToCheck form-control" name="context" id="txtContext" rows="2"
                          maxlength="200" minlength="3"
                          placeholder="Dans quelles circonstances et contexte ce groupe est-il créé ?"><?= $group['context'] ?></textarea>
            </div>
        </div>
        <span id="pCounterContext">0/200</span>
        <div class="flexdiv">
            <div class="divVisibility row pt-3 col-6 box-verticalaligncenter">
                <div>
                    <h4>Niveau de visibilité</h4>
                    <div class="flexdiv box-verticalaligncenter">
                        <select class="fullwidth form-control" name="visibility" id="selVisibility" required>
                            <?php
                            //Define descriptions of each mode:
                            $desc[GROUP_VISIBILITY_INVISIBLE] = "Le groupe est complément invisible pour les personnes extérieures.";
                            $desc[GROUP_VISIBILITY_TITLE] = "Uniquement le titre du groupe est visible pour les personnes extérieures.";
                            $desc[GROUP_VISIBILITY_STANDARD] = "Le groupe est complément visible pour les personnes extérieures.";
                            $desc[GROUP_VISIBILITY_TOTAL] = "";


                            foreach (GROUP_LIST_VISIBILITY as $option) { ?>
                                <option data-desc="<?= $desc[$option] ?>"
                                        value="<?= $option ?>" <?= ($option == GROUP_VISIBILITY_STANDARD) ? "selected" : "" ?>>
                                    <?= convertGroupVisibility($option, true) ?>
                                </option>
                            <?php } ?>
                        </select>
                        <?= createToolTipWithPoint("Cette option permet de gérer le niveau de visibilité des informations du groupe pour les personnes à l'extérieur du groupe.", "icon-small ml-2 mr-2 m-2", false, "right") ?>
                    </div>
                    <div class="mt-2">Signification du mode : (a définir)</div>
                </div>
            </div>
            <div class="divRestrictAccess row pt-4 col-6 box-verticalaligncenter">
                <div class="">
                    <h4>Type d'accès</h4>
                    <input type="checkbox" id="chkRestrictAccess"
                           name="restrict_access" <?= ($group['restrict_access'] == 1) ? "checked" : "" ?>>
                    <label for="chkRestrictAccess">Accès restreint</label>
                </div>
                <div class="col-lg-8 col-md-12 infotext">
                    <?= createToolTipWithPoint("L'accès restreint permet de modérer l'entrée des personnes dans un groupe. Les personnes devront être approuvée avant d'être membre du groupe.", "icon-small ml-2 mr-2 m-2", false, "right") ?>
                </div>

            </div>

        </div>
        <p class="mt-5 infotext">Les 2 paramètres "Visible" et "Accès restreint" n'interfèrent pas entre eux. Ils
            donnent différents niveaux de sécurité des groupes et permettent plus de sécurité ou de confidentialité
            pour
            les groupes sensibles.</p>
        <div class="divPassword row pt-4">
            <div class="col-lg-4 col-md-12 marginauto ">
                <h4>Confirmation de l'action</h4>
                <input class="fullwidth smalltextinput form-control" type="password" name="password"
                       placeholder="Mot de passe"
                       required>
            </div>
            <div class="col-lg-8 col-md-12 infotext">Créer un groupe étant une action importante, nous avons besoin de
                votre confirmation pour valider l'action. Pour ceci rentrer le mot de passe de votre compte.
            </div>
        </div>
        <div class="divBtnCreate pt-4">
            <input type="submit" class="btn btn-primary" value="Créer le groupe" disabled>créer un groupe pas encore
            possible
        </div>
    </form>
<?php
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>
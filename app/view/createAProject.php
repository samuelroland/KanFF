<?php
ob_start();
$title = "Créer un projet"
?>
<h1><?= $title ?></h1>
<?php printPageWIPTextInfo(); ?>
<p>Cette page vous permet de créer un nouveau projet réalisé par un groupe dont vous êtes membre.</p>

<form action="?action=createAGroup" method="POST" class="pt-1">
    <div class="divContext row pt-4 box-verticalaligncenter">
        <div class="col-lg-3 col-md-12 ">
            <h4>Nom du projet</h4>
            <input type="text" class="form-control smalltextinput textFieldToCheck" name="name" id="txtName"
                   maxlength="70" required>
        </div>

        <div class="col-lg-3 col-md-10">
            <h4>Réalisé par</h4>
            <div class="d-inline-flex box-verticalaligncenter">
                <select name="group" id="group" class="form-control" required>
                    <?php foreach ($groups as $g) { ?>
                        <option value="<?= $g['id'] ?>"><?= $g['name'] ?></option>
                    <?php } ?>
                </select>
                <?= createToolTipWithPoint("Les projets sont réalisés par un ou plusieurs groupes. Vous devez choisir un premier groupe dont vous êtes
            membre pour créer un projet.", "icon-middlesmall ml-2 mr-2 m-2", false, "right") ?>
            </div>
        </div>
    </div>
    <p id="pCounterName">0/50</p>
    <div class="divDescription row pt-4">
        <div class="col-lg-3 col-md-12"><h4>Description</h4></div>
        <div class="col-12"><textarea class="form-control fullwidth textFieldToCheck" name="description"
                                      id="txtDescription" rows="2"
                                      maxlength="500" minlength="3" required></textarea>
        </div>

    </div>
    <p id="pCounterDescription">0/500</p>

    <div class="divContext row pt-4">
        <div class="col-lg-3 col-md-12"><h4>Objectif</h4></div>
        <div class="col-12"><textarea class="form-control fullwidth textFieldToCheck" name="goal" id="txtGoal" rows="2"
                                      maxlength="500"
                                      minlength="3"></textarea></div>
    </div>

    <p id="pCounterGoal">0/500</p>

    <div class="divContext row pt-4">
        <h4 class="ml-3 mr-5">Début et fin prévus</h4>
        <div class="ml-4">
            <label for="start">Début:</label>
            <input type="date" id="start" name="dateStart" value="<?= date("Y-m-d") ?>" required>
        </div>
        <div class="ml-4">
            <label for="end">Fin (facultatif):</label>
            <input class="marginauto" type="date" id="end" min="" name="dateEnd">
        </div>


    </div>
    <div class="d-inline-flex pt-4 box-verticalaligncenter">
        <div><h3>Priorité du projet</h3></div>
        <?= createToolTipWithPoint("Notez de 1 à 5 (1 = minimum et 5 = maximum), l'importance de l'urgence du projet.
            Ce qui permet ensuite de calculer la priorité du projet en privélégiant l'important à l'urgent.", "icon-middlesmall ml-2 mr-2 m-2", false, "Top") ?>
    </div>
    <div class="divImportance row">
        <div class="col-lg-3 col-md">
            <h4>Importance</h4>

            <input class="form-control inputtypenumber" type="number" min="1" max="5" name="importance" id="selImportance" value="1" required></div>
        <div class="col-lg-3 col-md">
            <h4>Urgence</h4>
            <input class="form-control inputtypenumber" type="number" min="1" max="5" name="urgency" id="selUrgency" value="1" required></div>
    </div>
    <div class="divVisibility mr-0 pt-4">
        <h4>Confidentialité</h4>
        <div class="col-lg-12 col-md-12">
            <input type="checkbox" id="chkRestrictAccess"
                   name="restrict_access" checked>
            <label for="chkRestrictAccess">Le projet est visible par les personnes non-membres des groupes réalisant ce
                projet</label>
        </div>
        <div class="col-lg-12 col-md-12">
            <input type="checkbox" id="chkRestrictAccess"
                   name="restrict_access" checked>
            <label for="chkRestrictAccess">Le journal de bord est visible par les personnes non-membres des groupes
                réalisant ce projet</label>
        </div>
    </div>
    <div class="divPassword row pt-4 col-lg-12">
        <div class="mr-3">
            <h4>Confirmation de l'action</h4>
            <div class="d-inline-flex box-verticalaligncenter">
                <input class="form-control fullwidth smalltextinput" type="password" name="password"
                       placeholder="Mot de passe" required>
                <?= createToolTipWithPoint("Créer un projet étant une action importante, nous avons besoin de
            votre confirmation pour valider l'action. Pour ceci rentrer le mot de passe de votre compte.", "icon-middlesmall ml-2 mr-2 m-2", false, "right") ?>
            </div>
        </div>
    </div>
    <div class="divBtnCreate pt-4">
        <input type="submit" class="btn btn-primary" value="Créer le projet">
    </div>
</form>
<br><br>
<?php
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>


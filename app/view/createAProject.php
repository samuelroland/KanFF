<?php
ob_start();
$title = "Créer un projet"
?>
<h1><?= $title ?></h1>
<?php printPageWIPTextInfo(); ?>
<p>Cette page vous permet de créer un nouveau projet réalisé par un groupe dont vous êtes membre.</p>

<form action="?action=createAProject" method="POST" class="pt-1">
    <div class="divContext row pt-2 box-verticalaligncenter">
        <div class="col-lg-3 col-md-12 ">
            <h4>Nom</h4>
            <input type="text" class="form-control smalltextinput textFieldToCheck" name="name" id="txtName"
                   maxlength="70" required value="<?= $data['name'] ?>">
        </div>

        <div class="col-lg-3 col-md-10">
            <h4>Réalisé par</h4>
            <div class="d-inline-flex box-verticalaligncenter">
                <select name="manager_id" id="manager_id" class="form-control" required>
                    <?php foreach ($groups as $group) { ?>
                        <option value="<?= $group['id'] ?>" <?= (($data['manager_id'] == $group['id']) ? "selected" : "") ?>><?= $group['name'] ?></option>
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
                                      maxlength="500" minlength="3" required><?= $data['description'] ?></textarea>
        </div>

    </div>
    <p id="pCounterDescription">0/500</p>

    <div class="divContext row pt-2">
        <div class="col-lg-3 col-md-12"><h4>Objectif</h4></div>
        <div class="col-12"><textarea class="form-control fullwidth textFieldToCheck" name="goal" id="txtGoal" rows="2"
                                      maxlength="500"
                                      minlength="3"><?= $data['goal'] ?></textarea></div>
    </div>

    <p id="pCounterGoal">0/500</p>

    <div class="divContext row pt-2">
        <h4 class="ml-3 mr-5">Début et fin prévus</h4>
        <div class="ml-4">
            <label for="start">Début:</label>
            <input type="date" id="start" name="start"
                   value="<?= ((isset($data['start'])) ? date("Y-m-d", strtotime($data['start'])) : date("Y-m-d")) ?>"
                   required>
        </div>
        <div class="ml-4">
            <label for="end">Fin (facultatif):</label>
            <input class="marginauto" type="date" id="end" min="" name="end"
                   value="<?= ((($data['end']) !=  '') ? date("Y-m-d", strtotime($data['end'])) : "") ?>">
        </div>


    </div>
    <div class="d-inline-flex pt-4 box-verticalaligncenter">
        <div><h3>Priorité du projet</h3></div>
        <?= createToolTipWithPoint("Notez de 1 à 5 (1 = minimum et 5 = maximum), l'importance de l'urgence du projet.
            Ce qui permet ensuite de calculer la priorité du projet en privélégiant l'important à l'urgent.", "icon-middlesmall ml-2 mr-2 m-2", false, "Top") ?>
        <?= createManualLink("les priorités des projets", false, "icon-middlesmall") ?>
    </div>
    <div class="divImportance row">
        <div class="col-lg-3 col-md">
            <h4>Importance</h4>

            <input class="form-control inputtypenumber" type="number" min="1" max="5" name="importance"
                   id="selImportance" value="<?= ((isset($data['importance'])) ? $data['importance'] : 1) ?>" required></div>
        <div class="col-lg-3 col-md">
            <h4>Urgence</h4>
            <input class="form-control inputtypenumber" type="number" min="1" max="5" name="urgency" id="selUrgency"
                   value="<?= ((isset($data['urgency'])) ? $data['urgency'] : 1) ?>" required></div>
    </div>
    <div class="divVisibility mr-0 pt-4">
        <h4>Confidentialité<?= createManualLink("les paramètres de visibilités des projets", false, "icon-middlesmall ml-3") ?></h4>
        <div class="col-lg-12 col-md-12">
            <input type="checkbox" id="visible"
                   name="visible" <?= ((isset($data['name'])) ? (($data['visible'] == "on") ? "checked" : "") : "checked") //checked by default or if form has been sent, take value sent
            ?>>
            <label for="chkRestrictAccess">Le projet est visible par les membres extérieurs au projet.</label>
        </div>
        <div class="col-lg-12 col-md-12">
            <input type="checkbox" id="logbook_visible"
                   name="logbook_visible" <?= ((isset($data['name'])) ? (($data['logbook_visible'] == "on") ? "checked" : "") : "checked") //checked by default or if form has been sent, take value sent
            ?>>
            <label for="chkRestrictAccess">Le journal de bord est visible par les membres extérieurs au projet.</label>
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


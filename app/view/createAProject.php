<?php
ob_start();
$title = "Créer un projet"
?>
<h1><?= $title ?></h1>
<p>Cette page vous permet de créer un nouveau projet réalisé par un groupe dont vous êtes membre</p>

<form action="?action=createAGroup" method="POST" class="pt-4">
    <div class="divContext row pt-4">
        <div class="col-lg-3 col-md-12 ">
            <h4>Nom du Project</h4>
            <input type="text" class="smalltextinput textFieldToCheck" name="name" id="txtName"
                   maxlength="50" required>
        </div>

        <div class="col-lg-3 col-md-12 marginauto">
            <h4>Importance</h4>
            <select class="fullwidth" name="group" id="group" required>
                <?php foreach ($groups as $g) { ?>
                    <option value="<?= $g['id'] ?>"><?= $g['name'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="col-lg-5 col-md-12 infotext">
            Notez de 1 à 5 (1 = minimum et 5 = maximum), l'importance de l'urgence du projet.
            Ce qui permet ensuite de calculer la priorité du projet en privélégiant l'important à l'urgent.
        </div>
    </div>
    <p id="pCounterName">0/50</p>
    <div class="divDescription row pt-4">
        <div class="col-lg-3 col-md-12"><h4>Description du projet</h4></div>
        <div class="col-12"><textarea class="fullwidth textFieldToCheck" name="description" id="txtDescription" rows="2"
                                      maxlength="500" minlength="3" required></textarea>
        </div>

    </div>
    <p id="pCounterDescription">0/500</p>

    <div class="divContext row pt-4">
        <div class="col-lg-3 col-md-12"><h4>Objectif du projet</h4></div>
        <div class="col-12"><textarea class="fullwidth textFieldToCheck" name="goal" id="txtGoal" rows="2"
                                      maxlength="500"
                                      minlength="3"></textarea></div>
    </div>

    <p id="pCounterGoal">0/500</p>

    <div class="divContext row pt-4">
        <h4 class="col-lg-3 col-md-12">Début et fin prévus</h4>
        <div class="marginauto">
            <label for="start">Début:</label>
            <input type="date" id="start" name="dateStart" required>
        </div>
        <div class="marginauto">
            <label for="end">Fin(facultatif):</label>
            <input class="marginauto" type="date" id="end" name="dateEnd">
        </div>


    </div>

    <div class="divImportance row pt-4">
        <div class="col-lg-3 col-md-12"><h3>Priorité du projet</h3></div>
        <div class="col-lg-8 col-md-12 infotext">
            Notez de 1 à 5 (1 = minimum et 5 = maximum), l'importance de l'urgence du projet.
            Ce qui permet ensuite de calculer la priorité du projet en privélégiant l'important à l'urgent.
        </div>
        <div class="col-lg-4 col-md-12 marginauto">
            <h4>Importance</h4>

            <select class="fullwidth" name="importance" id="selImportance" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select></div>
        <div class="col-lg-4 col-md-12 marginauto">
            <h4>Urgence</h4>
            <select class="fullwidth" name="urgency" id="selUrgency" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select></div>
    </div>
    <div class="divVisibility row pt-4">
        <div class="col-lg-4 col-md-12 marginauto">
            <h4>Type d'accès</h4>
            <input type="checkbox" id="chkRestrictAccess"
                   name="restrict_access">
            <label for="chkRestrictAccess">Accès restreint</label>
        </div>
        <div class="col-lg-8 col-md-12 infotext">L'accès restreint permet de modérer l'entrée des personnes dans un
            groupe. Les personnes devront attendre d'être acceptée avant de réelement rejoindre le groupe.
        </div>
    </div>
    <p class="mt-5 infotext">Les 2 paramètres "Visible" et "Accès restreint" n'interfèrent pas entre eux. Ils
        donnent différents niveaux de sécurité des groupes et permettent plus de sécurité ou de confidentialité pour
        les groupes sensibles.</p>
    <div class="divPassword row pt-4">
        <div class="col-lg-4 col-md-12 marginauto ">
            <h4>Confirmation de l'action</h4>
            <input class="fullwidth smalltextinput" type="password" name="password" placeholder="Mot de passe" required>
        </div>
        <div class="col-lg-8 col-md-12 infotext">Créer un groupe étant une action importante, nous avons besoin de
            votre confirmation pour valider l'action. Pour ceci rentrer le mot de passe de votre compte.
        </div>
    </div>
    <div class="divBtnCreate pt-4">
        <input type="submit" class="btn btn-primary" value="Créer le groupe">
    </div>
</form>
<?php
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>


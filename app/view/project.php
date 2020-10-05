<?php
/**
 *  Project: KanFF
 *  File: home.php firstpage of the website
 *  Author: Samuel Roland
 *  Creation date: 25.05.2020
 */
$title = "Détails de " . $project['name'];
ob_start();
?>
    <h1><?= $title ?></h1>
    Page en construction.
    <p>Voici les informations du projet <?= $project['name'] ?>, les groupes réalisant ce projet, le journal de bord et
        la gestion des travaux.</p>
<?php
if ($project['archived'] == 1) {
    echo "<p class='statebanner bg-primary'>Ce projet est archivé. Il ne peut plus être modifié.</p>";
}
?>
    <div class="statebanner">
        <img src="view/medias/icons/infopoint.png" alt="info point" class="icon-small">
        <span><h2 class="d-inline">Etat: <?= convertProjectState($project['state']) ?></h2></span>
    </div>
    <div>
        <h3>Informations</h3>
        <h4>Nom</h4>
        <?= $project['name'] ?>

        <h4>Description</h4>
        <?= $project['description'] ?>

        <h4>Objectif</h4>
        <?= $project['goal'] ?>

        <h4>Début - Fin</h4>
        <?= DTToHumanDate($project['start']) . " - " . DTToHumanDate($project['end']) ?>

        <h4>Importance - Urgence</h4>
        <?php
        echo "<img src='view/medias/icons/IconPointExclamation.png' class='icon-small' />";
        echo $project['importance'];
        echo "<img src='view/medias/icons/IconMontre.png' class='icon-small' />";
        echo $project['urgency']

        ?>
    </div>
    <div>
        <h3>Groupes participants</h3>
        <table class="table table-active">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Création du groupe</th>
                <th>Nombre de membres</th>
                <th>Participe depuis</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>asdf</td>
                <td>e</td>
                <td>werwer</td>
                <td>wjeklrjk</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div>
        <h3>Gestion des travaux</h3>
    </div>

    <div>
        <h3>Journal de bord</h3>
        <?php if ($project['logbook_visible']) { ?>
            <div><?= $project['logbook_content'] ?></div>
        <?php } else { ?>
            Le journal de bord n'est pas visible pour les personnes extérieures au projet.
        <?php } ?>
    </div>
<?php
displaydebug($project);
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>
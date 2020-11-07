<?php
/**
 *  Project: KanFF
 *  File: project.php view for the details of a project
 *  Author: Samuel Roland
 *  Creation date: 06.10.2020
 */
$title = "Détails de " . $project['name'];
ob_start();
?>
    <div class="flexdiv">
        <h1 class="flex-1"><?= $title ?></h1>
        <div class="">
            <button class="clickable btn btn-primary" data-href="?action=kanban&id=<?= $project['id'] ?>&opt=0">
                Kanban
            </button>
        </div>
    </div>
<?php printPageWIPTextInfo(); ?>
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
        echo "<img src='view/medias/icons/exclamationmark.png' class='icon-small' />";
        echo $project['importance'];
        echo "<img src='view/medias/icons/clock.png' class='icon-small' />";
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
        <h3 id="logs">Journal de bord</h3>
        <?php
        displaydebug($logs);
        if ($project['logbook_visible']) { ?>
            <div><?= $project['logbook_content'] ?></div>
            <hr class="hrgrey">
            <?php if (empty($logs)) {
                echo "Aucun enregistrement dans le journal de bord...";
            } else {
                ?>
                <span>Options d'affichage:</span>
                <div class="headView flexdiv">
                    <div class="flex-4">
                        <button data-href="?action=project&id=<?= $project['id'] ?>&option=1#logs"
                                class="clickable btn <?= ($option == 1) ? 'active' : 'btn-info' ?>"
                                title="Date, titre et initiales">Aperçu
                        </button>
                        <button data-href="?action=project&id=<?= $project['id'] ?>&option=2#logs"
                                class="clickable btn <?= ($option == 2) ? 'active' : 'btn-info' ?>"
                                title="Date, titre, description raccourcie initiales.">Résumé
                        </button>
                        <button data-href="?action=project&id=<?= $project['id'] ?>&option=3#logs"
                                class="clickable btn <?= ($option == 3) ? 'active' : 'btn-info' ?>"
                                title="Date, titre et initiales">Étendu
                        </button>
                        <?php
                        if ($isAdmin) { ?>
                            <button data-href="?action=members&option=5"
                                    class="clickable btn <?= ($option == 5) ? 'active' : 'btn-info' ?>">Non approuvé
                                (<strong><?= $nbUnapprovedUsers ?></strong>)
                            </button>
                            <button data-href="?action=members&option=6"
                                    class="clickable btn <?= ($option == 6) ? 'active' : 'btn-info' ?>">Banni
                            </button>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="box-alignright flex-1">
                        <?php if ($isAdmin) { ?>
                            <button class="btn btn-primary" id="btnEditMode">Mode édition</button>
                        <?php } ?>
                    </div>
                </div>
                <?php

                foreach ($logs as $log) { ?>
                    <div class="oneLog mt-1 pb-2" id="log-<?= $log['id'] ?>"
                         data-open="<?= ($option == 3) ? "true" : "false" ?>">
                        <div class="logfirstline flexdiv">
                            <strong class="flex-2"><?= DTToHumanDate($log['date'], "simpleday") . " - " . $log['title'] ?></strong>
                            <?php if ($option == 2) {
                                echo "<em class='flex-3 shortdescription acceptreturnchar'>" . substrText($log['description'], 100) . "</em>";
                            } ?>
                            <span class="flex-1 alignright">
                                <img src="view/medias/icons/trianglebottom.png" alt="triangle bottom"
                                     class="icon-triangle trianglebottom" hidden>
                                <img src="view/medias/icons/triangletop.png" alt="triangle top"
                                     class="icon-triangle triangletop" hidden>
                                <span>Créé le <?= DTToHumanDate($log['creation_date'], "simpleday") . " par " . mentionUser($log['user']) ?></span>
                            </span>

                        </div>
                        <div class="logInner pl-4 longdescription" <?php if ($option != 3) {
                            echo "hidden";
                        } ?>>
                            <em class="acceptreturnchar"><?= $log['description'] ?></em>
                        </div>
                    </div>
                <?php }
            }
            ?>
            <?php
        } else { ?>
            Le journal de bord n'est pas visible pour les personnes extérieures au projet.
            <?php
        }
        ?>
    </div>
<?php
displaydebug($project);
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>
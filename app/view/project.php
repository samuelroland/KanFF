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
    <p>Voici les informations du projet <strong><?= $project['name'] ?></strong>, les groupes participants, les travaux
        du projet et le journal de bord.</p>
<?php
if ($project['archived'] == 1) {
    echo "<p class='statebanner bg-primary'>Ce projet est archivé. Il ne peut plus être modifié.</p>";
}
?>
    <div class="statebanner box-verticalaligncenter ">
        <div class="iconsize-40">
            <?= printAnIcon("infopoint.png", "Statut","info point", "icon-small") ?>
        </div>
        <span><h3 class="d-inline ml-3"><?= convertProjectState($project['state'], true) ?></h3></span>
    </div>
    <div class="mt-4">
        <h3>Informations</h3>
        <div class="mt-2">
            <strong>Nom: </strong>
            <?= $project['name'] ?>
        </div>
        <div class="mt-2">
            <strong>Description:</strong>
            <br>
            <?= $project['description'] ?>
        </div>
        <div class="mt-2">
            <strong>Objectif:</strong>
            <br>
            <?= $project['goal'] ?>
        </div>
        <div class="mt-2">
            <strong>Début:</strong>
            <?= DTToHumanDate($project['start']) ?>
            et <strong> Fin:</strong>
            <?= (($project['end'] != null) ? DTToHumanDate($project['end']) : "Non défini") ?>
        </div>

        <div class="mt-2 projectpriority box-verticalaligncenter">
            <strong>Importance:</strong><?php
            printAnIcon("exclamationmark.png", "Importance du projet (de 1 à 5)", "exclamation mark icon", "icon-small");
            echo "<span class='pr-2 bigvalue'>" . $project['importance'] . "</span>";
            echo " <strong>et Urgence:</strong>";
            printAnIcon("clock.png", "Urgence du projet (de 1 à 5)", "exclamation mark icon", "icon-small");

            echo "<span class='pr-2 bigvalue'>" . $project['urgency'] . "</span>";
            ?>
        </div>
    </div>
    <div class="mt-4">
        <h3>Groupes participants</h3>
        <table class="table">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Création du groupe</th>
                <th>Nombre de membres</th>
                <th>Participe depuis</th>
            </tr>
            </thead>
            <tbody>
            <?php
            displaydebug($groups);
            foreach ($groups as $group) { ?>
                <tr>
                    <td><?= $group['name']; //TODO: display if group is creator and if is manager of the project          ?></td>
                    <td><?= DTToHumanDate($group['creation_date']) ?></td>
                    <td><?= $group['nbmembers'] ?></td>
                    <td><?= DTToHumanDate($group['participate_since']) ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        <h3>Travaux</h3>
        <div>En construction</div>
    </div>

    <div class="mt-4">
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
                        <?= createToolTipWithPoint("Options d'affichage permettant d'afficher plus ou moins d'informations concernant les enregistrements du journal", "icon-xsmall m-2", false, "right") ?>
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
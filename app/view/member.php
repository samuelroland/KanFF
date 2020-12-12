<?php
/**
 *  Project: KanFF
 *  File: home.php firstpage of the website
 *  Author: Samuel Roland
 *  Creation date: 25.05.2020
 */
$title = "Détails de " . $user['firstname'] . " " . $user['lastname'];
$fullname = buildFullNameOfUser($user);

function printContributions($contributions)
{
    ?>
    <div class="pt-2">
    <?php
    if (count($contributions) > 0) {
        ob_start();
        foreach ($contributions as $project) { ?>
            <h4><?= $project[0]['projectname'] //get the name of the project with the value in the first work                 ?></h4>
            <ol>
            <?php foreach ($project as $work) { ?>
                <li><span class="linkInternal clickable cursorpointer"
                          data-href="?action=project&id=<?= $work['projectid'] ?>#work-<?= $work['workid'] ?>"><?= $work['workname'] ?></span>
                </li>
                <?php
            }
            echo "</ol>";
        }

        echo ob_get_clean();
    } else {
        echo "Pas encore de contribution...";
    }
    echo "</div>";
}

ob_start();
?>
    <h1><?= $title ?></h1>
<?php printPageWIPTextInfo(); ?>
    <p>Voici les informations de <?= $fullname ?>, ses compétences, les groupes rejoints et ses contributions. Certaines
        informations peuvent être masquées en raison du niveau de visibilité défini...</p>
    <div class="statebanner flexdiv">
        <div class="iconsize-40">
            <?= printAnIcon("infopoint.png", "Statut","info point", "icon-small") ?>
        </div>
        <div class="box-verticalaligncenter ml-3">
            <em><?= $user['status'] ?></em>
        </div>
    </div>
    <div class="spanAreBlock standardDivDetail">
        <h2>Informations</h2>
        <span>Nom complet: <?= $fullname ?></span>
        <span>Initiales: <?= $user['initials'] ?></span>
        <span>Nom d'utilisateur·ice: <?= $user['username'] ?></span>
        <span>Date d'inscription sur l'instance: <?= DTToHumanDate($user['inscription'], "simpletime") ?></span>
        <span>Etat du compte: <?= convertUserState($user['state']) ?></span>
    </div>
    <div class="standardDivDetail">
        <h3>Biographie</h3>
        <span><?= $user['biography'] ?></span>
    </div>
    <div class="standardDivDetail spanAreBlock">
        <h3>Contact</h3>
        <?php if (areAreAllEqualTo("", [$user['email'], $user['phonenumber'], $user['chat_link']])) {
            echo "Aucune moyen de contact défini.";
        } ?>
        <?php if (empty($user['email']) == false) { ?>
            <span>Email: <a title="Envoyer un email à <?= $fullname ?>"
                            href="mailto:<?= $user['email'] ?>"><?= $user['email'] ?></a>
        </span>
        <?php } ?>
        <?php if (empty($user['phonenumber']) == false) { ?>
            <span>Téléphone: <a title="Téléphoner à <?= $fullname ?>"
                                href="tel:<?= $user['phonenumber'] ?>"><?= $user['phonenumber'] ?></a>
        </span>
        <?php } ?>
        <?php if (empty($user['chat_link']) == false) { ?>
            <span>Lien messagerie instantanée: <a class="linkExternal"
                                                  title="Contacter <?= $fullname ?> par messagerie instantanée"
                                                  target="_blank"
                                                  href="<?= $user['chat_link'] ?>"><?= $user['chat_link'] ?></a>
        </span>
        <?php } ?>
    </div>

    <div class="standardDivDetail">
        <h2>Groupes rejoints</h2>
        <?php if (count($groups) > 0) { ?>
            <table class="table width-min-content">
                <thead class="yellowligthheader">
                <tr>
                    <th>Nom</th>
                    <th>État</th>
                    <th>Nb de membres</th>
                    <th>Entrée</th>
                    <th>Création du groupe</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $test = 0;
                foreach ($groups as $group) {
                    ?>
                    <tr>
                        <td><?= $group['name'] ?></td>
                        <td><?= convertGroupState($group['state'], true) ?></td>
                        <td><?= $group['nbusers'] ?></td>
                        <td><?= DTToHumanDate($group['entrydate']) ?></td>
                        <td><?= DTToHumanDate($group['creation_date']) ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } else {
            echo "<p>Aucun groupe rejoint...</p>";
        } ?>
    </div>

    <div class="standardDivDetail">
        <h2>Contributions en cours</h2>
        <span>Les contributions en cours sont les travaux en cours, dont le membre affiché a participé (tâches en cours ou
            terminées). Les projets et les travaux sont ordrés par le nombre de tâches décroissant.</span>
        <?php printContributions($formatedContributions['inrun']); ?>
    </div>

    <div class="standardDivDetail">
        <h2>Contributions antérieures</h2>
        <span>Les contributions antérieures sont les travaux terminés dont le membre affiché a participé. Les projets et les travaux sont
            ordrés par le nombre de tâches décroissant.</span>
        <?php printContributions($formatedContributions['old']); ?>
    </div>
<?php
displaydebug($user);
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>
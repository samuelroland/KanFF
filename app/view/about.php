<?php
/**
 *  Project: KanFF
 *  File: about.php view of the page About. This page display the informations of the collective and the instance stored in instance.json
 *  Author: Samuel Roland
 *  Creation date: 26.08.2020
 */
$instanceinfos = getInstanceInfos();
$collective = $instanceinfos['collective'];
$instance = $instanceinfos['instance'];
$versions = getVersionsApp();
$lastVersion = $versions[count($versions)-1];
ob_start();
$title = "A propos";
?>
    <h1><?= $title = "A propos"; ?></h1>
<?php if ($instance['testinstance'] == true) {
    echo "<p class='text-danger'><strong>Ceci est une instance de test. Toutes les données sont fictives et ne doivent pas être réelle puisque accessibles publiquement.</strong></p>";
} ?>
    <br>
    <h2 class="txtdarkbluelogo"><?= $collective['name'] ?></h2>
    <p><strong>Type: </strong><?= $collective['type'] ?></p>
    <p><strong>Description: </strong><?= $collective['description'] ?></p>
    <br>
    <h2 class="txtlightbluelogo">Instance <?= $instance['name'] ?></h2>
    <p><strong>Une instance, Késako ?</strong></p>
    <p>Une instance est une installation d'une application sur un serveur. Ici par exemple,
            l'instance <?= $instance['name'] ?> est une installation de l'application KanFF sur le serveur atteignable à
            l'url <?= $_SERVER['HTTP_HOST'] ?>. Une instance KanFF ne peut pour l'instant n'héberger qu'un seul collectif.
            Dans de futures versions, il sera certainement possible d'en héberger plusieurs.</p>
    <p><?= $instance['description'] ?></p>
    <p><strong>Lien: </strong><?= $_SERVER['HTTP_HOST'] ?></p>
    <p><strong>Version installée: </strong>
        <?= $lastVersion['version'] . " (publiée le " . DTToHumanDate($lastVersion['date'], "simpleday") . ")" ?></p>
    <p><strong>A propos de cette instance: </strong><br><?= $instance['about'] ?></p>
     <br>
    <p><strong>Admin: </strong><?= $instance['admin'] ?></p>
    <p><strong>Contact: </strong><?= $instance['contact'] ?></p>
    <p><strong>Message de l'admin: </strong><?= $instance['adminmsg'] ?></p>
    <p><strong>A propos la création de nouveaux collectifs: </strong><br><?= $instance['aboutnewcollectives'] ?></p>

    <br>
    <h2 class="txtgreenlogo">KanFF</h2>
<p><strong>canne... quoi ?</strong></p>
<p><em class="txtdarkbluelogo">Une application web de gestion de projets, de tâches, et d'organisation du travail, conçue pour le milieu militant et associatif.</em><br>Chaque membre a son compte et intéragit dans des groupes, des projets, des travaux et tâches, de manière collaborative. Il y a aussi des événements et des journaux de bord par projet.</p>
<p><strong>Gérer des projets et des tâches ? C'est quoi et comment ?</strong></p>

<p>Il existe <strong>un petit mode d'emploi</strong> explicant de manière large et simple ce qu'on peut faire sur KanFF. Cette documentation se trouve ici. [ADD LINK]. Vous apprendrez également la signification des termes moins connus et largement utilisés dans l'application (comme kanban, travail, supertâche, ...). Le tout est illustré d'images afin de rendre les explications plus concrètes.
    <br> La 2ème partie explique plus en détail certaines parties et s'adresse aux personnes les plus intéressé·e·s...</p>
<?php
$contenttype = "restricted";
$content = ob_get_clean();
require "gabarit.php";
?>
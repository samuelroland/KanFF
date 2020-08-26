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
ob_start();
$title = "A propos";
?>
    <h1><?= $title = "A propos"; ?></h1>
    <h2 class="txtdarkbluelogo"><?= $collective['name'] ?></h2>
    <p><strong>Description: </strong><?= $collective['description'] ?></p>
    <p><strong>Type: </strong><?= $collective['type'] ?></p>
    <br>
    <h2 class="txtlightbluelogo">Instance <?= $instance['name'] ?></h2>
    <p><strong>Une instance, Késako ?</strong></p>
    <p><em>Une instance est une installation d'une application sur un serveur. Ici par exemple,
            l'instance <?= $instance['name'] ?> est une installation de l'application KanFF sur le serveur atteignable à
            l'url <?= $instance['url'] ?>. Une instance KanFF ne peut pour l'instant n'héberger qu'un seul collectif.
            Dans de futures versions, il sera certainement possible d'en héberger plusieurs.</em></p>
    <p><?= $instance['description'] ?></p>
    <p><strong>Lien: </strong><?= $instance['url'] ?></p>
    <p><strong>Contact: </strong><?= $instance['contact'] ?></p>
    <p><strong>A propos: </strong><br><?= $instance['about'] ?></p>
    <p><strong>A propos de nouveaux collectifs: </strong><br><?= $instance['aboutnewcollectives'] ?></p>

    <br>
    <h2 class="txtgreenlogo">KanFF</h2>
<p><strong>C'est quoi ?</strong></p>
<p>Une application web de gestion de projets, de tâches, et d'organisation du travail, conçue pour le milieu militant et associatif.</p>
<p><strong>Gérer des projets et des tâches ? C'est quoi et comment ?</strong></p>
<p>Il existe un petit mode d'emploi explicant de manière large et simple ce qu'on peut faire sur KanFF. Cette documentation se trouve ici. [ADD LINK]. Vous apprendrez également la signification des termes moins connus et utilisé dans l'application.
    <br> La 2ème partie explique plus en détail certaines parties facultatives pour les personnes les plus intéressé.e.s...</p>
<?php
$contenttype = "restricted";
$content = ob_get_clean();
require "gabarit.php";
?>
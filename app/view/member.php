<?php
/**
 *  Project: KanFF
 *  File: home.php firstpage of the website
 *  Author: Samuel Roland
 *  Creation date: 25.05.2020
 */
$title = "Détails de " . $user['firstname'] . " " . $user['lastname'];
$fullname = buildFullNameOfUser($user);
ob_start();
?>
    <h1><?= $title ?></h1>
<?php printPageWIPTextInfo(); ?>
    <p>Voici les informations de <?= $fullname ?>, ses compétences, les groupes rejoints et ses contributions. Certaines
        informations peuvent être masquées en raison du niveau de visibilité défini...</p>
    <div class="statebanner flexdiv">
        <div class="circlebordered">
            <?= printAnIcon("exclamationmark.png", "Statut", "exclamation mark icon") ?>
        </div>
        <div class="box-verticalaligncenter ml-3">
            <?= $user['status'] ?>
        </div>
    </div>
    <div class="spanAreBlock standardDivDetail">
        <h3>Informations</h3>
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
<?php
displaydebug($user);
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>
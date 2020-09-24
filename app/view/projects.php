<?php
ob_start();
$title = "Project";
//$test = "Rassemblement des personnes créatives de l'association.";
//$result = (htmlentities($test, ENT_QUOTES));


?>
    <h1><?= $title ?></h1>
    <div class="headView flexdiv">
        <div class="flex-1">
            <button class="btn active">Tous</button>
            <button class="btn btn-info">Contribués</button>
        </div>
        <div class="box-alignright flex-1">
            <a href="?action=createAGroup">
                <button class="btn btn-primary newgroup">Nouveau Project</button>
            </a>
        </div>
    </div>
    <H3>En cours</H3>
    <div class="divGroups row pt-3">
        <?php
        $test = 0;
        foreach ($projects as $project) {

            ?>
            <div class="divGroup bordertest">
                <div class="topDiv">
                    <div class="imgFrame">
                        <img class="imgGroup"
                            <?php if (is_null($project['image']) == false) {
                                echo "src='data/groups/" . $project['image'] . "'";
                            } else {
                                echo "src='view/medias/images/group_default.png'";
                            } ?> ></div>
                    <div class="groupInfo p-3">
                        <h3><?= $project['name'] ?></h3>
                        <p title="<?= $project['description'] ?>"><?= $project['description'] ?></p>
                        <p title="<?= $project['context'] ?>"><?= $project['context'] ?></p>
                    </div>
                </div>
                <div class="groupDetails bordertest">
                    <?php if (is_null($project['email']) == false) { ?>
                        <div class="box-verticalaligncenter">
                            <a title="Ecrire un email à <?= $project['email'] ?>" class="linkExternal"
                               href="mailto:<?= $project['email'] ?>">
                                <img src="view/medias/icons/email.png" alt="email logo" class="icon-simple">
                                <span><em><?= $project['email'] ?></em></a></span></div>
                    <?php } ?>
                    <?php if (is_null($project['creator_initials']) == false) { ?>
                        <div class="box-verticalaligncenter">
                            <a href="/?action=user&id=<?= $project['creator_id'] ?>" class="linkExternal"><img src="view/medias/icons/user.png" alt="email logo" class="icon-simple">
                                <span class="verticalalign"><?= $project['creator_initials'] ?></span></a>
                        </div>
                    <?php } ?>
                    <div class="box-verticalaligncenter">
                        <?php if (is_null($project['creation_date']) == false) { ?>
                        <img src="view/medias/icons/calendar.png" alt="email logo" class="icon-simple">
                        <span><?= "Création: " . DTToHumanDate($project['creation_date'], "simpleday") ?></span></div>
                <?php } ?>

                </div>
                <div class="position-bottom-right">
                    <button class="btn btn-info">Voir</button>
                </div>
            </div>
        <?php } ?>
    </div>
<?php
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>
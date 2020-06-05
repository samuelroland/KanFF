<?php
ob_start();
$title = "Groupes";
$test = "Rassemblement des personnes créatives de l'association.";
$result = (htmlentities($test, ENT_QUOTES));
echo $result;

?>
    <h1><?= $title ?></h1>
    <div class="headView row">
        <div class="col-md-6 col-sm-12">
            <button class="btn active">Tous</button>
            <button class="btn btn-info">Rejoints</button>
        </div>
        <div class="box-alignright col-md-6 col-sm-12">
            <a href="?action=createAGroup">
                <button class="btn btn-primary newgroup">Créer un nouveau groupe</button>
            </a>
        </div>
    </div>

    <div class="divGroups row pt-3">
        <?php
        $test = 0;
        foreach ($groups as $group) {

            ?>
            <div class="divGroup bordertest">
                <div class="topDiv">
                <div class="imgFrame">
                    <img class="imgGroup"
                        <?php if (is_null($group['image']) == false) {
                            echo "src='data/groups/" . $group['image'] . "'";
                        } else {
                            echo "src='view/medias/images/group_default.png'";
                        } ?> ></div>
                <div class="groupInfo p-3">
                    <h3><?= $group['name'] ?></h3>
                    <p title="<?= $group['description'] ?>"><?= $group['description'] ?></p>
                    <p title="<?= $group['context'] ?>"><?= $group['context'] ?></p>
                </div>
            </div>
                <div class="groupDetails bordertest">
                    <?php if (is_null($group['email']) == false) { ?>
                        <div class="box-verticalaligncenter">
                            <a title="Ecrire un email à <?= $group['email'] ?>" class="linkExternal"
                               href="mailto:<?= $group['email'] ?>">
                                <img src="view/medias/icons/email.png" alt="email logo" class="icon-simple">
                                <span><em><?= $group['email'] ?></em></a></span></div>
                    <?php } ?>
                    <?php if (is_null($group['creator_initials']) == false) { ?>
                        <div class="box-verticalaligncenter">
                            <a href="/?action=user&id=<?= $group['creator_id'] ?>" class="linkExternal"><img src="view/medias/icons/user.png" alt="email logo" class="icon-simple">
                            <span class="verticalalign"><?= $group['creator_initials'] ?></span></a>
                        </div>
                    <?php } ?>
                    <div class="box-verticalaligncenter">
                        <?php if (is_null($group['creation_date']) == false) { ?>
                        <img src="view/medias/icons/calendar.png" alt="email logo" class="icon-simple">
                        <span><?= "Création: " . DTToHumanDate($group['creation_date'], "simpleday") ?></span></div>
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
<?php
ob_start();
$title = "Groupes";
//$test = "Rassemblement des personnes créatives de l'association.";
//$result = (htmlentities($test, ENT_QUOTES));
echo $result;

?>
    <h1><?= $title ?></h1>
    <div class="headView flexdiv">
        <div class="flex-1">
            <button class="btn active">Tous</button>
            <button class="btn btn-info">Rejoints</button>
        </div>
        <div class="box-alignright flex-1">
            <a href="?action=createAGroup">
                <button class="btn btn-primary newgroup">Nouveau groupe</button>
            </a>
        </div>
    </div>

    <div class="divGroups row pt-3">
        <?php
        $test = 0;
        foreach ($groups as $group) {
            if ($group['visibility'] != GROUP_VISIBILITY_TITLE) {
                ?>
                <div class="divGroup thinBorder">
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
                    <div class="groupDetails thinBorder">
                        <?php if (is_null($group['email']) == false) { ?>
                            <div class="box-verticalaligncenter">
                                <a title="Ecrire un email à <?= $group['email'] ?>" class="linkExternal"
                                   href="mailto:<?= $group['email'] ?>">
                                    <img src="view/medias/icons/email.png" alt="email logo" class="icon-simple">
                                    <span><em><?= $group['email'] ?></em></a></span>
                            </div>
                        <?php } else { ?>
                            <div class="box-verticalaligncenter">
                                    <img src="view/medias/icons/email.png" alt="email logo" class="icon-simple">
                                    <span><em>Pas d'email</em></span>
                            </div>
                            <?php
                        }
                        if (is_null($group['creator_initials']) == false) { ?>
                            <div class="box-verticalaligncenter">
                                <a href="/?action=member&id=<?= $group['creator_id'] ?>" class="linkExternal"><img
                                            src="view/medias/icons/user.png" alt="email logo" class="icon-simple">
                                    <span class="verticalalign"><?= $group['creator_initials'] ?></span></a>
                            </div>
                        <?php } ?>
                        <div class="box-verticalaligncenter">
                            <?php if (is_null($group['creation_date']) == false) { ?>
                            <img src="view/medias/icons/calendar.png" alt="email logo" class="icon-simple">
                            <span><?= "Création: " . DTToHumanDate($group['creation_date'], "simpleday") ?></span></div>
                    </div>
                    <?php } ?>

                    <div class="position-bottom-right">
                        <button class="btn btn-info">Détails</button>
                    </div>
                </div>

                <?php
            } else {    //for title only group:
                ?>
                <div class="divGroup thinBorder">
                    <div class="topDiv">
                        <div class="">
                            <h3><?= $group['name'] ?></h3>
                            <p>Ce groupe ne permet pas d'afficher plus d'informations que le nom.</p>
                        </div>
                        <div class="position-bottom-right">
                            <button class="btn btn-info">Détails</button>
                        </div>
                    </div>
                </div>

                <?php
            }
        } ?>
    </div>
<?php
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>
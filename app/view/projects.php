<?php
ob_start();
$title = "Project";
//$test = "Rassemblement des personnes créatives de l'association.";
//$result = (htmlentities($test, ENT_QUOTES));

echo $result;
?>
    <h1><?= $title ?></h1>
    <div class="headView flexdiv">
        <div class="flex-1">
            <button class="btn active">Tous</button>
            <button class="btn btn-info">Contribués</button>
        </div>
        <div class="box-alignright flex-1">
            <a href="?action=createAProject">
                <button class="btn btn-primary newproject">Nouveau Project</button>
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
                <div class="">

                        <h3><?= $project['name'] ?></h3>
                    <h5><?= $project[''] ?></h5>
                    <div class="groupInfo ">
                        <p title="<?= $project['description'] ?>"><?= $project['description'] ?></p>
                        <p title="<?= $project['context'] ?>"><?= $project['context'] ?></p>
                        <p title="<?= $project['state'] ?>"><?= $project['state'] ?></p>
                    </div>
                </div>
                <div class="groupDetails ">


                    <div class="box-verticalaligncenter">

                        <div class="position-bottom-left">
                            <img src="view/medias/icons/PointDexcalamtion.jpg" alt="email logo" class="icon-simple">
                            <span title="<?= $project['importance'] ?>"><?= $project['importance'] ?></span>
                        </div>
                        <div class="position-bottom-left">
                            <img src="view/medias/icons/IconMontre.png" alt="email logo" class="icon-simple">
                            <span title="<?= $project['urgency'] ?>"><?= $project['urgency'] ?></span>
                        </div>
                        </div>


                </div>
                <div class="position-bottom-right">
                    <button class="btn btn-info">Détails</button>
                </div>
            </div>
        <?php } ?>
    </div>
<?php
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>
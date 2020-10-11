<?php
ob_start();
$title = "Projets";
echo substrText("Réfléxion hiérarchie + égalité des genres", 43, true, true)
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
    <div class="divGroups margin-5px pt-3">
        <?php
        $test = 0;
        foreach ($projects as $project) {
            ?>
            <div class="divProject thinBorder">
                <div class="divProjectFirstLine">
                    <h3 title="<?= $project['name'] ?>"><?php
                        if (strlen($project['name']) > 43) {
                            echo createToolTip(createElementWithFixedLines($project['name'], 1), $project['name']);
                            }else{
                            echo htmlentities($project['name']);
                        }
                        ?></h3>
                    <div class="flexdiv">
                        <div class="flex-2 divParticipate mb-4">
                            <?php
                            echo "<strong>Réalisé par:</strong><br>";
                            foreach ($project['participate'] as $participate) {
                                echo "<span class='clickable linkInternal cursorpointer ' data-href='?action=group&id={$participate['group']['id']}'>" . $participate['group']['name'] . "</span><br>";
                            }

                            ?>
                        </div>
                        <div class="flex-4">
                            <p title="<?= $project['description'] ?>"><?= createElementWithFixedLines($project['description'], 5) ?></p>
                            <p title="<?= $project['context'] ?>"><?= $project['context'] ?></p>

                        </div>
                    </div>
                </div>
                <div class="flexdiv fullwidth divProjectLastLine">
                    <div class="box-verticalaligncenter flex-2">
                        <div class="position-bottom-left">
                            <img src="view/medias/icons/PointDexcalamtion.jpg" alt="email logo" class="icon-simple">
                            <span title="<?= $project['importance'] ?>"><?= $project['importance'] ?></span>
                        </div>
                        <div class="position-bottom-left">
                            <img src="view/medias/icons/IconMontre.png" alt="email logo" class="icon-simple">
                            <span title="<?= $project['urgency'] ?>"><?= $project['urgency'] ?></span>
                        </div>

                    </div>
                    <div class="flex-4 box-verticalaligncenter">
                        <span title="<?= $project['state'] ?>">Etat: <?= convertProjectState($project['state']) ?></span>
                    </div>

                </div>
                <div class="position-bottom-right">
                    <button class="btn btn-info clickable" data-href="?action=project&id=<?= $project['id'] ?>">
                        Détails
                    </button>
                </div>
            </div>
        <?php } ?>
    </div>
<?php
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>
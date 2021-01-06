<?php
/**
 *  Project: KanFF
 *  File: formsForRightPanel.php view functions to print forms for the right panel in kanban.php
 *  Author: Samuel Roland
 *  Creation date: 23.10.2020
 */

function printDivTaskDetails($project)
{
    ob_start();
    $spanCSS = "";
    $divCSS = "mt-2";
    ?>
    <!-- divTaskDetails Details of a task -->
    <div id="divTaskDetails" class="divInRightPanel" style="display: none;">
        <div class="panelRightStandardHeader flexdiv box-verticalaligncenter middlecolumn">
            <span class="flex-1">Détails tâche n. <strong><span id="number"></span></strong></span>
            <div class="mr-3">
                <div id="state" class="alignright fullwidth font-weight-bold"></div>
                <div class="smallinfotext alignright" id="spancompletion"></div>
            </div>
            <span class="circle-redcross onclickCloseDetails"><?php printAnIcon("redcross.png", "Fermer le panneau de détails", "red cross icon", "icon-redcross") ?></span>
        </div>
        <div class="divTaskDetailsContent" id="divTaskDetailsContent">
            <div class="divTaskDetailsFirstLine flexdiv box-verticalaligncenter">
                <h5 id="spanname" class="flex-1 nomargin"></h5>
                <?php printAnIcon("chevrondown.png", "Options", "chevron down icon"); ?>
            </div>
            <hr class="hrgrey nomargin">
            <div class="divTaskDetailsInformations">
                <div class="flexdiv  <?= $divCSS ?>">
                    <div class="flex-2">
                        <div class="flexdiv">
                            <span class="flex-1 <?= $spanCSS ?>">Nom:</span>
                            <span id="pCounterName"></span>
                        </div>
                        <input id="inputname" name="name" type="text"
                               class="form-control textFieldToCheck counterVisibleOnlyIfFastMaxLength inputspan"
                               placeholder="Nom de la tâche" maxlength="100" required>
                    </div>
                    <div class="flex-1 ml-2">
                        <span class="<?= $spanCSS ?>">Travail:</span>
                        <input type="text" id="workname" class="form-control" disabled readonly>
                    </div>
                </div>
                <div class=" <?= $divCSS ?>">
                    <span class="<?= $spanCSS ?>">Description:</span>
                    <textarea id="description" name="description" type="text" rows="4"
                              class="form-control textFieldToCheck counterVisibleOnlyIfFastMaxLength resizenone inputspan"
                              placeholder="Description de la tâche" maxlength="2000"></textarea>
                    <div class="alignright"><span id="pCounterDescription"></span></div>
                </div>
                <div class="flexdiv <?= $divCSS ?>">
                    <div class="">
                        <span class="<?= $spanCSS ?>">Type:</span>
                        <select class="form-control width-min-content inputspan" name="type" id="type">
                            <?php foreach (TASK_LIST_TYPE as $type) {
                                echo "<option value='" . $type . "'>" . convertTaskType($type, true) . "</option>";
                            } ?>
                        </select>
                    </div>
                    <div class="flex-1 ml-3">
                        <span class="<?= $spanCSS ?>">Responsable:</span>
                        <div class="flexdiv divResponsible box-verticalaligncenter">
                            <div class="circle-responsible mr-2">
                                <p class="marginauto" id="initials"></p>
                            </div>
                            <input type="text" id="responsible" class="form-control flex-1 width-min-content"
                                   value="" disabled readonly>
                        </div>
                        <div class="alignright smallinfotext"><span id="creator"></span></div>
                    </div>
                </div>
                <div class="flexdiv <?= $divCSS ?>">
                    <div class="flex-1">
                        <span class="<?= $spanCSS ?>">Date limite:</span>
                        <input id="deadline" type="date" value="" name="deadline"
                               class="form-control inputtypedate inputspan">
                    </div>
                    <div class="flex-1 flexdiv">
                        <div class="ml-3">
                            <span class="<?= $spanCSS ?>">Urgence:</span>
                            <input type="number" name="urgency" id="urgency"
                                   class="form-control inputtypenumber inputspan"
                                   value="" min="0" max="5" required>
                        </div>
                        <div class="mt-4">
                            <?= createToolTipWithPoint("Notez l'urgence de la tâche de 0 à 5 (0 = aucun, 1 = min et 5 = max)", "icon-xsmall m-2", false) ?>
                        </div>
                    </div>
                </div>
                <div class="<?= $divCSS ?>">
                    <div class="flexdiv">
                        <span class="flex-1 align-items-end">Lien:</span>
                        <?= createToolTip('<span class="alignright yellowdarkonhover d-inline-block" ' . getInlineJSForALinkToCopy("link.value", true) . '>' . printAnIcon("copylink.png", "", "copy link icon", "icon-middlesmall m-2", false) . '</span>', "Copier le lien"); ?>
                        <?= createToolTip('<span class="alignright yellowdarkonhover d-inline-block" ' . getInlineJSForALinkToOpen("link.value", true) . '>' . printAnIcon("openlink.png", "", "open link icon", "icon-middlesmall m-2", false) . '</span>', "Ouvrir le lien dans un nouvel onglet"); ?>
                    </div>
                    <input type="text" placeholder="Lien relatif à la tâche" name="link" id="link"
                           class="form-control textFieldToCheck counterVisibleOnlyIfFastMaxLength inputspan"
                           maxlength="2000">
                    <div class="alignright">
                        <span id="pCounterLink">asfd</span>
                    </div>
                </div>
                <div class="<?= $divCSS ?>">
                    <span class="<?= $spanCSS ?>">Projet:</span>
                    <input id="projectname" type="text" value="<?= $project['name'] ?>" class="form-control inputspan"
                           disabled readonly>
                </div>
                <div class="panelRightStandardBottomLine">
                    <div class="flexdiv box-alignright">
                        <button id="btnCancelTaskDetails" class="btnSaveCancel btn colorCancel">Annuler</button>
                        <button id="btnSaveTaskDetails" class="btnSaveCancel btn colorSave">Enregistrer</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <?php
    echo ob_get_clean();
}

function printDivTaskCreate($project)
{
    ob_start();
    ?>
    <!-- divTaskCreate Form to create a task -->
    <div id="divTaskCreate" class="divInRightPanel" style="display: none;">
        <div class="panelRightStandardHeader flexdiv box-verticalaligncenter middlecolumn">
            <span class="flex-1"><strong>Créer une tâche</strong></span>
            <span class="circle-redcross onclickCloseDetails"><?php printAnIcon("redcross.png", "Fermer le panneau de détails", "red cross icon", "icon-redcross") ?></span>
        </div>
        <div class="" id="divTaskCreateContent">
            <div class="divTaskDetailsFirstLine flexdiv box-verticalaligncenter">
                <h5 id="spannamecreate" class="flex-1 nomargin breakword"></h5>
            </div>
            <hr class="hrgrey nomargin">
            <span class="smallinfotext">Une tâche est une activité courte réalisée par une personne parmi d'autres tâches dans le but d'effectuer entièrement le travail. </span>
            <div class="flexdiv mt-2">
                <div class="flex-1">
                    <div class="flexdiv">
                        <span class="flex-1">Nom:</span>
                        <span class="" id="pCounterName2"></span>
                    </div>
                    <input type="text" id="inputnamecreate" name="name2" maxlength="100" autofocus
                           class="textFieldToCheck counterVisibleOnlyIfFastMaxLength form-control"
                           placeholder="Nom de la tâche" required>
                </div>
                <div class="ml-2 ">
                    <span class="">Type:</span>
                    <select class="form-control" name="type" id="typecreate">
                        <option value="0">Autre</option>
                        <option value="1">Question</option>
                        <option value="2">Information</option>
                        <option value="3">Proposition</option>
                        <option value="4">Idée</option>
                        <option value="5">Réflexion</option>
                    </select>
                </div>
            </div>
            <div class="mt-2">
                <span class="">Travail:</span>
                <select class="form-control" name="work" id="workcreate">
                    <?php
                    //TODO: add conditions to not include invisible and done, and sort the list cleverly
                    foreach ($project['works'] as $work) {
                        if ($work['state'] != WORK_STATE_DONE && $work['hasWritingRightOnTasks']) {
                            ?>
                            <option class="" value="<?= $work['id'] ?>"
                                    data-work="<?= $work['id'] ?>"><?= $work['name'] ?><?php echo ($work['inbox'] != 1) ? " (" . convertWorkState($work['state'], true) . ")" : "" ?>
                            </option>
                        <?php }
                    } ?>
                </select>
                <input type="hidden" name="project" value="<?= $project['id'] ?>">
            </div>
            <div class="mt-2">
                <span class="smallinfotext">Les autres informations de la tâche peuvent être complété par la suite...</span>
            </div>
            <div class="mt-2 flexdiv">
                <div class="flex-1 box-verticalaligncenter">
                    <input type="checkbox" id="chkSerialCreation">
                    <label for="chkSerialCreation" class="ml-2 noverticalmargin">Mode Création en série</label>
                </div>
                <div class="box-alignright">
                    <span><?= createToolTipWithPoint("Ce mode vous permet de créer plusieurs tâches à la suite en restant sur ce formulaire. Quand le mode est désactivé, les détails de la tâche apparaissent directement après la création.", "icon-xsmall m-2", false, "bottom") ?></span>
                </div>
            </div>
            <div class="panelRightStandardBottomLine ">
                <div class="flexdiv mb-3">
                    <div class="box-verticalaligncenter">
                        <?= printAnIcon("point.png", "", "question mark icon", "icon-xsmall m-2", false) ?>
                    </div>
                    <div class="smallinfotext text-decoration-none">
                        <strong>Astuce: </strong><br>
                        Pour rentrer les informations plus rapidement, utilisez les touches Tab et Maj+Tab pour
                        changer de champ, les flèches du clavier pour choisir un type, ainsi que la touche Enter
                        (pour créer la tâche).<br>Vous n'avez donc pas besoin de la souris.
                    </div>
                </div>
                <div class="flexdiv box-alignright">
                    <button id="btnCancelCreate" class="btnSaveCancel btn colorCancel">Annuler</button>
                    <button id="btnCreateTask" class="btnSaveCancel btn colorSave">Créer la tâche</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    echo ob_get_clean();
}

?>

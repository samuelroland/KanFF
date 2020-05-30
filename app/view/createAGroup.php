<?php
ob_start();
$title = "Créer un groupe"
?>
    <h1>Créer un groupe</h1>
    <p>Cette page vous permet de créer un nouveau groupe sur cette instance. Vous rentrez ici les informations de base
        pour un groupe qui sont modifiables par la suite, et les autres informations pourront être rentrées dans les
        paramètres une fois le groupe créé.</p>

    <form action="?action=createAGroup" method="POST" class="pt-3">
        <h4>Nom du groupe</h4>
        <input type="text" name="name" placeholder="GT mail">
        <div class="divDescription row pt-3">
            <div class="col-lg-3 col-md-12"><h4>Description du groupe</h4></div>
            <div class="col-lg-9 col-md-12 infotext">Ce champ permet de décrire le but et ce qu'il se passera dans ce
                groupe. On
                peut aussi y mettre une indication sur la fréquence de travail et des réunions ou d'autres événements,
                ainsi que quelques dates importantes si nécessaire.
            </div>
            <div class="col-12"><textarea class="fullwidth" name="description" id="txtDescription" rows="5"
                                          maxlength="200" minlength="3" placeholder="tbd"></textarea>
            </div>

        </div>
        <p id="pCounterDescription" data-max="200">0/200</p>
        <div class="divContext row pt-3">
            <div class="col-lg-3 col-md-12"><h4>Contexte</h4></div>
            <div class="col-lg-9 col-md-12 infotext">Le contexte répond aux questions suivantes:
                Pourquoi ce groupe a été créé, dans quelles circonstances/contexte ?
            </div>
            <div class="col-12"><textarea class="fullwidth" name="context" id="txtContext" rows="5" maxlength="200"
                                          minlength="3" placeholder="tbd"></textarea></div>
        </div>
        <p id="pCounterContext" data-max="200">0/200</p>
        <div class="divVisibility row pt-3">
            <div class="col-lg-4 col-md-12 marginauto">
                <select class="alignverticalcenter" name="visibility" id="selVisibility">
                        <option value="1">Invisible</option>
                        <option value="2">Titre visible</option>
                        <option value="3">Image visible</option>
                        <option value="4">Statut visible</option>
                        <option value="5">Email visible</option>
                        <option value="6">Description et contexte visible</option>
                        <option value="7">Date de création visible</option>
                        <option value="8">Créateur/Créatrice visible</option>
                        <option value="9" selected>Membres visibles</option>
                        <option value="10">Lien du drive visible</option>
                        <option value="10">Lien du chat visible</option>
                        <option value="10">Totalement visible</option>
                    </select></div>
            <div class="col-lg-8 col-md-12 infotext">Cette option permet de gérer le niveau de visibilité des informations du groupe pour les personnes non-membres. Chaque niveau inclut les précédents. (Image visible inclut que le titre est également visible, par exemple. Et "Email visible" inclut l'email évidemment mais également le statut, l'image et le titre qui seront visibles).

                La visibilité ou au contraire l'invisibilité des projets, travaux, tâches, événements, journaux de bord, ... se gère sur chaque élément en question. (Ainsi un projet peut-être visible alors que d'autres pas).
            </div>
            <div class="col-12"><textarea class="fullwidth" name="context" id="txtContext" rows="5" maxlength="200"
                                          minlength="3" placeholder="tbd"></textarea></div>
        </div>
    </form>
<?php
$content = ob_get_clean();
require "gabarit.php";
?>
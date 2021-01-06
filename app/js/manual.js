/**
 *  Project: KanFF
 *  File: manual.js javascript for manual
 *  Author: Samuel Roland
 *  Creation date: 29.12.2020
 */
//After the DOM has been loaded:
$(document).ready(function () {
    hash = window.location.hash
    if (document.getElementById(hash.substr(1)) == null && hash != "" && queryActionIncludes("manual")) {
        displayResponseMsg("La section demandée dans l'URL n'existe pas.", false)
    }
})
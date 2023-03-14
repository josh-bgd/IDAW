<?php
function renderMenuToHTML($currentPageId) {
    // un tableau qui d\'efinit la structure du site
    $mymenu = array(
    // idPage titre
        'index' => array( 'Accueil' ),
        'cv' => array( 'Cv' ),
        'projets' => array('Hobbies')
        );
    // ...
    echo '<nav><ul>';
    foreach ($mymenu as $pageId => $pageParameters) {
        /* On parcourt le tableau $mymenu et la clé de l'élément courant est copiée dans $pageId 
        tandis que sa valeur est copiée dans $pageparameters*/
        if ($pageId == $currentPageId) {
            echo '<li class="active"><a href="' . $pageId . '.php">' . $pageParameters . '</a></li>';
        } else {
            echo '<li><a href="' . $pageId . '.php">' . $pageParameters . '</a></li>';
        }
    }
    echo '</ul></nav>';
}
?>
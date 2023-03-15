<?php
function renderMenuToHTML($currentPageId) {
    // un tableau qui d\'efinit la structure du site
    $mymenu = array(
    // idPage titre
        'accueil' => array( 'Accueil' ),
        'cv' => array( 'Cv' ),
        'projets' => array('Hobbies'),
        'contact' => array('Formulaire')
        );
    // ...
    echo '<nav><ul>';
    foreach ($mymenu as $pageId => $pageParameters) {
        /* On parcourt le tableau $mymenu et la clé de l'élément courant est copiée dans $pageId 
        tandis que sa valeur est copiée dans $pageparameters*/
        if ($pageId == $currentPageId) {
            echo '<button><li class="active"><a href="' . $pageId . '">' . $pageParameters[0] . '</a></li></button>';
        } else {
            echo '<button><li><a href="' . 'index.php?page=' . $pageId . '">' . $pageParameters[0] . '</a></li></button>';
        }
    }
    echo '</ul></nav>';
}
?>
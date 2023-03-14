<?php
function renderMenuToHTML($currentPageId) {
// un tableau qui d\'efinit la structure du site
$mymenu = array(
// idPage titre
'index' => array( 'Accueil' ),
'cv' => array( 'Cv' ),
'projets' => array('Mes Projets')
);
// ...
foreach($mymenu as $pageId => $pageParameters) { 
    /* On parcourt le tableau $mymenu et la clé de l'élément courant est copiée dans $pageId 
    tandis que sa valeur est copiée dans $pageparameters*/
    echo 
    '<nav class="menu">
        <ul>
            <button><li><a href="index.php">Accueil</a></li></button>
            <button><li><a href="cv.php">CV</a></li></button>
            <button><li><a href="projets.php">Hobbies</a></li></button>
        </ul>
    </nav>'; }
// ...
}
?>
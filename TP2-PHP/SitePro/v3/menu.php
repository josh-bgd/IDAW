<?php
function renderMenuToHTML($currentPageId) {
   
    // un tableau qui d\'efinit la structure du site
   /* $mymenu = array(
        // idPage titre
        'index' => array( 'Accueil' ),
        'cv' => array( 'CV' ),
        'projets' => array('Hobbies')
    );*/

    // ...
    if ($currentPageId=="index") {
    echo 
    '<nav class="menu">
            <ul>
                <button><li><a id="selected" href="index.php">Accueil</a></li></button>
                <button><li><a href="cv.php">CV</a></li></button>
                <button><li><a href="projets.php">Hobbies</a></li></button>
            </ul>
    </nav>';
    } else if ($currentPageId=="cv" ) {
        echo 
    '<nav class="menu">
            <ul>
                <button><li><a href="index.php">Accueil</a></li></button>
                <button><li><a id="selected" href="cv.php">CV</a></li></button>
                <button><li><a href="projets.php">Hobbies</a></li></button>
            </ul>
    </nav>';
    } else {
        echo 
        '<nav class="menu">
                <ul>
                    <button><li><a href="index.php">Accueil</a></li></button>
                    <button><li><a href="cv.php">CV</a></li></button>
                    <button><li><a id="selected" href="projets.php">Hobbies</a></li></button>
                </ul>
        </nav>'; 
    }
    // ...
}
?>
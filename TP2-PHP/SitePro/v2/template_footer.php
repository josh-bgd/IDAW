<?php
function renderFooterToHTML($currentPageId) {
    if ($currentPageId=="index") {
        echo 
        '<footer>
            <p>Vous êtes sur le footer de la page index</p>
        </footer>';
        } else if ($currentPageId=="cv" ) {
            echo 
        '<footer>
            <p>Vous êtes sur le footer de la page cv</p>
        </footer>';
        } else {
            echo 
        '<footer>
            <p>Vous êtes sur le footer de la page projets</p>
        </footer>'; 
        }
}
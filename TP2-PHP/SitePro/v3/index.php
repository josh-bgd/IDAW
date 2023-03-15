<?php
    $lang = isset($_GET['lang']) ? $_GET['lang'] : 'fr'; // récupère la valeur de la variable GET "lang", sinon défaut en français
    
    $currentPageId = 'accueil';
    if(isset($_GET['page'])) {
        $currentPageId = $_GET['page']; // récupère la valeur de la variable 'page' dans l'URL, sinon définit la valeur par défaut 'accueil'
    } 

    require_once("header.php");
?> 
<header class="bandeau_haut">
<h1 class="titre">Hector Durand</h1>
</header>
<?php
    require_once("menu.php");
    renderMenuToHTML($currentPageId,$lang);
?>
<section class="corps">
<?php
    $pageToInclude = $lang . "/" . $currentPageId . ".php";
    if(is_readable($pageToInclude))
        require_once($pageToInclude);
    else
        require_once($lang . "/error.php");
?>
</section>
<?php
    require_once("footer.php");
?>
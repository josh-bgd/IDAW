<?php
require_once("header.php");
$currentPageId = 'accueil';
if(isset($_GET['page'])) {
   $currentPageId = $_GET['page']; // récupère la valeur de la variable 'page' dans l'URL, sinon définit la valeur par défaut 'accueil'
} ?> 
<header class="bandeau_haut">
<h1 class="titre">Hector Durand</h1>
</header>
<?php
require_once("menu.php");
renderMenuToHTML($currentPageId);
?>
<section class="corps">
<?php
   $pageToInclude = $currentPageId . ".php";
if(is_readable($pageToInclude))
   require_once($pageToInclude);
else
   require_once("error.php");
?>
</section>
<?php
require_once("footer.php");
?>
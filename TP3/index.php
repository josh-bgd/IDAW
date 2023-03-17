<?php
require_once('header.php');

require_once('menu.php');
renderMenuToHTML('index');

require_once('connected.php');
?>
<h1>Si c'est bleu c'est style1, si cest rouge c'est style2</h1>
<h4>La directive 95/46/CE du Parlement européen et du Conseil vise à harmoniser la protection des libertés et droits fondamentaux des personnes physiques en ce qui concerne les activités de traitement et à assurer le libre flux des données à caractère personnel entre les États membres.</h4>
<form id="style_form" action="index.php" method="POST">
    <select name="css">
        <option value="style1">style1</option>
        <option value="style2">style2</option>
    </select>
    <input type="submit" value="Appliquer" />
</form>

<?php
require_once('logout.php');

require_once('footer.php');
renderFooterToHTML('index');
?>
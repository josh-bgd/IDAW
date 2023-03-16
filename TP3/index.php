<form id="style_form" action="index.php" method="GET">
  <select name="css">
<option value="style1">style1</option>
<option value="style2">style2</option>
</select>
<input type="submit" value="Appliquer" />
</form>

<?php
if(isset($_GET['css'])) {
  $style = $_GET['css'];
  setcookie('style_cookie', $style, time()+3600); // stocke la valeur de $style dans un cookie nommé 'style_cookie' pendant 1 heure
}
?>
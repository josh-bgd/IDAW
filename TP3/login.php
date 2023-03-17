<?php
require_once('header.php');

require_once('menu.php');
renderMenuToHTML('login');

require_once('connected.php');
?>

<h1>Test de Style</h1>
<form id="login_form" action="login.php" method="POST">
    <table>
        <tr>
            <th>Login :</th>
            <td><input type="text" name="login"></td>
        </tr>
        <tr>
            <th>Mot de passe :</th>
            <td><input type="password" name="password"></td>
        </tr>
        <tr>
            <th></th>
            <td><input type="submit" value="Se connecter..." /></td>
        </tr>
    </table>
</form>

<?php

require_once('logout.php');

require_once('footer.php');
renderFooterToHTML('login');

?>
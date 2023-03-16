<?php
require_once('header.php');
require_once('menu.php');
renderMenuToHTML('login');
?>

<h1>Test de Style</h1>
<form id="login_form" action="connected.php" method="POST">
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
require_once('footer.php');
renderFooterToHTML('login');
?>
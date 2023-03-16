<?php
if (isset($_COOKIE['style_cookie'])) {
    $style = $_COOKIE['style_cookie'];
} else {
    $style = 'style1'; // fixe un style par défaut
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <?php echo '<link rel="stylesheet" type="text/css" href="' . $style . '.css">'; ?>
    <title>Ma page</title>
</head>

<body>
    <h1>Si c'est bleu c'est style1, si cest rouge c'est style2</h1>
    <h4>La directive 95/46/CE du Parlement européen et du Conseil vise à harmoniser la protection des libertés et droits fondamentaux des personnes physiques en ce qui concerne les activités de traitement et à assurer le libre flux des données à caractère personnel entre les États membres.</h4>
    <form id="style_form" action="index.php" method="GET">
        <select name="css">
            <option value="style1">style1</option>
            <option value="style2">style2</option>
        </select>
        <input type="submit" value="Appliquer" />
    </form>

    <?php
    if (isset($_GET['css'])) {
        $style = $_GET['css'];
        setcookie('style_cookie', $style, time() + 3600); // stocke la valeur de $style dans un cookie nommé 'style_cookie' pendant 1 heure
    }
    ?>
</body>

</html>
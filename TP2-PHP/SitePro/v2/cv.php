<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style1.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../assets/bootstrap/css/bootstrap.min.css">
    <link href="../../../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="../../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <title>index</title>
</head>
<body>
    <header>
    <?php
        require_once('template_menu.php');
        renderMenuToHTML('cv');
    ?>
    </header>
    <p>cette page contient le cv de Josua</p>
    <?php
        require_once('template_footer.php');
        renderFooterToHTML('cv');
    ?>
</body>
</html>
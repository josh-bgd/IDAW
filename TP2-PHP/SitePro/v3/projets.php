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
        renderMenuToHTML('projets');
    ?>
    </header>
    <h1>Projets</h1>
    <div>
        <h2>cette page contient les différents projets de Josua</h2>
        <ul>
            <li>projet 1 : Lorem ipsum dolor sit amet.
                <a href="youtube.com">clique ici pour le voir</a>
            </li>
            <li>projet 2 : Lorem ipsum dolor sit amet consectetur adipisicing.</li>
            <li>projet 3 : Lorem ipsum dolor sit amet consectetur.</li>
            <li>projet 5 : Lorem ipsum dolor sit amet consectetur adipisicing elit.</li>
        </ul>
    </div>
    <?php
        require_once('template_footer.php');
        renderFooterToHTML('projets');
    ?>
</body>
</html>
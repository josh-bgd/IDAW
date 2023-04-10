<?php
require_once('config.php');
require_once('connection.php');
?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset='utf-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script>
        let apifolder = '<?php echo _API_URL; ?>';
    </script>
    <script src="CRUD.js" crossorigin="anonymous"></script>
    <title>tabletest</title>
</head>

<body>
    <?php
    require_once('data.php');
    ?>

    <form id="addStudentForm" action="" onsubmit="onFormsubmit();">
        <div class="form-group row">
            <label for="inputNom" class="col-sm-2 col-form-label">Nom*</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="nom" id="inputNom" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputPrenom" class="col-sm-2 col-form-label">Prenom*</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="prenom" id="inputPrenom" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputDateNaissance" class="col-sm-2 col-form-label">Date de naissance*</label>
            <div class="col-sm-3">
                <input type="date" class="form-control" id="inputDateNaissance" name="date_naissance" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputAimeLeCours" class="col-sm-2 col-form-label">Aime le cours Web</label>
            <div class="col-sm-3">
                <input type="checkbox" class="form-control" name="aime_le_cours" id="inputAimeLeCours">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputRemarques" class="col-sm-2 col-form-label">Remarques</label>
            <div class="col-sm-3">
                <textarea class="form-control" name="remarques" id="inputRemarques"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <span class="col-sm-2"></span>
            <div class="col-sm-2">
                <button type="submit" class="btn btn-primary form-control">Submit</button>
            </div>
        </div>
    </form>
</body>

</html>
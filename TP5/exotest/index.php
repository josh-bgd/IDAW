<!doctype html>
<html lang="fr">
<head>
<meta charset='utf-8'>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
<title>tabletest</title>
<style>
body{ margin-top: 5em; }
.table {
     margin-top: 100px;
margin-bottom: 100px;
}
</style>
</head>
<body onload="updateTable()">
<table class="table">
   <thead>
    <tr>
        <th scope="col">Nom</th>
        <th scope="col">Prenom</th>
        <th scope="col">Date de naissance</th>
        <th scope="col">Aime le cours Web</th>
        <th scope="col">Remarques</th>
        <th scope="col">CRUD</th>
    </tr>
</thead>
<tbody id="studentsTableBody">

</tbody>
</table>

<form id="addStudentForm" action="" onsubmit="onFormsubmit();">
    <div class="form-group row">
        <label for="inputNom" class="col-sm-2 col-form-label">Nom*</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" id="inputNom" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPrenom" class="col-sm-2 col-form-label">Prenom*</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" id="inputPrenom" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputDateNaissance" class="col-sm-2 col-form-label">Date de naissance*</label>
        <div class="col-sm-3">
            <input type="date" class="form-control" id="inputDateNaissance" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputAimeLeCours" class="col-sm-2 col-form-label">Aime le cours Web</label>
        <div class="col-sm-3">
            <input type="checkbox" class="form-control" id="inputAimeLeCours">
        </div>
    </div>
    <div class="form-group row">
        <label for="inputRemarques" class="col-sm-2 col-form-label">Remarques</label>
        <div class="col-sm-3">
            <textarea class="form-control" id="inputRemarques"></textarea>
        </div>
    </div>
    <div class="form-group row">
        <span class="col-sm-2"></span>
        <div class="col-sm-2">
            <button type="submit" class="btn btn-primary form-control">Submit</button>
        </div>
    </div>
</form>




<?php

require_once('config.php');
$connectionString = "mysql:host="._MYSQL_HOST;

if(defined('_MYSQL_PORT'))
    $connectionString .= ";port="._MYSQL_PORT;

$connectionString .= ";dbname="._MYSQL_DBNAME;
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' );

$pdo = NULL;
try {
    $pdo = new PDO($connectionString,_MYSQL_USER,_MYSQL_PASSWORD,$options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $erreur) {
    echo 'Erreur : '.$erreur->getMessage();
};

header("Access-Control-Allow-Origin:*");

// Création de la table "Utilisateur"
$sql = "CREATE TABLE IF NOT EXISTS Utilisateur (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    date_naissance DATE NOT NULL,
    aime_le_cours VARCHAR(255) NOT NULL DEFAULT '0',
    remarques TEXT
)";

if ($pdo->query($sql) === FALSE) {
    die("Erreur lors de la création de la table : " . $pdo->errorInfo()[2]);
}
?>

<script>
    let apifolder = '<?php 
    require_once('config.php');
    echo _APIURL;?>';
    let selectedRow = null;
    let students = [];

    function onFormsubmit() {
        event.preventDefault();
        let nom = $("#inputNom").val();
        let prenom = $("#inputPrenom").val();
        let dateNaissance = $("#inputDateNaissance").val();
        let aimeLeCours = $("#inputAimeLeCours").prop('checked');
        let remarques = $("#inputRemarques").val();

        if (nom.trim() !== '') {
            if (selectedRow) { // Si une ligne est sélectionnée, on la modifie
                let index = selectedRow.attr('data-index');
                //students[index] = {nom, prenom, dateNaissance, aimeLeCours, remarques};
                $.ajax({
                    url: apifolder + '/restapi.php',
                    type: 'PUT',
                    data: JSON.stringify({id: index, nom: nom, prenom: prenom, date_naissance: dateNaissance, aime_le_cours: aimeLeCours, remarques: remarques}),
                    success: function(responsejson) {
                        // Mettre à jour la ligne modifiée avec les nouvelles informations
                        console.log(responsejson);
                        updateTable(); // UPDATER UNIQUEMENT LA LIGNE ET NE PAS UTILISER CETTE FONCTION QUI RECHARGE TOUTES LA TABLE
                        selectedRow = null;
                        // Réinitialiser le formulaire
                        $("#addStudentForm").trigger("reset");
                        $("#inputNom").focus();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
                // selectedRow = null; // On désélectionne la ligne
            } else { // Sinon, on ajoute une nouvelle ligne
                $.ajax({
                    url: apifolder + '/restapi.php',
                    type: "POST",
                    data: JSON.stringify({nom: nom, prenom: prenom, date_naissance: dateNaissance, aime_le_cours: aimeLeCours, remarques: remarques}),
                    contentType: "application/json",
                    success: function(data) {
                        console.log(data);
                        // Si la requête a réussi, on ajoute l'utilisateur dans le tableau
                        students.push({nom, prenom, dateNaissance, aimeLeCours, remarques});
                        updateTable();                        
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert("Erreur lors de l'ajout de l'utilisateur.");
                        console.log(textStatus, errorThrown);
                    }

                });
            }
            // On réinitialise le formulaire
            $("#addStudentForm").trigger("reset");
            $("#inputNom").focus();
        }
    };

    function updateTable() { 
        let tableBody = $("#studentsTableBody");
        tableBody.empty();
        $.ajax({
            url: apifolder + '/restapi.php',
            method: "GET",
            success: function(students) {
            for (let i = 0; i < students.length; i++) {
                let student = students[i];
                tableBody.append(`
                <tr data-index="${student.id}">
                    <td>${student.nom}</td>
                    <td>${student.prenom}</td>
                    <td>${student.date_naissance}</td>
                    <td>${student.aime_le_cours ? 'Oui' : 'Non'}</td>
                    <td>${student.remarques}</td>
                    <td>
                        <button type="button" class="btn btn-warning" onclick="onEdit(this)">Editer</button>
                        <button type="button" class="btn btn-danger" onclick="onDelete(this)">Supprimer</button>
                    </td>
                </tr>
                `);
            }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("Erreur pour récupere les données de la table MySQL");
                console.log(textStatus, errorThrown);
            }
        });
    }

    function onEdit(button) {
        selectedRow = $(button).closest("tr");
        let id = selectedRow.attr('data-index');

        $("#inputNom").val(selectedRow.children().eq(0).text());
        $("#inputPrenom").val(selectedRow.children().eq(1).text());
        $("#inputDateNaissance").val(selectedRow.children().eq(2).text());
        $("#inputAimeLeCours").prop('checked', selectedRow.children().eq(3).text() === 'Oui');
        $("#inputRemarques").val(selectedRow.children().eq(4).text());
    }

    function onDelete(button) {
        let selectedRow = $(button).closest("tr");
        let index = selectedRow.attr('data-index');
        //students.splice(index, 1);
        $.ajax({
            url: apifolder + '/restapi.php',
            method: "DELETE",
            data: JSON.stringify({id: index}),
            success: function(response) { 
                updateTable();           
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("Erreur pour récupere les données de la table MySQL");
                console.log(textStatus, errorThrown);
            }
        });
    }
</script>


</body>
</html>
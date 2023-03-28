<!doctype html>
<html lang="fr">

<head>
    <meta charset='utf-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <title>tabletest</title>
    <style>
        body {
            margin-top: 5em;
        }

        .table {
            margin-top: 100px;
            margin-bottom: 100px;
        }
    </style>
</head>

<body>

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

    <form id="addStudentForm" action="" method="POST" onsubmit="onFormsubmit();">
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

    <?php
    require_once('config.php');
    $connectionString = "mysql:host=" . _MYSQL_HOST;

    if (defined('_MYSQL_PORT'))
        $connectionString .= ";port=" . _MYSQL_PORT;

    $connectionString .= ";dbname=" . _MYSQL_DBNAME;
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

    $pdo = NULL;
    try {
        $pdo = new PDO($connectionString, _MYSQL_USER, _MYSQL_PASSWORD, $options);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $erreur) {
        echo 'Erreur : ' . $erreur->getMessage();
    };

    header("Access-Control-Allow-Origin:*");

    $sql = "CREATE TABLE IF NOT EXISTS Utilisateur (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(30) NOT NULL,
        prenom VARCHAR(30) NOT NULL,
        date_naissance DATE,
        aime_le_cours BOOLEAN,
        remarques TEXT,
        age INT(3) NOT NULL DEFAULT 0
    )";


    if ($pdo->query($sql) === FALSE) {
        $error = $pdo->errorInfo();
        echo "Error creating table: " . $error[2];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $date_naissance = date('Y-m-d', strtotime($_POST['date_naissance']));
        $aime_le_cours = isset($_POST['aime_le_cours']) ? 1 : 0;
        $remarques = $_POST['remarques'];

        $sql = "INSERT INTO Utilisateur (nom, prenom, date_naissance, aime_le_cours, remarques)
                VALUES ('$nom', '$prenom', '$date_naissance', '$aime_le_cours', '$remarques')";

        if ($pdo->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            $error = $pdo->errorInfo();
            echo "Error creating table: " . $error[2];
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $sql = "SELECT * FROM Utilisateur";
        $result = $pdo->query($sql);
        if ($result->rowCount() > 0) {
            $rows = array();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        } else {
            echo json_encode(array('message' => 'No user found.'));
        }
    } else {
        echo json_encode(array('message' => 'Invalid request method.'));
    }


    $pdo = null;;
    ?>


    <script>
        let apifolder = '';
        let selectedRow = null;
        let students = [];

        function resetForm() {
            $("#inputNom").val('');
            $("#inputPrenom").val('');
            $("#inputDateNaissance").val('');
            $("#inputAimeLeCours").prop('checked', false);
            $("#inputRemarques").val('');
            selectedRow = null;
        }

        function onFormsubmit() {
            event.preventDefault();
            let nom = $("#inputNom").val();
            let prenom = $("#inputPrenom").val();
            let dateNaissance = $("#inputDateNaissance").val();
            let aimeLeCours = $("#inputAimeLeCours").prop('checked');
            let remarques = $("#inputRemarques").val();
            let student = {
                nom: nom,
                prenom: prenom,
                dateNaissance: dateNaissance,
                aimeLeCours: aimeLeCours,
                remarques: remarques
            };
            if (selectedRow == null) {
                addStudent(student);
            } else {
                updateStudent(student);
            }
            resetForm();
        }

        function addStudent(student) {
            $.ajax({
                type: "POST",
                url: apifolder + "ApiREST.php",
                data: JSON.stringify(student),
                success: function(response) {
                    console.log(response);
                    readStudents();
                },
                error: function(response) {
                    console.log(response);
                }
            });
        }

        function readStudents() {
            $.ajax({
                type: "GET",
                url: apifolder + "ApiREST.php",
                success: function(response) {
                    console.log(response);
                    students = JSON.parse(response);
                    displayStudents(students);
                },
                error: function(response) {
                    console.log(response);
                }
            });
        }

        function updateStudent(student) {
            $.ajax({
                type: "POST",
                url: apifolder + "ApiREST.php",
                data: JSON.stringify(student),
                success: function(response) {
                    console.log(response);
                    readStudents();
                },
                error: function(response) {
                    console.log(response);
                }
            });
        }

        function deleteStudent(id) {
            $.ajax({
                type: "POST",
                url: apifolder + "ApiREST.php",
                data: JSON.stringify({
                    id: id
                }),
                success: function(response) {
                    console.log(response);
                    readStudents();
                },
                error: function(response) {
                    console.log(response);
                }
            });
        }

        function onEdit(button) {
            let student = $(button).data("student");
            selectedRow = $(button).closest("tr")[0];
            $("#inputNom").val(student.nom);
            $("#inputPrenom").val(student.prenom);
            $("#inputDateNaissance").val(student.dateNaissance);
            $("#inputAimeLeCours").prop('checked', student.aimeLeCours);
            $("#inputRemarques").val(student.remarques);
        }

        function onDelete(button) {
            let id = $(button).data("id");
            deleteStudent(id);
        }
    </script>
</body>

</html>
<?php
$pdo = new PDO($connectionString, _MYSQL_USER, _MYSQL_PASSWORD, $options);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $date_naissance = date('Y-m-d', strtotime($_POST['date_naissance']));
    $aime_le_cours = isset($_POST['aime_le_cours']) ? 1 : 0;
    $remarques = $_POST['remarques'];

    $sql = "INSERT INTO Utilisateur (nom, prenom, date_naissance, aime_le_cours, remarques)
        VALUES ('$nom', '$prenom', '$date_naissance', '$aime_le_cours', '$remarques')";

    if ($pdo->query($sql) === FALSE) {
        $error = $pdo->errorInfo();
        echo "Error inserting data: " . $error[2];
    }
}


$sql = "SELECT * FROM Utilisateur";
$stmt = $pdo->query($sql);


$rows = '';
while ($row = $stmt->fetch()) {
    $aime_le_cours = $row['aime_le_cours'] ? 'Oui' : 'Non';
    $rows .= "<tr><td>{$row['nom']}</td><td>{$row['prenom']}</td>
    <td>{$row['date_naissance']}</td><td>{$aime_le_cours}</td>
    <td>{$row['remarques']}</td>
    <td>
    <button class='btn btn-info btn-sm edit-btn' data-id='{$row['id']}' onclick='onEdit(this)'>Editer</button>
     <button class='btn btn-danger btn-sm delete-btn' data-id='{$row['id']}' onclick='onDelete(this)'>Supprimer</button>
     </td</tr>";
}

// Add rows to table body
echo '<table class="table">';
echo '<thead><tr><th scope="col">Nom</th><th scope="col">Prenom</th><th scope="col">Date de naissance</th><th scope="col">Aime le cours Web</th><th scope="col">Remarques</th><th scope="col">CRUD</th></tr></thead>';
echo '<tbody id="studentsTableBody">';
echo $rows;
echo '</tbody></table>';

$pdo = null;

<?php
require_once('config.php');
require_once('connection.php');

$request_method = $_SERVER["REQUEST_METHOD"];


switch ($request_method) {
    case 'GET':
        getAllUsers();
        break;
    case 'POST':
        createUser();
        break;
    case 'PUT':
        updateUser();
        break;
    case 'DELETE':
        deleteUser();
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function getAllUsers()
{
    global $pdo;
    // Récupération des utilisateurs
    $request = $pdo->prepare('select * from Utilisateur');
    $request->execute();
    $Utilisateur = $request->fetchAll(PDO::FETCH_OBJ);

    // Conversion en JSON
    $json = json_encode($Utilisateur);

    // HTPP response of 200 OK
    header('HTTP/1.1 200 OK');
    header('Content-Type: application/json');
    echo $json;
}

function createUser()
{
    global $pdo;
    $userData = json_decode(file_get_contents('php://input'), true);

    $nom = $userData['nom'];
    $prenom = $userData['prenom'];
    $date_naissance = isset($userData['date_naissance']) ? date('Y-m-d', strtotime($userData['date_naissance'])) : null;
    $aime_le_cours = isset($userData['aime_le_cours']) ? intval($userData['aime_le_cours']) : 0;
    $remarques = isset($userData['remarques']) ? $userData['remarques'] : null;

    if (empty($nom) || empty($prenom) || empty($date_naissance)) {
        header('HTTP/1.1 400 Bad Request');
        echo ' Missing parameter 1 ';
        return;
    }

    $stmt = $pdo->prepare("INSERT INTO `Utilisateur` (`id`, `nom`, `prenom`, `date_naissance`, `aime_le_cours`, `remarques`) VALUES (NULL, :nom, :prenom, :date_naissance, :aime_le_cours, :remarques)");
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':date_naissance', $date_naissance);
    $stmt->bindParam(':aime_le_cours', $aime_le_cours);
    $stmt->bindParam(':remarques', $remarques);

    if ($stmt->execute()) {
        echo 'Data inserted successfully!';
        http_response_code(201);
    } else {
        echo 'Error inserting data';
    }
}



function updateUser()
{
    $userData = json_decode(file_get_contents('php://input'), true);

    $nom = $userData['nom'];
    $prenom = $userData['prenom'];
    $date_naissance = $userData['date_naissance'];
    $aime_le_cours = $userData['aime_le_cours'];
    $remarques = $userData['remarques'];

    global $pdo;
    $sql = "UPDATE Utilisateur SET nom = :nom, prenom = :prenom, date_naissance = :date_naissance, aime_le_cours = :aime_le_cours, remarques = :remarques WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':date_naissance', $date_naissance);
    $stmt->bindParam(':aime_le_cours', $aime_le_cours);
    $stmt->bindParam(':remarques', $remarques);
    $stmt->bindParam(':id', $userData['id']);


    if ($stmt->execute()) {
        $result = [
            'status' => true,
            'message' => 'User updated successfully'
        ];
    } else {
        $result = [
            'status' => false,
            'message' => 'Error updating user'
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($result);
}



function deleteUser()
{
    global $pdo;

    $userData = json_decode(file_get_contents('php://input'), true);

    if (!isset($userData['id'])) {
        echo json_encode(['error' => 'ID is required']);
        return;
    }

    $id = $userData['id'];

    $stmt = $pdo->prepare("DELETE FROM Utilisateur WHERE id=:id");
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => 'User deleted successfully']);
    } else {
        echo json_encode(['error' => 'User deletion failed']);
    }
}



$pdo = null;

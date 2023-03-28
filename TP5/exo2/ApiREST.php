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
        header("HTTP/1.0 405 Method Not ALlowed");
        break;
};



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
    $aime_le_cours = isset($userData['aime_le_cours']) ? $userData['aime_le_cours'] : 0;
    $remarques = isset($userData['remarques']) ? $userData['remarques'] : null;

    print("Received name: " . $nom);
    print("Received prename: " . $prenom);
    print("Received date: "  . $date_naissance);

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

    $id = $userData['id'];
    $nom = $userData['nom'];
    $prenom = $userData['prenom'];
    $date_naissance = $userData['date_naissance'];
    $aime_le_cours = $userData['aime_le_cours'];
    $remarques = $userData['remarques'];
    if (empty($id) || empty($nom) || empty($prenom) || empty($date_naissance) || empty($aime_le_cours)) {
        header('HTTP/1.1 400 Bad Request');
        echo 'Missing parameter 2';
        return;
    }

    // Connexion à la base de données
    global $pdo;

    // Modification de l'utilisateur dans la base de données
    $stmt = $pdo->prepare('UPDATE Utilisateur SET nom = ?, prenom = ?, date_naissance = ?, aime_le_cours = ?, remarques = ? WHERE id = ?');
    $stmt->execute([$nom, $prenom, $date_naissance, $aime_le_cours, $remarques, $id]);


    // Envoi de la réponse HTTP
    header('HTTP/1.1 204 No Content');
}


function deleteUser()
{
    // Vérification des paramètres
    $userData = json_decode(file_get_contents('php://input'), true);
    $id = $userData['id'];
    if (empty($id)) {
        header('HTTP/1.1 400 Bad Request');
        echo 'Missing parameter 3';
        return;
    }
    global $pdo;
    // Suppression de l'utilisateur de la base de données
    $stmt = $pdo->prepare('DELETE FROM Utilisateur WHERE id = ?');
    $stmt->execute([$id]);

    // Envoi de la réponse HTTP
    header('HTTP/1.1 204 No Content');
}

$pdo = null;
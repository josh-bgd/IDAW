<?php

require_once('config.php');
require_once('connexionBD.php');

$request_method = $_SERVER["REQUEST_METHOD"];

switch($request_method)
{
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



function getAllUsers() {
    global $pdo;
    // Récupération des utilisateurs
    $request = $pdo->prepare('select * from Utilisateur');
    $request->execute();
    $users = $request->fetchAll(PDO::FETCH_OBJ);
    
    // Conversion en JSON
    $json = json_encode($users);
    echo $json;

    // HTPP response of 200 OK
    header('HTTP/1.1 200 OK');
    http_response_code(200);
    header('Content-Type: application/json');
    
}

function createUser() {
    global $pdo;
    $userData = json_decode(file_get_contents('php://input'),true);

    $nom = $userData['nom'];
    $prenom = $userData['prenom'];
    $date_naissance = $userData['date_naissance'];
    $aime_le_cours = $userData['aime_le_cours'];
    $remarques = $userData['remarques'];

    $stmt = $pdo->prepare("INSERT INTO Utilisateur (nom, prenom, date_naissance, aime_le_cours, remarques) VALUES ( ? , ? , ? , ? , ? )");

    if($stmt->execute([$nom, $prenom, $date_naissance, $aime_le_cours, $remarques])) {
        http_response_code(201);
    } else {
        echo 'Error inserting data';
    }
    
}

function updateUser(){
    global $pdo;
    $userData = json_decode(file_get_contents('php://input'),true);

    // Récupérer les données envoyées depuis le formulaire
    $id = $userData['id'];
    $nom = $userData['nom'];
    $prenom = $userData['prenom'];
    $date_naissance = $userData['date_naissance'];
    $aime_le_cours = $userData['aime_le_cours'];
    $remarques = $userData['remarques'];

    // Préparer la requête d'insertion des données dans la table "utilisateurs"
    $stmt = $pdo->prepare('UPDATE Utilisateur SET nom = ?, prenom = ?, date_naissance = ?, aime_le_cours = ?, remarques = ? WHERE id = ?');
    $stmt -> execute([$nom, $prenom, $date_naissance, $aime_le_cours, $remarques, $id]);

    // Fermer la connexion à la base de données
    $pdo = null;

    // Renvoyer une réponse JSON à la requête AJAX
    $response = array('status' => 'success', 'message' => 'Utilisateur ajouté avec succès');
    //echo json_encode($response);
}


    function deleteUser() {
        $userData = json_decode(file_get_contents('php://input'),true);
        $id = $userData['id'];
        if (empty($id)) {
            header('HTTP/1.1 400 Bad Request');
            echo 'Missing parameter';
            return;
        }
        global $pdo;
        // Suppression de l'utilisateur de la base de données
        $stmt = $pdo->prepare('DELETE FROM Utilisateur WHERE id = ?');
        $stmt -> execute([$id]);
        
        // Envoi de la réponse HTTP
        header('HTTP/1.1 204 No Content');
    }

    $pdo = null;
?>
<?php

require_once('config.php');
require_once('init_pdo.php');

$request_method = $_SERVER["REQUEST_METHOD"];

switch($request_method)
{
    case 'GET':
        if(isset($_GET['id'])){
            getone($_GET['id']);
        }else{
            getall();
        }
        break;
    case 'POST':
        add();
        break;
    case 'PUT':
        modify();
        break;
    case 'DELETE':
        delete();
        break;
    default:
    header("HTTP/1.0 405 Method Not ALlowed");
    break;
};

// Ne pas oublier les ORDER BY pour afficher des tables trié (ascendant: default, sinon ajouter DESC)

function getall() {
    global $pdo;
    // Récupération des utilisateurs
    $request = $pdo->prepare('select * from Utilisateur');
    $request->execute();
    $users = $request->fetchAll(PDO::FETCH_OBJ);
    
    // Conversion en JSON
    $json = json_encode($users);
    echo $json; // on envoie la réponse de la requête 

    // HTPP response of 200 OK
    http_response_code(200);
    
}

function getone($id) {
    global $pdo;
    // Récupération des utilisateurs
    $stmt = $pdo->prepare("SELECT * FROM Utilisateur WHERE id = ?");
    $stmt->execute([$id]);
    $users = $request->fetchAll(PDO::FETCH_OBJ);
    
    // Conversion en JSON
    $json = json_encode($users);
    echo $json; // on envoie la réponse de la requête 

    // HTPP response of 200 OK
    http_response_code(200);
    
}

function add() {
    global $pdo;
    $userData = json_decode(file_get_contents('php://input'),true);

    $nom = $userData['nom'];
    $prenom = $userData['prenom'];

    $stmt = $pdo->prepare("INSERT INTO Utilisateur (nom, prenom) VALUES ( ? , ?)");

    if($stmt->execute([$nom, $prenom])) {
        $id = $pdo->lastInsertId();
        $indicateur = array('id_indicateur' => $id, 'nom' => $nom, 'prenom' => $prenom);
        $json = json_encode($indicateur);
        echo $json;
    } else {
        echo 'Error inserting data';
    }
    
}

function modify(){
    global $pdo;
    $userData = json_decode(file_get_contents('php://input'),true);

    // Récupérer les données envoyées depuis le formulaire
    $id = $userData['id'];
    $nom = $userData['nom'];

    $stmt = $pdo->prepare('UPDATE Utilisateur SET nom = ?WHERE id = ?');

    $stmt -> execute([$nom, $id]);

    // OPTIONNEL: Renvoyer une réponse JSON à la requête AJAX à afficher avec console.log
    $response = array('status' => 'success', 'message' => 'Utilisateur ajouté avec succès');
    echo json_encode($response);
}


function delete() {
    global $pdo;
    $userData = json_decode(file_get_contents('php://input'),true);
    $id = $userData['id'];
    if (empty($id)) {
        header('HTTP/1.1 400 Bad Request');
        echo 'Missing parameter';
        return;
    }
    // Suppression de l'utilisateur de la base de données
    $stmt = $pdo->prepare('DELETE FROM Utilisateur WHERE id = ?');
    $stmt -> execute([$id]);
}

    $pdo = null;
?>
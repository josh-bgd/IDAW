<?php

require_once('config.php');
require_once('init_pdo.php');

$request_method = $_SERVER["REQUEST_METHOD"];

switch($request_method)
{
    case 'GET':
        if(isset($_GET['login'])){
            getuserbylogin($_GET['login']);
        }else{
            getalluser();
        }
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


function getuserbylogin($login) {
    global $pdo;
    // Récupération des utilisateurs
    $request = $pdo->prepare('SELECT * FROM utilisateur WHERE login = ?');
    $request->execute([$login]);
    $users = $request->fetchAll(PDO::FETCH_OBJ);
    
    // Conversion en JSON
    $json = json_encode($users);
    echo $json; // on envoie la réponse de la requête 

    // HTPP response of 200 OK
    http_response_code(200);
    
}

function getalluser() {
    global $pdo;
    // Récupération des utilisateurs
    $request = $pdo->prepare('SELECT * FROM utilisateur ORDER BY nom ASC');
    $request->execute();
    $users = $request->fetchAll(PDO::FETCH_OBJ);
    
    // Conversion en JSON
    $json = json_encode($users);
    echo $json; // on envoie la réponse de la requête 

    // HTPP response of 200 OK
    http_response_code(200);
    
}

function createUser() {
    global $pdo;
    $userData = json_decode(file_get_contents('php://input'),true);

    $login = $userData['login'];
    $motdepasse = $userData['motdepasse'];
    $prenom = $userData['prenom'];
    $nom = $userData['nom'];
    $email = $userData['email'];
    $date_de_naissance = $userData['date_de_naissance'];
    $id_sexe = $userData['id_sexe'];
    $id_tranche_age = $userData['id_tranche_age'];
    $id_niveau = $userData['id_niveau'];
    $taille = $userData['taille'];
    $poids = $userData['poids'];

    $stmt = $pdo->prepare("INSERT INTO Utilisateur (login, motdepasse, prenom, nom, email, date_de_naissance, taille, poids, id_sexe, id_tranche_age, id_niveau) VALUES ( ? , ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if($stmt->execute([$login, $motdepasse, $prenom, $nom, $email, $date_de_naissance, $taille, $poids, $id_sexe, $id_tranche_age, $id_niveau])) {
        echo 'Data inserted';
    } else {
        echo 'Error inserting data';
    }
}


function updateUser() {
    global $pdo;
    $userData = json_decode(file_get_contents('php://input'), true);

    $login = $userData['login'];
    $motdepasse = $userData['motdepasse'];
    $prenom = $userData['prenom'];
    $nom = $userData['nom'];
    $email = $userData['email'];
    $date_de_naissance = $userData['date_de_naissance'];
    $taille = $userData['taille'];
    $poids = $userData['poids'];
    $id_sexe = $userData['id_sexe'];
    $id_tranche_age = $userData['id_tranche_age'];
    $id_niveau = $userData['id_niveau'];

    $stmt = $pdo->prepare("UPDATE utilisateur SET motdepasse=?, prenom=?, nom=?, email=?, date_de_naissance=?, taille=?, poids=?, id_sexe=?, id_tranche_age=?, id_niveau=? WHERE login=?");

    if ($stmt->execute([$motdepasse, $prenom, $nom, $email, $date_de_naissance, $taille, $poids, $id_sexe, $id_tranche_age, $id_niveau, $login])) {
        $response = array('status' => 'success', 'message' => 'Utilisateur mis à jour avec succès');
        echo json_encode($response);
    } else {
        echo 'Error updating data';
    }
}

function deleteUser() {
    global $pdo;
    $userData = json_decode(file_get_contents('php://input'), true);
    $login = $userData['login'];
    if (empty($login)) {
        header('HTTP/1.1 400 Bad Request');
        echo 'Missing parameter';
        return;
    }
    // Suppression de l'utilisateur de la base de données
    $stmt = $pdo->prepare('DELETE FROM Utilisateur WHERE login = ?');
    $stmt->execute([$login]);
    
    http_response_code(200);
}


    $pdo = null;
?>
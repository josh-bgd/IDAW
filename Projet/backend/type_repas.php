<?php

require_once('config.php');
require_once('init_pdo.php');

$request_method = $_SERVER["REQUEST_METHOD"];

switch($request_method)
{
    case 'GET':
        if(isset($_GET['nom_repas'])){
            getone($_GET['nom_repas']);
        }else{
            getall();
        }
        break;
    default:
    header("HTTP/1.0 405 Method Not ALlowed");
    break;
};

// Ne pas oublier les ORDER BY pour afficher des tables trié (ascendant: default, sinon ajouter DESC)

function getall() {
    global $pdo;
    // Récupération des utilisateurs
    $request = $pdo->prepare('select * from type_repas');
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
    $stmt = $pdo->prepare("SELECT * FROM type_repas WHERE nom_repas = ?");
    $stmt->execute([$id]);
    $users = $stmt->fetchAll(PDO::FETCH_OBJ);
    
    // Conversion en JSON
    $json = json_encode($users);
    echo $json; // on envoie la réponse de la requête 

    // HTPP response of 200 OK
    http_response_code(200);
    
}

    $pdo = null;
?>
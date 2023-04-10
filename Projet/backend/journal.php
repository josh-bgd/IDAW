<?php

require_once('config.php');
require_once('init_pdo.php');

$request_method = $_SERVER["REQUEST_METHOD"];

switch($request_method)
{
    case 'GET':
        if(isset($_GET['id_journal'])){
            getonejournal($_GET['id_journal']);
        } else if (isset($_GET['date']) && isset($_GET['login'])) {
            getone($_GET['date'], $_GET['login']);
        } else {
            getalljournal();
        }
        break;
    case 'POST':
        addjournal();
        break;
    case 'PUT':
        changejournal();
        break;
    case 'DELETE':
        deletejournal();
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
};

function getalljournal() {
    global $pdo;
    // Récupération des journaux
    $request = $pdo->prepare('SELECT * FROM journal');
    $request->execute();
    $journals = $request->fetchAll(PDO::FETCH_OBJ);
    
    // Conversion en JSON
    $json = json_encode($journals);
    echo $json; // on envoie la réponse de la requête 

    // HTPP response of 200 OK
    http_response_code(200);   
}

function getonejournal($id) {
    global $pdo;
    // Récupération du journal
    $stmt = $pdo->prepare("SELECT * FROM journal WHERE id_journal = ?");
    $stmt->execute([$id]);
    $journal = $stmt->fetch(PDO::FETCH_OBJ);
    
    // Conversion en JSON
    $json = json_encode($journal);
    echo $json; // on envoie la réponse de la requête 

    // HTPP response of 200 OK
    http_response_code(200);  
}

function getone($date, $login) {
    global $pdo;
    // Récupération du journal
    $stmt = $pdo->prepare("SELECT * FROM journal WHERE login = ? AND date = ?");
    $stmt->execute([$login, $date]);
    $journal = $stmt->fetchAll(PDO::FETCH_OBJ);
    
    // Conversion en JSON
    $json = json_encode($journal);
    echo $json; // on envoie la réponse de la requête 

    // HTPP response of 200 OK
    http_response_code(200);  
}


function addjournal() {
    global $pdo;
    $journalData = json_decode(file_get_contents('php://input'),true);

    $id_type_repas = $journalData['id_type_repas'];
    $login = $journalData['login'];
    $date = $journalData['date'];

    $stmt = $pdo->prepare("INSERT INTO journal (id_type_repas, login, date) VALUES (?, ?, ?)");

    if($stmt->execute([$id_type_repas, $login, $date])) {
        $id = $pdo->lastInsertId();
        $data = array('id_journal' => $id, 'id_type_repas' => $id_type_repas, 'login' => $login, 'date' => $date);
        $json = json_encode($data);
        echo $json;
    } else {
        echo 'Error inserting data';
    }   
}

function changejournal(){
    global $pdo;
    $journalData = json_decode(file_get_contents('php://input'),true);

    // Récupérer les données envoyées depuis le formulaire
    $id = $journalData['id_journal'];
    $id_type_repas = $journalData['id_type_repas'];
    $login = $journalData['login'];
    $date = $journalData['date'];

    $stmt = $pdo->prepare('UPDATE journal SET id_type_repas = ?, login = ?, date = ? WHERE id_journal = ?');

    $stmt -> execute([$id_type_repas, $login, $date, $id]);

    // OPTIONNEL: Renvoyer une réponse JSON à la requête AJAX à afficher avec console.log
    $response = array('status' => 'success', 'message' => 'Journal mis à jour avec succès');
    echo json_encode($response);
}


function deletejournal() {
    global $pdo;
    $journalData = json_decode(file_get_contents('php://input'),true);
    $id = $journalData['id_journal'];
    if (empty($id)) {
        header('HTTP/1.1 400 Bad Request');
        echo 'Missing parameter';
        return;
    }
    // Suppression du journal de la base de données
    $stmt = $pdo->prepare('DELETE FROM journal WHERE id_journal = ?');
    $stmt -> execute([$id]);
}


$pdo = null;
?>
<?php

require_once('config.php');
require_once('init_pdo.php');

$request_method = $_SERVER["REQUEST_METHOD"];

switch($request_method)
{
    case 'GET':
        if(isset($_GET['id_journal']) && isset($_GET['id_aliment'])){
            getoneconsommation($_GET['id_journal'], $_GET['id_aliment']);
        }else{
            getallconsommation();
        }
        break;
    case 'POST':
        addconsommation();
        break;
    case 'PUT':
        changeconsommation();
        break;
    case 'DELETE':
        deleteconsommation();
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
};

function getallconsommation() {
    global $pdo;
    // Récupération des consommations
    $request = $pdo->prepare('SELECT * FROM consommation');
    $request->execute();
    $consommations = $request->fetchAll(PDO::FETCH_OBJ);
    
    // Conversion en JSON
    $json = json_encode($consommations);
    echo $json;
    
    // HTTP response of 200 OK
    http_response_code(200);
}

function getoneconsommation($id_journal, $id_aliment) {
    global $pdo;
    // Récupération de la consommation
    $stmt = $pdo->prepare("SELECT * FROM consommation WHERE id_journal = ? AND id_aliment = ?");
    $stmt->execute([$id_journal, $id_aliment]);
    $consommation = $stmt->fetchAll(PDO::FETCH_OBJ);
    
    // Conversion en JSON
    $json = json_encode($consommation);
    echo $json;
    
    // HTTP response of 200 OK
    http_response_code(200);
}

function addconsommation() {
    global $pdo;
    $consommationData = json_decode(file_get_contents('php://input'),true);

    $id_journal = $consommationData['id_journal'];
    $id_aliment = $consommationData['id_aliment'];
    $quantite = $consommationData['quantite'];

    $stmt = $pdo->prepare("INSERT INTO consommation (id_journal, id_aliment, quantite) VALUES (?, ?, ?)");

    if($stmt->execute([$id_journal, $id_aliment, $quantite])) {
        echo 'Data inserted';
    } else {
        echo 'Error inserting data';
    }
    
}

function changeconsommation(){
    global $pdo;
    $consommationData = json_decode(file_get_contents('php://input'),true);

    // Récupérer les données envoyées depuis le formulaire
    $id_journal = $consommationData['id_journal'];
    $id_aliment = $consommationData['id_aliment'];
    $quantite = $consommationData['quantite'];

    $stmt = $pdo->prepare('UPDATE consommation SET quantite = ? WHERE id_journal = ? AND id_aliment = ?');

    $stmt -> execute([$quantite, $id_journal, $id_aliment]);

    // OPTIONNEL: Renvoyer une réponse JSON à la requête AJAX à afficher avec console.log
    $response = array('status' => 'success', 'message' => 'Consommation modifiée avec succès');
    echo json_encode($response);
}


function deleteconsommation() {
    global $pdo;
    $requestData = json_decode(file_get_contents('php://input'), true);
    $idJournal = $requestData['id_journal'];
    $idAliment = $requestData['id_aliment'];
    
    if (empty($idJournal) || empty($idAliment)) {
        header('HTTP/1.1 400 Bad Request');
        echo 'Missing parameter';
        return;
    }
    // Suppression de la consommation de la base de données
    $stmt = $pdo->prepare('DELETE FROM consommation WHERE id_journal = ? AND id_aliment = ?');
    if ($stmt->execute([$idJournal, $idAliment])) {
        $response = array('status' => 'success', 'message' => 'Consommation supprimée avec succès');
        echo json_encode($response);
        http_response_code(200);
    } else {
        echo 'Error deleting data';
    }
}

$pdo = null;
?>
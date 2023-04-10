<?php

require_once('config.php');
require_once('init_pdo.php');

$request_method = $_SERVER["REQUEST_METHOD"];

switch($request_method)
{
    case 'GET':
        if(isset($_GET['id_aliment'])){
            getAliment($_GET['id_aliment']);
        } else if (isset($_GET['nom'])) {
            getId($_GET['nom']);
        } else{
            getAllAliments();
        }
        break;
    case 'POST':
        createAliment();
        break;
    case 'PUT':
        updateAliment();
        break;
    case 'DELETE':
        deleteAliment();
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
};

function getAllAliments() {
    global $pdo;
    $request = $pdo->prepare('SELECT * FROM aliments');
    $request->execute();
    $aliments = $request->fetchAll(PDO::FETCH_OBJ);
    $json = json_encode($aliments);
    echo $json;
    http_response_code(200);
}

function getAliment($id_aliment){
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM aliments WHERE id_aliment = ?");
    $stmt->execute([$id_aliment]);
    $aliment = $stmt->fetch(PDO::FETCH_OBJ);
    if(!$aliment){
        header("HTTP/1.0 404 Not Found");
        echo json_encode(["error" => "Aliment introuvable"]);
        return;
    }
    $json = json_encode($aliment);
    echo $json;
    http_response_code(200);
}

function getId($nom){
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM aliments WHERE nom = ?");
    $stmt->execute([$nom]);
    $aliment = $stmt->fetchAll(PDO::FETCH_OBJ);
    $json = json_encode($aliment);
    echo $json;
    http_response_code(200);
}

function createAliment() {
    global $pdo;
    $alimentData = json_decode(file_get_contents('php://input'), true);

    $id_aliment = $alimentData['id_aliment'];
    $nom = $alimentData['nom'];
    $id_type = $alimentData['id_type'];

    $stmt = $pdo->prepare("INSERT INTO aliments (id_aliment, nom, id_type) VALUES (?, ?, ?)");

    if ($stmt->execute([$id_aliment, $nom, $id_type])) {
        $data = array('id_aliment' => $id_aliment, 'nom' => $nom, 'id_type' => $id_type);
        $json = json_encode($data);
        echo $json;
    } else {
        echo 'Error inserting data';
    }
}

function updateAliment() {
    global $pdo;
    $alimentData = json_decode(file_get_contents('php://input'), true);

    $id_aliment = $alimentData['id_aliment'];
    $nom = $alimentData['nom'];
    $id_type = $alimentData['id_type'];

    $stmt = $pdo->prepare('UPDATE aliments SET nom = ?, id_type = ? WHERE id_aliment = ?');

    if ($stmt->execute([$nom, $id_type, $id_aliment])) {
        $response = array('status' => 'success', 'message' => 'Aliment modifié avec succès');
        echo json_encode($response);
    } else {
        echo 'Error updating data';
    }
}

function deleteAliment() {
    global $pdo;
    $alimentData = json_decode(file_get_contents('php://input'), true);
    $id_aliment = $alimentData['id_aliment'];
    if (empty($id_aliment)) {
        header('HTTP/1.1 400 Bad Request');
        echo 'Missing parameter';
        return;
    }
    $stmt = $pdo->prepare('DELETE FROM aliments WHERE id_aliment = ?');
    $stmt->execute([$id_aliment]);

    http_response_code(200);
}

$pdo = null;

?>

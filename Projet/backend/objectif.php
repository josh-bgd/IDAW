<?php

require_once('config.php');
require_once('init_pdo.php');

$request_method = $_SERVER["REQUEST_METHOD"];

switch($request_method)
{
    case 'GET':
        if(isset($_GET['id_indicateur']) && isset($_GET['login'])) {
            getone($_GET['id_indicateur'],$_GET['login']);
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
        header("HTTP/1.0 405 Method Not Allowed");
        break;
};

function getall() {
    global $pdo;
    $request = $pdo->prepare('SELECT * FROM objectif');
    $request->execute();
    $objectifs = $request->fetchAll(PDO::FETCH_OBJ);

    $json = json_encode($objectifs);
    echo $json;

    http_response_code(200);
}

function getone($id_indicateur, $login) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM objectif WHERE id_indicateur = ? AND login = ?");
    $stmt->execute([$id_indicateur, $login]);
    $objectifs = $stmt->fetchAll(PDO::FETCH_OBJ);

    $json = json_encode($objectifs);
    echo $json;

    http_response_code(200);
}

function add() {
    global $pdo;
    $objectifData = json_decode(file_get_contents('php://input'),true);

    $id_indicateur = $objectifData['id_indicateur'];
    $login = $objectifData['login'];
    $quantite = $objectifData['quantite'];

    $stmt = $pdo->prepare("INSERT INTO objectif (id_indicateur, login, quantite) VALUES (?, ?, ?)");

    if($stmt->execute([$id_indicateur, $login, $quantite])) {
        $data = array('id_indicateur' => $id_indicateur, 'login' => $login, 'quantite' => $quantite);
        $json = json_encode($data);
        echo $json;
    } else {
        echo 'Error inserting data';
    }
}

function modify(){
    global $pdo;
    $objectifData = json_decode(file_get_contents('php://input'),true);

    $id_indicateur = $objectifData['id_indicateur'];
    $login = $objectifData['login'];
    $quantite = $objectifData['quantite'];

    $stmt = $pdo->prepare('UPDATE objectif SET quantite = ? WHERE id_indicateur = ? AND login = ?');

    $stmt -> execute([$quantite, $id_indicateur, $login]);

    $response = array('status' => 'success', 'message' => 'Objectif modifié avec succès');
    echo json_encode($response);
}

function delete() {
    global $pdo;
    $objectifData = json_decode(file_get_contents('php://input'),true);

    $id_indicateur = $objectifData['id_indicateur'];
    $login = $objectifData['login'];

    if (empty($id_indicateur) || empty($login)) {
        header('HTTP/1.1 400 Bad Request');
        echo 'Missing parameter';
        return;
    }

    $stmt = $pdo->prepare('DELETE FROM objectif WHERE id_indicateur = ? AND login = ?');
    $stmt -> execute([$id_indicateur, $login]);
}

$pdo = null;
?>

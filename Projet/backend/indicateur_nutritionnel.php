<?php

require_once('config.php');
require_once('init_pdo.php');

$request_method = $_SERVER["REQUEST_METHOD"];

switch($request_method)
{
    case 'GET':
        if(isset($_GET['id_indicateur'])){
            getone($_GET['id_indicateur']);
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
    $request = $pdo->prepare('SELECT * FROM indicateur_nutritionnel');
    $request->execute();
    $indicateurs = $request->fetchAll(PDO::FETCH_OBJ);
    $json = json_encode($indicateurs);
    echo $json;
    http_response_code(200);
}

function getone($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM indicateur_nutritionnel WHERE id_indicateur = ?");
    $stmt->execute([$id]);
    $indicateur = $stmt->fetchAll(PDO::FETCH_OBJ);
    $json = json_encode($indicateur);
    echo $json;
    http_response_code(200);
}

function add() {
    global $pdo;
    $data = json_decode(file_get_contents('php://input'), true);
    $nom = $data['nom'];
    $recommandation_oms = $data['recommandation_oms'];
    $stmt = $pdo->prepare("INSERT INTO indicateur_nutritionnel (nom, recommandation_oms) VALUES (?, ?)");
    if($stmt->execute([$nom, $recommandation_oms])){
        $id = $pdo->lastInsertId();
        $data = array('id_indicateur' => $id, 'nom' => $nom, 'recommandation_oms' => $recommandation_oms);
        $json = json_encode($data);
        echo $json;
    }else{
        echo 'Error inserting data';
    }
}

function modify(){
    global $pdo;
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id_indicateur'];
    $nom = $data['nom'];
    $recommandation_oms = $data['recommandation_oms'];
    $stmt = $pdo->prepare('UPDATE indicateur_nutritionnel SET nom = ?, recommandation_oms = ? WHERE id_indicateur = ?');
    $stmt -> execute([$nom, $recommandation_oms, $id]);
    $count = $stmt->rowCount();
    if($count > 0){
        $json = json_encode(array('status' => 'success', 'message' => 'Indicateur mis à jour avec succès'));
        echo $json;
        http_response_code(200);
    }else{
        http_response_code(404);
    }
}


function delete() {
    global $pdo;
    $jsonData = json_decode(file_get_contents('php://input'), true);
    $id = $jsonData['id_indicateur'];

    if (empty($id)) {
        header('HTTP/1.1 400 Bad Request');
        echo 'Missing parameter';
        return;
    }

    $stmt = $pdo->prepare('DELETE FROM indicateur_nutritionnel WHERE id_indicateur = ?');
    $stmt->execute([$id]);
}

$pdo = null;
?>
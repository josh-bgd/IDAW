<?php

require_once('config.php');
require_once('init_pdo.php');

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'POST':
        addOrUpdate();
        break;
    case 'PUT':
        modify();
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
};

function modify()
{
    global $pdo;
    $objectifData = json_decode(file_get_contents('php://input'), true);

    foreach ($objectifData['data'] as $row) {
        $id_indicateur = $row['id_indicateur'];
        $login = $row['login'];
        $quantite = $row['quantite'];

        // Check if the combination of id_indicateur and login already exists in objectif table
        $stmt = $pdo->prepare('SELECT * FROM objectif WHERE id_indicateur = ? AND login = ?');
        $stmt->execute([$id_indicateur, $login]);
        $result = $stmt->fetch();

        if ($result) {
            // If the combination already exists, update the quantite
            $stmt = $pdo->prepare('UPDATE objectif SET quantite = ? WHERE id_indicateur = ? AND login = ?');
            $stmt->execute([$quantite, $id_indicateur, $login]);
        } else {
            // If the combination doesn't exist, insert a new row
            $stmt = $pdo->prepare("INSERT INTO objectif (id_indicateur, login, quantite) VALUES (?, ?, ?)");

            try {
                if ($stmt->execute([$id_indicateur, $login, $quantite])) {
                    $data = array('id_indicateur' => $id_indicateur, 'login' => $login, 'quantite' => $quantite);
                    $json = json_encode($data);
                    echo $json;
                } else {
                    echo json_encode(array('error' => 'Error inserting data'));
                }
            } catch (PDOException $e) {
                echo json_encode(array('error' => $e->getMessage()));
            }
        }
    }

    $response = array('status' => 'success', 'message' => 'Objectif modified with success');
    echo json_encode($response);
}

function addOrUpdate()
{
    global $pdo;
    $objectifData = json_decode(file_get_contents('php://input'), true);

    foreach ($objectifData['data'] as $row) {
        $id_indicateur = $row['id_indicateur'];
        $login = $row['login'];
        $quantite = $row['quantite'];

        // Check if the combination of id_indicateur and login already exists in objectif table
        $stmt = $pdo->prepare('SELECT * FROM objectif WHERE id_indicateur = ? AND login = ?');
        $stmt->execute([$id_indicateur, $login]);
        $result = $stmt->fetch();

        if ($result) {
            // If the combination already exists, update the quantite
            $stmt = $pdo->prepare('UPDATE objectif SET quantite = ? WHERE id_indicateur = ? AND login = ?');
            $stmt->execute([$quantite, $id_indicateur, $login]);
            $data = array('id_indicateur' => $id_indicateur, 'login' => $login, 'quantite' => $quantite);
            $json = json_encode($data);
            echo $json;
        } else {
            // If the combination doesn't exist, insert a new row
            $stmt = $pdo->prepare("INSERT INTO objectif (id_indicateur, login, quantite) VALUES (?, ?, ?)");

            try {
                if ($stmt->execute([$id_indicateur, $login, $quantite])) {
                    $data = array('id_indicateur' => $id_indicateur, 'login' => $login, 'quantite' => $quantite);
                    $json = json_encode($data);
                    echo $json;
                } else {
                    echo json_encode(array('error' => 'Error inserting data'));
                }
            } catch (PDOException $e) {
                echo json_encode(array('error' => $e->getMessage()));
            }
        }
    }

    $response = array('status' => 'success', 'message' => 'Objectif added/modified with success');
    echo json_encode($response);
}



$pdo = null;

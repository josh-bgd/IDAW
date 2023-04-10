<?php

require_once('config.php');
require_once('init_pdo.php');

$request_method = $_SERVER["REQUEST_METHOD"];

switch($request_method)
{
    case 'POST':
        checkvalidcredentials();
        break;
    default:
    header("HTTP/1.0 405 Method Not ALlowed");
    break;
};

function checkvalidcredentials() {
    /*echo file_get_contents('php://input');
    exit(0);*/
    $userData = json_decode(file_get_contents('php://input'),true);
    $login = $userData["login"];
    $password = $userData["motdepasse"];
    
    global $pdo;
    $query = "SELECT COUNT(*) FROM utilisateur WHERE login = :login AND motdepasse = :password";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":login", $login);
    $statement->bindParam(":password", $password);
    $statement->execute();

    $count = $statement->fetchColumn();

    if ($count == 1) {
        echo "Valid credentials";
    } else {
        echo "Invalid credentials";
    }
}
$pdo = null;
?>
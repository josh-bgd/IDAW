<?php

require_once('config.php');
require_once('init_pdo.php');

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (isset($_GET['date']) && isset($_GET['login'])) {
            getalimentconsommees($_GET['date'], $_GET['login']);
        } else {
            header("HTTP/1.0 405 Method Not ALlowed");
        }
        break;
    default:
        header("HTTP/1.0 405 Method Not ALlowed");
        break;
};

function getalimentconsommees($date, $login)
{
    global $pdo;
    // Récupération des utilisateurs
    $stmt = $pdo->prepare("SELECT aliments.nom, aliments.id_aliment, consommation.quantite, journal.id_type_repas, journal.id_journal
                            FROM journal
                            INNER JOIN consommation ON journal.id_journal = consommation.id_journal
                            INNER JOIN aliments ON consommation.id_aliment = aliments.id_aliment
                            WHERE journal.date = ? AND journal.login = ? ");
    $stmt->execute([$date, $login]);
    $users = $stmt->fetchAll(PDO::FETCH_OBJ);

    // Conversion en JSON
    $json = json_encode($users);
    echo $json; // on envoie la réponse de la requête 

    // HTPP response of 200 OK
    http_response_code(200);
}


$pdo = null;

<?php

require_once('config.php');
require_once('init_pdo.php');

$request_method = $_SERVER["REQUEST_METHOD"];

switch($request_method)
{
    case 'GET':
        if(isset($_GET['date']) && isset($_GET['login']) && isset($_GET['id_indicateur'])){
            getmirconutriment($_GET['date'], $_GET['login'], $_GET['id_indicateur']);
        } else if (isset($_GET['date']) && isset($_GET['login'])) {
            getalimentconsommees($_GET['date'], $_GET['login']);
        } else if (isset($_GET['startdate']) && isset($_GET['enddate']) && isset($_GET['login'])) {
            getalimentconsommeeentreinterval($_GET['startdate'], $_GET['enddate'], $_GET['login']);
        } else {
            header("HTTP/1.0 405 Method Not ALlowed");
        }
        break;
    default:
    header("HTTP/1.0 405 Method Not ALlowed");
    break;
};

// Ne pas oublier les ORDER BY pour afficher des tables trié (ascendant: default, sinon ajouter DESC)

function getmirconutriment($date, $login, $id_indicateur) {
    global $pdo;
    // Récupération des utilisateurs
    $stmt = $pdo->prepare("SELECT SUM(CAST(c.quantite as decimal(11,3)) * CAST(co.quantite as decimal(11,3)) / 100) as quantite_fois_ratio
                            FROM consommation c
                            INNER JOIN journal j ON c.id_journal = j.id_journal
                            INNER JOIN contenu co ON c.id_aliment = co.id_aliment
                            WHERE j.date = ? AND j.login = ? AND co.id_indicateur = ? ");
    $stmt->execute([$date, $login, $id_indicateur]);
    $users = $stmt->fetchAll(PDO::FETCH_OBJ);
    
    // Conversion en JSON
    $json = json_encode($users);
    echo $json; // on envoie la réponse de la requête 

    // HTPP response of 200 OK
    http_response_code(200);
    
}

function getalimentconsommees($date, $login) {
    global $pdo;
    // Récupération des utilisateurs
    $stmt = $pdo->prepare("SELECT aliments.nom, consommation.quantite, journal.id_type_repas
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

function getalimentconsommeeentreinterval($startdate, $enddate, $login) {
    global $pdo;
    // Récupération des utilisateurs
    $stmt = $pdo->prepare("SELECT journal.date, aliments.nom, consommation.quantite, type_aliment.type
                            FROM journal
                            INNER JOIN consommation ON journal.id_journal = consommation.id_journal
                            INNER JOIN aliments ON consommation.id_aliment = aliments.id_aliment
                            INNER JOIN type_aliment ON type_aliment.id_type = aliments.id_type
                            WHERE journal.date BETWEEN ? AND ? AND journal.login = ? ");
    $stmt->execute([$startdate, $enddate, $login]);
    $users = $stmt->fetchAll(PDO::FETCH_OBJ);

    // Conversion en JSON
    $json = json_encode($users);
    echo $json; // on envoie la réponse de la requête 

    // HTPP response of 200 OK
    http_response_code(200); 
}


    $pdo = null;
?>
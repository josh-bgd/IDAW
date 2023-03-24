<?php
require_once('config.php');

$connectionString = "mysql:host="._MYSQL_HOST;

if(defined('_MYSQL_PORT'))
    $connectionString .= ";port="._MYSQL_PORT;

$connectionString .= ";dbname="._MYSQL_DBNAME;
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' );

$pdo = NULL;
try {
    $pdo = new PDO($connectionString,_MYSQL_USER,_MYSQL_PASSWORD,$options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $erreur) {
    echo 'Erreur : '.$erreur->getMessage();
};

$request_method = $_SERVER["REQUEST_METHOD"];

switch($request_method)
{
    case 'GET':
        getAllUsers();
        break;
    case 'POST':
        createUser();
        break;
    case 'PUT':
        updateUser();
        break;
    case 'DELETE':
        deleteUser();
        break;
    default:
    header("HTTP/1.0 405 Method Not ALlowed");
    break;
};



function getAllUsers() {
    global $pdo;
    // Récupération des utilisateurs
    $request = $pdo->prepare('select * from users');
    $request->execute();
    $users = $request->fetchAll(PDO::FETCH_OBJ);
    
    // Conversion en JSON
    $json = json_encode($users);

    // HTPP response of 200 OK
    header('HTTP/1.1 200 OK');
    header('Content-Type: application/json');
    echo $json;
}

function createUser() {
    global $pdo;
    $userData = json_decode(file_get_contents('php://input'),true);

    $name = $userData['name'];
    $email = $userData['email'];

    $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);

    $userInfo = array(
        //'id' => $newUserId,
        'name' => $name,
        'email' => $email
      );

    if($stmt->execute()) {
        echo 'Data inserted successfully!';
        http_response_code(201);
        //echo json_encode($userInfo);

    } else {
        echo 'Error inserting data';
    }
    
}

function updateUser(){
    $userData = json_decode(file_get_contents('php://input'),true);

    $id = $userData['id'];
    $nom = $userData['name'];
    $email = $userData['email'];
    if (empty($id) || empty($nom) || empty($email)) {
        header('HTTP/1.1 400 Bad Request');
        echo 'Missing parameter';
        return;
    }
    
    // Connexion à la base de données
    global $pdo;
    
    // Modification de l'utilisateur dans la base de données
    $stmt = $pdo->prepare('UPDATE users SET name = ?, email = ? WHERE id = ?');
    $stmt -> execute([$nom, $email, $id]);
    
    // Envoi de la réponse HTTP
    header('HTTP/1.1 204 No Content');
}


    function deleteUser() {
        // Vérification des paramètres
        $userData = json_decode(file_get_contents('php://input'),true);
        $id = $userData['id'];
        if (empty($id)) {
            header('HTTP/1.1 400 Bad Request');
            echo 'Missing parameter';
            return;
        }
        global $pdo;
        // Suppression de l'utilisateur de la base de données
        $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
        $stmt -> execute([$id]);
        
        // Envoi de la réponse HTTP
        header('HTTP/1.1 204 No Content');
    }

    $pdo = null;
?>
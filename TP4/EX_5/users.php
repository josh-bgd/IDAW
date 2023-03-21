<?php

    //fichier de configuration de la base de données
    require_once('config.php');

    // constrction de la chaîne de connexion PDO
    $connectionString = "mysql:host=" . _MYSQL_HOST;
    if (defined('_MYSQL_PORT'))
        $connectionString .= ";port=" . _MYSQL_PORT;
    $connectionString .= ";dbname=" . _MYSQL_DBNAME;

    // On définit les options PDO pour spécifier l'encodage
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

    // initialiser une connexion PDO
    $pdo = NULL;
    try {
        $pdo = new PDO($connectionString, _MYSQL_USER, _MYSQL_PASSWORD, $options);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $erreur) {
        echo 'Erreur : ' . $erreur->getMessage();
    }

    //Définition de l'entête de réponse Content-Type pour spécifier que la réponse est en JSON
    header('Content-Type: application/json');


     // Traitement pour la méthode GET
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        //requête SQL pour sélectionner tous les utilisateurs de la table users :
        $request = "SELECT * FROM users";

        //Exécution de la requête
        $result = $pdo->query($request);
        $users = $result->fetchAll(PDO::FETCH_OBJ);

        //Fermeture de la connexion à la base de données 
        $pdo = null;

        // On encode les résultats sous forme de JSON
        echo json_encode($users);

      // Traitement pour la méthode POST
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Vérification des champs obligatoires pour la création d'un utilisateur
        $requiredFields = ['name', 'email', 'age', 'family_name', 'nationality', 'eye_color'];
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                http_response_code(400); // Mauvaise Requête
                exit("Le champ '$field' est manquant.");
            }
        }
    
        // Création de l'utilisateur

        $user = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'age' => $_POST['age'],
            'family_name' => $_POST['family_name'],
            'nationality' => $_POST['nationality'],
            'eye_color' => $_POST['eye_color']
        ];
    
        /// 

        // Renvoi de la réponse HTTP avec le code 201 Created et l'URL de la nouvelle ressource
        header('HTTP/1.1 201 Created');
        echo "{ \"Location\" : \"".API_URL_PREFIX."/users.php/' . $user['id']\" }";
    
        //Fermeture de la connexion à la base de données 
        $pdo = null;

        // Renvoi des informations de l'utilisateur créé au format JSON dans le corps de la réponse
        header('Content-Type: application/json');
        echo json_encode($user);

    } else {

        //Fermeture de la connexion à la base de données 
        $pdo = null;

        // Erreur : méthode HTTP non prise en charge
        http_response_code(405); // Method Not Allowed
        exit("Méthode HTTP non autorisée.");
    }

?>

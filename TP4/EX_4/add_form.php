<?php

$user_id = '1';
if(isset($_GET['id'])) {
    $user_id = $_GET['id']; // récupère la valeur de la variable 'page' dans l'URL, sinon définit la valeur par défaut 'accueil'
} 

function renderFormToHTML ($user_id) {

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

    $request = $pdo->prepare("SELECT * FROM users WHERE id=:user_id");
    $request->execute(array(':user_id' => $user_id));

    // On affiche les résultats dans un tableau HTML
    if ($request->rowCount() > 0) {
        // On parcourt chaque ligne de résultat
        while ($row = $request->fetch(PDO::FETCH_OBJ)) {
            // formulaire de modification pour chaque utilisateur
            echo "<tr><td colspan='6'>";
            echo "<form action='add_user.php' method='post'>";
            echo "<input type='hidden' name='id' value='" . $row->id . "'>"; // l'id est caché on ne le voit pas sur la page web mais il est bien là
            echo "<label for='name'>Nom :</label>";
            echo "<input type='text' name='name' value='" . $row->name . "'><br>";
            echo "<label for='email'>Email :</label>";
            echo "<input type='email' name='email' value='" . $row->email . "'><br>";
            echo "<label for='age'>Age :</label>";
            echo "<input type='number' name='age' value='" . $row->age . "'><br>";
            echo "<label for='nationality'>Nationalité :</label>";
            echo "<input type='text' name='nationality' value='" . $row->nationality . "'><br>";
            echo "<label for='family_name'>Family name :</label>";
            echo "<input type='text' name='family_name' value='" . $row->family_name . "'><br>";
            echo "<label for='eye_color'>Eye color :</label>";
            echo "<input type='text' name='eye_color' value='" . $row->eye_color . "'><br>";
            echo "<input type='submit' value='Modifier'>";
            echo "</form>";
            echo "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 résultats";
    }
}

renderFormToHTML(($user_id));
?>
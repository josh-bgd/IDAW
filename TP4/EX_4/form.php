<?php
renderFormToHTML ($user_id) {

    $request = $pdo->prepare("SELECT * FROM users WHERE id=: $user_id");
    $request->execute();

    // On affiche les résultats dans un tableau HTML
    if ($request->rowCount() > 0) {
        // On parcourt chaque ligne de résultat
        while ($row = $request->fetch(PDO::FETCH_OBJ)) {
            // formulaire de modification pour chaque utilisateur
            echo "<tr><td colspan='6'>";
            echo "<form action='update_user.php' method='post'>";
            echo "<input type='hidden' name='id' value='" . $row->id . "'>"; // l'id est caché on ne le voit pas sur la page web mais il est bien là
            echo "<label for='name'>Nom :</label>";
            echo "<input type='text' name='name' value='" . $row->name . "'><br>";
            echo "<label for='email'>Email :</label>";
            echo "<input type='email' name='email' value='" . $row->email . "'><br>";
            echo "<label for='age'>Age :</label>";
            echo "<input type='number' name='age' value='" . $row->age . "'><br>";
            echo "<label for='nationality'>Nationalité :</label>";
            echo "<input type='text' name='nationality' value='" . $row->nationality . "'><br>";
            echo "<input type='submit' value='Modifier'>";
            echo "</form>";
            echo "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 résultats";
    }
}
?>
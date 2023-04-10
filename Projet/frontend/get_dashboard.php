<?php

// Récupération des paramètres
$startdate = $_POST['startdate'];
$enddate = $_POST['enddate'];
$login = $_POST['login'];

// Appel à l'API GET
$url = 'http://localhost:8888/Projet_IDAW/IDAW/Projet/backend/dashboard.php?startdate=' . $startdate . '&enddate=' . $enddate . '&login=' . $login;
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);

// Traitement du résultat
$result = json_decode($result, true);

// Affichage du résultat
?>
<table id="table" class="table">
    <thead>
        <tr>
        <th scope="col">Date</th>
        <th scope="col">Nom</th>
        <th scope="col">Quantité</th>
        <th scope="col">Type d'aliment</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($result as $row): ?>
        <tr>
            <td><?= $row['date'] ?></td>
            <td><?= $row['nom'] ?></td>
            <td><?= $row['quantite'] ?> g</td>
            <td><?= $row['type'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
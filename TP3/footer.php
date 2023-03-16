<?php
function renderFooterToHTML($currentPageId) {
        echo 
        '<footer>
            <p> Vous êtes sur le footer de la page ' . $currentPageId . '</p>';
        if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            // l'utilisateur est connecté, afficher son login
            $login = $_SESSION['login'];
            echo "<p> Bienvenue, $login ! <button><a href='logout.php'>Déconnexion</a></button></p>";
        } else {
            // l'utilisateur n'est pas connecté, afficher un message d'erreur ou rediriger vers la page de connexion
            echo "<p>Vous n'êtes pas connecté.</p>";
          }

        // code pour le traitement de la déconnexion
        if(isset($_GET['logout'])) {
            // détruire toutes les données de session
            session_unset();
            // détruire la session
            session_destroy();
            // rediriger vers la page d'acceuil
            require_once('index.php');
        }
        echo
        '</footer>
        </body>
        </html>';
}
?>


<?php
function renderFooterToHTML($currentPageId) {
        echo 
        '<footer>
            <p> Vous êtes sur le footer de la page ' . $currentPageId . '</p>';
        if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            // l'utilisateur est connecté, afficher son login
            $login = $_SESSION['login'];
            echo "<p> Bienvenue, $login ! </p>";
            } else {
            // l'utilisateur n'est pas connecté, afficher un message d'erreur ou rediriger vers la page de connexion
            echo "<p>Vous n'êtes pas connecté.</p>";
            }
        echo
        '</footer>
        </body>
        </html>';
}
?>
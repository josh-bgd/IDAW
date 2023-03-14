<?php
function renderFooterToHTML($currentPageId) {
    if ($currentPageId=="index") {
        echo 
        '</body>
            <footer>
                <p>Vous êtes sur le footer de la page index</p>
            </footer>
            </body>
            </html>';
        } else if ($currentPageId=="cv" ) {
            echo 
        '</body>
            <footer>
                <p>Vous êtes sur le footer de la page cv</p>
            </footer>
            </body>
            </html>';
        } else {
            echo 
        '</body>
            <footer>
                <p>Vous êtes sur le footer de la page projets</p>
            </footer>
            </body>
            </html>'; 
        }
}
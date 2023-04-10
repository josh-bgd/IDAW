# README FRONT END


## login.js : 

- Le script login.js écoute la soumission du formulaire (#login-form).
  
- Les valeurs de login et password sont récupérées et envoyées en JSON à backend/login.php via une requête AJAX POST.
  
- Si les informations sont valides, le script crée un cookie "login" avec la valeur du login et redirige l'utilisateur vers dashboard.php. Sinon, un message d'erreur est affiché.
  
- Le script envoie ensuite une requête AJAX à backend/journal.php pour récupérer les infos du journal de l'utilisateur pour la date actuelle.
  
- Si aucune info n'existe, une autre requête AJAX crée cinq nouvelles entrées dans le journal.
  
- Le script a une fonction "createCookie" pour créer un cookie avec un nom, une valeur et une durée de vie spécifiés.



## signup.js : 

- La fonction Javascript "signup-form" est exécutée lorsque le formulaire d'inscription est soumis.

- Les valeurs des champs du formulaire (prénom, nom, date de naissance, email, etc.) sont récupérées à l'aide de la méthode jQuery "val" et stockées dans des variables.

- Une vérification est effectuée pour s'assurer que les mots de passe entrés par l'utilisateur sont identiques. Une alerte est affichée si les mots de passe ne sont pas identiques.

- Une requête Ajax est envoyée au serveur en utilisant la méthode "ajax" de jQuery. Les données sont envoyées sous forme de JSON.

- Si l'insertion de données est réussie, une boucle est effectuée pour insérer des objectifs pour chaque indicateur nutritionnel (il y en a 5).

- Pour chaque indicateur, une requête Ajax est envoyée au serveur pour récupérer la recommandation de l'OMS et la quantité correspondante pour l'utilisateur, en utilisant les données de poids et d'identifiant de niveau d'activité.

- La page est redirigée vers la page de connexion si l'insertion de données est réussie. Sinon, une alerte est affichée à l'utilisateur.


## objectives.js : 

- Section 1: Ajoute des formulaires indicateurs avec des champs pour sélectionner un indicateur nutritionnel et une quantité. L'utilisateur peut ajouter ou supprimer un formulaire.

- Section 2: Utilise jQuery pour récupérer des indicateurs nutritionnels à partir d'un API et les ajouter à une liste déroulante. L'utilisateur peut sélectionner un indicateur et ajouter la quantité à un tableau.

- Section 3: Gestionnaire d'événements pour le formulaire d'objectif. Les valeurs des formulaires indicateurs sont collectées et envoyées à un API pour être enregistrées lors de la soumission.


## aliments.js :

- Permet de collecter des informations sur les aliments consommés à différents moments de la journée et de les afficher dans des tableaux.

- Le script affiche les options pour chaque type de repas dans des menus déroulants. Les options sont ajoutées dynamiquement en utilisant les données JSON récupérées depuis le serveur. Chaque menu déroulant possède un identifiant unique pour identifier le type de repas.

- Le script récupère les informations sur les aliments consommés pour la date en cours depuis le serveur. Les informations sont affichées dans des tableaux HTML qui sont également créés dynamiquement en utilisant les données JSON récupérées depuis le serveur.

- Chaque ligne de tableau affiche les informations sur un aliment consommé, y compris le nom de l'aliment, la quantité, l'identifiant de l'aliment et l'identifiant du journal de consommation. Les boutons "Remove" et "Update" sont également ajoutés à chaque ligne de tableau.

- Le bouton "Remove" permet à l'utilisateur de supprimer une ligne de tableau en envoyant une requête AJAX au serveur pour supprimer les données associées à la ligne.

- Les boutons pour ajouter un aliment consommé à un repas spécifique sont associés à des événements onclick. Lorsqu'un bouton est cliqué, le script récupère l'identifiant du type de repas correspondant à partir de l'identifiant unique du bouton et stocke cette valeur dans une variable. Le script récupère ensuite les informations sur l'aliment et la quantité depuis les menus déroulants et envoie une requête AJAX au serveur pour enregistrer les informations dans la base de données.

- Le script gère également la situation où l'utilisateur clique plusieurs fois sur le bouton d'ajout en même temps. Dans ce cas, la fonction d'ajout ne sera exécutée qu'une seule fois.

### Bouton Update :

- Pas encore implémenté, mais il était sénsé permettre de modifier une quantité pour un aliment, cependant la supression et l'ajout de ce nouvel aliment peut fonctionner le temps d'une nouvelle MAJ :-)
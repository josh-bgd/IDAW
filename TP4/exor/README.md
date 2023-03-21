Documentation de l'API :

    Ce code est écrit en PHP et gère une API REST permettant de récupérer tous les utilisateurs de la table "users" de la base de données et de créer un nouvel utilisateur en envoyant une requête HTTP POST. La méthode GET quant à elle, est utilisée pour récupérer tous les utilisateurs de la table "users" de la base de données. Elle est gérée par une requête SQL qui sélectionne tous les enregistrements de la table "users". 

Le code commence par inclure un fichier de configuration de la base de données. Ensuite, il construit une chaîne de connexion PDO en utilisant les constantes définies dans le fichier de configuration. Les options PDO sont également définies pour spécifier l'encodage. Une connexion PDO est ensuite initialisée en utilisant la chaîne de connexion PDO et les identifiants de connexion.

- METHODE GET : 

Le traitement de la méthode GET est géré en sélectionnant tous les utilisateurs de la table "users" à l'aide d'une requête SQL et en les encodant en JSON avant de les renvoyer dans la réponse.

La requête est exécutée en utilisant la méthode "query()" de l'objet PDO, qui renvoie un objet de résultat. Les résultats sont ensuite récupérés à l'aide de la méthode "fetchAll()" de l'objet de résultat, qui renvoie un tableau contenant tous les enregistrements sous forme d'objets. Ces résultats sont ensuite encodés en JSON à l'aide de la fonction "json_encode()" de PHP.

Si la requête échoue, une exception de type PDOException est levée et un message d'erreur est renvoyé dans la réponse. Ensuite, l'entête de réponse Content-Type est défini pour spécifier que la réponse sera en JSON.

- METHODE POST :

Le traitement de la méthode POST est géré en vérifiant si tous les champs obligatoires pour la création d'un utilisateur ont été fournis dans la requête POST. Si certains champs sont manquants, une réponse HTTP avec le code 400 "Mauvaise Requête" est renvoyée avec un message d'erreur. Sinon, un nouvel utilisateur est créé avec les informations fournies dans la requête POST. Une réponse HTTP avec le code 201 "Created" est renvoyée avec l'URL de la nouvelle ressource. Les informations de l'utilisateur créé sont également encodées en JSON et renvoyées dans la réponse.

Si une méthode HTTP autre que GET ou POST est utilisée, une réponse HTTP avec le code 405 "Method Not Allowed" est renvoyée avec un message d'erreur.


    Le code se termine en fermant la connexion PDO à la base de données.
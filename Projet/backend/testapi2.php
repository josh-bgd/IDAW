<!DOCTYPE html>
<html>

<head>
	<title>Login Page</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
	<h2>Login Page</h2>
	<form id="post-form">
		<input type="submit" value="post request">
	</form>
	<div id="display-result"></div>
</body>

</html>
<script>
	$(document).ready(function() {
		$('#post-form').submit(function(event) {
			event.preventDefault();

			// Récupérer le nom du repas et du plat en fonction du formulaire soumis
			let formId = $(this).attr('id');
			let mealName = formId.split('-')[0];
			let dishName = formId.split('-')[1];

			let nom_repas = mealName.charAt(0).toUpperCase() + mealName.slice(1); // Premier caractère en majuscule
			let nom_aliment = $('#' + dishName).val();
			let login = '<?php echo $_SESSION['login']; ?>'; // Nom d'utilisateur de la session PHP
			let quantite = $('#' + dishName + '-quantity').val(); // Récupérer la quantité depuis l'élément de formulaire
			let date = new Date();
			let annee = date.getFullYear();
			let mois = ("0" + (date.getMonth() + 1)).slice(-2);
			let jour = ("0" + date.getDate()).slice(-2);
			let heures = ("0" + date.getHours()).slice(-2);
			let minutes = ("0" + date.getMinutes()).slice(-2);
			let secondes = ("0" + date.getSeconds()).slice(-2);
			let dateFormatee = `${annee}-${mois}-${jour} ${heures}:${minutes}:${secondes}`;
			// Avoir la correspondance nom du type de repas (dejeuner, diner, ..) avec l'id associé
			$.ajax({
				type: 'GET',
				url: 'http://localhost:8888/Projet_IDAW/IDAW/Projet/backend/type_repas.php?nom_repas=' + nom_repas,
				success: function(data) {
					responseObject = JSON.parse(data);
					id_type_repasss = responseObject[0].id_type_repas;
					$.ajax({
						type: 'GET',
						url: 'http://localhost:8888/Projet_IDAW/IDAW/Projet/backend/aliments.php?nom=' + nom_aliment,
						success: function(data) {
							responseObject = JSON.parse(data);
							id_aliment = responseObject[0].id_aliment;

							$.ajax({
								type: 'POST',
								url: 'http://localhost:8888/Projet_IDAW/IDAW/Projet/backend/journal.php',
								data: JSON.stringify({
									id_type_repas: id_type_repasss,
									login: login,
									date: dateFormatee
								}),
								success: function(data) {
									obj = JSON.parse(data)
									id_journal = obj.id_journal
									$.ajax({
										type: 'POST',
										url: 'http://localhost:8888/Projet_IDAW/IDAW/Projet/backend/consommation.php',
										data: JSON.stringify({
											id_journal: id_journal,
											id_aliment: id_aliment,
											quantite: quantite
										}),
										success: function(data) {
											$('#display-result').html(data);
										}
									});
								}
							});
						}
					});
				}
			});

		});
	});
</script>
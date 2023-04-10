<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
	<h2>Login Page</h2>
	<form id="get-form">
		<input type="submit" value="Get request">
	</form>
	<form id="get-form2">
		<input type="submit" value="Get one request">
	</form>
	<form id="post-form">
		<input type="submit" value="post request">
	</form>
	<form id="put-form">
		<input type="submit" value="put request">
	</form>
	<form id="delete-form">
		<input type="submit" value="delete request">
	</form>
	<div id="display-result"></div>
	<div id="display-result2"></div>
</body>
</html>
<script>
    $(document).ready(function() {
	$('#get-form').submit(function(event) {
		event.preventDefault();
		let login = 'Lelea' // A CHANGER
		let date = '2023-04-01' // A CHANGER
		$.ajax({
			type: 'GET',
			url: 'http://localhost:8888/Projet_IDAW/IDAW/Projet/backend/indicateur_nutritionnel.php',
			success: function(data) {
				responseObject = JSON.parse(data);
				$('#display-result').html(data);
				$('#display-result2').html(responseObject[0].recommandation_oms);
			}
		});
	});
	$('#get-form2').submit(function(event) {
		event.preventDefault();
		let login = 'Lelea' // A CHANGER
		let id_indicateur = '1' // A CHANGER
		let startdate = '2023-04-01'
		let poids = '100'
		$.ajax({
			type: 'GET',
			url: 'http://localhost:8888/Projet_IDAW/IDAW/Projet/backend/indicateur_nutritionnel.php?id_indicateur=3',
			success: function(data) {
				responseObject = JSON.parse(data);
				//id_type_repas = parseFloat(responseObject[0].quantite_fois_ratio).toFixed(1);
				//id_aliment = id_type_repas
				recommandation_par_kilo = responseObject[0].recommandation_oms
                recommandation = recommandation_par_kilo * poids
				$('#display-result').html(recommandation);
			}
		});
	});
	$('#post-form').submit(function(event) {
		event.preventDefault();
		$.ajax({
			type: 'POST',
			url: 'http://localhost:8888/Projet_IDAW/IDAW/Projet/backend/journal.php',
			data: JSON.stringify({id_type_repas: "1",login: "Lelea",date: "2022-01-01 01:01:03"}),
			success: function(data) {
				obj = JSON.parse(data)
				$('#display-result').html(data);
			}
		});
	});
	$('#put-form').submit(function(event) {
		event.preventDefault();
		$.ajax({
			type: 'PUT',
			url: 'http://localhost:8888/Projet_IDAW/IDAW/Projet/backend/journal.php',
			data: JSON.stringify({id_indicateur: "1",login: "Lelea",quantite: "49"}),
			success: function(data) {
					$('#display-result').html(data);
			}
		});
	});
	$('#delete-form').submit(function(event) {
		event.preventDefault();
		$.ajax({
			type: 'DELETE',
			url: 'http://localhost:8888/Projet_IDAW/IDAW/Projet/backend/journal.php',
			data: JSON.stringify({id_indicateur: "1",login: "Lelea"}),
			success: function(data) {
					$('#display-result').html(data);
			}
		});
	});
});
</script>
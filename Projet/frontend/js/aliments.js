$(document).ready(function () {

  let loginInput = document.getElementById('login');
  let login = loginInput ? loginInput.value : null;

  var id_type_repas = null;
  let date = new Date();
  let annee = date.getFullYear();
  let mois = ("0" + (date.getMonth() + 1)).slice(-2);
  let jour = ("0" + date.getDate()).slice(-2);
  let dateFormatee = `${annee}-${mois}-${jour}`;

  // Collect the aliments from the server
  $.ajax({
    url: apifolder + '/backend/aliments.php',
    type: 'GET',
    success: function (data) {
      // Parse the JSON response
      var aliments = JSON.parse(data);

      // Append options to each select
      $("#breakfast, #snacks, #lunch, #dinner").each(function () {
        var select = $(this);
        select.append('<option value="">Add ' + select.attr("id") + '</option>');
        $.each(aliments, function (index, value) {
          select.append('<option value="' + value.id_aliment + '">' + value.nom + '</option>');
        });
      });

    }
  });

  $.ajax({
    url: apifolder + '/backend/dashboard2.php?date=' + dateFormatee + '&login=' + login,
    type: 'GET',
    data: {
      date: dateFormatee,
      login: login
    },
    dataType: 'json',
    success: function (data) {
      data.forEach(item => {
        let tableId;
        switch (item.id_type_repas) {
          case 1:
            tableId = 'add-breakfast-table';
            break;
          case 2:
            tableId = 'add-lunch-table';
            break;
          case 3:
            tableId = 'add-dinner-table';
            break;
          case 4:
            tableId = 'add-snacks-table';
            break;
          default:
            tableId = 'add-default-table'; // use a default table if id_type_repas is invalid
        }
        const tableBody = document.querySelector(`#${tableId} tbody`);
        const row = document.createElement('tr');
        const nameCell = document.createElement('td');
        nameCell.textContent = item.nom;
        nameCell.classList.add('nom-aliment');
        row.appendChild(nameCell);

        const quantityCell = document.createElement('td');
        quantityCell.textContent = item.quantite;
        quantityCell.classList.add('quantite-aliment');
        row.appendChild(quantityCell);

        const idAlimentCell = document.createElement('td');
        idAlimentCell.textContent = item.id_aliment;
        idAlimentCell.classList.add('id-aliment');
        idAlimentCell.style.display = 'none';
        row.appendChild(idAlimentCell);

        const idJournalCell = document.createElement('td');
        idJournalCell.textContent = item.id_journal;
        idJournalCell.classList.add('id-journal');
        idJournalCell.style.display = 'none';
        row.appendChild(idJournalCell);

        const removeBtn = document.createElement('button');
        removeBtn.textContent = 'Remove';
        removeBtn.classList.add('btn', 'btn-danger', 'remove-btn');

        removeBtn.addEventListener('click', () => {

          const id_journal = parseInt(row.querySelector('.id-journal').textContent);
          const id_aliment = parseInt(row.querySelector('.id-aliment').textContent);


          $.ajax({
            url: apifolder + '/backend/consommation.php',
            type: 'DELETE',
            data: JSON.stringify({
              id_journal: id_journal,
              id_aliment: id_aliment
            }),
            contentType: 'application/json',            
            success: function () {
              // remove the row from the table
              row.remove();
            },
            error: function (error) {
              console.error(error);
            }
          });
        });

        const updateBtn = document.createElement('button');
        updateBtn.textContent = 'Update';
        updateBtn.classList.add('btn', 'btn-primary');
        updateBtn.addEventListener('click', () => {
          // code to update item in table
        });
        const updateRemoveCell = document.createElement('td');
        updateRemoveCell.appendChild(removeBtn);
        updateRemoveCell.appendChild(updateBtn);
        row.appendChild(updateRemoveCell);
        tableBody.appendChild(row);
      });
    },
    error: function (error) {
      console.error(error);
    }
  });

  $("#add-breakfast").on("click", function () {
    id_type_repas = 1;
  });

  $("#add-lunch").on("click", function () {
    id_type_repas = 2;
  });

  $("#add-dinner").on("click", function () {
    id_type_repas = 3;
  });

  $("#add-snacks").on("click", function () {
    id_type_repas = 4;
  });

  $("#add-water").on("click", function () {
    id_type_repas = 5;
  });


  var isRunning = false;
  $("#add-breakfast, #add-lunch, #add-dinner, #add-snacks, #add-water").on("click", function (event) {
    if (isRunning) {
      return; // Do nothing if the function is already running
    }
    event.preventDefault();
    console.log(id_type_repas);

    // Récupérer la valeur de l'aliment et la quantité
    var id_aliment, quantite;

    if (id_type_repas === 1) {
      id_aliment = $("#breakfast").val();
      quantite = $("#breakfast-quantity").val();
    } else if (id_type_repas === 2) {
      id_aliment = $("#lunch").val();
      quantite = $("#lunch-quantity").val();
    } else if (id_type_repas === 3) {
      id_aliment = $("#dinner").val();
      quantite = $("#dinner-quantity").val();
    } else if (id_type_repas === 4) {
      id_aliment = $("#snacks").val();
      quantite = $("#snacks-quantity").val();
    } else if (id_type_repas === 5) {
      id_aliment = 9999;
      quantite = $("#water-quantity").val();
    }

    if (quantite.length === 0 || id_aliment.length === 0) {
      alert("Please fill in both the breakfast and quantity fields.");
      return;
    }

    // Appeler le backend pour récupérer l'id_journal correspondant
    $.ajax({
      url: apifolder + '/backend/journal.php?date=' + dateFormatee + '&login=' + login,
      type: 'GET',
      data: {
        date: dateFormatee,
        login: login
      },
      beforeSend: function () {
        isRunning = true; // Set the flag to true before sending the request
      },
      success: function (response) {
        var data = JSON.parse(response);

        // Trouver l'id_journal correspondant à id_type_repas
        var id_journal = null;
        for (var i = 0; i < data.length; i++) {
          if (data[i].id_type_repas === id_type_repas) {
            id_journal = data[i].id_journal;
            break;
          }
        }
        console.log(id_journal);

        if (id_journal === null) {
          alert("Error: No journal found");
        } else {
          // Envoyer la consommation à consommation.php

          console.log(typeof id_journal);
          console.log('id_journal:', id_journal);
          console.log(typeof id_aliment);
          console.log('id_aliment:', id_aliment);
          console.log(typeof quantite);
          console.log('quantite:', quantite);

          $.ajax({
            url: apifolder + '/backend/consommation.php',
            method: "POST",
            data: JSON.stringify({
              id_journal: id_journal,
              id_aliment: id_aliment,
              quantite: quantite
            }),
            contentType: 'application/json',
            success: function (response) {
              console.log(response);
            },
            error: function (xhr, textStatus, errorThrown) {
              console.log('Error: ' + errorThrown);
            },
            complete: function () {
              isRunning = false; // Reset the flag when the request is completed
            }
          });
        }
      },
      error: function () {
        alert("Error retrieving journal's infos");
        isRunning = false; // Reset the flag on error
      }
    });
  });


  var water_circles = document.getElementById("water_circles");

  document.getElementById("add-water").addEventListener("click", function () {
    var glassesOfWater = parseInt(document.getElementById("water-quantity").value);

    for (var i = 0; i < glassesOfWater; i++) {
      var circle = document.createElement("div");
      circle.classList.add("circle");
      water_circles.appendChild(circle);

    }
  });

  document.getElementById("remove-water").addEventListener("click", function () {
    var circles = document.querySelectorAll("#water_circles .circle");
    if (circles.length > 0) {
      var lastCircle = circles[circles.length - 1];
      lastCircle.parentNode.removeChild(lastCircle);
    }
  });

});


console.log("CRUD.js loaded");

let selectedRow = null;
let students = [];

function onFormsubmit() {
    event.preventDefault();

    let nom = $("#inputNom").val();
    let prenom = $("#inputPrenom").val();
    let dateNaissance = $("#inputDateNaissance").val();
    let aimeLeCours = $("#inputAimeLeCours").prop('checked');
    let remarques = $("#inputRemarques").val();

    let formData = {
        "nom": nom,
        "prenom": prenom,
        "date_naissance": dateNaissance,
        "aime_le_cours": aimeLeCours,
        "remarques": remarques,
    };

    if (nom.trim() !== '') {
        if (selectedRow) {
            $.ajax({
                url: apifolder + '/ApiREST.php',
                type: 'PUT',
                data: JSON.stringify(formData),
                success: function (responsejson) {
                    console.log(responsejson);
                    // Reset form
                    $("#addStudentForm").trigger("reset");
                    $("#inputNom").focus();
                    // reset selectedRow after the edit is done
                    selectedRow = null;
                    // Change the button back to POST method
                    $('#submitButton').text('Ajouter');
                    $('#submitButton').removeClass('btn-warning');
                    $('#submitButton').addClass('btn-success');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        } else {
            $.ajax({
                url: apifolder + '/ApiREST.php',
                type: "POST",
                data: JSON.stringify(formData),
                contentType: "application/json",
                success: function (data) {
                    console.log(data);
                    students.push({
                        nom,
                        prenom,
                        dateNaissance,
                        aimeLeCours,
                        remarques
                    });
                    updateTable();
                    // Reset form
                    $("#addStudentForm").trigger("reset");
                    $("#inputNom").focus();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Erreur lors de l'ajout de l'utilisateur.");
                    console.log(textStatus, errorThrown);
                }
            });
        }
    }
};


function updateTable() {
    let tableBody = $("#studentsTableBody");
    tableBody.empty();
    $.ajax({
        url: apifolder + '/ApiREST.php',
        method: "GET",
        success: function (students) {
            for (let i = 0; i < students.length; i++) {
                let student = students[i];
                tableBody.append(`
            <tr data-index="${student.id}">
                <td>${student.nom}</td>
                <td>${student.prenom}</td>
                <td>${student.date_naissance}</td>
                <td>${student.aime_le_cours ? 'Oui' : 'Non'}</td>
                <td>${student.remarques}</td>
                <td>
                    <button type="button" class="btn btn-warning" onclick="onEdit(this)">Editer</button>
                    <button type="button" class="btn btn-danger" onclick="onDelete(this)">Supprimer</button>
                </td>
            </tr>
            `);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert("Erreur pour récupere les données de la table MySQL");
            console.log(textStatus, errorThrown);
        }
    });
}

function onEdit(button) {
    selectedRow = $(button).closest("tr");
    let id = selectedRow.attr('data-index');
    $("#inputNom").val(selectedRow.children().eq(0).text());
    $("#inputPrenom").val(selectedRow.children().eq(1).text());
    $("#inputDateNaissance").val(selectedRow.children().eq(2).text());
    $("#inputAimeLeCours").prop('checked', selectedRow.children().eq(3).text() === 'Oui');
    $("#inputRemarques").val(selectedRow.children().eq(4).text());

    // Update database
    let nom = $("#inputNom").val();
    let prenom = $("#inputPrenom").val();
    let dateNaissance = $("#inputDateNaissance").val();
    let aimeLeCours = $("#inputAimeLeCours").prop('checked');
    let remarques = $("#inputRemarques").val();

    let formData = {
        "id": id,
        "nom": nom,
        "prenom": prenom,
        "date_naissance": dateNaissance,
        "aime_le_cours": aimeLeCours,
        "remarques": remarques,
    };

    $.ajax({
        url: apifolder + '/ApiREST.php/' + id,
        type: 'PUT',
        data: JSON.stringify(formData),
        contentType: 'application/json',
        success: function (response) {
            console.log(response);
            
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
        
    });
}



function onDelete(button) {
    let selectedRow = $(button).closest("tr");
    let index = selectedRow.attr('data-index');
    $.ajax({
        url: apifolder + '/ApiREST.php',
        method: "DELETE",
        data: JSON.stringify({
            id: index
        }),
        success: function (response) {
            updateTable();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert("Erreur pour récupere les données de la table MySQL");
            console.log(textStatus, errorThrown);
        }
    });
}
$(document).ready(function () {
    // Counter for new form ids
    var counter = 0;

    $("#add-indicator").click(function () {
        // Increment the counter
        counter++;

        // Create a new indicator form row
        var newRow = $('<div class="indicator-form row"></div>');

        // select element to the row
        var selectCol = $('<div class="col-md-6 form-group"></div>');
        var select = $('<select id="id_indicateur_' + counter + '" class="form-control"></select>');

        // retrieve the list of options from the existing select element
        var options = $('#id_indicateur').html();
        select.append(options);

        selectCol.append(select);
        newRow.append(selectCol);

        // quantity input and remove button
        var quantityCol = $('<div class="col-md-6"></div>');
        var quantityRow = $('<div class="row"></div>');
        var quantityInput = $('<div class="col-md-8 form-group"></div>');
        quantityInput.append('<input type="number" id="quantite_' + counter + '" class="form-control" placeholder="quantity" required>');
        quantityRow.append(quantityInput);
        var removeBtnCol = $('<div class="col-md-4 form-group"></div>');
        var removeBtnWrap = $('<div class="remove-btn-wrap"></div>');
        var removeBtn = $('<button type="button" class="btn btn-danger remove-btn" style="display: flex; justify-content: center;">Remove</button>');
        removeBtnWrap.append(removeBtn);
        removeBtnCol.append(removeBtnWrap);
        quantityRow.append(removeBtnCol);
        quantityCol.append(quantityRow);
        newRow.append(quantityCol);

        newRow.insertBefore($('.indicator-form:last'));
    });


    // Remove an indicator form
    $("#indicator-forms").on("click", ".remove-btn", function () {
        $(this).closest(".indicator-form").remove();
    });
});

$(document).ready(function () {

    // Collect the indicators from the server
    $.ajax({
        url: apifolder + '/backend/indicateur_nutritionnel.php',
        type: 'GET',
        success: function (data) {
            // Parse the JSON response
            var indicateurs = JSON.parse(data);

            // Append options to the nutritional indicator select
            var select = $('#id_indicateur');
            select.append('<option value="">Select the nutritional indicator</option>');
            $.each(indicateurs, function (index, value) {
                select.append('<option value="' + value.id_indicateur + '">' + value.nom + '</option>');
            });

            // Add an event listener to the add indicator button
            $('#add-indicator').click(function () {
                console.log("Le bouton Add a été cliqué !");
                var selectedIndicatorId = $("#id_indicateur").val();
                var selectedIndicator = indicateurs.find(function (element) {
                    return element.id_indicateur == selectedIndicatorId;
                });
                var selectedIndicatorName = selectedIndicator ? selectedIndicator.nom : "";
                var tableId = "#add-indicator-table";
                if (selectedIndicatorName != "") {
                    $(tableId + " tbody").append("<tr><td>" + selectedIndicatorName + "</td><td>" + $('#quantite').val() + "</td></tr>");
                }
            });

        }
    })
});


// Add event listener to the form submit button
$(document).ready(function () {
    $('#objectives-form').submit(function (event) {
        event.preventDefault(); // Prevent the default form submission

        var data = {
            'data': [] // Empty array for now
        };

        // Loop through each indicator-form
        $('.indicator-form').each(function () {
            // Get the values for this form
            var id_indicateur = $(this).find('.form-group select').val();
            var quantite = $(this).find('.form-group input[type="number"]').val();
            var login = $('#login').val();
            console.log(id_indicateur);
            console.log(quantite);
            console.log(login);

            // Add the data for this form to the data object
            data['data'].push({
                'id_indicateur': id_indicateur,
                'quantite': quantite,
                'login': login
            });
        });

        // Make the AJAX request with the modified data object
        $.ajax({
            url: apifolder + '/backend/objectif2.php',
            method: 'POST',
            data: JSON.stringify(data),
            contentType: 'application/json',
            success: function (response) {
                console.log(response); // Log the response from the API
                location.reload(); // Refresh the page
            },
            error: function (error) {
                console.error(error); // Log any errors that occur
            }
        });

    });
});



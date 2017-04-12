$('#postForm').submit(function(event) {

    event.preventDefault();

    // get form data and make ajax request to send form data to database
    var serializedData = $(this).serialize();
    var request = $.ajax({
        url: "../api/submitDB.php",
        type: "post",
        data: serializedData
    });

    request.done(function(response, textStatus, jqXHR) {
        // Clear inputs and messages when ajax request is successful
        clearPage();

        if (response.formInvalid) {
            // Fill corresponding label with error message, if any
            $('#titleErr').html("<font color='red'>" + response.titleErr + "<font>");
            $('#urlErr').html("<font color='red'>" + response.urlErr + "<font>");
            $('#textErr').html("<font color='red'>" + response.textErr + "<font>");
        } else {
            // Display message when insertion is successful
            $('#submitMsg')
                .addClass("alert alert-success")
                .append(response.message);
        }
    });

    request.fail(function(jqXHR, textStatus, errorThrown) {
        // Clear inputs and messages when ajax request failed
        clearPage();

        // Display mysqli error and log the error message to the console
        $('#submitMsg')
            .addClass("alert alert-danger")
            .append(jqXHR.responseJSON.message);
        console.error(
            "textStatus: " + textStatus + ", errorThrown: " + errorThrown
        );
    });
});

function clearPage() {
    // empty all input boxes and messages
    $('.errMsg').html('');
    $('#submitMsg').empty();
    $('#submitMsg').removeClass();
    $('.inputBox').val('');
    $('#postForm textarea').val('');
}
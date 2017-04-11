// sending form data to database
$('#postForm').submit(function(event) {

    event.preventDefault();

    var serializedData = $(this).serialize();

    var request = $.ajax({
        url: "../api/submitDB.php",
        type: "post",
        data: serializedData
    });

    request.done(function(response, textStatus, jqXHR) {
        if (response.formInvalid) {
            // Fill corresponding label with error message, if any
            $("#titleErr").html("<font color='red'>" + response.titleErr + "<font>");
            $("#urlErr").html("<font color='red'>" + response.urlErr + "<font>");
            $("#textErr").html("<font color='red'>" + response.textErr + "<font>");
        } else {
            // clear all input and error message when post is submitted
            $('.errMsg').html('');
            $(".inputBox").val('');
            $("#postForm textarea").val('');
            $('#submitMsg')
                .addClass("alert alert-success")
                .append(response.message);
        }
    });

    request.fail(function(jqXHR, textStatus, errorThrown) {
        $('#submitMsg')
                .addClass("alert alert-danger")
                .append(errorThrown);
        // Log the error to the console
        console.error(
            "textStatus: " + textStatus + ", errorThrown: " + errorThrown
        );
    });
});
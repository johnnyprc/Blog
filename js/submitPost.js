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
        clearPage(response.formInvalid);

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

    request.always(function() {
        // redirect page to the submit message, stripe any previous 
        // #element in the url
        var url = window.location.href;
        if (url.includes('#')) {
            url = url.substring(0, url.indexOf('#'));
        }
        console.log("url: " + url);
        window.location.href = url + '#submitMsg';
    });
});

function clearPage(formInvalid=true) {
    // empty all messages
    $('.errMsg').html('');
    $('#submitMsg').empty();
    $('#submitMsg').removeClass();

    // only empty all inputs when submit is successful
    if (!formInvalid) {
        $("input[name='inputTitle']").val('');
        $("input[name='imageURL']").val('');
        $('#postForm textarea').val('');
    }
}
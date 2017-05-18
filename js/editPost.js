// prompt user to confirm leaving the page without confirming edit
$('#postForm').areYouSure();

// flags to detect whether the inputs changed
var titleChange, urlChange, textChange;
titleChange = urlChange = textChange = false;

// change flag once the inputs are changed, only allow user to submit edit
// when one of the inputs are changed
$('.submitButton').prop("disabled", true);
$('input[name="inputTitle"]').change(function() {
    titleChange = true;
    $('.submitButton').prop("disabled", false);
});
$('input[name="imageURL"]').change(function() {
    urlChange = true;
    $('.submitButton').prop("disabled", false);
});
$('textarea[name="postText"]').change(function() {
    textChange = true;
    $('.submitButton').prop("disabled", false);
});

displayPost();

$('#postForm').submit(function(event) {

    event.preventDefault();
     // change text, disable button and show spinning icon while submitting
    $('#buttonText').text('Editing...');
    $('.submitButton').prop("disabled", true);
    $('#loadingIcon').addClass('glyphicon glyphicon-refresh spinning');

    // only send inputs which are changed
    var formData = {};
    if (titleChange) {
        formData['title'] = $('input[name="inputTitle"]').val();
    }
    if (urlChange) {
        formData['url'] = $('input[name="imageURL"]').val();
    }
    if (textChange) {
        formData['text'] = $('textarea[name="postText"]').val();
    }
    
    var formJson = JSON.stringify(formData);
    var editRequest = $.ajax({
        type: "post",
        url: "../api/submitDB.php",
        data: {
            'edit' : 'true',
            'json' : formJson,
            'postId' : getURLParameter('postId')
        }
    });

    editRequest.done(function(response, textStatus, jqXHR) {
        // Clear inputs and messages when ajax request is successful
        clearPage(response.formInvalid);

        if (response.formInvalid) {
            // Fill corresponding label with error message, if any
            $('#titleErr').html("<font color='red'>" + response.titleErr + "<font>");
            $('#urlErr').html("<font color='red'>" + response.urlErr + "<font>");
            $('#textErr').html("<font color='red'>" + response.textErr + "<font>");
        } else {
            // Display message when editing is successful
            $('#statusMsg')
                .addClass("alert alert-success")
                .append(response.message);
        }
    });

    editRequest.fail(function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
        // Clear inputs and messages when ajax request failed
        clearPage();

        // Display mysqli error and log the error message to the console
        $('#statusMsg')
            .addClass("alert alert-danger")
            .append(jqXHR.responseJSON.message);
        console.error(jqXHR.responseText);
    });

    editRequest.always(function() {
        // remove spinning icon and reset button 0.25 sec after submit finishes
        // (otherwise button changes too fast when just checking empty input)
        setTimeout(function() {
            $('#buttonText').text('Confirm');
            $('.submitButton').prop("disabled", false);
            $('#loadingIcon').removeClass();
        }, 250);

        // redirect page to the submit message, stripe any previous 
        // #element in the url
        var url = window.location.href;
        if (url.includes('#')) {
            url = url.substring(0, url.indexOf('#'));
        }
        window.location.href = url + '#statusMsg';
    });
});

function displayPost() {
    // ajax request to get current post content
    var request = $.ajax({
        type: "get",
        url: "../api/postsHandle.php",
        data: {
            'titleIdOnly' : "false",
            'postId' : getURLParameter('postId')
        }
    });

    request.done(function(response, textStatus, jqXHR) {
        var postContent = response[0];

        // set post content as default value
        $('input[name="inputTitle"]').attr('value', postContent['title']);
        $('input[name="imageURL"]').attr('value', postContent['url']);
        $('textarea[name="postText"]').val(postContent['text']);
    });

    request.fail(function(jqXHR, textStatus, errorThrown) {
        // display error when there's no post with current postId, also
        // disable submit button to prevent user from submitting
        $('#statusMsg')
            .addClass("alert alert-danger")
            .append("This post does not exist");
        $('.submitButton').prop("disabled", true);
        console.error(jqXHR.responseText);
    });
}

// get value from URL parameter
// http://stackoverflow.com/questions/11582512
function getURLParameter(name) {
    var regExp = new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)');
    var res = regExp.exec(location.search) || [null, ''];
    return decodeURIComponent(res[1].replace(/\+/g, '%20')) || null;
}

function clearPage(formInvalid=true) {
    // empty all messages
    $('.errMsg').html('');
    $('#statusMsg').empty();
    $('#statusMsg').removeClass();
}

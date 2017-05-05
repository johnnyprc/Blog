// prompt user to confirm leaving the page without confirming edit
$('#postForm').areYouSure();

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
    // display error when there's no post with current postId
    $('#statusMsg')
        .addClass("alert alert-danger")
        .append("This post does not exist");
    console.error(jqXHR.responseText);
});

// get value from URL parameter
// http://stackoverflow.com/questions/11582512
function getURLParameter(name) {
    var regExp = new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)');
    var res = regExp.exec(location.search) || [null, ''];
    return decodeURIComponent(res[1].replace(/\+/g, '%20')) || null;
}

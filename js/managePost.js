displayPage();

// submit POST request to delete post
$('#confirm-delete').on('click', '.btn-ok', function(e) {
    var $modalDiv = $(e.delegateTarget);
    var postId = $(this).data('postId');

    var deleteRequest = $.ajax({
        type: "post",
        url: "../api/postsHandle.php",
        data: {
            'postId' : postId,
            'delete' : true
        }
    });

    deleteRequest.done(function(response){
        // Refresh page to reflect deletion
        displayPage();

        // Clear previous message and display success message
        clearMsg();
        $('#deleteMsg').addClass("alert alert-success")
            .append(response.message);

    });

    deleteRequest.fail(function(jqXHR, textStatus, errorThrown) {
        // Clear previous message, display mysqli error and log error to console
        clearMsg();
        $('#deleteMsg').addClass("alert alert-danger")
            .append(jqXHR.responseJSON.message);
        console.error(
            "textStatus: " + textStatus + ", errorThrown: " + errorThrown
        );
    });

    $modalDiv.modal('hide');
});

// assign correct ID to the data tag in ok button within confirm modal
$('#confirm-delete').on('show.bs.modal', function(e) {
    var data = $(e.relatedTarget).data();
    $('.btn-ok', this).data('postId', data.postId);
});

function displayPage() {
    // clear unordered list
    $('.postList').empty();

    // ajax request to display all posts' title and store their IDs to data tag
    var request = $.ajax({
        type: "get",
        url: "../api/postsHandle.php",
        data: {
            'titleIdOnly' : "true"
        }
    });

    request.done(function(response, textStatus, jqXHR) {
        var listItem;
        
        // construct new list item and append to list
        $.each(response, function(key, value) {
            listItem = buildListItem(value['ID'], value['title']);
            $('.postList').append(listItem);
        });
    });  
}

// build HTML for list item with input data using Mustache
function buildListItem(Id, title) {
    var data = {
        Id : Id,
        title : title
    };

    // display title and store post Id in data tag
    var template =
        `<li class="list-group-item list-group-item-action justify-content-between">
            <span>{{title}}</span>
            <a class="badge" href="#" data-post-id="{{Id}}" data-toggle="modal"
                data-target="#confirm-delete">Delete</a>
        </li>`;
    return Mustache.render(template, data);
}

function clearMsg() {
    // Empty prompting message
    $('#deleteMsg').empty();
    $('#deleteMsg').removeClass();
}
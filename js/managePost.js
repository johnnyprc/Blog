// ajax request to display all posts' title and store their ID to data tag
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
        listItem = buildListItem(value['Id'], value['title']);
        $('.postList').append(listItem);
    })
});

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
        console.log("delete " + response.status);
    });

    $modalDiv.modal('hide');
});

// assign correct ID to the ok button in confirm modal
$('#confirm-delete').on('show.bs.modal', function(e) {
    var data = $(e.relatedTarget).data();
    $('.btn-ok', this).data('postId', data.postId);
});

function buildListItem(Id, title) {
    var data = {
        Id : Id,
        title : title
    }

    // display title and store post Id with HTML data tag
    var template =
        `<li class="list-group-item justify-content-between">
            <span>{{title}}</span>
            <a class="badge" href="#" data-post-id="{{Id}}" data-toggle="modal"
                data-target="#confirm-delete">Delete</a>
        </li>`;
    return Mustache.render(template, data);
}
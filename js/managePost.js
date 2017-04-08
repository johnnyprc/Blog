// submit POST request to delete post
$('#confirm-delete').on('click', '.btn-ok', function(e) {
    var $modalDiv = $(e.delegateTarget);
    var postId = $(this).data('postId');

    $.ajax({
        type: "post",
        url: "../api/postsHandle.php",
        data: {
            'postId' : postId,
            'delete' : true
        },
        success: function(response){
            console.log("delete " + response.status);
        }
    });

    $modalDiv.modal('hide');
});

// assign correct ID to the ok button in confirm modal
$('#confirm-delete').on('show.bs.modal', function(e) {
    var data = $(e.relatedTarget).data();
    $('.btn-ok', this).data('postId', data.postId);
});
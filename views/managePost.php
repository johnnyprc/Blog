<html lang="en">
<head>
    <title>Manage Post</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.1.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.js"></script>
    <?php
        // load up your config file
        require_once("../resources/config.php");
        echo '<link rel="stylesheet" href="'.SCRIPT_ROOT.'/css/style.css">';
    ?>
</head>
<?php     
    require_once(TEMPLATES_PATH . "/header.php");

    // Prompt user to login before submitting post
    if(!isset($_SESSION['username'])) {
        $_SESSION['err'] = "Please login before managing post";
        header( "Location: ../index.php" ); 
    }
?>

<div class="managePostContainer">
    <div id="deleteMsg"></div>
    <h2>Manage post</h2>
    <ul class="list-group postList"></ul>
</div>

<!-- modal for confirming deletion -->
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this post?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger btn-ok">Delete</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="../js/managePost.js"></script>
</body>
</html>



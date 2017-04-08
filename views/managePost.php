<html lang="en">
<head>
    <title>Manage Post</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.1.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
    <h2>Manage post</h2>
    <ul class="list-group postList">
        <li class="list-group-item justify-content-between">
            Cras justo odio
            <a class="badge badge-default badge-pill" href="../index.php">
                Delete</a>
        </li>
    </ul>
</div>

<!-- <script type="text/javascript" src="../js/submitPost.js"></script> -->
</body>
</html>



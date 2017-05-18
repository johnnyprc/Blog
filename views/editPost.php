<html lang="en">
<head>
    <title>Edit a Post</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.1.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="../resources/jquery.are-you-sure/jquery.are-you-sure.js"></script>
    <script src="../resources/jquery.are-you-sure/ays-beforeunload-shim.js"></script>
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
        $_SESSION['err'] = "Please login before editing post";
        header( "Location: ../index.php" ); 
    }
?>

<!-- page title and post submission form -->
<div id="submitContainer">
    <div id="statusMsg"></div>
    <h2>Edit a post</h2>
    <form id="postForm">
        <label>Beer Name:</label><span id="titleErr" class="errMsg"></span>
            <input class="form-control inputBox" type="text" name="inputTitle">
        <label>Beer Image URL:</label><span id="urlErr" class="errMsg"></span>
            <input class="form-control inputBox" type="text" name="imageURL">
        <label>Text:</label><span id="textErr" class="errMsg"></span>
            <textarea class="form-control" name="postText" rows="20"
                cols="120"></textarea>
        <button class="btn btn-default submitButton" type="submit" 
            form="postForm" title="Please make changes before submitting edit">
            <span id="loadingIcon"></span>
            <strong><span id="buttonText">Confirm</span></strong>
        </button>
    </form>
</div>

<script type="text/javascript" src="../js/editPost.js"></script>
</body>
</html>

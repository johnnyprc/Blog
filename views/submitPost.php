<html lang="en">
<head>
    <title>Submit a Post</title>
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
        $_SESSION['err'] = "Please login before submitting post";
        header( "Location: ../index.php" ); 
    }
?>

<!-- page title and post submission form -->
<div id="submitContainer">
    <div id="submitMsg"></div>
    <h2>Submit a post</h2><font color="red">All inputs are required</font>
    <form id="postForm">
        <label>Beer Name:</label><span id="titleErr" class="errMsg"></span>
            <input class="form-control inputBox" type="text" name="inputTitle">
        <label>Beer Image URL:</label><span id="urlErr" class="errMsg"></span>
            <input class="form-control inputBox" type="text" name="imageURL">
        <label>Text:</label><span id="textErr" class="errMsg"></span>
            <textarea class="form-control" name="postText" rows="20"
                cols="120"></textarea>
        <input class="btn btn-default submitButton" type="submit" value="Submit">
    </form>
</div>

<script type="text/javascript" src="../js/submitPost.js"></script>
</body>
</html>



<html lang="en">
<head>
    <link rel="stylesheet" href="../css/style.css">
    <title>Submit a Post</title>
</head>
<?php 
    // load up your config file
    require_once("../resources/config.php");
     
    require_once(TEMPLATES_PATH . "/header.php");

    // Prompt user to login before submitting post
    if(!isset($_SESSION['username'])) {
        $_SESSION['err'] = "Please login before submitting post";
        header( "Location: ../index.php" ); 
    }
?>
<div id="submitContainer">
    <h2>Submit a post</h2>
    <form>
        Title:<input class="inputBox" type="text" name="inputTitle">
        Image URL:<input class="inputBox" type="text" name="imageURL">
        Post: <textarea name="postText" rows="20" cols="120"></textarea>
        <input class="submitButton" type="submit" value="Submit">
    </form>
</div>
</body>
</html>



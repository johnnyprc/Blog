<html lang="en">
<head>
    <link rel="stylesheet" href="../css/style.css">
    <title>Submit a Post</title>
</head>
<?php    
    // load up your config file
    require_once("../resources/config.php");
     
    require_once(TEMPLATES_PATH . "/header.php");
?>
<div id="submitContainer">
    <h2>Submit a post</h2>
    <form>
        Title:<input type="text" name="inputTitle">
        Image URL:<input type="text" name="imageURL">
        Post: <textarea name="postText" rows="22" cols="140"></textarea>
        <input id="submitButton" type="submit" value="Submit">
    </form>
</div>
</body>
</html>



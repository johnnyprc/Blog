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
    <h2>Submit a post</h2><font color="red">All inputs are required</font>
    <form id="postForm">
        <label class="inputLabel">Title:</label>
            <input class="inputBox" type="text" name="inputTitle"><label id="titleErr"></label>
        <label class="inputLabel">Image URL:</label>
            <input class="inputBox" type="text" name="imageURL"><label id="urlErr"></label>
        <label class="inputLabel" id="textErr">Text:</label>
            <textarea name="postText" rows="20" cols="120"></textarea>
        <input class="submitButton" type="submit" value="Submit">
    </form>
</div>

<script>
// sending form data to database
$('#postForm').submit(function(event) {
    var request;

    event.preventDefault();

    $("#result").html('');

    var serializedData  = $(this).serialize();

    request = $.ajax({
        url: "../api/submitDB.php",
        type: "post",
        data: serializedData
    });

    request.done(function (response, textStatus, jqXHR){
        if (response.formInvalid) {
            // Fill corresponding label with error message, if any
            $("#titleErr").html("<font color='red'>" + response.titleErr + "<font>");
            $("#urlErr").html("<font color='red'>" + response.urlErr + "<font>");
            $("#textErr").html("Text: <font color='red'>" + response.textErr + "<font>");
        } else {
            alert(response.message);
        }
    });

    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        console.error(
            "textStatus: " + textStatus + ", errorThrown: " + errorThrown
        );
    });
});
</script>
</body>
</html>



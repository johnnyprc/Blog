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
    <form id="postForm">
        Title:<input class="inputBox" type="text" name="inputTitle">
        Image URL:<input class="inputBox" type="text" name="imageURL">
        Text: <textarea name="postText" rows="20" cols="120"></textarea>
        <input class="submitButton" type="submit" value="Submit">
    </form>
</div>

<!-- result of submitting a post -->
<div id="result"></div>

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
            // TODO: test url valid or not
            console.log(response.titleErr);
            console.log(response.urlErr);
            console.log(response.textErr);
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



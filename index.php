<html lang="en">
<head>
    <link rel="stylesheet" href="css/style.css">
    <title>Beer Blog</title>
</head>
<?php    
    // load up your config file
    require_once("resources/config.php");
     
    require_once(TEMPLATES_PATH . "/header.php");
?>
<div id="posts"></div>

<script>
    var request;
    request = $.ajax({
        url: "api/getPost.php",
        type: "get"  
    })

    request.done(function (response, textStatus, jqXHR){
        var newPost;
        // construct new post with same style and append to existing posts
        for (var key in response) {
            if (response.hasOwnProperty(key)) {
                newPost = constructPost(
                    response[key]['title'],
                    response[key]['date'],
                    response[key]['url'],
                    response[key]['text'],
                    response[key]['imgWidth'],
                    response[key]['imgHeight']
                );
                $("#posts").append(newPost);
            }
        }
    });

    request.fail(function (jqXHR, textStatus, errorThrown){
        console.error(
            "textStatus: " + textStatus + ", errorThrown: " + errorThrown
        );
    });

    function constructPost(title, date, url, text, imgWidth, imgHeight) {
        var myString = 
        `<div class="row">
            <h3 class="title">${title}</h3>
            <h3 class="date">${date}</h3>
        </div>
        <div class="row">
            <img src="${url}" alt="Image fail to load" height="${imgHeight}"
                width="${imgWidth}">
            <p>${text}</p>
        </div>`;
        return myString;
    }
</script>
</body>
</html>

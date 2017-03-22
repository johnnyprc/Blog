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
<div id="posts">
    <div class="row">
        <h3 class="title">Sierra Nevada Pale Ale</h3>
        <h3 class="date">2017-03-08</h3>
    </div>
    <div class="row">
        <img src="http://res.cloudinary.com/ratebeer/image/upload/w_250,c_limit/beer_365.jpg" alt="Image fail to load" height="363" width="125">
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
    </div>
</div>

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
                    response[key]['text']
                );
                $("#posts").append(newPost);
                console.log(response[key]['url']);
            }
        }
    });

    request.fail(function (jqXHR, textStatus, errorThrown){
        console.error(
            "textStatus: " + textStatus + ", errorThrown: " + errorThrown
        );
    });

    function constructPost(title, date, url, text) {
        var myString = 
        `<div class="row">
            <h3 class="title">${title}</h3>
            <h3 class="date">${date}</h3>
        </div>
        <div class="row">
            <img src=${url} alt="Image fail to load" height="200" width="80">
            <p>${text}</p>
        </div>`;
        return myString;
    }
</script>
</body>
</html>

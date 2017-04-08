
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("loginBtn");

// When the user clicks the button, open the modal 
if (btn != null) {
    btn.onclick = function() {
        modal.style.display = "block";
    }
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

var request;
request = $.ajax({
    url: "api/postsHandle.php",
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
    `<div class="panel panel-default dateContainer">
       <div class="panel-body">
            <p class="dateText"><strong>${date}</strong></p>
        </div>
    </div>
    <img class="beerImg" src="${url}" alt="Image failed to load" 
        height="${imgHeight}" width="${imgWidth}">
    <div class="panel panel-default postContainer">
        <div class="panel-heading postText">${title}</div>
        <div class="panel-body postText">${text}</div>
    </div>`;
    return myString;
}
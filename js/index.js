
var postsPerPage = 5;

// prevent incorrect error message to show
$('#loginBtn').click(function() {
    $('#loginErrMsg').remove();
});

// ajax request to display all posts
var request = $.ajax({
    url: "api/postsHandle.php",
    type: "get",
    data: {
        'titleIdOnly' : "false"
    }
});

request.done(function(response, textStatus, jqXHR) {
    var value;
    var currentPage = getURLParameter("page") || 1; // set current page to 1 
                                                    // when null 
    var numOfPosts = response.length;

    // make pagination elements
    constructPagination(numOfPosts, postsPerPage, currentPage);
    
    // get first and last post index for the current page
    var start = (currentPage - 1) * postsPerPage;
    var end = start + postsPerPage;
    for (var i = start; i < end; i++) {
        // exit the loop when the end is reached
        if (i >= numOfPosts) {
            break;
        }
        value = response[i];

        // construct new post with same style and append to existing posts
        $('#posts').append(constructPost(
            value['title'], 
            value['date'],
            value['url'],
            value['text'],
            value['imgWidth'],
            value['imgHeight']
        ));
    }
});

request.fail(function(jqXHR, textStatus, errorThrown) {
    console.warn(jqXHR.responseText)
});

function constructPost(title, date, url, text, imgWidth, imgHeight) {
    var data = {
        title : title,
        date : date,
        url : url,
        text : text,
        imgWidth : imgWidth,
        imgHeight : imgHeight
    };

    var template = 
        `<div class="panel panel-default dateContainer">
           <div class="panel-body">
                <p class="dateText"><strong>{{date}}</strong></p>
            </div>
        </div>
        <img class="beerImg" src="{{url}}" alt="Image failed to load" 
            height="{{imgHeight}}" width="{{imgWidth}}">
        <div class="panel panel-default postContainer">
            <div class="panel-heading postText">{{title}}</div>
            <div class="panel-body postText">{{text}}</div>
        </div>`;
    return Mustache.render(template, data);
}

function constructPagination(numOfPosts, postsPerPage, currentPage) {
    // calculate total number of pages necessary
    var totalPages = Math.ceil(numOfPosts / postsPerPage);
    var pageNumTemplate =
        `<li><a href="?page={{pageNum}}">{{pageNum}}</a></li>`;
    var navBtnTemplate = 
        `<li>
            <a href="?page={{pageNum}}" aria-label="{{label}}">
                <span aria-hidden="true">{{text}}</span>
            </a>
        </li>`

    // build the previous label and assign previous page as its link
    var data = {
        pageNum : currentPage - 1,
        label : "Previous",
        text: "Prev"
    };
    $('.pageList').append(Mustache.render(navBtnTemplate, data));

    // if no page number specified or on first page the previous label
    // will be disabled
    if (currentPage == null || currentPage == 1) {
        $('.pageList li').first().addClass("disabled");
        $('.pageList [href]').first().removeAttr("href");
    }

    // build list element for each page and assign page link
    for (var index = 1; index <= totalPages; index++) {
        data = {pageNum : index};
        $('.pageList').append(Mustache.render(pageNumTemplate, data));
    }

    // highlight the active page
    if (currentPage != null) {
        $(".pageList li:nth-child(" + (parseInt(currentPage) + 1) + ")").addClass("active");
    }

    // build the next label and assign next page as its link
    data = {
        pageNum : parseInt(currentPage) + 1,
        label : "Next",
        text : "Next"
    };
    $('.pageList').append(Mustache.render(navBtnTemplate, data));

    // if on last page the next label will be disabled
    if (currentPage == totalPages) {
        $('.pageList li').last().addClass("disabled");
        $('.pageList [href]').last().removeAttr("href");
    }
}

// get value from URL parameter
// http://stackoverflow.com/questions/11582512
function getURLParameter(name) {
    var regExp = new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)');
    var res = regExp.exec(location.search) || [null, ''];
    return decodeURIComponent(res[1].replace(/\+/g, '%20')) || null;
}
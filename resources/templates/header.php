<body>
<div id="header">
    <h1>My Beer Blog</h1>
    <div class="btn-group menuBtns">
    <?php 
        session_start();

        // Display submit/manage post button on home page
        // and home page button on submit/manage post page. 
        if(basename($_SERVER['PHP_SELF']) == "index.php") { 
            echo '<a class="btn btn-primary" href="'.SCRIPT_ROOT.
                    '/views/managePost.php">Manage Post</a>';
            echo '<a class="btn btn-primary" href="'.SCRIPT_ROOT.
                    '/views/submitPost.php">Submit Post</a>';
        } else {
            echo '<a class="btn btn-primary" href="'.SCRIPT_ROOT.
                    '/index.php">Home</a>';
        }
        
        // Display login button if user hasn't logged in, logout button 
        // if user has logged in
        if(isset($_SESSION['username'])) {
            echo '<a class="btn btn-primary" href="'.SCRIPT_ROOT.
                    '/api/authUser.php?logout=true">Logout</a>';
        } else {
            echo '<button class="btn btn-primary" id="loginBtn" 
                data-toggle="modal" data-target="#loginModal">Login</button>';
        }
    ?>   
    </div>
    <?php
        if(isset($_SESSION['username'])) {
            echo '<h4 id="nameTitle">Hello, ' .
                htmlspecialchars($_SESSION['username'], ENT_QUOTES) . '</h4>';
        }
    ?>
</div>
<hr>


<body>
<div id="header">
    <h1>My Beer Blog</h1>
    <div id="buttons">
        <?php 
            if(basename($_SERVER['PHP_SELF']) == "index.php") { 
                echo '<a id="navBtn" href="views/submitPost.php">Submit Post</a>';
            } else {
                echo '<a id="navBtn" href="../index.php">Home</a>';
            }
        ?>
        <button type="button">Login</button>
    </div>
</div>
<hr>


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
        <button id="loginBtn">Login</button>
        <!-- The Modal -->
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <form action="api/login.php" method="post">
                    <h3>Login to Blog to submit post</h3>
                    Username:<input class="inputBox" type="text" name="username"><br>
                    Password:<input class="inputBox" type="password" name="pwd"><br>
                    <input id="submitButtonModal" class="submitButton" type="submit" value="Submit">
                </form>                
            </div>

        </div>
    </div>
</div>
<hr>

<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.1.1.min.js"></script>

<script>
    // Get the modal
    var modal = document.getElementById('myModal');

    // Get the button that opens the modal
    var btn = document.getElementById("loginBtn");

    // When the user clicks the button, open the modal 
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

</script>


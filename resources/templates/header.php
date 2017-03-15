<body>
<div id="header">
    <h1>My Beer Blog</h1>
    <div id="buttons">
        <?php 
            session_start();

            // Display submitpost page link on homepage and homepage link on
            // submitpost page. Also only display login/logout button on homepage.
            if(basename($_SERVER['PHP_SELF']) == "index.php") { 
                echo '<a id="navBtn" href="views/submitPost.php">Submit Post</a>';

                if(isset($_SESSION['username'])) {
                    echo '<a id="logoutBtn" href="api/authUser.php?logout=true">Logout</a>';
                    echo '<span>Welcome ' .
                        htmlspecialchars($_SESSION['username'], ENT_QUOTES) . '</span>';
                }
                else {
                    echo '<button id="loginBtn">Login</button>';
                }

            } else {
                echo '<a id="navBtn" href="../index.php">Home</a>';
            }
            
            //Automatically show modal when login failed or user tried to submit post
            //without logging in.
            if(isset($_SESSION['err'])) {
                echo '<div id="myModal" class="modal" style="display:block;">';
            } else {
                echo '<div id="myModal" class="modal">';
            }
        ?>
        
            <!-- Modal content -->
            <div class="modal-content">
                <form action="api/authUser.php" method="post">
                    <h3>Login to Blog to submit post</h3>
                    <?php 
                        if(isset($_SESSION['err'])) {
                            echo '<p><font color="red">' .
                                htmlspecialchars($_SESSION['err'], ENT_QUOTES) . '</font></p>';
                            unset($_SESSION['err']);
                        }
                    ?>
                    Username:<br><input class="inputBoxModal" type="text" name="username"><br>
                    Password:<br><input class="inputBoxModal" type="password" name="pwd"><br>
                    <input class="submitButton" type="submit" name="login" value="Login">
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


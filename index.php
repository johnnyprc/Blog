<html lang="en">
<head>
    <title>Beer Blog</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.1.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <?php
        // load up your config file
        require_once("resources/config.php");
        echo '<link rel="stylesheet" href="'.SCRIPT_ROOT.'/css/style.css">';
    ?>
</head>
<?php
    require_once(TEMPLATES_PATH . "/header.php");

    // Automatically show modal when login failed or user tried to submit
    // post without logging in.
    if(isset($_SESSION['err'])) {
        echo '<div id="myModal" class="modal" style="display:block;">';
    } else {
        echo '<div id="myModal" class="modal">';
    }
?>
    <!-- Modal content -->
    <div class="modal-content">
        <form action="api/authUser.php" method="post">
            <h2>Login to Blog to submit post</h2>
            <?php 
                if(isset($_SESSION['err'])) {
                    echo '<p><font color="red">' .
                        htmlspecialchars($_SESSION['err'], ENT_QUOTES) . '</font></p>';
                    unset($_SESSION['err']);
                }
            ?>
            <!-- Username:<br><input class="inputBoxModal" type="text" name="username"><br>
            Password:<br><input class="inputBoxModal" type="password" name="pwd"><br> -->
            <div class="form-group inputBoxModal">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="email" name="username">
            </div>
            <div class="form-group inputBoxModal">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" id="pwd" name="pwd">
            </div>
            <input class="btn btn-default submitButton" type="submit" name="login" value="Login">
        </form>
    </div>
</div>

<div id="posts"></div>

<script type="text/javascript" src="js/index.js"></script>
</body>
</html>

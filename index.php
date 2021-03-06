<html lang="en">
<head>
    <title>Beer Blog</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.1.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.js"></script>
    <?php
        // load up your config file
        require_once("resources/config.php");
        echo '<link rel="stylesheet" href="'.SCRIPT_ROOT.'/css/style.css">';
    ?>
</head>
<?php
    require_once(TEMPLATES_PATH . "/header.php");

    // Automatically show modal when login failed or user tried to submit
    // or manage post without logging in.
    if(isset($_SESSION['err'])) {
        echo '<script type="text/javascript">
                $(document).ready(function() {
                    $("#loginModal").modal("show");
                });
              </script>';
    }
?>

<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form action="api/authUser.php" method="post">
                    <h2>Login</h2>
                    <?php
                        // show error message and unset error to prevent error
                        // displaying again when page is refreshed
                        if(isset($_SESSION['err'])) {
                            echo '<p id="loginErrMsg"><font color="red">' .
                                htmlspecialchars($_SESSION['err'], ENT_QUOTES) . '</font></p>';
                            unset($_SESSION['err']);
                        }
                    ?>
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
    </div>
</div>

<div id="posts"></div>

<div id="outer">
    <div id="bottomNav">
        <nav aria-label="Posts page navigation">
            <ul class="pagination pageList">
            </ul>
        </nav>
    </div>
</div>

<script type="text/javascript" src="js/index.js"></script>
</body>
</html>

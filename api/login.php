<?php
    require '../resources/config.php';
    session_start();

    if(isset($_POST['login'])) {
        // /* Connect to MySQL and select the database. */
        $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

        if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();
        
        $myusername = mysqli_real_escape_string($connection, $_POST['username']);
        $database = mysqli_select_db($connection, DB_DATABASE);
        // $hash = password_hash($_POST['pwd'], PASSWORD_DEFAULT);

        checkLogin($connection, $myusername, $_POST['pwd']);
        mysqli_close($connection);
    }

    function checkLogin($connection, $username, $pwd) {
        /* Querying database for user info */
        $sql = "SELECT pwd FROM Userinfo WHERE username = '$username'";
        $result = mysqli_query($connection, $sql);
        if (!$result) echo "Error description: " . mysqli_error($connection);
        $hash = mysqli_fetch_row($result)[0];

        /* Username and password matched */
        if (password_verify($pwd, $hash)) {
            $_SESSION['username'] = "123";
            header( "refresh:1;url=../index.php" ); 
            echo 'Login successful, you\'ll be redirected home page in 2 secs. If not, click <a href="../index.php">here</a>.';
        } else {
            $_SESSION['err'] = "Username and password is not valid";
            header( "Location: ../index.php" ); 
        }
    }

?>
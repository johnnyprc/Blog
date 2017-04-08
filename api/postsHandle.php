<?php
    require '../resources/config.php';
    include '../resources/ChromePhp.php';

    header('Content-Type: application/json');
    
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        retrievePosts($connection);
    } else {
        if (isset($_POST['delete'])) {
            $response = array();
            $response['status'] = 'success';
            echo(json_encode($response));
        }
    }

    function retrievePosts($connection) {
        // get every entry from the 'Posts' table
        $query = "SELECT * FROM Posts ;";
        $posts = array();

        if ($result = mysqli_query($connection, $query)) {
            // send results back as JSON
            $posts = $result->fetch_all(MYSQLI_ASSOC);
            echo(json_encode($posts));

            // Free result set
            mysqli_free_result($result);
        }

        mysqli_close($connection);
    }
?>
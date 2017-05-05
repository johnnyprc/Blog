<?php
    require '../resources/config.php';
    include '../resources/ChromePhp.php';

    header('Content-Type: application/json');
    
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['postId'])) {
            // getting specific post for editing
            retrievePosts($connection, $_GET['titleIdOnly'], $_GET["postId"]);
        } else {
            // getting posts to display at index or manage post page
            retrievePosts($connection, $_GET['titleIdOnly']);
        }
    } else {
        if (isset($_POST['delete'])) {
            deletePost($connection, $_POST["postId"]);
        }
    }

    function retrievePosts($connection, $titleIdOnly, $postId=null) {
        $query = ''; 
        $posts = array();
        
        if ($postId == null) {
            if ($titleIdOnly == "true") {
                // get ID and title from the 'Posts' table
                $query = "SELECT `ID`, `title` FROM Posts ;";
            } else {
                // get every entry from the 'Posts' table
                $query = "SELECT * FROM Posts ;";
            }
        } else {
            $query = "SELECT `title`, `url`, `text` FROM Posts WHERE ID = '" . 
                        mysqli_real_escape_string($connection, $postId) . "';";
        }

        if ($result = mysqli_query($connection, $query)) {
            // return error when query result is empty
            if ($result->num_rows === 0) {
                header('HTTP/1.1 500 Query result is empty');
                die(json_encode(array(
                    'message' => "Query result is empty"
                )));
            }

            // send results back as JSON
            $posts = $result->fetch_all(MYSQLI_ASSOC);
            echo(json_encode($posts));

            // Free result set
            mysqli_free_result($result);
        }

        mysqli_close($connection);
    }

    function deletePost($connection, $Id) {
        $query = "DELETE FROM Posts WHERE ID = '" . 
                    mysqli_real_escape_string($connection, $Id) . "'";

        if (mysqli_query($connection, $query)) {
            // Successfully deleted post
            echo(json_encode(array(
                'message' => 'Successfully removed post!',
            )));
        } else {
            // Deletion failed, return error message
            $err = mysqli_error($connection);
            header('HTTP/1.1 500 Database delete query failed');
            echo(json_encode(array(
                'message' => "ERROR! " . $err
            )));
        }

        mysqli_close($connection);
    }
?>
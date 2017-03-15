<?php
    require '../resources/config.php';
    
    $title = mysqli_real_escape_string($connection, $_POST['inputTitle']);
    $url = mysqli_real_escape_string($connection, $_POST['imageURL']);
    $text = mysqli_real_escape_string($connection, $_POST['postText']);
    addPost($connection, $title, $url, $text);

    function addPost($connection, $title, $url, $text) {
        $query = "INSERT INTO `Posts` (`title`, `url`, `text`)
                    VALUES ('$title', '$url', '$text');";

        if(!mysqli_query($connection, $query)) {
            header('HTTP/1.1 500 Internal Server');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
        } else {
            echo "Successfully added post!";
        }

        mysqli_close($connection);
    }
?>
<?php
    require '../resources/config.php';
    include 'ChromePhp.php';

    // valid input before inserting into database
    validateForm($_POST['inputTitle'], $_POST['imageURL'], $_POST['postText']);

    $title = mysqli_real_escape_string($connection, $_POST['inputTitle']);
    $url = mysqli_real_escape_string($connection, $_POST['imageURL']);
    $text = mysqli_real_escape_string($connection, $_POST['postText']);
    // addPost($connection, $title, $url, $text);

    // Validate that all inputs are not empty and image URL is valid
    function validateForm($title, $url, $text) {
        $titleErr = $urlErr = $textErr = "";
        if (empty($title)) {
            $titleErr = "A title is required";
        }

        if (empty($url)) {
            $urlErr = "An image URL is required";
        } else {
            // checking for valid image URL, ignore warning so that 
            // it wouldn't mess up json response
            if (!@getimagesize($url)) {
                $urlErr = "Image URL is invalid";
            }
        }

        if (empty($text)) {
            $textErr = "required";
        }

        // If there are any invalid input return immediately
        if (!empty($titleErr) || !empty($urlErr) || !empty($textErr)) {
            header('Content-Type: application/json');
            die(json_encode(array(
                'formInvalid' => True,
                'titleErr' => $titleErr,
                'urlErr' => $urlErr,
                'textErr' => $textErr
            )));
        }
    }

    function addPost($connection, $title, $url, $text) {
        $query = "INSERT INTO `Posts` (`title`, `url`, `text`)
                    VALUES ('$title', '$url', '$text');";

        if(!mysqli_query($connection, $query)) {
            // return error code 500 when query failed
            header('HTTP/1.1 500 Database query failed');
            header('Content-Type: application/json');    
            die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
        } else {
            header('Content-Type: application/json');    
            echo(json_encode(array(
                'message' => 'Successfully added post!',
                'formInvalid' => FALSE
            )));
        }

        mysqli_close($connection);
    }

?>
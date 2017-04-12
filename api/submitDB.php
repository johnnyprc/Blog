<?php
    require '../resources/config.php';
    include '../resources/ChromePhp.php';

    header('Content-Type: application/json');

    // validate input and get image width and height before inserting
    // into database
    $imgSize = processInput(
        $_POST['inputTitle'], $_POST['imageURL'], $_POST['postText']
    );

    $title = mysqli_real_escape_string($connection, $_POST['inputTitle']);
    $url = mysqli_real_escape_string($connection, $_POST['imageURL']);
    $text = mysqli_real_escape_string($connection, $_POST['postText']);
    addPost($connection, $title, $url, $text, $imgSize);

    // Validate that all inputs are not empty and image URL is valid
    function processInput($title, $url, $text) {
        $titleErr = $urlErr = $textErr = "";
        $newImgSize;

        if (empty($title)) {
            $titleErr = "A title is required";
        }

        if (empty($url)) {
            $urlErr = "An image URL is required";
        } else {
            // checking for valid image URL, ignore warning so that 
            // it wouldn't mess up json response
            if (!$size = @getimagesize($url)) {
                $urlErr = "Image URL is invalid";
            } else {
                // resize image so that width and height is under limit, 
                // if necessary
                $newImgSize = resizeImage($size[0], $size[1]);
                // ChromePhp::log($newImgSize[0] . " / " . $newImgSize[1]);
            }
        }

        if (empty($text)) {
            $textErr = "required";
        }

        // If there are any invalid input return immediately
        if (!empty($titleErr) || !empty($urlErr) || !empty($textErr)) {
            die(json_encode(array(
                'formInvalid' => True,
                'titleErr' => $titleErr,
                'urlErr' => $urlErr,
                'textErr' => $textErr
            )));
        }

        return $newImgSize;
    }

    // scale down the image if necessary, and make sure the width and height
    // is under the limit while maintaining its original width and height ratio
    function resizeImage($width, $height) {
        $widthLimit = 120;
        $heightLimit = 300;
        $ratioLimit = $widthLimit / $heightLimit;
        // no need to resize image if width and height are under limit
        if ($width < $widthLimit && $height < $heightLimit) {
            return array ($width, $height);
        }
        // If the width/height ratio is higher than the ratio limit,
        // adjust the width to width limit and scale the height accordingly;
        // otherwise adjust the height to height limit and scale the width
        // accordingly
        if (($width / $height) > $ratioLimit) {
            $newHeight = $height * ($widthLimit / $width);
            return array ($widthLimit, $newHeight);
        } else {
            $newWidth = $width * ($heightLimit / $height);
            return array ($newWidth, $heightLimit);
        }
    }

    function addPost($connection, $title, $url, $text, $imgSize) {
        $currentDate = date("Y-m-d");
        list($width, $height) = $imgSize;
        $query = "INSERT INTO `Posts` (`title`, `url`, `text`, `date`,
                `imgWidth`, `imgHeight`)
            VALUES 
                ('$title', '$url', '$text', '$currentDate', '$width',
                '$height');";

        if(!mysqli_query($connection, $query)) {
            // return error code 500 when query failed
            $err = mysqli_error($connection);
            header('HTTP/1.1 500 Database insert query failed');
            echo(json_encode(array(
                'message' => "ERROR! " . $err
            )));
        } else {
            // insertion successful
            echo(json_encode(array(
                'message' => 'Successfully added post!',
                'formInvalid' => FALSE
            )));
        }

        mysqli_close($connection);
    }

?>
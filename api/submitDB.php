<?php
    require '../resources/config.php';
    include '../resources/ChromePhp.php';

    header('Content-Type: application/json');

    if(isset($_POST['edit'])) {
        $formJson = json_decode($_POST['json'], true);

        // assign empty string to parameters when corresponding
        // input is not set
        $title = isset($formJson["title"]) ? $formJson["title"] : "";
        $url = isset($formJson["url"]) ? $formJson["url"] : "";
        $text = isset($formJson["text"]) ? $formJson["text"] : "";
        
        $imgSize = processInput($title, $url, $text,
                                isset($formJson["title"]),
                                isset($formJson["url"]),
                                isset($formJson["text"]));

        if ($imgSize != "") {
            list($width, $height) = $imgSize;
            $formJson["imgWidth"] = $width;
            $formJson["imgHeight"] = $height;
        }

        updatePost($connection, $_POST['postId'], $formJson);
    }

    // validate input and get image width and height before inserting
    // into database
    $imgSize = processInput(
        $_POST['inputTitle'], $_POST['imageURL'], $_POST['postText']
    );

    $title = mysqli_real_escape_string($connection, $_POST['inputTitle']);
    $url = mysqli_real_escape_string($connection, $_POST['imageURL']);
    $text = mysqli_real_escape_string($connection, $_POST['postText']);
    addPost($connection, $title, $url, $text, $imgSize);

    // Validate that all inputs are not empty and image URL is valid, 
    // while editing only checks image url when the url is changed
    function processInput($title, $url, $text, $titleChange = true,
                                $urlChange = true, $textChange = true) {
        $titleErr = $urlErr = $textErr = "";
        $newImgSize = "";

        // only check input title when it has been changed
        if ($titleChange) {
            if (empty($title)) {
                $titleErr = "A title is required";
            }
        }

        // only check url when the url is changed
        if ($urlChange) {
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
                }
            }
        }

        // only check text when the text is changed
        if ($textChange) {
            if (empty($text)) {
                $textErr = "required";
            }
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

    function updatePost($connection, $postId, $formJson) {
        // build query with json key/pair value
        $query = "UPDATE `Posts` SET ";
        foreach($formJson as $key => $value){
            $query .= $key . "='" . 
                mysqli_real_escape_string($connection, $value) . "',";
        }
        // trim the last comma from the query
        $query = rtrim($query,", ");
        $query .= " WHERE ID=" . $postId;

        if(!mysqli_query($connection, $query)) {
            // return error code 500 when query failed
            $err = mysqli_error($connection);
            header('HTTP/1.1 500 Database update query failed');
            die(json_encode(array(
                'message' => "ERROR! " . $err
            )));
        } else {
            // update successful
            die(json_encode(array(
                'message' => 'Successfully updated post!',
                'formInvalid' => FALSE
            )));
        }

        mysqli_close($connection);
    }

?>
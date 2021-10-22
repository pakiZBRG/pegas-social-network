<?php

    include "../db.inc.php";
    include "../helpers/Messages.php";

    if(isset($_POST)) {
        $content = '';
        if($_POST["content"]) {
            $content = mysqli_real_escape_string($conn, $_POST["content"]);
        }
        $postId = mysqli_real_escape_string($conn, $_POST["postId"]);
        $file = $_FILES["image"];

        $fileName = $file["name"];
        $name = explode('.', $fileName)[0];
        $fileTmpName = $file["tmp_name"];
        $fileSize = $file["size"];
        $fileError = $file["error"];

        // 0 => 'There is no error, the file uploaded with success',
        // 1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        // 2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        // 3 => 'The uploaded file was only partially uploaded',
        // 4 => 'No file was uploaded',
        // 6 => 'Missing a temporary folder',
        // 7 => 'Failed to write file to disk.',
        // 8 => 'A PHP extension stopped the file upload.',

        $fileType = $file["type"];
        $fileExt = explode(".", $fileName);
        $fileAcutalExt = strtolower(end($fileExt));
    
        $allowed = array('jpg', 'jpeg', 'png', 'webp');

        // No content and image
        if($content == '' && $fileError == 4){
            warning('Insert content or image for the post');
        } else if($content == '' && $fileError == 0 ){
            // Only image
            if(in_array($fileAcutalExt, $allowed)){
                if($fileError === 0){
                    if($fileSize < 1000000){
                        // if other image is choosen, delete the old one from ./assets and assign new
                        $query = "SELECT upload_image FROM posts WHERE id=$postId;";
                        $img_result = mysqli_query($conn, $query);
                        if($row = mysqli_fetch_assoc($img_result)) {
                            $filename = $row["upload_image"];
                            $deleteimg = realpath($_SERVER["DOCUMENT_ROOT"]) . "/$filename";
                            if (file_exists($deleteimg)) {
                                unlink($deleteimg);
                            }
                        }

                        $fileNewName = 'assets/'.$name."-".time().".".$fileAcutalExt;
                        $fileDestination = realpath($_SERVER["DOCUMENT_ROOT"]) . "/$fileNewName";
                        move_uploaded_file($fileTmpName, $fileDestination);
                        $update = "UPDATE posts SET upload_image=? WHERE id=?;";
                        $stmt = mysqli_prepare($conn, $update);
                        mysqli_stmt_bind_param($stmt, "ss", $fileNewName, $postId);
                        mysqli_stmt_execute($stmt);
                        if($stmt){
                            success("Post updated");
                        } else {
                            error('SQL error: '.mysqli_error($conn));
                        }
                    } else {
                        warning("The file is to big. Limit is 1MB!");
                    }
                } else {
                    error("There was an error!");
                }
            } else {
                warning("Unrecognizable type. Allowed types: jpg, jpeg, png, webp");
            }
        } else if($content != '' && $fileError == 4) {
            // Filled content and same image
            $sql = "UPDATE posts SET post_content=? WHERE id=?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $content, $postId);
            mysqli_stmt_execute($stmt);

            if($stmt){
                success("Post Updated");
            } else {
                error('SQL error: '.mysqli_error($conn));
            }
        } else if($content && $file) {
            // Has both content and image
            if(in_array($fileAcutalExt, $allowed)){
                if($fileError === 0){
                    if($fileSize < 1000000){
                        // if other image is choosen, delete the old one from ./assets and assign new
                        $query = "SELECT upload_image FROM posts WHERE id=$postId;";
                        $img_result = mysqli_query($conn, $query);
                        if($row = mysqli_fetch_assoc($img_result)) {
                            $filename = $row["upload_image"];
                            $deleteimg = realpath($_SERVER["DOCUMENT_ROOT"]) . "/$filename";
                            if (file_exists($deleteimg)) {
                                unlink($deleteimg);
                            }
                        }

                        $fileNewName = 'assets/'.$name."-".time().".".$fileAcutalExt;
                        $fileDestination = realpath($_SERVER["DOCUMENT_ROOT"]) . "/$fileNewName";
                        move_uploaded_file($fileTmpName, $fileDestination);
                        $update = "UPDATE posts SET upload_image=?, post_content=? WHERE id=?;";
                        $stmt = mysqli_prepare($conn, $update);
                        mysqli_stmt_bind_param($stmt, "sss", $fileNewName, $content, $postId);
                        mysqli_stmt_execute($stmt);
                        if($stmt){
                            success("Post updated");
                        } else {
                            error('SQL error: '.mysqli_error($conn));
                        }
                    } else {
                        warning("The file is to big. Limit is 1MB!");
                    }
                } else {
                    error("There was an error!");
                }
            } else {
                warning("Unrecognizable type. Allowed types: jpg, jpeg, png, webp");
            }
        }
    }

?>
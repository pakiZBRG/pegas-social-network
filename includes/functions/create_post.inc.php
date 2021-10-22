<?php

    include "../helpers/Messages.php";

    if(isset($_POST["userId"])){
        require realpath($_SERVER["DOCUMENT_ROOT"]) . "/includes/db.inc.php";

        $user_id = mysqli_real_escape_string($conn, $_POST["userId"]);
        $content = mysqli_real_escape_string($conn, $_POST["content"]);
        $file = $_FILES["image"];
        $date = date("d-m-Y H:i");
        $likes = 0;
    
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

        // Empty post and image
        if(trim($content) == '' && $fileError == 4){
            warning('Insert content or image for the post');
        // Filled post and empty image
        } else if(trim($content) && $fileError == 4) {
            $file = '';
            $sql1 = "INSERT INTO posts (user_id, post_content, upload_image, post_date, likes) VALUES (?, ?, ?, ?, ?);";
            $stmt1 = mysqli_prepare($conn, $sql1);
            mysqli_stmt_bind_param($stmt1, "ssssi", $user_id, $content, $file, $date, $likes);
            mysqli_stmt_execute($stmt1);
            $error = mysqli_stmt_error($stmt1);

            if(!$error){
                success("Post created");
                $sql2 = "UPDATE users SET posts='yes' WHERE id=?;";
                $stmt2 = mysqli_prepare($conn, $sql2);
                mysqli_stmt_bind_param($stmt2, "s", $user_id);
                mysqli_stmt_execute($stmt2);
            } else {
                error('SQL error: '.$error);
            }
        // Both entered or entered image
        } else if((trim($content) && $file) || $fileError == 0) {
            if(in_array($fileAcutalExt, $allowed)){
                if($fileError === 0){
                    if($fileSize < 1000000){

                        $fileNewName = "assets/".$name."-".time().".".$fileAcutalExt;
                        $fileDestination = realpath($_SERVER["DOCUMENT_ROOT"]) . "/pegas/$fileNewName";
                        $sql3 = "INSERT INTO posts (user_id, post_content, upload_image, post_date, likes) VALUES (?, ?, ?, ?, ?);";
                        $stmt3 = mysqli_prepare($conn, $sql3);
                        mysqli_stmt_bind_param($stmt3, "ssssi", $user_id, $content, $fileNewName, $date, $likes);
                        mysqli_stmt_execute($stmt3);
                        $error = mysqli_stmt_error($stmt3);
                        if(!$error){
                            success("Post created");
                            move_uploaded_file($fileTmpName, $fileDestination);
                            $sql = "UPDATE users SET posts='yes' WHERE id=?;";
                            $stmt = mysqli_prepare($conn, $sql);
                            mysqli_stmt_bind_param($stmt, "s", $user_id);
                            mysqli_stmt_execute($stmt);
                        } else {
                            error('SQL error: '.$error);
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
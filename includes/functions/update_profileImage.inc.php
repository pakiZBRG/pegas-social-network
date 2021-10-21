<?php

    include '../helpers/Messages.php';
    include "../db.inc.php";

    // Insert and change PROFILE image
    if(isset($_FILES["u_profile"])){
        $user_id = mysqli_real_escape_string($conn, $_POST["userId"]);
        $file = $_FILES["u_profile"];
    
        $fileName = $file["name"];
        $name = explode('.', $fileName)[0];
        $fileTmpName = $file["tmp_name"];
        $fileSize = $file["size"];
        $fileError = $file["error"];
        $fileType = $file["type"];
    
        $fileExt = explode(".", $fileName);
        $fileAcutalExt = strtolower(end($fileExt));
    
        $allowed = array('jpg', 'jpeg', 'png', 'svg', 'webp');
    
        if(in_array($fileAcutalExt, $allowed)){
            if($fileError === 0){
                if($fileSize < 1000000){
                    // if other image is choosen, delete the old one from ./assets and assign new
                    $query = "SELECT profile_image FROM users WHERE id=$user_id;";
                    $img_result = mysqli_query($conn, $query);
                    if($row = mysqli_fetch_assoc($img_result)) {
                        $filename = $row["profile_image"];
                        if($filename != 'img/user.jpg') {   
                            $deleteimg = realpath($_SERVER["DOCUMENT_ROOT"]) . "/pegas/$filename";
                            if (file_exists($deleteimg)) {
                                unlink($deleteimg);
                            }
                        }
                    }

                    $fileNewName = $name."-".time().".".$fileAcutalExt;
                    $fileDestination = realpath($_SERVER["DOCUMENT_ROOT"]) . "/pegas/assets/$fileNewName";
                    move_uploaded_file($fileTmpName, $fileDestination);
                    $sql = "UPDATE users SET profile_image='assets/$fileNewName' WHERE id='$user_id';";
                    $run = mysqli_query($conn, $sql);
                    if($run) {
                        echo "/pegas/assets/$fileNewName";
                    }
                }
                else {
                    warning('The file is to big, upto 1MB');
                }
            }
            else {
                warning('There was an error');
            }
        }
        else if($fileAcutalExt){
            warning(".$fileAcutalExt files not allowed. Only images");
        } else {
            warning("jpg, jpeg, png, webp are allowed");
        }
    }

?>
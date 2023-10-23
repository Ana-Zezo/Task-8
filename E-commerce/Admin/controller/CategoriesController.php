<?php
session_start();
require_once("../../database/dbConn.php");
require_once("../../function/helper.php");
if (isset($_SESSION["auth"])) {
    if ($_SESSION["auth"]["role"] == 0) {
        $_SESSION["not_auth"] = "You Are Not Authorization To Access Dashboard";
        redirect("../../index.php");
        die;
    }
} else {
    $_SESSION["login"] = "Login to Continue";
    redirect("../../login.php");
    die;
}

// Check Request POST
if (checkRequest("POST")) {
    $errors = [];
    // Stored Value And Sanitize
    foreach ($_POST as $key => $item) {
        $$key = sanitize($item);
    }
    foreach ($_FILES as $key => $item) {
        // dd($key, $item);
        $$key = $item;
    }
    $nameImage = $image["name"];
    $fullPath = $image["full_path"];
    $type = $image["type"];
    $tmpName = $image["tmp_name"];
    $errorImage = $image["error"];
    $sizeImage = $image["size"];
    $allow_exe = ["jpg", "jpeg", "png", "gif", "webp"];
    $allow_mim = ["image/png", "image/jpeg", "image/gif", "image/webp"];
    // Validation Image
    if ($nameImage == "") {
        $errors["image"] = "Image Is Required";
    } else {
        $fileName = pathinfo($nameImage, PATHINFO_FILENAME);
        $fileExe = pathinfo($nameImage, PATHINFO_EXTENSION);
        if (in_array($fileExe, $allow_exe)) {
            $checkTmp = mime_content_type($tmpName);
            if (in_array($checkTmp, $allow_mim)) {
                if ($errorImage == 0) {
                    if ($sizeImage < 5000000) {
                        $newName = uniqid("", true) . "." . $fileExe;
                        move_uploaded_file($tmpName, "../img/" . $newName);
                    } else {
                        $errors["image"] = "Image Must Be Less Than 5M";
                    }
                } else {
                    $errors["image"] = "Error In Image";
                }

            } else {
                $errors["image"] = "Image Not Correct";
            }
        } else {
            $errors["image"] = "Image Must Be Image";
        }
    }
    // Validation Title 
    if (requiredVal($title)) {
        $errors["title"] = "Title Is Required Value";
    } elseif (minVal($title, 3)) {
        $errors["title"] = "Title Less Than 3 Char";
    } elseif (maxVal($title, 25)) {
        $errors["title"] = "Title Is Greater Than 25 Char";
    }
    // Validation Desc 
    if (requiredVal($desc)) {
        $errors["desc"] = "Description Is Required Value";
    } elseif (minVal($desc, 3)) {
        $errors["desc"] = "Description Less Than 3 Char";
    } elseif (maxVal($desc, 25)) {
    }
    // Validation Status
    if ($status == "Open menu") {
        $errors["status"] = "Status Is Required Value";
    }
    if (empty($errors)) {
        $insertValue = "INSERT INTO `categories` (`title`,`desc`,`status`,`image`) VALUES ('$title','$desc','$status','$newName')";
        $result = mysqli_query($conn, $insertValue) or die(mysqli_error($conn));
        $_SESSION["insert_success"] = "Successful Insert Data";
        redirect("../categories.php");
        die;
    } else {
        $_SESSION["insert_categories"] = $errors;
        redirect("../categories.php");
        die;
    }
} else {
    $_SESSION["request_error"] = "Request Error";
    redirect("../categories.php");
    die;
}
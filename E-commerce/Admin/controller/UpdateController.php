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
    // Validation Image
    $image = $_FILES["image"];
    $nameImage = $image["name"];
    $tmpName = $image["tmp_name"];
    if ($nameImage == "") {
        $id = $_GET["id"];
        $sql = "SELECT * FROM `categories` WHERE `id`='$id'";
        $result = mysqli_query($conn, $sql);
        $myData = mysqli_fetch_assoc($result);
        $newName = $_POST["image"];
        $updateValue = "UPDATE `categories` SET
        `title` = '$title',
        `desc`='$desc',
        `status`='$status',
        `image` = '$newName'
         WHERE `id` = '$id' ";
        $resultUpdate = mysqli_query($conn, $updateValue);
        if (!empty($errors)) {
            $_SESSION["update_error"] = $errors;
            redirect("../edit.php?id=" . $id);
            die;
        }
    } else {
        $fullPath = $image["full_path"];
        $type = $image["type"];
        $errorImage = $image["error"];
        $sizeImage = $image["size"];
        $allow_exe = ["jpg", "jpeg", "png", "gif", "webp"];
        $allow_mim = ["image/png", "image/jpeg", "image/gif", "image/webp"];
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
    if (empty($errors)) {
        // Update Data
        $id = $_GET["id"];
        $updateValue = "UPDATE `categories` SET
        `title` = '$title',
        `desc`='$desc',
        `status`='$status',
        `image` = '$newName'
         WHERE `id` = '$id' ";
        $resultUpdate = mysqli_query($conn, $updateValue);
        $_SESSION["update_success"] = "Successful Update Data";
        redirect("../edit.php?id=" . $id);
        die;
    } else {
        $_SESSION["update_error"] = $errors;
        redirect("../edit.php?id=" . $id);
        die;
    }
} else {
    $_SESSION["request_error"] = "Request Error";
    redirect("../edit.php?id=" . $id);
    die;
}
<?php
session_start();
require_once("../../../database/dbConn.php");
require_once("../../../function/helper.php");
if (isset($_SESSION["auth"])) {
    if ($_SESSION["auth"]["role"] == 0) {
        $_SESSION["not_auth"] = "You Are Not Authorization To Access Dashboard";
        redirect("../../../index.php");
        die;
    }
} else {
    $_SESSION["login"] = "Login to Continue";
    redirect("../../../login.php");
    die;
}
// Check Request POST
if (checkRequest("POST")) {
    $id = $_GET["id"];
    $errors = [];
    // Stored Value And Sanitize
    foreach ($_POST as $key => $item) {
        $$key = sanitize($item);
    }
    // Validation Name 
    if (requiredVal($name)) {
        $errors["name"] = "Name Is Required Value";
    } elseif (minVal($name, 3)) {
        $errors["name"] = "Name Less Than 3 Char";
    } elseif (maxVal($name, 25)) {
        $errors["name"] = "Name Is Greater Than 25 Char";
    }
    // Validation Price 
    if (requiredVal($price)) {
        $errors["price"] = "Price Is Required Value";
    }
    // Validation Status
    if ($status == "Open menu") {
        $errors["status"] = "Status Is Required Value";
    }
    // Validation Quantity
    if (requiredVal($qty)) {
        $errors["qty"] = "Quantity Is Required Value";
    }
    // Validation Image
    $image = $_FILES["image"];
    $nameImage = $image["name"];
    $tmpName = $image["tmp_name"];
    if ($nameImage == "") {
        $id = $_GET["id"];
        $sql = "SELECT * FROM `products` WHERE `id`='$id'";
        $result = mysqli_query($conn, $sql);
        $myData = mysqli_fetch_assoc($result);
        $newName = $_POST["image"];
        dd($myData);
        $updateValue = "UPDATE `products` SET
        `name` = '$name',
        `price`='$price',
        `status`='$status',
        `qty`='$qty',
        `image` = '$newName'
         WHERE `id` = '$id'";
        $resultUpdate = mysqli_query($conn, $updateValue);
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
                        move_uploaded_file($tmpName, "../../img/product" . $newName);
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
        $updateValue = "UPDATE `products` SET
        `name` = '$name',
        `price`='$price',
        `status`='$status',
        `qty`='$qty',
        `image` = '$newName'
         WHERE `id` = '$id'";
        $resultUpdate = mysqli_query($conn, $updateValue);
        $_SESSION["update_success"] = "Successful Update Data";
        redirect("../../AllProduct.php?id=" . $id);
        die;
    } else {
        $_SESSION["update_error"] = $errors;
        redirect("../../EditProduct.php?id=" . $id);
        die;
    }
} else {

    $_SESSION["request_error"] = "Request Error";
    redirect("../../EditProduct.php?id=" . $id);
    die;
}
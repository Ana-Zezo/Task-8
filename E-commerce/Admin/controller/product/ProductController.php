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
    $errors = [];
    // Stored Value And Sanitize
    foreach ($_POST as $key => $item) {
        $$key = sanitize($item);
    }
    $image = $_FILES["image"];
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
                        move_uploaded_file($tmpName, "../../img/product_img/" . $newName);
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
    // Validation Quantity 
    if (requiredVal($price)) {
        $errors["qty"] = "Quantity Is Required Value";
    }
    // Validation Status
    if ($status == "Open menu") {
        $errors["status"] = "Status Is Required Value";
    }
    // Validation Categories 
    if ($cat_id == "Open menu") {
        $errors["categories"] = "Categories Is Required Value";
    }
    if (empty($errors)) {
        $insertValue = "INSERT INTO `products` (`name`,`price`,`status`,`qty`,`image`,`cat_id`) 
        VALUES ('$name',$price,$status,$qty,'$newName',$cat_id)";
        $result = mysqli_query($conn, $insertValue) or die(mysqli_error($conn));
        $_SESSION["insert_success"] = "Successful Insert Data";
        redirect("../../AddProduct.php");
        die;
    } else {
        $_SESSION["insert_product"] = $errors;
        redirect("../../AddProduct.php");
        die;
    }
} else {
    $_SESSION["request_error"] = "Request Error";
    redirect("../../AddProduct.php");
    die;
}
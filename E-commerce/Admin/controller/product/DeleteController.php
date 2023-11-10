<?php
session_start();
require_once "../../../function/helper.php";
require_once "../../../database/dbConn.php";
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
$sql = "SELECT * FROM `products`";
$result = mysqli_query($conn, $sql);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
if (checkRequest("GET")) {
    foreach ($products as $key => $item) {
        if ($products[$key]["id"] == $_GET["id"]) {
            $id = $products[$key]["id"];
            $sql = "SELECT image FROM products WHERE id=$id";
            $result = mysqli_query($conn, $sql);
            $arr = mysqli_fetch_array($result, MYSQLI_ASSOC);
            deleteImage("../../img/product_img/" . $arr["image"]);
            $sql = "DELETE FROM `products` WHERE `id` = '$id'";
            $result = mysqli_query($conn, $sql);
            $_SESSION["success_delete"] = "Successfully Delete";

            redirect("../../AllProduct.php");
            die;
        }
    }
    $_SESSION["no_exist"] = "No Exist Data";
    redirect("../../AllProduct.php");
    die;

} else {
    $_SESSION["request_error"] = "Request Error";
    redirect("../../AllProduct.php");
    die;
}
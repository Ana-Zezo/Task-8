<?php
session_start();
if (isset($_SESSION["auth"])) {
    if ($_SESSION["auth"]["role"] == 1) {
        $_SESSION["not_auth"] = "You Are Customer";
        redirect("../index.php");
        die;
    }
} else {
    $_SESSION["login"] = "Login to Continue";
    redirect("../login.php");
    die;
}
require_once("../function/helper.php");
require_once("../database/dbConn.php");
if (checkRequest("GET")) {
    $product_id = $_GET["id"];
    $user_id = ($_SESSION["auth"]["id"]);
    $select_all_product = "SELECT * FROM `products` WHERE id = $product_id";
    $result_product = mysqli_query($conn, $select_all_product);
    $row_product = mysqli_fetch_all($result_product, MYSQLI_ASSOC);
    $select_all_users = "SELECT * FROM `users` WHERE id = $user_id";
    $result_users = mysqli_query($conn, $select_all_users);
    $row_users = mysqli_fetch_all($result_users);
    $total = $row_product[0]["price"];
    $cat_id = $row_product[0]["cat_id"];
    $categories_query = "SELECT * FROM `categories` WHERE id=$cat_id";
    $result_categories = mysqli_query($conn, $categories_query);
    $row_categories = mysqli_fetch_all($result_categories, MYSQLI_ASSOC);
    $product_name = $row_categories[0]["title"];
    $sql = "INSERT INTO `carts`(`total`,`product_id`,`user_id`)
    VALUES($total,$product_id,$user_id)";
    $result = mysqli_query($conn, $sql);
    $_SESSION["insert_data"] = "Successfully Insert Data";
    redirect("../cart.php?user_id=$user_id");
    die;
} else {
    $_SESSION["request_error"] = "Request Error";
    redirect("../order.php?user_id=$user_id");
    die;
}
// foreach ($row_product as $key => $value) {
//     $price += $row_product[$key]["price"];
//     $qty += $row_product[$key]["qty"];
// }
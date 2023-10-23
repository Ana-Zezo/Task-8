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
$qty_POST = $_POST["qty"];
$product_id = $_POST["product_id"];
$user_id = $_POST["user_id"];

// Select All Product Phone
$select_product = "SELECT * FROM `products` WHERE `id`=$product_id";
$result_product = mysqli_query($conn, $select_product);
$row_product = mysqli_fetch_assoc($result_product);
$cart_id = $_GET["cart_id"];
// Sorted All Qty
$all_qty = $row_product["qty"];
// Sorted  price
$price = $row_product["price"];
if (checkRequest("POST")) {
    $new_qty = $all_qty - $qty_POST;
    if ($all_qty > 0) {
        $sql_update = "UPDATE `products` SET `qty`= $new_qty WHERE `id`=$product_id";
        $result_update = mysqli_query($conn, $sql_update);
    } else {
        $_SESSION["no_exist_product"] = "Not Exit This Product In Store";
        echo "<select class='form-select'style='width: 100px; margin: 0 auto' name='qty'>";
        echo "<option value='0' selected>0</option>";
        echo "</select>";
        redirect("../cart.php?user_id=$user_id");
        die;
    }
    $total = $price * $qty_POST;
    $sql = "INSERT INTO `orders`(`total_price`,`user_id`,`product_id`)
    VALUES($total,$user_id,$product_id)";
    $result = mysqli_query($conn, $sql);
    $delete_query = "DELETE FROM `carts` WHERE `id`= $cart_id";
    $result_delete = mysqli_query($conn, $delete_query);
    $_SESSION["success_order"] = "Add To Order";
    redirect("../cart.php?user_id=$user_id");
    die;

} else {
    $_SESSION["request_error"] = "Request Error";
    redirect("../cart.php?user_id=$user_id");
    die;
}
// foreach ($row_product as $key => $value) {
//     $price += $row_product[$key]["price"];
//     $qty += $row_product[$key]["qty"];
// }



// $product_name = $row_categories[0]["title"];
// $cat_id = $row_product[0]["cat_id"];
// $categories_query = "SELECT * FROM `categories` WHERE id=$cat_id";
// $result_categories = mysqli_query($conn, $categories_query);
// $row_categories = mysqli_fetch_all($result_categories, MYSQLI_ASSOC);
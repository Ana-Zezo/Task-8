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
$cart_id = $_GET["cart_id"];
$user_id = $_GET["user_id"];
$delete_query = "DELETE FROM `carts` WHERE `id`= $cart_id";
$result_delete = mysqli_query($conn, $delete_query);
$_SESSION["success_order"] = "Add To Order";
redirect("../cart.php?user_id=$user_id");
die;
?>
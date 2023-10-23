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
$process = $_POST["process"];
$order_id = $_POST["order_id"];
$total = 0;
$update_query = "UPDATE `orders` SET `process` = '$process',`total_price`=$total WHERE `id`=$order_id";
$update_result = mysqli_query($conn, $update_query);
redirect("../../order.php");
die;
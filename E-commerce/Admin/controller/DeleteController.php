<?php
session_start();
require_once "../../function/helper.php";
require_once "../../database/dbConn.php";
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
$sql = "SELECT * FROM `categories`";
$result = mysqli_query($conn, $sql);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
if (checkRequest("GET")) {
    foreach ($categories as $key => $item) {
        if ($categories[$key]["id"] == $_GET["id"]) {
            $id = $categories[$key]["id"];
            $sql = "DELETE FROM `categories` WHERE `id` = '$id'";
            $result = mysqli_query($conn, $sql);
            $_SESSION["success_delete"] = "Successfully Delete";
            redirect("../displayCategories.php");
            die;
        }
    }
    $_SESSION["no_exist"] = "No Exist Data";
    redirect("../displayCategories.php");
    die;

} else {
    $_SESSION["request_error"] = "Request Error";
    redirect("../displayCategories.php");
    die;
}
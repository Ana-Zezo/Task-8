<?php
session_start();
require_once("../database/dbConn.php");
require_once("../function/helper.php");

// Check Request POST
if (checkRequest("POST")) {
    $errors = [];
    // Stored Value And Sanitize
    foreach ($_POST as $key => $item) {
        $$key = sanitize($item);
    }
    // Validation Email
    if (requiredVal($email)) {
        $errors["email"] = "Email Is Required Value";
    } elseif (emailVal($email)) {
        $errors["email"] = "Invalid Email";
    }


    // Validation Password
    if (requiredVal($password)) {
        $errors["password"] = "Password Is Required Value";
    }
    if (empty($errors)) {
        $sql = "SELECT `email` FROM `users` WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) == 0) {
            $_SESSION["email_exist"] = "Email Not Exist";
            redirect("../register.php");
        }
        $email = mysqli_real_escape_string($conn, $email);
        $password = mysqli_real_escape_string($conn, $password);
        $sql = "SELECT * FROM `users` WHERE `email` = '$email'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $secrit_password = $row["password"];
        $checkPassword = password_verify($password, $secrit_password);
        if ($row["email"] == $email && $row["password"] == $checkPassword) {
            $login_query = "SELECT * FROM `users` WHERE`email` = '$email' AND  $checkPassword = 1";
            $result = mysqli_query($conn, $login_query);
            $login_result = mysqli_query($conn, $login_query) or die(mysqli_error($conn));
            $users = mysqli_fetch_array($login_result, MYSQLI_ASSOC);
        } else {
            $_SESSION["password_error"] = "Incorrect Password";
            redirect("../login.php");
            die;
        }
        if (mysqli_num_rows($login_result) > 0) {
            $_SESSION["auth"] = [
                "id" => $users["id"],
                "name" => $users["name"],
                "email" => $users["email"],
                "password" => $users["password"],
                "role" => $users["role"]
            ];
            if ($_SESSION["auth"]["role"] == 1) {
                $_SESSION["login_success"] = "Welcome To Dashboard";
                redirect("../Admin/index.php");
                die;
            } else {
                $_SESSION["login_success"] = "Login Successfully";
                redirect("../index.php");
                die;
            }
        } else {
            $_SESSION["message"] = "Invalid Credentials";
            redirect("../login.php");
            die;
        }
    } else {
        $_SESSION["login_error"] = $errors;
        redirect("../login.php");
        die;
    }


} else {
    $_SESSION["request_error"] = "Request Error";
    redirect("../login.php");
    die;
}
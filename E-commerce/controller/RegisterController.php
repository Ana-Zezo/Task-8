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

    // Validation Name 
    if (requiredVal($name)) {
        $errors["name"] = "Name Is Required Value";
    } elseif (minVal($name, 3)) {
        $errors["name"] = "Name Less Than 3";
    } elseif (maxVal($name, 25)) {
        $errors["name"] = "Name Greater Than 25";
    }
    // Validation Phone 
    if (requiredVal($phone)) {
        $errors["phone"] = "Phone Is Required Value";
    } elseif (minVal($phone, 3)) {
        // Change The Value After Finish to 10
        $errors["phone"] = "Phone Less Than 3";
    } elseif (maxVal($phone, 15)) {
        $errors["phone"] = "Phone Greater Than 15";
    }
    // Validation Password 
    if (requiredVal($password)) {
        $errors["password"] = "Password Is Required Value";
    } elseif (minVal($password, 3)) {
        // Change The Value After Finish to 10
        $errors["password"] = "Password Less Than 3";
    } elseif (maxVal($password, 25)) {
        $errors["password"] = "Password Greater Than 15";
    }
    // Validation confPassword 
    if (requiredVal($confPassword)) {
        $errors["confPassword"] = "Confirm Password Is Required Value";
    }
    // Validation email 
    if (requiredVal($email)) {
        $errors["email"] = "Email Is Required Value";
    } elseif (emailVal($email)) {
        $errors["email"] = "Invalid Email";
    }
    if ($role == "") {
        $errors["role"] = "Role Required Value";
    }
    if (empty($errors)) {
        $sql = "SELECT `email` FROM `users` WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $_SESSION["email_exist"] = "Email Exist";
            redirect("../register.php");
        } else {
            $checkPassword = mysqli_real_escape_string($conn, $password);
            $confirmPassword = mysqli_real_escape_string($conn, $confPassword);
            if ($checkPassword == $confirmPassword) {
                $password = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO `users`(`name`,`email`,`phone`, `password`,`role`)
                VALUES('$name','$email','$phone','$password','$role')";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $_SESSION["register_success"] = "Successful Register";
                    redirect("../login.php");
                    die;
                } else {
                    $_SESSION["register_fail"] = "Register Error";
                    redirect("../register.php");
                    die;
                }

            } else {
                $_SESSION["confirm_password_error"] = "Not Confirm Password";
                redirect("../register.php");
                die;
            }
        }

    } else {
        $_SESSION["register_error"] = $errors;
        redirect("../register.php");
        die;
    }


} else {
    $_SESSION["request_error"] = "Request_error";
    redirect("../register.php");
    die;
}
?>
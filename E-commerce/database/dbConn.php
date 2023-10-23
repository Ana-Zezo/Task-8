<?php
$hostName = "localhost";
$password = "";
$userName = "root";
$dbName = "E-commerce";

$conn = mysqli_connect($hostName, $userName, $password, $dbName);
$sql = "CREATE DATABASE IF NOT EXISTS `$dbName`";
$result = mysqli_query($conn, $sql);
if (!$conn) {
    echo "Error Connect" . mysqli_connect_error();
}

// Create Tables Users
$conn = mysqli_connect($hostName, $userName, $password, $dbName);
$sql = "CREATE TABLE IF NOT EXISTS `users`(
    `id` BIGINT PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR (50),
    `email` VARCHAR (75) ,
    `phone` VARCHAR (25) ,
    `password` VARCHAR(50)
    )";
$result = mysqli_query($conn, $sql);

// Create Table Categories 
$sql = "CREATE TABLE IF NOT EXISTS `categories`(
    `id` BIGINT PRIMARY KEY AUTO_INCREMENT,
    `title` VARCHAR (50) NOT NULL,
    `desc` VARCHAR (255)  NOT NULL,
    `status` INT DEFAULT 0,
    `image` VARCHAR(255) NOT NULL
    )";
$result = mysqli_query($conn, $sql);

?>
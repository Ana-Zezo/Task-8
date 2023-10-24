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

// Product Sql
$product_query = "ALTER TABLE `products` DROP FOREIGN KEY `products_ibfk_1`";
$result = mysqli_query($conn, $product_query);
$product_query = " ALTER TABLE `products` ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;";
$result = mysqli_query($conn, $product_query);

// Carts sql
$carts_query = "ALTER TABLE `carts` DROP FOREIGN KEY `cart_ibfk_1`";
$result = mysqli_query($conn, $carts_query);
$carts_query = "ALTER TABLE `carts` ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE ON UPDATE CASCADE";
$result = mysqli_query($conn, $carts_query);
$carts_query = "ALTER TABLE `carts` DROP FOREIGN KEY `carts_ibfk_2`";
$result = mysqli_query($conn, $carts_query);
$carts_query = "ALTER TABLE `carts` ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE";
$result = mysqli_query($conn, $carts_query);

// Order sql
$order_query = "ALTER TABLE `orders` DROP FOREIGN KEY `orders_ibfk_1`";
$result = mysqli_query($conn, $order_query);
$order_query = "ALTER TABLE `orders` ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE";
$result = mysqli_query($conn, $order_query);
$order_query = "ALTER TABLE `orders` DROP FOREIGN KEY `orders_ibfk_2`";
$result = mysqli_query($conn, $order_query);
$order_query = "ALTER TABLE `orders` ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE ON UPDATE CASCADE";
$result = mysqli_query($conn, $order_query);
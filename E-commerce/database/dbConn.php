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
// $conn = mysqli_connect($hostName, $userName, $password, $dbName);
$sql = "CREATE TABLE IF NOT EXISTS `users`(
    `id` BIGINT PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR (255),
    `email` VARCHAR (255) ,
    `phone` VARCHAR (255) ,
    `password` VARCHAR(255),
    `role` int(11) NOT NULL DEFAULT 0
    )";
$result = mysqli_query($conn, $sql);

// Create Table Categories 
$sql = "CREATE TABLE IF NOT EXISTS `categories`(
    `id` BIGINT PRIMARY KEY AUTO_INCREMENT,
    `title` VARCHAR (255) NOT NULL,
    `desc` VARCHAR (255)  NOT NULL,
    `status` INT DEFAULT 0,
    `image` VARCHAR(255) NOT NULL
    )";
$result = mysqli_query($conn, $sql);

// Create Table Product
$create_product = "CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `cat_id` bigint(20) DEFAULT NULL)";
$result = mysqli_query($conn, $create_product);
// Product Sql
$product_query = "ALTER TABLE `products` DROP FOREIGN KEY `products_ibfk_1`";
$result = mysqli_query($conn, $product_query);
$product_query = " ALTER TABLE `products` ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;";
$result = mysqli_query($conn, $product_query);

// Create Table Carts
$create_carts = "CREATE TABLE IF NOT EXISTS `carts` (
  `id` bigint(20) NOT NULL,
  `total` int(11) NOT NULL,
  `product_id` int(20) NOT NULL,
  `user_id` bigint(20) NOT NULL)";
$result = mysqli_query($conn, $create_carts);
// Carts sql
$carts_query = "ALTER TABLE `carts` DROP FOREIGN KEY `cart_ibfk_1`";
$result = mysqli_query($conn, $carts_query);
$carts_query = "ALTER TABLE `carts` ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE ON UPDATE CASCADE";
$result = mysqli_query($conn, $carts_query);
$carts_query = "ALTER TABLE `carts` DROP FOREIGN KEY `carts_ibfk_2`";
$result = mysqli_query($conn, $carts_query);
$carts_query = "ALTER TABLE `carts` ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE";
$result = mysqli_query($conn, $carts_query);

// Create Table Orders
$order_query = "CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL,
  `total_price` bigint(20) NOT NULL,
  `process` enum('0','1') NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `product_id` int(11) NOT NULL)";
$result = mysqli_query($conn, $order_query);
// Order sql
$order_query = "ALTER TABLE `orders` DROP FOREIGN KEY `orders_ibfk_1`";
$result = mysqli_query($conn, $order_query);
$order_query = "ALTER TABLE `orders` ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE";
$result = mysqli_query($conn, $order_query);
$order_query = "ALTER TABLE `orders` DROP FOREIGN KEY `orders_ibfk_2`";
$result = mysqli_query($conn, $order_query);
$order_query = "ALTER TABLE `orders` ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE ON UPDATE CASCADE";
$result = mysqli_query($conn, $order_query);
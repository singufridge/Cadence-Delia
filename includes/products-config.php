#!/usr/bin/php-cgi
<?php
require_once 'dbh.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $p_name = htmlspecialchars($_POST['product_name']);
    $p_desc = htmlspecialchars($_POST['product_desc']);
    $p_price = $_POST['price'];

    $stmt = $conn->prepare("SELECT * FROM products WHERE product_name = ? AND product_desc = ? AND price = ?");
    $stmt->bind_param("ssi", $p_name, $p_desc, $p_price);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $stmt = $conn->prepare("INSERT INTO products (`product_name`, `product_desc`, `price`, `image`) VALUES (?, ?, ?, 'images/no-img.png')");
        $stmt->bind_param("ssi", $p_name, $p_desc, $p_price);
        $stmt->execute();
        $result = $stmt->get_result();

        header('location: ../admin_products.php?error=none');
    } else {
        header('location: ../admin_products.php?error=exists');
    }
} else if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if(isset($_GET['delete'])) {
        $p_id = $_GET['product_id'];

        $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
        $stmt->bind_param("i", $p_id);
        $stmt->execute();
        $result = $stmt->get_result();
    }
}
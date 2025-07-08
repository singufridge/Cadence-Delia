#!/usr/bin/php-cgi
<?php
require_once 'dbh.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $p_id = $_GET['id'];
    $u_id = $_GET['uid'];

    $stmt = $conn->prepare("DELETE FROM wishlist WHERE product_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $p_id, $u_id);
    $stmt->execute();
    $result = $stmt->get_result();
}
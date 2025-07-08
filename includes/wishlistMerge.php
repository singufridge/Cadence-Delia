#!/usr/bin/php-cgi
<?php
session_start();
require_once 'dbh.php';

$data = json_decode(file_get_contents('php://input'), true);

$items = $data['localWishlist'];
//var_dump($items);

//$books = $_POST['books'];

foreach ($items as $item) {
	$p_id = $item['product_id'];
	$u_id = $_SESSION['uid'];

	$stmt = $conn->prepare("SELECT * FROM wishlist WHERE product_id = ? AND user_id = ?");
	$stmt->bind_param("ii", $p_id, $u_id);
	$stmt->execute();
	$result = $stmt->get_result();
	
	if ($result->num_rows == 0) {
		$stmt = $conn->prepare("INSERT INTO wishlist (product_id, user_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $p_id, $u_id);
        $stmt->execute();
	}
	
	$stmt->close();
}

$conn->close();
?>
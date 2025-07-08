#!/usr/bin/php-cgi
<?php
include 'includes/dbh.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wishlist</title>
    <?php include 'includes/header.php'; ?>
    <body>
        <div class="container text-center mb-5 pb-5">
            <h1>Wishlist</h1>
            <br><br>
    <?php
    if (isset($_SESSION['uid'])) {
        $uid = $_SESSION['uid'];

        $stmt = $conn->prepare("SELECT * FROM wishlist INNER JOIN products ON wishlist.product_id = products.product_id WHERE user_id = ?");
        $stmt->bind_param("i", $uid);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while($row = $result->fetch_assoc()) {
            echo "<div id='card".$row['product_id']."' class='card border-secondary mb-3 mx-auto' style='max-width: 35%;'>
                <div class='row g-0 align-items-center'>
                    <div class='col-md-4'>
                        <img src='".$row['image']."' class='img-fluid rounded-start'>
                    </div>
                    <div class='col-md-8'>
                        <div class='card-body'>
                            <h5 class='card-title'>".$row['product_name']."</h5>
                            <h5 class='card-text'>$".$row['price']."</h5>
                            <br>
                            <button type='button' class='btn btn-outline-danger' id='removeBtn-".$row['product_id']."'>Remove from Wishlist</button>
                        </div>
                    </div>
                </div>
            </div>";

            echo "<script>";
            echo "document.getElementById('removeBtn-".$row['product_id']."').addEventListener('click', function() {
                const xhr = new XMLHttpRequest();

                xhr.open('GET', 'includes/wishlistUpdate.php?id=".$row['product_id']."&uid=".$row['user_id']."', true);
                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 300) {
                    document.getElementById('card".$row['product_id']."').remove();
                    } else {
                    alert('An error occurred: ' + xhr.statusText);
                    }
                };
                
                xhr.send();
            });";
            echo "</script>";
        }
    } else {
        header('location: ../home.php');
    }
    echo "</div>";

    ?>
        </div>
        <?php include 'includes/footer.php'; ?>
    </body>
</html>
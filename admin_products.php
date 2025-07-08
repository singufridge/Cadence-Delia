#!/usr/bin/php-cgi
<?php
require_once 'includes/dbh.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administer Products</title>
    <?php 
    include 'includes/header.php'; 
    
    if (!isset($_SESSION['admin'])) {
      header('location: home.php');
    }
    ?>

    <div class="container text-center mb-5 pb-5">
        <h1>Administer Products</h1>
        <br>
        <div class="mx-auto p-2" style="width: 300px;">
            <form action="includes/products-config.php" method="post">
                <label for="product_name" class="form-label">Product Name:</label>
                <input type="text" class="form-control" id="product_name" name="product_name" required>
                <br>
                <label for="product_desc" class="form-label">Product Description:</label>
                <textarea class="form-control" id="product_desc" name="product_desc" required></textarea>
                <br>
                <label for="price" class="form-label">Price:</label>
                <div class="input-group mb-3">
                  <span class="input-group-text">$</span>
                  <input type="number" placeholder="0.00" min="0" step="0.01" class="form-control" id="price" name="price" aria-label="Amount (to the nearest dollar)" required>
                </div>
                <br>
                <button type="submit" class="btn btn-danger mb-3" name="submit">Register Product</button>
            </form>
            <?php
            if (isset($_GET['error'])) {
              echo "<br>
                    <p class=";
              if ($_GET['error'] == 'none') {
                echo "'text-success'>Product registration successful!";
              } else
              if ($_GET['error'] == 'exists') {
                echo "'text-danger'><b>Error:</b> that product already exists.";
              }
              echo "</p>";
            }
          ?>
          <br><hr><br>
          <?php
          $sql = "SELECT * FROM products ORDER BY product_id";
          $result = $conn->query($sql);

          echo "<table class='table'>
            <thead>
              <tr>
                <th>Product ID</th>
                <th>Product name</th>
                <th></th>
              </tr>
          </thead>";

          while($row = $result->fetch_assoc()) {
            echo "<tr id='row".$row['product_id']."'>";
            echo "<td>".$row['product_id']."</td>";
            echo "<td>".htmlspecialchars($row['product_name'])."</td>";
            echo "<td>
                  <button type='button' class='btn btn-outline-secondary' id='removeBtn-".$row['product_id']."'>
                    Remove
                  </button>
                  </td>";
            echo "</tr>";

            echo "<script>
            document.getElementById('removeBtn-".$row['product_id']."').addEventListener('click', 
            function() {
              const xhr = new XMLHttpRequest();
              xhr.open('GET', 'includes/products-config.php?product_id=".$row['product_id']."&delete=', true);
              
              xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                  document.getElementById('row".$row['product_id']."').remove();
                } else {
                  alert('An error occurred: ' + xhr.statusText);
                }
              };
              
              xhr.send();
            });
            </script>";
          }
          ?>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
  </body>
</html>
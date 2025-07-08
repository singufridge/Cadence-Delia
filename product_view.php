#!/usr/bin/php-cgi
<?php
include 'includes/dbh.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product View</title>
    <script src='script.js'></script>
    <?php include 'includes/header.php'; ?>

    <body>
      <div class="container text-center">
      <?php
      if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];
        
        $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
        $stmt->bind_param("s", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        if ($result->num_rows == 0) {
            //err
        } else {
            echo "<div class='container px-4 px-lg-5 mb-5 text-end'>
                    <div class='row gx-4 gx-lg-5 align-items-center'>
                        <div class='col-md-6'><img class='card-img-top mb-5 mb-md-0' src='".$row['image']."'/>
                    </div>
                    <div class='col-md-6'>
                      <h1 class='display-5 fw-bolder'>".$row['product_name']."</h1>
                      <br>
                      <div class='fs-5 mb-5'>
                        <h3 class='text-info'>$".$row['price']."</h3>
                      </div>
                      <p class='lead'>".$row['product_desc']."</p>
                      <button class='btn btn-outline-info mb-4' id='productBtn-".$row['product_id']."' type='button'>
                          Add to Wishlist
                      </button>
                      <br>";
            $stmt->close();

            $stmt = $conn->prepare("SELECT * FROM tags WHERE product_id = ?");
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
                      
            while($row = $result->fetch_assoc()) {
                echo "<span class='badge rounded-pill text-bg-secondary p-2 px-3 mx-1' >".$row['title']."</span>";
            } 
                echo "</div>
                    </div>
                  </div>";
        }
        
        $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
        $stmt->bind_param("s", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        echo "<script>";
        if ((isset($_SESSION['username']))) { //if logged in, set items to db
          echo "document.getElementById('productBtn-".$row['product_id']."').addEventListener('load', 
          function() {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'includes/buttonUpdate.php?id=".$row['product_id']."&uid=".$_SESSION['uid']."', true);
            
            xhr.onload = function() {
              if (xhr.status >= 200 && xhr.status < 300) {
                console.log('productBtn-".$row['product_id']." ' + xhr.responseText);
                document.getElementById('productBtn-".$row['product_id']."').innerText = xhr.responseText;
              } else {
                alert('An error occurred: ' + xhr.statusText);
              }
            };

            xhr.send();
          });
          
          document.getElementById('productBtn-".$row['product_id']."').addEventListener('click', 
          function() {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'includes/buttonUpdate.php?id=".$row['product_id']."&uid=".$_SESSION['uid']."&update=', true);
            
            xhr.onload = function() {
              if (xhr.status >= 200 && xhr.status < 300) {
                document.getElementById('productBtn-".$row['product_id']."').innerText = xhr.responseText;
              } else {
                alert('An error occurred: ' + xhr.statusText);
              }
            };
            
            xhr.send();
          })";
        } else { //if not logged in, set to localStorage
          echo "
          item".$row['product_id']." = [{
          product_id: ".$row['product_id'].",
          product_name: '".htmlspecialchars($row['product_name'])."',
          description: '".htmlspecialchars($row['product_desc'])."',
          price: ".$row['price'].",
          image: '".htmlspecialchars($row['image'])."'
          }];";
          //json object

          echo "document.getElementById('productBtn-".$row['product_id']."').onload = 
          buttonUpdate(document.getElementById('productBtn-".$row['product_id']."'), '".$row['product_id']."');";
          //on load, update button text in relation to localStorage status

          echo "document.getElementById('productBtn-".$row['product_id']."').addEventListener('click', 
          function() {
            if ('".$row['product_id']."' in localStorage) {
              window.localStorage.removeItem('".$row['product_id']."');
            } else {
              window.localStorage.setItem('".$row['product_id']."', JSON.stringify(item".$row['product_id']."));
            };
            buttonUpdate(document.getElementById('productBtn-".$row['product_id']."'), '".$row['product_id']."');
          })";
          //on click, toggle functionality of button based on localStorage status
        }
        echo "</script>";
      }
      ?>
      </div>
      <?php include 'includes/footer.php'; ?>
    </body>
</html>
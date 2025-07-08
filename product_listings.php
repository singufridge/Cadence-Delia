#!/usr/bin/php-cgi
<?php
require_once 'includes/dbh.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Assignment 4</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src='script.js'></script>
    <?php include 'includes/header.php'; ?>

    <div class="container text-center mb-5 pb-5">
      <h1><b>Bakery</b></h1>
      <br>
      <div class="dropdown">
        <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          Filter by Tags
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="product_listings.php"><b>All</b></a></li>
          <li><a class="dropdown-item" href="product_listings.php?tag=crunchy">Crunchy</a></li>
          <li><a class="dropdown-item" href="product_listings.php?tag=warm">Warm</a></li>
          <li><a class="dropdown-item" href="product_listings.php?tag=moist">Moist</a></li>
          <li><a class="dropdown-item" href="product_listings.php?tag=fluffy">Fluffy</a></li>
          <li><a class="dropdown-item" href="product_listings.php?tag=buttery">Buttery</a></li>
          <li><a class="dropdown-item" href="product_listings.php?tag=chocolatey">Chocolatey</a></li>
          <li><a class="dropdown-item" href="product_listings.php?tag=fruity">Fruity</a></li>
        </ul>
      </div>
    <br><br>
<?php
  if (!isset($_GET['tag'])) {
    $sql = "SELECT * FROM products ORDER BY product_name";
    $result = $conn->query($sql);
  } else {
    $tag = $_GET['tag'];

    $stmt = $conn->prepare($stmt = "SELECT * FROM products INNER JOIN tags ON products.product_id = tags.product_id WHERE tags.title = ? ORDER BY product_name");
    $stmt->bind_param("s", $tag);
    $stmt->execute();
    $result = $stmt->get_result();
  }

  while($row = $result->fetch_assoc()) {
      echo "<div class='card mb-3 mx-auto' style='max-width: 60%'>
        <div class='row g-0 align-items-center'>
          <div class='col-md-4'>
            <img src='".htmlspecialchars($row['image'])."' class='card-img-top'>
          </div>
          <div class='col-md-8'>
            <div class='card-body'>
              <h5 class='card-title'>".htmlspecialchars($row['product_name'])."</h5>
              <p class='card-text'>".htmlspecialchars($row['product_desc'])."</p>
              <p class='card-text'><small class='text-body-secondary'>$".($row['price'])."</small></p>
              <button type='button' class='btn btn-outline-info' id='productBtn-".$row['product_id']."'>
                  Add to Wishlist
              </button>
              <br><br>
              <button type='button' class='btn btn-secondary'>
                <a style='text-decoration: none; color: white;' 
                  href='product_view.php?product_id=".$row['product_id']."'>
                  View Product
                </a>
              </button>
            </div>
          </div>
        </div>
      </div>";

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
        description: '" . htmlspecialchars($row['product_desc']) . "',
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
      
  $conn->close();
  ?>
    </div>
    <?php include 'includes/footer.php'; ?>
  </body>
</html>
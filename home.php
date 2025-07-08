#!/usr/bin/php-cgi
<!DOCTYPE html>
<!--
Cadence Delia
jl23th
7876683
-->
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Assignment 4</title>
    <?php include 'includes/header.php'; ?>

    <div class="container text-center">
      <h1><b>Assignment 4</b></h1>
      <?php
      if (isset($_SESSION['username'])) {
        echo "<h3>";
        echo "Welcome, " . $_SESSION['username'] . "!";
        echo "</h3>";
      } 
      
      if (isset($_SESSION['admin'])) {
        echo "<p>";
        echo "You have admin privelleges.";
        echo "</p>";

        echo "<br><br>";

        echo "<div class='d-grid gap-3'>";
        echo "<form action='admin_users.php' method='post'>
                <button type='submit' class='btn btn-info'>
                  Administer Users
                </button>
              </form>";
        echo "<form action='admin_products.php'>
                <button type='submit' class='btn btn-danger'>
                  Administer Products
                </button>
              </form>";
        echo "</div>";
      }
      ?>
    </div>
    <?php
      if (isset($_GET['sync'])) {
        echo "<script>
        let localWishlist = [];
        
        window.onload = function() {
          for (i = 0; i < localStorage.length; i++) {
            if (localStorage.key(i) != 'debug') {
              let JSONprod = JSON.parse(localStorage.getItem(localStorage.key(i)));
              localWishlist = localWishlist.concat(JSONprod);
            }
          }
          console.log(JSON.stringify({ localWishlist }));

          const xhr = new XMLHttpRequest();
          
          xhr.open('POST', 'includes/wishlistMerge.php', true);
          xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
          
          xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
              console.log(xhr.responseText);
            } else {
              console.log('Error:', xhr.statusText);
            }
          };
          
          xhr.send(JSON.stringify({ localWishlist }));

          localWishlist = [];
        }";
      }
      ?>  
    </script>
    <?php include 'includes/footer.php'; ?>
  </body>
</html>
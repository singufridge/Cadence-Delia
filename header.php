<?php
  session_start();
?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
      body {
        padding-top: 5%;
      }
    </style>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg fixed-top bg-body-tertiary bg-dark border-bottom border-body" data-bs-theme="dark">
      <div class="container">
        <a class="navbar-brand" href="home.php"><b>COSC 2P89</b></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-link" href="home.php">Home</a>
            <a class="nav-link" href="product_listings.php">Item Listings</a>
            <?php
            if (!isset($_SESSION['uid'])) {
              echo "<a class='nav-link' href='wishlist.php'>Wishlist</a>";
            } else {
              echo "<a class='nav-link' href='wishlist_server.php'>Wishlist</a>";
            }
            ?>
            <?php
            if (!isset($_SESSION['uid'])) {
              echo "<a class='nav-link' href='signup.php'><b>SIGN UP</b></a>";
              echo "<a class='nav-link' href='login.php'><b>LOG IN</b></a>";
            } else {
              echo "<a class='nav-link' href='includes/logout-config.php'><b>LOG OUT</b></a>";
            }
            ?>
          </div>
        </div>
      </div>
    </nav>
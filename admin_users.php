#!/usr/bin/php-cgi
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administer Users</title>
    <?php
    include 'includes/header.php';
    
    if (!isset($_SESSION['admin'])) {
      header('location: home.php');
    }
    ?>

    <div class="container text-center">
      <h1>Administer Users</h1>
        <br>
        <div class="mx-auto p-2" style="width: 300px;">
            <form action="includes/users-config.php" method="post">
                <label for="user" class="form-label">Username:</label>
                <input type="user" class="form-control" id="user" name="user" required>
                <br>
                <label for="pwd" class="form-label">Password:</label>
                <input type="password" class="form-control" id="pwd" name="pwd" required>
                <br>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="adminCheck" id="flexCheckDefault" name="adminCheck">
                  <label class="form-check-label" for="adminCheck">Make User Admin?</label>
                </div>
                <br>
                <button type="submit" class="btn btn-info mb-3" name="submit">Submit</button>
            </form>
          <?php
            if (isset($_GET['error'])) {
              echo "<br>
                    <p class=";
              if ($_GET['error'] == 'none') {
                echo "'text-success'> User administration successful.";
              } else
              if ($_GET['error'] == 'usertaken') {
                echo "'text-danger'><b>Error:</b> that username already exists.";
              }
              echo "</p>";
            }
          ?>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
  </body>
</html>
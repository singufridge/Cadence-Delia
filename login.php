#!/usr/bin/php-cgi
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log In</title>
    <?php include 'includes/header.php'; ?>

    <div class="container text-center">
        <h1>Log In</h1>
        <br>
        <div class="mx-auto p-2" style="width: 300px;">
            <form action="includes/login-config.php" method="post">
                <label for="user" class="form-label">Username:</label>
                <input type="user" class="form-control" id="user" name="user" required>
                <br>
                <label for="pwd" class="form-label">Password:</label>
                <input type="password" class="form-control" id="pwd" name="pwd" required>
                <br>
                <button type="submit" class="btn btn-primary mb-3" name="submit">Submit</button>
            </form>
          <?php
            if (isset($_GET['error'])) {
              echo "<br>
                    <p class=";
              if ($_GET['error'] == 'usernull') {
                echo "'text-danger'> Error: username does not exist.";
              }
              if ($_GET['error'] == 'wrongpwd') {
                echo "'text-danger'> Error: password does not match.";
              }
            }
          ?>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
  </body>
</html>
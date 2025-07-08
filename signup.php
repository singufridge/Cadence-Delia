#!/usr/bin/php-cgi
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up</title>
    <?php include 'includes/header.php'; ?>

    <div class="container text-center">
        <h1>Sign Up</h1>
        <br>
        <div class="mx-auto p-2" style="width: 300px;">
            <form action="includes/signup-config.php" method="post">
                <label for="user" class="form-label">Username:</label>
                <input type="user" class="form-control" id="user" name="user" required>
                <br>
                <label for="pwd" class="form-label">Password:</label>
                <input type="password" class="form-control" id="pwd" name="pwd" required>
                <br>
                <button type="submit" class="btn btn-info mb-3" name="submit">Submit</button>
            </form>
          <?php
            if (isset($_GET['error'])) {
              echo "<br>
                    <p class=";
              if ($_GET['error'] == 'none') {
                echo "'text-success'> Sign up successful! You may now log in.";
              } else
              if ($_GET['error'] == 'usertaken') {
                echo "'text-danger'><b>Error:</b> that username is taken.";
              }
              echo "</p>";
            }
          ?>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
  </body>
</html>
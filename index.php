<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel = "stylesheet" type = "text/css" href="css/login.css">
  </head>
  <body>
    <div class = "logInForm">
    <form action = "login.php" method="post">

      <?php
        if(isset($_GET['error'])){
      ?>
          <p class = "error"><?php echo $_GET['error']; ?> </p>

      <?php
    }
      ?>

      <label>Username</label>
      <input type = "text" name = "uname" placeholder="Username">
      <br>

      <label>Password</label>
      <input type = "password" name = "password" placeholder="Password">
      <br>

      <button type = "submit">Login</button>

    </form>
  </div>

  </body>
</html>

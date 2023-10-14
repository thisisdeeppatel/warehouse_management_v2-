<?php
  require_once('loginclass.php');

  $login = new login();

  $login->validateLoggedIn();

  if(isset($_REQUEST['u']) && $_REQUEST['u'] != "" && $_REQUEST['p'] != "" )
  {
      $u = $_REQUEST["u"];
      $p = $_REQUEST["p"];

      if($login->createUser("$u", "$p") == 1)
      {
          echo "<div class='alert alert-sucess text-center'><h2>" . "USER CREATED". "</h2></div>";
      }
      else if($login->createUser("$u", "$p") == 2)
      {
          echo "<div class='alert alert-warning text-center'><h2>" . "Invaid Username and password length". "</h2></div>";
      }
      else
      {
          echo "<div class='alert alert-warning text-center'><h2>" . "USER ALREADY EXIST". "</h2></div>";
      }
  }
?>


<!DOCTYPE html>
<html>
<head>
  
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create User</title>

  <link rel="stylesheet" href="static/css/bootstrap.min.css">
</head>

<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="text-center">Create New User</h3>
          </div>
          <div class="card-body">

            <form action="createuser.php" method="post">

              <div class="form-group mt-4">
                <label for="username">New Username</label>
                <input type="text" class="form-control" name="u" minlength="5" required>
              </div>
              <div class="form-group mt-4">
                <label for="password">New Password</label>
                <input type="password" class="form-control" name="p" minlength="6" required>
              </div>
              <button type="submit" class="btn btn-primary mt-4">Create User</button>
              <a class="btn btn-primary mt-4 ms-4"  href="index.php">GO BACK</a>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
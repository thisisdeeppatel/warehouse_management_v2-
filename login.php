<?php

require_once('loginclass.php');

$login = new login();

// check if logout request
if(isset($_REQUEST['logout']))
{
    $login->doLogout();
}

// check if already loggged in
$login->redirectHomeIfLoggedin();


// handel post method for login
if(isset($_REQUEST['u']) && isset($_REQUEST['p']))
{
    $u = $_REQUEST["u"];
    $p = $_REQUEST["p"];
    $login->doLogin($u , $p);
}


// Show Errors.
if(isset($_REQUEST['msg']))
{
    echo "<div class='alert alert-warning text-center'><h2>" . $_REQUEST['msg'] . "</h2></div>";
}
?>

<!DOCTYPE html>
<html>
<head>
  
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>

  <link rel="stylesheet" href="static/css/bootstrap.min.css">
</head>

<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="text-center">Login</h3>
          </div>
          <div class="card-body">
            <form action="login.php" method="post">
              <div class="form-group mt-4">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="u" required>
              </div>
              <div class="form-group mt-4">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="p" required>
              </div>
              <button type="submit" class="btn btn-primary mt-4">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

<?php
require_once 'loginclass.php';

$login = new login();

$login->validateLoggedIn();
?>

<?php

require_once 'database.php';

$id = mysqli_real_escape_string($connection , htmlspecialchars($_GET['id']));

$qry = mysqli_query($connection , "DELETE FROM items WHERE id=$id");

header("Location: index.php?msg=delsuccess");
?>
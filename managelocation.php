<?php
    require_once 'loginclass.php';

    $login = new login();

    $login->validateLoggedIn();
?>
<?php
    require_once 'database.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["address"]))
    {
        $name = mysqli_real_escape_string($connection, htmlspecialchars($_POST["address"]));

        $qry = "INSERT INTO location(address) VALUES ('$name')";
        
        mysqli_query($connection,$qry);
        header("Location: index.php?msg=locsuccess");
    }

    $locations = mysqli_query($connection , "SELECT * FROM location");
    ?>

    
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Locations</title>

    <link rel="stylesheet" href="static/css/bootstrap.min.css">
    <link rel="stylesheet" href="static/css/jquery.dataTables.css">

    <script type="text/javascript" src="static/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="static/js/jquery-3.6.4.min.js"></script>
    <script src="static/js/jquery.dataTables.js"></script>


    <script>
        $(document).ready(function()
        {
            $("#tbl").DataTable({
                responsive : true
            });
        });
    </script>
    <style>
      #tbl tr:nth-child(even)
      {
      
       height: 10px ;
       background-color: aliceblue;
      }
    </style>


</head>
<body class="container-fluid">

<form class="w-50 border p-4" method="post" action="managelocation.php">
    <h1 class="">Add Location</h1>
    <dl>
        <dt>Input Location Adress</dt>
        <dd><input class="form-control" type="text" name="address" autofocus required /></dd>

    </dl>
    <input type="submit" class="btn btn-primary" accesskey="a" value="ADD LOCATION" />
    <a href="index.php" class="btn btn-danger ms-2" accesskey="b" >RETURN BACK</a>
    
</form>


<hr class="mt-2"/>
<h1 class="mt-2">Available Locations</h1>

<table id="tbl" class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Address</th>
            <th>Total Items</th>
        </tr>
    </thead>
<tbody>

<?php 
    foreach($locations as $location)
    {
        $id = $location["id"];
        $num_items = mysqli_query($connection , "SELECT * FROM items WHERE location = '$id'" );
        $count = mysqli_num_rows($num_items);

        echo "<tr>";
        echo "<td>" . $location["id"] . "</td>";
        echo "<td>" . $location["address"] . "</td>";
        echo "<td>" . $count . "</td>";
        echo "</tr>";
    }
    ?>
</tbody>
</table>


</body>
</html>
<?php
    require_once 'database.php';
    $locations = mysqli_query($connection , "SELECT * FROM location");
?>

<?php
    require_once 'loginclass.php';

    $login = new login();

    $login->validateLoggedIn();
?>


<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["name"]))
{
    
    $name = mysqli_real_escape_string($connection, htmlspecialchars($_POST["name"]));
    $price =  mysqli_real_escape_string($connection,htmlspecialchars($_POST["price"]));
    $location =  mysqli_real_escape_string($connection, htmlspecialchars($_POST["location"]));
    $stock=  mysqli_real_escape_string($connection, htmlspecialchars($_POST["stock"]));

    $qry = "INSERT INTO items(name , price,stock,location) VALUES('$name', '$price' , '$stock' , '$location')";
    mysqli_query($connection , $qry );
    header("Location: index.php?msg=itemsuccess");
}
?>


   
    <form class="border p-4" action="additem-ajax.php" method="post">
    
        <dl>
            <dt>Item Name</dt>
            <dd><input class="form-control" type="text" name="name" required autofocus size="40"/></dd>

            <dt>Item Price</dt>
            <dd><input class="form-control" type="number" name="price" required autofocus size="40"/></dd>

            <dt>Item Stock</dt>
            <dd><input class="form-control" type="number" name="stock" value="9999" required autofocus size="40"/></dd>

            <dt>Item location</dt>
            <dd><select class="form-control" name="location">
                    <?php
                        foreach ($locations as $locationA)
                        {
                            echo "<option value=\"" . $locationA['id'] . "\">" . $locationA['address'] . "</option>";
                        }
                    ?>
                </select>
            </dd>
        </dl>
<input type="submit" accesskey="a" class="btn btn-success" value="ADD ITEM">
<a href="index.php" accesskey="b" class="btn btn-danger ms-2">RETURN BACK</a>
    </form>




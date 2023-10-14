<?php

require_once 'database.php';
?>

<?php
require_once 'loginclass.php';

$login = new login();

$login->validateLoggedIn();
?>

<?php


$item = [];
$locations = mysqli_query($connection , "SELECT * FROM location");



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["name"]))
    {
    $id = mysqli_real_escape_string($connection, htmlspecialchars($_POST["id"]));

    $name = mysqli_real_escape_string($connection, htmlspecialchars($_POST["name"]));
    $price = mysqli_real_escape_string($connection, htmlspecialchars($_POST["price"]));
    $location = mysqli_real_escape_string($connection, htmlspecialchars($_POST["location"]));
    $stock = mysqli_real_escape_string($connection, htmlspecialchars($_POST["stock"]));

    $qry = "UPDATE items set name='$name', price=$price, location=$location , stock=$stock where id=$id";

    mysqli_query($connection,$qry);

    header("Location: index.php?msg=editsuccess");
    
    }

  else

  {
    if(!isset($_GET['id']))
    {
      die("Direct access not allowed");
    }
    $id = mysqli_real_escape_string($connection, htmlspecialchars($_GET["id"]));
    $qry = "SELECT * FROM items where id=$id";

    $result=mysqli_query($connection,$qry);
    foreach ($result as $itm)
    {
      $item[] = $itm;
    }
  }
  
?>

    <script>
      function del()
      {
          var c = confirm("ARE YOU SURE");

          if(c == true)
          {
            
            var id=<?php echo $item[0]['id'] ;?>;
            window.document.location = "delete.php?id=" + id;
          }
      }
    </script>




<form action="edititem-ajax.php" method=post class="p-4 border" >

      <dl>
        <dt>ID</dt>
        <dd><input class="form-control" size="70" type="text" name="_id" id="_id" value="<?php echo $item[0]['id'] ;  ?>" disabled></dd>

        <dt>Name</dt>
        <dd><input class="form-control" size="70" type="text" name="name" id="name" value="<?php echo $item[0]['name'] ; ?>" autofocus></dd>

        <dt>Price</dt>
        <dd><input class="form-control" size="70" type="text" name="price" id="price" value="<?php echo $item[0]['price'] ; ?>"></dd>

        <dt>Item location</dt>
            <dd><select class="form-control" name="location">
                    <?php
                      // Dynamically Select specific option in select tag
                        foreach ($locations as $locationA)
                        {
                            echo "<option ";


                            if($locationA['id'] == $item[0]['location']) {echo " selected ";}
                            
                            echo "value=\"" . $locationA['id'] . "\">" . $locationA['address'] . "</option>";

                        }
                    ?>
                </select>
       </dd>
                    <input type="hidden" name="id" name="id" value="<?php echo $item[0]['id'] ; ?>">
        <dt>Stock</dt>
        <dd><input class="form-control" type="text" name="stock" id="stock" value="<?php echo $item[0]['stock'] ; ?>"></dd>
   
      </dl>
    
      <button type="submit" class="btn btn-primary">SAVE &amp; RETURN</button>
      
      </form>
      <button class="btn btn-danger ms-4 mt-2" onclick="del();">DELETE</button>
<?php

require_once 'database.php';

require_once 'loginclass.php';

$login = new login();

$login->validateLoggedIn();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deep's Wherehose Manager</title>
    <link rel="stylesheet" href="static/css/bootstrap.min.css">
    <link rel="stylesheet" href="static/css/jquery.dataTables.css">
    <style>
      #dt tr:nth-child(even)
      {
      
       height: 10px ;
       background-color: aliceblue;
      }
    </style>

    <script type="text/javascript" src="static/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="static/js/jquery-3.6.4.min.js"></script>
    <script src="static/js/jquery.dataTables.js"></script>

        <script>
          // Show Loading screen untill full page renders. 
            $(document).ready(function()
            {
                $("#dt").DataTable();

                $("#loading").css("display" , "none");
                $("#main").css("display" , "block");

                $("#msg").delay(1000).fadeOut();


                //for edit item modal
                $(".showmodal").click(function()
                {
                  var data_id = $(this).data("id");
                  //alert(data);

                  
                  $.ajax({
                    url: 'edititem-ajax.php?id='+data_id, 
                    method: 'GET',
                    dataType: 'html',
                    success: function(data) {
                        // main logic here
                        $(".modal-body").html(data);
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                  });
                  $("#editmodal").modal("show");
                });


                // for add item modal
                $("#addbtn").click(function()
                {
                  $.ajax({
                    url: 'additem-ajax.php', 
                    method: 'GET',
                    dataType: 'html',
                    success: function(data) {
                        // main logic here
                        $(".modal-body2").html(data);
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                  });
                  $("#addmodal").modal("show");
                });
                });
            
            </script>
    
</head>
<body>
<div id="loading" class="text-center">
 <h1 class="mt-4"> Loading Dashboard...</h1>
 <br>
 <b> Slow Internet or Large Number of Items.</b> 
</div>
<div id="main" class="container-fluid p-4" style="display: none;">

    <a class="btn btn-primary btn-sm mb-2" accesskey="i" id="addbtn">ADD ITEM</a>
    <a class="btn btn-primary btn-sm ms-2 mb-2" accesskey="l" href="managelocation.php">MANAGE LOCATION</a>
    <a class="btn btn-primary btn-sm ms-2 mb-2" accesskey="l" href="createuser.php">CREATE USER</a>


    
    <a class="btn btn-danger btn-sm ms-2 mb-2" accesskey="l" href="login.php?logout=1">LOGOUT ( <?php echo $_SESSION['username'];?> )</a>
    
   
    <?php
    if (isset($_GET['msg']))
    {
      if($_GET['msg'] == "itemsuccess")
      echo "<div id='msg' class='alert alert-success'> ITEM ADDED SUCCESSFUL</div>";
      if($_GET['msg'] == "locsuccess")
      echo "<div id='msg' class='alert alert-success'> LOCATION ADDED SUCCESSFUL</div>";
      if($_GET['msg'] == "editsuccess")
      echo "<div id='msg' class='alert alert-success'> ITEM EDITED SUCCESSFUL</div>";
      if($_GET['msg'] == "delsuccess")
      echo "<div id='msg' class='alert alert-danger'> ITEM DELETED SUCCESSFUL</div>";
    }
        
    ?>
    <hr width=100%>
    <h2 class="">Available Items</h2>

    <!-- jquery datatable -->
    <table id="dt" class="table table-responsive table-spripped mt-1 border">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Location</th>
            <th>stock</th>
            <th>Action</th>
        </tr>
        </thead>
      <tbody>
        <?php $items = mysqli_query($connection , "SELECT items.name,items.id,items.price,location.address,items.stock FROM items INNER JOIN location ON items.location = location.id ORDER BY name asc");
       
            foreach ($items as $item)
            {
                echo '<tr>';
                echo '<td>' . $item['id'] . "</td>";
                echo '<td>' . $item['name'] . "</td>";
                echo '<td>' . $item['price'] . "</td>";
                echo '<td>' . $item['address'] . "</td>";
                echo '<td>' . $item['stock'] . "</td>";
                //edititem.php?id=$item["id"]
                echo "<td> <button type=button class='btn btn-primary showmodal' data-id=" .$item['id']. "> EDIT </button></td>";
                echo '</tr>';
            }

          ?>
      </tbody>

    </table>
</div>


<!-- modal for edit item -->
<div class="modal fade" id="editmodal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title">Edit Item</h2>
      </div>
      <div class="modal-body">
      
      </div>
      <div class="modal-footer">
      <button type="button" class='btn btn-primary' data-bs-dismiss="modal">CLOSE</button>
      </div>
    </div>
  </div>
</div>


<!-- modal for add item -->
<div class="modal fade" id="addmodal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title">Add New Item</h2>
      </div>
      <div class="modal-body modal-body2">
      
      </div>
      <div class="modal-footer">
      <button type="button" class='btn btn-primary' data-bs-dismiss="modal">CLOSE</button>
      </div>
    </div>
  </div>
</div>

</body>
</html>
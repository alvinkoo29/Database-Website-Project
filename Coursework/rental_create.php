<?php
include_once "dbconnection.php";
include_once "template/header.php";

// logic after submit the form
if(isset($_POST['submit'])) {
  $inventory_id = trim($_POST['inventory']);
  $customer_id = trim($_POST['customer']);

  $insertRentalSQL = "INSERT INTO rental (rental_date, inventory_id, customer_id, return_date, staff_id, last_update)
                      VALUES (NOW(), '{$inventory_id}', '{$customer_id}', NULL, '1', NOW())";
  if(!$connection->query($insertRentalSQL)) {
      printf("Error insert rental: %s\n", $connection->error);
  }
  $getRentalID = $connection->query("SELECT rental_id FROM rental ORDER BY rental_id DESC")->fetch_array();
  if(!$connection->query($getRentalID)) {
    printf("Error get rental: %s\n", $connection->error);
  }
  $getFilm = $connection->query("SELECT film_id FROM inventory WHERE inventory_id = '{$inventory_id}'")->fetch_array();
  if(!$connection->query($getFilm)) {
    printf("Error get film: %s\n", $connection->error);
  }
  $filmDetail = $connection->query("SELECT rental_rate FROM film WHERE film_id = '{$getFilm['film_id']}'")->fetch_array();
  if(!$connection->query($filmDetail)) {
    printf("Error film detail: %s\n", $connection->error);
  }

  $insertPaymentSQL = "INSERT INTO payment (customer_id, rental_id, amount, last_update) VALUES ('{$customer_id}', '{$getRentalID['rental_id']}', '{$filmDetail['rental_rate']}', NOW())";
  if(!$connection->query($insertPaymentSQL)) {
    printf("Error insert payment: %s\n", $connection->error);
  } else {
    echo "<script type=\"text/javascript\">
    alert('Data saved.');
    window.location = 'rental_index.php';
    </script>";
}
}
?>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

  <?php include_once "template/sidebar.php"; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      <?php include_once "template/topbar.php"; ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Add Rental Record</h1>
            </div>
          <!-- User Form -->
          <form id="addRental" name="addRental" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="form-group">
              <label for="inventory">Inventory</label>
              <select class="form-control" id="inventory" name="inventory">
            <?php
              $inventorySQL = "SELECT * FROM inventory INNER JOIN film on inventory.film_id = film.film_id";
              $inventoryResult = $connection->query($inventorySQL);
              while($inventoryRow = $inventoryResult->fetch_array()){
                echo "<option value='{$inventoryRow['inventory_id']}'>{$inventoryRow['title']} at store {$inventoryRow['store_id']}</value>";
              }
            ?>
              </select>
            </div>
            <div class="form-group">
              <label for="customer">Customer</label>
              <select class="form-control" id="customer" name="customer">
            <?php
              $customerSQL = "SELECT * FROM customer WHERE active = '1'";
              $customerResult = $connection->query($customerSQL);
              while($customerRow = $customerResult->fetch_array()){
                echo "<option value='{$customerRow['customer_id']}'>{$customerRow['first_name']} {$inventoryRow['last_name']}</value>";
              }
            ?>
              </select>
            </div>
            <div class="form-group row">
            <div class="col-sm-10" align="center">
              <input type="submit" name="submit" class="btn btn-primary" value="Submit">
              <input type="reset" name="reset" class="btn btn-primary" value="Reset">
              <input type="reset" name="cancel" class="btn btn-primary" value="Cancel" onClick="window.history.back();">
            </div>
          </div>
          </form>
           <!-- End of User Form -->
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

<?php
include_once "template/footer.php"; ?>

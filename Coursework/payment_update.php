<?php
include_once "dbconnection.php";
include_once "template/header.php";

// logic after submit the form
if(isset($_POST['submit'])) {
  $paymentID = trim($_POST['paymentID']);
  $customer = trim($_POST['customer']);
  $rentalID = trim($_POST['rentalID']);

  $sql = "UPDATE payment SET customer_id = '{$customer}', payment_date = NOW(), staff_id = '1', last_update = NOW() WHERE payment_id = '{$paymentID}'";

  if(!$connection->query($sql)) {
    printf("Error: %s\n", $connection->error);
  }

  $sql2 = "UPDATE rental SET return_date = NOW(), last_update = NOW() WHERE rental_id = '{$rentalID}'";

  if(!$connection->query($sql2)) {
    printf("Error: %s\n", $connection->error);
  } else {
    echo "<script type=\"text/javascript\">
    alert('Paid.');
    window.location = 'payment_index.php';
    </script>";
  }
}

// load the user ID info. Fill to the form
if(isset($_GET['id']) && $_GET['id'] !== "") {
  $sql = "SELECT *
          FROM payment
          INNER JOIN customer ON payment.customer_id = customer.customer_id
          WHERE payment.payment_date IS NULL
          AND payment_id = '{$_GET['id']}'";
  $result = $connection->query($sql);

    if ($result->num_rows > 0) {
      $row = $result->fetch_array();
    } else {
      echo "<script type=\"text/javascript\">alert('No record found'); window.history.back(); </script>";
    }
  } else {
    echo "<script type=\"text/javascript\">alert('Invalid action'); window.history.back(); </script>";
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
            <h1 class="h3 mb-0 text-gray-800">Make payment for rental ID: <?php echo $row['rental_id']; ?></h1>
            </div>
          <!-- Payment Form -->
          <form id="addUser" name="addUser" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="form-group">
            <label for="paymentID">Payment ID</label>
            <input type="text" class="form-control" value="<?php echo $row['payment_id']; ?>" disabled>
            <input type="hidden" id="paymentID" name="paymentID" value="<?php echo $row['payment_id']; ?>">
            <input type="hidden" id="rentalID" name="rentalID" value="<?php echo $row['rental_id']; ?>">
            </div>
            <div class="form-group">
            <label for="amount">Amount to Paid</label>
            <input type="text" class="form-control" id="amount" name="amount" value="<?php echo $row['amount']; ?>" disabled>
            </div>
            <div class="form-group">
              <label for="customer">Customer</label>
              <select class="form-control" id="customer" name="customer">
                <option value=""> </option>
                <?php
                $customerResult = $connection->query("SELECT customer_id, first_name, last_name FROM customer");
                while($customer = $customerResult->fetch_array()){
                  echo "<option value='{$customer['customer_id']}'>{$customer['first_name']} {$customer['last_name']}</option>";
                }
                ?>
              </select>
            </div>
            <div class="form-group row">
            <div class="col-sm-10" align="center">
              <input type="submit" name="submit" class="btn btn-primary" value="Paid">
              <input type="reset" name="reset" class="btn btn-primary" value="Reset">
              <input type="reset" name="cancel" class="btn btn-primary" value="Cancel" onClick="window.history.back();">
            </div>
          </div>
          </form>
           <!-- End of Payment Form -->
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

<?php
include_once "template/footer.php"; ?>

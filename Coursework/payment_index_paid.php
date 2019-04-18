<?php
include_once "dbconnection.php";
include_once "template/header.php";
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
            <h1 class="h3 mb-0 text-gray-800">Payment Management</h1>
            </div>
          <!-- Content DataTable -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Paid Payment Records</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Customer ID</th>
                      <th>Staff ID</th>
                      <th>Rental ID</th>
                      <th>Amount</th>
                      <th>Payment Date</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>Customer ID</th>
                      <th>Staff ID</th>
                      <th>Rental ID</th>
                      <th>Amount</th>
                      <th>Payment Date</th>
                    </tr>
                  </tfoot>
                  <tbody>
                  <?php
                  $sql = "SELECT *
                          FROM payment
                          INNER JOIN customer ON payment.customer_id = customer.customer_id
                          WHERE payment.payment_date IS NOT NULL
                          ORDER BY payment_id DESC";
                  if ($result = $connection->query($sql)) {
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_array())
                        {
                            echo "<tr>";
                            echo "<td>".$row['payment_id']."</td>";
                            echo "<td>".$row['first_name']." ".$row['first_name']."</td>";
                            echo "<td>".$row['staff_id']."</td>";
                            echo "<td>".$row['rental_id']."</td>";
                            echo "<td>".$row['amount']."</td>";
                            echo "<td>".$row['payment_date']."</td>";
                            echo "</tr>";
                        }
                        $result->free();
                    }
                  }
                  ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

<?php
include_once "template/footer.php"; ?>

<?php
include_once "dbconnection.php";
include_once "template/header.php";

// get delete
if(isset($_GET['delete']) && $_GET['delete'] !== "") {
  $deleteID = trim($_GET['delete']);
  $sql = "DELETE FROM rental WHERE rental_id = '{$deleteID}';";

  if(!$connection->query($sql)) {
    printf("Error: %s\n", $connection->error);
  } else {
    echo "<script type=\"text/javascript\">
    alert('ID = ".$deleteID;
    echo " . Data deleted.'); window.location = 'rental_index.php';
    </script>";
  }
}
// get return
if(isset($_GET['return']) && $_GET['return'] !== "") {
  $return = trim($_GET['return']);
  $sql = "UPDATE rental SET return_date = NOW() WHERE rental_id = '{$return}';";

  if(!$connection->query($sql)) {
    printf("Error: %s\n", $connection->error);
  } else {
    echo "<script type=\"text/javascript\">
    alert('ID = ".$return;
    echo " . Record returned!'); window.location = 'rental_index.php';
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
            <h1 class="h3 mb-0 text-gray-800">Rental Management</h1>
            <a href="rental_create.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Add rental record </a>
            </div>
          <!-- Content DataTable -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Rental List</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Rental Date</th>
                      <th>Inventory ID</th>
                      <th>Customer NAME</th>
                      <th>Return Date</th>
                      <th>Staff ID</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>Rental Date</th>
                      <th>Inventory ID</th>
                      <th>Customer NAME</th>
                      <th>Return Date</th>
                      <th>Staff ID</th>
                      <th>Actions</th>
                    </tr>
                  </tfoot>
                  <tbody>
                  <?php
                  $sql = "SELECT *
                          FROM rental
                          INNER JOIN customer ON rental.customer_id = customer.customer_id
                          WHERE return_date IS NULL
                          ORDER BY rental_id DESC";
                  if ($result = $connection->query($sql)) {
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_array())
                        {
                            echo "<tr>";
                            echo "<td>".$row['rental_id']."</td>";
                            echo "<td>".$row['rental_date']."</td>";
                            echo "<td>".$row['inventory_id']."</td>";
                            echo "<td>".$row['first_name']." ".$row['last_name']."</td>";
                            echo "<td>".$row['return_date']."</td>";
                            echo "<td>".$row['staff_id']."</td>";
                            if($row['return_date'] === NULL) {
                              echo "<td><a href='rental_index.php?return={$row['rental_id']}' class='d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm'>Return </a> <a href='rental_index.php?delete={$row['rental_id']}' class='d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm'>Delete </a></td>";
                            } else {
                              echo "<td>&nbsp;</td>";
                            }
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

<?php
include_once "dbconnection.php";
include_once "template/header.php";

// get delete
if(isset($_GET['delete']) && $_GET['delete'] !== "") {
  $deleteID = trim($_GET['delete']);
  $sql = "DELETE FROM customer WHERE customer_id = '{$deleteID}';";

  if(!$connection->query($sql)) {
    printf("Error: %s\n", $connection->error);
  } else {
    echo "<script type=\"text/javascript\">
    alert('ID = ".$deleteID;
    echo " . Data deleted.'); window.location = 'customers_index.php';
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
            <h1 class="h3 mb-0 text-gray-800">Customers Management</h1>
            <a href="customers_create.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Add customer record </a>
            </div>
          <!-- Content DataTable -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Customer List</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Store ID</th>
                      <th>Name</th>
                      <th>Address</th>
                      <th>email</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  $sql = "SELECT * FROM customer";
                  if ($result = $connection->query($sql)) {
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_array())
                        {
                            echo "<tr>";
                            echo "<td>".$row['customer_id']."</td>";
                            echo "<td>".$row['store_id']."</td>";
                            echo "<td>".$row['first_name']." ".$row['last_name']."</td>";
                            $addressSQL = "SELECT *
                                           FROM address
                                           WHERE address_id = '{$row[address_id]}'";
                            $addressRow = $connection->query($addressSQL)->fetch_array();
                            echo "<td>".$addressRow['address']."</td>";
                            echo "<td>".$row['email']."</td>";
                            echo "<td>".($row['active'] == "1" ? "active" : "inactive")."</td>";
                            echo "<td><a href='customers_update.php?id={$row['customer_id']}' class='d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm'>Edit </a> . <a href='customers_index.php?delete={$row['customer_id']}' class='d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm'>Delete </a></td>";
                            echo "</tr>";
                        }
                        $result->free();
                    }
                  }
                  ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>Store ID</th>
                      <th>Name</th>
                      <th>Address</th>
                      <th>email</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </tfoot>
                  <tbody>
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

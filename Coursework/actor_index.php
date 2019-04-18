<?php
include_once "dbconnection.php";
include_once "template/header.php";

// get delete
if(isset($_GET['delete']) && $_GET['delete'] !== "") {
  $deleteID = trim($_GET['delete']);
  $sql = "DELETE FROM actor WHERE actor_id = '{$deleteID}';";

  if(!$connection->query($sql)) {
    printf("Error: %s\n", $connection->error);
  } else {
    echo "<script type=\"text/javascript\">
    alert('ID = ".$deleteID;
    echo " . Data deleted.'); window.location = 'actor_index.php';
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
            <h1 class="h3 mb-0 text-gray-800">Actors Management</h1>
            <a href="actor_create.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Add actor </a>
            </div>
          <!-- Content DataTable -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Actors List</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                    <th>ID</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Actions</th>
                    </tr>
                  </tfoot>
                  <tbody>
                  <?php
                  $sql = "SELECT * FROM actor";
                  if ($result = $connection->query($sql)) {
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_array())
                        {
                            echo "<tr>";
                            echo "<td>".$row['actor_id']."</td>";
                            echo "<td>".$row['first_name']."</td>";
                            echo "<td>".$row['last_name']."</td>";
                            echo "<td><a href='actor_update.php?id={$row['actor_id']}' class='d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm'>Edit </a> . <a href='actor_index.php?delete={$row['actor_id']}' class='d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm'>Delete </a></td>";
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

<?php
include_once "dbconnection.php";
include_once "template/header.php";

if(isset($_GET['delete']) && $_GET['delete'] !== "") {
  $deleteID = trim($_GET['delete']);
  $sql = "DELETE FROM inventory WHERE inventory_id = '{$deleteID}';";

  if(!$connection->query($sql)) {
    printf("Error: %s\n", $connection->error);
  } else {
    echo "<script type=\"text/javascript\">
    alert('ID = ".$deleteID;
    echo " . Data deleted.'); window.location = 'inventory_index.php';
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
            <h1 class="h3 mb-0 text-gray-800">Inventory Management</h1>
            <a href="inventory_create.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Add Film into inventory</a>
            </div>
          <!-- Content DataTable -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Inventory List</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Store ID</th>
                      <th>Title</th>
                      <th>Description</th>
                      <th>Release Year</th>
                      <th>Language</th>
                      <th>Video length (Mins)</th>
                      <th>Rating</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  $sql = "SELECT *
                          FROM inventory
                          INNER JOIN film ON inventory.film_id = film.film_id";
                  if ($result = $connection->query($sql)) {
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_array())
                        {
                            $languageSQL = "SELECT *
                                        FROM language
                                        WHERE language_id = '{$row[language_id]}'";
                            $languageRow = $connection->query($languageSQL)->fetch_array();
                            echo "<tr>";
                            echo "<td>".$row['inventory_id']."</td>";
                            echo "<td>".$row['store_id']."</td>";
                            echo "<td>".$row['title']."</td>";
                            echo "<td>".$row['description']."</td>";
                            echo "<td>".$row['release_year']."</td>";
                            echo "<td>".$languageRow['name']."</td>";
                            echo "<td>".$row['length']."</td>";
                            echo "<td>".$row['rating']."</td>";
                            echo "<td><a href='inventory_update.php?id={$row['inventory_id']}' class='d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm'>Edit </a> . <a href='inventory_index.php?delete={$row['inventory_id']}' class='d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm'>Delete </a></td>";
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
                      <th>Title</th>
                      <th>Description</th>
                      <th>Release Year</th>
                      <th>Language</th>
                      <th>Video length (Mins)</th>
                      <th>Rating</th>
                      <th>Action</th>
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

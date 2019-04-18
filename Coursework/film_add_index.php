<?php
include_once "dbconnection.php";
include_once "template/header.php";

if(isset($_GET['delete']) && $_GET['delete'] !== "") {
  $deleteID = trim($_GET['delete']);
  $sql = "DELETE FROM film WHERE film_id = '{$deleteID}';";

  if(!$connection->query($sql)) {
    printf("Error: %s\n", $connection->error);
  } else {
    echo "<script type=\"text/javascript\">
    alert('ID = ".$deleteID;
    echo " . Data deleted.'); window.location = 'film_index.php';
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
            <h1 class="h3 mb-0 text-gray-800">Films Management</h1>
            <a href="film_add_create.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Add New Film</a>
            </div>
          <!-- Content DataTable -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Films List</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Title</th>
                      <th>Release Year</th>
                      <th>Language</th>
                      <th>Rental Duration (Days)</th>
                      <th>Rental Rate</th>
                      <th>Video length (Mins)</th>
                      <th>Rating</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  $sql = "SELECT *
                          FROM film
                          INNER JOIN language ON film.language_id = language.language_id";
                  if ($result = $connection->query($sql)) {
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_array())
                        {
                            echo "<tr>";
                            echo "<td>".$row['film_id']."</td>";
                            echo "<td>".$row['title']."</td>";
                            echo "<td>".$row['release_year']."</td>";
                            echo "<td>".$row['name']."</td>";
                            echo "<td>".$row['rental_duration']."</td>";
                            echo "<td>".$row['rental_rate']."</td>";
                            echo "<td>".$row['length']."</td>";
                            echo "<td>".$row['rating']."</td>";
                            echo "<td><a href='film_add_update.php?id={$row['film_id']}' class='d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm'>Edit </a><a href='film_add_index.php?delete={$row['film_id']}' class='d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm'>Delete </a></td>";
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
                      <th>Title</th>
                      <th>Release Year</th>
                      <th>Language</th>
                      <th>Rental Duration (Days)</th>
                      <th>Rental Rate</th>
                      <th>Video length (Mins)</th>
                      <th>Rating</th>
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

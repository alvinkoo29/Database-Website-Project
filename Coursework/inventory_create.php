<?php
include_once "dbconnection.php";
include_once "template/header.php";

// logic after submit the form
if(isset($_POST['submit'])) {
  $storeID = trim($_POST['storeID']);
  $film = trim($_POST['film']);

  $sql = "INSERT INTO inventory (film_id, store_id, last_update) VALUES ('{$film}', '{$storeID}', NOW())";

  if(!$connection->query($sql)) {
    printf("Error: %s\n", $connection->error);
  } else {
    echo "<script type=\"text/javascript\">
    alert('Data saved.');
    window.location = 'actor_index.php';
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
            <h1 class="h3 mb-0 text-gray-800">Add Film</h1>
            </div>
          <!-- Inventory Form -->
          <form id="addFilm" name="addFilm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="form-group">
              <label for="storeID">Store ID</label>
              <select class="form-control" id="storeID" name="storeID">
                <option value="1" selected>1</option>
                <option value="2">2</option>
              </select>
            </div>
            <div class="form-group">
              <label for="film">Film Title</label>
              <select class="form-control" id="film" name="film">
                <?php
                $textSQL = "SELECT * FROM film";
                $result = $connection->query($textSQL);
                while($textRow = $result->fetch_array()) {
                  echo "<option value='{$textRow['film_id']}'>{$textRow['title']}</option>";
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
           <!-- End of Inventory Form -->
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <script type="text/javascript">
      function updateDescription() {
        let title = document.getElementById("title").value;
        document.getElementById("description").value = title;
      }
      </script>

<?php
include_once "template/footer.php"; ?>

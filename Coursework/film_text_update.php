<?php
include_once "dbconnection.php";
include_once "template/header.php";

// logic after submit the form
if(isset($_POST['submit'])) {
  $film_id = trim($_POST['film_id']);
  $title = trim($_POST['title']);
  $description = trim($_POST['description']);

  $sql = "UPDATE film_text SET `title` = '{$title}', `description` = '{$description}' WHERE film_id = '{$film_id}'";

  if(!$connection->query($sql)) {
    printf("Error: %s\n", $connection->error);
  } else {
    echo "<script type=\"text/javascript\">
    alert('Data updated.');
    window.location = 'film_text_index.php';
    </script>";
  }
}

// load the user ID info. Fill to the form
if(isset($_GET['id']) && $_GET['id'] !== "") {
  $sql = "SELECT *
          FROM film_text
          WHERE film_id = '{$_GET['id']}'";
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
            <h1 class="h3 mb-0 text-gray-800">Edit Film Text</h1>
            </div>
          <!-- Film Text Form -->
          <form id="editFilmText" name="editFilmText" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo $row['title']; ?>" placeholder="Title">
            </div>
            <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" id="description" name="description" value="<?php echo $row['description']; ?>" placeholder="Description">
            <input type="hidden" id="film_id" name="film_id" value="<?php echo $row['film_id']; ?>" />
            </div>
            <div class="form-group row">
            <div class="col-sm-10" align="center">
              <input type="submit" name="submit" class="btn btn-primary" value="Submit">
              <input type="reset" name="reset" class="btn btn-primary" value="Reset">
              <input type="reset" name="cancel" class="btn btn-primary" value="Cancel" onClick="window.history.back();">
            </div>
          </div>
          </form>
           <!-- End of Film Text Form -->
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

<?php
include_once "template/footer.php"; ?>

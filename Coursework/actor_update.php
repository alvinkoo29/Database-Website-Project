<?php
include_once "dbconnection.php";
include_once "template/header.php";


// logic after submit the form
if(isset($_POST['submit'])) {
  $actorID = trim($_POST['actor_id']);
  $firstName = trim($_POST['firstName']);
  $lastName = trim($_POST['lastName']);

  $sql = "UPDATE actor SET first_name = '{$firstName}', last_name = '{$lastName}', last_update = 'NOW()' WHERE actor_id = '{$actorID}'";

  if(!$connection->query($sql)) {
    printf("Error: %s\n", $connection->error);
  } else {
    echo "<script type=\"text/javascript\">
    alert('Data updated.');
    window.location = 'actor_index.php';
    </script>";
  }
}

// load the user ID info. Fill to the form
if(isset($_GET['id']) && $_GET['id'] !== "") {
  $sql = "SELECT *
          FROM actor
          WHERE actor_id = '{$_GET['id']}'";
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
            <h1 class="h3 mb-0 text-gray-800">Edit Actor</h1>
            </div>
          <!-- Actor Form -->
          <form id="editActor" name="editActor" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="form-group">
            <label for="firstName">First name</label>
            <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $row['first_name']; ?>" placeholder="First Name">
            </div>
            <div class="form-group">
            <label for="lastName">Last name</label>
            <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $row['last_name']; ?>" placeholder="Last Name">
            <input type="hidden" id="actor_id" name="actor_id" value="<?php echo $row['actor_id']; ?>" />
            </div>
            <div class="form-group row">
            <div class="col-sm-10" align="center">
              <input type="submit" name="submit" class="btn btn-primary" value="Submit">
              <input type="reset" name="reset" class="btn btn-primary" value="Reset">
              <input type="reset" name="cancel" class="btn btn-primary" value="Cancel" onClick="window.history.back();">
            </div>
          </div>
          </form>
           <!-- End of Actor Form -->
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

<?php
include_once "template/footer.php"; ?>

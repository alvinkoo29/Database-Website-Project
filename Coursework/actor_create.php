<?php
include_once "dbconnection.php";
include_once "template/header.php";

// logic after submit the form
if(isset($_POST['submit'])) {
  $firstName = trim($_POST['firstName']);
  $lastName = trim($_POST['lastName']);

  $sql="INSERT INTO actor (first_name, last_name, last_update) VALUES ('{$firstName}', '{$lastName}', NOW())";

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
            <h1 class="h3 mb-0 text-gray-800">Add Actor</h1>
            </div>
          <!-- Actor Form -->
          <form id="addActor" name="addActor" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="form-group">
            <label for="firstName">First name</label>
            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" required>
            </div>
            <div class="form-group">
            <label for="lastName">Last name</label>
            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" required>
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

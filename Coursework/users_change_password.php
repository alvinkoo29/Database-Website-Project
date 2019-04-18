<?php
include_once "dbconnection.php";
include_once "template/header.php";

// logic after submit the form
if(isset($_POST['submit'])) {
  $staffID = trim($_POST['staffID']);
  $password = trim($_POST['password']);
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  $updatePasswordSQL = "UPDATE staff SET `password` = '{$hashed_password}', last_update = NOW() WHERE staff_id = '{$staffID}'";

  if(!$connection->query($updatePasswordSQL)) {
    printf("Error update password: %s\n", $connection->error);
  } else {
    echo "<script type=\"text/javascript\">
    alert('Password Changed!');
    window.location = 'index.php';
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
            <h1 class="h3 mb-0 text-gray-800">Change Password</h1>
            </div>
          <!-- Password Form -->
          <form id="form" name="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          <input type="hidden" name="staffID" value="<?php echo $_SESSION['staffID']; ?>" />
          <div class="form-group">
            <label for="password">New Password:</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="new-password" required pattern="^\S{6,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Must have at least 6 characters' : ''); if(this.checkValidity()) form.password_confirm.pattern = this.value;">
            </div>
          <div class="form-group">
            <label for="password_confirm">Confirm Password:</label>
            <input type="password" class="form-control" id="password_confirm" name="password_confirm" autocomplete="new-password" required pattern="^\S{6,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Please enter the same Password as above' : '');" placeholder="Verify Password">
            </div>
            <div class="form-group row">
            <div class="col-sm-10" align="center">
              <input type="submit" name="submit" class="btn btn-primary" value="Submit">
              <input type="reset" name="cancel" class="btn btn-primary" value="Cancel" onClick="window.history.back();">
            </div>
          </div>
          </form>
           <!-- End of Password Form -->
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

<?php
include_once "template/footer.php"; ?>

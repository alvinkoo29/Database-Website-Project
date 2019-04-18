<?php
include_once "dbconnection.php";

if(isset($_POST['submit'])){
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  $sql = "SELECT `username`, `password`, `staff_id`
          FROM staff
          WHERE username = '{$username}'
          AND active = '1'";
  $result = $connection->query($sql);
  if($result->num_rows > 0) {
    $row = $result->fetch_array();
    $verify = password_verify($password, $row['password']);
    if($verify == 1) {
      session_start();
      $_SESSION['staffID'] = $row['staff_id'];
      $_SESSION['username'] = $row['username'];
      header("Location: index.php");
    } else {
      echo "<script> alert('Data not found! Please retry.'); </script>";
    }
  } else {
    echo "<script> alert('Data not found! Please retry.'); </script>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Login - Movies Rental</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                  </div>
                  <form id="login" name="login" class="user" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Enter Username..." required autocomplete="username">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password" required autocomplete="current-password">
                    </div>
                    <input type="submit" id="submit" name="submit" value="Login" class="btn btn-primary btn-user btn-block">
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

</body>

</html>

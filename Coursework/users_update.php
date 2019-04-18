<?php
include_once "dbconnection.php";
include_once "template/header.php";

// logic after submit the form
if(isset($_POST['submit'])) {
  $staffID = trim($_POST['staffID']);
  $addressID = trim($_POST['addressID']);
  $firstName = trim($_POST['firstName']);
  $lastName = trim($_POST['lastName']);
  $store= trim($_POST['storeID']);
  $email= trim($_POST['email']);
  $address1= trim($_POST['address1']);
  $address2 = trim($_POST['address2']);
  $postcode = trim($_POST['postcode']);
  $district = trim($_POST['district']);
  $city = trim($_POST['city']);
  $active = trim($_POST['active']);
  $phone = trim($_POST['phone']);
  $username = trim($_POST['username']);

  $updateAddressSQL = "UPDATE `address` SET `address` = '{$address1}', `address2` = '{$address2}', `district` = '{$district}', `city_id` = '{$city}', `postal_code` = '{$postcode}', `phone` = '{$phone}', last_update = NOW() WHERE address_id = '{$addressID}'";
  if(!$connection->query($updateAddressSQL)) {
    printf("Error update address: %s\n", $connection->error);
  }

  $updateStaffSQL = "UPDATE staff SET first_name = '{$firstName}', last_name = '{$lastName}', email = '{$email}', store_id = '{$store}', active = '{$active}', username = '{$username}', last_update = NOW() WHERE staff_id = '{$staffID}'";

  if(!$connection->query($updateStaffSQL)) {
    printf("Error insert customer: %s\n", $connection->error);
  } else {
    echo "<script type=\"text/javascript\">
    alert('Data Updated.');
    window.location = 'users_index.php';
    </script>";
  }
}

// load the user ID info. Fill to the form
if(isset($_GET['id']) && $_GET['id'] !== "") {
  $sql = "SELECT *
          FROM staff
          INNER JOIN address ON staff.address_id = address.address_id
          WHERE staff_id = '{$_GET['id']}'";
  $result = $connection->query($sql);

    if ($result->num_rows > 0) {
      $row = $result->fetch_array();

      $citySQL = "SELECT *
                  FROM city
                  INNER JOIN country ON city.country_id = country.country_id
                  WHERE city_id = '{$row['city_id']}'";
      $citySingleRow = $connection->query($citySQL)->fetch_array();

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
            <h1 class="h3 mb-0 text-gray-800">Edit User</h1>
            </div>
          <!-- User Form -->
          <form id="addUser" name="addUser" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          <input type="hidden" name="staffID" value="<?php echo $row['staff_id']; ?>" />
          <input type="hidden" name="addressID" value="<?php echo $row['address_id']; ?>" />
            <div class="form-group">
              <label for="storeID">Store ID</label>
              <select class="form-control" id="storeID" name="storeID">
                <option value="1" <?php echo ($row['store_id'] == "1")? "selected" : "" ;?>>1</option>
                <option value="2" <?php echo ($row['store_id'] == "2")? "selected" : "" ;?>>2</option>
              </select>
            </div>
            <div class="form-group">
            <label for="firstName">First name</label>
            <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $row['first_name']; ?>" placeholder="First Name">
            </div>
            <div class="form-group">
            <label for="lastName">Last name</label>
            <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $row['last_name']; ?>" placeholder="Last Name">
            </div>
            <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $row['phone']; ?>" placeholder="Phone number">
            </div>
            <div class="form-group">
            <label for="address">Address 1</label>
            <input type="text" class="form-control" id="address1" name="address1" value="<?php echo $row['address']; ?>" placeholder="Address 1">
            </div>
            <div class="form-group">
            <label for="address2">Address 2</label>
            <input type="text" class="form-control" id="address2" name="address2" value="<?php echo $row['address2']; ?>" placeholder="Address 2">
            </div>
            <div class="form-group">
            <label for="postcode">Postal Code</label>
            <input type="text" class="form-control" id="postcode" name="postcode" placeholder="Postal Code" value="<?php echo $row['postal_code']; ?>">
            </div>
            <div class="form-group">
            <label for="district">District</label>
            <input type="text" class="form-control" id="district" name="district" value="<?php echo $row['district']; ?>" placeholder="District">
            </div>
            <div class="form-group">
              <label for="city">City and Country</label>
              <select class="form-control" id="city" name="city">
                <?php
                $citySQL = "SELECT * FROM city INNER JOIN country on city.country_id = country.country_id ORDER BY country.country";
                $result = $connection->query($citySQL);
                while($cityRow = $result->fetch_array()) {
                  echo "<option value='{$cityRow['city_id']}' ";
                  echo ($cityRow['city_id'] == $citySingleRow['city_id'])? "selected " : "";
                  echo ">{$cityRow['city']}, {$cityRow['country']}</option>";
                }
                ?>
              </select>
            </div>
            <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>" placeholder="name@example.com">
            </div>
            <div class="form-group">
              <label for="active">Status</label>
              <select class="form-control" id="active" name="active">
                <option value="1" <?php echo ($row['active'] == "1")? "selected" : "" ;?>>Active</option>
                <option value="0" <?php echo ($row['active'] == "0")? "selected" : "" ;?>>Inactive</option>
              </select>
            </div>
            <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $row['username']; ?>" placeholder="Username" autocomplete="username">
            </div>
            <div class="form-group row">
            <div class="col-sm-10" align="center">
              <input type="submit" name="submit" class="btn btn-primary" value="Submit">
              <input type="reset" name="reset" class="btn btn-primary" value="Reset">
              <input type="reset" name="cancel" class="btn btn-primary" value="Cancel" onClick="window.history.back();">
            </div>
          </div>
          </form>
           <!-- End of User Form -->
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

<?php
include_once "template/footer.php"; ?>

<?php
include_once "dbconnection.php";
include_once "template/header.php";

// logic after submit the form
if(isset($_POST['submit'])) {
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

  $addressSQL = "INSERT INTO address (`address`, `address2`, `district`, `city_id`, `postal_code`, `phone`, `last_update`) VALUES ('{$address1}', '{$address2}', '{$district}', '{$city}', '{$postcode}', '{$phone}', NOW())";

  if(!$connection->query($addressSQL)) {
    printf("Error insert address: %s\n", $connection->error);
  }

  $getLatestAddressID = $connection->query("SELECT address_id FROM `address` ORDER BY address_id DESC")->fetch_array();
  if(!$getLatestAddressID) {
    printf("Error get latest address: %s\n", $connection->error);
  }

  $customerSQL = "INSERT INTO customer (store_id, first_name, last_name, email, address_id, active, create_date, last_update) VALUES ('{$store}', '{$firstName}', '{$lastName}', '{$email}', '{$getLatestAddressID['address_id']}', '{$active}', NOW(), NOW())";

  if(!$connection->query($customerSQL)) {
    printf("Error insert customer: %s\n", $connection->error);
  } else {
    echo "<script type=\"text/javascript\">
    alert('Data saved.');
    window.location = 'customers_index.php';
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
            <h1 class="h3 mb-0 text-gray-800">Add Customer</h1>
            </div>
          <!-- Customer Form -->
          <form id="addCustomer" name="addCustomer" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="form-group">
              <label for="storeID">Store ID</label>
              <select class="form-control" id="storeID" name="storeID" required>
                <option value="1" selected>1</option>
                <option value="2">2</option>
              </select>
            </div>
            <div class="form-group">
            <label for="firstName">First name</label>
            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" required>
            </div>
            <div class="form-group">
            <label for="lastName">Last name</label>
            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" required>
            </div>
            <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone number" required>
            </div>
            <div class="form-group">
            <label for="address">Address 1</label>
            <input type="text" class="form-control" id="address1" name="address1" placeholder="Address 1" required>
            </div>
            <div class="form-group">
            <label for="address2">Address 2</label>
            <input type="text" class="form-control" id="address2" name="address2" placeholder="Address 2">
            </div>
            <div class="form-group">
            <label for="postcode">Postal Code</label>
            <input type="text" class="form-control" id="postcode" name="postcode" placeholder="Postal Code" required>
            </div>
            <div class="form-group">
            <label for="district">District</label>
            <input type="text" class="form-control" id="district" name="district" placeholder="District" required>
            </div>
            <div class="form-group">
              <label for="city">City and Country</label>
              <select class="form-control" id="city" name="city" required>
                <option value="-">-</option>
                <?php
                $citySQL = "SELECT * FROM city INNER JOIN country on city.country_id = country.country_id ORDER BY country.country";
                $result = $connection->query($citySQL);
                while($cityRow = $result->fetch_array()) {
                  echo "<option value='{$cityRow['city_id']}'>{$cityRow['city']}, {$cityRow['country']}</option>";
                }
                ?>
              </select>
            </div>
            <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
            </div>
            <div class="form-group">
              <label for="active">Status</label>
              <select class="form-control" id="active" name="active" required>
                <option value="1" selected>Active</option>
                <option value="0">Inactive</option>
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
           <!-- End of Customer Form -->
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

<?php
include_once "template/footer.php"; ?>

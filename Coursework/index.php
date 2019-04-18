<?php
include_once "dbconnection.php";
include_once "template/header.php";
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
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Earnings</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">RM
                      <?php
                       $sql = "SELECT SUM(amount) as totalEarning FROM payment";
                       $result = $connection->query($sql)->fetch_array();
                       echo $result['totalEarning'];
                      ?>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Rental Records</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                      <?php
                       $sql = "SELECT * FROM rental";
                       $result = $connection->query($sql)->num_rows;
                       echo $result;
                      ?>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-list fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Films Collections</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                      <?php
                       $sql = "SELECT * FROM film";
                       $result = $connection->query($sql)->num_rows;
                       echo $result;
                      ?>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-film fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Customers</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                      <?php
                       $sql = "SELECT * FROM customer";
                       $result = $connection->query($sql)->num_rows;
                       echo $result;
                      ?>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Store 1</h1>
        </div>
        <div class="row">
          <div class="col-xl-3 col-md-6 mb-3"> Address:
          <?php
             $sql = "SELECT * FROM store WHERE store_id = '1'";
             $row = $connection->query($sql)->fetch_array();

             $addressSQL = "SELECT *
                            FROM address
                            WHERE address_id = '{$row[address_id]}'";
             $addressRow = $connection->query($addressSQL)->fetch_array();

             $citySQL = "SELECT *
                          FROM city
                          WHERE city_id = '{$addressRow['city_id']}'";
             $cityRow = $connection->query($citySQL)->fetch_array();

             $countrySQL = "SELECT *
                          FROM country
                          WHERE country_id = '{$cityRow['country_id']}'";
             $countryRow = $connection->query($countrySQL)->fetch_array();

             $managerSQL = "SELECT *
                            FROM staff
                            WHERE staff_id = '{$row['manager_staff_id']}'";
             $managerRow = $connection->query($managerSQL)->fetch_array();

             echo $addressRow['address'].", ".$addressRow['district'].", ".$cityRow['city'], ", ".$countryRow['country'];
          ?>
          </div>
          <div class="col-xl-3 col-md-6 mb-3"> Manager: <?php echo $managerRow['username']; ?>
          </div>
        </div>

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Store 2</h1>
        </div>
        <div class="row">
          <div class="col-xl-3 col-md-6 mb-3"> Address:
          <?php
             $sql = "SELECT * FROM store WHERE store_id = '2'";
             $row = $connection->query($sql)->fetch_array();

             $addressSQL = "SELECT *
                            FROM address
                            WHERE address_id = '{$row[address_id]}'";
             $addressRow = $connection->query($addressSQL)->fetch_array();

             $citySQL = "SELECT *
                          FROM city
                          WHERE city_id = '{$addressRow['city_id']}'";
             $cityRow = $connection->query($citySQL)->fetch_array();

             $countrySQL = "SELECT *
                          FROM country
                          WHERE country_id = '{$cityRow['country_id']}'";
             $countryRow = $connection->query($countrySQL)->fetch_array();

             $managerSQL = "SELECT *
                            FROM staff
                            WHERE staff_id = '{$row['manager_staff_id']}'";
             $managerRow = $connection->query($managerSQL)->fetch_array();

             echo $addressRow['address'].", ".$addressRow['district'].", ".$cityRow['city'], ", ".$countryRow['country'];
          ?>
          </div>
          <div class="col-xl-3 col-md-6 mb-3"> Manager: <?php echo $managerRow['username']; ?>
          </div>
        </div>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

<?php include_once "template/footer.php"; ?>

<?php
include_once "dbconnection.php";
include_once "template/header.php";

// logic after submit the form
if(isset($_POST['submit'])) {
  $filmID = trim($_POST['filmID']);
  $filmCategoryID = trim($_POST['filmCategoryID']);
  $title = trim($_POST['title']);
  $category = trim($_POST['category']); // set to film_category
  $releaseYear = trim($_POST['release_year']);
  $language = trim($_POST['language']);
  $rentalDuration = trim($_POST['rental_duration']);
  $rentalRate = trim($_POST['rental_rate']);
  $videoLength = trim($_POST['videoLength']);
  $replacementCost = trim($_POST['replacement_cost']);
  $rating = trim($_POST['rating']);
  $specialFeatures = trim($_POST['special_features']);

  $filmTitleSQL = "SELECT title, description
                    FROM film_text
                    WHERE `film_text_id` = '{$title}'";
  $filmSingleDescription = $connection->query($filmTitleSQL)->fetch_array();

  $updateFilmSQL = "UPDATE `film` SET `title` = '{$filmSingleDescription['title']}', `description` = '{$filmSingleDescription['title']}', `release_year` = '{$releaseYear}', `language_id` = '{$language}', `rental_duration` = '{$rentalDuration}', `rental_rate` = '{$rentalRate}', `length` = '{$videoLength}', `replacement_cost` = '{$replacementCost}', `rating` = '{$rating}', special_features = '{$specialFeatures}', last_update = NOW() WHERE film_id = '{$filmID}'";


  if(!$connection->query($updateFilmSQL)) {
    printf("Error insert film: %s\n", $connection->error);
  }

  // add to film_actor table
  // foreach($_POST['actor'] as $actorID) {
  //   $insertActor = "INSERT INTO film_actor (actor_id, film_id, last_update) VALUES ('{$actorID}', '{getLatestFilmID['film_id']}', NOW())";
  //   if(!$connection->query($insertIntoCategory)) {
  //     printf("Error insert film_category: %s\n", $connection->error);
  //   }
  // }

  $updateCategory = "UPDATE `film_category` SET film_id = '{$filmID}', category_id = '{$category}', last_update = NOW() WHERE film_category_id = '{$filmCategoryID}'";
  if(!$connection->query($updateCategory)) {
    printf("Error insert film_category: %s\n", $connection->error);
  } else {
    echo "<script type=\"text/javascript\">
    alert('Data Updated.');
    window.location = 'film_add_index.php';
    </script>";
  }

}

// load the user ID info. Fill to the form
if(isset($_GET['id']) && $_GET['id'] !== "") {
  $sql = "SELECT *
          FROM film
          INNER JOIN language ON film.language_id = language.language_id
          WHERE film_id = '{$_GET['id']}'";
  $result = $connection->query($sql);

    if ($result->num_rows > 0) {
      $row = $result->fetch_array();

      $filmTitleSQL = "SELECT *
                       FROM film_text
                       WHERE film_id = '{$_GET['id']}'";
      $filmSingleTitle = $connection->query($filmTitleSQL)->fetch_array();
      $filmCategorySQL = "SELECT *
                          FROM film_category
                          WHERE film_id = '{$_GET['id']}'";
      $filmSingleCategory = $connection->query($filmCategorySQL)->fetch_array();
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
            <h1 class="h3 mb-0 text-gray-800">Add Film</h1>
            </div>
          <!-- Film Form -->
          <form id="addFilm" name="addFilm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input type="hidden" name="filmID" value="<?php echo $row['film_id']; ?>">
            <input type="hidden" name="filmCategoryID" value="<?php echo $filmSingleCategory['film_category_id']; ?>">
            <div class="form-group">
              <label for="title">Title</label>
              <select class="form-control" id="title" name="title" onchange="updateDescription();">
                <?php
                $textSQL = "SELECT * FROM film_text";
                $result = $connection->query($textSQL);
                while($textRow = $result->fetch_array()) {
                  echo "<option value='{$textRow['film_text_id']}' ";
                  echo ($textRow['title'] == $filmSingleTitle['title'])? "selected ": "";
                  echo ">{$textRow['title']}</option>";
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="category">Category</label>
              <select class="form-control" id="category" name="category">
                <?php
                $categorySQL = "SELECT * FROM category";
                $result = $connection->query($categorySQL);
                while($categoryRow = $result->fetch_array()) {
                  echo "<option value='{$categoryRow['category_id']}' ";
                  echo ($categoryRow['category_id'] == $filmSingleCategory['category_id'])? "selected ": "";
                  echo ">{$categoryRow['name']}</option>";
                }
                ?>
              </select>
            </div>
            <div class="form-group">
            <label for="release_year">Release Year</label>
            <input type="number" class="form-control" id="release_year" name="release_year" step="1" placeholder="Release Year" value="<?php echo $row['release_year']; ?>">
            </div>
            <div class="form-group">
              <label for="language">Language</label>
              <select class="form-control" id="language" name="language">
                <?php
                $languageSQL = "SELECT * FROM language";
                $result = $connection->query($languageSQL);
                while($languageRow = $result->fetch_array()) {
                  echo "<option value='{$languageRow['language_id']}' ";
                  echo ($languageRow['language_id'] == $row['language_id'])? "selected ":"";
                  echo ">{$row['name']}</option>";
                }
                ?>
              </select>
            </div>
            <div class="form-group">
            <label for="rental_duration">Rental Duration (Days)</label>
            <input type="number" class="form-control" id="rental_duration" min="0" step="1" value="0" name="rental_duration" placeholder="Rental Duration" value="<?php echo $row['rental_duration']; ?>">
            </div>
            <div class="form-group">
            <label for="rental_rate">Rental Rate (E.g 12.00)</label>
            <input type="number" pattern="^\d+(\.|\,)\d{2}$" class="form-control" id="rental_rate" name="rental_rate" placeholder="Rental Rate" value="<?php echo $row['rental_rate']; ?>">
            </div>
            <div class="form-group">
            <label for="videoLength">Video Length (Mins)</label>
            <input type="text" class="form-control" id="videoLength" name="videoLength" placeholder="Video Length (Mins)" value="<?php echo $row['length']; ?>">
            </div>
            <div class="form-group">
            <label for="replacement_cost">Replacement Cost</label>
            <input type="text" class="form-control" id="replacement_cost" name="replacement_cost" placeholder="Replacement Cost" value="<?php echo $row['replacement_cost']; ?>">
            </div>
            <div class="form-group">
            <label for="rating">Rating</label>
            <input type="text" class="form-control" id="rating" name="rating" placeholder="Rating" value="<?php echo $row['rating']; ?>">
            </div>
            <div class="form-group">
            <label for="special_features">Special Features</label>
            <input type="text" class="form-control" id="special_features" name="special_features" placeholder="Special Features" value="<?php echo $row['special_features']; ?>">
            </div>
            <div class="form-group row">
            <div class="col-sm-10" align="center">
              <input type="submit" name="submit" class="btn btn-primary" value="Submit">
              <input type="reset" name="reset" class="btn btn-primary" value="Reset">
              <input type="reset" name="cancel" class="btn btn-primary" value="Cancel" onClick="window.history.back();">
            </div>
          </div>
          </form>
           <!-- End of Film Form -->
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
<?php
include_once "template/footer.php"; ?>

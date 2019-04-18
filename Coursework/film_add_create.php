<?php
include_once "dbconnection.php";
include_once "template/header.php";

// logic after submit the form
if(isset($_POST['submit'])) {
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

  $sql = "INSERT INTO `film` (`title`, `description`, `release_year`, `language_id`, `rental_duration`, `rental_rate`, `length`, `replacement_cost`, `rating`, special_features, last_update) VALUES ('{$filmSingleDescription['title']}', '{$filmSingleDescription['description']}', '{$releaseYear}', '{$language}', '{$rentalDuration}', '{$rentalRate}', '{$videoLength}', '{$replacementCost}', '{$rating}', '{$specialFeatures}', NOW())";

  if(!$connection->query($sql)) {
    printf("Error insert film: %s\n", $connection->error);
  }

  $getLatestFilmID = $connection->query("SELECT film_id FROM `film` ORDER BY film_id DESC")->fetch_array();
  if(!$getLatestFilmID) {
    printf("Error get latest address: %s\n", $connection->error);
  }

  // add to film_actor table
  foreach($_POST['actor'] as $actorID) {
    $insertActor = "INSERT INTO film_actor (actor_id, film_id, last_update) VALUES ('{$actorID}', '{getLatestFilmID['film_id']}', NOW())";
    if(!$connection->query($insertIntoCategory)) {
      printf("Error insert film_category: %s\n", $connection->error);
    }
  }

  $insertIntoCategory = "INSERT INTO film_category (film_id, category_id, last_update) VALUES ('{$getLatestFilmID['film_id']}', '{$category}', NOW())";

  if(!$connection->query($insertIntoCategory)) {
    printf("Error insert film_category: %s\n", $connection->error);
  } else {
    echo "<script type=\"text/javascript\">
    alert('Data saved.');
    window.location = 'film_add_index.php';
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
          <!-- Film Form -->
          <form id="addFilm" name="addFilm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="form-group">
              <label for="title">Title</label>
              <select class="form-control" id="title" name="title" required>
                <option value="-">-</option>
                <?php
                $textSQL = "SELECT * FROM film_text";
                $result = $connection->query($textSQL);
                while($textRow = $result->fetch_array()) {
                  echo "<option value='{$textRow['film_text_id']}'>{$textRow['title']}</option>";
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="category">Category</label>
              <select class="form-control" id="category" name="category" required>
                <?php
                $categorySQL = "SELECT * FROM category";
                $result = $connection->query($categorySQL);
                while($categoryRow = $result->fetch_array()) {
                  echo "<option value='{$categoryRow['category_id']}'>{$categoryRow['name']}</option>";
                }
                ?>
              </select>
            </div>
            <div class="form-group">
            <label for="release_year">Release Year</label>
            <input type="number" class="form-control" id="release_year" name="release_year" value="1950" step="1" placeholder="Release Year" required>
            </div>
            <div class="form-group">
              <label for="language">Language</label>
              <select class="form-control" id="language" name="language">
                <?php
                $languageSQL = "SELECT * FROM language";
                $result = $connection->query($languageSQL);
                while($languageRow = $result->fetch_array()) {
                  echo "<option value='{$languageRow['language_id']}'>{$languageRow['name']}</option>";
                }
                ?>
              </select>
            </div>
            <div class="form-group">
            <label for="rental_duration">Rental Duration (Days)</label>
            <input type="number" class="form-control" id="rental_duration" min="0" step="1" value="0" name="rental_duration" placeholder="Rental Duration" required>
            </div>
            <div class="form-group">
            <label for="rental_rate">Rental Rate (E.g 12.00)</label>
            <input type="number" pattern="^\d+(\.|\,)\d{2}$" class="form-control" id="rental_rate" name="rental_rate" placeholder="Rental Rate" required>
            </div>
            <div class="form-group">
            <label for="videoLength">Video Length (Mins)</label>
            <input type="text" class="form-control" id="videoLength" name="videoLength" placeholder="Video Length (Mins)">
            </div>
            <div class="form-group">
            <label for="replacement_cost">Replacement Cost</label>
            <input type="text" class="form-control" id="replacement_cost" name="replacement_cost" placeholder="Replacement Cost" required>
            </div>
            <div class="form-group">
            <label for="rating">Rating</label>
            <input type="text" class="form-control" id="rating" name="rating" placeholder="Rating">
            </div>
            <div class="form-group">
            <label for="special_features">Special Features</label>
            <input type="text" class="form-control" id="special_features" name="special_features" placeholder="Special Features">
            </div>
            <div class="form-group">
              <label for="actor">Actor</label>
              <select multiple class="form-control" id="actor" name="actor[]">
                <?php
                $actorSQL = "SELECT * FROM actor";
                $result = $connection->query($actorSQL);
                while($actorRow = $result->fetch_array()) {
                  echo "<option value='{$actorRow['actor_id']}'>{$actorRow['first_name']} {$actorRow['last_name']}</option>";
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
           <!-- End of Film Form -->
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
<?php
include_once "template/footer.php"; ?>

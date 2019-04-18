<?php
$dbServername = "localhost";

// production
$dbUsername = "hcyak1_test";
$dbPassword = "Ygp-s$?vO+Ba";
$dbName = "hcyak1_test";

// development
// $dbUsername = "project";
// $dbPassword = "project";
// $dbName = "hcyak1_test";

$connection = mysqli_connect($dbServername,$dbUsername,$dbPassword,$dbName) or die("Connection to server failed");
?>

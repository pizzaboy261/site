<!--Connect met database-->
<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'restaurant';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
  die("Databaseverbinding mislukt: " . $conn->connect_error);
}
?>

<?php
// settings.php
// Database connection settings

$host = "localhost";
$user = "root";
$pass = "";
$db   = "assignment2";  

// Create connection
$conn = mysqli_connect($host, $user, $pass, $db);

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>

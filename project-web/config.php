<?php
// config.php
$servername   = "localhost";
$db_username  = "root";
$db_password  = "";
$dbname       = "umkm_db1";

// Buat koneksi ke database
$conn = new mysqli($servername, $db_username, $db_password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

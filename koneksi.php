<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "uas_pemweb_120140219";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}
?>
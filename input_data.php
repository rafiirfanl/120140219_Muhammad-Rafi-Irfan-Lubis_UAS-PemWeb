<?php
include 'koneksi.php';

$nama_buku = htmlspecialchars($_POST['nama_buku']);
$harga_buku = htmlspecialchars($_POST['harga_buku']);
$kategori_buku = htmlspecialchars($_POST['kategori_buku']);
$status = htmlspecialchars($_POST['status_buku']);

$query = "INSERT INTO buku (nama_buku, harga_buku, kategori_buku, status_buku) VALUES ('$nama_buku', '$harga_buku', '$kategori_buku', '$status')";

if ($conn->query($query) === TRUE) {
    header('Location: index.php');
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}

$conn->close();
?>
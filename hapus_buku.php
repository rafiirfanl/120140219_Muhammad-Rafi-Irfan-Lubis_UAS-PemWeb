<?php
include 'koneksi.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM buku WHERE id = $id";

    if ($conn->query($query) === TRUE) {
        header('Location: index.php');
        exit();
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    echo "ID Buku tidak valid.";
}
?>

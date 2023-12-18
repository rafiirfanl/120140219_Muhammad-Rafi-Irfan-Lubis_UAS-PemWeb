<?php
session_start();

        //Identifikasi Browser
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $browser_type = '';

        if (strpos($user_agent, 'MSIE') !== false || strpos($user_agent, 'Trident') !== false) {
            $browser_type = 'Internet Explorer';
        } elseif (strpos($user_agent, 'Firefox') !== false) {
            $browser_type = 'Mozilla Firefox';
        } elseif (strpos($user_agent, 'Chrome') !== false) {
            $browser_type = 'Google Chrome';
        } elseif (strpos($user_agent, 'Safari') !== false) {
            $browser_type = 'Safari';
        } elseif (strpos($user_agent, 'Opera') !== false || strpos($user_agent, 'OPR') !== false) {
            $browser_type = 'Opera';
        } elseif (strpos($user_agent, 'Edge') !== false) {
            $browser_type = 'Microsoft Edge';
        } else {
            $browser_type = 'Unknown Browser';
        }

        echo "<script>localStorage.setItem('browser_type', '" . $browser_type . "');</script>";

        $ipaddr = getenv('REMOTE_ADDR');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Gramai-Iya Book Store</title>
    <style>
    :root{
        color: black;
    }
    
    body {
        margin: 0;
        padding: 20px;
        padding-bottom: 30px; 
    }
    .header {
        background-color: rgb(243, 93, 138);
        color: black;
        padding-left: 3%;
        padding-right: 5%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .button:hover{
        cursor: pointer;
    }
    
    .content1 {
        padding-left: 2%;
        padding-right: 2%;
        display: flex;
        flex-direction: column; 
        align-items: center; 
        text-align: center; 
    }
    
    .content2 {
        padding-left: 2%;
        padding-right: 2%;
    }

    .form-group {
        margin-bottom: 10px;
    }
    
    .tables {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    
    .tables th, .tables td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }
    
    .tables th {
        background-color: #f2f2f2;
        color: #333;
        font-weight: bold;
    }
    
    .tables tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    </style>

</head>
<body>
    <div class="header">
        <h1>Gramai-Iya Book Store</h1>
    </div>

    <div class="content1">

        <h1>Tambah Data buku</h1>
    
        <form id="formInput" action="input_data.php" method="post" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="nama_buku">Nama buku:</label>
                <input type="text" id="nama_buku" name="nama_buku">
            </div>

            <div class="form-group">
                <label for="penulis">Penulis:</label>
                <input type="text" id="penulis" name="penulis">
            </div>

            <div class="form-group">
                <label for="harga_buku">Harga buku:</label>
                <input type="number" id="harga_buku" name="harga_buku">
            </div>

            <div class="form-group">
                <label for="kategori_buku">Kategori:</label>
                <select class="form-control" id="kategori_buku" name="kategori_buku">
                    <option value="Pelajaran">Pelajaran</option>
                    <option value="SciFI">SciFi</option>
                    <option value="Novel">Novel</option>
                    <option value="Komik">Komik</option>
                </select>
            </div>

            <div class="form-group">
                <p>Status:</p>
                <input type="checkbox" id="status_buku" name="status_buku" value="Tersedia">
                <label for="status_buku">Tersedia</label><br>
            </div>

            <input type="submit" class="button" value="Submit">
            <input type="button" class="button" value="Reset" onclick="resetForm()">
        </form>
    </div>
    
    <div class="content2">
        <h1>Informasi buku</h1>

        <table class="tables">
            <thead>
            <tr>
                <th>Nama buku</th>
                <th>Penulis</th>
                <th>Harga buku</th>
                <th>Kategori buku</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>

            <tbody>
                <?php
                include 'koneksi.php';

                $query = "SELECT * FROM buku";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['nama_buku'] . "</td>";
                    echo "<td>" . $row['penulis'] . "</td>";
                    echo "<td>" . $row['harga_buku'] . "</td>";
                    echo "<td>" . $row['kategori_buku'] . "</td>";

                    if ($row['status_buku'] != "Tersedia"){
                        echo "<td>" . 'Tidak Tersedia' . "</td>";
                    }else {
                        echo "<td>" . $row['status_buku'] . "</td>";
                    }
                    
                    echo "<td>
                            <a href='hapus_buku.php?id=" . $row['id'] . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus buku ini?\")'>Hapus</a>
                        </td>";
                    echo "</tr>";
                    echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Tidak ada buku.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>

        <h1>Informasi Browser Pengguna</h1>
        <div id="browserInfo">
            
        </div>
    </div>

    <script>
       
        function resetForm() {
            var form = document.getElementById('formInput');
            form.reset();
        }

        var browserType = localStorage.getItem('browser_type');
        document.getElementById('browserInfo').textContent = 'Anda saat ini menggunakan tipe Browser: ' + browserType;

        function validateForm() {
            var namabuku = document.getElementById('nama_buku').value;
            var namabuku = document.getElementById('penulis').value;
            var hargabuku = document.getElementById('harga_buku').value;
            var kategoribuku = document.getElementById('kategori_buku').value;

            if (namabuku === '' || hargabuku === '' || kategoribuku === '') {
                alert('Mohon lengkapi semua kolom!');
                return false;
            }

            return true;
        }
    </script>
    
</body>
</html>

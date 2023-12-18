<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Gramai-Iya Book Store</title>
</head>
<body>
    <div class="header">
        <h1>Gramai-Iya Book Store</h1>
    </div>

    <!-- <div class="">
        <h1>Gramai-Iya Book Store</h1>
    </div> -->
    <?php
        session_start();

        //mencari jenis browser
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $browser_type = '';

        // Mencari Jenis Browser yang digunakan
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

        //menyimpan browser type ke local storage
        echo "<script>localStorage.setItem('browser_type', '" . $browser_type . "');</script>";

        //ambil ip address
        $ipaddr = getenv('REMOTE_ADDR');
    ?>

    <div class="content">
        <h1>Informasi Buku</h1>
        
        <div id="browserInfo"></div>

        <h1>Tambah Data buku</h1>
        <form id="formInput" action="input_data.php" method="post" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="nama_buku">Nama buku:</label>
                <input type="text" id="nama_buku" name="nama_buku">
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
    
    <div class="content">
        <h1>Informasi buku</h1>

        <table class="tables">
            <thead>
            <tr>
                <th>Nama buku</th>
                <th>Harga buku</th>
                <th>Kategori buku</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>

            <tbody>
                <?php
                include 'koneksi.php';

                // Query untuk mengambil keseluruhan database
                $query = "SELECT * FROM buku";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['nama_buku'] . "</td>";
                    echo "<td>" . $row['harga_buku'] . "</td>";
                    echo "<td>" . $row['kategori_buku'] . "</td>";

                    // logic untuk menmeriksa apakah status_buku Tersedia atau array kosong, jika array kosong, maka akan menampilkan "Tidak Tersedia"
                    if ($row['status_buku'] != "Tersedia"){
                        echo "<td>" . 'Tidak Tersedia' . "</td>";
                    }else {
                        echo "<td>" . $row['status_buku'] . "</td>";
                    }
                    
                    //button hapus buku untuk menghapus buku berdasarkan id
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
    </div>

    <script>
        // Fungsi resetForm untuk mereset formulir input pengguna ketika button reset di klik
        function resetForm() {
            var form = document.getElementById('formInput');
            form.reset();
        }

        // Ambil nilai dari localStorage dan tampilkan text di element dengan ID 'browserInfo'
        var browserType = localStorage.getItem('browser_type');
        document.getElementById('browserInfo').textContent = 'Browser Type: ' + browserType;

        //validateForm untuk validasi apakah semua input field sudah terisi atau belum. Jika belum, akan muncul alert
        function validateForm() {
            var namabuku = document.getElementById('nama_buku').value;
            var hargabuku = document.getElementById('harga_buku').value;
            var kategoribuku = document.getElementById('kategori_buku').value;

            // Validasi form
            if (namabuku === '' || hargabuku === '' || kategoribuku === '') {
                alert('Mohon lengkapi semua kolom!');
                return false;
            }

            return true;
        }
    </script>
    
</body>
</html>

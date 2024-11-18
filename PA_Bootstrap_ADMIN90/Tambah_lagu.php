<?php

require "koneksi.php"; // Include database connection

if (isset($_POST['tambah_lagu'])) {
    // Retrieve form inputs
    $judul_lagu = $_POST['judul']; // Judul lagu from input
    $asal_daerah = $_POST['asal_daerah'];
    $tanggal_rilis = $_POST['tanggal_lagu']; // Tanggal rilis from input
    $lirik_lagu = $_POST['lirik']; // Lirik lagu from textarea
    $deskripsi = $_POST['deskripsi']; // Deskripsi from textarea
    $id_album = $_POST['id_album']; // ID album from dropdown

    // Escape inputs to prevent SQL injection
    $judul_lagu = mysqli_real_escape_string($conn, $judul_lagu);
    $asal_daerah = mysqli_real_escape_string($conn, $asal_daerah);
    $tanggal_rilis = mysqli_real_escape_string($conn, $tanggal_rilis);
    $lirik_lagu = mysqli_real_escape_string($conn, $lirik_lagu);
    $deskripsi = mysqli_real_escape_string($conn, $deskripsi);
    $id_album = mysqli_real_escape_string($conn, $id_album); // Sanitize the album ID

    // Handle cover image upload
    $file_sampul = $_FILES['sampul']['name']; 
    $sampul_tmp = $_FILES['sampul']['tmp_name'];
    $sampul_upload_dir = 'sampul-lagu/';
    $sampul_path = $sampul_upload_dir . $file_sampul;

    // Handle song file upload
    $file_lagu = $_FILES['lagu']['name']; 
    $lagu_tmp = $_FILES['lagu']['tmp_name'];
    $lagu_upload_dir = 'lagu/';
    $lagu_path = $lagu_upload_dir . $file_lagu;

    // Validate the file types for the uploads
    $allowed_audio_types = ['audio/mpeg'];
    $lagu_type = mime_content_type($lagu_tmp);
    $allowed_image_types = ['image/jpeg', 'image/png'];

    $sampul_type = mime_content_type($sampul_tmp);

    if (!in_array($lagu_type, $allowed_audio_types)) {
        echo "<script>alert('File lagu hanya dapat berupa file MP3.');</script>";
    } elseif (!in_array($sampul_type, $allowed_image_types)) {
        echo "<script>alert('File sampul hanya dapat berupa file JPG/PNG.');</script>";
    } elseif (move_uploaded_file($sampul_tmp, $sampul_path) && move_uploaded_file($lagu_tmp, $lagu_path)) {
        // SQL query to insert the data into the database
        $sql = "INSERT INTO lagu (judul_lagu, asal_daerah, tanggal_rilis, lirik_lagu, deskripsi, file_sampul, file_lagu, id_album) 
                VALUES ('$judul_lagu', '$asal_daerah' ,'$tanggal_rilis', '$lirik_lagu', '$deskripsi', '$file_sampul', '$file_lagu', '$id_album')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Lagu berhasil ditambahkan!');</script>";
        } else {
            echo "<script>alert('Gagal menambahkan lagu: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Gagal mengunggah file.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Lagu</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/tambah_lagu.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-up">
                <button class="logo-btn" onclick="toggleSidebar()">
                    <img src="Logo/logo.png" alt="logo" class="logo">
                </button>
                <button class="icon-btn">
                    <i class="fa-solid fa-plus-circle" style="font-size: 35px; color: #110905;"></i>
                    <span class="icon-text">Tambah</span>
                </button>
                <button class="icon-btn">
                    <i class="fa-solid fa-music" style="font-size: 30px; color: #110905;"></i>
                    <span class="icon-text">Album</span>
                </button>
            </div>
            <div class="sidebar-logout">
                <button class="icon-btn">
                    <i class="fa-solid fa-right-from-bracket" style="font-size: 35px; color: #110905;"></i>
                    <span class="icon-text">Keluar</span>
                </button>
            </div>
            
        </nav>
        

        <!-- Main Content -->
        <div class="main-content">
            <!-- Navbar -->
            <nav class="navbar">
                <div class="navbar-left">
                    <button class="arrow"><i class="fa-solid fa-chevron-left" style="font-size: 17px; color: #110905; background : #a88f6b"></i></button>
                    <button class="arrow"><i class="fa-solid fa-chevron-right" style="font-size: 17px; color: #110905; background : #a88f6b"></i></button>
                </div>
                <h1 style="color: #a88f6B; font-size:32px; margin-top: 7px;">Tambah Lagu</h1>
                <div class="account">
                    <img src="Logo/logo.png" alt="Profile" class="profile-img">
                    <span>Admin</span>
                </div>
            </nav>
            <!-- Main Content Body -->
            <div class="main-content-body">
                <main class="form">
                <form action="Tambah_lagu.php" method="POST" enctype="multipart/form-data">
                        <div class="form-section">
                            <label for="judul">Judul Lagu</label>
                            <input type="text" id="judul" name="judul" placeholder="Judul lagu" required>

                            <label for="asal_daerah">Asal Daerah</label>
                            <input type="text" id="asal_daerah" name="asal_daerah" placeholder="Asal daerah" required>

                            <label for="tanggal_lagu">Tanggal Rilis</label>
                            <input type="date" id="tanggal_lagu" name="tanggal_lagu" required>

                            <label for="id_album">Pilih Album</label>
                            <select id="id_album" name="id_album" required>
                                <?php
                                // Query untuk mengambil album dari database
                                $album_query = "SELECT * FROM album";
                                $album_result = mysqli_query($conn, $album_query);

                                // Menampilkan album dalam dropdown
                                while ($album = mysqli_fetch_assoc($album_result)) {
                                    echo "<option value='" . $album['id_album'] . "'>" . $album['nama_album'] . "</option>";
                                }
                                ?>
                            </select>

                            <label for="sampul">Unggah Foto Sampul Lagu</label>
                            <div class="file-upload">
                                <label for="sampul" class="upload-btn">Unggah foto</label>
                                <span class="file-name-sampul-lagu">Tidak ada file dipilih</span>
                                <input type="file" id="sampul" name="sampul" required onchange="showFileNameSampul(this)">
                            </div>

                            <label for="lagu">Unggah File Lagu</label>
                            <div class="file-upload">
                                <label for="lagu" class="upload-btn">Unggah lagu</label>
                                <span class="file-name-lagu">Tidak ada file dipilih</span>
                                <input type="file" id="lagu" name="lagu" required onchange="showFileNameLagu(this)">
                            </div>
                        </div>

                        <div class="form-section">
                            <label for="lirik">Lirik Lagu</label>
                            <textarea name="lirik" id="lirik" placeholder="Tambahkan lirik" required></textarea>

                            <label for="deskripsi">Deskripsi Lagu</label>
                            <textarea name="deskripsi" id="deskripsi" placeholder="Tambahkan deskripsi lagu" required></textarea>
                        </div>

                        <div class="form-buttons">
                            <button type="submit" class="btn" name="tambah_lagu">Tambah</button>
                            <button type="button" class="btn"><a href="daftar_lagu_admin.php">Batal</button></a>
                        </div>
                    </form>
                </main>
            </div> 
        </div>

        <script>
        // Fungsi untuk menampilkan nama file sampul
        function showFileNameSampul(input) {
            const fileNameSampul = input.files[0] ? input.files[0].name : "Tidak ada file dipilih";
            document.querySelector(".file-name-sampul-lagu").textContent = fileNameSampul;
        }

        // Fungsi untuk menampilkan nama file lagu
        function showFileNameLagu(input) {
            const fileNameLagu = input.files[0] ? input.files[0].name : "Tidak ada file dipilih";
            document.querySelector(".file-name-lagu").textContent = fileNameLagu;
        }
        </script>
    </div>
</body>
</html>

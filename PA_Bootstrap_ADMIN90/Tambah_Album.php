<?php
require "koneksi.php";

if (isset($_POST['tambah_album'])) {
    $nama_album = $_POST['album'];
    $asal_daerah = $_POST['asal_daerah'];
    $tanggal_rilis = $_POST['tanggal_album'];

    // Upload sampul album
    $sampul_album = $_FILES['sampul_album']['name'];
    $sampul_tmp = $_FILES['sampul_album']['tmp_name'];
    $upload_dir = 'sampul/';
    $sampul_path = $upload_dir . $sampul_album;

    // Validasi tipe file sampul album
    $allowed_image_types = ['image/jpeg'];
    $sampul_type = mime_content_type($sampul_tmp);

    if (!in_array($sampul_type, $allowed_image_types)) {
        echo "<script>alert('Sampul album hanya dapat berupa file .jpg');</script>";
    } elseif (move_uploaded_file($sampul_tmp, $sampul_path)) {
        // Insert data album
        $sql_album = "INSERT INTO album (nama_album, asal_daerah, tanggal_rilis, sampul_album) 
                      VALUES ('$nama_album', '$asal_daerah', '$tanggal_rilis', '$sampul_album')";
        
        if (mysqli_query($conn, $sql_album)) {
            echo "<script>alert('Album berhasil ditambahkan!');</script>";
        } else {
            echo "<script>alert('Gagal menambahkan album: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Gagal mengunggah sampul album.');</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Album</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/tambah_album.css" />
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
                <a href="Tambah_Album.php" class="icon-btn">
                    <i class="fa-solid fa-plus-circle" style="font-size: 35px; color: #110905;"></i>
                    <span class="icon-text">Tambah</span>
                </a>
                <a href="Album_admin.php" class="icon-btn">
                    <i class="fa-solid fa-music" style="font-size: 30px; color: #110905;"></i>
                    <span class="icon-text">Album</span>
                </a>
            </div>
            <div class="sidebar-logout">
                <a href="index.html" class="icon-btn">
                    <i class="fa-solid fa-right-from-bracket" style="font-size: 35px; color: #110905;"></i>
                    <span class="icon-text">Keluar</span>
                </a>
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
                <h1 style="color: #a88f6B; font-size:32px; margin-top: 7px;">Tambah Album</h1>
                <div class="account">
                    <img src="Logo/logo.png" alt="Profile" class="profile-img">
                    <span>Admin</span>
                </div>



            </nav>
            <!-- Main Content Body -->
            <div class="main-content-body">
                <main class="form">
                    <form action="Tambah_Album.php" method="post" enctype="multipart/form-data">
                        <div class="form-section">
                            <label for="album">Nama Album</label>
                            <input type="text" id="album" name="album" placeholder="Nama Album" required>
                
                            <label for="asal_daerah">Asal Daerah</label>
                            <input type="text" id="asal_daerah" name="asal_daerah" placeholder="Asal daerah" required>
                
                            <label for="tanggal">Tanggal Rilis</label>
                            <div class="custom-date">
                                <input type="date" id="tanggal_album" name="tanggal_album"  required>
                                <span class="calendar-icon"></span>
                            </div>
                            
                            <label for="lagu">Unggah Foto Sampul Album</label>
                            <div class="file-upload">
                                <label for="sampul_album" class="upload-btn">Unggah foto</label>
                                <span class="file-name">Tidak ada file dipilih</span>
                                <input type="file" id="sampul_album" name="sampul_album" accept=".jpeg" onchange="showFileName(this)">
                            </div>
                        </div>
                
                        <div class="form-buttons">
                            <button type="submit" class="btn" name="tambah_album">Tambah</button>
                            <button type="button" class="btn"><a href="Album_admin.php">Batal</button></a>
                        </div>
                    </form>
                </main>
                
            </div> 
        </div>





        
    </div>
    <script src="js/home.js" defer></script>
</body>
</html>

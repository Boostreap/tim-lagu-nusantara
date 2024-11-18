<?php
require "koneksi.php";

// Memastikan album_id diterima dengan benar dari URL
if (isset($_GET['album_id']) && is_numeric($_GET['album_id'])) {
    $album_id = $_GET['album_id'];

    // Query untuk mengambil data lagu beserta informasi album yang terkait
    $query = "
        SELECT lagu.*, album.nama_album, album.sampul_album, album.tanggal_rilis
        FROM lagu
        INNER JOIN album ON lagu.id_album = album.id_album
        WHERE album.id_album = $album_id
        ORDER BY lagu.id_lagu DESC
    ";

    // Eksekusi query
    $result = mysqli_query($conn, $query);

    // Cek apakah query berhasil
    if (!$result) {
        die("Query error: " . mysqli_error($conn));  // Menampilkan error jika query gagal
    }

    // Ambil data album untuk ditampilkan di halaman
    $album_query = "SELECT * FROM album WHERE id_album = $album_id";
    $album_result = mysqli_query($conn, $album_query);
    if ($album_result) {
        $album = mysqli_fetch_assoc($album_result);
    }
    else {
        // Jika album_id tidak valid, tampilkan pesan error atau redirect ke halaman lain
        die("Album ID tidak valid.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Songs</title>
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
                <a href="Tambah_Album.php"><button class="icon-btn">
                    <i class="fa-solid fa-plus-circle" style="font-size: 35px; color: #110905;"></i>
                    <span class="icon-text">Tambah</span>
                </button>
                </a>
                <a href="Album_admin.php"><button class="icon-btn">
                    <i class="fa-solid fa-music" style="font-size: 30px; color: #110905;"></i>
                    <span class="icon-text">Album</span>
                </button>
                </a>
            </div>
            <div class="sidebar-logout">
                <a href="index.html"><button class="icon-btn">
                    <i class="fa-solid fa-right-from-bracket" style="font-size: 35px; color: #110905;"></i>
                    <span class="icon-text">Keluar</span>
                </button>
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
                <div class="search">
                    <i class="fa-solid fa-magnifying-glass" style="font-size: 17px; color: #110905; background : #a88f6b"></i>
                    <input type="text" placeholder="Cari lagu">
                </div>
                <div class="account">
                    <img src="Logo/logo.png" alt="Profile" class="profile-img">
                    <span>Admin</span>
                </div>
            </nav>
            
            <!-- Main Content Body -->
            <div class="main-content-body">
                <?php if (isset($album)) { ?>
                    <div class="album-detail">
                        <img src="sampul/<?= $album['sampul_album'] ?>" alt="Album Cover" class="album">
                        <div class="album-details">
                            <h1><?= $album['nama_album'] ?></h1>
                            <p>Album • <?= $album['tanggal_rilis'] ?> • <?= mysqli_num_rows($result) ?> Songs</p>
                            <div class="album-controls">
                                <a href="Tambah_lagu.php" class="play-btn">
                                    <i class="fa-solid fa-plus-circle" style="font-size: 35px;"></i>
                                </a>
                                <a href="Ubah_Album.php?id=<?= $album['id_album'] ?>" class="play-btn">
                                    <i class="fa-solid fa-pen-to-square" style="font-size: 35px;"></i>
                                </a>
                                <a href="hapus_album.php?id_album=<?= $album['id_album']?>" class="play-btn">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <div class="song-list">
                    <div class="song-header">
                        <div class="song-no-header">No</div>
                        <div class="song-title-header">Judul</div>
                        <div class="song-release-header">Tanggal rilis</div>
                        <div class="song-duration-header">Durasi</div>
                        <div class="song-edit-header">Ubah</div>
                        <div class="song-delete-header">Hapus</div>
                    </div>
                
                    <?php
                    // Pastikan query berhasil dan result ada
                    if (mysqli_num_rows($result) > 0) {
                        $no = 1;
                        while ($lagu = mysqli_fetch_assoc($result)) {
                            $asal_daerah = $lagu['asal_daerah']; 
                            ?>
                            <div class="song-item">
                                <div class="song-no-item"><?= $no++ ?></div>
                                <div class="song-title-item"><?= $lagu['judul_lagu'] ?><br><span><?= htmlspecialchars($lagu['asal_daerah']) ?></span></div>
                                <div class="song-release-item"><?= $lagu['tanggal_rilis'] ?></div>
                                <div class="song-duration-item">00:00</div>
                                <div class="song-edit-item">
                                    <a href="Ubah_Lagu.php?id_lagu=<?= $lagu['id_lagu'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                </div>
                                <div class="song-delete-item">
                                    <a href="hapus_lagu.php?id=<?= $lagu['id_lagu'] ?>"><i class="fa-solid fa-trash-can"></i></a>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo "Tidak ada lagu ditemukan.";
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
    <script src="js/home.js" defer></script>
</body>
</html>

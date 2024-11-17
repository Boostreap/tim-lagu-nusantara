<?php
require "koneksi.php";

// Mengambil input pencarian, jika ada
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query untuk mengambil data album berdasarkan pencarian
if ($search) {
    $result = $conn->query("SELECT * FROM album WHERE nama_album LIKE '%$search%' ORDER BY id_album DESC");
} else {
    $result = $conn->query("SELECT * FROM album ORDER BY id_album DESC");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Album Beatvibes</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/album_admin.css" />
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
                    <button class="arrow"><i class="fa-solid fa-chevron-left" style="font-size: 17px; color: #110905; background : #a88f6B"></i></button>
                    <button class="arrow"><i class="fa-solid fa-chevron-right" style="font-size: 17px; color: #110905; background : #a88f6B"></i></button>
                </div>
                <div class="search">
                    <i class="fa-solid fa-magnifying-glass" style="font-size: 17px; color: #110905; background : #a88f6B"></i>
                    <form method="GET" action="Album_admin.php">
                        <input type="text" placeholder="Cari album" name="search" value="<?= htmlspecialchars($search) ?>" />
                    </form>
                </div>
                <div class="account">
                    <img src="Logo/logo.png" alt="Profile" class="profile-img">
                    <span>Admin</span>
                </div>
            </nav>

            <!-- Main Content Body -->
            <div class="main-content-body">
                <div class="main-content-body-up">
                    <h1>Trend This Week</h1>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <div class="album-grid-item">
                            <!-- Link ke halaman daftar lagu dengan album_id -->
                            <a href="daftar_lagu_admin.php?album_id=<?php echo $row['id_album']; ?>">
                                <img src="sampul/<?php echo $row['sampul_album']; ?>" alt="<?php echo $row['nama_album']; ?>" class="album">
                                <div class="album-info">
                                    <h2><?php echo $row['nama_album']; ?></h2>
                                    <p><?php echo $row['asal_daerah']; ?></p>
                                </div>
                            </a>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div> 
    </div>

    <script src="js/home.js" defer></script>
</body>
</html>

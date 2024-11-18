<?php
require 'koneksi.php';

if (isset($_GET['id_lagu'])) {
    $id_lagu = $_GET['id_lagu'];
} else {
    echo "<script>alert('ID Lagu tidak ditemukan!'); window.location.href = 'Album_Admin.php';</script>";
    exit;
}

$song_result = $conn->query("SELECT * FROM lagu WHERE id_lagu = '$id_lagu'");


// if ($song_result === false) {
//     echo "<script>alert('Query gagal dijalankan.'); window.location.href = 'daftar_lagu_admin.php';</script>";
//     exit;
// }

$song = $song_result->fetch_assoc();

// if (!$song) {
//     echo "<script>alert('Lagu tidak ditemukan!'); window.location.href = 'daftar_lagu_admin.php';</script>";
//     exit;
// }

// Mengambil data album untuk dropdown pilih album
$album_result = $conn->query("SELECT * FROM album");
if (isset($_POST['update_lagu'])) {
    // Mengambil data dari form
    $judul_lagu = $_POST['judul'];
    $asal_daerah = $_POST['asal_daerah'];
    $tanggal_rilis = $_POST['tanggal_lagu'];
    $lirik_lagu = $_POST['lirik'];
    $deskripsi = $_POST['deskripsi'];
    $id_album = $_POST['id_album'];

    // Cek jika ada file sampul baru yang diunggah
    if (!empty($_FILES['sampul']['name'])) {
        $file_sampul = $_FILES['sampul']['name'];
        $sampul_tmp = $_FILES['sampul']['tmp_name'];
        $upload_dir = 'sampul-lagu/';
        $sampul_path = $upload_dir . $file_sampul;

        // Hapus file sampul lama jika ada
        if (file_exists($upload_dir . $song['file_sampul'])) {
            unlink($upload_dir . $song['file_sampul']);
        }

        // Pindahkan file yang diunggah
        if (!move_uploaded_file($sampul_tmp, $sampul_path)) {
            echo "<script>alert('Gagal mengunggah sampul lagu.');</script>";
            exit;
        }
    } else {
        $file_sampul = $song['file_sampul']; // Jika tidak ada file baru, gunakan sampul lama
    }

    // Cek jika ada file lagu baru yang diunggah
    if (!empty($_FILES['lagu']['name'])) {
        $file_lagu = $_FILES['lagu']['name'];
        $lagu_tmp = $_FILES['lagu']['tmp_name'];
        $lagu_upload_dir = 'lagu/';
        $lagu_path = $lagu_upload_dir . $file_lagu;

        // Hapus file lagu lama jika ada
        if (file_exists($lagu_upload_dir . $song['file_lagu'])) {
            unlink($lagu_upload_dir . $song['file_lagu']);
        }

        // Pindahkan file yang diunggah
        if (!move_uploaded_file($lagu_tmp, $lagu_path)) {
            echo "<script>alert('Gagal mengunggah lagu.');</script>";
            exit;
        }
    } else {
        $file_lagu = $song['file_lagu']; // Jika tidak ada file baru, gunakan lagu lama
    }

    // Query untuk update data lagu
    $sql = "UPDATE lagu SET judul_lagu = ?, asal_daerah = ?, tanggal_rilis = ?, lirik_lagu = ?, deskripsi = ?, 
            file_sampul = ?, file_lagu = ?, id_album = ? WHERE id_lagu = ?";

    // Persiapkan statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param('ssssssssi', $judul_lagu, $asal_daerah, $tanggal_rilis, $lirik_lagu, $deskripsi, 
                         $file_sampul, $file_lagu, $id_album, $id_lagu);

        // Execute the query
        if ($stmt->execute()) {
            echo "<script>alert('Lagu berhasil diperbarui!'); window.location.href = 'Album_admin.php?id_album=$id_album';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui lagu.');</script>";
        }

        // Menutup statement
        $stmt->close();
    } else {
        echo "<script>alert('Gagal menyiapkan query untuk update lagu.');</script>";
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Lagu</title>
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
                <h1 style="color: #a88f6B; font-size:32px; margin-top: 7px;">Ubah Lagu</h1>
                <div class="account">
                    <img src="Logo/logo.png" alt="Profile" class="profile-img">
                    <span>Admin</span>
                </div>
            </nav>

            <!-- Main Content Body -->
            <div class="main-content-body">
                <main class="form">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="form-section">
                            <label for="judul">Judul Lagu</label>
                            <input type="text" id="judul" name="judul" placeholder="Judul lagu" required value="<?php echo htmlspecialchars($song['judul_lagu']); ?>">

                            <label for="asal_daerah">Asal Daerah</label>
                            <input type="text" id="asal_daerah" name="asal_daerah" placeholder="Asal daerah" required value="<?php echo htmlspecialchars($song['asal_daerah']); ?>">

                            <label for="tanggal_lagu">Tanggal Rilis</label>
                            <input type="date" id="tanggal_lagu" name="tanggal_lagu" required value="<?php echo htmlspecialchars($song['tanggal_rilis']); ?>">

                            <label for="id_album">Pilih Album</label>
                            <select id="id_album" name="id_album" required>
                                <?php while ($album = $album_result->fetch_assoc()): ?>
                                    <option value="<?php echo $album['id_album']; ?>" <?php echo $album['id_album'] == $song['id_album'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($album['nama_album']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>

                            <label for="sampul">Unggah Foto Sampul Lagu</label>
                            <div class="file-upload">
                                <label for="sampul" class="upload-btn">Unggah foto</label>
                                <span class="file-name"><?php echo $song['file_sampul'] ? $song['file_sampul'] : 'Tidak ada file dipilih'; ?></span>
                                <input type="file" id="sampul" name="sampul" accept="image/*">
                            </div>

                            <label for="lagu">Unggah File Lagu</label>
                            <div class="file-upload">
                                <label for="lagu" class="upload-btn">Unggah lagu</label>
                                <span class="file-name"><?php echo $song['file_lagu'] ? $song['file_lagu'] : 'Tidak ada file dipilih'; ?></span>
                                <input type="file" id="lagu" name="lagu" accept="audio/mpeg">
                            </div>
                        </div>

                        <div class="form-section">
                            <label for="lirik">Lirik Lagu</label>
                            <textarea name="lirik" id="lirik" placeholder="Tambahkan lirik" required><?php echo htmlspecialchars($song['lirik_lagu']); ?></textarea>

                            <label for="deskripsi">Deskripsi Lagu</label>
                            <textarea name="deskripsi" id="deskripsi" placeholder="Tambahkan deskripsi lagu" required><?php echo htmlspecialchars($song['deskripsi']); ?></textarea>
                        </div>

                        <div class="form-buttons">
                            <button type="submit" class="btn" name="update_lagu">Ubah</button>
                            <button type="button" class="btn" onclick="window.location.href='daftar_lagu_admin.php?id_album=<?php echo $song['id_album']; ?>'">Batal</button>
                        </div>
                    </form>
                </main>
            </div> 
        </div>
    </div>

    <script src="js/home.js" defer></script>
</body>
</html>

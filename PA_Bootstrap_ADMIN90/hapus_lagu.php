<?php
// Menghubungkan dengan database
require 'koneksi.php'; // Pastikan koneksi.php sudah ada

// Cek jika parameter 'id' ada di URL
if (isset($_GET['id'])) {
    $id_lagu = $_GET['id'];

    // Ambil informasi lagu dari database berdasarkan ID
    $result = $conn->query("SELECT * FROM lagu WHERE id_lagu = '$id_lagu'");

    if ($result->num_rows > 0) {
        $lagu = $result->fetch_assoc();
        
        // Hapus file sampul dan file lagu jika ada
        $sampul_path = 'sampul-lagu/' . $lagu['file_sampul'];
        $lagu_path = 'lagu/' . $lagu['file_lagu'];

        if (file_exists($sampul_path)) {
            unlink($sampul_path); // Hapus file sampul
        }

        if (file_exists($lagu_path)) {
            unlink($lagu_path); // Hapus file lagu
        }

        // Hapus data lagu dari database
        $delete_sql = "DELETE FROM lagu WHERE id_lagu = '$id_lagu'";

        if ($conn->query($delete_sql)) {
            // Jika berhasil dihapus, arahkan kembali ke halaman daftar lagu
            echo "<script>alert('Lagu berhasil dihapus!'); window.location.href = 'Album_admin.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus lagu: " . $conn->error . "'); window.location.href = 'daftar_lagu_admin.php';</script>";
        }
    } else {
        echo "<script>alert('Lagu tidak ditemukan!'); window.location.href = 'Album_admin.php';</script>";
    }
} else {
    echo "<script>alert('ID Lagu tidak ditemukan!'); window.location.href = 'Album_admin.php';</script>";
}

$conn->close(); // Tutup koneksi database
?>

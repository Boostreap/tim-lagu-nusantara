<?php
// Menghubungkan dengan database
require 'koneksi.php'; // Pastikan koneksi.php sudah ada

// Cek jika parameter 'id_hapus' ada di URL
if (isset($_GET['id_album'])) {
    $id_album = $_GET['id_album'];

    // Ambil informasi album dari database berdasarkan ID
    $result = $conn->query("SELECT * FROM album WHERE id_album = '$id_album'");

    if ($result->num_rows > 0) {
        $album = $result->fetch_assoc();
        
        // Hapus file sampul album jika ada
        $sampul_path = 'sampul-album/' . $album['file_sampul'];

        if (file_exists($sampul_path)) {
            unlink($sampul_path); // Hapus file sampul album
        }

        // Hapus data album dari database
        $delete_sql = "DELETE FROM album WHERE id_album = '$id_album'";

        if ($conn->query($delete_sql)) {
            // Jika berhasil dihapus, arahkan kembali ke halaman daftar album
            echo "<script>alert('Album berhasil dihapus!'); window.location.href = 'Album_admin.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus album: " . $conn->error . "'); window.location.href = 'Album_admin.php';</script>";
        }
    } else {
        echo "<script>alert('Album tidak ditemukan!'); window.location.href = 'Album_admin.php';</script>";
    }
} else {
    echo "<script>alert('ID Album tidak ditemukan!'); window.location.href = 'daftar_album_admin.php';</script>";
}

$conn->close(); // Tutup koneksi database
?>

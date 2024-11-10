-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Nov 2024 pada 07.57
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bootstrap_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bootstrap_tb`
--

CREATE TABLE `bootstrap_tb` (
  `id` int(255) NOT NULL,
  `Nama_pengguna` varchar(255) NOT NULL,
  `Nama` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Kata_sandi` varchar(255) NOT NULL,
  `Foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `bootstrap_tb`
--

INSERT INTO `bootstrap_tb` (`id`, `Nama_pengguna`, `Nama`, `Email`, `Kata_sandi`, `Foto`) VALUES
(19, 'iswan', 'iswansyah', 'iswansyahriani@gmail.com', '$2y$10$zEpiNAZuwcdG5qzlSr5zhOC0UY3qA/Z/xKkPA8XcWx0dNs23BkxwW', 'uploads/images (3).jpg');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bootstrap_tb`
--
ALTER TABLE `bootstrap_tb`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bootstrap_tb`
--
ALTER TABLE `bootstrap_tb`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

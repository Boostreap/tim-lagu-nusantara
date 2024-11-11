<?php
session_start();
require "koneksi.php";
if (isset($_SESSION["user"])) {
   header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-logo">
                <h2 id="formTitle">Masuk ke SuaraKita</h2>
            </div>
            <div class="have-acc">
                <p>Belum punya akun? <a href="Daftar.php">Daftar</a></p>
            </div>
            <?php
            if (isset($_POST["login"])) {
                $Nama_Pengguna = $_POST["Nama_Pengguna"];
                $Kata_Sandi = $_POST["Kata_Sandi"];
                
                if ($Nama_Pengguna === 'admin' && $password === 'admin123') {
                    // Simpan data admin di session
                    $_SESSION['user_id'] = 'admin';
                    $_SESSION['Nama_pengguna'] = 'admin';

                    echo "<script>
                            alert('Login sebagai Admin Berhasil');
                            window.location.href = 'Album_admin.php';
                        </script>";
                    exit();    
                }

                
                    

                require_once "Koneksi.php";
                $sql = "SELECT * FROM bootstrap_tb WHERE Nama_pengguna = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "s", $Nama_Pengguna);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
                // Pengecekan untuk admin
                
                if ($user) {
                    if (password_verify($Kata_Sandi, $user["Kata_sandi"])) {
                        $_SESSION["user"] = $Nama_Pengguna;
                        header("Location: beranda.php");
                        exit();
                    } else {
                        echo "<div class='alert alert-danger'>Kata sandi tidak cocok</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Nama Pengguna tidak ditemukan</div>";
                }
            }
            ?>

            <form id="dataForm" class="login-form" action="Masuk.php" method="POST" onsubmit="return validasiForm()"
                enctype="multipart/form-data" novalidate>
                <label for="Nama_Pengguna">Nama Pengguna</label>
                <input type="text" id="Nama_Pengguna" name="Nama_Pengguna" placeholder="Nama Pengguna" required>
                <p class="error-message">Nama Pengguna tidak boleh kosong.</p>

                <label for="Kata_Sandi">Kata Sandi</label>
                <input type="password" id="Kata_Sandi" name="Kata_Sandi" placeholder="Password" required>
                <p class="error-message">Kata Sandi tidak boleh kosong.</p>

                <div class="submit-container">
                    <button type="submit" name="login" class="submit-btn">Masuk</button>
                </div>
            </form>
        </div>
    </div>
    <script src="js/script.js"></script>

</body>

</html>
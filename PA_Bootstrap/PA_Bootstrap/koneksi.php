<?php
    $server = "localhost";
    $user = "root";
    $password = "";
    $db_name = "nusantara";

    $conn = mysqli_connect($server, $user, $password, $db_name);

    if(!$conn){
        die("Gagal Terhubung". mysqli_connect_error());
    }
?>
<?php

try {

    $koneksi = new PDO(
        "mysql:host=" . getenv('MYSQLHOST') .
        ";port=" . getenv('MYSQLPORT') .
        ";dbname=" . getenv('MYSQLDATABASE') .
        ";charset=utf8mb4",
        getenv('MYSQLUSER'),
        getenv('MYSQLPASSWORD')
    );

    $koneksi->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

} catch (PDOException $e) {

    die("Koneksi gagal: " . $e->getMessage());
}

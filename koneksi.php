<?php

$host = getenv('mysql.railway.internal');
$user = getenv('root');
$password = getenv('KaJYZOpVRPCbfWLaElIWjvsYWbSZUCpt');
$database = getenv('railway');
$port = getenv('3306');

$koneksi = mysqli_connect(
    $host,
    $user,
    $password,
    $database,
    $port
);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

<?php

include 'koneksi.php';

$id = $_POST['id'];
$nama_ruang = $_POST['nama_ruang'];
$lokasi = $_POST['lokasi'];
$kapasitas = $_POST['kapasitas'];

$query = mysqli_query(
    $koneksi,
    "UPDATE ruang SET

        nama_ruang = '$nama_ruang',
        lokasi = '$lokasi',
        kapasitas = '$kapasitas'

     WHERE id = '$id'"
);

if ($query) {

    echo json_encode([
        "success" => true,
        "message" => "Data ruang berhasil diupdate"
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Data ruang gagal diupdate"
    ]);
}
?>
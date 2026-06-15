<?php

include 'koneksi.php';
include 'auto_update_status.php';

$data = array();

$query = mysqli_query(
    $koneksi,
    "SELECT
        p.*,
        g.fakultas

     FROM peminjaman p

     LEFT JOIN ruang r
     ON p.nama_ruang = r.nama_ruang

     LEFT JOIN gedung g
     ON r.id_gedung = g.id

     ORDER BY p.id DESC"
);

while($row = mysqli_fetch_assoc($query)){
    $data[] = $row;
}

echo json_encode($data);

?>
<?php

include 'koneksi.php';

$data = array();

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM gedung"
);

while($row = mysqli_fetch_assoc($query)){
    $data[] = $row;
}

echo json_encode($data);

?>
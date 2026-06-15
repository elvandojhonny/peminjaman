<?php

include 'koneksi.php';

$stmt = $koneksi->prepare("
    SELECT * FROM users
    ORDER BY id DESC
");

$stmt->execute();

$result = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    $result[] = [

        "id"        => $row['id'],
        "nama"      => $row['nama'],
        "nim"       => $row['nim'],
        "email"     => $row['email'],
        "prodi"     => $row['prodi'],
        "fakultas"  => $row['fakultas'],
        "no_hp"     => $row['no_hp'],
        "alamat"    => $row['alamat'],

        "username"  => $row['username'],
        "password"  => $row['password'],
        "role"      => $row['role']
    ];
}

echo json_encode($result);
?>

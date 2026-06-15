<?php

include 'koneksi.php';

$id       = $_POST['id'] ?? '';
$nama     = $_POST['nama'] ?? '';
$nim      = $_POST['nim'] ?? '';
$email    = $_POST['email'] ?? '';
$prodi    = $_POST['prodi'] ?? '';
$fakultas = $_POST['fakultas'] ?? '';
$no_hp    = $_POST['no_hp'] ?? '';
$alamat   = $_POST['alamat'] ?? '';

$username = $email;
$password = $_POST['password'] ?? '';
$role     = $_POST['role'] ?? '';

try {

    if ($password != "") {

        $hashedPassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $stmt = $koneksi->prepare("
            UPDATE users SET
                nama = ?,
                nim = ?,
                email = ?,
                prodi = ?,
                fakultas = ?,
                no_hp = ?,
                alamat = ?,
                username = ?,
                password = ?,
                role = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $nama,
            $nim,
            $email,
            $prodi,
            $fakultas,
            $no_hp,
            $alamat,
            $username,
            $hashedPassword,
            $role,
            $id
        ]);

    } else {

        $stmt = $koneksi->prepare("
            UPDATE users SET
                nama = ?,
                nim = ?,
                email = ?,
                prodi = ?,
                fakultas = ?,
                no_hp = ?,
                alamat = ?,
                username = ?,
                role = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $nama,
            $nim,
            $email,
            $prodi,
            $fakultas,
            $no_hp,
            $alamat,
            $username,
            $role,
            $id
        ]);
    }

    echo json_encode([
        "success" => true,
        "message" => "Berhasil diupdate"
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}

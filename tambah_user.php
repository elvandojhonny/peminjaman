<?php

include 'koneksi.php';

$nama      = $_POST['nama'] ?? '';
$nim       = $_POST['nim'] ?? '';
$email     = $_POST['email'] ?? '';
$prodi     = $_POST['prodi'] ?? '';
$fakultas  = $_POST['fakultas'] ?? '';
$no_hp     = $_POST['no_hp'] ?? '';
$alamat    = $_POST['alamat'] ?? '';
$username  = $email;
$password  = $_POST['password'] ?? '';
$role      = $_POST['role'] ?? '';

$hashedPassword = password_hash(
    $password,
    PASSWORD_DEFAULT
);

try {

    $cek = $koneksi->prepare("
        SELECT id
        FROM users
        WHERE email = ?
    ");

    $cek->execute([$email]);

    if ($cek->rowCount() > 0) {

        echo json_encode([
            "success" => false,
            "message" => "Email sudah digunakan"
        ]);

        exit;
    }

    $stmt = $koneksi->prepare("
        INSERT INTO users
        (
            nama,
            nim,
            email,
            prodi,
            fakultas,
            no_hp,
            alamat,
            username,
            password,
            role
        )
        VALUES
        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
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
        $role
    ]);

    echo json_encode([
        "success" => true,
        "message" => "User berhasil ditambahkan"
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>

<?php

header('Content-Type: application/json');

include 'koneksi.php';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

try {

    $stmt = $pdo->prepare(
        "SELECT * FROM users WHERE email = ?"
    );

    $stmt->execute([$email]);

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data) {

        if (password_verify($password, $data['password'])) {

            echo json_encode([

                "success" => true,
                "message" => "Login berhasil",

                "id" => $data['id'],

                "nama" => $data['nama'],
                "nim" => $data['nim'],
                "email" => $data['email'],
                "prodi" => $data['prodi'],
                "fakultas" => $data['fakultas'],
                "no_hp" => $data['no_hp'],
                "alamat" => $data['alamat'],

                "username" => $data['username'],
                "role" => $data['role']

            ]);

        } else {

            echo json_encode([
                "success" => false,
                "message" => "Password salah"
            ]);
        }

    } else {

        echo json_encode([
            "success" => false,
            "message" => "Email tidak ditemukan"
        ]);
    }

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}

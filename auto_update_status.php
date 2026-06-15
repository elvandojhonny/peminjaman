<?php

date_default_timezone_set('Asia/Makassar');

if (!function_exists('convertTanggalIndonesia')) {

    function convertTanggalIndonesia($tanggal)
    {
        $bulan = [
            "Januari" => "01",
            "Februari" => "02",
            "Maret" => "03",
            "April" => "04",
            "Mei" => "05",
            "Juni" => "06",
            "Juli" => "07",
            "Agustus" => "08",
            "September" => "09",
            "Oktober" => "10",
            "November" => "11",
            "Desember" => "12"
        ];

        $pecah = explode(" ", trim($tanggal));

        if (count($pecah) != 3) {
            return null;
        }

        $hari = sprintf("%02d", (int)$pecah[0]);

        if (!isset($bulan[$pecah[1]])) {
            return null;
        }

        return
            $pecah[2] . "-" .
            $bulan[$pecah[1]] . "-" .
            $hari;
    }
}

$stmt = $koneksi->query("
    SELECT *
    FROM peminjaman
    WHERE LOWER(status) IN ('disetujui','digunakan')
");

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    $tanggalMysql =
        convertTanggalIndonesia($row['tanggal']);

    if (!$tanggalMysql) {
        continue;
    }

    $waktuMulai = strtotime(
        $tanggalMysql . " " . $row['jam_mulai']
    );

    $waktuSelesai = strtotime(
        $tanggalMysql . " " . $row['jam_selesai']
    );

    $sekarang = time();

    // DISSETUJUI -> DIGUNAKAN

    if (
        strtolower($row['status']) == 'disetujui'
        &&
        $sekarang >= $waktuMulai
        &&
        $sekarang < $waktuSelesai
    ) {

        $update = $koneksi->prepare("
            UPDATE peminjaman
            SET status='Digunakan'
            WHERE id=?
        ");

        $update->execute([$row['id']]);
    }

    // DIGUNAKAN -> SELESAI

    if (
        $sekarang >= $waktuSelesai
    ) {

        $update = $koneksi->prepare("
            UPDATE peminjaman
            SET status='Selesai'
            WHERE id=?
        ");

        $update->execute([$row['id']]);
    }
}

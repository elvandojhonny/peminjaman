<?php

include 'koneksi.php';

if ($koneksi) {
    echo "DB OK";
} else {
    echo "DB GAGAL";
}

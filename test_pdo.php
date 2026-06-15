<?php

try {

    $pdo = new PDO(
        "mysql:host=" . getenv('MYSQLHOST') .
        ";port=" . getenv('MYSQLPORT') .
        ";dbname=" . getenv('MYSQLDATABASE'),
        getenv('MYSQLUSER'),
        getenv('MYSQLPASSWORD')
    );

    echo "DB CONNECTED";

} catch (PDOException $e) {

    echo "ERROR: " . $e->getMessage();

}

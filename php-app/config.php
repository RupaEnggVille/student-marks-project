<?php

$host = "mysql";
$user = "root";
$password = "root";
$database = "studentdb";

$conn = null;

for ($i = 0; $i < 10; $i++) {

    $conn = mysqli_connect($host, $user, $password, $database);

    if ($conn) {
        break;
    }

    sleep(2);
}

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

?>

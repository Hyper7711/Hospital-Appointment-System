<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "hospital_opd_db";
$port = 3307;

$conn = mysqli_connect($host, $user, $password, $database, $port);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

?>
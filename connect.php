<?php
header('Content-Type: text/html; charset=utf-8');

$servername = "127.0.0.1";
$username = "root";
$password = "";
$basename = "sopitas";
$port = 3307;

$dbc = mysqli_connect($servername, $username, $password, $basename, $port);

if (!$dbc) {
    die("Greška pri spajanju na bazu: " . mysqli_connect_error());
}

mysqli_set_charset($dbc, "utf8mb4");
?>
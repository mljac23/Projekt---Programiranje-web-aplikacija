<?php
include 'connect.php';

if (isset($_POST['submit'])) {

    $naslov = mysqli_real_escape_string($dbc, $_POST['naslov']);
    $kategorija = mysqli_real_escape_string($dbc, $_POST['kategorija']);
    $sazetak = mysqli_real_escape_string($dbc, $_POST['sazetak']);
    $tekst = mysqli_real_escape_string($dbc, $_POST['tekst']);
    $datum = date('d.m.Y.');
    $arhiva = isset($_POST['arhiva']) ? 1 : 0;

    $slika = $_FILES['slika']['name'];
    $slika_tmp = $_FILES['slika']['tmp_name'];

    $target_dir = "img/" . basename($slika);

    move_uploaded_file($slika_tmp, $target_dir);

    $query = "INSERT INTO vijesti 
              (datum, naslov, sazetak, tekst, slika, kategorija, arhiva)
              VALUES
              ('$datum', '$naslov', '$sazetak', '$tekst', '$slika', '$kategorija', '$arhiva')";

    $result = mysqli_query($dbc, $query) or die("Greška pri unosu u bazu: " . mysqli_error($dbc));

    mysqli_close($dbc);

    header("Location: uspjesno.php");
    exit;
} else {
    header("Location: administracija.php");
    exit;
}
?>
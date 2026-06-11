<?php

if (isset($_POST['submit'])) {

    $naslov = trim($_POST['naslov']);
    $kategorija = trim($_POST['kategorija']);
    $datum = trim($_POST['datum']);
    $slika = trim($_POST['slika']);
    $sazetak = trim($_POST['sazetak']);
    $tekst = trim($_POST['tekst']);

    if (
        empty($naslov) ||
        empty($kategorija) ||
        empty($datum) ||
        empty($slika) ||
        empty($sazetak) ||
        empty($tekst)
    ) {
        echo "Sva polja moraju biti popunjena.";
        echo "<br><a href='administracija.php'>Vrati se na formu</a>";
        exit;
    }

} else {
    header("Location: administracija.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Pregled unesene vijesti</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <div class="header-content">
        <img src="img/logo.png" alt="Logo" class="logo">

        <nav>
            <a href="index.html">POČETNA</a>
            <a href="index.html#glazba">GLAZBA</a>
            <a href="index.html#sport">SPORT</a>
            <a href="administracija.php">ADMINISTRACIJA</a>
        </nav>
    </div>
</header>

<main class="article-container">

    <img src="img/<?php echo htmlspecialchars($slika); ?>" alt="Slika vijesti" class="article-image">

    <h1><?php echo htmlspecialchars($naslov); ?></h1>

    <p class="date">
        <?php echo htmlspecialchars($datum); ?> | 
        <?php echo htmlspecialchars($kategorija); ?>
    </p>

    <p>
        <strong>Kratki sadržaj:</strong>
        <?php echo htmlspecialchars($sazetak); ?>
    </p>

    <p>
        <?php echo nl2br(htmlspecialchars($tekst)); ?>
    </p>

    <br>

    <form action="uspjesno.php" method="POST">
        <input type="hidden" name="naslov" value="<?php echo htmlspecialchars($naslov); ?>">
        <input type="hidden" name="kategorija" value="<?php echo htmlspecialchars($kategorija); ?>">
        <input type="hidden" name="datum" value="<?php echo htmlspecialchars($datum); ?>">
        <input type="hidden" name="slika" value="<?php echo htmlspecialchars($slika); ?>">
        <input type="hidden" name="sazetak" value="<?php echo htmlspecialchars($sazetak); ?>">
        <input type="hidden" name="tekst" value="<?php echo htmlspecialchars($tekst); ?>">

        <button type="submit">Potvrdi unos</button>
    </form>

</main>

<footer>
    <p>Autor: Stjepan Antunović | Email: stjepan.antunovic.06@gmail.com | 2026.</p>
</footer>

</body>
</html>
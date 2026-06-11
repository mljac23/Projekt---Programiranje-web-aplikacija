<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Uspješan unos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="site-header">
    <div class="header-inner">

        <a href="index.php" class="logo">
            <img src="img/logo.png" alt="Sopitas logo">
        </a>

        <nav class="navigation" aria-label="Glavna navigacija">
            <ul>
                <li><a href="index.php">POČETNA</a></li>
                <li><a href="kategorija.php?kategorija=Glazba">GLAZBA</a></li>
                <li><a href="kategorija.php?kategorija=Sport">SPORT</a></li>
                <li><a href="administracija.php">UNOS VIJESTI</a></li>
                <li><a href="administrator.php">UREĐIVANJE</a></li>
            </ul>
        </nav>

    </div>
</header>

<main class="content">

    <section class="category category-sport">
        <div class="category-title-row">
            <h2>USPJEŠNO</h2>
            <span></span>
        </div>

        <div class="success-box">
            <h1>Vijest je uspješno spremljena u bazu!</h1>

            <a href="administracija.php" class="back-link">Unesi novu vijest</a>
            <br><br>
            <a href="index.php" class="back-link">Vrati se na početnu</a>
            <br><br>
            <a href="administrator.php" class="back-link">Uredi ili izbriši vijesti</a>
        </div>
    </section>

</main>

<footer class="site-footer">
    <p>2026.</p>
</footer>

</body>
</html>
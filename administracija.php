<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Administracija</title>
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
                <li><a href="login.php">LOGIN</a></li>
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
            <h2>ADMINISTRACIJA</h2>
            <span></span>
        </div>

        <form action="skripta.php" method="POST" enctype="multipart/form-data" class="admin-form">

            <label for="naslov">Naslov vijesti:</label>
            <input type="text" id="naslov" name="naslov" required>

            <label for="kategorija">Kategorija:</label>
            <select id="kategorija" name="kategorija" required>
                <option value="">Odaberi kategoriju</option>
                <option value="Glazba">Glazba</option>
                <option value="Sport">Sport</option>
            </select>

            <label for="slika">Slika vijesti:</label>
            <input type="file" id="slika" name="slika" accept="image/*" required>

            <label for="sazetak">Kratki sadržaj:</label>
            <textarea id="sazetak" name="sazetak" rows="4" required></textarea>

            <label for="tekst">Tekst vijesti:</label>
            <textarea id="tekst" name="tekst" rows="8" required></textarea>

            <label>
                <input type="checkbox" name="arhiva">
                Spremi u arhivu
            </label>

            <button type="submit" name="submit">Spremi vijest</button>

        </form>
    </section>

</main>

<footer class="site-footer">
    <p>2026.</p>
</footer>

</body>
</html>
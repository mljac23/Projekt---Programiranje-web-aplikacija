<?php
include 'connect.php';

define('UPLPATH', 'img/');

$query_glazba = "SELECT * FROM vijesti 
                 WHERE arhiva = 0 AND kategorija = 'Glazba' 
                 ORDER BY id DESC 
                 LIMIT 3";

$result_glazba = mysqli_query($dbc, $query_glazba) 
    or die("Greška kod dohvaćanja glazbenih vijesti: " . mysqli_error($dbc));

$query_sport = "SELECT * FROM vijesti 
                WHERE arhiva = 0 AND kategorija = 'Sport' 
                ORDER BY id DESC 
                LIMIT 3";

$result_sport = mysqli_query($dbc, $query_sport) 
    or die("Greška kod dohvaćanja sportskih vijesti: " . mysqli_error($dbc));
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sopitas - News portal</title>
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
                <li><a href="login.php">LOGIN</a></li>
                <li><a href="logout.php">ODJAVA</a></li>
            </ul>
        </nav>

    </div>
</header>

<main class="content">

    <section id="glazba" class="category category-music">
        <div class="category-title-row">
            <h2>GLAZBA</h2>
            <span></span>
        </div>

        <div class="article-grid">

            <?php
            if (mysqli_num_rows($result_glazba) > 0) {
                while ($row = mysqli_fetch_array($result_glazba)) {
                    echo '<article class="card">';
                    echo '<a href="clanak.php?id=' . $row['id'] . '" class="image-link">';
                    echo '<img src="' . UPLPATH . htmlspecialchars($row['slika']) . '" alt="' . htmlspecialchars($row['naslov']) . '">';
                    echo '</a>';

                    echo '<h3>';
                    echo '<a href="clanak.php?id=' . $row['id'] . '">';
                    echo htmlspecialchars($row['naslov']);
                    echo '</a>';
                    echo '</h3>';

                    echo '<p class="date">' . htmlspecialchars($row['datum']) . '</p>';
                    echo '</article>';
                }
            } else {
                echo '<p>Nema unesenih vijesti u kategoriji Glazba.</p>';
            }
            ?>

        </div>
    </section>

    <section id="sport" class="category category-sport">
        <div class="category-title-row">
            <h2>SPORT</h2>
            <span></span>
        </div>

        <div class="article-grid">

            <?php
            if (mysqli_num_rows($result_sport) > 0) {
                while ($row = mysqli_fetch_array($result_sport)) {
                    echo '<article class="card">';
                    echo '<a href="clanak.php?id=' . $row['id'] . '" class="image-link">';
                    echo '<img src="' . UPLPATH . htmlspecialchars($row['slika']) . '" alt="' . htmlspecialchars($row['naslov']) . '">';
                    echo '</a>';

                    echo '<h3>';
                    echo '<a href="clanak.php?id=' . $row['id'] . '">';
                    echo htmlspecialchars($row['naslov']);
                    echo '</a>';
                    echo '</h3>';

                    echo '<p class="date">' . htmlspecialchars($row['datum']) . '</p>';
                    echo '</article>';
                }
            } else {
                echo '<p>Nema unesenih vijesti u kategoriji Sport.</p>';
            }

            mysqli_close($dbc);
            ?>

        </div>
    </section>

</main>

<footer class="site-footer">
    <p>2026.</p>
</footer>

</body>
</html>
<?php
include 'connect.php';

define('UPLPATH', 'img/');

if (isset($_GET['kategorija'])) {
    $kategorija = mysqli_real_escape_string($dbc, $_GET['kategorija']);
} else {
    header("Location: index.php");
    exit;
}

$query = "SELECT * FROM vijesti 
          WHERE arhiva = 0 AND kategorija = '$kategorija'
          ORDER BY id DESC";

$result = mysqli_query($dbc, $query) 
    or die("Greška kod dohvaćanja vijesti: " . mysqli_error($dbc));
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($kategorija); ?> - Sopitas</title>
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

    <section class="category <?php echo ($kategorija == 'Glazba') ? 'category-music' : 'category-sport'; ?>">
        <div class="category-title-row">
            <h2><?php echo strtoupper(htmlspecialchars($kategorija)); ?></h2>
            <span></span>
        </div>

        <div class="article-grid">

            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
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
                echo '<p>Nema unesenih vijesti u ovoj kategoriji.</p>';
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
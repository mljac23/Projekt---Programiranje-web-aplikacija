<?php
include 'connect.php';

define('UPLPATH', 'img/');

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
} else {
    header("Location: index.php");
    exit;
}

$query = "SELECT * FROM vijesti WHERE id = $id";
$result = mysqli_query($dbc, $query) 
    or die("Greška kod dohvaćanja članka: " . mysqli_error($dbc));

if (mysqli_num_rows($result) == 0) {
    header("Location: index.php");
    exit;
}

$row = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($row['naslov']); ?></title>
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

<main class="article-container">

    <img 
        src="<?php echo UPLPATH . htmlspecialchars($row['slika']); ?>" 
        alt="<?php echo htmlspecialchars($row['naslov']); ?>" 
        class="article-image"
    >

    <h1><?php echo htmlspecialchars($row['naslov']); ?></h1>

    <p class="date">
        <?php echo htmlspecialchars($row['datum']); ?> |
        <?php echo htmlspecialchars($row['kategorija']); ?>
    </p>

    <p>
        <strong>
            <?php echo htmlspecialchars($row['sazetak']); ?>
        </strong>
    </p>

    <p>
        <?php echo nl2br(htmlspecialchars($row['tekst'])); ?>
    </p>

    <br>

    <a href="index.php" class="back-link">Vrati se na početnu</a>

</main>

<footer class="site-footer">
    <p>2026.</p>
</footer>

</body>
</html>

<?php
mysqli_close($dbc);
?>
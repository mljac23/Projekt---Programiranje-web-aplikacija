<?php
session_start();

if (!isset($_SESSION['korisnicko_ime'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['razina'] != 1) {
    echo '<!DOCTYPE html>
    <html lang="hr">
    <head>
        <meta charset="UTF-8">
        <title>Nema pristupa</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>

    <header class="site-header">
        <div class="header-inner">
            <a href="index.php" class="logo">
                <img src="img/logo.png" alt="Sopitas logo">
            </a>

            <nav class="navigation">
                <ul>
                    <li><a href="index.php">POČETNA</a></li>
                    <li><a href="kategorija.php?kategorija=Glazba">GLAZBA</a></li>
                    <li><a href="kategorija.php?kategorija=Sport">SPORT</a></li>
                    <li><a href="logout.php">ODJAVA</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="content">
        <section class="category category-sport">
            <div class="category-title-row">
                <h2>NEMA PRISTUPA</h2>
                <span></span>
            </div>

            <div class="success-box">
                <h1>Bok ' . htmlspecialchars($_SESSION['ime']) . '!</h1>
                <p>Uspješno ste prijavljeni, ali nemate administratorska prava za pristup ovoj stranici.</p>
                <br>
                <a href="index.php" class="back-link">Vrati se na početnu</a>
                <br><br>
                <a href="logout.php" class="back-link">Odjava</a>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <p>2026.</p>
    </footer>

    </body>
    </html>';
    exit;
}

include 'connect.php';

define('UPLPATH', 'img/');

/* BRISANJE VIJESTI */
if (isset($_POST['delete'])) {
    $id = (int) $_POST['id'];

    $sql = "DELETE FROM vijesti WHERE id = ?";
    $stmt = mysqli_stmt_init($dbc);

    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
    }

    header("Location: administrator.php");
    exit;
}

/* UREĐIVANJE VIJESTI */
if (isset($_POST['update'])) {
    $id = (int) $_POST['id'];

    $naslov = $_POST['naslov'];
    $sazetak = $_POST['sazetak'];
    $tekst = $_POST['tekst'];
    $kategorija = $_POST['kategorija'];
    $arhiva = isset($_POST['arhiva']) ? 1 : 0;
    $stara_slika = $_POST['stara_slika'];

    if (!empty($_FILES['slika']['name'])) {
        $slika = basename($_FILES['slika']['name']);
        $slika_tmp = $_FILES['slika']['tmp_name'];
        $target_dir = "img/" . $slika;

        move_uploaded_file($slika_tmp, $target_dir);
    } else {
        $slika = $stara_slika;
    }

    $sql = "UPDATE vijesti 
            SET naslov = ?, 
                sazetak = ?, 
                tekst = ?, 
                slika = ?, 
                kategorija = ?, 
                arhiva = ?
            WHERE id = ?";

    $stmt = mysqli_stmt_init($dbc);

    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param(
            $stmt,
            "sssssii",
            $naslov,
            $sazetak,
            $tekst,
            $slika,
            $kategorija,
            $arhiva,
            $id
        );

        mysqli_stmt_execute($stmt);
    }

    header("Location: administrator.php");
    exit;
}

/* DOHVAT SVIH VIJESTI */
$query = "SELECT * FROM vijesti ORDER BY id DESC";
$result = mysqli_query($dbc, $query) or die("Greška kod dohvaćanja vijesti: " . mysqli_error($dbc));
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Uređivanje vijesti</title>
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
                <li><a href="logout.php">ODJAVA</a></li>
            </ul>
        </nav>

    </div>
</header>

<main class="content">

    <section class="category category-sport">
        <div class="category-title-row">
            <h2>UREĐIVANJE VIJESTI</h2>
            <span></span>
        </div>

        <div class="success-box">
            <p>
                Prijavljeni ste kao:
                <strong><?php echo htmlspecialchars($_SESSION['korisnicko_ime']); ?></strong>
            </p>
            <p>Imate administratorska prava.</p>
        </div>

        <?php if (mysqli_num_rows($result) == 0): ?>

            <div class="success-box">
                <p>Trenutno nema vijesti u bazi.</p>
                <br>
                <a href="administracija.php" class="back-link">Unesi prvu vijest</a>
            </div>

        <?php else: ?>

            <?php while ($row = mysqli_fetch_array($result)): ?>

                <form action="administrator.php" method="POST" enctype="multipart/form-data" class="admin-form">

                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="hidden" name="stara_slika" value="<?php echo htmlspecialchars($row['slika']); ?>">

                    <label for="naslov_<?php echo $row['id']; ?>">Naslov vijesti:</label>
                    <input 
                        type="text" 
                        id="naslov_<?php echo $row['id']; ?>" 
                        name="naslov" 
                        value="<?php echo htmlspecialchars($row['naslov']); ?>" 
                        required
                    >

                    <label for="sazetak_<?php echo $row['id']; ?>">Kratki sadržaj:</label>
                    <textarea 
                        id="sazetak_<?php echo $row['id']; ?>" 
                        name="sazetak" 
                        rows="4" 
                        required><?php echo htmlspecialchars($row['sazetak']); ?></textarea>

                    <label for="tekst_<?php echo $row['id']; ?>">Tekst vijesti:</label>
                    <textarea 
                        id="tekst_<?php echo $row['id']; ?>" 
                        name="tekst" 
                        rows="8" 
                        required><?php echo htmlspecialchars($row['tekst']); ?></textarea>

                    <label>Trenutna slika:</label>

                    <?php if (!empty($row['slika'])): ?>
                        <img 
                            src="<?php echo UPLPATH . htmlspecialchars($row['slika']); ?>" 
                            alt="<?php echo htmlspecialchars($row['naslov']); ?>" 
                            style="width: 160px; height: auto; margin-bottom: 10px;"
                        >
                    <?php else: ?>
                        <p>Nema slike.</p>
                    <?php endif; ?>

                    <label for="slika_<?php echo $row['id']; ?>">Promijeni sliku:</label>
                    <input 
                        type="file" 
                        id="slika_<?php echo $row['id']; ?>" 
                        name="slika" 
                        accept="image/*"
                    >

                    <label for="kategorija_<?php echo $row['id']; ?>">Kategorija:</label>
                    <select id="kategorija_<?php echo $row['id']; ?>" name="kategorija" required>
                        <option value="Glazba" <?php if ($row['kategorija'] == 'Glazba') echo 'selected'; ?>>
                            Glazba
                        </option>
                        <option value="Sport" <?php if ($row['kategorija'] == 'Sport') echo 'selected'; ?>>
                            Sport
                        </option>
                    </select>

                    <label>
                        <input 
                            type="checkbox" 
                            name="arhiva" 
                            <?php if ($row['arhiva'] == 1) echo 'checked'; ?>
                        >
                        Spremi u arhivu
                    </label>

                    <button type="submit" name="update">Izmijeni</button>

                    <button 
                        type="submit" 
                        name="delete" 
                        onclick="return confirm('Jesi li siguran da želiš obrisati ovu vijest?');"
                    >
                        Izbriši
                    </button>

                </form>

            <?php endwhile; ?>

        <?php endif; ?>

    </section>

</main>

<footer class="site-footer">
    <p>2026.</p>
</footer>

</body>
</html>

<?php
mysqli_close($dbc);
?>
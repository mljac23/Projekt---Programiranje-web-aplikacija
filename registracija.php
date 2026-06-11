<?php
include 'connect.php';

$msg = "";
$registriranKorisnik = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $ime = trim($_POST['ime']);
    $prezime = trim($_POST['prezime']);
    $username = trim($_POST['username']);
    $pass = $_POST['pass'];
    $passRep = $_POST['passRep'];

    if (empty($ime) || empty($prezime) || empty($username) || empty($pass) || empty($passRep)) {
        $msg = "Sva polja moraju biti popunjena.";
    } elseif ($pass !== $passRep) {
        $msg = "Lozinke nisu iste.";
    } else {

        $sql = "SELECT korisnicko_ime FROM korisnik WHERE korisnicko_ime = ?";
        $stmt = mysqli_stmt_init($dbc);

        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
        }

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $msg = "Korisničko ime već postoji.";
        } else {
            $hashed_password = password_hash($pass, PASSWORD_BCRYPT);
            $razina = 0;

            $sql = "INSERT INTO korisnik (ime, prezime, korisnicko_ime, lozinka, razina)
                    VALUES (?, ?, ?, ?, ?)";

            $stmt = mysqli_stmt_init($dbc);

            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssssi", $ime, $prezime, $username, $hashed_password, $razina);
                mysqli_stmt_execute($stmt);
                $registriranKorisnik = true;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Registracija</title>
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
                <li><a href="administracija.php">UNOS VIJESTI</a></li>
                <li><a href="login.php">LOGIN</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="content">

    <section class="category category-sport">
        <div class="category-title-row">
            <h2>REGISTRACIJA</h2>
            <span></span>
        </div>

        <div class="success-box">
            <?php if ($registriranKorisnik): ?>
                <h1>Uspješna registracija!</h1>
                <p>Korisnik je uspješno registriran.</p>
                <br>
                <a href="login.php" class="back-link">Idi na prijavu</a>
            <?php else: ?>

                <?php if (!empty($msg)): ?>
                    <p style="color: red; font-weight: bold;"><?php echo htmlspecialchars($msg); ?></p>
                    <br>
                <?php endif; ?>

                <form action="registracija.php" method="POST" class="admin-form">

                    <label for="ime">Ime:</label>
                    <input type="text" id="ime" name="ime" required>

                    <label for="prezime">Prezime:</label>
                    <input type="text" id="prezime" name="prezime" required>

                    <label for="username">Korisničko ime:</label>
                    <input type="text" id="username" name="username" required>

                    <label for="pass">Lozinka:</label>
                    <input type="password" id="pass" name="pass" required>

                    <label for="passRep">Ponovi lozinku:</label>
                    <input type="password" id="passRep" name="passRep" required>

                    <button type="submit">Registriraj se</button>

                </form>

            <?php endif; ?>
        </div>
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
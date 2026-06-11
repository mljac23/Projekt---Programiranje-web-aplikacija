<?php
session_start();
include 'connect.php';

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $lozinka = $_POST['lozinka'];

    $sql = "SELECT id, ime, korisnicko_ime, lozinka, razina 
            FROM korisnik 
            WHERE korisnicko_ime = ?";

    $stmt = mysqli_stmt_init($dbc);

    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $id, $ime, $korisnicko_ime, $lozinka_hash, $razina);
        mysqli_stmt_fetch($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0 && password_verify($lozinka, $lozinka_hash)) {

            $_SESSION['korisnik_id'] = $id;
            $_SESSION['ime'] = $ime;
            $_SESSION['korisnicko_ime'] = $korisnicko_ime;
            $_SESSION['razina'] = $razina;

            if ($razina == 1) {
                header("Location: administrator.php");
                exit;
            } else {
                $msg = "Bok " . htmlspecialchars($ime) . ", uspješno ste prijavljeni, ali nemate administratorska prava.";
            }

        } else {
            $msg = "Neispravno korisničko ime ili lozinka. Morate se prvo registrirati.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Prijava</title>
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
                <li><a href="registracija.php">REGISTRACIJA</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="content">

    <section class="category category-sport">
        <div class="category-title-row">
            <h2>PRIJAVA</h2>
            <span></span>
        </div>

        <div class="success-box">

            <?php if (!empty($msg)): ?>
                <p style="color: red; font-weight: bold;"><?php echo $msg; ?></p>
                <br>
                <?php if (strpos($msg, "registrirati") !== false): ?>
                    <a href="registracija.php" class="back-link">Registriraj se</a>
                    <br><br>
                <?php endif; ?>
            <?php endif; ?>

            <form action="login.php" method="POST" class="admin-form">

                <label for="username">Korisničko ime:</label>
                <input type="text" id="username" name="username" required>

                <label for="lozinka">Lozinka:</label>
                <input type="password" id="lozinka" name="lozinka" required>

                <button type="submit" name="prijava">Prijavi se</button>

            </form>

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
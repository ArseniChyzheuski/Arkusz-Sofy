<?php
$conn = mysqli_connect("localhost", "root", "", "antyki");
if (isset($_POST['kup'])) {
    $id = $_POST['kup'];
    mysqli_query($conn, "INSERT INTO zakupy (idKlienci, idMeble, sztuk) VALUES (1, $id, 1)");
}
function pokazMeble($conn, $kategoria, $folder) {
    $sql = "SELECT idMeble, nazwa, plik, styl, cena, opis FROM meble WHERE kategoria = $kategoria";
    $wynik = mysqli_query($conn, $sql);

    while ($wiersz = mysqli_fetch_array($wynik)) {
        echo "<div class='mebel'>";

        echo "<img class='obraz' src='$folder/" . $wiersz['plik'] . "' alt='mebel'>";

        echo "<div>";
        echo "<h3>" . $wiersz['nazwa'] . "</h3>";
        echo "<h4>styl " . $wiersz['styl'] . "</h4>";
        echo "<h3>CENA: " . $wiersz['cena'] . " zł</h3>";

        echo "<form method='post'>";
        echo "<button name='kup' value='" . $wiersz['idMeble'] . "'>KUP</button>";
        echo "</form>";
        echo "</div>";

        echo "<p class='opis'>" . $wiersz['opis'] . "</p>";
        echo "</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Sprzedaż antyków</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>
<header>
    <h1>Najlepsze antyki w mieście</h1>
</header>
<main>
    <section>
        <h2>- Sofy -</h2>
        <?php pokazMeble($conn, 1, "sofy"); ?>
        <h2>- Fotele -</h2>
        <?php pokazMeble($conn, 2, "fotele"); ?>
        <h2>- Komody -</h2>
        <?php pokazMeble($conn, 3, "komody"); ?>
    </section>
    <aside>
        <h2>Koszyk</h2>
        <p>Zalogowano: Anna Kowalska</p>
        <?php
        $sql = "SELECT meble.nazwa, meble.cena
                FROM meble
                JOIN zakupy ON meble.idMeble = zakupy.idMeble
                WHERE zakupy.idKlienci = 1";
        $wynik = mysqli_query($conn, $sql);
        $koszt = 0;
        echo "<ol>";
        while ($wiersz = mysqli_fetch_array($wynik)) {
            echo "<li>" . $wiersz['nazwa'] . ", cena: " . $wiersz['cena'] . "</li>";
            $koszt += $wiersz['cena'];
        }
        echo "</ol>";
        echo "<p>Koszt całkowity: " . $koszt . "</p>";
        ?>
    </aside>
</main>
<footer>
    <p>Stronę wykonał: Arseni</p>
</footer>
</body>
</html>
<?php
mysqli_close($conn);
?>

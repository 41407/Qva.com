<?php

try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=jiji", "jiji", "argh");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$kysely = $yhteys->prepare(
        "select COUNT(kuvaid) from kuva where kayttajanimi = ?");
$kysely->execute(array($_GET['avain']));
$summa = $kysely->fetch();

// Kysellään mitä kuvia löytyy, uutuusjärjestyksessä
$kysely = $yhteys->prepare(
        "SELECT kuvaid, kayttajanimi FROM kuva WHERE kayttajanimi = ? ORDER BY julkaisuaika DESC");
$kysely->execute(array($_GET['avain']));

echo '<h1>';
echo 'Käyttäjän ' . $_GET['avain'] . ' lisäämät kuvat</h1><p>';
if ($summa["count"] > 0) {
    echo 'Löytyi ';
    if ($summa["count"] > 1) {
        echo 'yhteensä ';
    }
    echo $summa["count"] . ' kuva';

    if ($summa["count"] != 1) {
        echo 'a';
    }
} else {
    echo 'Yhtään kuvaa ei löytynyt';
}

echo '.</p><br>';

while ($currentKuva = $kysely->fetch()) {
    echo '<a href="?toiminto=kuva';
    echo '&kuvaid=' . $currentKuva["kuvaid"] . '">';
    echo '<div ';
    echo 'class="image" ';
    echo 'style="background-image:url(' . "'kuvat/" . $currentKuva["kuvaid"] . "t" . '.jpg' . "'" . ')"';
    echo '>';
    echo '</div>';
    echo '</a>';
    echo("\n");
}
?>
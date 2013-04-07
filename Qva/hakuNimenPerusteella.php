<?php

try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=jiji", "jiji", "argh");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$kysely = $yhteys->prepare(
        "select COUNT(kuvaid) from kuva where kayttajanimi = '" . $_GET['avain'] . "'");
$kysely->execute();
$summa = $kysely->fetch();

// Kysellään mitä kuvia löytyy, uutuusjärjestyksessä
$kysely = $yhteys->prepare(
        "SELECT kuvaid, kayttajanimi FROM kuva WHERE kayttajanimi = '" . $_GET['avain'] . "' ORDER BY julkaisuaika DESC");
$kysely->execute();

echo '<h1>';
echo 'Käyttäjän ' . $_GET['avain'] . ' lisäämät kuvat</h1>';
echo '<p>Löytyi ';
if ($summa["count"] > 1) {
    echo 'yhteensä ';
}
echo $summa["count"] . ' kuva';

if ($summa["count"] > 1) {
    echo 'a';
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
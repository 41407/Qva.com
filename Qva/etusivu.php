<?php
try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=jiji", "jiji", "argh");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Kysellään mitä kuvia löytyy, uutuusjärjestyksessä
$kysely = $yhteys->prepare(
        "SELECT kuvaid, kayttajanimi FROM kuva ORDER BY julkaisuaika DESC");
$kysely->execute();

while ($currentKuva = $kysely->fetch()) {
    echo '<a href="?toiminto=kuva';
    echo '&kuvaid=' . $currentKuva["kuvaid"] . '">';
    echo '<div ';
    echo 'class="image" ';
    echo 'style="background-image:url(' . "'kuvat/" . $currentKuva["kuvaid"] . "t". '.jpg'."'". ')"';
    echo '>';
    echo '</div>';
    echo '</a>';
    echo("\n");
}
?>
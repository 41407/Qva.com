<?php

if (isset($_GET["p"])) {
    $sivu = $_GET["p"];
} else {
    $sivu = 0;
}

/**
 * Paginaatiologicka jonka voi irrottaaa omaksi tiedostokseen jos javascript
 */
$kuviaPerSivu = 15;

try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=jiji", "jiji", "argh");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

/*
 *  Kysellään mitä kuvia löytyy, uutuusjärjestyksessä
 * Haetaan 1 kuva enemmän kuin mitä kuviaPerSivussa on määritelty, jotta voidaan
 * katsoa tarvitseeko laittaa linkin seuraavalle sivulle
 */
$limitti = $kuviaPerSivu + 1;
$kysely = $yhteys->prepare(
        "SELECT kuvaid, kayttajanimi " .
        "FROM kuva " .
        "ORDER BY julkaisuaika DESC " .
        "LIMIT " . $limitti . " " .
        "OFFSET " . $sivu * $kuviaPerSivu);
$kysely->execute();


for ($index = 1; $index < $limitti; $index++) {
    if ($currentKuva = $kysely->fetch()) {
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
}

/**
 *  /paginaatiologicka
 */
echo '<br><div id="pagenav">';
if ($sivu > 0) {
    $sivu--;
    echo '<a href="?p=' . $sivu . '">Edellinen sivu</a>';
    $sivu++;
}
if ($currentKuva = $kysely->fetch()) {
    $sivu++;
    echo '<a href="?p=' . $sivu . '">Seuraava sivu</a>';
    echo '</div>';
}
?>
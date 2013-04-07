<?php

$kuvaid = $_GET["kuvaid"];
$kuvatiedosto = $kuvaid . ".jpg";
$toiminto = $_GET["kuvatoiminto"];

try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=jiji", "jiji", "argh");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
/**
 * Kuvan poistaminen
 */
if ($toiminto === "poistaKuva") {
    $kysely = $yhteys->prepare("DELETE FROM kuva
    WHERE kuvaid = " . $kuvaid);
    $kysely->execute();
    unlink("kuvat/" . $kuvaid . ".jpg");
    unlink("kuvat/" . $kuvaid . "t" . ".jpg");
    include("kuvaPoistettu.php");
    die();
}
// Haetaan kuvan tiedot
$kysely = $yhteys->prepare("SELECT * FROM kuva WHERE kuvaid = '" .
        $kuvaid . "'");
$kysely->execute();
$kuvanTiedot = $kysely->fetch();

/**
 * Rintataan itse kuva
 */
// Kokeellinen lightbox featuuri
// echo '<a href="kuva.php?k=' . $kuvatiedosto . '" target="_BLANK">';
echo '<img src="kuvat/' . $kuvatiedosto . '">';
// echo '</a>';

/**
 * Kuvan lisänneen käyttäjän toiminnot
 */
if ($kuvanTiedot[kayttajanimi] === $_SESSION[kayttajanimi]) {
    include("kuvasivuKayttajanToiminnot.php");
}

/**
 * Kuvan nimi, jos löytyy
 */
echo '<div class="photoInfo">';

echo '<a href="?toiminto=hakuNimenPerusteella&avain=' . $kuvanTiedot["kayttajanimi"] . '">';
echo '<h2 style="text-align:right">©';
echo $kuvanTiedot["kayttajanimi"];
echo '</h2></a>';

if ($kuvanTiedot["kuvanimi"]) {
    echo '<h1>';
    echo $kuvanTiedot["kuvanimi"];
    echo '</h1>';
}

if ($kuvanTiedot["kuvateksti"]) {
    echo '<p>';
    echo $kuvanTiedot["kuvateksti"];
    echo '</p>';
}
echo '</div>';
echo '<p style="color:#444; text-align:right">Lisätty ' . $kuvanTiedot["julkaisuaika"] . '.';

if ($_GET["kuvatoiminto"] === "muokkaaKuvaa") {
    include("kuvaMuokkaus.php");
}
?>
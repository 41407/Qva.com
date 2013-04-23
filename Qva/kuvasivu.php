<?php

$kuvaid = $_GET["kuvaid"];
$kuvatiedosto = $kuvaid;
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
        $kysely = $yhteys->prepare("DELETE FROM kommentti
    WHERE kuvaid = " . $kuvaid);
    $kysely->execute();
    $kysely = $yhteys->prepare("DELETE FROM kuva
    WHERE kuvaid = " . $kuvaid);
    $kysely->execute();
    unlink("kuvat/" . $kuvaid . ".jpg");
    unlink("kuvat/" . $kuvaid . "s" . ".jpg");
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
echo '<a href="kuva.php?k=' . $kuvatiedosto . '.jpg">';
echo '<div class="imageframe">';
echo '<img src="kuvat/' . $kuvatiedosto . 's.jpg">';
echo '</div>';
echo '</a>';

/**
 * Kuvan lisänneen käyttäjän toiminnot
 */
if (isset($_SESSION[kayttajanimi])) {
    if ($kuvanTiedot[kayttajanimi] === $_SESSION[kayttajanimi]) {
        include("kuvasivuKayttajanToiminnot.php");

        if ($_GET["kuvatoiminto"] === "muokkaaKuvaa") {
            include("kuvaMuokkaus.php");
            die();
        }
    }
}
/**
 * Ao. koodia ei suoriteta mikäli käyttäjä on klikannut kuvanmuokkauslinkkiä
 */
echo '<div class="photoInfo">';


/**
 * Kuvan lisääjän nimi
 */
echo '<a href="?toiminto=hakuNimenPerusteella&avain=' . $kuvanTiedot["kayttajanimi"] . '">';
echo '<h2 style="text-align:right">©';
echo $kuvanTiedot["kayttajanimi"];
echo '</h2></a>';

/**
 * Kuvan nimi, jos
 */
if ($kuvanTiedot["kuvanimi"]) {
    echo '<h1>';
    echo $kuvanTiedot["kuvanimi"];
    echo '</h1>';
}

/**
 * Kuvateksti, mikäli
 */
if ($kuvanTiedot["kuvateksti"]) {
    echo '<p>';
    echo $kuvanTiedot["kuvateksti"];
    echo '</p>';
}

/**
 * Julkaisuaika
 */
echo '</div>';
echo '<p style="color:#444; text-align:right">Lisätty ' .
 $kuvanTiedot["julkaisuaika"] . '.';
echo '<p class="tags">Tägit: ';

/**
 * Tägänderit yo
 */
$kysely = $yhteys->prepare("SELECT tagnimi FROM kuvantagit WHERE kuvaid = " .
        $kuvaid);
$kysely->execute();

$i = 0;
while ($tagit = $kysely->fetch()) {
    if ($i > 0) {
        echo', ';
    }
    echo '<a href="?toiminto=hakuTaginPerusteella&tag=' . $tagit["tagnimi"] . '">';
    echo $tagit["tagnimi"];
    echo '</a>';
    $i++;
}
echo '</p>';

if (isset($_SESSION[kayttajanimi])) {
    include("kuvaKommentoi.php");
}
include("kuvanKommentit.php");
?>
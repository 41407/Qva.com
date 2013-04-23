<?php

try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=jiji", "jiji", "argh");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$kuvaid = $_POST["kuvaid"];
$kuvanimi = htmlspecialchars($_POST["kuvanimi"]);
$kuvateksti = htmlspecialchars($_POST["kuvateksti"]);
$kuvantagit = htmlspecialchars($_POST["kuvantagit"]);


/**
 * Kuvan otsikko, kuvateksti tietokantaan
 */
$kysely = $yhteys->prepare("UPDATE kuva SET kuvanimi=?, kuvateksti=? WHERE kuvaid = ?");
$kysely->execute(array($kuvanimi, $kuvateksti, $kuvaid));

/**
 * The fun part. Parsitaan tägit
 */
$pilkotutTagit = explode(",", $kuvantagit);

/**
 * Trimmataan tägien alut ja loput ja formatoidaan ne
 */
$i = 0;
while (isset($pilkotutTagit[$i])) {
    // >lowercase
    $pilkotutTagit[$i] = strtolower($pilkotutTagit[$i]);
    // ekan spacebäärin trimmaus
    $pilkotutTagit[$i] = ltrim($pilkotutTagit[$i]);
    // mahd tokan spacebäärin trimmaus
    $pilkotutTagit[$i] = rtrim($pilkotutTagit[$i]);
    /**
     * Pätkäistään tägi 80. merkin kohdalta
     */
    $pilkotutTagit[$i] = substr($pilkotutTagit[$i], 0, 80);

    $i++;
}
/**
 * Tägit tietokantaan erittiän rouhealla mekanismilla
 */
$kysely = $yhteys->prepare("delete from kuvantagit where kuvaid = ?");
$kysely->execute(array($kuvaid));
$j = 0;
while (isset($pilkotutTagit[$j])) {
    $kysely = $yhteys->prepare("INSERT INTO kuvantagit(kuvaid, tagnimi)" .
            "VALUES(?, ?)");
    $kysely->execute(array($kuvaid, $pilkotutTagit[$j]));
    $j++;
}

header("Location: /qva/?toiminto=kuva&kuvaid=" . $kuvaid);
die();
?>

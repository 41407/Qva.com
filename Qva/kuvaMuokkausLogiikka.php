<?php

try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=jiji", "jiji", "argh");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$kuvaid = $_POST["kuvaid"];
$kuvanimi = $_POST["kuvanimi"];
$kuvateksti = $_POST["kuvateksti"];
$kuvantagit = $_POST["kuvantagit"];

/**
 * Kuvan otsikko, kuvateksti tietokantaan
 */
$kysely = $yhteys->prepare("UPDATE kuva SET kuvanimi='" . $kuvanimi . "', kuvateksti='" . $kuvateksti . "' WHERE kuvaid = ". $kuvaid);
$kysely->execute();

/**
 * The fun part. Parsitaan tägit
 */
$pilkotutTagit = explode(",", $kuvantagit);

/**
 * Trimmataan tägien alut ja loput ja formatoidaan ne
 */
$i = 0;
while ($pilkotutTagit[$i]) {
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
$kysely = $yhteys->prepare("delete from kuvantagit where kuvaid =" . $kuvaid);
$kysely->execute();
$j = 0;
while ($pilkotutTagit[$j]) {
    $kysely = $yhteys->prepare("INSERT INTO kuvantagit(kuvaid, tagnimi)" .
            "VALUES(" . $kuvaid . ", '" . $pilkotutTagit[$j] . "')");
    $kysely->execute();
    $j++;
}

header("Location: /qva/?toiminto=kuva&kuvaid=".$kuvaid);
die();
?>

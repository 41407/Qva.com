<?php

try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=jiji", "jiji", "argh");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$kuvaid = $_POST["kuvaid"];
$tunnus = $_POST["tunnus"];
$kommentti = $_POST["kommentti"];

$kysely = $yhteys->prepare(
        "INSERT INTO kommentti (kuvaid, kayttajanimi, julkaisuaika, kommenttistring) " .
        "VALUES (" . $kuvaid . ", '" . $tunnus . "', CURRENT_TIMESTAMP(0), '" .
        $kommentti . "')");
$kysely->execute();
header("Location: /qva/?toiminto=kuva&kuvaid=" . $kuvaid);
die();
?>

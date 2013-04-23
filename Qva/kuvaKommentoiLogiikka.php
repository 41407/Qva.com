<?php

try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=jiji", "jiji", "argh");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$kuvaid = $_POST["kuvaid"];
$tunnus = $_POST["tunnus"];
$kommentti = htmlspecialchars($_POST["kommentti"]);

$kysely = $yhteys->prepare(
        "INSERT INTO kommentti (kuvaid, kayttajanimi, julkaisuaika, kommenttistring)
        VALUES (?, ?, CURRENT_TIMESTAMP(0), ?)");
$kysely->execute(array($kuvaid, $tunnus, $kommentti));
header("Location: /qva/?toiminto=kuva&kuvaid=" . $kuvaid);
die();
?>

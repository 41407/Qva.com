<?php
session_start();
// yhteyden muodostus tietokantaan
try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=jiji",
                    "jiji", "argh");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$tunnus = $_POST["tunnus"];
$salasana = $_POST["salasana"];

// kyselyn suoritus
$kysely = $yhteys->prepare("INSERT INTO kayttaja (kayttajanimi, salasana) VALUES (?, ?)");
$kysely->execute(array($tunnus, $salasana));

$_SESSION["kayttajanimi"] = $tunnus;
header("Location: /?toiminto=kirjautuminenOnnistui");
?>
<?php
session_start();

try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=jiji",
                    "jiji", "argh");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$tunnus = htmlspecialchars($_POST["tunnus"]);
$salasana = $_POST["salasana"];

$kysely = $yhteys->prepare("SELECT * FROM kayttaja WHERE kayttajanimi = ? AND salasana = ?");
$kysely->execute(array($tunnus, $salasana));

if ($kysely->fetch()) {
    $_SESSION["kayttajanimi"] = $tunnus;
    header("Location: /qva/?toiminto=kirjautuminenOnnistui");
    die();
}
header("Location: /qva/?toiminto=kirjautuminenEiOnnistunut");
?>
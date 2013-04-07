<?php
session_start();

// Haetaan kuvataulun indeksi
try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=jiji", "jiji", "argh");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Tästä tulee kuvan nimi (ja implisiitisti id)
$kysely = $yhteys->prepare(
        "SELECT last_value FROM kuva_kuvaid_seq");
$kysely->execute();
$rivi = $kysely->fetch();
$id = $rivi["last_value"] + 1;

$kuvanimi = $_POST["kuvanimi"];
$kuvateksti = $_POST["kuvateksti"];

$sallitutPaatteet = array("jpeg, jpg"/*, "png" */);
$kuvanPaate = end(explode(".", $_FILES["file"]["name"]));
$paate = strtolower($kuvanPaate);
if ((($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/jpg")
        /* || ($_FILES["file"]["type"] == "image/png") */) && in_array($paate, $sallitutPaatteet)) {
    if ($_FILES["file"]["error"] > 0) {
        echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    } else {
        /*
         * Debuggailuosastoa:
         * 
          echo "Upload: " . $_FILES["file"]["name"] . "<br>";
          echo "Type: " . $_FILES["file"]["type"] . "<br>";
          echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
          echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
          echo "Username: " . $_SESSION["kayttajanimi"] . "<br>";
         */

        $lopullinenTiedostonimi = $id . "." . $paate;
        // Siirretään temporaalinen tiedosto kansioonsa
        move_uploaded_file($_FILES["file"]["tmp_name"], "kuvat/" .
                $lopullinenTiedostonimi);
        //echo "Stored in: " . "kuvat/" . $id . "." . $paate;

        // Lisätään kuva tietokantaan
        $kysely = $yhteys->prepare(
                "INSERT INTO kuva (kuvanimi, julkaisuaika, kayttajanimi, kuvateksti) " .
                "VALUES ('" . $kuvanimi . "', CURRENT_TIMESTAMP(0), '" .
                $_SESSION["kayttajanimi"] . "', '". $kuvateksti . "')");
        $kysely->execute();

        // tehdään pieni esikatselukuva ja annetaan www-datalle oikeudet kuvaan
        // ja thumbnailiin
        shell_exec("convert kuvat/" . $lopullinenTiedostonimi . " -resize 275x275^ kuvat/" . $id . "t." . $paate . " && " .
                "setfacl -m u:www-data:r-- kuvat/" . $lopullinenTiedostonimi . " kuvat/" . $id . "t." . $paate);
        header("Location: /qva/?toiminto=kuvanLisaysOnnistui");
        die();
    }
} else {
    header("Location: /qva/?toiminto=kuvanLisaysEpaonnistui");
}
?>
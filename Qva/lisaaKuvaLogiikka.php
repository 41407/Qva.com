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

$sallitutPaatteet = array(/*"jpeg", */"jpg",/* "png"*/);
$paate = end(explode(".", $_FILES["file"]["name"]));
if ((($_FILES["file"]["type"] == "image/jpeg")
        || ($_FILES["file"]["type"] == "image/jpg")
       /* || ($_FILES["file"]["type"] == "image/png")*/)
        && in_array($paate, $sallitutPaatteet)) {
    if ($_FILES["file"]["error"] > 0) {
        echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    } else {
        // POistan nämä jos jaxan
        echo "Upload: " . $_FILES["file"]["name"] . "<br>";
        echo "Type: " . $_FILES["file"]["type"] . "<br>";
        echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
        echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
        echo "Username: " . $_SESSION["kayttajanimi"] . "<br>";

        // Siirretään temporaalinen tiedosto kansioonsa
        move_uploaded_file($_FILES["file"]["tmp_name"], "kuvat/" .
                $id . "." . $paate);
        echo "Stored in: " . "kuvat/" . $id . "." . $paate;

        // Lisätään kuva tietokantaan
        $kysely = $yhteys->prepare(
                "INSERT INTO kuva (kuvanimi, julkaisuaika, kayttajanimi) " . "VALUES ('" . $kuvanimi . "', CURRENT_TIMESTAMP(0), '" . $_SESSION["kayttajanimi"] . "')");
        $kysely->execute();

        // annetaan www-datalle oikeudet kuvaan
        shell_exec ( "setfacl -m u:www-data:r-- kuvat/" . $id . "." . $paate);
    }
} else {
    echo "Invalid file";
}
?>
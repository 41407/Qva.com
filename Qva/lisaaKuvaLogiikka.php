<?php

session_start();
 
try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=jiji", "jiji", "argh");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Kehitetään kuvalle id
$kysely = $yhteys->prepare(
        "SELECT last_value FROM kuva_kuvaid_seq");
$kysely->execute();
$rivi = $kysely->fetch();
$id = $rivi["last_value"] + 1;

$kuvanimi = htmlspecialchars($_POST["kuvanimi"]);
$kuvateksti = htmlspecialchars($_POST["kuvateksti"]);

$sallitutPaatteet = array("jpeg", "jpg", "png");
$kuvanPaate = end(explode(".", $_FILES["file"]["name"]));
$paate = strtolower($kuvanPaate);
if ((($_FILES["file"]["type"] == "image/jpeg") ||
        ($_FILES["file"]["type"] == "image/jpg") ||
        ($_FILES["file"]["type"] == "image/png")) &&
        in_array($paate, $sallitutPaatteet)) {
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
                "VALUES (?, CURRENT_TIMESTAMP(0), ?, ?)");
        $kysely->execute(array($kuvanimi, $_SESSION["kayttajanimi"], $kuvateksti));

        /*
         * Tehdään:
         * 1. Muunnos jpg-muotoon
         * 2. 900px kuva
         * 3. Thumbnail
         * 4. Oikeudet luoduille kuville
         * 
         * Joten lopuksi meillä on 3 kuvaa. Esimerkkitapauksessa kuvaid = 83:
         *  83.jpg  originaali, täysikokoinen kuva joka on muunnettu .jpg:ksi
         *  83s.jpg 900x900px kokoon downskaalattu kuva
         *  83t.jpg 275x275px kokoon downskaalattu thumbnail
         *  
         */
        shell_exec("convert kuvat/" . $lopullinenTiedostonimi . " kuvat/" . $id . ".jpg" .
                " && " .
                "convert kuvat/" . $lopullinenTiedostonimi . " -resize 900x900\> kuvat/" . $id . "s.jpg" .
                " && " .
                "convert kuvat/" . $lopullinenTiedostonimi . " -resize 275x275^ kuvat/" . $id . "t.jpg" .
                " && " .
                "setfacl -m u:www-data:r-- kuvat/" . $lopullinenTiedostonimi . " kuvat/" . $id . "t.jpg" . " kuvat/" . $id . "s.jpg");
        header("Location: /qva/?toiminto=kuvanLisaysOnnistui");
        die();
    }
} else {
    header("Location: /qva/?toiminto=kuvanLisaysEpaonnistui");
}
?>
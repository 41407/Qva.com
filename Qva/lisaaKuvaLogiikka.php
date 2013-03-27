<?php
// Haetaan kuvataulun indeksi
try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=jiji",
                    "jiji", "argh");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$kysely = $yhteys->prepare("SELECT * FROM kayttaja WHERE kayttajanimi = '" .
        $tunnus . "'");
$kysely->execute();

/**
 * käytä kuva_kuvaid_seq->last_valueta!
 */

$sallitutPaatteet = array("jpeg", "jpg", "png");
$paate = end(explode(".", $_FILES["file"]["name"]));
if ((($_FILES["file"]["type"] == "image/jpeg")
        || ($_FILES["file"]["type"] == "image/jpg")
        || ($_FILES["file"]["type"] == "image/png"))
        && in_array($paate, $sallitutPaatteet)) {
    if ($_FILES["file"]["error"] > 0) {
        echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    } else {
        echo "Upload: " . $_FILES["file"]["name"] . "<br>";
        echo "Type: " . $_FILES["file"]["type"] . "<br>";
        echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
        echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";


        move_uploaded_file($_FILES["file"]["tmp_name"], "kuvat/" .
                $_FILES["file"]["name"]);
        echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
    }
} else {
    echo "Invalid file";
}
?>
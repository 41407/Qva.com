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

$search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
                 "'<[/!]*?[^<>]*?>'si",          // Strip out HTML tags
//                 "'([rn])[s]+'",                // Strip out white space
                 "'&(quot|#34);'i",                // Replace HTML entities
                 "'&(amp|#38);'i",
                 "'&(lt|#60);'i",
                 "'&(gt|#62);'i",
                 "'&(nbsp|#160);'i",
                 "'&(iexcl|#161);'i",
                 "'&(cent|#162);'i",
                 "'&(pound|#163);'i",
                 "'&(copy|#169);'i",
                 "'&#(d+);'e");                    // evaluate as php
 
$replace = array ("",
                 "",
                 "\1",
                 "\"",
                 "&",
                 "<",
                 ">",
                 " ",
                 chr(161),
                 chr(162),
                 chr(163),
                 chr(169),
                 "chr(\1)");
 
$kommentti = preg_replace($search, $replace, $kommentti);

$kysely = $yhteys->prepare(
        "INSERT INTO kommentti (kuvaid, kayttajanimi, julkaisuaika, kommenttistring) " .
        "VALUES (" . $kuvaid . ", '" . $tunnus . "', CURRENT_TIMESTAMP(0), '" .
        $kommentti . "')");
$kysely->execute();
header("Location: /qva/?toiminto=kuva&kuvaid=" . $kuvaid);
die();
?>

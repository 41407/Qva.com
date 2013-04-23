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
 

$tunnus = preg_replace($search, $replace, $_POST["tunnus"]);
$salasana = $_POST["salasana"];

// Testataan löytyykö tunnus jo tietokannasta

$kysely = $yhteys->prepare("SELECT * FROM kayttaja WHERE kayttajanimi = '" .
        $tunnus . "'");
$kysely->execute();

if ($kysely->fetch()) {
    header("Location: /qva/?toiminto=tunnuksenLuontiEiOnnistunut");
    die();
}



// kyselyn suoritus
$kysely = $yhteys->prepare("INSERT INTO kayttaja (kayttajanimi, salasana) VALUES (?, ?)");
$kysely->execute(array($tunnus, $salasana));

$_SESSION["kayttajanimi"] = $tunnus;
header("Location: /qva/?toiminto=kirjautuminenOnnistui");
?>
<?php

try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=jiji", "jiji", "argh");
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

$kuvaid = $_POST["kuvaid"];
$kuvanimi = preg_replace($search, $replace, $_POST["kuvanimi"]);
$kuvateksti = preg_replace($search, $replace, $_POST["kuvateksti"]);
$kuvantagit = preg_replace($search, $replace, $_POST["kuvantagit"]);


/**
 * Kuvan otsikko, kuvateksti tietokantaan
 */
$kysely = $yhteys->prepare("UPDATE kuva SET kuvanimi='" . $kuvanimi . "', kuvateksti='" . $kuvateksti . "' WHERE kuvaid = ". $kuvaid);
$kysely->execute();

/**
 * The fun part. Parsitaan tägit
 */
$pilkotutTagit = explode(",", $kuvantagit);

/**
 * Trimmataan tägien alut ja loput ja formatoidaan ne
 */
$i = 0;
while ($pilkotutTagit[$i]) {
    // >lowercase
    $pilkotutTagit[$i] = strtolower($pilkotutTagit[$i]);
    // ekan spacebäärin trimmaus
    $pilkotutTagit[$i] = ltrim($pilkotutTagit[$i]);
    // mahd tokan spacebäärin trimmaus
    $pilkotutTagit[$i] = rtrim($pilkotutTagit[$i]);
    /**
     * Pätkäistään tägi 80. merkin kohdalta
     */
    $pilkotutTagit[$i] = substr($pilkotutTagit[$i], 0, 80);

    $i++;
}
/**
 * Tägit tietokantaan erittiän rouhealla mekanismilla
 */
$kysely = $yhteys->prepare("delete from kuvantagit where kuvaid =" . $kuvaid);
$kysely->execute();
$j = 0;
while ($pilkotutTagit[$j]) {
    $kysely = $yhteys->prepare("INSERT INTO kuvantagit(kuvaid, tagnimi)" .
            "VALUES(" . $kuvaid . ", '" . $pilkotutTagit[$j] . "')");
    $kysely->execute();
    $j++;
}

header("Location: /qva/?toiminto=kuva&kuvaid=".$kuvaid);
die();
?>

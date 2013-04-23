<?php

$hakusanat = $_POST["hakusanat"];
$tagi = $_POST["tagi"];
$tunnus = $_POST["tunnus"];
$kuvanimi = $_POST["kuvanimi"];
$kuvateksti = $_POST["kuvateksti"];

$hakuehdot = "";

/**
 * Hakusanojen parsinta, kopioitu suoraan kuvamuokkauslogiikasta.phå ja joojoo
 * on huonoa ohjelmointia
 */
$pilkotutHakuehdot = explode(",", $kuvantagit);

/**
 * Trimmataan tägien alut ja loput ja formatoidaan ne
 */
$i = 0;
while ($pilkotutHakuehdot[$i]) {
    // >lowercase
    $pilkotutHakuehdot[$i] = strtolower($pilkotutHakuehdot[$i]);
    // ekan spacebäärin trimmaus
    $pilkotutHakuehdot[$i] = ltrim($pilkotutHakuehdot[$i]);
    // mahd tokan spacebäärin trimmaus
    $pilkotutHakuehdot[$i] = rtrim($pilkotutHakuehdot[$i]);
    /**
     * Pätkäistään tägi 80. merkin kohdalta
     */
    $pilkotutHakuehdot[$i] = substr($pilkotutHakuehdot[$i], 0, 80);

    $i++;
}
$i = 0;
if ($tagi) {
    $tagikysely = "(";
    while ($pilkotutHakuehdot[$i]) {
        implode($tagikysely, "kuvantagit.tagnimi LIKE ");
        implode($tagikysely, "'" . $pilkotutHakuehdot[$i] . "' ");

        if ($pilkotutHakuehdot[$i + 1]) {
            implode($tagikysely, "OR ");
        }
        $i++;
    }
    implode($tagikysely, ")");
}
/**
 * Yhtäkkiä huomaan että hakutoiminto ei välttämättä olekaan tarpeellinen
 */

try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=jiji",
                    "jiji", "argh");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$kysely = $yhteys->prepare("SELECT kuva.kuvaid
    FROM kuva, kuvantagit
    WHERE kuva.kuvaid = kuvantagit.kuvaid AND ?");
$kysely->execute(array($hakuehdot));
?>

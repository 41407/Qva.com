<h1>Qva.com käyttäjät</h1>
<?php
try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=jiji",
                    "jiji", "argh");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// Testataan löytyykö tunnus jo tietokannasta

$kysely = $yhteys->prepare("SELECT kayttajanimi FROM kayttaja WHERE kayttajanimi != 'admin'");
$kysely->execute();

while ($nimi = $kysely->fetch()) {
    echo('<a href = "?toiminto=hakuNimenPerusteella&avain=' . $nimi[0] . '">');
    echo($nimi[0]);
    echo("</a><br>");
}
?>
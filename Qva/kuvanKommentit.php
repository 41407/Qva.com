

<?php

try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=jiji", "jiji", "argh");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$kysely = $yhteys->prepare(
        "select kommenttistring as kommentti, kayttajanimi as tunnus, " .
        "julkaisuaika as aika, kommenttiid as id " .
        "from kommentti where kuvaid=? order by aika desc");
$kysely->execute(array($kuvaid));

$i = 0;
while ($kommentti = $kysely->fetch()) {
    echo'<div class="comment">';
    echo'<div class="commentInfo">';
    echo '<a href="?toiminto=hakuNimenPerusteella&avain=' . $kommentti["tunnus"] . '">';
    echo $kommentti["tunnus"];
    echo '</a> ';
    if (isset($_SESSION["kayttajanimi"])) {
        if ($kommentti["tunnus"] === $_SESSION["kayttajanimi"] ||
                $_SESSION["kayttajanimi"] === 'admin') {
            echo '- <a href="?toiminto=poistaKommentti&kommenttiID=' .
            $kommentti["id"] . '"> Poista kommentti </a>';
        }
    }

    
    echo ' - ' . $kommentti["aika"];

    echo '</div>';
    echo '<div class="commentBody">';
    echo $kommentti["kommentti"];
    echo '</div>';
    echo '</div>';
    $i++;
}
?>
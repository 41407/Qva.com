

<?php
try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=jiji", "jiji", "argh");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$kysely = $yhteys->prepare(
        "select kommenttistring as kommentti, kayttajanimi as tunnus, julkaisuaika as aika" .
        " from kommentti where kuvaid=" . $kuvaid . " order by aika desc");
$kysely->execute();

$i = 0;
while ($kommentti = $kysely->fetch()) {
    echo'<div class="comment">';
    echo'<div class="commentInfo">';
    echo '<a href="?toiminto=hakuNimenPerusteella&avain=' . $kommentti["tunnus"] . '">';
    echo $kommentti["tunnus"];
    echo '</a> ';
    echo $kommentti["aika"];
    echo '</div>';
    echo '<div class="commentBody">';
    echo $kommentti["kommentti"];
    echo '</div>';
    echo '</div>';
    $i++;
}
?>
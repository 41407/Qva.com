<?php
try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=jiji", "jiji", "argh");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>







<h1>Muokkaa kuvan tietoja</h1>
<form action="kuvaMuokkausLogiikka.php" method="post">

    Kuvan otsikko: <br>
    <input type="text" name="kuvanimi" value="<?php
    $kysely = $yhteys->prepare(
            "SELECT kuvanimi
    FROM kuva
    WHERE kuvaid = " . $_GET["kuvaid"]);
    $kysely->execute();
    $kuvanimi = $kysely->fetch();
    echo($kuvanimi["kuvanimi"]);
    ?>"  size ="80" maxlength="80"> <br><br>

    Kuvateksti: <br>
    <input type="text" name="kuvateksti" value="<?php
    $kysely = $yhteys->prepare(
            "SELECT kuvateksti
    FROM kuva
    WHERE kuvaid = " . $_GET["kuvaid"]);
    $kysely->execute();
    $kuvateksti = $kysely->fetch();
    echo($kuvateksti["kuvateksti"]);
    ?>" size ="80" maxlength="300"> <br><br>

    Kuvan tägit: <br>
    <input type="text" name="tagit" value="<?php
           $kysely = $yhteys->prepare(
                   "SELECT tagnimi
    FROM kuva, kuvantagit
    WHERE kuva.kuvaid = " . $_GET["kuvaid"] . " AND
    kuva.kuvaid=kuvantagit.kuvaid");
           $kysely->execute();
           while ($currentTag = $kysely->fetch()) {
               echo($currentTag["tagnimi"] . ', ');
           }
    ?>" size ="80"> <br>
    Erottele tägit pilkulla, esimerkiksi "maisema, yö, koira, kalifi"
    <br><br>
    <br><input type="submit" value="Tallenna"><br><br>
</form>
<br>
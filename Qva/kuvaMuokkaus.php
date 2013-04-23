<?php
try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=jiji", "jiji", "argh");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>

<h1>Kuvan tietojen muokkaus</h1>
<p>Mitkään kentistä eivät ole pakollisia.</p>
<form action="kuvaMuokkausLogiikka.php" method="post">
    <input type="hidden" name="kuvaid" value="<?php echo $_GET["kuvaid"]; ?>">

    Kuvan otsikko: <br>
    <input type="text" name="kuvanimi" value="<?php
    $kysely = $yhteys->prepare(
            "SELECT kuvanimi
    FROM kuva
    WHERE kuvaid = ?");
    $kysely->execute(array($_GET["kuvaid"]));
    $kuvanimi = $kysely->fetch();
    echo($kuvanimi["kuvanimi"]);
    ?>"  size ="80" maxlength="80"> <br><br>

    Kuvateksti: <br>
    <input type="text" name="kuvateksti" value="<?php
    $kysely = $yhteys->prepare(
            "SELECT kuvateksti
    FROM kuva
    WHERE kuvaid = ?");
    $kysely->execute(array($_GET["kuvaid"]));
    $kuvateksti = $kysely->fetch();
    echo($kuvateksti["kuvateksti"]);
    ?>" size ="80" maxlength="300"> <br><br>

    Kuvan tägit: <br>
    <input type="text" name="kuvantagit" value="<?php
    $kysely = $yhteys->prepare(
            "SELECT tagnimi
    FROM kuva, kuvantagit
    WHERE kuva.kuvaid = ?
    AND kuva.kuvaid=kuvantagit.kuvaid");
    $kysely->execute(array($_GET["kuvaid"]));
    while ($currentTag = $kysely->fetch()) {
        echo($currentTag["tagnimi"] . ', ');
    }
    ?>" size ="80"> <br>
    Erottele tägit pilkulla, esimerkiksi "maisema, yö, koira, kalifi"
    <br><br>
    <br><input type="submit" value="Valmis"><br><br>
</form>
<br>
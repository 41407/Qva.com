<h1>Kuvan lisääminen</h1>
<p>Täällä voit lisätä kuvia palveluun. Kuvan tiedostomuoto tulee olla jpg, jpeg
    tai png. Mitkään allaolevista tekstikentistä eivät ole pakollisia. Tägien
    lisääminen kuvaan onnistuu kuvan lähettämisen jälkeen.</p>

<form action="lisaaKuvaLogiikka.php" method="post"
      enctype="multipart/form-data">
    Kuvatiedosto:<br>
    <input type="file" name="file" id="file"><br><br>
    Kuvan otsikko:<br>
    <input type="text" name="kuvanimi" size ="80" maxlength="80"> <br><br>
    Kuvateksti:<br>
    <input type="text" name="kuvateksti" size ="80" maxlength="300"> <br><br>
    <input type="submit" name="submit" value="Submit">
</form>
<?php
$toiminto = $_GET["toiminto"];
if ($toiminto === "kuvanLisaysEpaonnistui") {
    ?>
    <br><br>
    <p>Kuvan lisäys epäonnistui. Jos valitsit mielestäsi validin kuvan, syynä
        lienee väärä tiedostomuoto. Tällä hetkellä vain jpg, jpeg ja png
        -päätteisiä kuvia voi lisätä. </p>
<?php }
?>
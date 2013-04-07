<h1>Kuvan lisääminen</h1>
<p>Täällä voit lisätä kuvia palveluun. Tällä hetkellä vain .jpg-muotoiset kuvat
    kelpaavat</p>

<form action="lisaaKuvaLogiikka.php" method="post"
      enctype="multipart/form-data">
    Kuvatiedosto:<br>
    <input type="file" name="file" id="file"><br><br>
    Kuvan otsikko (voi jättää tyhjäksi):<br>
    <input type="text" name="kuvanimi" size ="80" maxlength="80"> <br><br>
    Kuvateksti (voi jättää tyhjäksi):<br>
    <input type="text" name="kuvateksti" size ="300" maxlength="300"> <br><br>
    <input type="submit" name="submit" value="Submit">
</form>
<?php
$toiminto = $_GET["toiminto"];
if ($toiminto === "kuvanLisaysEpaonnistui") {
    ?>
    <br><br>
    <p>Kuvan lisäys epäonnistui. Syynä lienee väärä tiedostomuoto. Tällä hetkellä
        vain ja ainoastaan .jpg-päätteisiä kuvia voi lisätä. </p>
<?php }
?>
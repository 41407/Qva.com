<h1>Kuvan lisääminen</h1>
<p>Täällä voit lisätä kuvia palveluun. Tällä hetkellä vain .jpg-muotoiset kuvat
kelpaavat</p>

<form action="lisaaKuvaLogiikka.php" method="post"
enctype="multipart/form-data">
Kuvatiedosto:<br>
<input type="file" name="file" id="file"><br><br>
Kuvan nimi/kuvateksti (voi jättää tyhjäksi):<br>
<input type="text" name="kuvanimi" size ="80" maxlength="80"> <br><br>
<input type="submit" name="submit" value="Submit">
</form>
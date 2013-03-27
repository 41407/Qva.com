<form action="kirjautumislogiikka.php" method="post">
    Tunnus:
    <input type="text" name="tunnus" maxlength="16" size="16"> <br>
    Salasana:
    <input type="password" name="salasana" maxlength="16" size="16"> <br>
    <input type="submit" value="Kirjaudu">
</form>
<a href="?toiminto=luoTunnus">Luo uusi tunnus</a><br>
<?php
if ($_GET["toiminto"] === "kirjautuminenEiOnnistunut") {
    ?>
    Väärä käyttäjätunnus tai salasana!
    <?php
}
?>

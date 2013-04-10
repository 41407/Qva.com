<form style="margin-top:11px; margin-bottom:1px;" action="kirjautumislogiikka.php" method="post">
    <input type="text" name="tunnus" value="Käyttäjätunnus" maxlength="16" size="16">
    <input type="password" name="salasana" value="salasana" maxlength="16" size="16">
    <input type="submit" value="Kirjaudu">
</form>
<?php
if (isset($_GET["toiminto"]) && $_GET["toiminto"] === "kirjautuminenEiOnnistunut") {
    ?>
    Väärä käyttäjätunnus tai salasana!
    <?php
}
?>
<a href="?toiminto=luoTunnus">Luo uusi tunnus<?php
    if (isset($_GET["toiminto"]) && $_GET["toiminto"] === "kirjautuminenEiOnnistunut") {
        echo'?</a>';
    } else {
        echo'</a>';
    }
    ?>



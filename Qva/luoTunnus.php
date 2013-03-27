<h1>Luo uusi tunnus</h1>
<p>Nimen ja salasanan enimmäispituus on 16 merkkiä.</p>
<form action="luoTunnusLogiikka.php" method="post">
    Nimi:<br>
    <input type="text" name="tunnus" size ="16" maxlength="16"> <br><br>
    Salasana:<br>
    <input type="password" name="salasana" size ="16" maxlength="16"> <br><br>
    <input type="submit" value="Luo tunnus"><br><br>
</form>
<?php
if ($_GET["toiminto"] === "tunnuksenLuontiEiOnnistunut") {
    ?>
    <p>Ikävä kyllä näyttää siltä että valitsemasi käyttäjätunnus on jo jonkun toisen käytössä :(</p>
    <?php
}
?>
<br>
<a href="tos.html" target="_BLANK">Käyttöehdot</a>
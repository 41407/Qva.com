<h1>Luo uusi tunnus</h1>
<p>Nimen ja salasanan enimmäispituus on 16 merkkiä.</p>

<form action="luoTunnusLogiikka.php" method="post">
    Nimi:
    <input type="text" name="tunnus" size ="16" maxlength="16"> <br>
    Salasana:
    <input type="password" name="salasana" size ="16" maxlength="16"> <br>
    <input type="submit" value="Luo tunnus"><br><br>
</form>

<?php

if($_GET["toiminto"] === "tunnuksenLuontiEiOnnistunut") {
    ?>
    <p>Ikävä kyllä näyttää siltä että valitsemasi käyttäjätunnus on jo jonkun toisen käytössä :(</p>
<?php
}

?>
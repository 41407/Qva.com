<?php
$url = (!empty($_SERVER['HTTPS'])) ? "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] : "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

if ($_GET["kuvatoiminto"] === "kommentoi") {
    ?>

    <form action="kuvaKommentoiLogiikka.php" method="post">
        <input type="text" name="kommentti" size ="80" maxlength="160">
        <input type="hidden" name="tunnus" value="<?php
    echo($_SESSION["kayttajanimi"]);
    ?>">
               <input type="hidden" name="kuvaid" value="<?php
           echo($_GET["kuvaid"]);
    ?>">
               <input type="submit" value="Kommentoi"><br><br>
    </form>

    <?php
} else {
    echo('<a href = "' . $url . '&kuvatoiminto=kommentoi">Lisää kommentti</a><br><br>');
}
?>

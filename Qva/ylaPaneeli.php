<div id="topMargin">
    <a href="?toiminto=etusivu">
        <div id="logo">
        </div>
    </a>
    <div id="topNav">
        <?php
            include("navigaatiopaneeli.php");
        ?>
    </div>
    <div id="userFeatures">
        <?php
        if (isset($_SESSION["kayttajanimi"])) {
            // käyttäjä kirjautunut
            include("kayttajanToiminnot.php");
        } else {
            // käyttäjä ei ole kirjautunut
            include("kirjautumispaneeli.php");
        }
        ?>
    </div>
</div>
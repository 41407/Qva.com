<div id="topMargin">
    <div id="logo">
        <a href="/?toiminto=etusivu"><img src="img/qvalogo.png" alt="qva.com">
        </a>
    </div>
    <div id="topNav">
        linkki jee jaa joo
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
<div id="container">
    <div id="top">
        <?php
        include("ylaPaneeli.php");
        ?>
    </div>
    <div id="main">
        <?php
        $toiminto = $_GET["toiminto"];
        if ($toiminto === "luoTunnus") {
            include("luoTunnus.php");
        } else if ($toiminto === "etusivu") {
            include("etusivu.php");
        } else {
            include("etusivu.php");
        }
        ?>
    </div>
</div>
<?php

$toiminto = $_GET["toiminto"];
switch ($toiminto) {
    case("luoTunnus"):
        include("luoTunnus.php");
        break;
    case("tunnuksenLuontiEiOnnistunut"):
        include("luoTunnus.php");
        break;
    case("etusivu"):
        include("etusivu.php");
        break;
    case("lisaaKuva"):
        include("lisaaKuva.php");
        break;
    case("omatKuvat"):
        include("etusivu.php"); //implementioi haku
        break;
    default:
        include("etusivu.php");
}
?>

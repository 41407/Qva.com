<?php
if (isset($_GET['toiminto'])) {
    $toiminto = $_GET["toiminto"];
} else {
    include("etusivu.php");
    die();
}
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
    case("kuvanLisaysEpaonnistui"):
        include("lisaaKuva.php");
        break;
    case("kuvanLisaysOnnistui"):
        include("etusivu.php"); // TODO
        break;
    case("omatKuvat"):
        include("etusivu.php"); //TODO
        break;
    case("kuva"):
        include("kuvasivu.php");
        break;
    case("hakuNimenPerusteella"):
        include("hakuNimenPerusteella.php");
        break;
    default:
        include("etusivu.php");
}
?>

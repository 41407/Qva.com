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
        include("etusivu.php");
        break;
    case("kuva"):
        include("kuvasivu.php");
        break;
    case("hakuNimenPerusteella"):
        include("hakuNimenPerusteella.php");
        break;
    case("hakutoiminto"):
        include("hakutoiminto.php");
        break;
    case("kayttajat"):
        include("kayttajat.php");
        break;
    case("tagit"):
        include("tagit.php");
        break;
    default:
        include("etusivu.php");
}
?>

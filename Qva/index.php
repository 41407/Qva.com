<?php
session_start();
$toiminto = $_GET["toiminto"];
if ($toiminto === "kirjauduUlos") {
    unset($_SESSION["kayttajanimi"]);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css" />
        <title>Qva.com</title>
    </head>
    <body>
        <?php
        include("layout.php");
        ?>
    </body>
</html>

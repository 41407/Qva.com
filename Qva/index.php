<?php
session_start();
if (isset($_GET['toiminto'])) {
    if ($_GET["toiminto"] === "kirjauduUlos") {
        unset($_SESSION["kayttajanimi"]);
    }
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

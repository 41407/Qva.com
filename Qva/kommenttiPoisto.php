<?php
if (isset($_GET["kommenttiID"])) {
    $id = $_GET["kommenttiID"];
}

try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=jiji", "jiji", "argh");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$kysely = $yhteys->prepare("DELETE FROM kommentti
    WHERE kommenttiid = ?");
$kysely->execute(array($id));
?>

<h1>Kommentti poistettu.</h1><p><script>
    document.write('<a href="' + document.referrer + '">Takaisin</a>');
</script></p>
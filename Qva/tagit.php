<h1>Tägit</h1>
<p>
    <?php
    try {
        $yhteys = new PDO("pgsql:host=localhost;dbname=jiji", "jiji", "argh");
    } catch (PDOException $e) {
        die("VIRHE: " . $e->getMessage());
    }
    $yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $kysely = $yhteys->prepare("SELECT DISTINCT tagnimi FROM kuvantagit ORDER BY tagnimi");
    $kysely->execute();
    $i = 0;
    while ($tagit = $kysely->fetch()) {
        if ($i > 0) {
            echo', ';
        }
        echo '<a href="?hakuTaginPerusteella&tag=' . $tagit["tagnimi"] . '">';
        echo $tagit["tagnimi"];
        echo '</a>';
        $i++;
    }
    ?>
</p>

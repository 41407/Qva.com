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

    /**
     * Tagien rivitystä varten string aakkosista
     */
    $abcString = "";
    for ($i = 0; $i < 26; $i++) {
        $char = chr($i + 97); // koska ascii
        $abcString = $abcString . $char;
    }
    $abcString = $abcString . "å" . "ä" . "ö";

    /**
     * Tägien printtaus
     */
    $i = 0;
    while ($tagit = $kysely->fetch()) {
        /**
         * Mahdollisen tyhjän tägin huomiotta jättäminen
         */
        if (strlen($tagit["tagnimi"]) == 0) {
            continue;
        }
        /**
         * Rivitys
         */
        if ($i > 0) {
            /**
             * Aakkostringi pilkotaan arrayksi in_arrayn vuoksi
             */
            $abcArray = str_split($abcString);
            $ekaChar = str_split($tagit["tagnimi"]);

            if (in_array($ekaChar[0], $abcArray)) {
                /**
                 * Jos tägin eka merkki on abcstringissä, sitä vastaava merkki
                 * poistetaan abcstringistä ja tehdään rivinvaihto
                 */
                $abcArray = explode($ekaChar[0], $abcString);
                $abcString = implode("", $abcArray);
                echo "\n";
                echo '</p><p>';
            } else {
                /**
                 * Jos ei, pilkku tägien väliin
                 */
                echo', ';
            }
        }
        /**
         * Tägin ja linkin printtaus
         */
        echo '<a href="?toiminto=hakuTaginPerusteella&tag=' . $tagit["tagnimi"] . '">';
        echo $tagit["tagnimi"];
        echo '</a>';
        $i++;
    }
    ?>
</p>

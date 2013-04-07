<p class="photoFeatures">
    <?php
    $url = (!empty($_SERVER['HTTPS'])) ? "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] : "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    
    /**
     * Kuvan tietojen muokkaaminen
     */
    echo '<a href ="';
    echo($url . '&kuvatoiminto=muokkaaKuvaa">');
    echo 'Muokkaa kuvan tietoja';
    echo '</a> | ';
    
    /**
     * Kuvan poistaminen
     */
    echo '<a href ="';
    echo($url . '&kuvatoiminto=poistaKuva">');
    echo 'Poista kuva';
    echo '</a>';
    ?>


</p>
<link rel="stylesheet" type="text/css" href="style.css" />
<?php
echo '<div id="lightbox" ';
echo '><img src="kuvat/' . $_GET["k"] . '">';
//echo 'style="background-image:url(' . "'kuvat/" . $_GET["k"] . "'" . ')">';
?>
<script>
    document.write('<a href="' + document.referrer + '">Takaisin</a>');
</script>
<?php
echo '</div>';
?>

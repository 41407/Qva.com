<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css" />
        <title>Qva.com</title>
    </head>
    <body>
        <div id="container">
            <div id="top">
                <div id="topMargin">
                    <div id="logo">
                        <img src="img/qvalogo.png" alt="qva.com">
                    </div>
                    <div id="topNav">
                        linkki jee jaa joo
                    </div>
                    <div id="userFeatures">
                        <?php
                        include("topPanel.php");
                        ?>
                    </div>
                </div>
            </div>
            <div id="main">
                <?php
                $toiminto = $_GET["toiminto"];
                if($toiminto === "luoTunnus") {
                    include("luoTunnus.php");
                } else {
                    include("etusivu.php");
                }              
                ?>
            </div>
        </div>
    </body>
</html>

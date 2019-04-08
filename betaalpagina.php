<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>IDEAL betalen</title>
        <style>
            * {
                text-align: center;
            }
            
            body {
                width: 50%;
                margin-left: 25%;
            }
            
            
        </style>
    </head>
    <body>
        <fieldset>
        <legend><h1>IDEAL betalen</h1></legend>
        <?php
        session_start();
        $bedrag=$_SESSION["aankoopbedrag"];
        
        print("<H2>U moet €$bedrag betalen</H2>");
        ?>
        <hr>
        <a href="bevestig.php?betaald=ja"><button>Bevestig betaling</button></a>
        <a href="bevestig.php?betaald=nee"><button>Annuleer betaling</button></a>
        </fieldset>
    </body>
</html>

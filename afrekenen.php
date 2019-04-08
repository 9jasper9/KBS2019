<?php include_once "includes/header.php"; ?>
<?php

// de winkelmand mag niet leeg zijn
if (! (isset($_SESSION["winkelmandje"])AND count($_SESSION["winkelmandje"])>0)) {
    include 'mand.php';
    exit();
}

if(isset($_POST["email"])){
    
    $email= filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $firstname = filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_STRING);
    $lastname  = filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_STRING);
    $birthdate = filter_input(INPUT_POST, "birthdate", FILTER_SANITIZE_STRING);
    $phone     = filter_input(INPUT_POST, "phone", FILTER_SANITIZE_NUMBER_INT);
    
    $postcode=filter_input(INPUT_POST, "postal_code", FILTER_SANITIZE_STRING);
    $huisnummer=filter_input(INPUT_POST, "street_number", FILTER_SANITIZE_STRING);
    $woonplaats=filter_input(INPUT_POST, "locality", FILTER_SANITIZE_STRING);
    $straatnaam=filter_input(INPUT_POST, "route", FILTER_SANITIZE_STRING);
    
    $user_class->createAccount($email, NULL, $firstname, $lastname, $phone, $birthdate, $postcode, $huisnummer, $woonplaats, $straatnaam);
    
}

// ald de gebruiker niet is ingelogd, laat hem inloggen of een account aanmaken
if(!$user_class->isloggedin()){
    // laat de gebruiker inloggen
    include 'bestelgegevens.php';
    exit();
}
    



?>
<main role="main" class="container" >
    <div class="row">
        <div class="col-lg-12" id="products-container">
            
         
            <h1>Bevestig uw bestelling:</h1>
            <div class="row">
            <div class="col-lg-12">
                <?php
        
        
        if (isset($_SESSION["winkelmandje"])AND count($_SESSION["winkelmandje"])>0) {
            $winkelmandje = $_SESSION["winkelmandje"];
            print("<table class=\"table\" border=\"1\">");
            print("<th>Product</th>");
            print("<th>Aantal</th >");
            print("<th>Prijs p/s</th >");
            print("<th>Prijs totaal</th >");

            $totaal = 0;
            foreach ($winkelmandje as $productID => $productarray) {
                    $product=$products_class->fetch($productID);
                $naam = $product['StockItemName'];
                $aantal = (int)$productarray['aantal'];
                $prijs = $product['RecommendedRetailPrice'];
                $prijsTotaal = $aantal * $prijs;
                $totaal = $totaal + $prijsTotaal;

                print("<tr>");
                print("<td>$naam</td>");
                print("<td>$aantal</td>");
                print("<td>€ $prijs</td>");
                print("<td>€ $prijsTotaal</td>");
                print("</tr>");
            }
            print(" </table>");
            print("Totaalprijs: $totaal");
            
            print("<br><br>");
            $userdata=$user_class->fetch($user_class->getUserID());
            print($userdata["voornaam"]." ".$userdata["achternaam"]."<br>");
            print($userdata["straatnaam"]." ".$userdata["huisnummer"]."<br>");
            print($userdata["postcode"].", ".$userdata["woonplaats"]."<br>");
            
        
            // sla de gegevens op als een onveranderbare bestelling
            // we willen niet dat er producten worden toegevoegd terwijl we betalen.
            $_SESSION["aankoopbedrag"]=$totaal;
            $_SESSION["aankoop"]=$_SESSION["winkelmandje"];

            print("<br>");
            print("<a href=\"betaalpagina.php\"> Bevestigen </a><br>");
        }
        
                
        ?>
            </div>
            </div>
        </div>
    </div>
</main>
<?php include_once "includes/footer.php"; ?>
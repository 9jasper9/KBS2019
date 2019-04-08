
<?php include_once "includes/header.php"; ?>
<main role="main" class="container" >
    <div class="row">
        <div class="col-lg-12" id="products-container">
            
            <style>
                td {
                    vertical-align: middle !important;
                }
            </style>
            <h1>Winkelwagen:</h1>
            <div class="row">
            <div class="col-lg-12">
                <?php
        
        if (isset($_SESSION["winkelmandje"]) AND isset($_GET["delete"])) {
            $winkelmandje = $_SESSION["winkelmandje"];
            
                #print ("TEST".$_GET["delete"]);
                unset($winkelmandje[$_GET["delete"]]);
                $_SESSION["winkelmandje"] = $winkelmandje;
            }
        
        if (isset($_SESSION["winkelmandje"])AND count($_SESSION["winkelmandje"])>0) {
            $winkelmandje = $_SESSION["winkelmandje"];
            print("<table class=\"table\">");
            print("<thead>");
            print("<tr>");
            print("<th>Product</th>");
            print("<th>Aantal</th >");
            print("<th>Prijs p/s</th >");
            print("<th>Prijs totaal</th >");
            print("<th>Verwijderen</th>");
            print("</tr>");
            print("</thead>");
            print("<tbody>");
            $totaal = 0;
            foreach ($winkelmandje as $productID => $productarray) {
                    $product=$products_class->fetch($productID);
                $naam = $product['StockItemName'];
                $aantal = $productarray['aantal'];
                $prijs = $product['RecommendedRetailPrice'];
                $prijsTotaal = $aantal * $prijs;
                $totaal = $totaal + $prijsTotaal;

                print("<tr>");
                print("<td>$naam</td>");
                print("<td><form method='post'><input type='hidden' name='productid' value='$productID'><input class='cartamount form-control' type='number' value='$aantal' name='productamount'></form></td>");
                print("<td>€ " . number_format($prijs, 2) . "</td>");
                print("<td>€ " . number_format($prijsTotaal, 2) . "</td>");
                print("<td><a href=\"mand.php?delete=$productID\" class='text-danger'><i class=\"fa fa-trash\"></i></a></td>");
                print("</tr>");
            }
            print("</tbody>");
            print("<tfoot>");
            print("<tr>");
            print("<td colspan='2'>&nbsp;</td>");
            print("<td><strong>Totaalprijs:</strong></td>");
            print("<td colspan='2'>&euro; " . number_format($totaal, 2) . "</td>");
            print("</tr>");
            print("</tfoot>");
            print("</table>");
            print("<a href=\"index.php\" class='btn btn-primary pull-left'><i class=\"fa fa-arrow-circle-left\" aria-hidden=\"true\"></i> Verder winkelen </a>");
            print("<a href=\"afrekenen.php\" class='btn btn-primary pull-right'><i class=\"fa fa-arrow-circle-right\" aria-hidden=\"true\"></i> Afrekenen </a><br>");
        } else {
            print("<h3>Uw winkelmandje is leeg</h3>");
            print("<a href=\"products.php\" class='btn btn-primary'><i class=\"fa fa-arrow-circle-left\" aria-hidden=\"true\"></i> Terug naar de webshop</a>");
        }
        ?>
            </div>
            </div>
        </div>
    </div>
</main>
<?php include_once "includes/footer.php"; ?>
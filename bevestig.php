<?php include_once "includes/header.php"; ?>

<main role="main" class="container" >
    <div class="row">
        <div class="col-lg-12" id="products-container">
            <?php include_once "includes/nav.php"; ?>
            <?php include_once "includes/carousel.php"; ?>
            
            <?php
if($_GET["betaald"]==="ja"){

    foreach($_SESSION["aankoop"] as $id => $aantal){
        $aantal=$aantal["aantal"];
        
        $sql = "update stockitemholdings set QuantityOnHand=QuantityOnHand-:aantal WHERE StockItemID = :id";
        $stmt = $connection->prepare($sql);
        $stmt->bindparam(':id', $id, PDO::PARAM_INT);
        $stmt->bindparam(':aantal', $aantal, PDO::PARAM_INT);
        $stmt->execute();
    }

    unset($_SESSION["aankoop"]);
    unset($_SESSION["aankoopbedrag"]);
    unset($_SESSION["winkelmandje"]);
    session_destroy();
    
    print("<h1>Betaling gelukt</h1>");
    
}else{
    print("<h1>betaling mislukt</h1>");
}
?>
        </div>
    </div>
</main>
<?php include_once "includes/footer.php"; ?>

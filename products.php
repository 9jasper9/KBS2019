<?php include_once "includes/header.php"; ?>
<main role="main" class="container">
    <div class="row">
        <div class="col-lg-2" id="sidebar">
            <?php include_once "includes/sidebar.php"; ?>
        </div>
        <div class="col-lg-10" id="products-container">
            <?php include_once "includes/nav.php"; ?>
            <?php include_once "includes/carousel.php"; ?>
            <h1>Blader door ons assortiment:</h1>
            <div>
                
            </div>
            <div class="row justify-content-end">
                <div class="col-md-4">
                    <form method="get" id="sort-form" class="justify-content-end form-inline">
                    <input name="category" type="hidden" value="<?php if(isset($_GET['category'])){echo htmlspecialchars($_GET['category']);}else{ echo '0';}?>">
                    <input name="amount" type="hidden" value="<?php if(isset($_GET['amount'])){echo htmlspecialchars($_GET['amount']);}else{ echo 'products-20';}?>">
                    <input name="search" type="hidden" value="<?php if(isset($_GET['search'])){echo htmlspecialchars($_GET['search']);}?>">
                    <label for="sort" class="sort-label" id="sort-label">Sorteer op: </label>
                    <select name="sort" class="form-control" id="sort">
                        <option value="titleasc" <?php if(isset($_GET['sort']) and $_GET["sort"]=="titleasc"){echo "selected";} ?>>Titel: A - Z</option>
                        <option value="titledesc" <?php if(isset($_GET['sort']) and $_GET["sort"]=="titledesc"){echo "selected";} ?>>Titel: Z - A</option>
                        <option value="priceasc" <?php if(isset($_GET['sort']) and $_GET["sort"]=="priceasc"){echo "selected";} ?>>Prijs: Laag - Hoog</option>
                        <option value="pricedesc" <?php if(isset($_GET['sort']) and $_GET["sort"]=="pricedesc"){echo "selected";} ?>>Prijs: Hoog - Laag</option>
                    </select>
                    </form>
                </div>
                <div class="amount-box">
                    <form method="get" id="product-amount" class="justify-conten-end form-inline">
                        <input name="category" type="hidden" value="<?php if(isset($_GET['category'])){echo htmlspecialchars($_GET['category']);}else{ echo '0';}?>">
                        <input name="search" type="hidden" value="<?php if(isset($_GET['search'])){echo htmlspecialchars($_GET['search']);}?>">
                        <input name="sort" type="hidden" value="<?php if(isset($_GET['sort'])){echo htmlspecialchars($_GET['sort']);}?>">
                        <label for="amount" class="sort-label" id="amount-label">Aantal producten:&nbsp;</label>
                        <select name="amount" class="form-control" id="amount">
                            <option value="products-10" <?php if(isset($_GET['amount']) and $_GET["amount"]=="products-10"){echo "selected";} ?>>10</option>
                            <option value="products-20" <?php if(isset($_GET['amount']) and $_GET["amount"]=="products-20"){echo "selected";} ?>>20</option>
                            <option value="products-30" <?php if(isset($_GET['amount']) and $_GET["amount"]=="products-30"){echo "selected";} ?>>30</option>
                            <option value="products-40" <?php if(isset($_GET['amount']) and $_GET["amount"]=="products-40"){echo "selected";} ?>>40</option>
                            <option value="products-50" <?php if(isset($_GET['amount']) and $_GET["amount"]=="products-50"){echo "selected";} ?>>50</option>
                        </select>
                    </form>
                </div>
            </div>
                <?php
                    $products=$products_class->fetchAllRequested();
                    
                if(empty($products)) {
                    echo "<div class='alert alert-primary btn-block text-center'>Er konden helaas geen producten worden gevonden 😢</div>";
                } else {
                    ?>
                    <div class="row">
                    <?php
                    
                    foreach($products as $key => $product) {
                        if(!empty($product['Photo'])) {
                           $image = 'data:image/jpeg;base64,'.base64_encode($product['Photo']);
                        } else {
                            $image = 'https://picsum.photos/380/?random';
                        }
                        ?>
                        <div class="col-lg-3 product-col">
                            <div class="card">
                                <img class="card-img-top" src="<?php echo $image; ?>" alt="Card image cap">
                                <span class="badge badge-dark">&euro; <?php echo number_format($product['RecommendedRetailPrice'], 2); ?></span>
                                <div class="card-body card-product">
                                    <h5 class="card-title"><?php echo $product['StockItemName']; ?></h5>
                                    <a href="product.php?product=<?php echo $product['StockItemID']; ?>" class="btn btn-primary btn-block">Bekijken</a>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    
                    ?>
                    </div>
            <div style="text-align: center">
                    <?php
                    $url="?";
                    $page=0;
                    if(isset($_GET['page'])){$page=(int)$_GET['page'];}
                    
                        if(isset($_GET['category'])){
                            $url.="category=".htmlspecialchars($_GET['category'])."&"; }
                        if(isset($_GET['sort'])){
                            $url.="sort=".htmlspecialchars($_GET['sort'])."&"; }
                        if(isset($_GET['search'])){
                            $url.="search=".htmlspecialchars($_GET['search'])."&"; }
                        if(isset($_GET['amount'])){
                            $url.="amount=".htmlspecialchars($_GET['amount'])."&"; }
                            
                    if($page >0){
                        $backurl=$url."page=".($page-1);
                        print('<a style="float:left;" href="'.$backurl.'"><-- vorige pagina</a>');
                    }
                    
                    print("page ".($page+1));
                    $pageamount = 10;
                    if(isset($_GET["amount"])){
                        if($_GET["amount"]=="products-10"){
                            $pageamount=10; }
                        if($_GET["amount"]=="products-30"){
                            $pageamount=30; }
                        if($_GET["amount"]=="products-40"){
                            $pageamount=40; }
                        if($_GET["amount"]=="products-50"){
                            $pageamount=50; }
                    }
                    if(count($products)==$pageamount){
                        $nexturl=$url."page=".($page+1);
                        print("<a style='float:right;' href='".$nexturl."'>volgende pagina --></a>");
                    }
                }?>
            </div>
        </div>
    </div>
</main>
<?php include_once "includes/footer.php"; ?>
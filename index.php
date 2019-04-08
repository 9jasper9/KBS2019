<?php include_once "includes/header.php"; ?>
<main role="main" class="container" >
    <div class="row">
        <div class="col-lg-12" id="products-container">
            <?php
            if(isset($message)) {
                echo '<div class="alert alert-success" role="alert">' . $message . ' </div>';
            }
            ?>
            <?php include_once "includes/nav.php"; ?>
            <?php include_once "includes/carousel.php"; ?>
            <h1>Kies een categorie:</h1>
            <div class="row">
                <?php
                $categories = $products_class->fetchAllCatNames();
                foreach($categories as $key => $category) {
                    if(!empty($category['Photo'])) {
                        $image = 'data:image/jpeg;base64,'.base64_encode($category['Photo']);
                    } else {
                        $image = 'http://placehold.it/380x380';
                    }
                    ?>
                    <div class="col-lg-3 product-col">
                        <div class="card">
                            <img class="card-img-top" src="<?php echo $image; ?>" alt="Card image cap">
                            <div class="card-body card-product">
                                <h5 class="card-title"><?php echo $category['StockGroupName']; ?></h5>
                                <a href="products.php?category=<?php echo $category['StockGroupID']; ?>" class="btn btn-primary btn-block">Bekijken</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</main>
<?php include_once "includes/footer.php"; ?>
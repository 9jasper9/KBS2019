<?php include_once "includes/header.php";

?>
<main role="main" class="container">
    <div class="row">
        <div class="col-lg-12" id="product-container">
            <?php

            if (isset($_GET['product'])) {
                $product = $products_class->fetch($_GET['product']);
                $stock = $products_class->fetchStockitemholdings($product['StockItemID'])['QuantityOnHand'];
                $category = $products_class->fetchCat($products_class->fetchCatForProduct($_GET['product'])['StockGroupID']);
            }
            if (!isset($_GET['product']) || empty($product)) {
                echo "<div class='alert alert-primary btn-block text-center'>Er konden helaas geen product worden gevonden 😢</div>";
            } else {
                ?>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Homepagina</a></li>
                    <li class="breadcrumb-item"><a
                                href="products.php?category=<?php echo $category['StockGroupID']; ?>"><?php echo htmlspecialchars($category['StockGroupName']); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo htmlspecialchars($product['StockItemName']); ?></li>
                </ol>
                <div class="row">
                    <?php
                    $media = $products_class->fetchMedia($product['StockItemID']);
                    if (empty($media)) {
                        $media = array(0 => array('file' => 'data:image/jpeg;base64,' . base64_encode($product['Photo']), 'isVideo' => 0));
                    } ?>
                    <div class="col-lg-6">
                        <style>
                            #product-title {
                                padding: 30px 0;
                            }

                            #product-carousel .list-inline {
                                white-space: nowrap;
                                overflow-x: auto;
                            }

                            #product-carousel .carousel-indicators {
                                position: static;
                                left: initial;
                                width: initial;
                                margin-left: initial;
                                justify-content: flex-start;
                            }

                            #product-carousel .carousel-indicators > li {
                                width: initial;
                                height: initial;
                                text-indent: initial;
                                max-width: 128px;
                            }

                            #product-carousel .carousel-indicators > li.active img {
                                opacity: 0.7;
                            }
                        </style>
                        <!-- main slider carousel -->
                        <div id="product-carousel" class="carousel slide">
                            <!-- main slider carousel items -->
                            <div class="carousel-inner">
                                <?php
                                foreach ($media as $key => $item) {
                                    if ($item['isVideo']) { ?>
                                        <div class="main-carousel <?php if ($key == 0) {
                                            echo "active";
                                        } ?> item carousel-item" data-slide-number="<?php echo $key; ?>">
                                            <video class="img-fluid" <?php if ($key == 0) { echo "id='myImage'"; } ?> controls>
                                                <source src="<?php echo $item['file']; ?>" type="video/mp4">
                                                <source src="<?php echo $item['file']; ?>" type="video/ogg">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                    <?php } else {
                                        ?>
                                        <div class="main-carousel <?php if ($key == 0) {
                                            echo "active";
                                        } ?> item carousel-item" data-slide-number="<?php echo $key; ?>">
                                            <img src="<?php echo $item['file']; ?>"
                                                 class="img-fluid" <?php if ($key == 0) {
                                                echo "id='myImage'";
                                            } ?>>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                            <!-- main slider carousel nav controls -->

                            <div class="carousel-indicators-container bg-dark">
                                <ul class="carousel-indicators list-inline">
                                    <?php
                                    foreach ($media as $key => $item) {
                                        if ($item['isVideo']) { ?>
                                            <li class="<?php if ($key == 0) {
                                                echo "active";
                                            } ?> list-inline-item active">
                                                <a id="carousel-selector-<?php echo $key; ?>" class="selected"
                                                   data-slide-to="<?php echo $key; ?>"
                                                   data-target="#product-carousel">
                                                    <img src="images/video_thumb.png"
                                                         class="img-fluid product-thumb" style="padding: 15px; background: white;">
                                                </a>
                                            </li>
                                        <?php } else {
                                            ?>
                                            <li class="<?php if ($key == 0) {
                                                echo "active";
                                            } ?> list-inline-item active">
                                                <a id="carousel-selector-<?php echo $key; ?>" class="selected"
                                                   data-slide-to="<?php echo $key; ?>"
                                                   data-target="#product-carousel">
                                                    <img src="<?php echo $item['file']; ?>"
                                                         class="img-fluid product-thumb">
                                                </a>
                                            </li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h1 id="product-title"><?php echo htmlspecialchars($product['StockItemName']); ?></h1>
                        <h3>&euro; <?php echo number_format($product['RecommendedRetailPrice'], 2); ?>
                            <small>/stuk</small>
                        </h3>
                        <form method="post">
                            <div class="form-group">
                                <input type="number"
                                       name="productamount" id="product-amount" class="form-control"
                                       placeholder="Aantal" min="1" max="<?php echo $stock; ?>" step="1" value="1">
                                <input type="hidden" name="productid" value="<?php echo $product['StockItemID']; ?>">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                    <i class="fa fa-cart-plus" aria-hidden="true"></i> Toevoegen aan winkelwagen
                                </button>
                            </div>
                        </form>
                        <?php
                        $options = $products_class->fetchAlts($product['StockItemName']);
                        if (!empty($options) && count($options) > 1) {
                            ?>
                            <div class="form-group">
                                <label for="options" id="options-label">Andere varianten van dit product:</label>
                                <select class="form-control" id="product-type-select">
                                    <?php
                                    foreach ($options as $option) { ?>
                                        <option data-href="product.php?product=<?php echo $option['StockItemID']; ?>" <?php if ($product['StockItemName'] == $option['StockItemName']) {
                                            echo "selected";
                                        } ?>><?php echo $option['StockItemName']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php } ?>

                        <div class="row" style="margin-top: 15px;">
                            <div class="col-lg-12">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab" data-toggle="tab"
                                           href="#description" role="tab"
                                           aria-controls="home" aria-selected="true">Productomschrijving</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#specs"
                                           role="tab"
                                           aria-controls="contact" aria-selected="false">Specificaties</a>
                                    </li>
                                </ul>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="description" role="tabpanel"
                                                 aria-labelledby="home-tab">
                                                <p>
                                                    <?php
                                                    if (!empty($product['MarketingComments'])) {
                                                        echo $product['MarketingComments'];
                                                    } else {
                                                        echo $product['SearchDetails'];
                                                    }
                                                    ?>
                                                </p>
                                                <p>
                                                    <b>
                                                        <?php
                                                        if ($stock > 100) {
                                                            echo "Dit product is nog meer dan 100 keer op voorraad!";
                                                        } else {
                                                            echo "Dit product is nog maar $stock keer op voorraad!";
                                                        }
                                                        ?>
                                                    </b>
                                                </p>
                                                <p>
                                                    <?php
                                                    if (!empty($product['Tags'])) {
                                                        $tags = json_decode($product['Tags'], 1);
                                                        foreach ($tags as $key => $tag) {
                                                            echo "<a href='products.php?category=0&search=$tag' class='btn btn-primary btn-sm label-tag'>$tag</a>";
                                                        }
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                            <div class="tab-pane fade" id="specs" role="tabpanel"
                                                 aria-labelledby="contact-tab">
                                                <ul class="list-group">
                                                    <?php
                                                    if (!empty($product['Brand'])) {
                                                        echo "<li class=\"list-group-item\"><strong>Merk:</strong> " . $product['Brand'] . "</li>";
                                                    }
                                                    if (!empty($product['Size'])) {
                                                        echo "<li class=\"list-group-item\"><strong>Grootte:</strong> " . $product['Size'] . "</li>";
                                                    }
                                                    if (!empty($product['TypicalWeightPerUnit'])) {
                                                        echo "<li class=\"list-group-item\"><strong>Gewicht per stuk:</strong> " . $product['TypicalWeightPerUnit'] . "</li>";
                                                    }
                                                    if (!empty($product['CustomFields'])) {
                                                        $fields = json_decode($product['CustomFields'], 1);
                                                        foreach ($fields as $key => $field) {
                                                            if ($key !== 'Tags') {
                                                                echo "<li class=\"list-group-item\"><strong>" . $products_class->translateCustomFields($key) . ":</strong> " . $field . "</li>";
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 30px;">
                    <!-- TODO: Hier ff panneltje omheen zetten en aanbevolen producten inladen/weergeven -->
                    <div class="col-lg-12">
                        <div class="card" id="recommended-products">
                            <div class="card-header bg-primary text-light">
                                Vergelijkbare producten
                            </div>
                            <div class="recommended-product-slider bg-dark">
                                <div style="width: 1680px; padding: 15px;">
                                    <?php
                                    $products = $products_class->fetchAllForCatLimit($products_class->fetchCatForProduct($_GET['product'])['StockGroupID'], 0, 10);
                                    foreach ($products as $key => $product) {
                                        if (!empty($product['Photo'])) {
                                            $image = 'data:image/jpeg;base64,' . base64_encode($product['Photo']);
                                        } else {
                                            $image = 'https://picsum.photos/380/?random';
                                        }
                                        $id = $product['StockItemID'];
                                        echo "<a href='product.php?product=$id'><img src='$image' class='featured product-thumb'></a>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</main>
<?php include_once "includes/footer.php"; ?>

<div class="list-group">
    <b href="#" class="list-group-item list-group-header list-group-item-action bg-dark">Categorieën</b>
    <a href="products.php?category=0" class="list-group-item list-group-item-action <?php if($_GET['category'] == 0) { echo "active"; }; ?>">Everything</a>
    <?php
    $categories = $products_class->fetchAllCatNames();
    foreach($categories as $category) { ?>
        <a href="products.php?category=<?php echo $category['StockGroupID']; ?>" class="list-group-item list-group-item-action <?php if($_GET['category'] == $category['StockGroupID']) { echo "active"; }; ?>"><?php echo ucfirst($category['StockGroupName']); ?></a>
    <?php } ?>
</div>
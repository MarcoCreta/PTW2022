<?php if (count($templateParams['teachings']) == 0) : ?>
    <div>
        <p>Non ci sono prodotti da mostrare</p>
    </div>
<?php elseif (count($templateParams['teachings']) == 1) : ?>
    <?php foreach ($templateParams['teachings'] as $category => $products) : ?>

        <div class="category row" id="<?php echo $category ?>">
            <div class="row row-cols-1 row-cols-md-3 g-1" id="category-body">

                <?php
                $templateParams['products'] = $products;
                require 'shop-product.php';
                ?>
            </div>
        </div>
    <?php endforeach ?>

<?php else : ?>
    <?php foreach ($templateParams['teachings'] as $category => $products) : ?>

        <div class="category row" id="<?php echo $category ?>">
            <div class="d-flex" id="category-header">
                <h4><?php echo $category ?></h4>
                <a class="category-button ms-auto" href="shop.php?category=<?php echo $category ?>">see all</a>
            </div>
            <div class="row row-cols-1 row-cols-md-3 g-1" id="category-body">

                <?php
                $templateParams['products'] = array_slice($products, 0, 6);
                require 'shop-product.php';
                ?>
            </div>
        </div>
    <?php endforeach ?>
<?php endif ?>
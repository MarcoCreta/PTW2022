<?php if (count($templateParams['products']) == 0) : ?>
    <div>
        <p>Non ci sono prodotti da mostrare</p>
    </div>

<?php else : ?>
    <?php foreach ($templateParams['products'] as $product) : ?>

        <div class="shop-product card col-6 col-md-4" id="<?php echo $product['ID_content'] ?>">
            <span class="checkout-product-img card-img-top p-0">
                <svg class="card-img-top bd-placeholder-img img-thumbnail p-0" width="200" height="200" xmlns="http://www.w3.org/2000/svg" role="img" preserveAspectRatio="xMidYMid slice" focusable="false">
                    <rect width="100%" height="100%" fill="#868e96"></rect>
                </svg>
            </span>
            <div class="card-img-overlay">
                <p class="card-text"><?php echo $product['type'] ?></p>
            </div>
            <div class="card-body">
                <p class="card-text"><?php echo $product['description'] ?></p>
                <div class="d-flex">
                    <small class="text-muted"><?php echo $product['name'] ?></small>
                    <small class="text-muted ms-auto"><?php echo $product['price'] ?>€</small>
                </div>
            </div>
        </div>

    <?php endforeach ?>
<?php endif ?>
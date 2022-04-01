<div class="products-list" id="products-list">

    <?php if (count($templateParams['cart']['products']) == 0) : ?>
        <p>il carrello è vuoto</p>

    <?php else : ?>
        <?php foreach ($templateParams['cart']['products'] as $product): ?>
            <div class="cart-product card mb-3" id="<?php echo $product['ID_content'] ?>">
                <div class="card-body py-1">
                    <h5 class="product-name card-title"><?php echo $product['name'] ?></h5>
                    <div class="row align-items-center m-0">
                        <div class="col-sm-2 d-flex justify-content-center p-0">
                            <span class="checkout-product-img p-0">
                                <svg class="bd-placeholder-img img-thumbnail p-0" width="200" height="200" xmlns="http://www.w3.org/2000/svg" role="img" preserveAspectRatio="xMidYMid slice" focusable="false">
                                    <rect width="100%" height="100%" fill="#868e96"></rect>
                                </svg>
                            </span>
                        </div>
                        <div class="col-sm-10">
                            <div class="checkout-product-details">
                                <p class="text-secondary"><?php echo $product['theme_detail'] ?></p>
                                <div class="row d-flex align-items-center justify-content-between">
                                    <div class="col-9 mb-0 d-flex">
                                        <p>price : </p>
                                        <p class="product-price"><?php echo $product['price'] ?></p>
                                        <p> €</p>
                                    </div>

                                    <button class="col-2 remove-product">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    <?php endif ?>


</div>
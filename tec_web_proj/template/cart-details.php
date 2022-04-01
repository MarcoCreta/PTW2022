<?php 
$total = array_sum(array_column($templateParams['cart']['products'], 'price'));
$discount = 0;
$final_price = $total-$discount;

?>


<div class="order-details" id="order-details">
    <div class="card">
        <div class="card-body">
            <p><b>Dettagli ordine</b></p>
            <div class="d-flex justify-content-between mb-2">
                <span>
                    <p class="products-number" id="products-number">cart(<?php echo count($templateParams['cart']['products']) ?>)</p>
                </span>
                <span>
                    <p class="products-price" id="total"><?php echo $total ?> €</p>
                </span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Sconto</span>
                <span class="text-success"><?php echo $discount ?>€</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between mb-4">
                <span><strong>Prezzo finale</strong></span>
                <span>
                    <p class="final-price" id="final-price"><?php echo $final_price ?>€</p>
                </span>
            </div>
            <button id="place-order" href="#" class="btn btn-primary d-block mt-3 next col-12">Effettua ordine</button>
        </div>
    </div>
</div>
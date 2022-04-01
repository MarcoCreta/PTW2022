<?php if (count($templateParams['purchase']) == 0) : ?>
    <div>
        <p>Non ci sono transazioni da mostrare</p>
    </div>
<?php else : ?>
        <?php foreach ($templateParams['purchase'] as $transaction => $purchases) : ?>

            <article class="content transaction" id="<?php echo $transaction ?>">
                <div class="" id="transaction-header">
                    <h5 class="transaction-id">ID transazione : <?php echo $transaction ?></h5>
                    <div class="d-flex justify-content-between">
                        <p id="amount">Importo :<?php echo $purchases[0]['amount'] ?>€</p>
                        <p id="date"> Data :<?php echo $purchases[0]['date'] ?></p>
                        <p id="time"> Ora :<?php echo $purchases[0]['time'] ?></p>
                    </div>
                </div>
                <hr>

                <div class="" id="purchase-lis">
                    <?php foreach ($purchases as $purchase) : ?>
                        <div class="purchase group flex-row p-2 mb-2 rounded">
                            <div class="group-data-block ms-3">
                                <h6 class="product-name">Nome : <?php echo $purchase['name'] ?></h6>
                                <p class="" product-id="<?php echo $purchase['ID_content'] ?>">Prezzo : <?php echo $purchase['price'] ?>€</p>
                                <p class="">Tipo : <?php echo $purchase['type'] ?></p>
                                <p class="">Categoria : <?php echo $purchase['category'] ?></p>

                            </div>
                        </div>
                        <?php endforeach ?>
                </div>
                    </article>
        <?php endforeach ?>

<?php endif ?>
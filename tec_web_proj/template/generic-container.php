<?php if (isset($templateParams['container'])) : ?>

    <?php foreach ($templateParams['container'] as $container) : ?>


        <article class="content">
            <h6 class="mb-1 text-center"><?php echo $container['title']?></h6>
            <hr>
            <div class="inner-container">
                <?php require APP_ROOT . '/' . $container['element'] ?>
            </div>
        </article>

    <?php endforeach ?>

<?php endif ?>
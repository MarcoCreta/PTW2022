<nav class="side-nav">
<ul class="side-nav-list p-0">
    <?php foreach ($templateParams['side-nav'] as $element) : ?>

            <li class="side-nav-item">
                <a class="" id="<?php echo $element['name']?>-nav" href="<?php echo $element['element']?>">
                    <i class="ri-user bi <?php echo $element['icon']?> bg-soft-primary text-primary me-3"></i><?php echo $element['name']?>
                </a>
            </li>


    <?php endforeach ?>
    </ul>
</nav>
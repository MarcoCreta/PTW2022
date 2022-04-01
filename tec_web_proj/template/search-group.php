<?php if (isset($templateParams['groups'])) : ?>
    <?php if (count($templateParams['groups']) == 0) : ?>
        <p>non collabori con nessun gruppo</p>
    <?php else : ?>
        <?php foreach ($templateParams['groups'] as $group) : ?>
            <a class="group d-flex flex-row p-2 mb-2 rounded" href="edit-group.php?ID_group=<?php echo $group['ID_group'] ?>">
                <div class="group-data-block ms-3">
                    <h6 class="group-name"><?php echo $group['name'] ?></h6>
                    <div class="group-id" group-id="<?php echo $group['ID_group'] ?>"></div>
                </div>
                <?php if (!empty($group['collaboration'])) : ?>
                    <button class="c-button leave-group btn btn-secondary m-1 ms-auto">
                        <i class=""></i>
                    </button>
                <?php endif ?>
            </a>
        <?php endforeach ?>
    <?php endif ?>
<?php else : ?>
    <p>si è verificato un errore, riprova più tardi</p>
<?php endif ?>
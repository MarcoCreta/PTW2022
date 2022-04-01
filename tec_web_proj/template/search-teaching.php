<?php if (isset($templateParams['teachings'])) : ?>
    <?php if (count($templateParams['teachings']) == 0) : ?>
        <p>non c'è nessun teaching</p>
    <?php else : ?>
        <?php foreach ($templateParams['teachings'] as $teaching) : ?>
            <div>
                <div class="search-teaching p-2 mb-2 rounded">
                    <a class="teaching d-flex flex-column p-2 mb-2 rounded" href="edit-teaching.php?ID_group=<?php echo $teaching['ID_group']?>&ID_content=<?php echo $teaching['ID_content']?>">
                        <h6 class="teaching-name"><?php echo $teaching['teaching_name'] ?></h6>
                    </a>
                    <hr>
                    <?php if (isset($teaching['group_name'])) : ?>
                    <p class="group-name">Gruppo di appartenenza : <?php echo $teaching['group_name'] ?></p>
                    <?php endif ?>
                    <p class="group-name">Data di creazione : <?php echo $teaching['creation_date'] ?></p>
                    <p class="group-name">Tipologia : <?php echo $teaching['type'] ?></p>
                </div>
            </div>
        <?php endforeach ?>
    <?php endif ?>
<?php else : ?>
    <p>si è verificato un errore, riprova più tardi</p>
<?php endif ?>
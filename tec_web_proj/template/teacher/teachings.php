<article class="content tab-container" id="teachings-container">
    <div class="d-flex">
        <a class="back-button hidden" href="teacher-area.php"></a>
        <h3 class="mb-1 text-center">Teachings :</h3>
    </div>
    <hr>

    <?php if (isset($_GET['ID_group'])) : ?>
        <div id="new-teaching">
            <a type="button" class="button n-button m-1 w-100" href="edit-teaching.php?ID_group=<?php echo $_GET['ID_group'] ?>">
                <i class="bi bi-plus-circle"></i>
            </a>
        </div>

    <?php endif ?>

    <div class="row g-1" id='teachings-list'>
        <?php require APP_ROOT . '/template/search-teaching.php' ?>
    </div>
</article>
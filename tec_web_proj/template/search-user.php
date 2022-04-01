<?php if (count($templateParams['users']) == 0) : ?>
    <p>non ci sono utenti da mostrare</p>
<?php else : ?>
    <?php foreach ($templateParams['users'] as $user) : ?>
        <div class="user d-flex flex-row p-2 mb-2 rounded">
            <div class="user-img">
                <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" height="40" width="40" alt="<?php echo $user['username'] ?> profile img" class="avatar-35 rounded-circle img-fluid">
            </div>
            <div class="user-data-block ms-3">
                <a href="profile.php?user=<?php echo $user['username']?>"><h6 class="user-username"><?php echo $user['username']?></h6></a>
            </div>
            <?php if (empty($user['friendship'])) : ?>
                <button class="f-button f-add btn btn-primary m-1 ms-auto">
                    <i class=""></i>
                </button>
            <?php else : ?>
                <button class="f-button f-remove btn btn-secondary m-1 ms-auto">
                    <i class=""></i>
                </button>
            <?php endif ?>
        </div>

    <?php endforeach ?>
<?php endif ?>
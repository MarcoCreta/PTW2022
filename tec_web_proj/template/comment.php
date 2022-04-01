<?php foreach ($templateParams['comments'] as $comment) : ?>
    <div class="comment d-flex flex-row p-2 mb-2 rounded">
        <div class="user-img">
            <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" height="40" width="40" alt="<?php echo $comment['username'] ?> profile img" class="avatar-35 rounded-circle img-fluid">
        </div>
        <div class="comment-data-block ms-3">
            <a href="profile.php?user=<?php echo $comment['username'] ?>">
                <h6 class="comment-username"><?php echo $comment['username'] ?></h6>
            </a>
            <p class="mb-0 text-break"><?php echo $comment['content'] ?></p>
            <div class="comment-info d-flex align-items-left flex-wrap">
                <p class="comment-date mb-0 me-3 text-primary"><?php echo $comment['date'] ?></p>
                <p class="comment-time mb-0 text-primary"><?php echo $comment['time'] ?></p>
            </div>
        </div>
        <?php if ($comment['username'] == $_SESSION['username']) : ?>
            <div class="comment-toolbar ms-auto">
                <div class="dropdown">
                    <span class="" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                        <i class="bi bi-three-dots"></i>
                    </span>
                    <div class="dropdown-menu m-0 p-0">
                        <a class="dropdown-item delete-comment p-3">
                            <div class="d-flex align-items-top">
                                <i class="bi bi-trash"></i>
                                <div class="data ms-2">
                                    <h6>Elimina</h6>
                                    <p class="mb-0">cancella questo commento</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>
<?php endforeach ?>
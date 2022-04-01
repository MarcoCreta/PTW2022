<?php if (count($templateParams['posts']) == 0) : ?>
    <div>
        <p>Non ci sono post da mostrare</p>
    </div>

<?php else : ?>
    <?php foreach ($templateParams['posts'] as $post) : ?>
        <div class="post card col-12 mb-3 p-3">
            <div class="user-post-data">
                <div class="d-flex justify-content-between">
                    <div class="me-3">
                        <img class="rounded-circle img-profile" height="50" width="50" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" alt="${post.username} profile img">
                    </div>
                    <div class="w-100">
                        <div class="d-flex justify-content-between">
                            <div class="">
                                <div class="d-flex flex-row">
                                    <a href="profile.php?user=<?php echo $post['username'] ?>">
                                        <h5 class="post-username mb-0 d-inline-block" id="post-username"><?php echo $post['username'] ?></h5>
                                    </a>
                                    <?php if (isset($post['p_username'])) : ?>
                                        <?php if ($post['p_username'] != $post['username']) : ?>
                                            <i class="bi bi-caret-right-fill bx-3"></i>
                                            <a href="profile.php?user=<?php echo $post['p_username'] ?>">
                                                <h5 class="post-p_username"><?php echo $post['p_username'] ?></h5>
                                            </a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                <div class="post-profile" hidden><?php echo $post['ID_profile'] ?></div>
                                <div class="d-flex justify-content-between align-items-center flex-wrap">
                                    <p class="post-date mb-0 me-3 text-primary"><?php echo $post['date'] ?></p>
                                    <p class="post-time mb-0 text-primary"><?php echo $post['time'] ?></p>
                                </div>
                            </div>
                            <?php if ($post['username'] == $_SESSION['username'] || $post['ID_profile'] == ['ID_profile']) : ?>
                                <div class="post-toolbar ms-auto">
                                    <div class="dropdown">
                                        <span class="" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                            <i class="bi bi-three-dots"></i>
                                        </span>
                                        <div class="dropdown-menu m-0 p-0">
                                            <a class="dropdown-item delete-post p-3">
                                                <div class="d-flex align-items-top">
                                                    <i class="bi bi-trash"></i>
                                                    <div class="data ms-2">
                                                        <h6>Elimina</h6>
                                                        <p class="mb-0">cancella questo post</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="post-content mt-3">
                <p class="text-break"><?php echo $post['content'] ?></p>
            </div>
            <div class="post-image">
                <a hidden href="javascript:void();"><img src="" alt="post-image" class="img-fluid rounded w-100"></a>
            </div>
            <div class="comment-area mt-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="like-block position-relative d-flex align-items-center">
                        <div class="comment-number">
                            <?php echo $post['n_comments'] ?> commenti
                        </div>
                    </div>
                </div>
                <hr>
                <ul class="post-comments list-inline p-0 m-0">

                </ul>
                <form class="comment-form d-flex align-items-center mt-3">
                    <input type="text" class="form-control comment-text rounded" placeholder="Enter Your Comment">
                </form>
            </div>
        </div>

    <?php endforeach; ?>

<?php endif; ?>
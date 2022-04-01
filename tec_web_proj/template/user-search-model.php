<div class="user d-flex flex-row p-2 mb-2 rounded">
        <div class="user-img">
            <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" height="40" width="40" alt="${user.username} profile img" class="avatar-35 rounded-circle img-fluid">
        </div>
        <div class="user-data-block ms-3">
            <h6 class="user-username">${user.username}</h6>
        </div>

<?php if (true): ?>
    <a class="f-button f-add btn btn-primary m-1 ms-auto">
            <i class="bi bi-person-plus-fill"></i>
    </a>
<?php else: ?>
    <a class="f-button f-remove btn btn-secondary m-1 ms-auto">
            <i class="bi bi-person-x-fill"></i>
        </a>
<?php endif ?>
    </div>
<div hidden class="profile-info">
   <div class="profile-username" id="<?php echo $templateParams['profile_username'] ?>"></div>
   <div class="profile-id" id="<?php echo $templateParams['profile_ID'] ?>"></div>
</div>

<div class="post-model col-12 my-3">
   <form id="post-form" class="card card-block card-stretch card-height">
      <div class="card-header d-flex justify-content-between">
         <div class="header-title">
            <h4 class="card-title">Create Post</h4>
         </div>
      </div>
      <div class="card-body">
         <div class="d-flex align-items-center">
            <div class="post-text w-100 ">
               <input type="text" class="form-control rounded" id="post-text" placeholder="Write something here..." style="border:none;">
            </div>
         </div>
         <hr>
         <ul class=" post-opt-block d-flex list-inline m-0 p-0 flex-wrap">
            <li class="me-3 mb-md-0 mb-2">
               <button class="btn btn-soft-primary" type="button">
                  <i class="bi bi-image-fill"></i> Photo/Video
               </a>
            </li>
            
         </ul>
      </div>
   </form>
</div>
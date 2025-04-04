<div class="container py-5">
    <div class="custom-container custom-center">
    <!-- <h1 class="text-center"><u>Home Page</u></h1> -->
    <div  style="display: flex;justify-content: center;align-items: center;">
        <h2 class="header_title">Home Page</h2>
    </div>
    <div class="mt-4" style="display: flex;justify-content: center;align-items: center; padding-top: 25px;">
        <h3>Welcome <?php echo isset($user_name) ? $user_name : ''?></h3>
    </div>   
    <div class="mt-5 d-grid" style="padding-top: 25px;">
        <div class="text-center mt-3">
            <a href="<?php echo base_url('user/create_notification') ?>" class="btn btn-lg rounded-0  btn-color  full-width">Create Notification</a>
        </div>
        <div class="text-center mt-3">
            <a href="<?php echo base_url('user/list') ?>" class="btn btn-lg rounded-0  btn-color  full-width">Listing</a>
        </div>
        <?php if (isset($permission->category) && $permission->category == 'on') { ?>
        <div class="text-center mt-3">
            <a href="<?php echo base_url('category') ?>" class="btn btn-lg rounded-0  btn-color full-width">Category</a>
        </div>
        <?php }?>
        <?php if (isset($permission->companies) && $permission->companies == 'on') { ?>
        <div class="text-center mt-3">
            <a href="<?php echo base_url('companies') ?>" class="btn btn-lg rounded-0  btn-color full-width">Companies</a>
        </div>
        <?php }?>
    </div>
    </div>
</div>
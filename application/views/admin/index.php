<div class="container py-5">
    <div class="custom-container custom-center">
        <div style="display: flex;justify-content: center;align-items: center;">
            <h1 class="header_title"><b>Admin Screen</b></h1>
        </div>

        <h4 class="text-center mt-4"><a href="<?php echo base_url('#') ?>" style="color: #000;">Main Menu</a></h4>
        <div lass="mt-5 d-grid" style="padding-top: 45px;">
            <?php if ((isset($permission->category) && $permission->category == 'on') || $this->session->userdata('role') == 1) { ?>
                <div class="text-center mt-3">
                    <a href="<?php echo base_url('category') ?>" class="btn btn-lg rounded-0  btn-color full-width"><b>Category</b></a>
                </div>
            <?php } ?>
            <?php if ((isset($permission->companies) && $permission->companies == 'on') || $this->session->userdata('role') == 1) { ?>
            <div class="text-center mt-3">
                <a href="<?php echo base_url('companies') ?>" class="btn btn-lg rounded-0  btn-color full-width"><b>Companies</b></a>
            </div>
            <?php } ?>
            <div class="text-center mt-3">
                <a href="<?php echo base_url('admin/users') ?>" class="btn btn-lg rounded-0  btn-color full-width"><b>Users</b></a>
            </div>
            <div class="text-center mt-3">
                <a href="<?php echo base_url('admin/list') ?>" class="btn btn-lg rounded-0  btn-color full-width"><b>List</b></a>
            </div>
            <div class="text-center mt-3">
                <a href="<?php echo base_url('admin/settings') ?>" class="btn btn-lg rounded-0  btn-color full-width"><b>Settings</b></a>
            </div>
            <div class="text-center mt-3">
                <a href="<?php echo base_url('admin/log_out') ?>" class="btn btn-lg rounded-0  btn-color full-width"><b>Log Out</b></a>
            </div>
        </div>
    </div>
</div>
<div class="container py-5">
    <div class="custom-container custom-center">
        <div style="display: flex;justify-content: center;align-items: center;">
            <h1 class="header_title"><b>Settings</b></h1>
        </div>
        <div lass="mt-5 d-grid" style="padding-top: 45px;">
            <div class="text-center mt-3">
                <a href="<?php echo base_url('admin/settings/upload_type_size') ?>" class="btn btn-lg rounded-0  btn-color full-width"><b>File Upload Type/Size</b></a>
            </div>
            <div class="text-center mt-3">
                <a href="<?php echo base_url('admin/settings/upload_number') ?>" class="btn btn-lg rounded-0  btn-color full-width"><b>File Upload Number</b></a>
            </div>
            <div class="text-center mt-3">
                <a href="<?php echo base_url('admin/settings/notification_date_number') ?>" class="btn btn-lg rounded-0  btn-color full-width"><b>Reminder Notification date Number list</b></a>
            </div>
            <?php if ($this->session->userdata('role') == 1) { ?>
                <div class="text-center mt-3">
                    <a href="<?php echo base_url('admin/settings/permission') ?>" class="btn btn-lg rounded-0  btn-color full-width"><b>Permission</b></a>
                </div>
            <?php } ?>


        </div>
    </div>
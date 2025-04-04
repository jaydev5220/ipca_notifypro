<div class="custom-container custom-center">
    <form enctype="multipart/form-data" method="POST" id="settings_form" action="<?php echo current_url(); ?>">
        <div class="container pt-5">
            <div style="display: flex;justify-content: center;align-items: center;">
                <h4>File Upload Type</h4>
            </div>
            <div style="display: flex;justify-content: center;align-items: center;">
                <input type="text" id="upload_type" name="upload_type" placeholder="Please Type Here" style="padding: 15px;border: 2px solid black;background-color: rgba(154,220,255,.6);width:65%;" value="<?php echo isset($setting_data) ? $setting_data['upload_type'] : '' ?>" />
            </div>
        </div>
        <div class="container pt-4">
            <div style="display: flex;justify-content: center;align-items: center;">
                <h4>File Upload Size</h4>
            </div>
            <div style="display: flex;justify-content: center;align-items: center;">
                <input type="number" id="upload_size" name="upload_size" placeholder="Size in MB" style="padding: 15px;border: 2px solid black;background-color: rgba(154,220,255,.6);width:65%;" value="<?php echo isset($setting_data) ? $setting_data['upload_size'] : '' ?>" />
            </div>
        </div>
</div>
<div class="container pt-5 pl-4 pr-4">
    <div class="float-left">
        <button type="submit" class="btn full-width rounded-0 w-100" style="padding: 5px 25px 5px 25px;font-weight: 600;font-size: 16px;border: 2px solid black;">SUBMIT</button>
    </div>
    <div class="float-right">
        <a href="<?php echo base_url('settings') ?>" class="btn full-width rounded-0 w-100" style="padding: 5px 25px 5px 25px;font-weight: 600;font-size: 16px;border: 2px solid black;">CLEAR</a>
    </div>
</div>
</form>
<script>
    $(document).ready(function() {

        $('#settings_form').validate({
            rules: {
                upload_type: {
                    required: true,
                },
                upload_size: {
                    required: true,
                },
            },
            messages: {
                upload_type: {
                    required: "Please enter upload type",
                },
                upload_size: {
                    required: "Please enter upload size",
                },
            },
            submitHandler: function(form) {
                showLoader();
                //make ajax call
                $.ajax({
                    url: "<?php echo current_url(); ?>",
                    type: "POST",
                    data: $('#settings_form').serialize(),
                    success: function(response) {
                        if (response.status == 1) {
                            hideLoader();
                            toastr.success(response.message);
                            //redirect other page
                            setTimeout(function() {
                                window.location.href = "<?php echo base_url('admin/settings'); ?>";
                            }, 2000);
                        } else {
                            toastr.error(response.message);
                            hideLoader();
                        }
                    }
                });
            }
        });


    });
</script>
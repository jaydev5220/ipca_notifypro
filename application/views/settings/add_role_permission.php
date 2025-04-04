<div class="custom-container custom-center">
    <form enctype="multipart/form-data" method="POST" id="add_role">
        <div class="container pt-5">
            <input type="hidden" name="id" value="<?php echo isset($permission) ? $permission->id : '' ?>">
            <div style="display: flex;justify-content: center;align-items: center;">
                <h4>Role Name</h4>
            </div>
            <div style="display: flex;justify-content: center;align-items: center;">
                <input type="text" id="role_name" name="role_name" placeholder="Type here" value="<?php echo isset($permission) ? $permission->role_name : '' ?>" style="padding: 15px;border: 2px solid black;background-color: rgba(154,220,255,.6);width:65%;" />
            </div>

            <div class="permission_list pt-3 text-center">
                <div style="display: flex;justify-content: center;align-items: center;">
                    <h4>Permission</h4>
                </div>
                <div class="form-group">

                    <?php
                    $checked = '';
                    if (isset($permission->permission['category']) && $permission->permission['category'] == 'on') {
                        $checked = "checked";
                    } ?>
                    <input type="checkbox" id="category" name="permission[category]" <?php echo $checked;  ?>>
                    <label for="category">Category</label>
                </div>
                <div class="form-group">
                <?php
                    $checked = '';
                    if (isset($permission->permission['companies']) && $permission->permission['companies'] == 'on') {
                        $checked = "checked";
                    } ?>
                    <input type="checkbox" id="companies" name="permission[companies]"  <?php echo $checked;  ?>>
                    <label for="companies">Companies</label>
                </div>
            </div>
        </div>



        <div class="container pt-5 pl-4 pr-4">
            <div class="float-left">
                <button type="submit" class="btn full-width rounded-0 w-100" style="padding: 5px 25px 5px 25px;font-weight: 600;font-size: 16px;border: 2px solid black;">SUBMIT</button>
            </div>

            <?php if (isset($permission)) { ?>
                <div class="float-right">
                    <a href="<?php echo base_url('admin/settings/permission') ?>" class="btn full-width rounded-0 w-100" style="padding: 5px 25px 5px 25px;font-weight: 600;font-size: 16px;border: 2px solid black;">CANCEL</a>
                </div>

            <?php } else { ?>
                <div class="float-right">
                    <a href="javascript:void(0);" class="btn full-width rounded-0 w-100" id="clear" style="padding: 5px 25px 5px 25px;font-weight: 600;font-size: 16px;border: 2px solid black;">CLEAR</a>
                </div>
            <?php } ?>


        </div>
    </form>
</div>
<script>
    $(document).ready(function() {

        //make form submit event with validation
        $("#add_role").validate({
            rules: {
                role_name: {
                    required: true,

                },
            },
            messages: {
                role_name: {
                    required: "Please enter role name",
                },
            },
            submitHandler: function(form) {
                showLoader();
                //make ajax call
                $.ajax({
                    url: "<?php echo current_url(); ?>",
                    type: "POST",
                    data: $(form).serialize(),
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 1) {
                            hideLoader();
                            toastr.success(response.message);
                            setTimeout(function() {
                                window.location.href = "<?php echo base_url('admin/settings/permission') ?>";
                            }, 1000);
                        } else {
                            toastr.error(response.message);
                            hideLoader();
                        }
                    }
                });
            }
        });
        $('#clear').click(function() {
            $('#role_name').val('');
            $('#add_role input[type="checkbox"]').prop('checked', false);
        });

    });
</script>
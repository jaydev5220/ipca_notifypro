<div id="user_add">
    <div class="container py-5">
        <div style="display: flex;justify-content: center;align-items: center;">
            <h2 class="header_title">Password Update</h2>
        </div>
    </div>

    <form method="post" name="password_form" id="password_form" enctype="multipart/form-data" action="<?php echo base_url('admin/reset_password/' . $token) ?>">
        <input type="hidden" name="token" value="<?php echo $token ?>">
        <div class="container py-5">
            <div class="row">
                <div class="col-5">
                    <label for="password" class="form-label" style="font-size: 20px;">Password</label>
                </div>
                <div class="col-7">
                    <input type="password" id="new_password" name="new_password" class="form-control custom-input rounded-0" />
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-5">
                    <label for="confirm_password" class="form-label" style="font-size: 20px;">Confirm Password</label>
                </div>
                <div class="col-7">
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control custom-input rounded-0" />
                </div>
            </div>
        </div>

        <div class="container pt-5 pl-4 pr-4">
            <div class="float-left">
                <button type="submit" class="btn full-width rounded-0 w-100" style="padding: 5px 25px 5px 25px;font-weight: 600;font-size: 16px;border: 2px solid black;">SUBMIT</button>
            </div>
            <div class="float-right">
                <a href="<?php echo base_url('admin/users') ?>" class="btn full-width rounded-0 w-100" style="padding: 5px 25px 5px 25px;font-weight: 600;font-size: 16px;border: 2px solid black;">CLEAR</a>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        $('#password_form').validate({
            rules: {
                new_password: {
                    required: true,
                    minlength: 6
                },
                confirm_password: {
                    required: true,
                    equalTo: "#new_password"
                }
            },
            messages: {
                new_password: "Password is required",
                confirm_password: {
                    required: "Confirm password is required",
                    equalTo: "Passwords do not match"
                }
            },
            submitHandler: function(form) {
                var formData = new FormData(form);
                showLoader();
                $.ajax({
                    url: "<?php echo current_url() ?>",
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    success: function(data) {
                        if (data.status == 1) {
                            hideLoader();
                            toastr.success(data.message);
                            setTimeout(function() {
                                window.location.href = "<?php echo base_url('/') ?>";
                            }, 2000);
                        } else {
                            toastr.error(data.message);
                            hideLoader();
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        });
    });
</script>
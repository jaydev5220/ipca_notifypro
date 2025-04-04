<div class="container py-5">
    <div style="display: flex;justify-content: center;align-items: center;">
        <h2 class="header_title">Login Page</h2>
    </div>
    <div class="mt-5 d-grid" style="padding-top: 45px;">
        <form method="POST" id="login_form" class="mt-2" onsubmit="return false">
            <div class="mb-3">
                <label for="username" class="form-label" style="font-size: 20px;">Username</label>
                <input type="text" class="form-control custom-input rounded-0" id="username" style="width: 50%;" name="username">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label" style="font-size: 20px;">Password</label>
                <input type="password" class="form-control custom-input rounded-0" id="password" style="width: 50%;" name="password">
            </div>
            <div class="mt-4">
                <button type="submit" id="submit" name="submit" style="border: 1px solid #000; padding: 7px;color:#000;font-size: 20px;">SUBMIT</button>
            </div>
            <div class="mt-4">
                <a href="<?php echo base_url('admin/admin_reset_password') ?>" style="border: 1px solid #000; padding: 7px;color:#000;font-size: 20px;">
                    Reset password
                </a>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {

        //login form validation  
        $('#login_form').validate({
            rules: {
                username: {
                    required: true,
                },
                password: {
                    required: true,
                    minlength: 6
                }
            },
            messages: {
                tenant_email: "Please enter a valid username",
                tenant_password: "Please enter your password"
            },
            submitHandler: function(form) {
                showLoader();
                var formData = new FormData(form);
                $.ajax({
                    url: "<?php echo base_url('admin/login') ?>",
                    type: "POST",
                    data: formData,
                    success: function(data) {
                        if (data.status == 1) {
                            hideLoader();
                            toastr.success(data.message);
                            setTimeout(function() {
                                window.location.href = "<?php echo base_url('admin') ?>";
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
<div class="container">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-center">
                        <a href="javascript:void(0)" class="gap-2" style="text-decoration: none !important;">
                            <span class="app-brand-text demo text-body fw-bolder">Login</span>
                        </a>
                    </div>

                    <form method="POST" id="login_form" class="mt-2" onsubmit="return false">
                        <div class="mb-3">
                            <label for="username" class="form-label">Email</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter your email" autofocus />
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">Password</label>
                                <a href="<?php echo base_url('admin/admin_reset_password') ?>">
                                    <small>Reset Password?</small>
                                </a>
                            </div>
                            <input type="password" id="password" class="form-control" name="password" placeholder="Enter your password" />
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
                username: "Please enter a valid username",
                password: "Please enter your password"
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
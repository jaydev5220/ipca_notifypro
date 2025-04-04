    <style>
        #email {
            width: 50%;
            margin-left: 33%;
        }

        @media screen and (max-width: 768px) {
            #email {
                margin-left: 29%;
                width: 50%;
            }
        }
    </style>
    <div class="container text-center p-5">
        <h1>Password Reset</h1>
        <p>We Send You Email For Resetting Password, Kindly Check Your Email First Before Trying Again.</p>

        <form action="<?php echo site_url('admin/admin_reset_password') ?>" method="post" id="admin_reset_password">
            <div style="margin-top: 10%;">
                <label for="email" class="form-label" style="font-size: 20px;margin-left: -28%;">Email:</label>
                <input type="email" class="form-control custom-input rounded-0" id="email" name="email">
            </div>
            <div class="mt-4">
                <button type="submit" id="resend_button" style="border: 1px solid #000; padding: 7px;color:#000;font-size: 20px;">
                    Resend Email
                </button>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {

            $('#admin_reset_password').validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                        remote: {
                            url: "<?php echo base_url('Reset_password/email_not_exists') ?>",
                            type: "post",
                            data: {
                                email: function() {
                                    return $("#email").val();
                                },
                            }

                        }
                    },
                },
                messages: {
                    tenant_email: "Please enter a valid Email",
                    email: {
                        required: "Please enter your email address.",
                        email: "Please enter a valid email address.",
                        remote: "Email Not Exist!"
                    },
                },
                submitHandler: function(form) {
                    showLoader();
                    console.log('test');
                    var formData = new FormData(form);
                    $.ajax({
                        url: "<?php echo current_url() ?>",
                        type: "POST",
                        data: formData,
                        success: function(data) {
                            if (data.status == 1) {
                                hideLoader();
                                toastr.success(data.message);
                                setTimeout(function() {
                                }, 2500);
                            } else {
                                toastr.error(data.message);
                                hideLoader();
                            }
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                    $("#admin_reset_password")[0].reset();
                }
            });

        });
    </script>
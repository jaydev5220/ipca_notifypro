<div id="user_add">
    <div class="container py-5">
        <div style="display: flex;justify-content: center;align-items: center;">
            <h2 class="header_title">User Creation</h2>
        </div>
    </div>

    <form method="post" name="user_add_form" id="user_add_form" enctype="multipart/form-data">
        <div class="container py-5">
            <div class="row">
                <div class="col-5">
                    <label for="first_name" class="form-label" style="font-size: 20px;">First Name</label>
                </div>
                <div class="col-7">
                    <input type="text" id="first_name" name="first_name" value="<?php echo isset($user_data) ? $user_data['first_name'] : '' ?>" class="form-control custom-input rounded-0" />
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-5">
                    <label for="last_name" class="form-label" style="font-size: 20px;">Last Name</label>
                </div>
                <div class="col-7">
                    <input type="text" id="last_name" value="<?php echo isset($user_data) ? $user_data['last_name'] : '' ?>" name="last_name" class="form-control custom-input rounded-0" />
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-5">
                    <label for="email" class="form-label" style="font-size: 20px;">Email</label>
                </div>
                <div class="col-7">
                    <input type="text" id="email" name="email" value="<?php echo isset($user_data) ? $user_data['email'] : '' ?>" class="form-control custom-input rounded-0" />
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-5">
                    <label for="mobile" class="form-label" style="font-size: 20px;">Mobile</label>
                </div>
                <div class="col-7">
                    <input type="text" id="mobile" name="mobile" value="<?php echo isset($user_data) ? $user_data['mobile'] : '' ?>" class="form-control custom-input rounded-0" />
                </div>
            </div>
            <br />
            <?php if ($this->session->userdata('role') == '1') { ?>
                <div class="row">
                    <div class="col-5">
                        <label for="role" class="form-label" style="font-size: 20px;">Role</label>
                    </div>
                    <div class="col-7">
                        <select name="role" id="role" class="form-control custom-input rounded-0">
                            <option value="1" <?php if (isset($user_data) && $user_data['role'] == '1') {
                                                    echo 'selected';
                                                } ?>>Super Admin</option>
                            <option value="2" <?php if (isset($user_data) && $user_data['role'] == '2') {
                                                    echo 'selected';
                                                } ?>>Admin</option>
                            <option value="3" <?php if (isset($user_data) && $user_data['role'] == '3') {
                                                    echo 'selected';
                                                } ?>>User</option>
                            <option value="4" <?php if (isset($user_data) && $user_data['role'] == '4') {
                                                    echo 'selected';
                                                } ?>>Vendor</option>
                        </select>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="container pt-5 pl-4 pr-4">
            <div class="float-left">
                <button type="submit" class="btn full-width rounded-0 w-100" style="padding: 5px 25px 5px 25px;font-weight: 600;font-size: 16px;border: 2px solid black;">SUBMIT</button>
            </div>
            <?php if (isset($user_data)) { ?>
                <div class="float-right">
                    <a href="<?php echo base_url('admin/users') ?>" class="btn full-width rounded-0 w-100" style="padding: 5px 25px 5px 25px;font-weight: 600;font-size: 16px;border: 2px solid black;">CANCEL</a>
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
        //make ajax call fo form submit form submit
        $('#user_add_form').validate({
            rules: {
                first_name: {
                    required: true,
                },
                last_name: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: "<?php echo base_url('user_email_check') ?>",
                        type: "post",
                        data: {
                            email: function() {
                                return $("#email").val();
                            },
                            id: function() {
                                return "<?php echo isset($user_data) ? $user_data['id'] : '' ?>";
                            }

                        }

                    }
                },
                mobile: {
                    required: true,
                }
            },
            messages: {
                first_name: "Please enter your first name",
                last_name: "Please enter your last name",
                email: {
                    required: "Please enter your email address.",
                    email: "Please enter a valid email address.",
                    remote: "Email already in use!"
                },
                mobile: "Please enter a valid mobile number"
            },
            submitHandler: function(form) {
                var formData = new FormData(form);
                showLoader();
                $.ajax({
                    url: "<?php echo current_url() ?>",
                    type: "POST",
                    data: formData,
                    success: function(data) {
                        
                        if (data.status == 1) {
                            toastr.success(data.message);
                            hideLoader();
                            setTimeout(function() {
                                window.location.href = "<?php echo base_url('admin/users') ?>";
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

        //make clicl event for clear button
        $('#clear').click(function() {
            $('#user_add_form')[0].reset();
        });
    });
</script>
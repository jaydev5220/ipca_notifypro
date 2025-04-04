<style>
    #textarea {
        background-color: #b5e7ee;
    }

    th {
        text-align: center;
    }

    td {
        text-align: center;
    }

    textarea:focus {
        outline: none;
    }

    .select2-container {
        font-size: 25px;
        text-align: left !important;
        background: linear-gradient(to right, #ccffcc 0%, #99ccff 100%);
        padding-bottom: 15px !important;
        padding-top: 4px !important;
    }

    li:hover {
        background: gray !important;
    }

    @media (max-width: 767px) {
        li:hover {
            background: gray !important;
        }
    }
</style>
<div class="container py-5">
    <div style="display: flex;justify-content: center;align-items: center;">
        <h2 class="header_title">Create Notification</h2>
    </div>
    <?php
    $this->load->view('user/nav_bar');
    ?>
    <form class="mt-5" style="margin-left: 1%;" id="notification_add" method="post">
        <div class="d-grid gap-2 col-lg-4 col-md-6 mx-auto text-center">
            <div class="mt-3">
                <!-- <a class="btn btn-color  rounded-0" style="font-size: 25px;">Search <b>category</b></a> -->
                <select id="category_id" name="category_id" class="btn-color rounded-0" style="width: 70%;font-size: 25px;padding: 8px 7px;">
                    <option value="0">Search Category</option>
                    <?php foreach ($category_list as $category) : ?>
                        <option value="<?php echo $category['id']; ?>"><?php echo $category['category_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mt-3">
                <!-- <a class="btn btn-color  rounded-0" style="font-size: 25px;">Search <b>Company</b></a> -->
                <select id="company_id" name="company_id" class="btn-color rounded-0" style="width: 70%;font-size: 25px;padding: 8px 7px;">
                    <option value="0">Search Company</option>
                    <?php foreach ($company_list as $company) : ?>
                        <option value="<?php echo $company['id']; ?>"><?php echo $company['company_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mt-3">
                <select id="contact_list" class="btn-color rounded-0" style="width: 70%; font-size: 25px; padding: 8px 7px;">
                    <option value="0">Search Contact</option>

                </select>
            </div>
        </div>
        <div id="section1">
            <div class="mb-3">
                <label for="contact_name" class="form-label" style="font-size: 20px;">Contact Name :</label>
                <input type="text" class="form-control custom-input rounded-0" style="border: none;" id="contact_name" name="contact_name">
            </div>
            <div class="mb-3">
                <label for="whatsapp_no" class="form-label" style="font-size: 20px;">Whatsapp No :</label>
                <input type="text" class="form-control custom-input rounded-0" style="border: none;" id="whatsapp_no" name="whatsapp_no">
            </div>
            <div class="mb-3">
                <label for="email_id" class="form-label" style="font-size: 20px;">Email ID :</label>
                <input type="email" class="form-control custom-input rounded-0" style="border: none;" id="email_id" name="email_id">
            </div>
            <div class="float-left">
                <button type="button" id="nextButton" class="btn full-width rounded-0 w-100" style="padding: 5px 25px 5px 25px; font-weight: 600; font-size: 16px; border: 2px solid black;">NEXT</button>
            </div>
        </div>
        <div style="display: none;" id="section2">
            <div class="container py-5">

                <h3 class="text-center header_title"><b>Create Notification Details</b></h3>
                <div class="mt-2 ml-0 d-grid" style="padding-top: 45px;">
                    <div style="margin-left: 55px;">
                        <h5>Type Text :</h5>
                        <textarea name="type_text" id="textarea" cols="45" rows="5"></textarea>
                    </div>
                    <div>
                        <table class="table table-borderless mt-3" style="border-collapse: separate;border-spacing: 20px;">
                            <thead>
                                <tr>
                                    <th scope="col" class="btn-color">Reminder Period:</th>
                                    <th scope="col" class="btn-color">No.of Attachments:</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select style="border: 1px solid #000; width: 100%;text-align: center;height: 50px;" name="reminder_id">
                                            <?php
                                            if (isset($reminder_list)) {
                                                foreach ($reminder_list as $row) {

                                                    echo '<option value="' . $row['id'] . '">' . $row['notification_name'] . '</option>';
                                                }
                                            } else {
                                                echo '<option value="-1">No notifications available</option>';
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select style="border: 1px solid #000; width: 100%;text-align: center;height: 50px;" name="upload_number_id">
                                            <?php
                                            if (isset($no_of_attachments_list)) {
                                                foreach ($no_of_attachments_list as $row) {

                                                    echo '<option value="' . $row['upload_number'] . '">' . $row['upload_number'] . '</option>';
                                                }
                                            } else {
                                                echo '<option value="-1">No notifications available</option>';
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="height: 20px;"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="container pl-4 pr-4">
                        <div class="float-left">
                            <button class="btn full-width rounded-0 w-100" style="padding: 5px 25px 5px 25px;font-weight: 600;font-size: 16px;border: 2px solid black;">SUBMIT</button>
                        </div>
                        <!-- <div class="float-right">
                            <a href="<?php echo base_url('user/home_page') ?>" class="btn full-width rounded-0 w-100" style="padding: 5px 25px 5px 25px;font-weight: 600;font-size: 16px;border: 2px solid black;">RESET</a>
                        </div> -->
                        <div class="float-right">
                            <a href="javascript:void(0)" class="btn full-width rounded-0 w-100" id="reset" style="padding: 5px 25px 5px 25px;font-weight: 600;font-size: 16px;border: 2px solid black;">RESET</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        const nextButton = $('#nextButton');
        const resetButton = $('#reset');
        const section1 = $('#section1');
        const section2 = $('#section2');

        nextButton.on('click', function() {
            if ($('#notification_add').valid()) {
                // The form is valid, perform your action
                // For example, show/hide the next section
                section1.hide();
                section2.show();
            }
        });

        $("#company_id").select2({
            width: "70%",
            theme: "select2-container",
        });

        $("#contact_list").select2({
            width: "70%",
            theme: "select2-container",
        });

        resetButton.on('click', function() {
            section1.show();
            section2.hide();

        });

        $('#notification_add').validate({
            rules: {
                // Define validation rules for your fields
                contact_name: {
                    required: true
                },
                whatsapp_no: {
                    required: true
                },
                email_id: {
                    required: true,
                    email: true
                },
                // Add more validation rules for other fields
            },
            messages: {
                // Define custom error messages for your fields
                contact_name: {
                    required: 'Please enter a contact name.'
                },
                whatsapp_no: {
                    required: 'Please enter a WhatsApp number.'
                },
                email_id: {
                    required: 'Please enter an email address.',
                    email: 'Please enter a valid email address.'
                },
                // Add more custom error messages for other fields
            },
            submitHandler: function(form) {
                showLoader();
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
                                window.location.href = "<?php echo base_url('user/list') ?>";
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

        $('#company_id').on('change', function() {
            var company_id = $(this).val();
            console.log(company_id)

            if (company_id > 0) {
                $.ajax({
                    url: "<?php echo base_url('get_contacts_by_company') ?>",
                    method: 'POST',
                    data: {
                        company_id: company_id
                    },
                    success: function(data) {
                        if (data.status == 1) {
                            populateContactDropdown(data.company_details);
                        } else {
                            $('#contact_list').empty();
                            $('#contact_list').append($('<option>', {
                                value: 0,
                                text: 'Search Contact'
                            }));
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            } else {
                $('#contact_list').empty();
                $('#contact_list').append($('<option>', {
                    value: 0,
                    text: 'Search Contact'
                }));
            }
        });

        function populateContactDropdown(contact_details) {
            // Clear existing options in the dropdown
            $('#contact_list').empty();

            // Create an object to keep track of unique contact names
            var unique_contact_names = {};

            // Add the "Search Contact" static option
            $('#contact_list').append($('<option>', {
                value: 0,
                text: 'Search Contact'
            }));

            // Iterate through contact details and add unique contact names
            $.each(contact_details, function(key, value) {
                var contact_id = value.id;
                var contact_name = value.notification_name;

                // Check if contact name is unique
                if (!unique_contact_names[contact_name]) {
                    unique_contact_names[contact_name] = true;
                    $('#contact_list').append($('<option>', {
                        value: contact_id,
                        text: contact_name
                    }));
                }
            });
        }

        //make ajax call when contact name sleceted
        $('#contact_list').on('change', function() {
            var contect_id = $(this).val();

            // Fetch the contact details using AJAX
            $.ajax({
                url: "<?php echo base_url('get_contact_details') ?>",
                method: 'POST',
                data: {
                    contact_id: contect_id
                },
                success: function(data) {
                    if (data.status == 1) {
                        // Set the contact details in the respective input fields
                        $('#contact_name').val(data.contact_details.contact_name);
                        $('#whatsapp_no').val(data.contact_details.whatsapp_no);
                        $('#email_id').val(data.contact_details.email_id);
                    } else {
                        // Clear the input fields if no contact is selected
                        $('#contact_name').val('');
                        $('#whatsapp_no').val('');
                        $('#email_id').val('');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });
    });

    $(document).ready(function() {
        function adjustTextareaSize() {
            if ($(window).width() <= 767) {
                $('#textarea').attr('cols', 30);
                $('#textarea').attr('rows', 5);
            } else {
                $('#textarea').attr('cols', 45);
                $('#textarea').attr('rows', 5);
            }
        }
        adjustTextareaSize();
        $(window).resize(adjustTextareaSize);
    });
</script>
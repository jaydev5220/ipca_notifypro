<div class="custom-container custom-center">
    <form enctype="multipart/form-data" method="POST" id="add_notification_date_number" action="<?php echo current_url(); ?>">
        <div class="container pt-5">
            <input type="hidden" name="id" value="<?php echo isset($notification_date_number) ? $notification_date_number->id : '' ?>">
            <div style="display: flex;justify-content: center;align-items: center;">
                <h4>Reminder Notification  Name</h4>
            </div>
            <div style="display: flex;justify-content: center;align-items: center;">
                <input type="text" id="notification_name" name="notification_name" placeholder="Type here" value="<?php echo isset($notification_date_number) ? $notification_date_number->notification_name : '' ?>" style="padding: 15px;border: 2px solid black;background-color: rgba(154,220,255,.6);width:65%;" />
            </div>
        </div>



        <div class="container pt-5 pl-4 pr-4">
            <div class="float-left">
                <button type="submit" class="btn full-width rounded-0 w-100" style="padding: 5px 25px 5px 25px;font-weight: 600;font-size: 16px;border: 2px solid black;">SUBMIT</button>
            </div>

            <?php if (isset($company)) { ?>
                <div class="float-right">
                    <a href="<?php echo base_url('admin/settings/notification_date_number') ?>" class="btn full-width rounded-0 w-100" style="padding: 5px 25px 5px 25px;font-weight: 600;font-size: 16px;border: 2px solid black;">CANCEL</a>
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
        $("#add_notification_date_number").validate({
            rules: {
                notification_name: {
                    required: true,
                },
            },
            messages: {
                notification_name: {
                    required: "Please enter notification name",
                },
            },
            submitHandler: function(form) {
                showLoader();
               //make ajax call
                $.ajax({
                    url: "<?php echo base_url('admin/settings/add_notification_date_number') ?>",
                    type: "POST",
                    data: $(form).serialize(),
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 1) {
                            hideLoader();
                            toastr.success(response.message);
                            setTimeout(function() {
                                window.location.href = "<?php echo base_url('settings/notification_date_number') ?>";
                            }, 1000);
                        } else {
                            toastr.error(response.message);
                            hideLoader();
                        }
                    }
                });
            }
        });
      
     

        //make click event for clear button
        $("#clear").click(function() {
            $("#add_notification_date_number")[0].reset();
        });
    });
</script>
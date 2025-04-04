<div class="custom-container custom-center">
    <form enctype="multipart/form-data" method="POST" id="company_add" action="<?php echo current_url(); ?>">
        <div class="container pt-5">
            <input type="hidden" name="id" value="<?php echo isset($company) ? $company['id'] : '' ?>">
            <div style="display: flex;justify-content: center;align-items: center;">
                <h4>Company Name</h4>
            </div>
            <div style="display: flex;justify-content: center;align-items: center;">
                <input type="text" id="company_name" name="company_name" placeholder="Type here" value="<?php echo isset($company) ? $company['company_name'] : '' ?>" style="padding: 15px;border: 2px solid black;background-color: rgba(154,220,255,.6);width:65%;" />
            </div>
        </div>
        <div class="container pt-4">
            <div style="display: flex;justify-content: center;align-items: center;">
                <h4>State</h4>
            </div>
            <div style="display: flex;justify-content: center;align-items: center;">
                <!-- <input type="text" id="city" name="city" placeholder="Search" style="padding: 15px;border: 2px solid black;background-color: rgba(154,220,255,.6);" /> -->
                <select name="state" id="state" style="padding: 15px;border: 2px solid black;background-color: rgba(154,220,255,.6);width:65%;">
                    <?php if (!empty($state_list)) { ?>
                        <?php foreach ($state_list as $key => $value) { ?>
                            <option value="<?php echo $value['id'] ?>" <?php if (isset($company) && $company['state'] == $value['id']) {
                                                                            echo 'selected';
                                                                        } ?>><?php echo $value['name'] ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="container pt-4">
            <div style="display: flex;justify-content: center;align-items: center;">
                <h4>City</h4>
            </div>
            <div style="display: flex;justify-content: center;align-items: center;">
                <!-- <input type="text" id="state" name="state" placeholder="Search" style="padding: 15px;border: 2px solid black;background-color: rgba(154,220,255,.6);" /> -->
                <select name="city" id="city" style="padding: 15px;border: 2px solid black;background-color: rgba(154,220,255,.6);width:65%;">
                    <?php if (!empty($city_list)) { ?>
                        <?php foreach ($city_list as $key => $value) { ?>
                            <option value="<?php echo $value['id'] ?>" <?php if (isset($company) && $company['city'] == $value['id']) {
                                                                            echo 'selected';
                                                                        } ?>><?php echo $value['city'] ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
        </div>

</div>
<div class="container pt-5 pl-4 pr-4">
    <div class="float-left">
        <button type="submit" class="btn full-width rounded-0 w-100" style="padding: 5px 25px 5px 25px;font-weight: 600;font-size: 16px;border: 2px solid black;">SUBMIT</button>
    </div>

    <?php if (isset($company)) { ?>
        <div class="float-right">
            <a href="<?php echo base_url('companies') ?>" class="btn full-width rounded-0 w-100" style="padding: 5px 25px 5px 25px;font-weight: 600;font-size: 16px;border: 2px solid black;">CANCEL</a>
        </div>

    <?php } else { ?>
        <div class="float-right">
            <a href="javascript:void(0);" class="btn full-width rounded-0 w-100" id="clear" style="padding: 5px 25px 5px 25px;font-weight: 600;font-size: 16px;border: 2px solid black;">CLEAR</a>
        </div>
    <?php } ?>


</div>
</form>
<script>
    $(document).ready(function() {
        //make ajax call fo form submit form submit
        $("#company_add").submit(function(e) {
            showLoader();
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: $(this).attr("action"),
                type: "POST",
                data: formData,
                success: function(response) {
                    if (response.status === 1) {
                        hideLoader();
                        toastr.success(response.message);

                        setTimeout(function() {
                            window.location.href = "<?php echo base_url('companies') ?>"; 
                        }, 2000);
                    } else {
                        toastr.error(response.message);
                        hideLoader();
                    }
                },
                error: function() {
                    console.log('An error occurred during the AJAX request');
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });


        //state drodown change event 
        $("#state").change(function() {
            var state_id = $(this).val();
            $.ajax({
                url: "<?php echo base_url('admin/get_city_list'); ?>",
                type: "POST",
                data: {
                    state_id: state_id
                },
                success: function(data) {
                    console.log(data);
                    $("#city").html(data);
                }
            });
        });

        //make click event for clear button
        $("#clear").click(function() {
            $("#company_name").val('');
            $("#state").val('');
            $("#city").val('');
        });
    });
</script>
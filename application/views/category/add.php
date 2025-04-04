<style>
  .custom-container {
    height: 60vh;
  }

  .custom-center {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 20px;
  }

  .input-box {
    margin-top: 20px;
    width: 80%;
    padding: 10px;
    border: none;
    background-color: #b5e7ee;
    border-radius: 0;
    height: 15%;
  }

  .button-group {
    display: flex;
    justify-content: space-between;
    width: 100%;
    margin-top: 10px;
  }

  .btn_custome {
    width: 40%;
    padding: 10px;
    border: 1px solid #000;
    border-radius: 0;
    font-weight: 600;
    font-size: 25px;
  }

  input.input-box:focus {
    outline: none;
  }
</style>
<form method="post" name="category_add_form" id="category_add_form" enctype="multipart/form-data">
  <div class="container py-5">
    <div class="custom-container custom-center">
      <h5 class="text-center">Name of Category</h5>
      <input class="input-box" type="text" name="category_name" id="category_name" value="<?php echo isset($categoryData) ? $categoryData['category_name'] :'' ?>">
      <input type="hidden" name="hid" id="hid" value="<?php echo isset($categoryData) ? $categoryData['id'] :'' ?>">
    </div>

  </div>
  <div class="container pl-4 pr-4">
    <div class="float-left">
      <button type="submit" class="btn full-width rounded-0 w-100" style="padding: 5px 25px 5px 25px;font-weight: 600;font-size: 16px;border: 2px solid black;">SUBMIT</button>
    </div>
    <?php if(isset($categoryData)){?> 
      <div class="float-right">
      <a href="<?php echo base_url('category'); ?>" class="btn full-width rounded-0 w-100" style="padding: 5px 25px 5px 25px;font-weight: 600;font-size: 16px;border: 2px solid black;">CANCEL</a>
    </div>
      
    <?php }else{ ?>
         <div class="float-right">
      <a href="javascript:void(0);" class="btn full-width rounded-0 w-100" id="clear" style="padding: 5px 25px 5px 25px;font-weight: 600;font-size: 16px;border: 2px solid black;">CLEAR</a>
    </div>
    <?php } ?>
 
  </div>
</form>
<script>
  $(document).ready(function() {
    //make ajax call fo form submit form submit
    $('#category_add_form').validate({
      rules: {
        category_name: {
          required: true,
        },
      },
      messages: {
        category_name: "Please enter a valid category name",
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
              setTimeout(function () {
                    window.location.href = "<?php echo base_url('category') ?>"; 
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

    //make click event for clear button
    $('#clear').click(function() {
      $('#category_name').val('');
    });
  });
</script>
<style>
    .add-More-box {
        padding: 3px;
        border: 1px solid #000;
        background-color: #b5e7ee;
    }

    .add-More-box i {
        margin-right: 8px;
        color: #17a2b8;
    }

    .add-more-button {
        display: inline-block;
        padding: 4px 15px;
        margin: 10px;
        background-color: white;
        border: 2px solid #000;
        color: black;
        text-decoration: none;
        font-size: 16px;
        font-weight: 600;
    }

    #file-input {
        display: none;
        border: 1px solid #17a2b8;
    }
    
    @media (max-width: 767px) {
        img {
            width: 100%;
        }
    }
</style>
<div class="container">
    <div class="custom-container custom-center">
        <form method="post" enctype="multipart/form-data">
            <div class="mt-4">
                <?php if (isset($max_file) && $max_file > 0) { ?>
                    <div class="d-flex justify-content-end align-items-center">
                        <i class="fa fa-plus ml-2" aria-hidden="true"></i>
                        <div class="add-More-box">
                            <input type="file" id="file-input" name="file" />

                            <label id="file-input-label" for="file-input">ADD MORE</label>
                            <!-- <input type="file" class="mb-0 ml-1">ADD MORE</input> -->
                        </div>
                    </div>
                <?php } ?>
                <input type="hidden" name="notification_id" value="<?php echo isset($notification_id) ? $notification_id : '' ?>">
                <input type="hidden" name="document_texts" value="">
            </div>
            <?php if (!empty($notification_document)) { ?>

                <?php foreach ($notification_document as $key => $value) {
                    // $extension = pathinfo($value['document'], PATHINFO_EXTENSION); 
                ?>
                    <?php /*
                      <?php if ($extension == 'jpg') { ?>
                          <div class="row mb-4 mt-4">
                              <div class="col-6"></div>
                              <div class="col-6" style="display: flex;justify-content: center;align-items: center;"><a class="btn full-width rounded-0 document_remove" style="font-weight: 600;font-size: 16px;border: 1px solid black;width:65%;" href="javascript:void(0)" data-id="<?php echo $value['id'] ?>">Remove</a></div>
                          </div>
                      <?php } else if ($extension == 'pdf') { ?>
                          <div class="row mb-4 mt-4">
                              <div class="col-6"><i class="fa-regular fa-file-lines" style="font-size: 115px;"></i></div>
                              <div class="col-6" style="display: flex;justify-content: center;align-items: center;"><a class="btn full-width rounded-0 document_remove" style="font-weight: 600;font-size: 16px;border: 1px solid black;width:65%;" href="javascript:void(0)" data-id="<?php echo $value['id'] ?>">Remove</a></div>
                          </div>
  
                      <?php } else { ?>
                          <div class="row mb-4 mt-4">
                              <div class="col-6"><i class="fa-regular fa-file-lines" style="font-size: 115px;"></i></div>
                              <div class="col-6" style="display: flex;justify-content: center;align-items: center;"><a class="btn full-width rounded-0 document_remove" style="font-weight: 600;font-size: 16px;border: 1px solid black;width:65%;" href="javascript:void(0)" data-id="<?php echo $value['id'] ?>">Remove</a></div>
                          </div>
                      <?php } ?>
                 */ ?>

                    <!-- make image View -->
                    <div class="row mb-4 mt-4">
                        <div class="col-6">
                            <?php if (file_exists(FCPATH.'uploads/' . $value['notification_id'] . '/thumb' . '/' . $value['document'] . '.jpg')) { ?>
                                <img src="<?php echo  base_url('uploads/' . $value['notification_id'] . '/thumb' . '/' . $value['document'] . '.jpg') ?>" alt="NotifyPro">
                            <?php } else { ?>
                                <img src="<?php echo  base_url('uploads/no_img.jpg') ?>" alt="NotifyPro" >
                            <?php } ?>
                        </div>
                        <div class="col-6" style="display: flex;justify-content: center;align-items: center;"><a class="btn full-width rounded-0 document_remove" style="font-weight: 600;font-size: 16px;border: 1px solid black;width:65%;" href="javascript:void(0)" data-id="<?php echo $value['id'] ?>">Remove</a></div>
                    </div>


                <?php } ?>

            <?php } ?>

            <!-- <div class="row mt-3">
            <div class="col-6"><i class="fa fa-address-book" style="font-size: 115px;"></i></div>
            <div class="col-6" style="display: flex;justify-content: center;align-items: center;"><a class="btn full-width rounded-0 " style="font-weight: 600;font-size: 16px;border: 1px solid black;width:65%;" href="#">Remove</a></div>
        </div> -->
            <?php if (isset($max_file) && $max_file > 0) { ?>
                <div class="mt-5 text-center">
                    <button type="submit" class="add-more-button">SUBMIT</button>
                </div>
            <?php } else { ?>
                <div class="mt-5 text-center">
                    <button type="button" id="document_add" class="add-more-button">SUBMIT</button>
                </div>

            <?php } ?>

        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        //form submit ajax call
        $('form').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: '<?php echo base_url('do_upload') ?>',
                type: 'POST',
                data: formData,
                success: function(data) {
                    //json parse
                    data = JSON.parse(data);
                    if (data.status == "success") {
                        toastr.success(data.message);
                        setTimeout(function() {
                            window.location.reload()
                        }, 2000);
                    } else {
                        toastr.error(data.message);
                    }

                },
                cache: false,
                contentType: false,
                processData: false
            });
        });

        // add document 
        $('#document_add').click(function() {
            if (confirm('Are you sure you want submit document?')) {
                var notification_id = $('input[name="notification_id"]').val();
                $.ajax({
                    url: base_url + 'document_add',
                    type: 'POST',
                    data: {
                        id: notification_id
                    },
                    success: function(data) {
                        if (data.status == 1) {
                            toastr.success(data.message);
                            setTimeout(function() {
                                //location reload tank you page
                                window.location.href = data.redirect_url;

                            }, 1000);
                        } else {
                            toastr.error(data.message);
                        }
                    }
                });


            }
        });


        $('.document_remove').click(function() {
            //before delete conform
            if (confirm('Are you sure you want to delete this document?')) {

                var id = $(this).data('id');
                $.ajax({
                    url: '<?php echo base_url('vendor/remove_document') ?>',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(data) {
                        if (data.status == 1) {
                            toastr.success(data.message);
                            setTimeout(function() {
                                window.location.reload()
                            }, 2000);
                        } else {
                            toastr.error(data.message);
                        }

                    }
                });
            }
        });
    });
</script>
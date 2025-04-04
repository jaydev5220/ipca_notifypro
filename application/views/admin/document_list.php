<style>
    .button-container {
        display: flex;
        justify-content: center;
        width: 109%;
    }

    .button {
        padding: 3px 5px;
        margin: 5px;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
</style>

<div class="container py-5">
    <h4 class="text-center"><u>Document List</u></h4>

    <!-- document list  -->
    <div class="row mt-5 text-center">

        <div class="col-6" style="text-align: initial;">
            <h5>Document List</h5>
        </div>
        <div class="col-6">
            <h5>Action</h5>
        </div>
        <?php if (!empty($document_list)) { ?>
            <?php foreach ($document_list as $value) {       ?>

                <div class="col-6" style="display: flex;align-items: center;">
                    <!-- checkbox make -->
                    <input type="checkbox" name="document[]" id="document" class="document d-none" value="<?php echo $value['id'] ?>" style="margin-right: 10px;">
                    <?php if (file_exists(FCPATH . 'uploads/' . $value['notification_id'] . '/thumb' . '/' . $value['document'] . '.jpg')) { ?>
                        <img style="margin-top: 15px;" src="<?php echo  base_url('uploads/' . $value['notification_id'] . '/thumb' . '/' . $value['document'] . '.jpg') ?>" alt="NotifyPro">
                    <?php } else { ?>
                        <img style="margin-top: 15px;" src="<?php echo  base_url('uploads/no_img.jpg') ?>" alt="NotifyPro">
                    <?php } ?>
                </div>
                <div class="col-6" style="display: flex; justify-content: center; align-items: center;">
                    <div class="button-container">
                        <div class="button">
                            <a href="<?php echo base_url('download_file/' . $value['id']); ?>" id="download" class="btn" style="border: 1px solid;">Download</a>

                        </div>
                        <div class="button">
                            <a href="<?php echo base_url('view_file/' . $value['id']); ?>" id="view" class="btn" style="border: 1px solid;" target="_blank">View</a>

                        </div>
                    </div>
                </div>


            <?php } ?>

        <?php } ?>
    </div>

    <?php
    if ($status_1 !== 'accept') {
    ?>
        <form action="<?php echo base_url('user/document_confirmation') ?>" method="post" enctype="multipart/form-data">

            <input type="hidden" name="document_list[]" id="document_list" value="">

            <div class="mt-5 d-grid" style="padding-top: 5px;">
                <div id="accept" style="border: 1px solid #000;text-align: center;margin-left: 10%;margin-right: 67%;padding: 5px;">
                    Accept
                </div>
                <div id="reject" style="border: 1px solid #000;text-align: center;margin-left: 10%;margin-right: 67%;padding: 5px;margin-top: 3%;">
                    Reject
                </div>
                <div style="margin-left: 11%; margin-top: 5%;" id="reason_div" class="d-none">
                    <h5>Rejected Reason :</h5>
                    <textarea name="reason_textarea" id="reason_textarea" cols="35" rows="8"></textarea>
                </div>
            </div>
            <div style="margin: 15px 0px;">
                <input type="hidden" name="reject_type" id="reject_type" value="">
                <input type="hidden" name="notification_id" id="notification_id" value="<?php echo isset($notification_id) ? $notification_id : '' ?>">
                <button type="submit" style="border: 1px solid #000; padding: 7px; margin-left: 5%; margin-top: 3%;">
                    SUBMIT
                </button>
            </div>
        </form>

    <?php } ?>

</div>

<script>
    //on div click event value set in hidden input reject type
    $(document).on('click', '#accept', function() {
        $('#reject').css('border', "solid 1px #000");
        $('#reject_type').val('accept');
        $('#reason_div').addClass('d-none');
        $('.document').addClass('d-none');
        $(this).css('border', "solid 2px red");

    });
    $(document).on('click', '#reject', function() {
        $('#accept').css('border', "solid 1px #000");
        $('#reject_type').val('reject');
        $('.d-none').removeClass('d-none');
        $(this).css('border', "solid 2px red");
    });

    //form submit ajax call
    $(document).on('submit', 'form', function(e) {
        showLoader();
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        var type = form.attr('method');
        var data = new FormData(this);
        if ($('#reject_type').val() == 'reject' && $('#reason_textarea').val() == '') {
            hideLoader();
            toastr.error('Please enter reason');
            return false;
        }
        if ($('#reject_type').val() == '') {
            hideLoader();
            toastr.error('Please select accept or reject');
            return false;
        }
        var reject_type = $('#reject_type').val();
        if (reject_type == 'reject') {
            if ($('.document:checked').length === 0) {
                hideLoader();
                toastr.error('Please select at least one document.', 'Error', {
                    closeButton: true,
                    timeOut: 3000,
                    progressBar: true
                });
                return false;
            }
        }
        $.ajax({
            url: url,
            type: type,
            data: data,
            dataType: 'json',
            cache: false,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('.loading').removeClass('d-none');
            },
            success: function(response) {
                if (response.status == 1) {
                    hideLoader();
                    toastr.success(response.message);
                    setTimeout(function() {
                        window.location.href = "<?php echo base_url('admin/list') ?>";
                    }, 1000);
                } else {
                    hideLoader();
                    toastr.error(response.message);
                }
            }
        });
    });

    //when chckbox checked then value set in hidden input
    $(document).on('change', '.document', function() {
        var document_list = [];
        $('.document:checked').each(function() {
            document_list.push($(this).val());
        });
        $('#document_list').val(document_list);
    });
</script>
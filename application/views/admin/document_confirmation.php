<style>
    #reason_textarea {
        background-color: #4ebde6;
    }
</style>
<div class="container py-5">
    <h4 class="text-center"><u>Document Confirmation</u></h4>

    <!-- document list  -->
    <div class="row mt-5 text-center">

        <div class="col-6" style="text-align: initial;">
            <h5>Document List</h5>
        </div>
        <div class="col-6">
            <h5>Action</h5>
        </div>
        <?php if (!empty($document_list)) { ?>
            <?php foreach ($document_list as $value) { ?>

                <div class="col-6" style="display: flex;align-items: center;">
                    <!-- checkbox make -->
                    <input type="checkbox" name="document[]" id="document" class="document d-none" value="<?php echo $value['id'] ?>" style="margin-right: 10px;">
                    <?php if (file_exists(FCPATH . 'uploads/' . $value['notification_id'] . '/thumb' . '/' . $value['document'] . '.jpg')) { ?>
                        <img src="<?php echo  base_url('uploads/' . $value['notification_id'] . '/thumb' . '/' . $value['document'] . '.jpg') ?>" alt="NotifyPro" style="width: 100%;height: 100%;">
                    <?php } else { ?>
                        <img src="<?php echo  base_url('uploads/no_img.jpg') ?>" alt="NotifyPro" style="width: 100%;height: 100%;">
                    <?php } ?>
                </div>
                <div class="col-6" style="display: flex; justify-content: center; align-items: center;">
                    <h5><a href="<?php echo base_url('download_file/' . $value['id']); ?>" id="download" class="btn" style="border: 1px solid; width: 100%;">Download</a></h5>
                </div>


            <?php } ?>

        <?php } ?>
    </div>
</div>
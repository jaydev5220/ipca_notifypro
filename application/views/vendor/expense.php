<style>
    .rounded-icon {
        display: inline-flex;
        align-items: center;
        padding: 10px;
        border-radius: 20px;
        background-color: #b5e7ee;
        color: white;
        cursor: pointer;
    }

    .txt-content-box {
        border: 1px solid;
    }

    .txt-color-font {
        color: #000;
    }

    input[type=text] {
        outline: none;
    }

    /* .select2-container--default .select2-selection--single{} */

    @media (max-width: 767px) {
        #document_text {
            margin-left: 0px !important;
        }
    }
</style>

<div class="container py-3">
    <!-- <form action="<?php echo base_url('do_upload'); ?>" method="post" enctype="multipart/form-data" style="display: contents;"> -->
    <div class="custom-container custom-center">
        <h2 class="text-center"><u><?php echo isset($category_name) ? $category_name : ''; ?></u></h2>
        <div class="p-3 text-center">
            Please Submit <br>
            <?php echo $type_text; ?>
        </div>
        <textarea class="ml-2 mr-5 txt-content-box" style="background-color: #b5e7ee; width: 350px; height: 150px;" name="document_text" id="document_text"></textarea>
        <div class="mt-5">
            <div class="d-flex align-items-center ml-3">

                <!-- File Upload Dropzone -->
                <div id="dropzone" class="dropzone" style="width: 70%;height: auto;border: 2px solid;"></div>

                <!-- Submit Button -->
                <div style="display: contents;"><i class="fa fa-upload rounded-icon" aria-hidden="true"></i>
                    <p class="mb-0 ml-3">
                        <button type="button" id="upload" class="txt-color-font">UPLOAD FILE</button>
                    </p>
                </div>


            </div>
        </div>
    </div>
    <!-- </form> -->
</div>
<script>
    Dropzone.autoDiscover = false;
    $(document).ready(function() {
        var myDropzone = new Dropzone("#dropzone", {
            url: "<?php echo base_url('do_upload'); ?>",
            maxFilesize: <?php echo isset($max_size) ? $max_size : 25 ?>,
            addRemoveLinks: true,
            acceptedFiles: "<?php echo isset($allowed_types) ? $allowed_types : 'jpg' ?>",
            uploadMultiple: true,
            maxFiles: <?php echo isset($max_file) ? $max_file : 2 ?>,
            autoProcessQueue: false,
            init: function() {
                this.on("success", function(file, response) {
                    var obj = JSON.parse(response);
                    if (obj.status == 'success') {
                        toastr.success(obj.message);
                        //make redirect_url dynamic
                        setTimeout(function() {
                            window.location.href = obj.redirect_url;
                        }, 2000);
                    } else {
                        toastr.error(obj.message);
                    }
                });
            }
        });

        myDropzone.on('sending', function(file, xhr, formData) {
            formData.append('notification_id', <?php echo isset($notification_id) ? $notification_id : '' ?>);
            formData.append('document_text', $('textarea[name="document_text"]').val());
        });

        $("#upload").on("click", function(e) {
            e.preventDefault();
            var queuedFiles = myDropzone.getQueuedFiles();
            var fileCount = queuedFiles.length;
            var maxFile = <?php echo isset($max_file) ? $max_file : 2 ?>; // Default to 2 if not provided

            // Set parallel uploads based on the number of files
            myDropzone.options.parallelUploads = (fileCount <= maxFile) ? fileCount : maxFile;

            if (fileCount == maxFile) {
                myDropzone.processQueue();
            } else {
                // Process the queue to upload all files simultaneously
                toastr.error(maxFile + ' files to upload.');
            }
        });
    });
</script>
<div class="container py-5">

    <div style="display: flex;justify-content: center;align-items: center;">
        <h3 class="header_title" style="font-weight: 10 !important;">Category List</h3>
    </div>
    <!-- make table view -->
    <?php if ($this->session->userdata('role') == '1' || $this->session->userdata('role') == '2') { ?>
        <div class="float-right mt-4">
            <a href="<?php echo base_url('admin') ?>" class="btn full-width rounded-0 w-100 mt-5" style="border: 1px solid #000;">HOME</a>
        </div>
    <?php } else { ?>
        <?php
        $this->load->view('user/nav_bar');
        ?>
    <?php } ?>
    <div class="float-right m-4">
        <a href="<?php echo base_url('category/add') ?>" class="btn full-width rounded-0 w-100 mt-5" style="border: 1px solid #000;">Add New</a>
    </div>
    <div class="table_div table-responsive mt-5">
        <table class="table table-borderless mt-3" id="category_list" style="border-collapse: separate;">
            <thead>
                <tr>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">Sr.No</th>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">Name</th>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">Created Date</th>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">Update</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#category_list').DataTable({
            searching: false,
            paging: false,
            info: false,
            processing: true,
            serverSide: true,
            paging: false,
            scrollCollapse: true,
            scrollY: '40vh',
            ajax: {
                url: '<?= base_url('get_category_list') ?>',
                type: 'POST',
            },
            columns: [{
                    data: 'SrNo'
                },
                {
                    data: 'Name'
                },
                {
                    data: 'Created Date'
                },
                {
                    data: 'action'
                }
            ],
        });

    });
    $(document).on('click', '.delete-category', function() {
        var category_id = $(this).data('id');

        if (confirm('Are you sure you want to delete this category?')) {
            showLoader();
            $.ajax({
                url: '<?= base_url('category/delete') ?>',
                type: 'POST',
                data: {
                    category_id: category_id
                },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.status === 'success') {
                        hideLoader();
                        toastr.success(result.message);
                        $('#category_list').DataTable().ajax.reload();

                    } else {
                        toastr.error(result.message);
                        hideLoader();
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });
</script>
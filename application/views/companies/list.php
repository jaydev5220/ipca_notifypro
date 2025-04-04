<div class="container py-5">
    <div style="display: flex;justify-content: center;align-items: center;">
        <h2 class="header_title">Company List</h2>
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
        <a href="<?php echo base_url('add_company') ?>" class="btn full-width rounded-0 w-100 mt-5" style="background-color: rgba(154,220,255,.6);border: 2px solid black;"><i class="fa-solid fa-plus"></i> ADD NEW</a>
    </div>
    <div class="table_div table-responsive mt-5">
        <table class="table table-borderless mt-3" id="companies_list">
            <thead>
                <tr>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">Sr.No</th>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">Company</th>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">Created Date</th>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">City</th>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">State</th>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">Update</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#companies_list').DataTable({
                searching: false, // Hide search option
                paging: false, // Hide pagination
                info: false, // Hide "Showing x of y entries" info
                responsive: true, // Enable responsive extension
                paging: false,
                scrollCollapse: true,
                scrollY: '40vh',
                columnDefs: [{
                        targets: [0, 1, 2, 3, 4, 5],
                        className: "desktop"
                    },
                    {
                        targets: [0, 1, 5],
                        className: "tablet mobile"
                    },
                ],
                ajax: {
                    url: base_url + 'companies_list', // Replace with the correct URL
                    type: 'GET', // Use GET or POST based on your backend
                    dataType: 'json',
                },
                columns: [{
                        data: 'id'
                    }, // Replace 'column1' with your actual column names
                    {
                        data: 'company_name'
                    },
                    {
                        data: 'date_created'
                    },
                    {
                        data: 'city_name'
                    },
                    {
                        data: 'state_name'
                    },
                    {
                        data: 'action'
                    },
                ]

            }

        );

        // Delete company
        $(document).on('click', '.delete_compnay', function() {
            var company_id = $(this).data('id');

            if (confirm('Are you sure you want to delete this company?')) {
                showLoader();
                $.ajax({
                    url: base_url + 'company/delete',
                    type: 'POST',
                    data: {
                        company_id: company_id
                    },
                    success: function(response) {
                        if (response.status == 1) {
                            hideLoader();
                            toastr.success(response.message);
                            // Reload the table
                            $('#companies_list').DataTable().ajax.reload();
                        } else {
                            toastr.error(response.message);
                            hideLoader();
                        }
                    }
                });
            }
        });
    });
</script>
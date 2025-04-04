<div class="container py-5">
    <div style="display: flex;justify-content: center;align-items: center;">
        <h2 style="border-bottom: 2px solid black;padding-bottom: 5px;">User List</h2>
    </div>
    <!-- make table view -->
    <div class="float-right m-4">
        <a href="<?php echo base_url('admin/add_user') ?>" class="btn full-width rounded-0 w-100 mt-5" style="background-color: rgba(154,220,255,.6);border: 2px solid black;"><i class="fa-solid fa-plus"></i> ADD NEW</a>
    </div>
    <div class="table_div table-responsive mt-5">
        <table class="table table-borderless mt-3" id="admin_user_list" style="border-collapse: separate;">
            <thead>
                <tr>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">Sr.No</th>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">Username</th>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">Email</th>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">Mobile</th>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">Created Date</th>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">Update</th>
                </tr>
            </thead>

        </table>
    </div>
</div>
<script>
    $(document).ready(function() {

        $('#admin_user_list').DataTable({
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
                    url: base_url + 'admin/users/list_table', // Replace with the correct URL
                    type: 'GET', // Use GET or POST based on your backend
                    dataType: 'json',
                },
                columns: [{
                        data: 'id'
                    }, // Replace 'column1' with your actual column names
                    {
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'mobile'
                    },
                    {
                        data: 'date_created'
                    },
                    {
                        data: 'action'
                    },
                ]

            }

        );

        //delete user
        $(document).on('click', '.delete-user', function() {
            var user_id = $(this).data('id');

            if (confirm('Are you sure you want to delete this user?')) {
                showLoader();
                $.ajax({
                    url: base_url + 'admin/user/delete',
                    type: 'POST',
                    data: {
                        id: user_id
                    },
                    success: function(data) {
                        if (data.status == 1) {
                            hideLoader();
                            toastr.success(data.message);
                            setTimeout(function() {
                                $('#admin_user_list').DataTable().ajax.reload();
                            }, 1000);
                        } else {
                            toastr.error(data.message);
                            hideLoader();
                        }
                    }
                });
            }
        });
    });
</script>
<div class="container py-5">

    <div style="display: flex;justify-content: center;align-items: center;">
        <h3 class="header_title" style="font-weight: 10 !important;">Permission</h3>
    </div>
    <!-- make table view -->
    <div class="float-right m-4">
        <a href="<?php echo base_url('admin/settings/add_role_permission') ?>" class="btn full-width rounded-0 w-100 mt-5" style="border: 1px solid #000;">Add Role</a>
    </div>

    <div class="table_div table-responsive mt-5">
        <table class="table table-borderless mt-3" id="permission_list" style="border-collapse: separate;">
            <thead>
                <tr>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">Sr.No</th>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">Role</th>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script>
    //make datatable
    $(document).ready(function() {

        
        $('#permission_list').DataTable({
                searching: false,
                paging: false,
                info: false,
                paging: false,
                scrollCollapse: true,
                scrollY: '40vh',
                ajax: {
                    url: base_url + 'admin/settings/permission_list',
                    type: 'GET',
                    dataType: 'json',
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'role_name'
                    },
                    {
                        data: 'action'
                    },
                ]
            }

        );

     

    });
    $(document).on('click', '.delete-role_permission', function() {
        var id = $(this).data('id');
        if (confirm('Are you sure you want to delete this role permission?')) {
            showLoader();
            $.ajax({
                url: base_url + 'admin/settings/delete_role_permission/' + id,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status == 1) {
                        hideLoader();
                        toastr.success(response.message);
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    } else {
                        toastr.error(response.message);
                        hideLoader();
                    }
                }
            });
        }
    });
</script>
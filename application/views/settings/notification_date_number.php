<div class="container py-5">

    <div style="display: flex;justify-content: center;align-items: center;">
        <h3 class="header_title" style="font-weight: 10 !important;">Reminder Notification date</h3>
    </div>
    <!-- make table view -->
    <div class="float-right m-4">
        <a href="<?php echo base_url('admin/settings/add_notification_date_number') ?>" class="btn full-width rounded-0 w-100 mt-5" style="border: 1px solid #000;">Add New</a>
    </div>
    <div class="table_div table-responsive mt-5">
        <table class="table table-borderless mt-3" id="notification_date_number_list" style="border-collapse: separate;">
            <thead>
                <tr>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">Sr.No</th>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">Number</th>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">Created Date</th>
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

        $('#notification_date_number_list').DataTable({
                searching: false, // Hide search option
                paging: false, // Hide pagination
                info: false, // Hide "Showing x of y entries" info
                paging: false,
                scrollCollapse: true,
                scrollY: '40vh',
                ajax: {
                    url: base_url + 'admin/settings/get_notification_date_number', // Replace with the correct URL
                    type: 'GET', // Use GET or POST based on your backend
                    dataType: 'json',
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'notification_name'
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

        //make delete call
        $(document).on('click', '.delete-notification_name', function() {
            var id = $(this).data('id');
            if (confirm('Are you sure you want to delete this upload number?')) {
                showLoader();
                $.ajax({
                    url: base_url + 'admin/settings/delete_notification_date_number/' + id,
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
    });
</script>
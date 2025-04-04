<style>
    th {
        background-color: lightblue;
    }
</style>
<div class="container py-5">
    <div style="display: flex;justify-content: center;align-items: center;">
        <h2 class="header_title">Listing</h2>
    </div>

    <!-- make table view -->

    <div class="table_div table-responsive mt-5">

        <table class="table table-borderless mt-3" id="user_list" style="border-collapse: separate;">
            <thead>
                <tr>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">Sr.No</th>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">User</th>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">Date Sent</th>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">Category</th>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">Contact</th>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">Company</th>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">Whatsapp</th>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">Email Id</th>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">Status</th>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">Date Recieved</th>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">Document</th>
                    <th scope="col" style="background: #89c6e9; border:2px solid black !important;">Status</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        var all_columns = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
        var visible_columns = [1, 3, 4, 5];
        var table = $('#user_list').DataTable({
            info: true,
            searching: true,
            responsive: true,
            paging: true,
            pageLength: 25,
            scrollCollapse: true,
            scrollY: '60vh',
            scrollX: '60vh',
            ordering: false,
            columnDefs: [{
                    targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                    className: "desktop"
                },
                {
                    targets: [0, 1, 2, 3, 4, 5],
                    className: "tablet mobile"
                },
            ],
            ajax: {
                url: base_url + 'Admin/user_data_list_table',
                type: 'GET',
                dataType: 'json',
            },
            columns: [{
                    data: 'id',
                },
                {
                    data: 'user',
                },
                {
                    data: 'date_sent',
                },
                {
                    data: 'category',
                },
                {
                    data: 'contact',
                },
                {
                    data: 'company',
                },
                {
                    data: 'wp_number',
                },
                {
                    data: 'email_id',
                },
                {
                    data: 'status',
                },
                {
                    data: 'date_recieved',
                },
                {
                    data: 'document',
                },
                {
                    data: 'status_2',
                },
            ],
            initComplete: function() {
                var api = this.api();

                // Create a new row in the table header for visible columns
                var headerRow = $(api.table().header()).append('<tr id="filter-row"></tr>');

                // For each visible column
                $.each(all_columns, function(index, data) {
                    if (visible_columns.includes(data)) {
                        var columnHeader = $(api.column(data).header()).text();
                        $('#filter-row').append('<td><input type="text" placeholder="Search ' + columnHeader + '" class="filter-input" data-index="' + data + '" /></td>');
                    } else {
                        $('#filter-row').append('<td></td>');
                    }
                });

                // On every keypress in these inputs
                $('.filter-input', headerRow).off('input').on('input', function() {
                    var columnIndex = $(this).data('index');
                    var searchText = $(this).val().toLowerCase(); // Get the input value and convert to lowercase

                    // Filter the column based on the input value
                    table.column(columnIndex).search(searchText).draw();
                });
            }
        });
    });
</script>
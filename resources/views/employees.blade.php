@extends('adminlte::page')

@section('title', 'Employee List')

@section('content_header')
    <h1>All Employee List</h1>
@endsection

@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-end align-items-center">
            <div class="btn-group">
                <button class="btn btn-secondary me-2" onclick="collectSelectedIds()"><i class="fas fa-download"></i> Download ID Cards</button>
                <button class="btn btn-primary me-2" onclick="location.href='{{url('/registration')}}'"><i class="fas fa-plus"></i> Add New Employee</button>
                <button class="btn btn-success me-2" data-toggle="modal" data-target="#bulkUploadModal" onclick="open_bulk_uplaode()"><i class="fas fa-upload"></i> Bulk Upload</button>
                <button class="btn btn-danger me-2"><i class="fas fa-trash"></i> Bulk Delete</button>
            </div>
        </div>


        <div class="card-body">
            <table id="employeeTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th><input type="checkbox"></th>
                        <th>Name</th>
                        <th>Employee ID</th>
                        <th>Mobile Number</th>
                        <th>Employee Type</th>
                        <th>Role</th>
                        <th>Weekly Off</th>
                        <th>Department</th>
                        <th>Gate Off</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>


<x-adminlte-modal id="bulkUploadModal" title="Import Users" theme="primary" size="md" v-centered>
    <form action="{{ route('bulk_uoploade_request') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="text-center">
            <!-- File Input -->
            <x-adminlte-input-file name="user_file" label="Choose File" placeholder="No file chosen">
                <x-slot name="prependSlot">
                    <div class="input-group-text"><i class="fas fa-file-upload"></i></div>
                </x-slot>
            </x-adminlte-input-file>
        </div>

        <div class="d-flex flex-column gap-2 mt-3">
            <!-- Upload Button -->
            <x-adminlte-button type="submit" label="Upload" theme="dark" class="btn-block"/>

            <!-- Download Template Button -->
            <a href="{{url('/sample.csv')}}" class="btn btn-success btn-block">
                <i class="fas fa-file-excel"></i> Download XLS Format
            </a>

            <!-- Cancel Button -->
            <x-adminlte-button label="Cancel" theme="danger" data-dismiss="modal" class="btn-block"/>
        </div>
    </form>
</x-adminlte-modal>


@endsection

@section('js')
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
<script>
    $(document).ready(function () {
        $(document).ready(function() {
    $('#employeeTable').DataTable({
        dom: "<'row'<'col-sm-12'B>>" +
             "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Export to Excel',
                className: 'btn btn-success mb-3'
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> Export to PDF',
                className: 'btn btn-danger mb-3'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn btn-primary mb-3'
            },
            {
                extend: 'colvis',
                text: '<i class="fas fa-columns"></i> Column Visibility',
                className: 'btn btn-secondary dropdown-toggle mb-3',
                columnText: function(dt, idx, title) {
                    return title;
                },
                init: function(api, node, config) {
                    $(node).removeClass('dt-button').addClass('dropdown-toggle');
                }
            }
        ],
        responsive: true,
        autoWidth: false
    });
});


        // Search functionality
        $('#searchBox').on('keyup', function () {
            $('#employeeTable').DataTable().search($(this).val()).draw();
        });
    });

    function collectSelectedIds() {
        // Collect all checked checkboxes
        const checkboxes = document.querySelectorAll('input[name="delet_ids"]:checked');
        let ids = Array.from(checkboxes).map(cb => cb.value);

        // Convert the IDs array into a comma-separated string
        const searchInput = ids.join(',');
        location.href = "{{url('downloade-selected-id-cards/')}}/" + searchInput;

    }

    function attendance_data_set(url_input) {
    $.ajax({
        url: url_input,
        type: "GET",
        dataType: "json",
        headers: {
            "Content-Type": "application/json"
        },
        success: function(response) {
            console.log("Response:", response); // Debugging

            var all_users_data = response.all_users.data;
            var role_number = $("#role_number").val();
            var table_body = $("#employeeTable tbody");
            table_body.empty();

            all_users_data.forEach(all_users_data => {
                if (all_users_data.role >= role_number) {
                    var row = `
                        <tr>
                            <td><input type="checkbox" class="checkbox_ids" value="${all_users_data.id}"></td>
                            <td>${all_users_data.f_name} ${all_users_data.m_name} ${all_users_data.l_name}</td>
                            <td>${all_users_data.Employee_id}</td>
                            <td>${all_users_data.mobile_number}</td>
                            <td>${all_users_data.EmpTypeName}</td>
                            <td>${all_users_data.roles}</td>
                            <td>${all_users_data.Weekly_Off}</td>
                            <td>${all_users_data.Department_name}</td>
                            <td>${all_users_data.Gate_Off}</td>
                            <td>
                                <button class="btn btn-info btn-sm"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-warning btn-sm" onclick="window.location.href='/user-details/${user.id}'"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-primary btn-sm"><i class="fas fa-download"></i></button>
                            </td>
                        </tr>
                    `;
                    table_body.append(row);
                }
            });

            // Handle pagination
            var pagination_html = "";
            response.all_users.links.forEach((element, index) => {
                pagination_html += `<p data-page='${element.url}' class="${element.active ? 'active' : ''} page-btn">${element.label}</p>`;
            });

            $("#pagination_div").html(pagination_html);
        },
        error: function(xhr, status, error) {
            console.error("Error:", error);
        }
    });
}

</script>
@endsection

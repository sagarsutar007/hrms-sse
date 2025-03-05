@extends('adminlte::page')

@section('title', 'All Leave')

@section('content_header')
    <h1>All Leave</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">All Leave</h3>
                <div class="card-tools">
                    <a class="btn btn-light btn-sm" href=""><i class="fa fa-plus text-secondary"></i> Add New</a>
                    <a class="btn btn-light btn-sm" href=""><i class="fas fa-file-import text-secondary"></i> Bulk Upload</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="leaveTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Name <span onclick="sortData('Name')"><i class="fa-solid fa-sort"></i></span></th>
                                <th>Employee ID <span onclick="sortData('Employee_id')"><i class="fa-solid fa-sort"></i></span></th>
                                <th>Leave Type <span onclick="sortData('Leave_Type')"><i class="fa-solid fa-sort"></i></span></th>
                                <th>Start Date <span onclick="sortData('Start_Date')"><i class="fa-solid fa-sort"></i></span></th>
                                <th>End Date</th>
                                <th>Description</th>
                                <th>Remarks by Approver</th>
                                <th>Department</th>
                                <th>Status</th>
                                <th>Half Day</th>
                                <th>Total Days</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be inserted here dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <nav>
                    <ul class="pagination pagination-sm justify-content-end" id="pagination_div">
                        <!-- Pagination will be inserted here dynamically -->
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- View Leave Modal -->
<x-adminlte-modal id="leaveModal" title="Leave Details" theme="primary" icon="fas fa-info-circle" size="lg">
    <div class="row">
        <div class="col-md-6">
            <x-adminlte-input name="leaveName" label="Name" id="leaveName" readonly />
        </div>
        <div class="col-md-6">
            <x-adminlte-input name="leaveEmployee" label="Employee ID" id="leaveEmployee" readonly />
        </div>
        <div class="col-md-6">
            <x-adminlte-input name="leaveType" label="Leave Type" id="leaveType" readonly />
        </div>
        <div class="col-md-6">
            <x-adminlte-input name="leaveStart" label="Start Date" id="leaveStart" readonly />
        </div>
        <div class="col-md-6">
            <x-adminlte-input name="leaveEnd" label="End Date" id="leaveEnd" readonly />
        </div>
        <div class="col-md-6">
            <x-adminlte-input name="leaveDescription" label="Description" id="leaveDescription" readonly />
        </div>
        <div class="col-md-6">
            <x-adminlte-input name="leaveRemarks" label="Remarks by Approver" id="leaveRemarks" readonly />
        </div>
        <div class="col-md-6">
            <x-adminlte-input name="leaveStatus" label="Status" id="leaveStatus" readonly />
        </div>
        <div class="col-md-6">
            <x-adminlte-input name="leaveTotal" label="Total Days" id="leaveTotal" readonly />
        </div>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button class="btn btn-secondary" label="Close" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>

<!-- Edit Leave Modal -->
<x-adminlte-modal id="editLeaveModal" title="Edit Leave" theme="warning" icon="fas fa-edit" size="lg">
    <div class="row">
        <div class="col-md-6">
            <x-adminlte-input name="editLeaveType" label="Leave Type" id="editLeaveType" />
        </div>
        <div class="col-md-6 d-flex align-items-center mt-2">
            <label class="mr-2 mb-0">Half Day:</label>
            <input type="checkbox" id="editHalfDay" class="ml-2" style="transform: scale(1.5);">
        </div>
        <div class="col-md-6">
            <x-adminlte-input name="editStartDate" label="Start Date" id="editStartDate" type="date" />
        </div>
        <div class="col-md-6">
            <x-adminlte-input name="editEndDate" label="End Date" id="editEndDate" type="date" />
        </div>
        <div class="col-md-6">
            <x-adminlte-input name="editTotalDays" label="Total Days" id="editTotalDays" />
        </div>
        <div class="col-md-6">
            <x-adminlte-input name="editDescription" label="Description" id="editDescription" />
        </div>
        <div class="col-md-6">
            <x-adminlte-input name="editRemarks" label="Remarks by Approver" id="editRemarks" />
        </div>
        <div class="col-md-6">
            <x-adminlte-select name="editStatus" label="Status" id="editStatus">
                <option value="Approved">Approved</option>
                <option value="Rejected">Rejected</option>
                <option value="Pending">Pending</option>
            </x-adminlte-select>
        </div>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button class="btn btn-primary" label="Update" onclick="submitLeaveEdit()" />
        <x-adminlte-button class="btn btn-secondary" label="Close" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>

@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script>
       $(document).ready(function() {
    // Initialize DataTable
    var leaveTable = $('#leaveTable').DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
        "paging": true,
        "info": true,
        "searching": true,
        "ordering": true,
        "dom": 'lBfrtip',
        "buttons": [
            {
                extend: 'excel',
                exportOptions: {
                    columns: ':visible:not(:last-child)'
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: ':visible:not(:last-child)'
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible:not(:last-child)'
                }
            },
            'colvis',
        ],
        "language": {
            "lengthMenu": "_MENU_"
        }
    });

    // Initial load of data
    attendance_data_set("{{ route('search_leave') }}");

    // Search functionality
    $('#searchInput').on('keyup', function() {
        attendance_data_set("{{ route('search_leave') }}");
    });

    function viewLeaveDetails(id) {
    $.ajax({
        type: "GET",
        url: "{{ url('/leave-view/') }}/" + id,
        dataType: "json",
        success: function(response) {
            var r_data = response.data;

            // Populate the "View Leave Details" modal fields
            $("#leaveName").val(r_data.Name);
            $("#leaveEmployee").val(r_data.Employee_id);
            $("#leaveType").val(r_data.Leave_Type_name);
            $("#leaveStart").val(r_data.Start_Date);
            $("#leaveEnd").val(r_data.End_Date);
            $("#leaveDescription").val(r_data.Description);
            $("#leaveRemarks").val(r_data.Remarks_by_Approve);
            $("#leaveStatus").val(r_data.Status);
            $("#leaveTotal").val(r_data.Total_Days);

            // Open the modal
            $("#leaveModal").modal("show");
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
}

function editLeaveDetails(id) {
    $.ajax({
        type: "GET",
        url: "{{ url('/leave-edit/') }}/" + id,
        dataType: "json",
        success: function(response) {
            var r_data = response.data;

            // Populate the "Edit Leave" modal fields
            $("#editLeaveType").val(r_data.Leave_Type_name);
            $("#editHalfDay").prop("checked", r_data.Half_Day);
            $("#editStartDate").val(r_data.Start_Date);
            $("#editEndDate").val(r_data.End_Date);
            $("#editTotalDays").val(r_data.Total_Days);
            $("#editDescription").val(r_data.Description);
            $("#editRemarks").val(r_data.Remarks_by_Approve);
            $("#editStatus").val(r_data.Status);

            // Open the modal
            $("#editLeaveModal").modal("show");
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
}

});

$(document).ready(function () {
    var limit = 50;
    var sortClickCounts = {
        'Name': 1,
        'Employee_id': 1,
        'Leave_Type': 1,
        'Start_Date': 1
    };

    loadData();

    function loadData(url = "{{ url('/all-leaves-api') }}/" + limit) {
        $.ajax({
            url: url,
            type: "GET",
            dataType: "json",
            success: function (response) {
                renderTable(response.all_users.data);
                renderPagination(response.pagination);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching data:", error);
            }
        });
    }

    function renderTable(data) {
        var tableBody = $("#leaveTable tbody");
        tableBody.empty();

        if (data.length === 0) {
            tableBody.append(`<tr><td colspan="13" class="text-center">No data available</td></tr>`);
            return;
        }

        var rowIndex = 1;

        $.each(data, function (index, user) {
            var halfDayText = user.Half_Day ? "Yes" : "";
            var row = `<tr>
                <td>${rowIndex++}</td>
                <td>${user.Name}</td>
                <td>${user.Employee_id}</td>
                <td>${user.leave_Name}</td>
                <td>${user.Start_Date}</td>
                <td>${user.End_Date}</td>
                <td>${user.Description}</td>
                <td>${user.Remarks_by_Approve}</td>
                <td>${user.Department_name}</td>
                <td>${user.Status}</td>
                <td>${halfDayText}</td>
                <td>${user.Total_Days}</td>
                <td>
                    <button onclick="viewLeaveDetails(${user.id})" class="btn btn-sm btn-info">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                    <button onclick="editLeaveDetails(${user.id})" class="btn btn-sm btn-primary">
                        <i class="fa-solid fa-pencil"></i>
                    </button>

                </td>
            </tr>`;
            tableBody.append(row);
        });
    }

    function renderPagination(pagination) {
        var paginationDiv = $("#pagination_div");
        paginationDiv.empty();

        if (!pagination) return;

        for (var i = 1; i <= pagination.total_pages; i++) {
            var activeClass = i === pagination.current_page ? "active" : "";
            paginationDiv.append(`<li class="page-item ${activeClass}"><a class="page-link page-btn" data-page="${i}">${i}</a></li>`);
        }
    }

    $("#pagination_div").on("click", ".page-btn", function () {
        var page = $(this).data("page");
        loadData("{{ url('/all-leaves-api') }}/" + limit + "?page=" + page);
    });

    function sortData(column) {
        let method = (sortClickCounts[column] % 2 === 0) ? 'asc' : 'desc';
        sortClickCounts[column]++;
        loadData("{{ url('/all-leaves-short-api') }}/" + limit + "/" + column + "/" + method);
    }

    $("#search_btn").on("click", function (event) {
        event.preventDefault();
        var searchQuery = $("#search_input").val();
        loadData("{{ url('/all-leaves-search-api') }}/" + limit + "/" + searchQuery);
    });

    $("#limit_inputt").on("change", function () {
        limit = $(this).val();
        loadData("{{ url('/all-leaves-api') }}/" + limit);
    });
});




    </script>
@endsection

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
                <div class="float-right">
                    <button class="btn btn-sm btn-success" id="exportExcel">
                        <i class="fas fa-file-excel mr-1"></i> Excel
                    </button>
                    <button class="btn btn-sm btn-danger" id="exportPdf">
                        <i class="fas fa-file-pdf mr-1"></i> PDF
                    </button>
                    <button class="btn btn-sm btn-primary" id="printTable">
                        <i class="fas fa-print mr-1"></i> Print
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="leaveTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Name <span onclick="sortData('Name')"></span></th>
                                <th>Employee ID <span onclick="sortData('Employee_id')"></span></th>
                                <th>Leave Type <span onclick="sortData('Leave_Type')"></span></th>
                                <th>Start Date <span onclick="sortData('Start_Date')"></span></th>
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

@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap4.min.css">
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>
    <script>
        // Global functions to handle view and edit actions
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
                    alert("Error loading leave details. Please try again.");
                }
            });
        }

        function editLeaveDetails(id) {
            window.location.href = "{{ url('/edit-leave/') }}/" + id;
        }

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
                "language": {
                    "lengthMenu": "_MENU_"
                }
            });

            // Create custom export buttons
            var buttons = new $.fn.dataTable.Buttons(leaveTable, {
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Excel',
                        title: 'All Leave Data',
                        exportOptions: {
                            columns: ':visible:not(:last-child)'
                        },
                        className: 'hidden'
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        title: 'All Leave Data',
                        exportOptions: {
                            columns: ':visible:not(:last-child)'
                        },
                        className: 'hidden'
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        title: 'All Leave Data',
                        exportOptions: {
                            columns: ':visible:not(:last-child)'
                        },
                        className: 'hidden'
                    }
                ]
            });

            // Export button event handlers
            $('#exportExcel').on('click', function() {
                buttons.exportData(0);
            });

            $('#exportPdf').on('click', function() {
                buttons.exportData(1);
            });

            $('#printTable').on('click', function() {
                buttons.exportData(2);
            });

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

            window.sortData = function(column) {
                let method = (sortClickCounts[column] % 2 === 0) ? 'asc' : 'desc';
                sortClickCounts[column]++;
                loadData("{{ url('/all-leaves-short-api') }}/" + limit + "/" + column + "/" + method);
            };

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

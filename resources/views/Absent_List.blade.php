@extends('adminlte::page')

@section('title', 'Absent List')

@section('content_header')
    <h1>Absent List</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Employee Absent List</h3>
                <div class="card-tools">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Date</span>
                        </div>
                        <input type="date" id="date_input" class="form-control" onchange="change_date()">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary" id="search_btn" onclick="change_date()">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-success btn-sm mr-2" id="exportExcel" onclick="exportTableToExcel()">
                        <i class="fas fa-file-excel mr-1"></i> Excel
                    </button>
                    <button class="btn btn-danger btn-sm mr-2" id="exportPdf" onclick="exportTableToPDF()">
                        <i class="fas fa-file-pdf mr-1"></i> PDF
                    </button>
                    <button class="btn btn-primary btn-sm" id="printTable" onclick="printTable()">
                        <i class="fas fa-print mr-1"></i> Print
                    </button>
                </div>

                <div class="table-responsive" id="result">
                    <!-- Table data will be loaded here -->
                </div>
            </div>
            <div class="card-footer clearfix">
                <input type="text" value="{{ session('role_number') }}" id="role_number" hidden>
            </div>
        </div>
    </div>
</div>

<!-- Modal for leave details -->
<div class="modal fade" id="leaveDetailsModal" tabindex="-1" role="dialog" aria-labelledby="leaveDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="leaveDetailsModalLabel">Leave Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="leaveDetailsContent">
                <!-- Leave details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
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

    <script>
        // Initialize variables
        let absenceTable;
        let limit = 50;
        let page_url;

        // Disable search button initially
        $("#search_btn").prop("disabled", true);

        // Load data on page load
        $(document).ready(function() {
            loadData();

            // Enable search button when date is selected
            $("#date_input").on("change", function() {
                $("#search_btn").prop("disabled", false);
            });
        });

        function loadData() {
            page_url = "{{ url('/absent-employee-list/') }}/";
            fetchAttendanceData(page_url);
        }

        function change_date() {
            let date = $('#date_input').val();
            if (date) {
                page_url = "{{ url('/absent-employee-list/') }}/" + date;
                fetchAttendanceData(page_url);
            } else {
                toastr.warning('Please select a date first');
            }
        }

        function fetchAttendanceData(url_input) {
            // Show loading indicator
            $("#result").html('<div class="text-center"><i class="fas fa-spinner fa-spin fa-3x"></i><p class="mt-2">Loading data...</p></div>');

            $.ajax({
                url: url_input,
                type: "GET",
                dataType: "json",
                headers: {
                    "Content-Type": "application/json"
                },
                success: function(response) {
                    $("#result").empty();

                    let all_users_data = response.data;
                    if (all_users_data.length === 0) {
                        $("#result").html('<div class="alert alert-info">No absent employees found for the selected date.</div>');
                        return;
                    }

                    let table_html_data = `
                    <table id="absence_table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Employee Name</th>
                                <th>Employee ID</th>
                                <th>Shift Name</th>
                            </tr>
                        </thead>
                        <tbody>`;

                    let flag = 1;
                    all_users_data.forEach(employee => {
                        table_html_data += `
                        <tr>
                            <td>${flag}</td>
                            <td>${employee.name}</td>
                            <td>${employee.EmployeeID}</td>
                            <td>${employee.Shift_name}</td>
                        </tr>`;
                        flag++;
                    });

                    table_html_data += `
                        </tbody>
                    </table>`;

                    $("#result").html(table_html_data);

                    // Initialize DataTable
                    if ($.fn.DataTable.isDataTable('#absence_table')) {
                        $('#absence_table').DataTable().destroy();
                    }

                    absenceTable = $('#absence_table').DataTable({
                        "responsive": true,
                        "lengthChange": true,
                        "autoWidth": false,
                        "pageLength": 10,
                        "dom": '<"top"f>rt<"bottom"lip><"clear">'
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    $("#result").html('<div class="alert alert-danger">Error loading data. Please try again.</div>');
                }
            });
        }

        // Export functions
        function exportTableToExcel() {
            if (!$.fn.DataTable.isDataTable('#absence_table')) {
                toastr.error('No data available to export');
                return;
            }

            let currentDate = $('#date_input').val() || new Date().toISOString().slice(0, 10);
            let fileName = 'Absent_Employees_' + currentDate + '.xlsx';

            let buttons = new $.fn.dataTable.Buttons(absenceTable, {
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Excel',
                        title: 'Absent Employees - ' + currentDate,
                        filename: fileName.replace('.xlsx', ''),
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ]
            });

            buttons.container().appendTo('body');
            buttons.buttons().trigger();
            buttons.remove();
        }

        function exportTableToPDF() {
            if (!$.fn.DataTable.isDataTable('#absence_table')) {
                toastr.error('No data available to export');
                return;
            }

            let currentDate = $('#date_input').val() || new Date().toISOString().slice(0, 10);
            let fileName = 'Absent_Employees_' + currentDate + '.pdf';

            let buttons = new $.fn.dataTable.Buttons(absenceTable, {
                buttons: [
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        title: 'Absent Employees - ' + currentDate,
                        filename: fileName.replace('.pdf', ''),
                        exportOptions: {
                            columns: ':visible'
                        },
                        orientation: 'portrait',
                        pageSize: 'A4',
                        customize: function(doc) {
                            doc.defaultStyle.fontSize = 10;
                            doc.styles.tableHeader.fontSize = 11;
                            doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        }
                    }
                ]
            });

            buttons.container().appendTo('body');
            buttons.buttons().trigger();
            buttons.remove();
        }

        function printTable() {
            if (!$.fn.DataTable.isDataTable('#absence_table')) {
                toastr.error('No data available to print');
                return;
            }

            let buttons = new $.fn.dataTable.Buttons(absenceTable, {
                buttons: [
                    {
                        extend: 'print',
                        text: 'Print',
                        title: 'Absent Employees',
                        exportOptions: {
                            columns: ':visible'
                        },
                        customize: function(win) {
                            $(win.document.body).css('font-size', '10pt');
                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    }
                ]
            });

            buttons.container().appendTo('body');
            buttons.buttons().trigger();
            buttons.remove();
        }

        function viewLeaveDetails(id) {
            $.ajax({
                type: "GET",
                url: "{{ url('/leave-view/') }}/" + id,
                dataType: "json",
                success: function(response) {
                    var leaveData = response.data;

                    var detailsHtml = `
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Name</th>
                                    <td>${leaveData.Name}</td>
                                </tr>
                                <tr>
                                    <th>Employee ID</th>
                                    <td>${leaveData.Employee_id}</td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td>${leaveData.Description}</td>
                                </tr>
                                <tr>
                                    <th>Remarks by Approver</th>
                                    <td>${leaveData.Remarks_by_Approve}</td>
                                </tr>
                                <tr>
                                    <th>Total Days</th>
                                    <td>${leaveData.Total_Days}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Leave Type</th>
                                    <td>${leaveData.Leave_Type_name}</td>
                                </tr>
                                <tr>
                                    <th>Start Date</th>
                                    <td>${leaveData.Start_Date}</td>
                                </tr>
                                <tr>
                                    <th>End Date</th>
                                    <td>${leaveData.End_Date}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge ${leaveData.Status === 'Approved' ? 'badge-success' : (leaveData.Status === 'Rejected' ? 'badge-danger' : 'badge-warning')}">
                                            ${leaveData.Status}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>`;

                    $("#leaveDetailsContent").html(detailsHtml);
                    $("#leaveDetailsModal").modal("show");
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    toastr.error('Error loading leave details. Please try again.');
                }
            });
        }
    </script>
@endsection

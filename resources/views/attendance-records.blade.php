@extends('adminlte::page')

@section('title', 'Attendance List')

@section('content_header')
    <h1>Present/Absent List</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    <h3 class="card-title">Attendance Records</h3>
                </div>
                <div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-info" id="exportExcel">
                            <i class="fas fa-file-excel"></i> Excel
                        </button>
                        <button type="button" class="btn btn-danger" id="exportPDF">
                            <i class="fas fa-file-pdf"></i> PDF
                        </button>
                        <button type="button" class="btn btn-secondary" id="printTable">
                            <i class="fas fa-print"></i> Print
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <form action="{{ route('all_attendance_search') }}" method="post" class="form-inline">
                    @csrf
                    <div class="input-group">
                        <input type="search" class="form-control" name="search_input" id="search_input"
                            placeholder="Search by name & Email">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary" id="search_btn">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="mb-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="from_date">From Date</label>
                            <input type="date" class="form-control" id="from_date" name="from_date">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="to_date">To Date</label>
                            <input type="date" class="form-control" id="to_date" name="to_date">
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive" id="result">
                <!-- Table will be loaded here by AJAX -->
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3" id="pagination_div">
                <!-- Pagination will be loaded here -->
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>
    <script>
        $(function() {
            // Load attendance data on page load
            loadAttendance("{{ url('/get-attandence-data-api') }}");

            // Handle pagination click
            $('#pagination_div').on('click', '.page-link', function(e) {
                e.preventDefault();
                var page = $(this).data('page');
                loadAttendance(page);
            });

            // Handle search button click
            $("#search_btn").on("click", function(event) {
                event.preventDefault();
                var searchTerm = $("#search_input").val();
                var fromDate = $("#from_date").val();
                var toDate = $("#to_date").val();

                var url = "{{ url('/get-attandence-data-search-api') }}/" + searchTerm;
                if (fromDate) {
                    url += '?from=' + fromDate;
                    if (toDate) {
                        url += '&to=' + toDate;
                    }
                } else if (toDate) {
                    url += '?to=' + toDate;
                }

                loadAttendance(url);
            });

            // Handle export buttons
            $("#exportExcel").on("click", function() {
                exportTableToExcel();
            });

            $("#exportPDF").on("click", function() {
                exportTableToPDF();
            });

            $("#printTable").on("click", function() {
                printTable();
            });
        });

        // Function to load attendance data
        function loadAttendance(url) {
            // Show loading spinner
            $("#result").html('<div class="text-center"><i class="fas fa-spinner fa-spin fa-2x"></i></div>');

            $.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                headers: {
                    "Content-Type": "application/json"
                },
                success: function(response) {
                    $("#result").empty();

                    var all_attendance = response.attendance_data.data;

                    var table_html_data = `
                        <table id="attendance_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Date <i class="fas fa-sort"></i></th>
                                    <th>Employee ID <i class="fas fa-sort"></i></th>
                                    <th>Name <i class="fas fa-sort"></i></th>
                                    <th>Department</th>
                                    <th>Employee Type</th>
                                    <th>Shift</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>`;

                    all_attendance.forEach(user_data => {
                        // Check for different possible date property names
                        var date = user_data.attendance_Date || user_data.attendance_date || user_data.date || 'N/A';

                        var statusClass = user_data.status === 'present' ? 'text-success font-weight-bold' : 'text-danger font-weight-bold';
                        var statusText = user_data.status === 'present' ? 'Present' : 'Absent';

                        table_html_data += `
                            <tr>
                                <td>${date}</td>
                                <td>${user_data.Employee_id}</td>
                                <td>${user_data.NAME}</td>
                                <td>${user_data.Department_name}</td>
                                <td>${user_data.EmpTypeName}</td>
                                <td>${user_data.Shift_Name}</td>
                                <td class="${statusClass}">${statusText}</td>
                            </tr>`;
                    });

                    table_html_data += `</tbody></table>`;
                    $("#result").html(table_html_data);

                    // Build pagination
                    var pajination_data = response.attendance_data.links;
                    var pagination_html = '<ul class="pagination">';

                    pajination_data.forEach(element => {
                        pagination_html += `<li class="page-item ${element.active ? 'active' : ''}">`;
                        pagination_html += `<a class="page-link" href="#" data-page="${element.url}">${element.label}</a>`;
                        pagination_html += `</li>`;
                    });

                    pagination_html += `</ul>
                        <div>
                            <span class="text-muted">Page Size: ${response.attendance_data.per_page}</span> |
                            <span class="text-muted">Total Records: ${response.attendance_data.total}</span>
                        </div>`;

                    $("#pagination_div").html(pagination_html);

                    // Initialize DataTables for sorting
                    $('#attendance_table').DataTable({
                        "paging": false,
                        "searching": false,
                        "info": false
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    $("#result").html('<div class="alert alert-danger">Failed to load data</div>');
                }
            });
        }

        // Export functions
        function exportTableToExcel() {
            var wb = XLSX.utils.table_to_book(document.getElementById('attendance_table'));
            XLSX.writeFile(wb, 'attendance_data.xlsx');
        }

        function exportTableToPDF() {
            const doc = new jsPDF();
            doc.autoTable({ html: '#attendance_table' });
            doc.save('attendance_data.pdf');
        }

        function printTable() {
            var printContents = document.getElementById('result').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>
@stop

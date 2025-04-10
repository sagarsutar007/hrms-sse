@extends('adminlte::page')

@section('title', 'Salary Report')

@section('content_header')
    <h1>Salary Report</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Salary Sheet for <span id="month_year_span">March 2024</span></h3>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Date</span>
                                </div>
                                <input type="date" id="date_input" class="form-control" onchange="change_date()">
                                <div class="input-group-append">
                                    <button type="button" id="search_btn" class="btn btn-primary" onclick="change_date()">
                                        <i class="fas fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-success" onclick="exportTableToExcel()">
                                    <i class="fas fa-file-excel"></i> Excel
                                </button>
                                <button type="button" class="btn btn-danger" onclick="exportTableToPDF()">
                                    <i class="fas fa-file-pdf"></i> PDF
                                </button>
                                <button type="button" class="btn btn-secondary" onclick="printTable()">
                                    <i class="fas fa-print"></i> Print
                                </button>
                            </div>
                        </div>
                    </div>

                    <input type="text" value="{{session('role_number')}}" id="role_number" hidden>

                    <div id="result">
                        <!-- Table content will be loaded here -->
                        <div class="overlay">
                            <i class="fas fa-sync fa-spin"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for leave view -->
<div class="modal fade" id="leaveModal" tabindex="-1" role="dialog" aria-labelledby="leaveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="leaveModalLabel">Leave Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="leaveModalBody">
                <!-- Leave details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .table th, .table td {
            vertical-align: middle;
        }
        .card-body {
            overflow-x: auto;
        }
        .total-row {
            font-weight: bold;
            background-color: #f8f9fa;
        }
    </style>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.14/jspdf.plugin.autotable.min.js"></script>
    <script>
        // Set today's date as default
        $(document).ready(function() {
            // Get today's date in YYYY-MM-DD format
            let today = new Date();
            let formattedDate = today.toISOString().split('T')[0];

            // Set the value of the date input field
            document.getElementById("date_input").value = formattedDate;

            let month = today.getMonth() + 1; // Months are 0-based (0 = January, 11 = December)
            let year = today.getFullYear();

            // Format the month to always be two digits (e.g., "01" for January)
            month = month.toString().padStart(2, '0');
            document.getElementById("month_year_span").innerHTML = `${month}-${year}`;

            // Load initial data
            lode_data();
        });

        // Disable search button by default
        $("#search_btn").prop("disabled", true);

        var limit = 50;
        var page_url;

        function lode_data() {
            page_url = "{{url('/totall-salary-amount/')}}/"
            attendance_data_set(page_url);
        }

        function change_date() {
            var date = $('#date_input').val();
            page_url = "{{url('/totall-salary-amount/')}}/" + date;
            attendance_data_set(page_url);
        }

        function show_animation() {
            $("#result").html('<div class="text-center p-5"><i class="fas fa-spinner fa-pulse fa-3x"></i><p class="mt-2">Loading data...</p></div>');
        }

        function hide_animation() {
            // Animation is hidden when data is loaded
        }

        function attendance_data_set(url_input) {
            show_animation();
            $.ajax({
                url: url_input,
                type: "GET",
                dataType: "json",
                headers: {
                    "Content-Type": "application/json"
                },
                success: function(response) {
                    console.log("Response:", response);
                    $("#result").empty();
                    var all_users_data = response.data;
                    var role_number = $("#role_number").val();

                    var table_html_data = `
                        <table id="id_of_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Employee Name</th>
                                    <th>Shift Name</th>
                                    <th>OT Amount</th>
                                    <th>Salary Amount</th>
                                    <th>Total Paid Amount</th>
                                </tr>
                            </thead>
                            <tbody>`;

                    var flag = 1;
                    var Total_Paid_Amount = 0;
                    var Total_OT_Amount = 0;
                    var Total_Salary_amount = 0;

                    all_users_data.forEach(all_users => {
                        table_html_data += `
                            <tr id="" value="employee_id${all_users.id}">
                                <td>${all_users.Employee_id}</td>
                                <td>${all_users.name}</td>
                                <td>${all_users.shift_name}</td>
                                <td>${all_users.OT_Amount}</td>
                                <td>${all_users.Salary_amount}</td>
                                <td>${all_users.Total_Paid_Amount}</td>
                            </tr>`;

                        Total_Paid_Amount = parseInt(Total_Paid_Amount) + parseInt(all_users.Total_Paid_Amount);
                        Total_OT_Amount = parseInt(Total_OT_Amount) + parseInt(all_users.OT_Amount);
                        Total_Salary_amount = parseInt(Total_Salary_amount) + parseInt(all_users.Salary_amount);
                        flag++;
                    });

                    table_html_data += `
                            </tbody>
                            <tfoot>
                                <tr class="total-row">
                                    <td>Total</td>
                                    <td colspan='2'></td>
                                    <td>${Total_OT_Amount}</td>
                                    <td>${Total_Salary_amount}</td>
                                    <td>${Total_Paid_Amount}</td>
                                </tr>
                            </tfoot>
                        </table>`;

                    $("#result").html(table_html_data);

                    // Initialize DataTable with AdminLTE styling
                    $('#id_of_table').DataTable({
                        "paging": true,
                        "lengthChange": true,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                        "responsive": true,
                    });

                    hide_animation();
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    $("#result").html('<div class="alert alert-danger">Error loading data. Please try again.</div>');
                }
            });
        }

        function printTable() {
            // Get the HTML table element
            var table = document.getElementById("id_of_table").outerHTML;

            // Open a new window
            var newWindow = window.open('', '', 'width=800,height=600');

            // Add the table HTML and a print button to the new window
            newWindow.document.write('<html><head><title>Print Table</title>');
            newWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">');
            newWindow.document.write('<style>table { border-collapse: collapse; width: 100%; } th, td { border: 1px solid black; padding: 8px; text-align: left; }</style>');
            newWindow.document.write('</head><body>');
            newWindow.document.write('<div class="container p-4"><h3 class="text-center mb-4">Salary Report</h3>');
            newWindow.document.write(table);
            newWindow.document.write('</div></body></html>');

            // Automatically trigger print dialog
            newWindow.document.close();
            newWindow.focus();
            newWindow.print();
            newWindow.close();
        }

        function exportTableToPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Get the HTML table
            var table = document.getElementById("id_of_table");

            // Add title to PDF
            doc.text("Salary Report", 14, 15);
            doc.text("Date: " + $('#date_input').val(), 14, 22);

            // Use autoTable plugin to convert table to PDF
            doc.autoTable({
                html: table,
                startY: 30,
                theme: 'grid',
                headStyles: { fillColor: [51, 122, 183], textColor: [255, 255, 255] },
                styles: { fontSize: 8 }
            });

            // Save the generated PDF
            doc.save("salary_report.pdf");
        }

        function exportTableToExcel() {
            // Get the table element
            var table = document.getElementById("id_of_table");

            // Create a new workbook
            var wb = XLSX.utils.table_to_book(table, {sheet: "Salary Report"});

            // Export the workbook to an Excel file
            XLSX.writeFile(wb, "salary_report.xlsx");
        }

        function total_leave_view(id) {
            $.ajax({
                type: "GET",
                url: "{{url('/leave-view/')}}/" + id,
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    var r_data = response.data;

                    var modalContent = `
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Name:</strong> ${r_data.Name}</p>
                                <p><strong>Employee ID:</strong> ${r_data.Employee_id}</p>
                                <p><strong>Description:</strong> ${r_data.Description}</p>
                                <p><strong>Remarks by Approve:</strong> ${r_data.Remarks_by_Approve}</p>
                                <p><strong>Total Days:</strong> ${r_data.Total_Days}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Leave Type:</strong> ${r_data.Leave_Type_name}</p>
                                <p><strong>Start Date:</strong> ${r_data.Start_Date}</p>
                                <p><strong>End Date:</strong> ${r_data.End_Date}</p>
                                <p><strong>Status:</strong> <span class="badge badge-${r_data.Status === 'Approved' ? 'success' : r_data.Status === 'Pending' ? 'warning' : 'danger'}">${r_data.Status}</span></p>
                            </div>
                        </div>`;

                    $("#leaveModalBody").html(modalContent);
                    $("#leaveModal").modal('show');
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    toastr.error('Error loading leave details');
                }
            });
        }
    </script>
@stop

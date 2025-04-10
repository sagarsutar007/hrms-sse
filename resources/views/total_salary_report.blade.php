@extends('adminlte::page')

@section('title', 'Salary Report')

@section('content_header')
    <h1>Salary Report for <span id="month_year_span">March 2024</span></h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Salary Sheet</h3>
                        <div class="card-tools">
                            <div class="input-group">
                                <input type="date" name="date" class="form-control" onchange="change_date()" id="date_input">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary" id="search_btn" onclick="change_date()">
                                        <i class="fas fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="btn-group">
                            <button type="button" class="btn btn-success" onclick="exportTableToExcel()">
                                <i class="fas fa-file-excel"></i> Excel
                            </button>
                            <button type="button" class="btn btn-danger" onclick="exportTableToPDF()">
                                <i class="fas fa-file-pdf"></i> PDF
                            </button>
                            <button type="button" class="btn btn-info" onclick="printTable()">
                                <i class="fas fa-print"></i> Print
                            </button>
                        </div>
                    </div>
                    <input type="text" value="{{session('role_number')}}" id="role_number" hidden>
                    <div id="result">
                        <!-- Table data will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for popup details -->
<div class="modal fade" id="pup_up_div" tabindex="-1" role="dialog" aria-labelledby="leaveDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="leaveDetailsModalLabel">Leave Details</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="close_pup_up_div()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal_content">
                <!-- Leave details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="close_pup_up_div()">Close</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/datatables/css/dataTables.bootstrap4.min.css') }}">
@stop

@section('js')
    <!-- Required JS libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.14/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Get today's date in YYYY-MM-DD format
        let today = new Date();
        let formattedDate = today.toISOString().split('T')[0];

        // Set the value of the date input field
        document.getElementById("date_input").value = formattedDate;

        let month = today.getMonth() + 1; // Months are 0-based (0 = January, 11 = December)
        let year = today.getFullYear();

        // Format the month to always be two digits (e.g., "01" for January)
        month = month.toString().padStart(2, '0');
        document.getElementById("month_year_span").innerHTML = `${month} - ${year}`;

        // Disable search button initially
        $("#search_btn").prop("disabled", true);

        var limit = 50;
        var page_url;

        $(document).ready(function() {
            lode_data();
        });

        function lode_data() {
  page_url = "{{url('/totall-salary-amount/')}}/"
 attendance_data_set(page_url)
}

function change_date(){
   var date = $('#date_input').val()
    page_url = "{{url('/totall-salary-amount/')}}/" + date
    attendance_data_set(page_url)
}

function attendance_data_set(url_input) {
$.ajax({
url:  url_input,  // API endpoint URL
type: "GET",  // HTTP method, e.g., GET, POST, PUT, DELETE
dataType: "json",

headers: {
// "Authorization": "Bearer YOUR_ACCESS_TOKEN",  // Add headers if needed
"Content-Type": "application/json"
},
success: function(response) {
console.log("Response:", response);  // Handle the successful response here
$("#result").empty();
var count_flag = 1;
var all_data = response.data;
var role_number = $("#role_number").val();
var all_users_data = response.data ;
var table_html_data =`<table id="id_of_table" class="table table-hover"  style="padding: 20px; align-self: center; width: 100%; margin-top: 6px;"   >
    <link rel="stylesheet" href="css/table.css">
        <col class="col1" />
        <col class="col2" />
        <col class="col3" />
        <col class="col4" />
        <col class="col5" />
        <col class="col6" />
        <col class="col7" />
        <col class="col8" />
        <col class="col9" />
        <col class="col10" />
        <col class="col11" />

    <thead >
        <tr >


            <th> Employee ID</th>
            <th> Employee Name </th>
            <th>Shift Name</th>
            <th>OT Amount</th>
             <th>Salary Amount</th>
            <th>Total Paid Amount</th>



        </tr>



    </thead>`
    var flag = 1
    var Total_Paid_Amount = 0;
    var Total_OT_Amount = 0;
    var Total_Salary_amount = 0;

    all_users_data.forEach(all_users => {

        table_html_data += `<tr id="" value="employee_id${all_users.id }" >

            <td>${all_users.Employee_id } </td>
            <td> ${all_users.name} </td>

            <td>${all_users.shift_name } </td>
            <td>${all_users.OT_Amount } </td>
            <td>${all_users.Salary_amount } </td>
            <td>${all_users.Total_Paid_Amount } </td>

            </tr>`
            Total_Paid_Amount = parseInt(Total_Paid_Amount) + parseInt(all_users.Total_Paid_Amount)
            Total_OT_Amount = parseInt(Total_OT_Amount) + parseInt(all_users.OT_Amount)
            Total_Salary_amount = parseInt(Total_Salary_amount) + parseInt(all_users.Salary_amount)
        flag ++
    });
        table_html_data += `<tr> <td> Total </td>  <td colspan='2'> </td>    <td> ${Total_OT_Amount} </td> <td> ${Total_Salary_amount} </td> <td> ${Total_Paid_Amount} </td><tr></table>`
$("#result").html(table_html_data);
},
 error: function(xhr, status, error) {
console.error("Error:", error);  // Handle the error here
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
            newWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1.0/dist/css/adminlte.min.css">');
            newWindow.document.write('<style>table { border-collapse: collapse; width: 100%; } th, td { border: 1px solid black; padding: 8px; text-align: left; }</style>');
            newWindow.document.write('</head><body>');
            newWindow.document.write('<div class="container"><h3 class="mb-4">Salary Report</h3>');
            newWindow.document.write(table);
            newWindow.document.write('</div></body></html>');

            // Automatically trigger print dialog
            newWindow.document.close();
            newWindow.focus();
            newWindow.print();
            newWindow.close();
        }

        function exportTableToPDF() {
            // Create a new instance of jsPDF
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Get the HTML table
            var table = document.getElementById("id_of_table");

            // Add title
            doc.text("Salary Report", 14, 15);

            // Use autoTable plugin to convert table to PDF
            doc.autoTable({
                html: table,
                startY: 20,
                theme: 'grid',
                headStyles: { fillColor: [52, 58, 64] },
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

        function close_pup_up_div() {
            $('#pup_up_div').modal('hide');
        }

        function open_pup_up_div() {
            $('#pup_up_div').modal('show');
        }

        function total_leave_view(id) {
            open_pup_up_div();

            $.ajax({
                type: "GET",
                url: "{{url('/leave-view/')}}/" + id,
                dataType: "json",
                success: function(response) {
                    var r_data = response.data;

                    var pup_up_data = `
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box">
                                    <div class="info-box-content">
                                        <p><strong>Name:</strong> ${r_data.Name}</p>
                                        <p><strong>Employee ID:</strong> ${r_data.Employee_id}</p>
                                        <p><strong>Description:</strong> ${r_data.Description}</p>
                                        <p><strong>Remarks by Approve:</strong> ${r_data.Remarks_by_Approve}</p>
                                        <p><strong>Total Days:</strong> ${r_data.Total_Days}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box">
                                    <div class="info-box-content">
                                        <p><strong>Leave Type:</strong> ${r_data.Leave_Type_name}</p>
                                        <p><strong>Start Date:</strong> ${r_data.Start_Date}</p>
                                        <p><strong>End Date:</strong> ${r_data.End_Date}</p>
                                        <p><strong>Status:</strong> <span class="badge badge-${r_data.Status === 'Approved' ? 'success' : (r_data.Status === 'Rejected' ? 'danger' : 'warning')}">${r_data.Status}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>`;

                    $("#modal_content").html(pup_up_data);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    $("#modal_content").html('<div class="alert alert-danger">Error loading leave details</div>');
                }
            });
        }
    </script>
@stop

@extends('adminlte::page')

@section('title', 'Salary Sheet')

@section('content_header')
    <h1>Salary Sheet for <span id="month_year_span">April 2025</span></h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default" onclick="exportTableToExcel()">
                                    <i class="fas fa-file-excel"></i> Excel
                                </button>
                                <button type="button" class="btn btn-default" onclick="exportTableToPDF()">
                                    <i class="fas fa-file-pdf"></i> PDF
                                </button>
                                <button type="button" class="btn btn-default" onclick="printTable()">
                                    <i class="fas fa-print"></i> Print
                                </button>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="mr-2">
                                <input type="text" name="year" class="form-control" id="year_input" list="year_list"
                                    onchange="change_year()" placeholder="Select Year">
                                <datalist id="year_list"></datalist>
                            </div>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Date</span>
                                </div>
                                <input type="month" name="date" class="form-control" onchange="change_date()" id="date_input">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" id="search_btn" onclick="change_date()">
                                        <i class="fas fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Company Wise</h3>
                </div>
                <div class="card-body" id="result_all">
                    <!-- Company wise data will be loaded here -->
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Department Wise</h3>
                </div>
                <div class="card-body" id="result_department_wise">
                    <!-- Department wise data will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Role Wise</h3>
                </div>
                <div class="card-body" id="result_role_wise">
                    <!-- Role wise data will be loaded here -->
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Employee Type Wise</h3>
                </div>
                <div class="card-body" id="result_employ_type_wise">
                    <!-- Employee type wise data will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Detailed View -->
<div class="modal fade" id="salaryModal" tabindex="-1" role="dialog" aria-labelledby="salaryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="salaryModalLabel">Detailed Salary Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="pop_up_table_div">
                <!-- Detailed data will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Leave View Modal -->
<div class="modal fade" id="leaveModal" tabindex="-1" role="dialog" aria-labelledby="leaveModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="leaveModalLabel">Leave Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="leave_details_div">
                <!-- Leave details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<input type="text" value="{{session('role_number')}}" id="role_number" hidden>
@stop

@section('css')
<style>
    .table-responsive {
        overflow-x: auto;
    }
    .table th, .table td {
        vertical-align: middle;
    }
    .clickable-row {
        cursor: pointer;
    }
    .clickable-row:hover {
        background-color: rgba(0,0,0,.075);
    }
</style>
@stop

@section('js')
<script>
    // Function to populate datalist with years dynamically
    function populateYears() {
        let datalist = document.getElementById("year_list");
        let currentYear = new Date().getFullYear();

        for (let year = 2024; year <= currentYear + 10; year++) {
            let option = document.createElement("option");
            option.value = year;
            datalist.appendChild(option);
        }
    }

    // Get today's date in YYYY-MM-DD format
    let today = new Date();
    let month = today.getMonth() + 1; // Months are 0-based (0 = January, 11 = December)
    let year = today.getFullYear();

    // Format the month to always be two digits (e.g., "01" for January)
    month = month.toString().padStart(2, '0');

    // Set date input to current year-month
    $(document).ready(function() {
        let formattedYearMonth = `${year}-${month}`;
        $("#date_input").val(formattedYearMonth);

        // Display month name and year
        const monthNames = ["January", "February", "March", "April", "May", "June",
                          "July", "August", "September", "October", "November", "December"];
        document.getElementById("month_year_span").innerHTML = `${monthNames[today.getMonth()]} ${year}`;

        // Populate years dropdown
        populateYears();

        // Load initial data
        lode_data();

        // Disable search button initially
        $("#search_btn").prop("disabled", true);
    });

    function showLoading() {
        // Show loading overlay or spinner
        Swal.fire({
            title: 'Loading...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }

    function hideLoading() {
        // Hide loading overlay
        Swal.close();
    }

    function show_animation() {
        showLoading();
    }

    function hide_animation() {
        hideLoading();
    }

    var limit = 50;
    var page_url;

    function lode_data() {
        page_url = "{{url('/totall-salary-amount/')}}/"
        attendance_data_set(page_url);
        salary_data_department_wise("{{url('/totall-salary-amount_department_wise/')}}/");
        salary_data_role_wise("{{url('/totall-salary-amount_role_wise/')}}/");
        salary_data_employ_type_wise("{{url('/totall-salary-amount-employ-type-wise/')}}/");
    }

    function change_date() {
        var date = $('#date_input').val();
        page_url = "{{url('/totall-salary-amount/')}}/" + date;
        attendance_data_set(page_url);
        salary_data_department_wise("{{url('/totall-salary-amount_department_wise/')}}/" + date);
        salary_data_role_wise("{{url('/totall-salary-amount_role_wise/')}}/" + date);
        salary_data_employ_type_wise("{{url('/totall-salary-amount-employ-type-wise/')}}/" + date);
    }

    function change_year() {
        var year = $('#year_input').val();
        page_url = "{{url('/totall-salary-amount_year/')}}/" + year;
        attendance_data_set(page_url);
        salary_data_department_wise("{{url('/totall-salary-amount_department_wise_year/')}}/" + year);
        salary_data_role_wise("{{url('/totall-salary-amount_role_wise_year/')}}/" + year);
        salary_data_employ_type_wise("{{url('/totall-salary-amount-employ-type-wise_year/')}}/" + year);
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
                console.log("Response:", response);
                $("#result").empty();

                var all_users_data = response.data;
                var Total_Paid_Amount = 0;
                var Total_OT_Amount = 0;
                var Total_Salary_amount = 0;

                all_users_data.forEach(all_users => {
                    Total_Paid_Amount = parseInt(Total_Paid_Amount) + parseInt(all_users.Total_Paid_Amount);
                    Total_OT_Amount = parseInt(Total_OT_Amount) + parseInt(all_users.OT_Amount);
                    Total_Salary_amount = parseInt(Total_Salary_amount) + parseInt(all_users.Salary_amount);
                });

                var table_html_data = `
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>OT Amount</th>
                                <th>Salary Amount</th>
                                <th>Total Paid Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="clickable-row" onclick="open_company_wise_data()">
                                <td>${Total_OT_Amount}</td>
                                <td>${Total_Salary_amount}</td>
                                <td>${Total_Paid_Amount}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>`;

                $("#result_all").html(table_html_data);

            },
            error: function(xhr, status, error) {
                console.error("Error:", error);


                // Show error toast
                toastr.error('Error loading data. Please try again.');
            }
        });
    }

    function salary_data_department_wise(url_input) {

        $.ajax({
            url: url_input,
            type: "GET",
            dataType: "json",
            headers: {
                "Content-Type": "application/json"
            },
            success: function(response) {
                console.log("Response:", response);
                var all_users_data = response.data;

                var table_html_data2 = `
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Department</th>
                                <th>Total Salary Amount</th>
                                <th>Total OT Amount</th>
                                <th>Total Paid Amount</th>
                                <th>Total Employees</th>
                            </tr>
                        </thead>
                        <tbody>`;

                all_users_data.forEach(all_users => {
                    table_html_data2 += `
                    <tr class="clickable-row" onclick="open_department_wise_data('${all_users.Department_id}')">
                        <td>${all_users.Department_name}</td>
                        <td>${all_users.Total_Salary_Amount}</td>
                        <td>${all_users.Total_OT_Amount}</td>
                        <td>${all_users.Total_Paid_Amount}</td>
                        <td>${all_users.Total_Employees}</td>
                    </tr>`;
                });

                table_html_data2 += `
                        </tbody>
                    </table>
                </div>`;

                $("#result_department_wise").html(table_html_data2);

            },
            error: function(xhr, status, error) {
                console.error("Error:", error);


                // Show error toast
                toastr.error('Error loading department data. Please try again.');
            }
        });
    }

    function salary_data_role_wise(url_input) {

        $.ajax({
            url: url_input,
            type: "GET",
            dataType: "json",
            headers: {
                "Content-Type": "application/json"
            },
            success: function(response) {
                console.log("Response:", response);
                var all_users_data = response.data;

                var table_html_data3 = `
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Role Name</th>
                                <th>Total Salary Amount</th>
                                <th>Total OT Amount</th>
                                <th>Total Paid Amount</th>
                                <th>Total Employees</th>
                            </tr>
                        </thead>
                        <tbody>`;

                all_users_data.forEach(all_users => {
                    table_html_data3 += `
                    <tr class="clickable-row" onclick="open_role_wise_data('${all_users.Role_id}')">
                        <td>${all_users.Role}</td>
                        <td>${all_users.Total_Salary_Amount}</td>
                        <td>${all_users.Total_OT_Amount}</td>
                        <td>${all_users.Total_Paid_Amount}</td>
                        <td>${all_users.Total_Employees}</td>
                    </tr>`;
                });

                table_html_data3 += `
                        </tbody>
                    </table>
                </div>`;

                $("#result_role_wise").html(table_html_data3);

            },
            error: function(xhr, status, error) {
                console.error("Error:", error);


                // Show error toast
                toastr.error('Error loading role data. Please try again.');
            }
        });
    }

    function salary_data_employ_type_wise(url_input) {

        $.ajax({
            url: url_input,
            type: "GET",
            dataType: "json",
            headers: {
                "Content-Type": "application/json"
            },
            success: function(response) {
                console.log("Response:", response);
                var all_users_data = response.data;

                var table_html_data4 = `
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Employee Type</th>
                                <th>Total Salary Amount</th>
                                <th>Total OT Amount</th>
                                <th>Total Paid Amount</th>
                                <th>Total Employees</th>
                            </tr>
                        </thead>
                        <tbody>`;

                all_users_data.forEach(all_users => {
                    table_html_data4 += `
                    <tr class="clickable-row" onclick="open_emptype_wise_data('${all_users.Employee_Type_id}')">
                        <td>${all_users.Employee_Type}</td>
                        <td>${all_users.Total_Salary_Amount}</td>
                        <td>${all_users.Total_OT_Amount}</td>
                        <td>${all_users.Total_Paid_Amount}</td>
                        <td>${all_users.Total_Employees}</td>
                    </tr>`;
                });

                table_html_data4 += `
                        </tbody>
                    </table>
                </div>`;

                $("#result_employ_type_wise").html(table_html_data4);

            },
            error: function(xhr, status, error) {
                console.error("Error:", error);


                // Show error toast
                toastr.error('Error loading employee type data. Please try again.');
            }
        });
    }

    function open_company_wise_data() {
        var date = $('#date_input').val();
        if(date == "") {
            var year = $('#year_input').val();
            pop_up_data_company_wise('{{url("/company_data_all_parms/")}}/' + year + '/0/0/0/0', "Company Wise Data");
        } else {
            pop_up_data_company_wise('{{url("/company_lable_data/")}}/' + date, "Company Wise Data");
        }
    }

    function open_role_wise_data(role_id) {
        var date = $('#date_input').val();
        if(date == "") {
            var year = $('#year_input').val();
            pop_up_data_company_wise('{{url("/company_data_all_parms/")}}/' + year + '/0/'+ role_id +'/0/0', "Role Wise Data");
        } else {
            pop_up_data_company_wise('{{url("/company_data_all_parms_2/")}}/' + date + '/'+ role_id +'/0/0', "Role Wise Data");
        }
    }

    function open_department_wise_data(department_id) {
        var date = $('#date_input').val();
        if(date == "") {
            var year = $('#year_input').val();
            pop_up_data_company_wise('{{url("/company_data_all_parms/")}}/' + year + '/0/0/'+department_id+'/0', "Department Wise Data");
        } else {
            pop_up_data_company_wise('{{url("/company_data_all_parms_2/")}}/' + date + '/0/'+department_id+'/0', "Department Wise Data");
        }
    }

    function open_emptype_wise_data(emptype_id) {
        var date = $('#date_input').val();
        if(date == "") {
            var year = $('#year_input').val();
            pop_up_data_company_wise('{{url("/company_data_all_parms/")}}/' + year + '/0/0/0/' + emptype_id, "Employee Type Wise Data");
        } else {
            pop_up_data_company_wise('{{url("/company_data_all_parms_2/")}}/' + date + '/0/0/' + emptype_id, "Employee Type Wise Data");
        }
    }

    function pop_up_data_company_wise(url_input, header_data) {

        $.ajax({
            url: url_input,
            type: "GET",
            dataType: "json",
            headers: {
                "Content-Type": "application/json"
            },
            success: function(response) {
                console.log("Response:", response);
                var all_users_data = response.data;

                var pop_up_table = `
                <h4>${header_data}</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>EmployeeID</th>
                                <th>Name</th>
                                <th>Shift Name</th>
                                <th>Department Name</th>
                                <th>OT Hours</th>
                                <th>OT Amount</th>
                                <th>Salary Amount</th>
                                <th>Paid Amount</th>
                                <th>CTC</th>
                            </tr>
                        </thead>
                        <tbody>`;

                all_users_data.forEach(all_users => {
                    pop_up_table += `
                    <tr>
                        <td>${all_users.EmployeeID}</td>
                        <td>${all_users.Name}</td>
                        <td>${all_users.Shift_Name}</td>
                        <td>${all_users.Department_name}</td>
                        <td>${all_users.OT_Hours}</td>
                        <td>${all_users.OT_Amount}</td>
                        <td>${all_users.Salary_amount}</td>
                        <td>${all_users.Paid_Amount}</td>
                        <td>${all_users.CTC}</td>
                    </tr>`;
                });

                pop_up_table += `
                        </tbody>
                    </table>
                </div>`;

                $("#pop_up_table_div").html(pop_up_table);


                $('#salaryModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);


                // Show error toast
                toastr.error('Error loading detailed data. Please try again.');
            }
        });
    }

    function total_leave_view(id) {

        $.ajax({
            type: "GET",
            url: "{{url('/leave-view/')}}/" + id,
            dataType: "json",
            success: function(response) {
                console.log(response);
                var r_data = response.data;

                var leave_details = `
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
                        <p><strong>Status:</strong> <span class="badge badge-${r_data.Status === 'Approved' ? 'success' : (r_data.Status === 'Pending' ? 'warning' : 'danger')}">${r_data.Status}</span></p>
                    </div>
                </div>`;

                $("#leave_details_div").html(leave_details);


                $('#leaveModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);


                // Show error toast
                toastr.error('Error loading leave data. Please try again.');
            }
        });
    }

    function exportTableToExcel() {
        // Excel export functionality
        toastr.success('Exporting to Excel...');
        // Implementation code would go here
    }

    function exportTableToPDF() {
        // PDF export functionality
        toastr.success('Exporting to PDF...');
        // Implementation code would go here
    }

    function printTable() {
        // Print functionality
        window.print();
    }
</script>
@stop

@extends('adminlte::page')

@section('title', 'Salary Sheet')

@section('content_header')
    <h1>Salary Sheet</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="btn-group">
                    <button type="button" class="btn btn-success" id="excel-btn" title="Excel">
                        <i class="fas fa-file-excel"></i> Excel
                    </button>
                    <button type="button" class="btn btn-danger" id="pdf-btn" title="PDF">
                        <i class="fas fa-file-pdf"></i> PDF
                    </button>
                    <button type="button" class="btn btn-default" id="print-btn" title="Print">
                        <i class="fas fa-print"></i> Print
                    </button>
                    <button type="button" class="btn btn-default" id="toggle-days-btn" title="Toggle Days" onclick="toggleMonths()">
                        <i class="fas fa-calendar-day"></i> Toggle Days
                    </button>
                </div>
            </div>
            <div class="col-4"></div>
            {{-- <div class="col-md-2">
                <button type="button" class="btn btn-success btn-block pay-salary-btn" id="saveTableData">
                    <i class="fas fa-money-bill-wave"></i> Pay All Employee Salary
                </button>
            </div> --}}
            <div class="col-md-2">
                <div class="input-group">
                    <input type="month" class="form-control" id="month-selector" value="{{ date('Y-m') }}">
                    <div class="input-group-append">
                        <button class="btn btn-default" id="month-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card-body" style="max-height: 1000px; overflow-y: auto; overflow-x: auto;">
        <!-- Flex row with space between -->
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
            <!-- Color Legends -->
            <div class="mb-2">
                <span style="display:inline-block; width:15px; height:15px; background-color:#00FFFF; margin-right:5px;"></span> Weekly Off
                <span style="display:inline-block; width:15px; height:15px; background-color:#FFFF00; margin-right:5px;"></span> Holiday
                <span style="display:inline-block; width:15px; height:15px; background-color:#FFA500; margin-right:5px;"></span> Swap Day
                <span style="display:inline-block; width:15px; height:15px; background-color:#FF0000; margin-right:5px;"></span> Sick Leave
                <span style="display:inline-block; width:15px; height:15px; background-color:#FF00FF; margin-right:5px;"></span> Casual Leave
                <span style="display:inline-block; width:15px; height:15px; background-color:#ff8a8a ; margin-right:5px;"></span> Terminated
            </div>

            <!-- Search Bar -->
            <form action="{{ route('search_employee') }}" method="post" class="d-flex" style="gap: 5px;">
                @csrf
                <input type="search" name="search_val" id="search_input" class="form-control"
                    placeholder="Search Employee by Name Number etc" required onkeyup="serch_on_key_presh()">
                {{-- <button type="submit" id="search_btn" class="btn btn-outline-secondary">Search</button> --}}
            </form>
        </div>

        <div class="table-responsive" id="result">
            <div class="text-center">
                <i class="fas fa-spinner fa-spin fa-3x"></i>
                <p>Loading data...</p>
            </div>
        </div>

        <div id="pagination_div" class="mt-3"></div>
    </div>


</div>



<!-- Employee Details Modal -->
<div class="modal fade" id="employeeDetailsModal" tabindex="-1" role="dialog" aria-labelledby="employeeDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="employeeDetailsModalLabel">Employee Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="employeeDetailsContent">
                <!-- Content will be populated by JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="print-details-btn">Print Details</button>
            </div>
        </div>
    </div>
</div>

<!-- Salary Modal using AdminLTE Modal -->
<div class="modal fade" id="salaryModal" tabindex="-1" role="dialog" aria-labelledby="salaryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document"> <!-- xl for full-width -->
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="table_heading_h2">Salary Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>

            <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th><h4 class="mb-0">Consolidated Employee Details</h4></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="heade_table_tr_data">
                            <!-- Filled dynamically -->
                        </tr>
                    </tbody>
                </table>

                <h3 class="mt-4">Daily Breakdown</h3>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="bg-info text-white">
                            <tr>
                                <th>DATE</th>
                                <th>In</th>
                                <th>Out</th>
                                <th>Tot. Hrs</th>
                                <th>Tot. Min</th>
                                <th>OT Hrs.</th>
                                <th>OT Min</th>
                                <th>OT Amt</th>
                                <th>Daily Amt</th>
                                <th>Cumulative Amt</th>
                            </tr>
                        </thead>
                        <tbody id="in_out_single_user_tr">
                            <!-- Filled dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- Add Save/Print/etc. buttons here if needed -->
            </div>
        </div>
    </div>
</div>

<!-- Arrear Form -->
<div class="modal fade" id="arrearModal" tabindex="-1" role="dialog" aria-labelledby="arrearModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="arrearModalLabel">Add Arrear</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="Arrear_Form">
            @csrf
            <input type="text" name="Employee_Id" id="Employee_Id_inpur_arrear_form" style="padding: 5px 10px; width:100%;" hidden>

            <div class="form-group row">
              <div class="col-md-6">
                <p class="input_lable_p">Arrear Amount*</p>
                <div class="input">
                  <input type="text" class="form-control" placeholder="Arrear Amount" name="Arrear_Amount" id="Arrear_Amount_input" required oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                </div>
              </div>
              <div class="col-md-6">
                <p class="input_lable_p">Arrear Reason*</p>
                <div class="input">
                  <input type="text" class="form-control" id="Arrear_Reason" placeholder="Arrear Reason" name="Arrear_Reason" required>
                </div>
              </div>
            </div>

            <div class="form-group">
              <p class="input_lable_p">Arrear Month*</p>
              <div class="input">
                <input type="month" class="form-control" id="Arrear_month_year" name="Arrear_month_year" required>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="arrear_form_submit_btn" onclick="save_arrear()">Submit</button>
        </div>
      </div>
    </div>
  </div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap4.min.css">
<style>
    .btn-group .btn {
        margin-right: 5px;
    }
    .btn i {
        margin-right: 5px;
    }
    .dataTables_wrapper {
        position: relative;
    }
    .dataTables_wrapper .dataTables_paginate {
        position: fixed;
        right: 20px;
        bottom: 20px;
        background: white;
        padding: 5px;
        border-radius: 5px;
        z-index: 1000;
    }
    .card-body {
        overflow-x: auto;
        white-space: nowrap;
        position: relative;
        max-height: 60vh
    }

    /* Custom colors for leave types */
    .bg-weekly-off { background-color: #00FFFF !important; }
    .bg-holiday { background-color: #FFFF00 !important; }
    .bg-swap-day { background-color: #FFA500 !important; }
    .bg-sick-leave { background-color: #FF0000 !important; }
    .bg-casual-leave { background-color: #FF00FF !important; }
    .bg-termination { background-color: #ff8a8a !important; }

    /* Fix table header alignment */
    #salary-table-daily th {
        text-align: center;
        vertical-align: middle;
    }

    /* Pay Salary Button */
    .pay-salary-btn {
        padding: 5px 10px;
        border: none;
        border-radius: 4px;
        background-color: #28a745;
        color: white;
        cursor: pointer;
        transition: all 0.3s;
    }
    .pay-salary-btn:hover {
        background-color: #218838;
    }
    .pay-salary-btn:disabled {
        background-color: #6c757d;
        cursor: not-allowed;
    }
    .pay-salary-btn i {
        margin-right: 5px;
    }

    /* Loading indicator */
    .loading {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 200px;
    }
</style>
@stop

@section('js')
    <!-- jQuery (Required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <!-- Bootstrap 4 JS (Optional but recommended for styling consistency) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables core -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap4.min.js"></script>

    <!-- JSZip and pdfmake (required for Excel/PDF export) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <!-- Buttons for Excel, PDF, and Print -->
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>

    <script>

        let arrear_month = 0;
        let arrear_year = 0;

        close_Arrear_Info_form()

            function close_Arrear_Info_form() {
            document.getElementById("Arrear_Info_div").style.display = "none"
            }

            function open_Arrear_Info_form() {
                    $('#arrearModal').modal('show');
                }

                function close_Arrear_Info_form() {
                    $('#arrearModal').modal('hide');
                }

                function save_arrear(event) {
                    event.preventDefault();

                    var emp_id = $("#Employee_Id_inpur_arrear_form").val();
                    var Arrear_amount_var = $("#Arrear_Amount_input").val();
                    var Arrear_reason_var = $("#Arrear_Reason").val();

                    var monthly_salary_var = $("#monthly_salary" + emp_id).text();
                    var Advance_amount_var = $("#advance" + emp_id).text();
                    var Deduction_amount_var = $("#deductions_amount" + emp_id).text();

                    if (Arrear_amount_var !== "" && Arrear_reason_var !== "") {
                        close_Arrear_Info_form();

                        $("#arrear_amount_td" + emp_id).text(Arrear_amount_var);
                        $("#arrear_reason_td" + emp_id).text(Arrear_reason_var);

                        var n_salary = parseFloat(monthly_salary_var) - parseFloat(Advance_amount_var) - parseFloat(Deduction_amount_var) + parseFloat(Arrear_amount_var);
                        $("#net_salary" + emp_id).text(n_salary.toFixed(2));

                        var formData = $('#Arrear_Form').serialize();

                        $.ajax({
                            url: "{{ route('add_arrear_api') }}",
                            method: "POST",
                            data: formData,
                            headers: {
                                'X-CSRF-TOKEN': $('input[name="_token"]').val()
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                $('#Arrear_Form')[0].reset();
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON?.message || 'Something went wrong!'
                                });
                            }
                        });

                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Required Fields',
                            text: Arrear_amount_var === "" ? "Please enter Arrear Amount" : "Please enter Arrear Reason"
                        });
                    }
                }

                const modal = document.getElementById("salaryModal");
                const openModalBtn = document.getElementById("openModal");
                const closeModalBtn = document.querySelector(".close");

                closeModalBtn.addEventListener("click", () => {
                    modal.style.display = "none";
                });

                window.addEventListener("click", (event) => {
                    if (event.target === modal) {
                        modal.style.display = "none";
                    }
                });

                // Bind submit via jQuery
                $(document).on('submit', '#Arrear_Form', save_arrear);

            function save_arrear() {
            event.preventDefault(); // Prevent the link's default action
            var emp_id = $("#Employee_Id_inpur_arrear_form").val();
            var Arrear_amount_var = $("#Arrear_Amount_input").val();
            var Arrear_reason_var = $("#Arrear_Reason").val();
            var Arrear_method_var = $("#Arrear_Amount_input").val();

            var monthly_salary_var = $("#monthly_salary" + emp_id).text();
            var Advance_amount_var = $("#advance" + emp_id).text();
            var Deduction_amount_var = $("#deductions_amount" + emp_id).text();
            if (Arrear_amount_var != "" && Arrear_reason_var != "") {
                close_Arrear_Info_form()
                // arrear_amount_td${all_users_data.Employee_id}arrear_reason_td
                $("#arrear_amount_td" + emp_id).text(Arrear_amount_var);
                $("#arrear_reason_td" + emp_id).text(Arrear_reason_var);
                var monthly_income = $("#monthly_salary" + emp_id).text();
                var net_income = $("#net_salary" + emp_id).text();
                var n_salary

                n_salary = parseFloat(monthly_salary_var) - parseFloat(Advance_amount_var) - parseFloat(Deduction_amount_var) +
                parseFloat(Arrear_amount_var);
                $("#net_salary" + emp_id).text(n_salary.toFixed(2)); // Ensure two decimal places
                var formData = $('#Arrear_Form').serialize();
                // Make AJAX POST request
                $.ajax({
                url: "{{ route('add_arrear_api') }}", // Laravel route
                method: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val() // CSRF token
                },
                success: function (response) {
                    // Handle success response
                    alert(response.message);
                    $('#Arrear_Form')[0].reset(); // Reset the form
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    alert('An error occurred: ' + xhr.responseText);
                }
                });
            } else {
                if (Arrear_amount_var == "") {
                alert("Please Enter Arrear Amount");
                } else {
                alert("Please Enter Arrear Reason");
                }
            }
        };

        // Example JavaScript variable
        var myJavascriptVar = "2024-10-01";
        // Set the cookie
        document.cookie = "myJavascriptVar=" + encodeURIComponent(myJavascriptVar) + "; path=/;";

        //Start for showing filtered data of terminated employee

        // Function to get URL parameter by name
        function getUrlParameter(name) {
            name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
            var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
            var results = regex.exec(location.search);
            return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
        }

        var Working_Day;
        var limit = 50;

        // Get URL parameters for month, year, and employee_id
        var urlMonth = getUrlParameter('month');
        var urlYear = getUrlParameter('year');
        var urlEmployeeId = getUrlParameter('employee_id');

        // Use URL parameters if available, otherwise use current month/year
        var s_month = urlMonth ? parseInt(urlMonth) - 1 : new Date().getMonth();
        var s_year = urlYear ? parseInt(urlYear) : new Date().getFullYear();
        var inp = urlEmployeeId || "";
        var month = "";
        var year = "";

        function getLastDateOfMonth(year, month) {
            // Month is 0-based (0 = January, 11 = December)
            return new Date(year, month + 1, 0).getDate();
        }

        var set_last_date = getLastDateOfMonth(s_year, s_month);
        s_month = s_month + 1;
        var start_d = s_year + "-" + s_month + "-01";
        var end_d = s_year + "-" + s_month + "-" + set_last_date;
        var page_url;
        arrear_year = s_year;
        arrear_month = s_month;

        // Initialize the page with the URL parameters
        lode_data();

        function lode_data() {
            // Get the employee ID from URL
            var employeeId = getUrlParameter('employee_id');

            // Construct the base URL
            page_url = "{{url('/salary-calculations-api')}}/" + limit + "/" + s_month + "/" + s_year;

            // Add employee_id parameter if it exists
            if (employeeId) {
                page_url += "?employee_id=" + employeeId;
            }

            attendance_data_set(page_url);
        }

        // Update the month selector if available
        document.addEventListener('DOMContentLoaded', function() {
            const monthSelector = document.getElementById("month-selector");
            if (monthSelector && urlMonth && urlYear) {
                // Format the date to YYYY-MM for the month selector
                const formattedMonth = urlMonth.padStart(2, '0');
                monthSelector.value = `${urlYear}-${formattedMonth}`;
            }
        });

        //End for showing filtered data of terminated employee

        const formatDateToYYYYMMDD = (date) => {
            const f_year = date.getFullYear();
            const f_month = String(date.getMonth() + 1).padStart(2, '0');
            const f_day = String(date.getDate()).padStart(2, '0');
            return `${f_year}-${f_month}-${f_day}`;
        };

        // This function will be triggered when the user selects a month
        document.getElementById("month-selector").addEventListener("change", function () {
            set_month_for_data(); // or any function you want to call
        });


        function set_month_for_data() {
            const dateInput = document.getElementById("month-selector").value;
            const selectedDate = new Date(dateInput);

            if (isNaN(selectedDate.getTime())) {
                alert("Please select a valid month.");
                return;
            }

            // Extract year and month
            let s_year = selectedDate.getFullYear();
            let s_month = selectedDate.getMonth(); // 0-based for getLastDateOfMonth
            let set_last_date = getLastDateOfMonth(s_year, s_month);

            // Set global values
            arrear_year = s_year;
            arrear_month = s_month + 1; // convert to 1-based for usage

            // Format dates
            let formatted_month = arrear_month < 10 ? "0" + arrear_month : arrear_month;
            let start_d = `${arrear_year}-${formatted_month}-01`;
            let end_d = `${arrear_year}-${formatted_month}-${set_last_date}`;

            let page_url = "{{url('/salary-calculations-api')}}/" + limit + "/" + arrear_month + "/" + arrear_year;
            attendance_data_set(page_url);
        }

        var f_name_click_count = 1;
        var employ_id_click_count = 1;
        var mobile_number_click_count = 1;
        var email_click_count = 1;
        var aadhaar_number_click_count = 1;
        var pan_number_click_count = 1;

        $("#search_btn").on("click", function (event) {
        event.preventDefault(); // Prevent the link's default action
        // Perform your custom logic
        serch_on_key_presh()
        });

        function set_limit() {
        limit = $("#limit_inputt").val();
        if (month == "") {
            month = s_month
        }
        if (year == "") {
            year = s_year;
        }
        if (inp == "") {
            page_url = "{{url('/salary-calculations-api')}}/" + limit + "/" + month + "/" + year
        } else {
            page_url = "{{url('/salary-calculations-short-search-api')}}/" + limit + "/" + month + "/" + year + "/" + inp
        }
        attendance_data_set(page_url)
        }

        function serch_on_key_presh() {
            let inp = $("#search_input").val().trim();

            // Use the global variables that are set in set_month_for_data()
            let month = arrear_month;  // This is already 1-based from your function
            let year = arrear_year;

            if (inp === "") inp = "all"; // fallback when search input is empty

            let page_url = "{{ url('/salary-calculations-short-search-api') }}/" + limit + "/" + month + "/" + year + "/" + inp;
            attendance_data_set(page_url);
        }

        $('#pagination_div').on('click', '.page-btn', function () {
        var page = $(this).data('page'); // Get the page number from the button's data attribute
        attendance_data_set(page)
        });

        function short_data(short_by) {
        if (month == "") {
            month = s_month
        }
        if (year == "") {
            year = s_year;
        }
        if (short_by == 'f_name') {
            if (f_name_click_count % 2 == 0) {
            methid = 'asc'
            } else {
            methid = 'desc'
            }
            f_name_click_count++;
            page_url = "{{url('/salary-calculations-short-api')}}/" + limit + "/" + month + "/" + year + "/" + short_by + "/" +
            methid
            attendance_data_set(page_url)

        } else if (short_by == 'Employee_id') {
            if (employ_id_click_count % 2 == 0) {
            methid = 'asc'
            } else {
            methid = 'desc'

            }
            employ_id_click_count++;
            page_url = "{{url('/salary-calculations-short-api')}}/" + limit + "/" + month + "/" + year + "/" + short_by + "/" +
            methid
            attendance_data_set(page_url)

        } else if (short_by == 'Shift_hours') {
            if (mobile_number_click_count % 2 == 0) {
            methid = 'asc'
            } else {
            methid = 'desc'

            }
            mobile_number_click_count++;
            page_url = "{{url('/salary-calculations-short-api')}}/" + limit + "/" + month + "/" + year + "/" + short_by + "/" +
            methid
            attendance_data_set(page_url)

        } else if (short_by == 'email') {
            if (email_click_count % 2 == 0) {
            methid = 'asc'
            } else {
            methid = 'desc'

            }
            email_click_count++;
            page_url = "{{url('/salary-calculations-short-api')}}/" + limit + "/" + month + "/" + year + "/" + short_by + "/" +
            methid
            attendance_data_set(page_url)

        } else if (short_by == 'aadhaar_number') {
            if (aadhaar_number_click_count % 2 == 0) {
            methid = 'asc'
            } else {
            methid = 'desc'

            }
            aadhaar_number_click_count++;
            page_url = "{{url('/salary-calculations-short-api')}}/" + limit + "/" + month + "/" + year + "/" + short_by + "/" +
            methid
            attendance_data_set(page_url)

        } else if (short_by == 'pan_number') {
            if (pan_number_click_count % 2 == 0) {
            methid = 'asc'
            } else {
            methid = 'desc'

            }
            pan_number_click_count++;
            page_url = "{{url('/salary-calculations-short-api')}}/" + limit + "/" + month + "/" + year + "/" + short_by + "/" +
            methid
            attendance_data_set(page_url)
        } else {}
        }


        // First, let's modify how the table columns are created
        function attendance_data_set(url_input) {
    $.ajax({
        url: url_input,
        type: "GET",
        dataType: "json",
        headers: {
            "Content-Type": "application/json"
        },
        data: {
            empId: {{ $_GET['employee_id'] ?? 'null' }},
        },

        success: function(response) {
            console.log("Response:", response);
            $("#result").empty();
            var count_flag = 1;
            var all_data = response.data;
            var role_number = $("#role_number").val();
            // Initialize variables
            var Work = 0, Absent = 0, Over_Time = 0, Over_Time_in_INR = 0,
                Working_Day = 0, deductions_amount = 0, month_deductions_amount = 0,
                Penalty = 0, advance = 0, monthaly_salary = 0, net_salary = 0;

            // Other variable initializations remain the same
            var Day_Total_Amount = 0;
            var Over_Ttime_Rate = 0;
            var Swap_Day_array_data = 0;
            var Swap_Date = '';
            var Public_Holiday_array_data = 0;
            var Daily_Rate = 0;
            var leave_color = "";
            var Half_Day_Leave = 0;
            var Payment_Status = "";
            var Short_Name = "";
            var OT_Amt = 0;
            var Daily_Amt = 0;
            var Total_OT_Amount = 0;
            var Total_Amount = 0;
            var Total_all_day_Amount = 0;
            var Weekly_Off_array_data = 0;
            var data_count = 1;
            var top_table_content = 0;
            var one_user_monthly_in_out = '';
            var one_user_monthly_total_amount = 0;
            var month_and_year_var;
            var month_year;
            var leave_holiday_weakly_off_count = 0;

            // Get all data from response
            var all_users_data = response.all_users.data;
            var all_attandance_data = response.attendance_info_data;
            var deductions_data = response.deductions_data;
            var penalty_data = response.penalty_data;
            var advance_data = response.advance_data;
            var public_holiday_data = response.holiday_data;
            var leave_data = response.leave_data;

            // Basic table structure
            var table_html_data = `
                <div class="card">
                <div class="card-body">
                    <table id="salary_table" class="table table-bordered table-hover display nowrap" style="width:100%" data-responsive="true">
                        <thead>
                            <tr>
                            <th colspan="4"></th>
                            `;

            // Get date range
            const startDate = new Date(start_d);
            const endDate = new Date(end_d);
            const dates = [];
            var c_data = response.calendar_data;
            c_data.forEach(c_data => {
                dates.push(new Date(c_data.date));
                Working_Day++;
            });



            // Create column headers for each date
            dates.forEach(date => {
                const formattedDate = date.toLocaleDateString("en-US", {
                    weekday: "long",
                    day: "2-digit",
                    month: "long",
                    year: "numeric"
                });

                    month_and_year_var = date.toLocaleDateString("en-US", {
                    month: "long",
                    year: "numeric"
                });

                // Create a date header that spans multiple columns
                table_html_data += `
                <th colspan="7" class="text-center">${formattedDate}</th>
                `;
            });

            // Close the first header row and start the second row with the first four columns
            table_html_data += `
                </tr>
                <tr>
                    <th>Sr. N.</th>
                    <th>Name</th>
                    <th>Employee Id</th>
                    <th>Shift hrs</th>
            `;

            // Create sub-headers for each date
            dates.forEach(date => {
                table_html_data += `
                    <th>In</th>
                    <th>Out</th>
                    <th>Tot. Hrs</th>
                    <th>Tot. Min</th>
                    <th>OT Min</th>
                    <th>OT Amt</th>
                    <th>Daily Amt</th>
                `;
            });

            // Add the remaining column headers
            table_html_data += `
                    <th>Total Day</th>
                    <th>Working Day</th>
                    <th>work (in day)</th>
                    <th>Absent</th>
                    <th>Over Time</th>
                    <th>Over Time Rate</th>
                    <th>Over Time (in INR)</th>
                    <th>Loan / Advance(in INR)</th>
                    <th>Deduction</th>
                    <th>Penalty</th>
                    <th>Arrear</th>
                    <th>Arrear Reason</th>
                    <th>Daily_Rate</th>
                    <th>Monthly Salary</th>
                    <th>Net Salary</th>
                    <th>Paid Amount</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
            `;

            // Process each user's data
            all_users_data.forEach(all_users_data => {
                // Reset variables for each user
                Work = 0;
                Over_Time = 0;
                deductions_amount = 0;
                advance = 0;
                Total_OT_Amount = 0;
                Total_all_day_Amount = 0;
                leave_holiday_weakly_off_count = 0;
                cumulative_amount = 0; // Reset cumulative amount for each user

                const hasTerminationDate = all_users_data.termination_date && all_users_data.termination_date.trim() !== '';
                const terminationDate = hasTerminationDate ? new Date(all_users_data.termination_date) : null;

                let dateInput = document.getElementById("month-selector").value;
                let selectedDate = new Date(dateInput);

                // Extract month and year for clean comparison
                const selectedMonth = selectedDate.getMonth();
                const selectedYear = selectedDate.getFullYear();

                let showEmployee = true;

                if (hasTerminationDate) {
                    const terminationMonth = terminationDate.getMonth();
                    const terminationYear = terminationDate.getFullYear();

                    // Skip employee if selected date is after termination month
                    if (
                        selectedYear > terminationYear ||
                        (selectedYear === terminationYear && selectedMonth > terminationMonth)
                    ) {
                        showEmployee = false;
                    }

                    if (!showEmployee) return; // Employee already terminated, skip row
                }

                // Calculate employee's effective working days based on termination date
                let effectiveWorkingDays = Working_Day;

                if (hasTerminationDate) {
                    // Count only working days that are on or before the termination date
                    effectiveWorkingDays = dates.filter(date => date <= terminationDate).length;
                }


                table_html_data += `
                    <tr id="users_data_row${all_users_data.Employee_id}" ondblclick="open_arrear_pop_up('${all_users_data.Employee_id}')">
                    <td>${data_count}</td>
                    <td onclick="open_pershon_details('${all_users_data.Employee_id}')">${all_users_data.f_name} ${all_users_data.m_name} ${all_users_data.l_name}</td>
                    <td>${all_users_data.Employee_id}</td>
                    <td>${all_users_data.Shift_hours}</td>
                `;

                var Employee_Daily_Rate = all_users_data.salary / Working_Day;
                data_count++;
                var pop_up_total_hr = 0;
                var pop_up_total_min = 0;
                var pop_up_total_ot_hr = 0;
                var pop_up_total_ot_min = 0;
                var pop_up_total_ot_amount = 0;
                var pop_up_total_amount = 0;

                // Initialize monthly in/out report
                one_user_monthly_in_out = `
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <tbody id="in_out_single_user_tr">
                `;

                // Process each date for this user
                dates.forEach(date => {
                    // Initialize daily amount for this date
                    let dailyAmountForThisDate = 0;
                    let Daily_Amt = 0;
                    let OT_Amt = 0;

                    if (hasTerminationDate && date > terminationDate) {
                        // Skip processing for dates after termination
                        table_html_data += `
                            <td class="bg-termination"></td>
                            <td class="bg-termination"></td>
                            <td class="bg-termination"></td>
                            <td class="bg-termination"></td>
                            <td class="bg-termination"></td>
                            <td class="bg-termination"></td>
                            <td class="bg-termination"></td>
                        `;

                        return;
                    }

                    const formattedDate = date.toLocaleDateString("en-US", {
                        day: "2-digit",
                        month: "long",
                        year: "numeric"
                    });

                    month_year = date.toLocaleDateString("en-US", {
                        month: "2-digit",
                        year: "numeric"
                    });

                    // Filter data for this user and date
                    const filteredData = all_attandance_data.filter(all_att_data =>
                        all_att_data.Employee_id === all_users_data.Employee_id &&
                        (formatDateToYYYYMMDD(date) === all_att_data.attandence_Date ||
                        formatDateToYYYYMMDD(date) === all_att_data.Swap_Date)
                    );

                    // Check for public holidays, leave data, etc.
                    const public_holiday_filyer_data = public_holiday_data.filter(public_holiday_data =>
                        formatDateToYYYYMMDD(date) === public_holiday_data.holiday_Date
                    );

                    const leave_filter_data = leave_data.filter(leave_d =>
                        leave_d.Employee_id === all_users_data.Employee_id && leave_d.Start_Date <=
                        formatDateToYYYYMMDD(date) && leave_d.End_Date >= formatDateToYYYYMMDD(date)
                    );

                    // Initialize variables
                    let leave_color = '';
                    let Half_Day_Leave = 0;
                    let Payment_Status_Leave = '';
                    let Short_Name_Leave = '';
                    let Payment_Status = "";
                    let Public_Holiday_array_data = 0;

                    // Process leave data if available
                    if (leave_filter_data.length > 0) {
                        leave_filter_data.forEach(leave_filter_data => {
                            leave_color = leave_filter_data.Color;
                            Half_Day_Leave = leave_filter_data.Half_Day;
                            Payment_Status_Leave = leave_filter_data.Payment_Status;
                            Short_Name_Leave = leave_filter_data.Short_Name;
                        });
                    }

                    // Check for public holidays
                    public_holiday_filyer_data.forEach(pub_ho => {
                        if (pub_ho.holiday_Date === formatDateToYYYYMMDD(date)) {
                            Public_Holiday_array_data = 1;
                        } else {
                            Public_Holiday_array_data = 0;
                        }
                    });

                    let cellBackgroundColor = ''; // Default is no background color
                    let currentDateFormatted = formatDateToYYYYMMDD(date);

                    // Helper function to normalize date formats for reliable comparison
                    function normalizeDate(dateValue) {
                        if (!dateValue) return null;

                        try {
                            // Handle different date formats
                            if (typeof dateValue === 'string') {
                                // If it's already in YYYY-MM-DD format, return it
                                if (/^\d{4}-\d{2}-\d{2}$/.test(dateValue)) {
                                    return dateValue;
                                }
                                // Otherwise convert to Date and format
                                return formatDateToYYYYMMDD(new Date(dateValue));
                            } else if (dateValue instanceof Date) {
                                return formatDateToYYYYMMDD(dateValue);
                            }
                            return null;
                        } catch (e) {
                            console.error(`Date normalization error: ${e.message}`);
                            return null;
                        }
                    }

                    // Process all dates in filteredData
                    let swapDates = [];
                    let holidayDates = [];
                    let weeklyOffs = [];
                    let swapDays = [];
                    let Daily_Rate = all_users_data.Daily_Rate || 0; // Initialize with employee's default rate
                    let Over_Ttime_Rate = parseFloat(all_users_data.Over_Ttime_Rate || 0); // Initialize with employee's default OT rate
                    let hasActualAttendanceData = false; // Flag to check if we have real attendance data

                    // Safety check before processing
                    if (filteredData && Array.isArray(filteredData)) {
                        filteredData.forEach(element => {
                            // Check if this is actual attendance data or just a swap date reference
                            if (element.attandence_Date === currentDateFormatted) {
                                hasActualAttendanceData = true;
                            }

                            // Process swap dates
                            if (element.Swap_Date) {
                                const normalizedDate = normalizeDate(element.Swap_Date);
                                if (normalizedDate) swapDates.push(normalizedDate);
                            }

                            // Process holiday dates
                            if (element.Holiday_Date) {
                                const normalizedDate = normalizeDate(element.Holiday_Date);
                                if (normalizedDate) holidayDates.push(normalizedDate);
                            }

                            // Process other data
                            if (element.Swap_Day == 1) swapDays.push(element);
                            if (element.WeeklyOff == 1) weeklyOffs.push(element);

                            // Keep the last values for rates (assuming they're the same for all records)
                            if (element.Daily_Rate) Daily_Rate = element.Daily_Rate;
                            // Add these console logs after retrieving Over_Ttime_Rate
                            console.log(`Employee ID: ${all_users_data.Employee_id}, Initial Over_Ttime_Rate: ${Over_Ttime_Rate}`);

                            // In the filteredData loop where Over_Ttime_Rate is potentially updated
                            if (element.Over_Ttime_Rate) {
                                Over_Ttime_Rate = parseFloat(element.Over_Ttime_Rate);
                            }
                        });
                    }

                    console.log(Over_Ttime_Rate);

                    // Determine the cell background color based on conditions
                    if (swapDates.includes(currentDateFormatted)) {
                        cellBackgroundColor = 'style="background-color:orange"'; // Swap date
                        console.log(`Swap date found: ${currentDateFormatted}`);

                        // Only add daily amount for swap dates if there's no actual attendance data
                        if (!hasActualAttendanceData) {
                            Daily_Amt = Employee_Daily_Rate;
                        }
                    }
                    else if (swapDays.length > 0) {
                        cellBackgroundColor = 'style="background-color:orange"'; // Swap day
                        console.log(`Swap day found: ${currentDateFormatted}`);

                        // Only add daily amount for swap days if there's no actual attendance data
                        if (!hasActualAttendanceData) {
                            Daily_Amt = Employee_Daily_Rate;
                        }
                    }
                    else if (public_holiday_filyer_data && public_holiday_filyer_data.length == 1) {
                        cellBackgroundColor = 'style="background-color:yellow"'; // Public holiday
                        Daily_Amt = Employee_Daily_Rate;
                    }
                    else if (weeklyOffs.length > 0) {
                        cellBackgroundColor = 'style="background-color:cyan"'; // Weekly off
                        Daily_Amt = Employee_Daily_Rate;
                    }
                    else if (all_users_data && all_users_data.Weekly_Off &&
                            all_users_data.Weekly_Off == date.toLocaleDateString('en-US', { weekday: 'long' })) {
                        cellBackgroundColor = 'style="background-color:cyan"'; // Weekly off by day name
                        Daily_Amt = Employee_Daily_Rate;
                    }
                    else if (holidayDates.includes(currentDateFormatted)) {
                        cellBackgroundColor = 'style="background-color:yellow"'; // Holiday date
                        Daily_Amt = Employee_Daily_Rate;
                    }
                    else if (public_holiday_filyer_data && Array.isArray(public_holiday_filyer_data)) {
                        // Check if any holiday date matches the current date
                        const found = public_holiday_filyer_data.some(holiday => {
                            if (!holiday || !holiday.holiday_Date) return false;
                            return normalizeDate(holiday.holiday_Date) === currentDateFormatted;
                        });

                        if (found) {
                            cellBackgroundColor = 'style="background-color:yellow"'; // Public holiday
                            Daily_Amt = Employee_Daily_Rate;
                        }
                    }
                    else if (leave_filter_data.length > 0) {
                        Payment_Status = leave_filter_data[0].Payment_Status;
                        cellBackgroundColor = 'style="background-color:' + leave_color + '"'; // Leave

                        if (Half_Day_Leave == 1) {
                            cellBackgroundColor = 'style="background: linear-gradient(to right, ' + leave_color + ' 50%, transparent 50%)"';
                            leave_holiday_weakly_off_count += 0.5;

                            if (Payment_Status == "Paid") {
                                Daily_Amt = Employee_Daily_Rate / 2;
                            }
                        } else {
                            if (cellBackgroundColor != "") {
                                leave_holiday_weakly_off_count++;

                                if (Payment_Status == "Paid") {
                                    Daily_Amt = Employee_Daily_Rate;
                                }
                            }
                        }
                    }

                    // Create attendance table cells based on actual data presence
                    if (!hasActualAttendanceData) {
                        // No actual attendance data for this date (or only swap reference)
                        table_html_data += `
                            <td ${cellBackgroundColor}></td>
                            <td ${cellBackgroundColor}></td>
                            <td ${cellBackgroundColor}></td>
                            <td ${cellBackgroundColor}></td>
                            <td ${cellBackgroundColor}></td>
                            <td ${cellBackgroundColor}></td>
                            <td ${cellBackgroundColor}>${Daily_Amt.toFixed(2)}</td>
                        `;

                        // Update cumulative amount with daily amount for this date
                        dailyAmountForThisDate = Daily_Amt;
                        cumulative_amount += dailyAmountForThisDate;

                        // Add to monthly in/out report
                        one_user_monthly_in_out += `
                        <tr>
                            <td class="in_time_p" ${cellBackgroundColor}>${formatDateToYYYYMMDD(date)}</td>
                            <td class="in_time_p" ${cellBackgroundColor}></td>
                            <td class="out_time_p" ${cellBackgroundColor}></td>
                            <td class="total_hr_p" ${cellBackgroundColor}></td>
                            <td class="total_min_p" ${cellBackgroundColor}></td>
                            <td class="total_min_p ot" ${cellBackgroundColor}></td>
                            <td class="total_min_p ot" ${cellBackgroundColor}></td>
                            <td class="total_min_p ot" ${cellBackgroundColor}></td>
                            <td class="total_min_p ot" ${cellBackgroundColor}>${Daily_Amt.toFixed(2)}</td>
                            <td class="total_min_p ot" ${cellBackgroundColor}>${cumulative_amount.toFixed(2)}</td>
                        </tr>`;
                    } else {
                        // Filter for only actual attendance data, not swap references
                        const actualAttendanceData = filteredData.filter(data => data.attandence_Date === currentDateFormatted);

                        actualAttendanceData.forEach(all_att_data => {
                            // Calculate actual attendance amount
                            let attendanceDaily_Amt = 0;

                            if (Half_Day_Leave == 1 && all_att_data.Totel_Hours >= all_att_data.Shift_hours / 2) {
                                attendanceDaily_Amt = all_att_data.Daily_Rate / 2;
                            } else if (all_att_data.Totel_Hours >= all_att_data.Shift_hours) {
                                attendanceDaily_Amt = all_att_data.Daily_Rate;
                            } else {
                                attendanceDaily_Amt = all_att_data.Daily_Rate;
                            }

                            // Set the daily amount for this record
                            Daily_Amt = attendanceDaily_Amt;

                            // Ensure we have a valid overtime rate
                            if (all_att_data.Over_Ttime_Rate) {
                                Over_Ttime_Rate = all_att_data.Over_Ttime_Rate;
                            }

                            // Calculate OT amount
                            OT_Amt = all_att_data.Overtime * Over_Ttime_Rate;
                            Total_OT_Amount = Total_OT_Amount + OT_Amt;

                            const formattedTotalHours = parseFloat(all_att_data.Totel_Hours).toFixed(2);

                            // Add individual cells for each data point
                            table_html_data += `
                                <td ${cellBackgroundColor}>${all_att_data.in_time}</td>
                                <td ${cellBackgroundColor}>${all_att_data.out_time}</td>
                                <td ${cellBackgroundColor}>${parseFloat(all_att_data.Totel_Hours).toFixed(2)}</td>
                                <td ${cellBackgroundColor}>${all_att_data.Total_Minutes}</td>
                                <td ${cellBackgroundColor}>${all_att_data.Overtime}</td>
                                <td ${cellBackgroundColor}>${OT_Amt.toFixed(2)}</td>
                                <td ${cellBackgroundColor}>${Daily_Amt.toFixed(2)}</td>
                            `;

                            // Update cumulative amount with daily amount for this date
                            dailyAmountForThisDate = Daily_Amt;
                            cumulative_amount += dailyAmountForThisDate;

                            // Add to monthly in/out report
                            one_user_monthly_in_out += `
                            <tr>
                                <td class="in_time_p" ${cellBackgroundColor}>${formatDateToYYYYMMDD(date)}</td>
                                <td class="in_time_p" ${cellBackgroundColor}>${all_att_data.in_time}</td>
                                <td class="out_time_p" ${cellBackgroundColor}>${all_att_data.out_time}</td>
                                <td class="total_hr_p" ${cellBackgroundColor}>${parseFloat(all_att_data.Totel_Hours).toFixed(2)}</td>
                                <td class="total_min_p" ${cellBackgroundColor}>${all_att_data.Total_Minutes}</td>
                                <td class="total_min_p ot" ${cellBackgroundColor}>${all_att_data.OT_Hr}</td>
                                <td class="total_min_p ot" ${cellBackgroundColor}>${all_att_data.Overtime}</td>
                                <td class="total_min_p ot" ${cellBackgroundColor}>${OT_Amt.toFixed(2)}</td>
                                <td class="total_min_p ot" ${cellBackgroundColor}>${Daily_Amt.toFixed(2)}</td>
                                <td class="total_min_p ot" ${cellBackgroundColor}>${cumulative_amount.toFixed(2)}</td>
                            </tr>`;

                            pop_up_total_hr += parseFloat(all_att_data.Totel_Hours);
                            pop_up_total_min += all_att_data.Total_Minutes;
                            pop_up_total_ot_hr += all_att_data.OT_Hr;
                            pop_up_total_ot_min += all_att_data.Overtime;
                            pop_up_total_ot_amount += OT_Amt;
                            Work++;
                            Over_Time += all_att_data.Overtime;
                        });
                    }

                    pop_up_total_amount += Daily_Amt;
                    Total_all_day_Amount += Daily_Amt;
                    });

                    // Add totals row to monthly in/out report
                    one_user_monthly_in_out += `
                    <tr class="table-secondary font-weight-bold">
                        <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                        <td><strong>${pop_up_total_hr.toFixed(2)}</strong></td>
                        <td><strong>${pop_up_total_min}</strong></td>
                        <td><strong>${pop_up_total_ot_hr.toFixed(2)}</strong></td>
                        <td><strong>${pop_up_total_ot_min}</strong></td>
                        <td><strong>${pop_up_total_ot_amount.toFixed(2)}</strong></td>
                        <td><strong>${pop_up_total_amount.toFixed(2)}</strong></td>
                        <td><strong>${cumulative_amount.toFixed(2)}</strong></td>
                    </tr>`;

                    // Close the monthly in/out report table
                    one_user_monthly_in_out += `
                            </tbody>
                        </table>
                    </div>`;

                    // Use effective working days for calculations if employee is terminated
                    const calculationWorkingDays = hasTerminationDate ? effectiveWorkingDays : Working_Day;

                    // Calculate absence data
                    let holidayCount = 0;

                    // Count holidays before termination date
                    if (hasTerminationDate) {
                        holidayCount = public_holiday_data.filter(holiday =>
                            new Date(holiday.holiday_Date) <= terminationDate
                        ).length;
                    } else {
                        holidayCount = response.holiday_count;
                    }

                    // Calculate absence using the same formula as original, but with adjusted values
                    var Absent_count = calculationWorkingDays - holidayCount - Work;
                    if (Absent_count <= 0) {
                        Absent_count = 0;
                    }

                    // Use same total amount calculation as the original
                    Total_Amount = Total_all_day_Amount + Total_OT_Amount;

                    // Add summary columns with termination date consideration but same structure as original
                    table_html_data += `<td>${calculationWorkingDays}</td>
                                    <td>${calculationWorkingDays - holidayCount}</td>
                                    <td>${Work}</td>
                                    <td>${Absent_count}</td>
                                    <td>${Over_Time}</td>
                                    <td>${Over_Ttime_Rate.toFixed(2)}</td>
                                    <td>${Math.round(Total_OT_Amount)}</td>`;

                    // Add advance column exactly as in original
                    table_html_data += `<td id="advance${all_users_data.Employee_id}">`;
                    if (advance_data != "") {
                        advance_data.forEach(advance_data => {
                            if (advance_data.Employee_id == all_users_data.Employee_id) {
                                advance = parseInt(advance) + parseInt(advance_data.Loan_Amount_in_INR);
                            }
                        });
                    }
                    table_html_data += `${advance}</td>`;

                    // Add deductions column exactly as in original
                    table_html_data += `<td id="deductions_amount${all_users_data.Employee_id}">`;
                    if (deductions_data != null) {
                        deductions_data.forEach(deductions => {
                            if (deductions.Employee_id === all_users_data.Employee_id) {
                                deductions_amount += parseInt(deductions.deduction_Amount_in_INR);
                            }
                        });
                    }
                    table_html_data += `${deductions_amount}</td>`;

                    // Add penalty column
                    table_html_data += `<td id="penalty_amount${all_users_data.Employee_id}">`;
                    if (penalty_data != null) {
                        penalty_data.forEach(penalty => {
                            if (penalty.EmpID === all_users_data.Employee_id) {
                                Penalty += parseInt(penalty.Final_Amount);
                            }
                        });
                    }
                    table_html_data += `${Penalty}</td>`;

                    // Add arrear columns exactly as in original
                    table_html_data += `<td id="arrear_amount_td${all_users_data.Employee_id}">${all_users_data.Arrear_Amount ?? 0}</td>
                                    <td id="arrear_reason_td${all_users_data.Employee_id}">${all_users_data.Arrear_Reasons ?? " "}</td>`;

                    // Add daily rate and monthly salary exactly as in original
                    table_html_data += `<td>${Daily_Rate.toFixed(2)}</td>
                                    <td id="monthly_salary${all_users_data.Employee_id}">`;
                    // Same monthly salary calculation as original
                    monthaly_salary = Total_Amount + (leave_holiday_weakly_off_count * all_users_data.salary / 30);
                    table_html_data += `${Math.round(monthaly_salary)}</td>`;

                    // Add net salary cell start
                    var arrer_amo = all_users_data.Arrear_Amount ?? 0;
                    table_html_data += `<td id="net_salary${all_users_data.Employee_id}">`;

                    // Same net salary calculation as original, with parseInt for safety
                    net_salary = monthaly_salary - Penalty - deductions_amount + parseInt(arrer_amo || 0);

                    // Create termination info only if needed (new in second snippet)
                    let terminationInfo = '';
                    if (hasTerminationDate) {
                        terminationInfo = `<tr><td colspan="2" style="color:red">Terminated on: ${all_users_data.termination_date}</td><td colspan="8"></td></tr>`;
                    }

                    // Calculate overtime hours with 2 decimal places
                    const overtimeHours = (Over_Time / 60).toFixed(2);

                    // Create top table content - matches format of original but with termination info
                    top_table_content = `<tr>
                        <th colspan='2'>Employee Information</th>
                        <th colspan='2'>Attendance Details</th>
                        <th colspan='2'>Overtime</th>
                        <th colspan='3'>Deductions & Additions</th>
                        <th colspan='2'>Salary Details</th></tr>
                    <tr><td>Name</td> <td>${all_users_data.f_name} ${all_users_data.m_name} ${all_users_data.l_name}</td>
                    <td>Total Days</td><td>${calculationWorkingDays}</td> <td>Overtime (Hours)</td><td>${overtimeHours}</td><td>Loan/Advance (INR)</td><td>${advance}</td>
                    <td>Daily Rate (INR)</td><td>${Daily_Rate.toFixed(2)}</td></tr>
                    <tr> <td>Employee ID</td> <td>${all_users_data.Employee_id}</td>
                    <td>Working Days</td><td>${calculationWorkingDays - holidayCount}</td> <td>Overtime Rate</td><td>${Over_Ttime_Rate.toFixed(2)}</td>
                    <td>Deductions</td><td>${deductions_amount}</td>
                    <td>Gross Salary (INR)</td><td>${monthaly_salary.toFixed(2)}</td></tr>
                    <tr> <td>Shift Hours</td> <td>${all_users_data.Shift_hours}</td>
                    <td>Days Worked</td><td>${Work}</td>
                    <td>Overtime (INR)</td><td>${Total_OT_Amount.toFixed(2)}</td>
                    <td>Penalty</td><td>${Penalty}</td>
                    <td>Net Salary (INR)</td><td>${Math.round(net_salary)}</td> </tr>
                    <tr> <td colspan='2'></td>
                    <td>Days Absent</td><td>${Absent_count}</td>
                    <td colspan='2'></td>
                    <td>Arrear</td><td>${all_users_data.Arrear_Amount ?? 0}</td>
                    <td>Paid Amount</td><td id='paid_amoutn_for_pup_up_span'></td>
                    </tr>
                    <tr>
                    <td colspan='2'></td>
                    <td colspan='4'></td>
                    <td>Arrear Reason</td><td colspan='3'>${all_users_data.Arrear_Reasons ?? " "}</td>
                    </tr>
                    ${terminationInfo}`;

                    // Set paid amount as in original
                    var paid_amt = Math.round(net_salary);

                    // Complete the net salary cell with hidden inputs as in original
                    table_html_data += `${Math.round(net_salary)}
                    <input hidden id="header_cont_${all_users_data.Employee_id}" type="text" value="${top_table_content.replace(/"/g, '&quot;')}">
                    <input hidden value='${one_user_monthly_total_amount}' id='one_user_monthly_total_amount${all_users_data.Employee_id}'>
                    <input hidden value='${one_user_monthly_in_out}' id='one_user_monthly_in_out${all_users_data.Employee_id}'>
                    <p id='heading${all_users_data.Employee_id}' hidden>Salary of ${all_users_data.f_name} ${all_users_data.m_name} ${all_users_data.l_name} for ${month_and_year_var}</p></td>`;

                    // Add paid amount cell as in original
                    table_html_data += `<td><input type="text" value="${paid_amt}" style="border:none" id="paid_amount_td${all_users_data.Employee_id}"></td>
                    <td hidden><input type="text" value="${Math.round(net_salary)}" style="border:none" id="net_amount_td${all_users_data.Employee_id}" hidden></td>
                    <td hidden><input type="text" value="${Total_OT_Amount}" style="border:none" id="OT_amt${all_users_data.Employee_id}" hidden></td>
                    <td hidden><input type="text" value="${overtimeHours}" style="border:none" id="OT_hrs${all_users_data.Employee_id}" hidden></td>
                    <td hidden><input type="text" value="${Penalty}" style="border:none" id="penalty_amt${all_users_data.Employee_id}" hidden></td>
                    <td id="${all_users_data.Employee_id}" onclick="salary_paid_function(${all_users_data.Employee_id})">`;

                    // Add pay/final settlement buttons with same styling as original
                    if (all_users_data.Paid_Flag == 1) {
                        table_html_data += `<button class="pay-salary-btn" disabled id='payButton${all_users_data.Employee_id}'>
                            <i class="fas fa-check-circle"></i> PAID
                        </button>`;
                    } else if (
                        hasTerminationDate &&
                        terminationDate.getMonth() === selectedMonth &&
                        terminationDate.getFullYear() === selectedYear
                    ) {
                        table_html_data += `<button class="pay-salary-btn" id='payButton${all_users_data.Employee_id}' onclick='paySalary(${all_users_data.Employee_id})'>
                            <i class="fa-solid fa-indian-rupee-sign"></i> Final Settlement
                        </button>`;
                    } else {
                        table_html_data += `<button class="pay-salary-btn" id='payButton${all_users_data.Employee_id}' onclick='paySalary(${all_users_data.Employee_id})'>
                            <i class="fa-solid fa-indian-rupee-sign"></i> Pay Salary
                        </button>`;
                    }

                    table_html_data += `</td>`;

                // Reset variables for next user
                leave_holiday_weakly_off_count = 0;
                one_user_monthly_in_out = '';
                top_table_content = '';
                one_user_monthly_total_amount = 0;
                Work = 0;
                paid_amt = 0;
                Over_Time = 0;
                deductions = 0;
                Penalty = 0;
                advance = 0;
                deductions_amount = 0;
                advance = "0";
                Over_Ttime_Rate = 0;
                Day_Total_Amount = 0;
                Daily_Rate = 0;
                Over_Ttime_Rate = 0;
                Total_OT_Amount = 0;
                Total_Amount = 0;
                Total_all_day_Amount = 0;
            });

            // Close the table
            table_html_data += `
                </tbody>
            </table>
        </div>
        </div>
            `;

            // Display the table
            $("#result").html(table_html_data);


            // Add DataTables initialization
            $('#salary_table').DataTable({
                "scrollX": true,
                "scrollCollapse": true,
                "paging": true,
                "pageLength": 10,
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "info": true,
                "searching": true,
                "ordering": true,
                "order": [
                    [0, "asc"]
                ],
                "autoWidth": false,
                "responsive": false,
                "dom": 'Bfrtip',
                "buttons": [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                "language": {
                    "search": "Search:",
                    "lengthMenu": "Show _MENU_ entries",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "infoEmpty": "Showing 0 to 0 of 0 entries",
                    "infoFiltered": "(filtered from _MAX_ total entries)",
                    "paginate": {
                        "first": "First",
                        "last": "Last",
                        "next": "Next",
                        "previous": "Previous"
                    }
                },
                "stateSave": true,
                "columnDefs": [{ "targets": "_all", "defaultContent": "" }],
                "fixedHeader": true
            });
        },
        error: function(xhr, status, error) {
            console.error("Error:", error);

            $("#result").html(`
<div class="alert alert-danger">Error loading data: ${error}</div>
`);
        }
    });
}
setInterval(() => {

}, 1000);

        function validateNumber(cell, Employee_id) {
        const value = cell.innerText;
        if (!/^[\d+-]*$/.test(value)) { // Allow digits, +, and -
            cell.innerText = value.replace(/[^0-9+-]/g, ''); // Remove all characters except digits, +, and -
            alert('y');
        }
        }

        function open_arrear_pop_up(employee_id) {
            // First call the salary paid logic

            const paid_button_text = $("#payButton" + employee_id).text().trim();
            if (paid_button_text === "PAID") {
                return;
            }

            // Open the arrear info form modal or section
            open_Arrear_Info_form(employee_id);

            // Get arrear amount and reason from the table cells
            const arrear_amount_td = $("#arrear_amount_td" + employee_id).text();
            const arrear_reason_td = $("#arrear_reason_td" + employee_id).text();

            // Get year and month from the input (format: YYYY-MM)
            const inputMonth = document.getElementById("month-selector").value;

            if (!inputMonth) {
                alert("Please select a month first.");
                return;
            }

            const [arrear_year, raw_month] = inputMonth.split("-");
            const arrear_month = raw_month.padStart(2, "0"); // ensure 2-digit month

            // Populate the modal fields
            $("#Employee_Id_inpur_arrear_form").val(employee_id);
            $("#Arrear_Amount_input").val(arrear_amount_td);
            $("#Arrear_Reason").val(arrear_reason_td);
            $("#Arrear_month_year").val(`${arrear_year}-${arrear_month}`);
        }




        $(document).on('click', '#saveTableData', function () {

        var input_month = $('#month_selector').val();
        if (input_month !="") {
            arrear_month = input_month;
        }


        $.ajax({
                url: '{{url("/luck-one-clic-arrear-data")}}/' + arrear_month, // Laravel URL helper
                type: 'GET', // or 'POST' if required
                success: function(response) {
                    alert(response.message);
                    set_month_for_data();
                },
                error: function(xhr, status, error) {

                    alert(error);
                }
            });
    });



        function show_animation() {
        }

        function hide_animation() {
        }

        function salary_paid_function(employee_id){


            var input_month = $('#month-selector').val();
            if (input_month !="") {
                arrear_month = input_month;
            }
            var paid_amount = $('#paid_amount_td' + employee_id).val();
            var net_amount = $('#net_amount_td' + employee_id).val();
            var OT_amt = $('#OT_amt' + employee_id).val();
            var OT_hrs = $('#OT_hrs' + employee_id).val();

            $.ajax({
                    url: '{{url("/luck-arrear-data")}}/' + employee_id + "/" + arrear_month + "/" + paid_amount + "/" + net_amount+ "/" + OT_amt + "/" + OT_hrs, // Laravel URL helper
                    type: 'GET', // or 'POST' if required
                    success: function(response) {
                        alert(response.message);
                        hide_animation()
                    },
                    error: function(xhr, status, error) {

                        alert(error);
                        hide_animation()
                    }
                });

            }

            function paySalary(Employee_id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to pay the salary?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Pay Now!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Call the function only after user confirms
                        salary_paid_function(Employee_id);

                        // Update button text and state
                        const button = document.getElementById("payButton" + Employee_id);
                        if (button) {
                            button.innerHTML = '<i class="fas fa-check-circle"></i> PAID';
                            button.disabled = true;

                            const tooltip = button.querySelector('.tooltip');
                            if (tooltip) {
                                tooltip.style.visibility = 'hidden';
                            }
                        }
                    }
                });
            }

        $(function (e) {
            var all_ids = [];
            $("#sellect_all_ids").click(function () {
                $(".checkbox_ids").prop('checked', $(this).prop('checked'))
            })
            $('#delet_add_records').click(function (e) {
                $('input:checkbox[name=delet_ids]:checked').each(function () {
                all_ids.push($(this).val());
                })

                $.ajax({
                url: "{{route('delete_employee')}}",
                type: "POST",
                data: {
                    ids: all_ids,
                    _token: '{{csrf_token()}}'
                },
                success: function (response) {

                    alert(response.success)
                    location.reload()
                }
                })
            })
        })

        function close_bulk_uplaode() {
        document.getElementById('pup_up').style.display = "none"
        }

        function open_bulk_uplaode() {
        document.getElementById('pup_up').style.display = "flex"
        }

        window.addEventListener("click", (event) => {
        if (event.target === modal) {
            modal.style.display = "none";
        }
        });

        $(document).on('click', '#confirm-pay-btn', function () {
            var salary_month = $('#month-selector').val();

            if (salary_month === "") {
                alert("Please select a month before paying salaries.");
                return;
            }

            $.ajax({
                url: '{{ url("/pay-salaries") }}/' + salary_month, // Laravel route with month
                type: 'GET', // Or 'POST' if you're updating DB
                success: function (response) {
                    alert(response.message);
                    set_month_for_data(); // Optional: Refresh table or update something
                },
                error: function (xhr, status, error) {
                    alert("Error while paying salaries: " + error);
                }
            });
        });

        function open_pershon_details(emp_id) {

            var paid_amoutn_for_pup_up = $('#paid_amount_td' + emp_id).val();
            console.log($('#paid_amount_td' + emp_id).prop('outerHTML'));


            var hed_tr_data = $("#header_cont_" + emp_id).val();
            var one_user_monthly_in_out_data_var = $("#one_user_monthly_in_out" + emp_id).val();
            var table_heading = $("#heading" + emp_id).html();

            $("#heade_table_tr_data").html(hed_tr_data);
            $("#in_out_single_user_tr").html(one_user_monthly_in_out_data_var);
            $("#table_heading_h2").html(table_heading);
            $("#paid_amoutn_for_pup_up_span").text(paid_amoutn_for_pup_up);

            // Store employee ID in a hidden field for PDF generation
            if ($('#modal_employee_id').length === 0) {
                $('body').append(`<input type="hidden" id="modal_employee_id" value="${emp_id}">`);
            } else {
                $('#modal_employee_id').val(emp_id);
            }

            $('#salaryModal').modal('show');

            // Add Print and PDF buttons to modal footer
            if ($('#printButton').length === 0 && $('#pdfDownloadButton').length === 0) {
                $('.modal-footer').append(`
                    <button id="printButton" class="btn btn-primary me-2" onclick="printSalaryDetails('${emp_id}')">
                        <i class="fas fa-print"></i> Print
                    </button>
                `);
            } else {
                // Update existing buttons with new employee ID
                $('#printButton').attr('onclick', `printSalaryDetails('${emp_id}')`);
                $('#pdfDownloadButton').attr('onclick', `downloadPDF('${emp_id}')`);
            }
        }

        function printSalaryDetails(emp_id) {
            // Get modal content
            var paid_amoutn_for_pup_up = $('#paid_amount_td' + emp_id).val();

            var hed_tr_data = $("#header_cont_" + emp_id).val();
            var one_user_monthly_in_out_data_var = $("#one_user_monthly_in_out" + emp_id).val();
            var table_heading = $("#heading" + emp_id).html();

            // Create a new window for printing
            const printWindow = window.open('', '_blank');

            // Add necessary CSS for printing
            printWindow.document.write(`
                <html>
                <head>
                    <title>${table_heading}</title>
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
                    <style>
                        body { padding: 20px; font-family: Arial, sans-serif; }
                        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                        table, th, td { border: 1px solid #ddd; }
                        th, td { padding: 8px; text-align: left; }
                        th { background-color: #f2f2f2; }
                        .header-info { margin-bottom: 20px; }
                        @media print {
                            .no-print { display: none; }
                            button { display: none; }
                        }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <div class="row header-info">
                            <div class="col-12">
                                <h3>${table_heading}</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered">
                                    ${hed_tr_data}
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h4>Attendance Details</h4>
                                ${one_user_monthly_in_out_data_var}
                            </div>
                        </div>
                        <div class="row no-print">
                            <div class="col-12 text-center mt-3">
                                <button class="btn btn-primary" onclick="window.print()">Print</button>
                                <button class="btn btn-secondary" onclick="window.close()">Close</button>
                            </div>
                        </div>
                    </div>

                    <script>
                        setTimeout(function() {
                            window.print();
                        }, 1000);
                    <\/script>
                </body>
                </html>
            `);
            printWindow.document.close();

        }

        function toggleMonths() {
        var table = document.getElementById("salary_table");

        // Skip if table doesn't exist
        if (!table) return;

        // First, determine how many date columns we have
        var headerRow = table.rows[0];
        var subHeaderRow = table.rows[1];

        // Toggle the empty space above the first four columns
        if (headerRow.cells[0].colSpan === 4) {
            headerRow.cells[0].style.display =
                (headerRow.cells[0].style.display === "none" ? "" : "none");
        }

        // Get number of date columns from the header row
        var dateColumns = 0;
        var firstDateColIndex = 4; // After Sr No, Name, Employee Id, Shift hrs

        for (var i = 1; i < headerRow.cells.length; i++) { // Start from 1 to skip the empty space
            if (headerRow.cells[i].colSpan === 7) {
                dateColumns++;
            }
        }

        // Now toggle each date's columns
        for (var rowIndex = 0; rowIndex < table.rows.length; rowIndex++) {
            var row = table.rows[rowIndex];

            if (rowIndex <= 1) {
                // For header rows, toggle the date header cells
                if (rowIndex === 0) {
                    // For the main header row, toggle the date headers
                    for (var i = 1; i < headerRow.cells.length; i++) {
                        if (headerRow.cells[i].colSpan === 7) {
                            headerRow.cells[i].style.display =
                                (headerRow.cells[i].style.display === "none" ? "" : "none");
                        }
                    }
                } else {
                    // For the subheader row, toggle all date-related column headers
                    for (var dateIndex = 0; dateIndex < dateColumns; dateIndex++) {
                        var startColIndex = firstDateColIndex + (dateIndex * 7);
                        for (var subColIndex = 0; subColIndex < 7; subColIndex++) {
                            var colIndex = startColIndex + subColIndex;
                            if (colIndex < subHeaderRow.cells.length) {
                                subHeaderRow.cells[colIndex].style.display =
                                    (subHeaderRow.cells[colIndex].style.display === "none" ? "" : "none");
                            }
                        }
                    }
                }
            } else {
                // For data rows, toggle each date's cells
                for (var dateIndex = 0; dateIndex < dateColumns; dateIndex++) {
                    var startColIndex = firstDateColIndex + (dateIndex * 7);
                    for (var subColIndex = 0; subColIndex < 7; subColIndex++) {
                        var colIndex = startColIndex + subColIndex;
                        if (colIndex < row.cells.length) {
                            row.cells[colIndex].style.display =
                                (row.cells[colIndex].style.display === "none" ? "" : "none");
                        }
                    }
                }
            }
        }
    }

    $(document).ready(function () {
                let datesRow = document.getElementById("datesRow");
                if (!datesRow) {
                    console.error("Element with id='datesRow' not found!");
                    return;
                }

                const currentDate = new Date();
                let c_year = currentDate.getFullYear();
                let c_month = currentDate.getMonth() + 1;
                let daysInMonth = new Date(c_year, c_month, 0).getDate();

                for (let day = 1; day <= daysInMonth; day++) {
                    let th = document.createElement("th");
                    th.textContent = `${day} / ${c_month} / ${c_year}`;
                    datesRow.appendChild(th);
                }
            });

    </script>
@stop

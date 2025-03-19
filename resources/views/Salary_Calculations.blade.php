<!-- resources/views/salary/index.blade.php -->
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
            <div class="col-2"></div>
            <div class="col-md-2">
                <button type="button" class="btn btn-success btn-block" id="pay-salary-btn" data-toggle="modal" data-target="#confirmPayModal">
                    <i class="fas fa-money-bill-wave"></i> Pay All Employee Salary
                </button>
            </div>
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
        <div class="mb-2">
            <span style="display:inline-block; width:15px; height:15px; background-color:#00FFFF; margin-right:5px;"></span> Weekly Off
            <span style="display:inline-block; width:15px; height:15px; background-color:#FFFF00; margin-right:5px;"></span> Holiday
            <span style="display:inline-block; width:15px; height:15px; background-color:#FFA500; margin-right:5px;"></span> Swap Day
            <span style="display:inline-block; width:15px; height:15px; background-color:#FF0000; margin-right:5px;"></span> Sick Leave
            <span style="display:inline-block; width:15px; height:15px; background-color:#FF00FF; margin-right:5px;"></span> Casual Leave
        </div>

        <div class="table-responsive" id="result">
            <div class="text-center">
                <i class="fas fa-spinner fa-spin fa-3x"></i>
                <p>Loading data...</p>
            </div>
        </div>
        <div id="pagination_div" class="mt-3">
        </div>
    </div>
</div>

<!-- Arrear Form -->
<form  id="Arrear_Form">
    @csrf
    <div class="full_width_div" id="Arrear_Info_div" style="display: none;">
       <div class=" form_inner_div">
          <div class="form_header_div">
             <h3> Add Arrear</h3>
             <p class="cancle_p" onclick="close_Arrear_Info_form()"><i class="fa-regular fa-circle-xmark"></i>
             </p>
          </div>
          <input type="text" name="Employee_Id" id="Employee_Id_inpur_arrear_form" style="padding: 5px 10px ; width:100%;"  hidden>
          <div class="display_flex_center">
             <div>
                <p class="input_lable_p">Arrear Amount*</p>
                <div class="input">
                   <input type="text" placeholder="Arrear Amount " style="border:none" name="Arrear_Amount"  id="Arrear_Amount_input" required oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                </div>
             </div>
             <div style="margin-left:10px ">
                <p class="input_lable_p">Arrear Reason* </p>
                <div class="input">
                   <input type="text" id="Arrear_Reason" placeholder="Arrear Reason" name="Arrear_Reason" style="border: none" required>
                </div>
             </div>
          </div>
          <div class="display_flex_center">
             <div>
                <p class="input_lable_p">Arrear Month*</p>
                <div class="input">
                   <input type="month" id="Arrear_month_year" name="Arrear_month_year" style="border: none" required>
                </div>
             </div>
          </div>
          <div class="display_flex_center_2 " style="margin: 40px;">
             <input type="submit" value="submit" class="input margin_5_20 submit_btn" id="arrear_form_submit_btn" onclick="save_arrear()">
          </div>
       </div>
    </div>
 </form>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmPayModal" tabindex="-1" role="dialog" aria-labelledby="confirmPayModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmPayModalLabel">Confirm Salary Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to pay all employee salaries?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirm-pay-btn">Yes, Pay Salaries</button>
            </div>
        </div>
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

<!-- Arrear Modal -->
<div class="modal fade" id="arrearModal" tabindex="-1" role="dialog" aria-labelledby="arrearModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="arrearModalLabel">Add/Edit Arrear</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="arrearForm">
                    <input type="hidden" id="arrear-employee-id">
                    <div class="form-group">
                        <label for="arrear-amount">Arrear Amount</label>
                        <input type="number" class="form-control" id="arrear-amount" placeholder="Enter arrear amount">
                    </div>
                    <div class="form-group">
                        <label for="arrear-reason">Reason</label>
                        <textarea class="form-control" id="arrear-reason" rows="3" placeholder="Enter reason for arrear"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="save-arrear-btn">Save</button>
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
    }

    /* Custom colors for leave types */
    .bg-weekly-off { background-color: #00FFFF !important; }
    .bg-holiday { background-color: #FFFF00 !important; }
    .bg-swap-day { background-color: #FFA500 !important; }
    .bg-sick-leave { background-color: #FF0000 !important; }
    .bg-casual-leave { background-color: #FF00FF !important; }

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
    <script>
        close_Arrear_Info_form()

            function close_Arrear_Info_form() {
            document.getElementById("Arrear_Info_div").style.display = "none"
            }

            function open_Arrear_Info_form() {
            document.getElementById("Arrear_Info_div").style.display = "flex"
            }

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

        var Working_Day;
        var limit = 50;
        var s_month = new Date().getMonth();
        var s_year = new Date().getFullYear();
        var inp = ""
        var month = "";
        var year = "";

        function getLastDateOfMonth(year, month) {
        // Month is 0-based (0 = January, 11 = December)
        return new Date(year, month + 1, 0).getDate();
        }
        var set_last_date = getLastDateOfMonth(s_year, s_month)
        s_month = s_month + 1
        var start_d = s_year + "-" + s_month + "-01"
        var end_d = s_year + "-" + s_month + "-" + set_last_date
        var page_url;
        arrear_year = s_year
        arrear_month = s_month
        lode_data();

        function lode_data() {

        page_url = "{{url('/salary-calculations-api')}}/" + limit + "/" + s_month + "/" + s_year
        attendance_data_set(page_url)
        }

        const formatDateToYYYYMMDD = (date) => {
            const f_year = date.getFullYear();
            const f_month = String(date.getMonth() + 1).padStart(2, '0');
            const f_day = String(date.getDate()).padStart(2, '0');
            return `${f_year}-${f_month}-${f_day}`;
        };

        function set_month_for_data() {
            const dateInput = document.getElementById("month_input").value;
            const selectedDate = new Date(dateInput);

            // Extract year and month safely
            let s_year = selectedDate.getFullYear();
            let s_month = selectedDate.getMonth() + 1; // Convert to 1-based index
            let set_last_date = getLastDateOfMonth(s_year, s_month);

            let start_d = `${s_year}-${s_month}-01`;
            let end_d = `${s_year}-${s_month}-${set_last_date}`;

            let arrear_year = s_year;
            let arrear_month = s_month;

            let page_url = "{{url('/salary-calculations-api')}}/" + limit + "/" + s_month + "/" + s_year;
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
        inp = $("#search_input").val();
        if (month == "") {
            month = s_month
        }
        if (year == "") {
            year = s_year;
        }
        page_url = "{{url('/salary-calculations-short-search-api')}}/" + limit + "/" + month + "/" + year + "/" + inp
        attendance_data_set(page_url)
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
			var count_flag = 1;
			var all_data = response.data;
			var role_number = $("#role_number").val();
			var Work, Absent, Over_Time, Over_Time_in_INR, Advance, Deduction, Penalty, Monthly_Salary, Net_Salary;
			Work = 0;
			Over_Time = 0;
			Over_Time_in_INR = 0;
			Working_Day = 0;
			var deductions_amount = 0;
			var month_deductions_amount = 0;
			var Penalty = 0;
			var advance = 0;
			var monthaly_salary = 0;
			var net_salary = 0;
			var Day_Total_Amount = 0;
			var Over_Ttime_Rate = 0;
			var Swap_Day_array_data = 0;
			var Public_Holiday_array_data = 0;
			var Daily_Rate = 0;
			var Over_Ttime_Rate = 0;
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
			var all_users_data = response.all_users.data;
			var all_attandance_data = response.attendance_info_data;
			var deductions_data = response.deductions_data;
			var penalty_data = response.penalty_data;
			var advance_data = response.advance_data;
			var public_holiday_data = response.holiday_data;
			var leave_data = response.leave_data;
			var table_html_data =
				`
<div class="card">
   <div class="card-body">
      <table id="salary_table" class="table table-bordered table-hover display nowrap" style="width:100%">
         <thead>
            <tr>
               <th style="width:2%">Sr. N.</th>
               <th style="width:2%">Name</th>
               <th style="width:2%">Employee Id</th>
               <th style="width:2%">Shift hrs</th>
               `;
			const startDate = new Date(start_d);
			const endDate = new Date(end_d);
			const dates = [];
			var c_data = response.calendar_data;
			c_data.forEach(c_data => {
				dates.push(new Date(c_data.date));
				Working_Day++;
			});
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
				table_html_data += `
               <th class="date_p" colspan="7" style="width:2%">${formattedDate}</th>
               `;
			});
			table_html_data += `
               <th style="width:2%">Total Day</th>
               <th style="width:2%">Working Day</th>
               <th style="width:2%">work (in day)</th>
               <th style="width:2%">Absent</th>
               <th style="width:2%">Over Time</th>
               <th style="width:2%">Over Time Rate</th>
               <th style="width:2%">Over Time (in INR)</th>
               <th style="width:2%">Loan / Advance(in INR)</th>
               <th style="width:2%">Deduction</th>
               <th style="width:2%">Arrear</th>
               <th style="width:2%">Arrear Reason</th>
               <th style="width:2%">Daily_Rate</th>
               <th style="width:2%">Monthly Salary</th>
               <th style="width:2%">Net Salary</th>
               <th style="width:2%">Paid Amount</th>
               <th style="width:2%">Action</th>
            </tr>
         </thead>
         <tbody>
            `;
			all_users_data.forEach(all_users_data => {
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
				dates.forEach(date => {
					const formattedDate = date.toLocaleDateString("en-US", {
						day: "2-digit",
						month: "long",
						year: "numeric"
					});
					month_year = date.toLocaleDateString("en-US", {
						month: "2-digit",
						year: "numeric"
					});
					const filteredData = all_attandance_data.filter(all_att_data =>
						all_att_data.Employee_id === all_users_data.Employee_id &&
						formatDateToYYYYMMDD(date) === all_att_data.attandence_Date
					);
					const public_holiday_filyer_data = public_holiday_data.filter(public_holiday_data =>
						formatDateToYYYYMMDD(date) === public_holiday_data.holiday_Date
					);
					const leave_filter_data = leave_data.filter(leave_d =>
						leave_d.Employee_id === all_users_data.Employee_id && leave_d.Start_Date <=
						formatDateToYYYYMMDD(date) && leave_d.End_Date >= formatDateToYYYYMMDD(date)
					);
					if (leave_filter_data.length > 0) {
						leave_filter_data.forEach(leave_filter_data => {
							leave_color = leave_filter_data.Color;
							Half_Day_Leave = leave_filter_data.Half_Day;
							Payment_Status_Leave = leave_filter_data.Payment_Status;
							Short_Name_Leave = leave_filter_data.Short_Name;
						});
					}
					Payment_Status = "";
					OT_Amt = 0;
					Daily_Amt = 0;
					public_holiday_filyer_data.forEach(pub_ho => {
						if (pub_ho.holiday_Date === formatDateToYYYYMMDD(date)) {
							Public_Holiday_array_data = 1;
						} else {
							Public_Holiday_array_data = 0;
						}
					});
					filteredData.forEach(element => {
						Swap_Day_array_data = element.Swap_Day;
						Daily_Rate = element.Daily_Rate;
						Over_Ttime_Rate = element.Over_Ttime_Rate;
						Weekly_Off_array_data = element.WeeklyOff;
					});
					let cellBackgroundColor = '';
					if (Swap_Day_array_data == 1) {
						cellBackgroundColor = 'style="background-color:orange"';
					} else if (public_holiday_filyer_data.length == 1) {
						cellBackgroundColor = 'style="background-color:yellow"';
						Daily_Amt = Employee_Daily_Rate;
					} else if (Weekly_Off_array_data == 1) {
						cellBackgroundColor = 'style="background-color:cyan"';
						Daily_Amt = Employee_Daily_Rate;
					} else if (all_users_data.Weekly_Off == date.toLocaleDateString('en-US', {
							weekday: 'long'
						})) {
						cellBackgroundColor = 'style="background-color:cyan"';
						Daily_Amt = Employee_Daily_Rate;
					} else if (public_holiday_filyer_data.holiday_Date == formatDateToYYYYMMDD(date)) {
						cellBackgroundColor = 'style="background-color:yellow"';
						Daily_Amt = Employee_Daily_Rate;
					} else if (leave_filter_data.length > 0) {
						Payment_Status = leave_filter_data[0].Payment_Status;
						cellBackgroundColor = 'style="background-color:' + leave_color + '"';
						if (Half_Day_Leave == 1) {
							cellBackgroundColor = 'style="background: linear-gradient(to right, ' + leave_color +
								'50%, transparent 50%);"';
							leave_holiday_weakly_off_count += 0.5;
							if (Half_Day_Leave == 1 && Payment_Status == "Paid") {
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
					if (filteredData.length === 0) {
						table_html_data += `
               <td class="in_time_p" ${cellBackgroundColor}></td>
               <td class="out_time_p" ${cellBackgroundColor}></td>
               <td class="total_hr_p" ${cellBackgroundColor}></td>
               <td class="total_min_p" ${cellBackgroundColor}></td>
               <td class="total_min_p ot" ${cellBackgroundColor}></td>
               <td class="total_min_p ot" ${cellBackgroundColor}></td>
               <td class="total_min_p ot" ${cellBackgroundColor}>${Daily_Amt.toFixed(2)}</td>`;
					} else {
						filteredData.forEach(all_att_data => {
							if (Half_Day_Leave == 1 && all_att_data.Totel_Hours >= all_att_data.Shift_hours / 2) {
								Daily_Amt += all_att_data.Daily_Rate / 2;
							} else if (all_att_data.Totel_Hours >= all_att_data.Shift_hours) {
								Daily_Amt += all_att_data.Daily_Rate;
							} else {
								Daily_Amt += all_att_data.Daily_Rate;
							}
							OT_Amt = all_att_data.Overtime * all_att_data.Over_Ttime_Rate;
							Total_OT_Amount = Total_OT_Amount + OT_Amt;
							table_html_data += `
               <td class="in_time_p" ${cellBackgroundColor}>${all_att_data.in_time}</td>
               <td class="out_time_p" ${cellBackgroundColor}>${all_att_data.out_time}</td>
               <td class="total_hr_p" ${cellBackgroundColor}>${all_att_data.Total_Time}</td>
               <td class="total_min_p" ${cellBackgroundColor}>${all_att_data.Total_Minutes}</td>
               <td class="total_min_p ot" ${cellBackgroundColor}>${all_att_data.Overtime}</td>
               <td class="total_min_p ot" ${cellBackgroundColor}>${OT_Amt.toFixed(2)}</td>
               <td class="total_min_p ot" ${cellBackgroundColor}>${Daily_Amt.toFixed(2)}</td>`;
							pop_up_total_hr += all_att_data.Totel_Hours;
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
				const absent_data = 0;
				var Absent_count = Working_Day - response.holiday_count - Work;
				if (Absent_count <= 0) {
					Absent_count = 0;
				}
				Total_Amount = Total_all_day_Amount + Total_OT_Amount;
				table_html_data += `
               <td>${Working_Day}</td>
               <td>${Working_Day - response.holiday_count}</td>
               <td>${Work}</td>
               <td>${Absent_count}</td>
               <td>${Over_Time}</td>
               <td>${Over_Ttime_Rate.toFixed(2)}</td>
               <td>${Math.round(Total_OT_Amount)}</td>
               `;
				table_html_data += `
               <td id="advance${all_users_data.Employee_id}">`;
				if (advance_data != "") {
					advance_data.forEach(advance_data => {
						if (advance_data.Employee_id == all_users_data.Employee_id) {
							advance = parseInt(advance) + parseInt(advance_data.Loan_Amount_in_INR);
						}
					});
				}
				table_html_data += `${advance}
               </td>
               `;
				table_html_data += `
               <td id="deductions_amount${all_users_data.Employee_id}">`;
				if (deductions_data != null) {
					deductions_data.forEach(deductions => {
						if (deductions.Employee_id === all_users_data.Employee_id) {
							deductions_amount += parseInt(deductions.deduction_Amount_in_INR);
						}
					});
				}
				table_html_data += `${deductions_amount}
               </td>
               `;
				table_html_data += `
               <td id="arrear_amount_td${all_users_data.Employee_id}">${all_users_data.Arrear_Amount ?? 0}</td>
               <td id="arrear_reason_td${all_users_data.Employee_id}">${all_users_data.Arrear_Reasons ?? " "}</td>
               `;
				table_html_data += `
               <td>${Daily_Rate.toFixed(2)}</td>
               <td id="monthly_salary${all_users_data.Employee_id}">`;
				monthaly_salary = Total_Amount + (leave_holiday_weakly_off_count * all_users_data.salary / 30);
				table_html_data += `${Math.round(monthaly_salary)}
               </td>
               `;
				var arrer_amo = all_users_data.Arrear_Amount ?? 0;
				table_html_data += `
               <td id="net_salary${all_users_data.Employee_id}">`;
				net_salary = monthaly_salary - Penalty - deductions_amount + arrer_amo;
				table_html_data += `${Math.round(net_salary)}
               </td>
               `;
				var paid_amt = 0;
				if (all_users_data.Paid_Amount == null || all_users_data.Paid_Amount == 0 || all_users_data.Paid_Amount == '') {
					paid_amt = Math.round(net_salary);
				} else {
					paid_amt = all_users_data.Paid_Amount;
				}
				table_html_data += `
               <td><input type="text" value="${paid_amt}" style="border:none;width:100%" id="paid_amount_td${all_users_data.Employee_id}"></td>
               <td hidden><input type="text" value="${Math.round(net_salary)}" style="border:none" id="net_amount_td${all_users_data.Employee_id}" hidden></td>
               <td hidden><input type="text" value="${Total_OT_Amount}" style="border:none" id="OT_amt${all_users_data.Employee_id}" hidden></td>
               <td hidden><input type="text" value="${Over_Time / 60}" style="border:none" id="OT_hrs${all_users_data.Employee_id}" hidden></td>
               <td id="${all_users_data.Employee_id}" onclick="salary_paid_function(${all_users_data.Employee_id})">`;
				if (all_users_data.Paid_Flag == 1) {
					table_html_data += `
                  <button class="btn btn-success btn-sm" disabled id="payButton${all_users_data.Employee_id}">
                  <i class="fas fa-check-circle"></i> PAID
                  </button>`;
				} else {
					table_html_data += `
                  <button class="btn btn-primary btn-sm" id="payButton${all_users_data.Employee_id}" onclick="paySalary(${all_users_data.Employee_id})">
                  <i class="fa-solid fa-indian-rupee-sign"></i> Pay Salary
                  </button>`;
				}
				table_html_data += `
               </td>
            </tr>
            `;
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
				otm = 0;
				Total_OT_Amount = 0;
				Total_Amount = 0;
				Total_all_day_Amount = 0;
			});
			table_html_data += `
         </tbody>
      </table>
   </div>
</div>
`;
			$("#result").html(table_html_data);
			hide_animation();
			// Pagination
			var pajination_data = response.all_users.links;
			var pagination_html = `
<nav aria-label="Page navigation">
   <ul class="pagination">
      `;
			pajination_data.forEach(element => {
				if (element.url === null) {
					pagination_html += `
      <li class="page-item disabled">
         <a class="page-link">${element.label}</a>
      </li>
      `;
				} else {
					pagination_html += `
      <li class="page-item ${element.active ? 'active' : ''}">
         <a class="page-link" href="${element.url}">${element.label}</a>
      </li>
      `;
				}
			});
			pagination_html += `
   </ul>
</nav>
<div class="d-flex justify-content-end">
   <p><b>Page Size :</b> ${response.all_users.per_page}</p>
   <p><b>Total Records :</b> ${response.all_users.total}</p>
</div>
`;
			$("#pagination_div").html(pagination_html);
			// Enhanced DataTables initialization with full features
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
				"responsive": true,
				"dom": 'Bfrtip',
				"buttons": [
					'copy', 'csv', 'excel', 'pdf', 'print'
				],
				"columnDefs": [{
						"className": "dt-center",
						"targets": "_all"
					},
					{
						"width": "2%",
						"targets": "_all"
					},
					{
						"orderable": false,
						"targets": [3, 4, 5, 6, 7, 8, 9, 10, 11, 12, -1]
					},
					{
						"searchable": false,
						"targets": [3, 4, 5, 6, 7, 8, 9, 10, 11, 12, -1]
					}
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
				"fixedHeader": true
			});
		},
		error: function(xhr, status, error) {
			console.error("Error:", error);
			hide_animation();
			$("#result").html(`
<div class="alert alert-danger">Error loading data: ${error}</div>
`);
		}
	});
}
setInterval(() => {
	hide_animation();
}, 1000);

        function validateNumber(cell, Employee_id) {
        const value = cell.innerText;
        if (!/^[\d+-]*$/.test(value)) { // Allow digits, +, and -
            cell.innerText = value.replace(/[^0-9+-]/g, ''); // Remove all characters except digits, +, and -
            alert('y');
        }
        }

        function open_arrear_pop_up(employee_id) {
        var paid_button_text = $("#payButton" + employee_id).text()
        console.log(paid_button_text.trim());
        if (paid_button_text.trim() == "PAID") {
            return
        }
        open_Arrear_Info_form(employee_id)
        var arrear_amount_td = $("#arrear_amount_td" + employee_id).text()
        var arrear_reason_td = $("#arrear_reason_td" + employee_id).text()
        arrear_year = "2025";
        arrear_month = arrear_month < 10 ? "0" + arrear_month : arrear_month;
        $("#Employee_Id_inpur_arrear_form").val(employee_id)
        $("#Arrear_Amount_input").val(arrear_amount_td)
        $("#Arrear_Reason").val(arrear_reason_td)
        $("#Arrear_month_year").val(arrear_year + "-" + arrear_month);
        }
        $(document).on('click', '#saveTableData', function () {

        var arrear_month = 0;
        var input_month = $('#month_input').val();
        if (input_month != "") {
            arrear_month = input_month;
        }
        $.ajax({
            url: '{{url("/luck-one-clic-arrear-data")}}/' + arrear_month, // Laravel URL helper
            type: 'GET', // or 'POST' if required
            success: function (response) {
            alert(response.message);
            set_month_for_data();
            },
            error: function (xhr, status, error) {

            alert(error);
            }
        });
        });

        function show_animation() {
        }

        function hide_animation() {
        }

        function salary_paid_function(employee_id) {
        show_animation();
        var arrear_month = 0;
        var input_month = $('#month_input').val();
        if (input_month != "") {
            arrear_month = input_month;
        }
        var paid_amount = $('#paid_amount_td' + employee_id).val();
        var net_amount = $('#net_amount_td' + employee_id).val();
        var OT_amt = $('#OT_amt' + employee_id).val();
        var OT_hrs = $('#OT_hrs' + employee_id).val();

        $.ajax({
            url: '{{url("/luck-arrear-data")}}/' + employee_id + "/" + arrear_month + "/" + paid_amount + "/" +
            net_amount + "/" + OT_amt + "/" + OT_hrs, // Laravel URL helper
            type: 'GET', // or 'POST' if required
            success: function (response) {
            alert(response.message);
            hide_animation()
            },
            error: function (xhr, status, error) {

            alert(error);
            hide_animation()
            }
        });
        }

        function toggleMonths() {
        // Get the table
        var table = document.getElementById("salary_table");

        // Loop through each row
        for (var i = 0; i < table.rows.length; i++) {
            var row = table.rows[i];

            // Hide or show columns 3 to 6 (indices 2 to 5)
            for (var j = 0; j < Working_Day; j++) {
            if (i == 0) {
                var cell = row.cells[j + 4];
                cell.style.display = (cell.style.display === "none" ? "" : "none");
            } else {

                for (let index = 0; index < 7; index++) {
                var cell = row.cells[(j * 7) + 4 + index];

                console.log((j * 7) + 4)
                cell.style.display = (cell.style.display === "none" ? "" : "none");

                }
            }

            }
        }
        }

        function paySalary(Employee_id) {
        // Change the button text to "PAID"
        const button = document.getElementById("payButton" + Employee_id);
        button.innerHTML = '<i class="fas fa-check-circle"></i> PAID'; // Add a check icon and change text

        // Disable the button
        button.disabled = true;

        // Optionally, you can also change the tooltip or hide it
        const tooltip = button.querySelector('.tooltip');
        tooltip.style.visibility = 'hidden';
        }

        const currentDate = new Date();

        // Get current date
        let c_year = currentDate.getFullYear();
        let c_month = currentDate.getMonth() + 1; // Convert to 1-indexed (January = 1)

        // Get the number of days in the current month
        let daysInMonth = new Date(c_year, c_month, 0).getDate();

        // Select the table row where dates will be inserted
        let datesRow = document.getElementById("datesRow");

        // Generate the dates and add them as <th> elements
        for (let day = 1; day <= daysInMonth; day++) {
            let th = document.createElement("th");
            th.textContent = `${day} / ${c_month} / ${c_year}`;
            datesRow.appendChild(th);
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
        function open_pershon_details(emp_id) {
        var paid_amoutn_for_pup_up = $('#paid_amount_td' + emp_id).val()
        var hed_tr_data = $("#header_cont_" + emp_id).val();
        var one_user_monthly_in_out_data_var = $("#one_user_monthly_in_out" + emp_id).val();
        var table_heading = $("#heading" + emp_id).html();
        $("#heade_table_tr_data").html(hed_tr_data);
        $("#in_out_single_user_tr").html(one_user_monthly_in_out_data_var);
        $("#table_heading_h2").html(table_heading);
        modal.style.display = "block";
        document.getElementById("paid_amoutn_for_pup_up_span").innerHTML = paid_amoutn_for_pup_up;
        }
    </script>
@stop

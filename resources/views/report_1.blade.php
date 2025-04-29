@extends('adminlte::page')

@section('title', 'Monthly Attendance & Salary Report')

@section('content_header')
    <h1>Monthly Attendance & Salary Report</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header sticky-top bg-white">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <h3 class="card-title">Salary Report</h3>
            <div class="form-group mb-0">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Select Month</span>
                    </div>
                    <input type="month" id="month_input" class="form-control" onchange="set_month_for_data()">
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-5">
                <div class="input-group">
                    <input type="search" name="search_val" id="search_input" class="form-control" placeholder="Search Employee by Name, ID, etc." onkeyup="serch_on_key_presh()">
                    <div class="input-group-append">
                        <button type="button" id="search_btn" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group mb-0">
                    <select id="view_mode" class="form-control" onchange="toggleCompactView()">
                        <option value="normal">Normal View</option>
                        <option value="compact">Compact View</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="btn-group float-right">
                    <button type="button" class="btn btn-success" onclick="exportTableToExcel()">
                        <i class="fas fa-file-excel mr-1"></i> Excel
                    </button>
                    <button type="button" class="btn btn-danger" onclick="exportTableToPDF()">
                        <i class="fas fa-file-pdf mr-1"></i> PDF
                    </button>
                    <button type="button" class="btn btn-primary" onclick="printTable()">
                        <i class="fas fa-print mr-1"></i> Print
                    </button>
                </div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-12">
                <div class="legend-container d-flex flex-wrap">
                    <div class="legend-item mr-3">
                        <span class="legend-color" style="background-color: cyan;"></span>
                        <span>Weekly Off</span>
                    </div>
                    <div class="legend-item mr-3">
                        <span class="legend-color" style="background-color: yellow;"></span>
                        <span>Holiday</span>
                    </div>
                    <div class="legend-item mr-3">
                        <span class="legend-color" style="background-color: orange;"></span>
                        <span>Swap Day</span>
                    </div>
                    @isset($leave_type_master_data)
                        @foreach ($leave_type_master_data as $leave_master_d)
                            <div class="legend-item mr-3">
                                <span class="legend-color" style="background-color: {{$leave_master_d->Color}};"></span>
                                <span>{{$leave_master_d->Name}}</span>
                            </div>
                        @endforeach
                    @endisset
                </div>
            </div>
        </div>

        <div class="table-responsive-container">
            <div id="result" class="table-responsive">
                <!-- Table will be loaded here via AJAX -->
                <div class="d-flex justify-content-center p-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <button type="button" id="saveTableData" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Save Data
                </button>
            </div>
            <div class="col-md-6">
                <div id="pagination_div" class="float-right"></div>
            </div>
        </div>
    </div>
</div>

<!-- Floating action button for mobile -->
<div class="floating-action-buttons d-md-none">
    <button class="btn btn-primary rounded-circle shadow" id="mobileActionsToggle">
        <i class="fas fa-ellipsis-v"></i>
    </button>
    <div class="floating-actions-menu">
        <button class="btn btn-success btn-sm mb-2" onclick="exportTableToExcel()">
            <i class="fas fa-file-excel"></i>
        </button>
        <button class="btn btn-danger btn-sm mb-2" onclick="exportTableToPDF()">
            <i class="fas fa-file-pdf"></i>
        </button>
        <button class="btn btn-primary btn-sm" onclick="printTable()">
            <i class="fas fa-print"></i>
        </button>
    </div>
</div>
@stop

@section('css')
<!-- Custom CSS -->
<style>
    /* General styles */
    .legend-container {
        margin-bottom: 10px;
    }
    .legend-item {
        display: flex;
        align-items: center;
        margin-right: 15px;
        margin-bottom: 5px;
    }
    .legend-color {
        display: inline-block;
        width: 16px;
        height: 16px;
        margin-right: 5px;
        border: 1px solid #ddd;
    }

    /* Table styling */
    .table-responsive-container {
        position: relative;
        height: calc(100vh - 300px);
        min-height: 400px;
        border: 1px solid #dee2e6;
        margin-bottom: 1rem;
    }

    .table-responsive {
        height: 100%;
        overflow: auto;
    }

    /* Frozen headers and first columns */
    .sticky-table {
        position: relative;
        border-collapse: separate;
        border-spacing: 0;
    }

    .sticky-table thead th {
        position: sticky;
        top: 0;
        z-index: 2;
        background-color: #f4f6f9;
        border-bottom: 2px solid #dee2e6;
    }

    .sticky-table th.sticky-col,
    .sticky-table td.sticky-col {
        position: sticky;
        left: 0;
        z-index: 1;
        background-color: #fff;
    }

    .sticky-table th.sticky-col-2,
    .sticky-table td.sticky-col-2 {
        position: sticky;
        left: 60px;
        z-index: 1;
        background-color: #fff;
    }

    .sticky-table th.sticky-col-3,
    .sticky-table td.sticky-col-3 {
        position: sticky;
        left: 200px;
        z-index: 1;
        background-color: #fff;
    }

    .sticky-table th.sticky-col-4,
    .sticky-table td.sticky-col-4 {
        position: sticky;
        left: 260px;
        z-index: 1;
        background-color: #fff;
    }

    .sticky-table thead th.sticky-col,
    .sticky-table thead th.sticky-col-2,
    .sticky-table thead th.sticky-col-3,
    .sticky-table thead th.sticky-col-4 {
        z-index: 3;
        background-color: #f4f6f9;
    }

    /* Cell styling */
    .sticky-table th,
    .sticky-table td {
        padding: 8px;
        vertical-align: middle !important;
        white-space: nowrap;
        border: 1px solid #dee2e6;
    }

    /* Date header cells */
    .date-header {
        min-width: 80px;
        text-align: center;
        font-size: 0.8rem;
    }

    /* Status indicators */
    .status-cell {
        text-align: center;
        font-size: 0.85rem;
    }

    /* Pagination */
    .pagination {
        margin-bottom: 0;
    }
    .page-btn {
        cursor: pointer;
        padding: 5px 10px;
        border: 1px solid #ddd;
        margin: 0 2px;
        border-radius: 3px;
    }
    .page-btn.active {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }

    /* Compact view */
    .compact-view th,
    .compact-view td {
        padding: 4px 6px;
        font-size: 0.8rem;
    }

    .compact-view .date-header {
        min-width: 60px;
    }

    /* Mobile floating action buttons */
    .floating-action-buttons {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
    }

    .floating-actions-menu {
        display: none;
        flex-direction: column;
        position: absolute;
        bottom: 60px;
        right: 0;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-header {
            flex-direction: column;
        }

        .form-group {
            width: 100%;
            margin-top: 10px;
        }

        .btn-group {
            margin-top: 10px;
            width: 100%;
            display: flex;
            justify-content: space-between;
        }

        .btn-group .btn {
            flex: 1;
            margin: 0 2px;
        }
    }

    /* Make the border of sticky cells more visible when scrolling */
    .sticky-col, .sticky-col-2, .sticky-col-3, .sticky-col-4 {
        box-shadow: 2px 0px 3px rgba(0,0,0,0.1);
    }
</style>
@stop

@section('js')
<script>
    // Default values
    var limit = 50;
    var s_month = new Date().getMonth();
    var s_year = new Date().getFullYear();
    var inp = "";
    var month = "";
    var year = "";

    // Helper functions
    function getLastDateOfMonth(year, month) {
        return new Date(year, month + 1, 0).getDate();
    }

    var set_last_date = getLastDateOfMonth(s_year, s_month);
    s_month = s_month + 1;
    var start_d = s_year + "-" + (s_month < 10 ? '0' + s_month : s_month) + "-01";
    var end_d = s_year + "-" + (s_month < 10 ? '0' + s_month : s_month) + "-" + set_last_date;

    var page_url;

    // Load data on page load
    $(document).ready(function() {
        // Set current month in the month input
        document.getElementById("month_input").value = s_year + "-" + (s_month < 10 ? '0' + s_month : s_month);

        lode_data();

        // Event handlers
        $('#search_btn').on("click", function(event) {
            event.preventDefault();
            serch_on_key_presh();
        });

        $('#pagination_div').on('click', '.page-btn', function() {
            var page = $(this).data('page');
            attendance_data_set(page);
        });

        // Mobile floating action button
        $('#mobileActionsToggle').on('click', function() {
            $('.floating-actions-menu').toggle();
        });

        // Close floating menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.floating-action-buttons').length) {
                $('.floating-actions-menu').hide();
            }
        });
    });

    function toggleCompactView() {
        const viewMode = $('#view_mode').val();
        if (viewMode === 'compact') {
            $('#id_of_table').addClass('compact-view');
        } else {
            $('#id_of_table').removeClass('compact-view');
        }
    }

    function lode_data() {
        page_url = "{{url('/salary-calculations-api')}}/" + limit + "/" + s_month + "/" + s_year;
        attendance_data_set(page_url);
    }

    const formatDateToYYYYMMDD = (date) => {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    };

    function set_month_for_data() {
        const dateInput = document.getElementById("month_input").value;
        const selectedDate = new Date(dateInput);
        const year = selectedDate.getFullYear();
        const month = selectedDate.getMonth() + 1;

        set_last_date = getLastDateOfMonth(year, month - 1);
        start_d = year + "-" + (month < 10 ? '0' + month : month) + "-01";
        end_d = year + "-" + (month < 10 ? '0' + month : month) + "-" + set_last_date;

        page_url = "{{url('/salary-calculations-api')}}/" + limit + "/" + month + "/" + year;
        attendance_data_set(page_url);
    }

    function set_limit() {
        limit = $("#limit_inputt").val();

        if (month == "") {
            month = s_month;
        }
        if (year == "") {
            year = s_year;
        }

        if (inp == "") {
            page_url = "{{url('/salary-calculations-api')}}/" + limit + "/" + month + "/" + year;
        } else {
            page_url = "{{url('/salary-calculations-short-search-api')}}/" + limit + "/" + month + "/" + year + "/" + inp;
        }

        attendance_data_set(page_url);
    }

    function serch_on_key_presh() {
        inp = $("#search_input").val();

        if (month == "") {
            month = s_month;
        }
        if (year == "") {
            year = s_year;
        }

        page_url = "{{url('/salary-calculations-short-search-api')}}/" + limit + "/" + month + "/" + year + "/" + inp;
        attendance_data_set(page_url);
    }

    function attendance_data_set(url_input) {
    // Show loading spinner
    $("#result").html('<div class="d-flex justify-content-center p-5"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>');

    $.ajax({
        url: url_input,
        type: "GET",
        dataType: "json",
        headers: {
            "Content-Type": "application/json"
        },
        success: function(response) {
            $("#result").empty();
            var count_flag = 1;
            var all_data = response.data;
            var role_number = $("#role_number").val();
            var data_count = 1;

            // Variables for calculations
            var Working_Day, Work, Absent, Over_Time, Over_Time_in_INR, Advance, Deduction, Penalty, Monthly_Salary, Net_Salary;
            Work = 0;
            Over_Time = 0;
            Over_Time_in_INR = 0;
            Working_Day = set_last_date;
            var deductions_amount = 0;
            var Penalty = 0;
            var advance = 0;
            var monthaly_salary = 0;
            var net_salary = 0;
            var Day_Total_Amount = 0;
            var Over_Ttime_Rate = 0;
            var Swap_Day_array_data = 0;
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
            var final_amount_before_arrear = 0; // New variable for final amount before arrear

            // Safely get data from response, providing empty arrays as fallbacks
            var all_users_data = response.all_users?.data || [];
            var all_attandance_data = response.attendance_info_data || [];
            var deductions_data = response.deductions || [];
            var penalty_data = response.penalty_data || [];
            var advance_data = response.advance_data || [];
            var public_holiday_data = response.holiday_data || []; // Holiday master data
            var holiday_swap_data = response.holiday_swap_data || [];  // CHANGED: Use separate variable for swap dates
            var leave_data = response.leave_data || [];
            var holiday_count = response.holiday_count || 0;

            // Build table HTML with sticky columns
            var table_html_data = `
            <table id="id_of_table" class="table table-bordered table-striped table-hover sticky-table">
                <thead>
                    <tr>
                        <th class="sticky-col">Sr. N.</th>
                        <th class="sticky-col-2">Name <i class="fas fa-sort" onclick="short_data('f_name')" id="f_name_span"></i></th>
                        <th class="sticky-col-3">Employee Id <i class="fas fa-sort" onclick="short_data('Employee_id')" id="Employee_id_span"></i></th>
                        <th class="sticky-col-4">Shift hrs <i class="fas fa-sort" onclick="short_data('Shift_hours')" id="Shift_hours_span"></i></th>`;

            const startDate = new Date(start_d);
            const endDate = new Date(end_d);
            const dates = [];
            let currentDate = new Date(startDate);

            while (currentDate <= endDate) {
                dates.push(new Date(currentDate));
                currentDate.setDate(currentDate.getDate() + 1);
            }

            dates.forEach(date => {
                const formattedDate = date.toLocaleDateString("en-US", {
                    day: "2-digit",
                    month: "short"
                });
                table_html_data += `<th class="date-header">${formattedDate}</th>`;
            });

            table_html_data += `
                        <th>Total Day</th>
                        <th>Working Day</th>
                        <th>Work (in day)</th>
                        <th>Absent</th>
                        <th>Over Time</th>
                        <th>Over Time Rate</th>
                        <th>Over Time (in INR)</th>
                        <th>Loan / Advance(in INR)</th>
                        <th>Deduction</th>
                        <th>Penalty</th>
                        <th>Final Amount Before Arrear</th>
                        <th>Arrear</th>
                        <th>Arrear Reason</th>
                        <th>Daily Rate</th>
                        <th>Monthly Salary</th>
                        <th>Net Salary</th>
                    </tr>
                </thead>
                <tbody>`;

            // Process user data
            all_users_data.forEach(all_users_data => {
                table_html_data += `
                <tr>
                    <td class="sticky-col">${data_count}</td>
                    <td class="sticky-col-2">${all_users_data.f_name} ${all_users_data.m_name || ''} ${all_users_data.l_name || ''}</td>
                    <td class="sticky-col-3">${all_users_data.Employee_id}</td>
                    <td class="sticky-col-4">${all_users_data.Shift_hours}</td>`;

                var Employee_Daily_Rate = all_users_data.salary / set_last_date;
                data_count++;

                // Process attendance for each date
                dates.forEach(date => {
                    const formattedDate = formatDateToYYYYMMDD(date);

                    // Use safe filter operations with null checks
                    const filteredData = all_attandance_data.filter(all_att_data =>
                        all_att_data.Employee_id === all_users_data.Employee_id &&
                        formattedDate === all_att_data.attandence_Date
                    );

                    // Use safe filter with null check for public holidays
                    const public_holiday_filter_data = public_holiday_data.filter(holiday =>
                        formattedDate === holiday.holiday_Date
                    );

                    // Use safe filter with null check for swap dates
                    const swap_date_filter_data = holiday_swap_data.filter(swap_data =>
                        swap_data.Employee_id === all_users_data.Employee_id &&
                        formattedDate === swap_data.Swap_Date
                    );

                    // Use safe filter with null check for leave data
                    const leave_filter_data = leave_data.filter(leave_d =>
                        leave_d.Employee_id === all_users_data.Employee_id &&
                        leave_d.Start_Date <= formattedDate &&
                        leave_d.End_Date >= formattedDate
                    );

                    if (leave_filter_data.length > 0) {
                        leave_filter_data.forEach(leave_data_item => {
                            leave_color = leave_data_item.Color || "";
                            Half_Day_Leave = leave_data_item.Half_Day || 0;
                            Payment_Status = leave_data_item.Payment_Status || "";
                            Short_Name = leave_data_item.Short_Name || "";
                        });
                    } else {
                        // Reset leave variables when no leave found
                        leave_color = "";
                        Half_Day_Leave = 0;
                        Payment_Status = "";
                        Short_Name = "";
                    }

                    OT_Amt = 0;
                    Daily_Amt = 0;

                    // Reset swap day flag for each date
                    Swap_Day_array_data = 0;
                    Public_Holiday_array_data = 0;
                    Weekly_Off_array_data = 0;

                    filteredData.forEach(element => {
                        Swap_Day_array_data = element.Swap_Day || 0;
                        Public_Holiday_array_data = element.Public_Holiday || 0;
                        Daily_Rate = element.Daily_Rate || 0;
                        Over_Ttime_Rate = element.Over_Ttime_Rate || 0;
                        Weekly_Off_array_data = element.WeeklyOff || 0;
                    });

                    // Determine cell background color
                    let cellBackgroundColor = '';
                    let cellStatusText = 'Absent';
                    let statusClass = '';

                    // FIXED: Check for swap date first (highest priority)
                    if (swap_date_filter_data.length > 0) {
                        cellBackgroundColor = 'style="background-color: orange;"';
                        statusClass = 'swap-day';
                        cellStatusText = 'Present'; // Usually swap days are marked as present
                    } else if (Swap_Day_array_data == 1) {
                        // If marked as swap day in attendance data
                        cellBackgroundColor = 'style="background-color: orange;"';
                        statusClass = 'swap-day';
                        cellStatusText = 'Present';
                    } else if (Public_Holiday_array_data == 1) {
                        cellBackgroundColor = 'style="background-color: yellow;"';
                        statusClass = 'holiday';
                        cellStatusText = 'Absent';
                    } else if (Weekly_Off_array_data == 1) {
                        cellBackgroundColor = 'style="background-color: cyan;"';
                        statusClass = 'weekly-off';
                        cellStatusText = 'Absent';
                    } else if (all_users_data.Weekly_Off == date.toLocaleDateString('en-US', { weekday: 'long' })) {
                        cellBackgroundColor = 'style="background-color: cyan;"';
                        statusClass = 'weekly-off';
                        cellStatusText = 'Absent';
                    } else if (public_holiday_filter_data.length > 0) {
                        cellBackgroundColor = 'style="background-color: yellow;"';
                        statusClass = 'holiday';
                        cellStatusText = 'Absent';
                    } else if (leave_filter_data.length > 0) {
                        if (Half_Day_Leave == 1) {
                            cellBackgroundColor = `style="background: linear-gradient(to right, ${leave_color} 50%, transparent 50%);"`;
                            statusClass = 'half-day-leave';
                            cellStatusText = 'Absent';
                        } else {
                            cellBackgroundColor = `style="background-color: ${leave_color};"`;
                            statusClass = 'leave';
                            cellStatusText = 'Absent';
                        }
                    }

                    // If no attendance record and not a special day, show as absent
                    if (filteredData.length === 0) {
                        // For swap days, still show as Present
                        if (swap_date_filter_data.length > 0) {
                            table_html_data += `<td class="status-cell swap-day" style="background-color: orange;">Present</td>`;
                            Work++; // Count as worked day
                        } else {
                            table_html_data += `<td class="status-cell ${statusClass}" ${cellBackgroundColor}>${cellStatusText}</td>`;
                        }

                        if (Half_Day_Leave == 0 && Payment_Status == "Paid") {
                            Daily_Amt = Employee_Daily_Rate;
                        }
                    } else {
                        filteredData.forEach(all_att_data => {
                            if (Half_Day_Leave == 1 && Payment_Status == "Paid") {
                                Daily_Amt = all_att_data.Daily_Rate / 2;
                            } else {
                                Daily_Amt = all_att_data.Daily_Rate;
                            }

                            OT_Amt = all_att_data.Overtime * all_att_data.Over_Ttime_Rate;
                            Total_OT_Amount = Total_OT_Amount + OT_Amt;

                            table_html_data += `<td class="status-cell ${statusClass}" ${cellBackgroundColor}>Present</td>`;
                            Work++;
                            Over_Time += all_att_data.Overtime;
                        });
                    }

                    Total_all_day_Amount = Total_all_day_Amount + Daily_Amt;
                });

                // Calculate summaries
                var Absent_count = Working_Day - holiday_count - Work;
                if (Absent_count <= 0) {
                    Absent_count = 0;
                }

                Total_Amount = Total_all_day_Amount + Total_OT_Amount;

                // Add summary columns
                table_html_data += `
                    <td>${Working_Day}</td>
                    <td>${Working_Day - holiday_count}</td>
                    <td>${Work}</td>
                    <td>${Absent_count}</td>
                    <td>${Over_Time}</td>
                    <td>${Over_Ttime_Rate.toFixed(2)}</td>
                    <td>${Total_OT_Amount.toFixed(2)}</td>`;

                // Process advance/loan
                table_html_data += `<td>`;
                if (advance_data.length > 0) {
                    advance_data.forEach(advance_data_item => {
                        if (advance_data_item.Employee_id == all_users_data.Employee_id) {
                            advance = advance + (parseFloat(advance_data_item.Loan_Amount_in_INR) || 0);
                        }
                    });
                }
                table_html_data += `${advance}</td>`;

                // Process deductions
                table_html_data += `<td>`;
                if (deductions_data.length > 0) {
                    deductions_data.forEach(deduction => {
                        if (deduction.Employee_id == all_users_data.Employee_id) {
                            deductions_amount = deductions_amount + (parseFloat(deduction.deduction_Amount_in_INR) || 0);
                        }
                    });
                }
                table_html_data += `${deductions_amount.toFixed(2)}</td>`;

                // Process penalty
                table_html_data += `<td>`;
                if (penalty_data.length > 0) {
                    penalty_data.forEach(penalty => {
                        if (penalty.EmpID == all_users_data.Employee_id) {
                            Penalty = Penalty + parseFloat(penalty.Final_Amount || 0);
                        }
                    });
                }
                table_html_data += `${Penalty.toFixed(2)}</td>`;

                // Calculate final amount before arrear
                final_amount_before_arrear = Total_Amount - Penalty - deductions_amount - advance;
                table_html_data += `<td>${final_amount_before_arrear.toFixed(2)}</td>`;

                // Editable fields for arrears
                table_html_data += `
                    <td contenteditable="true" oninput="validateNumber(this)" class="arrear-amount">0</td>
                    <td contenteditable="true" class="arrear-reason"></td>`;

                // Final calculations
                monthaly_salary = Total_Amount;
                net_salary = final_amount_before_arrear; // Net salary is the final amount before arrear (arrear will be added via JS)

                table_html_data += `
                    <td>${Daily_Rate.toFixed(2)}</td>
                    <td>${monthaly_salary.toFixed(2)}</td>
                    <td class="net-salary">${net_salary.toFixed(2)}</td>
                </tr>`;

                // Reset variables for next employee
                Work = 0;
                Over_Time = 0;
                deductions_amount = 0;
                Penalty = 0;
                advance = 0;
                Over_Ttime_Rate = 0;
                Daily_Rate = 0;
                Total_OT_Amount = 0;
                Total_Amount = 0;
                Total_all_day_Amount = 0;
                final_amount_before_arrear = 0;
            });

            table_html_data += `</tbody></table>`;

            // Display table
            $("#result").html(table_html_data);

            // Add event listener to update net salary when arrear amount changes
            $(".arrear-amount").on("input", function() {
                const row = $(this).closest("tr");
                const arrearAmount = parseFloat($(this).text()) || 0;
                const finalAmountBeforeArrear = parseFloat(row.find("td").eq(-3).text());
                const netSalary = finalAmountBeforeArrear + arrearAmount;
                row.find(".net-salary").text(netSalary.toFixed(2));
            });

            // Apply any view mode settings
            if (typeof toggleCompactView === 'function') {
                toggleCompactView();
            }

            // Build pagination if available
            if (response.all_users && response.all_users.links) {
                var pagination_data = response.all_users.links;
                var pagination_html = `<nav aria-label="Page navigation"><ul class="pagination">`;

                pagination_data.forEach(link => {
                    pagination_html += `
                    <li class="page-item ${link.active ? 'active' : ''}">
                        <a class="page-link page-btn" data-page="${link.url}" href="javascript:void(0)">
                            ${link.label}
                        </a>
                    </li>`;
                });

                pagination_html += `</ul></nav>
                <div class="text-muted">
                    Showing ${response.all_users.from} to ${response.all_users.to} of ${response.all_users.total} entries
                </div>`;

                $("#pagination_div").html(pagination_html);
            }
        },
        error: function(xhr, status, error) {
            console.error("Error:", error);
            $("#result").html(`
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle mr-1"></i>
                Error loading data. Please try again.
            </div>`);
        }
    });
}


// Updated JavaScript function for processing dates in the report view

function processAttendanceData(startDate, endDate, userData, attendanceData, holidayData, holidayMasterData, leaveData) {
    // Check if all required data is available
    if (!userData || !Array.isArray(userData)) {
        console.error("User data is missing or invalid");
        return '<tr><td colspan="20">No user data available</td></tr>';
    }

    // Ensure other data arrays exist, provide empty arrays as fallback
    attendanceData = attendanceData || [];
    holidayData = holidayData || [];
    holidayMasterData = holidayMasterData || [];
    leaveData = leaveData || [];

    const dates = getDatesInRange(startDate, endDate);
    let html = '';

    userData.forEach(user => {
        html += '<tr>';
        html += `<td>${user.f_name || ''} ${user.l_name || ''}</td>`;
        html += `<td>${user.Employee_id || ''}</td>`;

        dates.forEach(date => {
            const formattedDate = formatDate(date); // YYYY-MM-DD format

            // Find attendance for this employee on this date - with null checks
            const attendance = attendanceData.find(att =>
                att && att.Employee_id === user.Employee_id &&
                att.attandence_Date === formattedDate
            );

            // Check for holiday - with null checks
            const isHoliday = holidayMasterData.some(holiday =>
                holiday && holiday.holiday_Date === formattedDate
            );

            // Check specifically for swap date - with null checks
            const swapDate = holidayData.find(holiday =>
                holiday && holiday.Employee_id === user.Employee_id &&
                holiday.Swap_Date === formattedDate
            );

            // Check for leave - with null checks
            const leave = leaveData.find(leave =>
                leave && leave.Employee_id === user.Employee_id &&
                new Date(leave.Start_Date) <= date &&
                new Date(leave.End_Date) >= date
            );

            // Set cell style and content based on status
            let cellClass = '';
            let cellContent = 'Absent';
            let cellStyle = '';

            if (attendance) {
                cellClass = 'present';
                cellContent = 'Present';
                cellStyle = 'background-color: #d4edda;'; // Light green for present
            } else if (swapDate) {
                // This is specifically a swap day
                cellClass = 'swap-day';
                cellContent = 'Present'; // Swap days are typically marked as present
                cellStyle = 'background-color: orange;';
            } else if (isHoliday) {
                cellClass = 'holiday';
                cellContent = 'Absent'; // Default for holidays
                cellStyle = 'background-color: yellow;';
            } else if (user.Weekly_Off === date.toLocaleDateString('en-US', { weekday: 'long' })) {
                cellClass = 'weekly-off';
                cellContent = 'Absent';
                cellStyle = 'background-color: cyan;';
            } else if (leave) {
                cellClass = 'leave';
                cellContent = 'Absent';

                if (leave.Half_Day === 1) {
                    cellStyle = `background: linear-gradient(to right, ${leave.Color || '#ffffff'} 50%, transparent 50%);`;
                } else {
                    cellStyle = `background-color: ${leave.Color || '#ffffff'};`;
                }
            }

            html += `<td class="${cellClass}" style="${cellStyle}">${cellContent}</td>`;
        });

        // Add summary columns - you can calculate these based on the attendance data
        const workDays = calculateWorkDays(user.Employee_id, attendanceData, startDate, endDate);
        const absentDays = dates.length - workDays;

        html += `<td>${dates.length}</td>`;  // Total days
        html += `<td>${dates.length - getHolidayCount(holidayMasterData, startDate, endDate)}</td>`; // Working days
        html += `<td>${workDays}</td>`;  // Work days
        html += `<td>${absentDays}</td>`; // Absent days
        html += '</tr>';
    });

    return html;
}

// Helper function to check if a date is a swap date - with null safety
function isSwapDate(employeeId, date, holidayData) {
    if (!holidayData || !Array.isArray(holidayData)) {
        return false;
    }

    const formattedDate = formatDate(date);

    // Check ONLY for exact swap date match
    return holidayData.some(holiday =>
        holiday &&
        holiday.Employee_id === employeeId &&
        holiday.Swap_Date === formattedDate
    );
}
    // Add this function to validate number input in editable cells
    function validateNumber(element) {
        let value = element.innerText;
        value = value.replace(/[^0-9.]/g, '');

        // Ensure only one decimal point
        const parts = value.split('.');
        if (parts.length > 2) {
            value = parts[0] + '.' + parts.slice(1).join('');
        }

        element.innerText = value;
    }

    function printTable() {
    // Create a print-friendly version
    var printContent = document.getElementById("id_of_table").outerHTML;
    var printWindow = window.open('', '', 'width=800,height=600');
    printWindow.document.write('<html><head><title>Monthly Attendance & Salary Report</title>');
    printWindow.document.write('<style>');
    printWindow.document.write(`
        table { border-collapse: collapse; width: 100%; font-size: 12px; }
        th, td { border: 1px solid black; padding: 5px; text-align: center; }
        th { background-color: #f2f2f2; }
        .weekly-off { background-color: cyan; }
        .holiday { background-color: yellow; }
        .swap-day { background-color: orange; }
        .leave { background-color: inherit; }
        .half-day-leave { background: linear-gradient(to right, inherit 50%, transparent 50%); }
        @media print {
            body { font-size: 12px; }
            .no-print { display: none; }
        }
    `);
    printWindow.document.write('</style></head><body>');
    printWindow.document.write('<h2 class="text-center">Monthly Attendance & Salary Report</h2>');
    printWindow.document.write('<h4 class="text-center">' + document.getElementById("month_input").value + '</h4>');
    printWindow.document.write(printContent);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.focus();
    setTimeout(function() {
        printWindow.print();
    }, 1000);
}

function exportTableToPDF() {
    // Create a new instance of jsPDF
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('l', 'pt', 'a3'); // Landscape orientation, A3 size

    // Create a clean version of the table
    var table = document.getElementById("id_of_table");

    // Add title and date
    doc.setFontSize(16);
    doc.text("Monthly Attendance & Salary Report", 40, 40);
    doc.setFontSize(12);
    doc.text(document.getElementById("month_input").value, 40, 60);

    // Add the table to the PDF
    doc.autoTable({
        html: table,
        startY: 70,
        theme: 'grid',
        headStyles: { fillColor: [0, 123, 255], textColor: [255, 255, 255] },
        styles: { fontSize: 7, cellPadding: 2 },
        columnStyles: {
            0: {cellWidth: 30}, // Sr. No
            1: {cellWidth: 80}, // Name
            2: {cellWidth: 50}, // Employee ID
        },
        didDrawPage: function(data) {
            // Add page number
            doc.setFontSize(10);
            doc.text('Page ' + doc.internal.getNumberOfPages(), data.settings.margin.left, doc.internal.pageSize.height - 10);
        }
    });

    doc.save("salary_report.pdf");
}

function exportTableToExcel() {
    // Get the table element
    var table = document.getElementById("id_of_table");

    // Format the table for Excel
    var wb = XLSX.utils.table_to_book(table, {
        sheet: "Salary Report",
        dateNF: 'yyyy-mm-dd',
        raw: true
    });

    // Save the Excel file
    XLSX.writeFile(wb, "salary_report_" + document.getElementById("month_input").value + ".xlsx");
}

// Save data functionality
$(document).on('click', '#saveTableData', function() {
    // Show loading state
    $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');

    const tableData = [];
    const headers = [];

    // Get headers first
    $('#id_of_table thead th').each(function() {
        headers.push($(this).text().trim().split(' ')[0]); // Remove sort icons from header text
    });

    // Get row data
    $('#id_of_table tbody tr').each(function() {
        const rowData = {};
        $(this).find('td').each(function(index) {
            // Use the header as the key
            if (index < headers.length) {
                rowData[headers[index]] = $(this).text().trim();
            }
        });
        tableData.push(rowData);
    });

    // Get the selected month and year
    const monthInput = document.getElementById("month_input").value;

    $.ajax({
        url: '{{ url("/save-salary-data") }}',
        type: 'POST',
        dataType: 'json',
        contentType: 'application/json',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        data: JSON.stringify({
            tableData: tableData,
            month: monthInput
        }),
        success: function(response) {
            // Reset button state
            $('#saveTableData').prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Save Data');

            // Show success message
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Salary data saved successfully!'
            });
            console.log(response.data);
        },
        error: function(xhr, status, error) {
            // Reset button state
            $('#saveTableData').prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Save Data');

            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to save salary data: ' + (xhr.responseJSON?.message || 'Unknown error')
            });
        }
    });
});

// Add short_data function that was referenced but not defined
function short_data(column) {
    // Toggle sort direction
    var currentDirection = $('#'+column+'_span').data('direction') || 'asc';
    var newDirection = currentDirection === 'asc' ? 'desc' : 'asc';

    // Update sort icon
    $('.fas.fa-sort').removeClass('fa-sort-up fa-sort-down');
    $('#'+column+'_span').addClass(newDirection === 'asc' ? 'fa-sort-up' : 'fa-sort-down');
    $('#'+column+'_span').data('direction', newDirection);

    // If we have month/year set, use them
    if (month == "") {
        month = s_month;
    }
    if (year == "") {
        year = s_year;
    }

    // Build sort URL with appropriate parameters
    var sortUrl;
    if (inp == "") {
        sortUrl = "{{url('/salary-calculations-api')}}/" + limit + "/" + month + "/" + year + "?sort=" + column + "&direction=" + newDirection;
    } else {
        sortUrl = "{{url('/salary-calculations-short-search-api')}}/" + limit + "/" + month + "/" + year + "/" + inp + "?sort=" + column + "&direction=" + newDirection;
    }

    // Load sorted data
    attendance_data_set(sortUrl);
}

// Add event handler for mobile UI
$(document).ready(function() {
    // Set current month in the month input
    var currentDate = new Date();
    var currentMonth = currentDate.getMonth() + 1; // getMonth() returns 0-11
    var currentYear = currentDate.getFullYear();
    document.getElementById("month_input").value = currentYear + "-" + (currentMonth < 10 ? '0' + currentMonth : currentMonth);

    // Mobile menu toggle
    $('#mobileActionsToggle').on('click', function() {
        $('.floating-actions-menu').toggle();
    });

    // Add resize handler to adjust UI for small screens
    $(window).resize(function() {
        adjustUIForScreenSize();
    });

    // Initial UI adjustment
    adjustUIForScreenSize();

    // Initialize SaveTable button event
    $('#saveTableData').on('click', function() {
        Swal.fire({
            title: 'Save Salary Data',
            text: 'Are you sure you want to save the current salary data?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, save it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // The existing click handler will take over from here
            }
        });
    });
});

// Function to adjust UI based on screen size
function adjustUIForScreenSize() {
    if ($(window).width() < 768) {
        // Mobile view
        $('.btn-group').addClass('btn-group-sm');
        $('.form-control').addClass('form-control-sm');
    } else {
        // Desktop view
        $('.btn-group').removeClass('btn-group-sm');
        $('.form-control').removeClass('form-control-sm');
    }
}
</script>
@stop

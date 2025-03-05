<!-- resources/views/salary/index.blade.php -->
@extends('adminlte::page')

@section('title', 'Report 1')

@section('content_header')
    <h1>Report 1</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="btn-group">
                    <button type="button" class="btn btn-default" title="Excel">
                        <i class="fas fa-file-excel"></i> Excel
                    </button>
                    <button type="button" class="btn btn-default" title="PDF">
                        <i class="fas fa-file-pdf"></i> PDF
                    </button>
                    <button type="button" class="btn btn-default" title="Print">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>
            <div class="col-md-2">
                <div class="input-group">
                    <input for="month_input" type="month" id="month_input"  class="form-control" value="{{ date('Y-m') }}" onchange="set_month_for_data()">
                </div>
            </div>
            <div class="col-md-2">
                <form id="search_form" action="{{ route('search_employee') }}" method="POST" class="form-inline d-flex justify-content-end">
                    @csrf
                    <div class="input-group">
                        <input type="search" class="form-control" name="search_input" id="search_input" placeholder="Search by Name & Email" onkeyup="searchOnKeyPress()">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card-body" style="max-height: 1000px; overflow-y: auto; overflow-x: auto; white-space: nowrap;">
        <div class="mb-2">
            <span class="me-2" style="display:inline-block; width:15px; height:15px; background-color:#00FFFF; margin-right:5px;"></span> Weekly Off
            <span class="me-2" style="display:inline-block; width:15px; height:15px; background-color:#FFFF00; margin-right:5px;"></span> Holiday
            <span class="me-2" style="display:inline-block; width:15px; height:15px; background-color:#FFA500; margin-right:5px;"></span> Swap Day
            <span class="me-2" style="display:inline-block; width:15px; height:15px; background-color:#FF0000; margin-right:5px;"></span> Sick Leave
            <span class="me-2" style="display:inline-block; width:15px; height:15px; background-color:#FF00FF; margin-right:5px;"></span> Casual Leave
        </div>
        <div class="card-body table-responsive p-0">
            <div id="loading-overlay" class="overlay">
                <i class="fas fa-2x fa-sync-alt fa-spin"></i>
            </div>
            <div id="result"></div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-md-6">
                    <button id="saveTableData" class="btn btn-success">Save Salary Data</button>
                </div>
                <div class="col-md-6">
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm justify-content-center" id="pagination_div">
                            <!-- Pagination will be dynamically inserted here -->
                        </ul>
                    </nav>
                </div>

            </div>
        </div>
    </div>
</div>

<input type="hidden" id="role_number" value="{{ Auth::user()->role_id ?? 0 }}">

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
    #salary-table {
        min-width: 100%;
    }
</style>
@stop

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
$(document).ready(function() {
    var table = $('#reportTable').DataTable({
        "pageLength": 5,
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
        "ordering": true,
        "searching": false,
        "responsive": true,
        "buttons": [],
        "columnDefs": [
            {
                "targets": [4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15],
                "orderable": false
            }
        ]
    });

    // Toggle Days button functionality
    $('.btn-group .btn:first-child').on('click', function() {
        var sunday = [10, 11, 12, 13, 14, 15];
        $.each(sunday, function(i, col) {
            var column = table.column(col);
            column.visible(!column.visible());
        });
    });

    // Excel export
    $('.btn-group .btn:nth-child(2)').on('click', function() {
        table.button('.buttons-excel').trigger();
    });

    // PDF export
    $('.btn-group .btn:nth-child(3)').on('click', function() {
        table.button('.buttons-pdf').trigger();
    });

    // Print
    $('.btn-group .btn:last-child').on('click', function() {
        table.button('.buttons-print').trigger();
    });

    // Global variables
    var limit = 50;
    var s_month = new Date().getMonth();
    var s_year = new Date().getFullYear();
    var inp = "";
    var month = "";
    var year = "";
    var start_d, end_d, set_last_date;
    var page_url;

    // Sorting click counters
    var sortClickCounters = {
        f_name: 1,
        Employee_id: 1,
        Shift_hours: 1,
        email: 1,
        aadhaar_number: 1,
        pan_number: 1
    };

    var data_count = 1;

    // Initialize on document ready
    $(function() {
        // Set initial month input value
        const currentDate = new Date();
        const currentYear = currentDate.getFullYear();
        const currentMonth = String(currentDate.getMonth() + 1).padStart(2, '0');
        document.getElementById('month_input').value = `${currentYear}-${currentMonth}`;

        // Initial data load
        s_month = s_month + 1;
        set_last_date = getLastDateOfMonth(s_year, s_month - 1);
        start_d = s_year + "-" + s_month + "-01";
        end_d = s_year + "-" + s_month + "-" + set_last_date;

        loadData();

        $('#pagination_div').on('click', '.page-btn', function() {
            var page = $(this).data('page');
            loadAttendanceData(page);
        });

        $(document).on('click', '#saveTableData', function() {
            saveTableData();
        });
    });

    // Helper function to get last date of month
    function getLastDateOfMonth(year, month) {
        // Month is 0-based (0 = January, 11 = December)
        return new Date(year, month + 1, 0).getDate();
    }

    // Format date to YYYY-MM-DD
    function formatDateToYYYYMMDD(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    // Load initial data
    function loadData() {
        page_url = "{{ url('/salary-calculations-api') }}/" + limit + "/" + s_month + "/" + s_year;
        loadAttendanceData(page_url);
    }

    // Set month for data
    function setMonthForData() {
        const dateInput = document.getElementById("month_input").value;
        const selectedDate = new Date(dateInput);

        // Extract year and month
        year = selectedDate.getFullYear();
        month = selectedDate.getMonth() + 1;

        // Calculate dates
        set_last_date = getLastDateOfMonth(year, month - 1);
        start_d = year + "-" + month + "-01";
        end_d = year + "-" + month + "-" + set_last_date;

        // Update URL and load data
        page_url = "{{ url('/salary-calculations-api') }}/" + limit + "/" + month + "/" + year;
        loadAttendanceData(page_url);
    }

    // Set limit (records per page)
    function setLimit() {
        limit = $("#limit_input").val();

        if (month == "") {
            month = s_month;
        }

        if (year == "") {
            year = s_year;
        }

        if (inp == "") {
            page_url = "{{ url('/salary-calculations-api') }}/" + limit + "/" + month + "/" + year;
        } else {
            page_url = "{{ url('/salary-calculations-short-search-api') }}/" + limit + "/" + month + "/" + year + "/" + inp;
        }

        loadAttendanceData(page_url);
    }

    // Search functionality
    function searchOnKeyPress() {
        let inp = $("#search_input").val().trim();
        let month = s_month;
        let year = s_year;

        if (month == "") month = s_month;
        if (year == "") year = s_year;

        let page_url = "{{url('/salary-calculations-short-search-api')}}/" + limit + "/" + month + "/" + year + "/" + encodeURIComponent(inp);

        $.ajax({
            url: page_url,
            type: "GET",
            success: function (data) {
                attendance_data_set(data); // Ensure this updates your UI correctly
            },
            error: function (xhr, status, error) {
                console.error("Error fetching data:", error);
                alert("Failed to fetch search results.");
            }
        });
    }

    // Sort data
    function sortData(sortBy) {
        if (month == "") {
            month = s_month;
        }

        if (year == "") {
            year = s_year;
        }

        let method = sortClickCounters[sortBy] % 2 === 0 ? 'asc' : 'desc';
        sortClickCounters[sortBy]++;

        page_url = "{{ url('/salary-calculations-short-api') }}/" + limit + "/" + month + "/" + year + "/" + sortBy + "/" + method;
        loadAttendanceData(page_url);
    }

    // Load attendance data
    function loadAttendanceData(url_input) {
        showAnimation();

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

                renderTable(response);

                // Pagination
                renderPagination(response.all_users.links, response.all_users.per_page, response.all_users.total);

                hideAnimation();
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                hideAnimation();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to load data. Please try again.'
                });
            }
        });
    }

    // Render table with data
    function renderTable(response) {
        data_count = 1;
        var all_users_data = response.all_users.data;
        var all_attandance_data = response.attendance_info_data;
        var deductions_data = response.deductions;
        var penalty_data = response.penalty_data;
        var advance_data = response.advance_data;
        var public_holiday_data = response.holiday_data;
        var leave_data = response.leave_data;

        // Generate dates range
        const startDate = new Date(start_d);
        const endDate = new Date(end_d);
        const dates = [];
        let currentDate = new Date(startDate);

        while (currentDate <= endDate) {
            dates.push(new Date(currentDate));
            currentDate.setDate(currentDate.getDate() + 1);
        }

        // Build table header
        let tableHtml = `
        <table id="salary_table" class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th class="text-center">Sr. No.</th>
                    <th>
                        Name
                        <a href="javascript:void(0)" onclick="sortData('f_name')">
                            <i class="fas fa-sort"></i>
                        </a>
                    </th>
                    <th>
                        Employee ID
                        <a href="javascript:void(0)" onclick="sortData('Employee_id')">
                            <i class="fas fa-sort"></i>
                        </a>
                    </th>
                    <th>
                        Shift Hours
                        <a href="javascript:void(0)" onclick="sortData('Shift_hours')">
                            <i class="fas fa-sort"></i>
                        </a>
                    </th>`;

        // Add date headers
        dates.forEach(date => {
            const formattedDate = date.toLocaleDateString("en-US", {
                day: "2-digit",
                month: "short"
            });
            tableHtml += `<th class="date_p">${formattedDate}</th>`;
        });

        // Add remaining headers
        tableHtml += `
                    <th>Total Days</th>
                    <th>Working Days</th>
                    <th>Work (days)</th>
                    <th>Absent</th>
                    <th>OT Hours</th>
                    <th>OT Rate</th>
                    <th>OT Amount</th>
                    <th>Advance</th>
                    <th>Deduction</th>
                    <th>Arrear</th>
                    <th>Arrear Reason</th>
                    <th>Daily Rate</th>
                    <th>Monthly Salary</th>
                    <th>Net Salary</th>
                </tr>
            </thead>
            <tbody>`;

        // Build table rows
        all_users_data.forEach(user => {
            let Work = 0;
            let Over_Time = 0;
            let Total_OT_Amount = 0;
            let Total_all_day_Amount = 0;
            let deductions_amount = 0;
            let advance = 0;
            let Employee_Daily_Rate = user.salary / set_last_date;
            let Daily_Rate = 0;
            let Over_Ttime_Rate = 0;

            tableHtml += `
            <tr>
                <td class="text-center">${data_count}</td>
                <td>${user.f_name} ${user.m_name} ${user.l_name}</td>
                <td>${user.Employee_id}</td>
                <td>${user.Shift_hours}</td>`;

            data_count++;

            // Process each date for the current user
            dates.forEach(date => {
                // Filter attendance data
                const filteredData = all_attandance_data.filter(att_data =>
                    att_data.Employee_id === user.Employee_id &&
                    formatDateToYYYYMMDD(date) === att_data.attandence_Date
                );

                // Filter holiday data
                const holiday_data = public_holiday_data.filter(holiday =>
                    formatDateToYYYYMMDD(date) === holiday.holiday_Date
                );

                // Filter leave data
                const leave_filter_data = leave_data.filter(leave =>
                    leave.Employee_id === user.Employee_id &&
                    leave.Start_Date <= formatDateToYYYYMMDD(date) &&
                    leave.End_Date >= formatDateToYYYYMMDD(date)
                );

                // Default variables
                let leave_color = "";
                let Half_Day_Leave = 0;
                let Payment_Status = "";
                let Short_Name = "";
                let OT_Amt = 0;
                let Daily_Amt = 0;
                let Swap_Day_array_data = 0;
                let Public_Holiday_array_data = 0;
                let Weekly_Off_array_data = 0;

                // Process leave data if exists
                if (leave_filter_data.length > 0) {
                    leave_filter_data.forEach(leave => {
                        leave_color = leave.Color;
                        Half_Day_Leave = leave.Half_Day;
                        Payment_Status = leave.Payment_Status;
                        Short_Name = leave.Short_Name;
                    });
                }

                // Process attendance data if exists
                filteredData.forEach(att => {
                    Swap_Day_array_data = att.Swap_Day;
                    Public_Holiday_array_data = att.Public_Holiday;
                    Weekly_Off_array_data = att.WeeklyOff;
                    Daily_Rate = att.Daily_Rate;
                    Over_Ttime_Rate = att.Over_Ttime_Rate;
                });

                // Determine cell background color
                let cellBackgroundColor = '';
                let status = 'Absent';

                if (Swap_Day_array_data == 1) {
                    cellBackgroundColor = 'style="background-color:#FFA500"'; // Orange for swap day
                } else if (Public_Holiday_array_data == 1) {
                    cellBackgroundColor = 'style="background-color:#FFFF00"'; // Yellow for public holiday
                } else if (Weekly_Off_array_data == 1) {
                    cellBackgroundColor = 'style="background-color:#00FFFF"'; // Cyan for weekly off
                } else if (user.Weekly_Off == date.toLocaleDateString('en-US', { weekday: 'long' })) {
                    cellBackgroundColor = 'style="background-color:#00FFFF"'; // Cyan for weekly off
                } else if (leave_filter_data.length > 0) {
                    if (Half_Day_Leave == 1) {
                        cellBackgroundColor = 'style="background: linear-gradient(to right, ' + leave_color + ' 50%, transparent 50%);"';
                    } else {
                        cellBackgroundColor = 'style="background-color:' + leave_color + '"';
                    }
                }

                // Calculate attendance and payment
                if (filteredData.length === 0) {
                    // Absent
                    if (Half_Day_Leave == 0 && Payment_Status == "Paid") {
                        Daily_Amt = Employee_Daily_Rate;
                    }
                } else {
                    // Present
                    status = 'Present';
                    filteredData.forEach(att => {
                        if (Half_Day_Leave == 1 && Payment_Status == "Paid") {
                            Daily_Amt = att.Daily_Rate / 2;
                        } else {
                            Daily_Amt = att.Daily_Rate;
                        }

                        OT_Amt = att.Overtime * att.Over_Ttime_Rate;
                        Total_OT_Amount += OT_Amt;

                        Work++;
                        Over_Time += att.Overtime;
                    });
                }

                Total_all_day_Amount += Daily_Amt;

                // Add the cell to the row
                tableHtml += `<td class="in_time_p" ${cellBackgroundColor}>${status}</td>`;
            });

            // Calculate absences
            let Absent_count = set_last_date - response.holiday_count - Work;
            if (Absent_count <= 0) {
                Absent_count = 0;
            }

            // Calculate salary totals
            let monthaly_salary = Total_all_day_Amount + Total_OT_Amount;

            // Get deductions for this employee
            if (deductions_data.length > 0) {
                deductions_data.forEach(deduction => {
                    if (deduction.Employee_id === user.Employee_id) {
                        deductions_amount += deduction.deduction_Amount_in_INR;
                    }
                });
            }

            // Get advances for this employee
            if (advance_data.length > 0) {
                advance_data.forEach(adv => {
                    if (adv.Employee_id === user.Employee_id) {
                        advance += adv.Loan_Amount_in_INR;
                    }
                });
            }

            // Calculate net salary
            let net_salary = monthaly_salary - deductions_amount - advance;

            // Add summary cells
            tableHtml += `
                <td>${set_last_date}</td>
                <td>${set_last_date - response.holiday_count}</td>
                <td>${Work}</td>
                <td>${Absent_count}</td>
                <td>${Over_Time}</td>
                <td>${Over_Ttime_Rate.toFixed(2)}</td>
                <td>${Total_OT_Amount.toFixed(2)}</td>
                <td>${advance}</td>
                <td>${deductions_amount}</td>
                <td class="editable" contenteditable="true" oninput="validateNumber(this)">0</td>
                <td class="editable" contenteditable="true"></td>
                <td>${Daily_Rate.toFixed(2)}</td>
                <td>${monthaly_salary.toFixed(2)}</td>
                <td>${net_salary.toFixed(2)}</td>
            </tr>`;
        });

        tableHtml += '</tbody></table>';

        // Render the table
        $("#result").html(tableHtml);
    }

    // Render pagination
    function renderPagination(links, perPage, total) {
        let paginationHtml = '<div class="pagination">';

        links.forEach(link => {
            let activeClass = link.active ? 'active' : '';
            let label = link.label;

            // Replace "Next &raquo;" and "&laquo; Previous" with icons
            if (label === 'Next &raquo;') {
                label = '<i class="fas fa-chevron-right"></i>';
            } else if (label === '&laquo; Previous') {
                label = '<i class="fas fa-chevron-left"></i>';
            }

            paginationHtml += `<p data-page='${link.url}' class="${activeClass} page-btn">${label}</p>`;
        });

        paginationHtml += `</div>
        <div class="ml-2">
            <span class="badge badge-info">Page Size: ${perPage}</span>
            <span class="badge badge-secondary">Total Records: ${total}</span>
        </div>`;

        $("#pagination_div").html(paginationHtml);
    }

    // Validate number inputs
    function validateNumber(cell) {
        const value = cell.innerText;
        if (!/^\d*$/.test(value)) {
            cell.innerText = value.replace(/\D/g, '');
        }
    }

    // Save table data
    function saveTableData() {
        const tableData = [];

        $('#salary_table tbody tr').each(function() {
            const row = [];
            $(this).find('td').each(function() {
                row.push($(this).text().trim());
            });
            tableData.push(row);
        });

        $.ajax({
            url: '{{ url("/save-salary-data") }}',
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: JSON.stringify({ tableData: tableData }),
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Salary data saved successfully!'
                });
                console.log(response.data);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to save salary data.'
                });
            }
        });
    }

    // Show loading animation
    function showAnimation() {
        $('#loading-overlay').show();
    }

    // Hide loading animation
    function hideAnimation() {
        $('#loading-overlay').hide();
    }

    $("#month_input").on("change", function() {
        const dateInput = this.value;
        if (!dateInput) return;

        const selectedDate = new Date(dateInput);
        s_year = selectedDate.getFullYear();
        s_month = selectedDate.getMonth() + 1;

        // Calculate start and end dates
        set_last_date = getLastDateOfMonth(s_year, s_month - 1);
        start_d = s_year + "-" + s_month.toString().padStart(2, '0') + "-01";
        end_d = s_year + "-" + s_month.toString().padStart(2, '0') + "-" + set_last_date;

        // Update URL with correct month & year
        page_url = `{{ url('/salary-calculations-api') }}/${limit}/${s_month}/${s_year}`;

        loadAttendanceData(page_url);
    });

});
</script>
@stop

@extends('adminlte::page')

@section('title', 'Monthly Attendance & Salary Report')

@section('content_header')
    <h1>Monthly Attendance & Salary Report</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
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

        <div class="table-responsive" id="result">
            <!-- Table will be loaded here via AJAX -->
            <div class="d-flex justify-content-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
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
@stop

@section('css')
<!-- Custom CSS -->
<style>
    .legend-container {
        margin-bottom: 10px;
    }
    .legend-item {
        display: flex;
        align-items: center;
        margin-right: 15px;
    }
    .legend-color {
        display: inline-block;
        width: 16px;
        height: 16px;
        margin-right: 5px;
        border: 1px solid #ddd;
    }
    .table th, .table td {
        vertical-align: middle !important;
    }
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
    .date_p {
        font-size: 0.8rem;
        white-space: nowrap;
    }
    #result table {
        font-size: 0.85rem;
    }
    .card-body {
        height: 600px; /* Fixed height */
        overflow-y: auto;
        position: relative;
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
    });

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
        $("#result").html('<div class="d-flex justify-content-center"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>');

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

                var all_users_data = response.all_users.data;
                var all_attandance_data = response.attendance_info_data;
                var deductions_data = response.deductions;
                var penalty_data = response.penalty_data;
                var advance_data = response.advance_data;
                var public_holiday_data = response.holiday_data;
                var leave_data = response.leave_data;

                // Build table HTML
                var table_html_data = `
                <table id="id_of_table" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Sr. N.</th>
                            <th>Name <i class="fas fa-sort" onclick="short_data('f_name')" id="f_name_span"></i></th>
                            <th>Employee Id <i class="fas fa-sort" onclick="short_data('Employee_id')" id="Employee_id_span"></i></th>
                            <th>Shift hrs <i class="fas fa-sort" onclick="short_data('Shift_hours')" id="Shift_hours_span"></i></th>`;

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
                    table_html_data += `<th class="date_p">${formattedDate}</th>`;
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
                        <td>${data_count}</td>
                        <td>${all_users_data.f_name} ${all_users_data.m_name || ''} ${all_users_data.l_name || ''}</td>
                        <td>${all_users_data.Employee_id}</td>
                        <td>${all_users_data.Shift_hours}</td>`;

                    var Employee_Daily_Rate = all_users_data.salary / set_last_date;
                    data_count++;

                    // Process attendance for each date
                    dates.forEach(date => {
                        const formattedDate = formatDateToYYYYMMDD(date);

                        const filteredData = all_attandance_data.filter(all_att_data =>
                            all_att_data.Employee_id === all_users_data.Employee_id &&
                            formattedDate === all_att_data.attandence_Date
                        );

                        const public_holiday_filter_data = public_holiday_data.filter(public_holiday_data =>
                            formattedDate === public_holiday_data.holiday_Date
                        );

                        const leave_filter_data = leave_data.filter(leave_d =>
                            leave_d.Employee_id === all_users_data.Employee_id &&
                            leave_d.Start_Date <= formattedDate &&
                            leave_d.End_Date >= formattedDate
                        );

                        if (leave_filter_data.length > 0) {
                            leave_filter_data.forEach(leave_data_item => {
                                leave_color = leave_data_item.Color;
                                Half_Day_Leave = leave_data_item.Half_Day;
                                Payment_Status = leave_data_item.Payment_Status;
                                Short_Name = leave_data_item.Short_Name;
                            });
                        }

                        OT_Amt = 0;
                        Daily_Amt = 0;

                        filteredData.forEach(element => {
                            Swap_Day_array_data = element.Swap_Day;
                            Public_Holiday_array_data = element.Public_Holiday;
                            Daily_Rate = element.Daily_Rate;
                            Over_Ttime_Rate = element.Over_Ttime_Rate;
                            Weekly_Off_array_data = element.WeeklyOff;
                        });

                        // Determine cell background color
                        let cellBackgroundColor = '';
                        let cellStatusText = 'Absent';

                        if (Swap_Day_array_data == 1) {
                            cellBackgroundColor = 'style="background-color: orange;"';
                        } else if (Public_Holiday_array_data == 1) {
                            cellBackgroundColor = 'style="background-color: yellow;"';
                        } else if (Weekly_Off_array_data == 1) {
                            cellBackgroundColor = 'style="background-color: cyan;"';
                        } else if (all_users_data.Weekly_Off == date.toLocaleDateString('en-US', { weekday: 'long' })) {
                            cellBackgroundColor = 'style="background-color: cyan;"';
                        } else if (public_holiday_filter_data.length > 0) {
                            cellBackgroundColor = 'style="background-color: yellow;"';
                        } else if (leave_filter_data.length > 0) {
                            if (Half_Day_Leave == 1) {
                                cellBackgroundColor = `style="background: linear-gradient(to right, ${leave_color} 50%, transparent 50%);"`;
                            } else {
                                cellBackgroundColor = `style="background-color: ${leave_color};"`;
                            }
                        }

                        if (filteredData.length === 0) {
                            table_html_data += `<td class="in_time_p" ${cellBackgroundColor}>${cellStatusText}</td>`;

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

                                table_html_data += `<td class="in_time_p" ${cellBackgroundColor}>Present</td>`;
                                Work++;
                                Over_Time += all_att_data.Overtime;
                            });
                        }

                        Total_all_day_Amount = Total_all_day_Amount + Daily_Amt;
                    });

                    // Calculate summaries
                    var Absent_count = Working_Day - response.holiday_count - Work;
                    if (Absent_count <= 0) {
                        Absent_count = 0;
                    }

                    Total_Amount = Total_all_day_Amount + Total_OT_Amount;

                    // Add summary columns
                    table_html_data += `
                        <td>${Working_Day}</td>
                        <td>${Working_Day - response.holiday_count}</td>
                        <td>${Work}</td>
                        <td>${Absent_count}</td>
                        <td>${Over_Time}</td>
                        <td>${Over_Ttime_Rate.toFixed(2)}</td>
                        <td>${Total_OT_Amount.toFixed(2)}</td>`;

                    // Process advance/loan
                    table_html_data += `<td>`;
                    if (advance_data != "") {
                        advance_data.forEach(advance_data_item => {
                            if (advance_data_item.Employee_id == all_users_data.Employee_id) {
                                advance = advance + advance_data_item.Loan_Amount_in_INR;
                            }
                        });
                    }
                    table_html_data += `${advance}</td>`;

                    // Process deductions
                    table_html_data += `<td>`;
                    if (deductions_data != "") {
                        deductions_data.forEach(deduction => {
                            if (deduction.Employee_id == all_users_data.Employee_id) {
                                deductions_amount = deductions_amount + deduction.deduction_Amount_in_INR;
                            }
                        });
                    }
                    table_html_data += `${deductions_amount}</td>`;

                    // Editable fields for arrears
                    table_html_data += `
                        <td contenteditable="true" oninput="validateNumber(this)"></td>
                        <td contenteditable="true"></td>`;

                    // Final calculations
                    monthaly_salary = Total_Amount;
                    net_salary = monthaly_salary - Penalty - deductions_amount - advance;

                    table_html_data += `
                        <td>${Daily_Rate.toFixed(2)}</td>
                        <td>${monthaly_salary.toFixed(2)}</td>
                        <td>${net_salary.toFixed(2)}</td>
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
                });

                table_html_data += `</tbody></table>`;

                // Display table
                $("#result").html(table_html_data);

                // Build pagination
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

    function validateNumber(cell) {
        const value = cell.innerText;
        if (!/^\d*$/.test(value)) {
            cell.innerText = value.replace(/\D/g, '');
        }
    }

    function printTable() {
        var table = document.getElementById("id_of_table").outerHTML;
        var newWindow = window.open('', '', 'width=800,height=600');
        newWindow.document.write('<html><head><title>Print Table</title>');
        newWindow.document.write('<style>table { border-collapse: collapse; width: 100%; } th, td { border: 1px solid black; padding: 8px; text-align: left; }</style>');
        newWindow.document.write('</head><body>');
        newWindow.document.write(table);
        newWindow.document.write('</body></html>');
        newWindow.document.close();
        newWindow.focus();
        newWindow.print();
        newWindow.close();
    }

    function exportTableToPDF() {
        // Create a new instance of jsPDF
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        var table = document.getElementById("id_of_table");
        doc.autoTable({
            html: table,
            startY: 10,
            theme: 'grid',
            headStyles: { fillColor: [0, 123, 255] },
            styles: { fontSize: 7 }
        });
        doc.save("salary_report.pdf");
    }

    function exportTableToExcel() {
        var table = document.getElementById("id_of_table");
        var wb = XLSX.utils.table_to_book(table, {sheet: "Salary Report"});
        XLSX.writeFile(wb, "salary_report.xlsx");
    }

    $(document).on('click', '#saveTableData', function() {
        const tableData = [];
        $('#id_of_table tbody tr').each(function() {
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
    });
</script>
@stop

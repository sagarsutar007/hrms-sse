@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
<div class="row">
    @if ($view_home_page_options == 1)
        <div class="col-lg-3 col-6">
            <div class="small-box bg-purple" onclick="location.href='{{url('employees')}}'">
                <div class="inner">
                    <h3>{{$employee_number}}</h3>
                    <p>Employees</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{url('employees')}}" class="small-box-footer">View Table <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning" onclick="location.href='{{url('all-attendance')}}'">
                <div class="inner">
                    <h3>P:{{$Present_number}} A:{{$Absent_number}}</h3>
                    <p>Attendance</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <a href="{{url('all-attendance')}}" class="small-box-footer">View Table <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success" onclick="location.href='{{url('total-leave')}}'">
                <div class="inner">
                    <h3>{{$leave_number}}</h3>
                    <p>Total Leave</p>
                </div>
                <div class="icon">
                    <i class="fas fa-sign-out-alt"></i>
                </div>
                <a href="{{url('total-leave')}}" class="small-box-footer">View Table <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary" onclick="location.href='{{url('all-attendance')}}'">
                <div class="inner">
                    <h3>{{$LatePunch}}</h3>
                    <p>Late Entry</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
                <a href="{{url('all-attendance')}}" class="small-box-footer">View Table <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    @endif
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-light">
                <h3 class="card-title"><i class="fas fa-user-clock mr-2"></i>Shift Wise Attendance</h3>
            </div>
            <div class="card-body table-responsive p-0" id="result">
                <!-- Shift wise attendance data will be loaded here -->
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-light">
                <h3 class="card-title"><i class="fas fa-user-tag mr-2"></i>Employee Type Wise Attendance</h3>
            </div>
            <div class="card-body table-responsive p-0" id="result_Get_Employee_Type_Wise_Current_Date_Data">
                <!-- Employee type wise attendance data will be loaded here -->
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-light">
                <h3 class="card-title"><i class="fas fa-hourglass-half mr-2"></i>Late Commers</h3>
            </div>
            <div class="card-body table-responsive p-0" id="Late_commer_data_table">
                <!-- Late commers data will be loaded here -->
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-light">
                <h3 class="card-title"><i class="fas fa-business-time mr-2"></i>OT Hours Department Wise</h3>
            </div>
            <div class="card-body table-responsive p-0" id="OTDataTable">
                <!-- OT data will be loaded here -->
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header bg-light">
                <h3 class="card-title"><i class="fas fa-user-times mr-2"></i>Absent List</h3>
            </div>
            <div class="card-body table-responsive p-0" id="result_absent">
                <!-- Absent list data will be loaded here -->
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header bg-light">
                <h3 class="card-title"><i class="fas fa-user-check mr-2"></i>Top 10 Present List</h3>
            </div>
            <div class="card-body table-responsive p-0" id="result_present">
                <!-- Present list data will be loaded here -->
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header bg-light">
                <h3 class="card-title"><i class="fas fa-user-slash mr-2"></i>Default Absent</h3>
            </div>
            <div class="card-body table-responsive p-0" id="result_defult_absent">
                <!-- Default absent data will be loaded here -->
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-light">
                <h3 class="card-title"><i class="fas fa-chart-pie mr-2"></i>Employee Type Attendance Charts</h3>
            </div>
            <div class="card-body">
                <div class="row" id="pieChartsContainer">
                    <!-- Pie charts will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('css')
    <style>
        .small-box {
            cursor: pointer;
            transition: transform 0.2s ease;
        }
        .small-box:hover {
            transform: translateY(-5px);
        }
        #pieChartsContainer .chart-item {
            margin-bottom: 20px;
        }
        .employee-photo img {
            border: 4px solid #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .card {
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 20px;
        }
        .card-header {
            border-bottom: 1px solid rgba(0,0,0,0.1);
            padding: 0.75rem 1.25rem;
        }
        .card-header h3 {
            margin-bottom: 0;
            font-weight: 600;
            font-size: 1.1rem;
        }
        .table {
            margin-bottom: 0;
        }
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            color: #495057;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            padding: 12px;
        }
        .table tbody tr {
            transition: background-color 0.2s ease;
        }
        .table tbody tr:hover {
            background-color: rgba(0,123,255,0.05);
        }
        .table td {
            padding: 12px;
            vertical-align: middle;
            border-top: 1px solid #dee2e6;
        }

        /* Status badges */
        .badge-present {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: 500;
        }
        .badge-absent {
            background-color: #dc3545;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: 500;
        }
        .badge-weekly-off {
            background-color: #17a2b8;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: 500;
        }
        .badge-late {
            background-color: #ffc107;
            color: #212529;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: 500;
        }
        .badge-leave {
            background-color: #6c757d;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: 500;
        }

        /* Shadow effect */
        .shadow {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        /* Scrollable tables */
        .table-responsive {
            max-height: 350px;
            overflow-y: auto;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode-generator/1.4.4/qrcode.min.js"></script>

    <script>
        // QR Code generation
        function generateQRCode() {
            var qrcode = new QRCode(document.getElementById("qrcode"), {
                text: "{{url('/push-attendance/')}}/{{$login_u_data['Employee_id']}}/6207820301",
                width: 85,
                height: 85,
            });
        }

        // Show ID Card
        function showIdCard() {
            $('#idCardModal').modal('show');
            setTimeout(function() {
                generateQRCode();
            }, 500);
        }

        // Shift Wise Attendance
        function attendanceDataSet(apiUrl) {
            fetchDataAndRenderTable(apiUrl, "#result");
        }

        function fetchDataAndRenderTable(apiUrl, targetElement) {
            $.ajax({
                url: apiUrl,
                type: "GET",
                dataType: "json",
                headers: {
                    "Content-Type": "application/json"
                },
                success: function(response) {
                    console.log("Response:", response);
                    $(targetElement).empty();

                    let tableHtml = `
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Shift Name</th>
                                <th>Total</th>
                                <th>Present</th>
                                <th>Weekly Off</th>
                                <th>Late Punch</th>
                                <th>On Leave</th>
                            </tr>
                        </thead>
                        <tbody>`;

                    response.forEach(record => {
                        const { Shift_Name, Present, OnWeeklyOff, LatePunch, OnLeave, TotalEmployees } = record;

                        tableHtml += `<tr>
                            <td><span class="font-weight-bold">${Shift_Name}</span></td>
                            <td>${TotalEmployees}</td>
                            <td><span class="badge-present">${Present}</span></td>
                            <td><span class="badge-weekly-off">${OnWeeklyOff}</span></td>
                            <td><span class="badge-late">${LatePunch}</span></td>
                            <td><span class="badge-leave">${OnLeave}</span></td>
                        </tr>`;
                    });

                    tableHtml += `</tbody></table>`;
                    $(targetElement).html(tableHtml);
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        }

        // Employee Type Wise Data
        function renderEmployeeTypeWiseData(apiUrl) {
            $.ajax({
                url: apiUrl,
                type: "GET",
                dataType: "json",
                headers: {
                    "Content-Type": "application/json"
                },
                success: function(response) {
                    console.log("Response:", response);
                    $("#employeeTypeResult").empty();

                    let tableHtml = `
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Total</th>
                                <th>Present</th>
                                <th>Weekly Off</th>
                                <th>Late Punch</th>
                                <th>On Leave</th>
                            </tr>
                        </thead>
                        <tbody>`;

                    response.forEach(record => {
                        const { EmpTypeName, TotalEmployees, Present, OnWeeklyOff, LatePunch, OnLeave } = record;

                        tableHtml += `<tr>
                            <td><span class="font-weight-bold">${EmpTypeName}</span></td>
                            <td>${TotalEmployees}</td>
                            <td><span class="badge-present">${Present}</span></td>
                            <td><span class="badge-weekly-off">${OnWeeklyOff}</span></td>
                            <td><span class="badge-late">${LatePunch}</span></td>
                            <td><span class="badge-leave">${OnLeave}</span></td>
                        </tr>`;
                    });

                    tableHtml += `</tbody></table>`;
                    $("#result_Get_Employee_Type_Wise_Current_Date_Data").html(tableHtml);
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        }

        // Late Comers
        function Late_commer_data_function(apiUrl) {
            $.ajax({
                url: apiUrl,
                type: "GET",
                dataType: "json",
                headers: {
                    "Content-Type": "application/json"
                },
                success: function(response) {
                    console.log("Response:", response);

                    let tableHtml = `
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Employee ID</th>
                                <th>Name</th>
                                <th>In Time</th>
                                <th>Employee Type</th>
                                <th>Shift</th>
                                <th>Department</th>
                            </tr>
                        </thead>
                        <tbody>`;

                    response.forEach(record => {
                        const {
                            Department,
                            EmpTypeName,
                            Shift_Name,
                            f_name,
                            m_name,
                            l_name,
                            Employee_id,
                            in_time
                        } = record;

                        tableHtml += `<tr>
                            <td><span class="text-primary">${Employee_id}</span></td>
                            <td><span class="font-weight-bold">${f_name || " "} ${m_name || " "} ${l_name || " "}</span></td>
                            <td><span class="badge-late">${in_time}</span></td>
                            <td>${EmpTypeName}</td>
                            <td>${Shift_Name}</td>
                            <td>${Department}</td>
                        </tr>`;
                    });

                    tableHtml += `</tbody></table>`;
                    $("#Late_commer_data_table").html(tableHtml);
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        }

        // Absent List
        function absent_list(apiUrl) {
            $.ajax({
                url: apiUrl,
                type: "GET",
                dataType: "json",
                headers: {
                    "Content-Type": "application/json"
                },
                success: function(response) {
                    console.log("Response: absent", response);

                    let tableHtml = `
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Employee ID</th>
                                <th>Shift Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>`;

                    response.data.forEach(record => {
                        const {
                            Shift_name,
                            name,
                            EmployeeID
                        } = record;

                        tableHtml += `<tr>
                            <td><span class="font-weight-bold">${name}</span></td>
                            <td><span class="text-primary">${EmployeeID}</span></td>
                            <td>${Shift_name}</td>
                            <td><span class="badge-absent">Absent</span></td>
                        </tr>`;
                    });

                    tableHtml += `</tbody></table>`;
                    $("#result_absent").html(tableHtml);
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        }

        // Present List
        function present_list(apiUrl) {
            $.ajax({
                url: apiUrl,
                type: "GET",
                dataType: "json",
                headers: {
                    "Content-Type": "application/json"
                },
                success: function(response) {
                    console.log("Response: present", response);

                    let tableHtml = `
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Present Days</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>`;

                    response.data.forEach(record => {
                        const {
                            Present,
                            name
                        } = record;

                        tableHtml += `<tr>
                            <td><span class="font-weight-bold">${name}</span></td>
                            <td>${Present}</td>
                            <td><span class="badge-present">Regular</span></td>
                        </tr>`;
                    });

                    tableHtml += `</tbody></table>`;
                    $("#result_present").html(tableHtml);
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        }

        // Default Absent
        function defult_absent(apiUrl) {
            $.ajax({
                url: apiUrl,
                type: "GET",
                dataType: "json",
                headers: {
                    "Content-Type": "application/json"
                },
                success: function(response) {
                    console.log("Response: default absent", response);

                    let tableHtml = `
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Employee ID</th>
                                <th>Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>`;

                    response.data.forEach(record => {
                        const {
                            name,
                            EmployeeID
                        } = record;

                        tableHtml += `<tr>
                            <td><span class="text-primary">${EmployeeID}</span></td>
                            <td><span class="font-weight-bold">${name}</span></td>
                            <td><span class="badge-absent">Default Absent</span></td>
                        </tr>`;
                    });

                    tableHtml += `</tbody></table>`;
                    $("#result_defult_absent").html(tableHtml);
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        }

        // OT Data
        function OTDataFunction(apiUrl) {
            $.ajax({
                url: apiUrl,
                type: "GET",
                dataType: "json",
                headers: {
                    "Content-Type": "application/json"
                },
                success: function(response) {
                    console.log("Response: OT", response);

                    let tableHtml = `
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Department</th>
                                <th>OT Hours</th>
                                <th>OT Minutes</th>
                                <th>Total Time</th>
                            </tr>
                        </thead>
                        <tbody>`;

                    response.forEach(record => {
                        const {
                            Department_name,
                            OTHrs,
                            OTMin
                        } = record;

                        // Calculate total time in hours and minutes
                        const totalHours = parseInt(OTHrs);
                        const totalMinutes = parseInt(OTMin);
                        const formattedTime = `${totalHours}h ${totalMinutes}m`;

                        tableHtml += `<tr>
                            <td><span class="font-weight-bold">${Department_name}</span></td>
                            <td>${totalHours}</td>
                            <td>${totalMinutes}</td>
                            <td><span class="badge badge-info">${formattedTime}</span></td>
                        </tr>`;
                    });


                    tableHtml += `</tbody></table>`;
                    $("#OTDataTable").html(tableHtml);
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        }

        // Pie Charts
        function renderEmployeeTypeWisePieCharts(apiUrl) {
            $.ajax({
                url: apiUrl,
                type: "GET",
                dataType: "json",
                headers: {
                    "Content-Type": "application/json"
                },
                success: function(response) {
                    console.log("Response:", response);

                    // Clear the container for new charts
                    $("#pieChartsContainer").empty();

                    // Loop through each employee type data
                    response.forEach((record, index) => {
                        const { EmpTypeName, Present, OnWeeklyOff, OnLeave, Absent, TotalEmployees } = record;

                        // Create a container and canvas for each chart
                        const chartId = `employeeTypePieChart_${index}`;
                        $("#pieChartsContainer").append(`
                            <div class="col-md-3 chart-item">
                                <div class="card shadow">
                                    <div class="card-header bg-light">
                                        <h5>${EmpTypeName} (Total: ${TotalEmployees})</h5>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="${chartId}"></canvas>
                                    </div>
                                </div>
                            </div>
                        `);

                        // Render the pie chart
                        const ctx = document.getElementById(chartId).getContext("2d");
                        new Chart(ctx, {
                            type: "pie",
                            data: {
                                labels: ["Present", "On Weekly Off", "On Leave", "Absent"],
                                datasets: [{
                                    data: [Present, OnWeeklyOff, OnLeave, Absent],
                                    backgroundColor: [
                                        "#28a745", "#17a2b8", "#ffc107", "#dc3545"
                                    ],
                                    hoverOffset: 4
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(tooltipItem) {
                                                return `${tooltipItem.label}: ${tooltipItem.raw}`;
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        }

        // Initialize functions on document ready
        $(document).ready(function() {
            attendanceDataSet('{{url("/all-attandance-detail-with-let-api/")}}');
            renderEmployeeTypeWiseData('{{url("/Get-Employee-Type-Wise-Current-Date-Data-api/")}}');
            Late_commer_data_function('{{url("/Late-Commer-Current-Date-Data-api/")}}');
            absent_list('{{url("/absent-employee-list/")}}');
            present_list('{{url("/attandance_100_top_10_list_api/")}}');
            defult_absent('{{url("/Default-Absentees-By-Month/")}}');
            OTDataFunction('{{url("/Daily-Ot-Hrs-api/")}}');
            renderEmployeeTypeWisePieCharts('{{url("/Get-Employee-Type-Wise-Current-Date-Data-api/")}}');

        });
    </script>
@stop

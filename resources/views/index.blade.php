@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@endsection

@section('content')

<div class="row">
    @if ($view_home_page_options == 1)
        <!-- Employees Card -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-purple">
                <div class="inner">
                    <h3>{{$employee_number}}</h3>
                    <p>Employees</p>
                </div>
                <a href="{{url('employees')}}" class="small-box-footer">View Table <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- Attendance Card -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-orange">
                <div class="inner">
                    <h3>P:{{$Present_number}} A:{{$Absent_number}}</h3>
                    <p>Attendance</p>
                </div>
                <a href="{{url('attendance-records')}}" class="small-box-footer">View Table <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- Total Leave Card -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{$leave_number}}</h3>
                    <p>Total Leave</p>
                </div>
                <a href="{{url('total-leave')}}" class="small-box-footer">View Table <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- Late Entry Card -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3>{{$LatePunch}}</h3>
                    <p>Late Entry</p>
                </div>
                <a href="{{url('all-attendance')}}" class="small-box-footer">View Table <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    @endif
</div>

<!-- Tables in col-md-6 -->
<div class="row">
    <!-- Shift Wise -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h3 class="card-title">Shift Wise</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Shift Name</th>
                            <th>Total</th>
                            <th>Present</th>
                            <th>On Weekly Off</th>
                            <th>Late Punch</th>
                            <th>On Leave</th>
                        </tr>
                    </thead>
                    <tbody id="shift_wise_body">
                        <tr><td colspan="6" class="text-center">Loading...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Employee Type Wise -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h3 class="card-title">Employee Type Wise</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Total</th>
                            <th>Present</th>
                            <th>On Weekly Off</th>
                            <th>Late Punch</th>
                            <th>On Leave</th>
                        </tr>
                    </thead>
                    <tbody id="employeeTypeResult">
                        <tr><td colspan="6" class="text-center">Loading...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Late Comers -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h3 class="card-title">Late Comers</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="Late_commer_data_table">
                    <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>In Time</th>
                            <th>Employee Type</th>
                            <th>Shift Name</th>
                            <th>Department</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6" class="text-center">No Data Available</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- OT Hrs Department Wise -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h3 class="card-title">OT Hrs Department Wise</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Department Name</th>
                            <th>Overtime Hours</th>
                            <th>Overtime Minutes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="3" class="text-center">No Data Available</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Absent List -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h3 class="card-title">Absent List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="absent_list_table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Employee ID</th>
                            <th>Shift Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="3" class="text-center">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Top 10 Present List -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h3 class="card-title">Top 10 Present List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Present</th>
                        </tr>
                    </thead>
                    <tbody id="present_list_body">
                        <tr><td colspan="2" class="text-center">Loading...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!--Default Absent List -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h3 class="card-title">Default Absent</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="default_absent_table">
                    <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2" class="text-center">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>




<!-- Pie Charts for Employee Types -->
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h3 class="card-title">Casual (Total Employees: 9)</h3>
            </div>
            <div class="card-body">
                <canvas id="casualChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h3 class="card-title">Daily Wages (Total Employees: 1)</h3>
            </div>
            <div class="card-body">
                <canvas id="dailyWagesChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h3 class="card-title">Full Time (Total Employees: 7)</h3>
            </div>
            <div class="card-body">
                <canvas id="fullTimeChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h3 class="card-title">Staff (Total Employees: 5)</h3>
            </div>
            <div class="card-body">
                <canvas id="staffChart"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function createPieChart(canvasId, present, weeklyOff, onLeave, absent) {
        new Chart(document.getElementById(canvasId), {
            type: 'pie',
            data: {
                labels: ['Present', 'On Weekly Off', 'On Leave', 'Absent'],
                datasets: [{
                    data: [present, weeklyOff, onLeave, absent],
                    backgroundColor: ['#ff0000', '#00c0ef', '#00a65a', '#9164ff']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    // Generate charts with data
    createPieChart('casualChart', 0, 0, 0, 9);
    createPieChart('dailyWagesChart', 0, 0, 0, 1);
    createPieChart('fullTimeChart', 0, 0, 0, 7);
    createPieChart('staffChart', 0, 0, 0, 5);

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

                const $tbody = $("#Late_commer_data_table tbody");
                $tbody.empty(); // Clear previous data

                if (response.length === 0) {
                    $tbody.html('<tr><td colspan="6" class="text-center">No Data Available</td></tr>');
                    return;
                }

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

                    const row = `
                        <tr>
                            <td>${Employee_id}</td>
                            <td>${f_name || ""} ${m_name || ""} ${l_name || ""}</td>
                            <td>${in_time}</td>
                            <td>${EmpTypeName}</td>
                            <td>${Shift_Name}</td>
                            <td>${Department}</td>
                        </tr>
                    `;

                    $tbody.append(row);
                });
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
            }
        });
    }

    absent_list('{{url("/absent-employee-list/")}}')
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

                const $tbody = $("#absent_list_table tbody");
                $tbody.empty(); // Clear existing rows

                if (!response.data || response.data.length === 0) {
                    $tbody.html('<tr><td colspan="3" class="text-center">No Data Available</td></tr>');
                    return;
                }

                response.data.forEach(record => {
                    const { Shift_name, name, EmployeeID } = record;

                    const row = `
                        <tr>
                            <td>${name}</td>
                            <td>${EmployeeID}</td>
                            <td>${Shift_name}</td>
                        </tr>
                    `;
                    $tbody.append(row);
                });
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                $("#absent_list_table tbody").html('<tr><td colspan="3" class="text-center text-danger">Error loading data</td></tr>');
            }
        });
    }

    defult_absent('{{url("/Default-Absentees-By-Month/")}}')
    function defult_absent(apiUrl) {
        $.ajax({
            url: apiUrl,
            type: "GET",
            dataType: "json",
            headers: {
                "Content-Type": "application/json"
            },
            success: function(response) {
                console.log("Response: absent", response);

                const $tbody = $("#default_absent_table tbody");
                $tbody.empty(); // Clear existing data

                if (!response.data || response.data.length === 0) {
                    $tbody.html('<tr><td colspan="2" class="text-center">No Data Available</td></tr>');
                    return;
                }

                response.data.forEach(record => {
                    const { name, EmployeeID } = record;

                    const row = `
                        <tr>
                            <td>${EmployeeID}</td>
                            <td>${name}</td>
                        </tr>
                    `;

                    $tbody.append(row);
                });
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                $("#default_absent_table tbody").html('<tr><td colspan="2" class="text-center text-danger">Error loading data</td></tr>');
            }
        });
    }

    present_list('{{url("/attandance_100_top_10_list_api/")}}')
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

                const $tbody = $("#present_list_body");
                $tbody.empty();

                if (!response.data || response.data.length === 0) {
                    $tbody.html('<tr><td colspan="2" class="text-center">No Data Available</td></tr>');
                    return;
                }

                response.data.forEach(record => {
                    const { name, Present } = record;

                    const row = `
                        <tr>
                            <td>${name}</td>
                            <td>${Present}</td>
                        </tr>
                    `;

                    $tbody.append(row);
                });
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                $("#present_list_body").html('<tr><td colspan="2" class="text-center text-danger">Error loading data</td></tr>');
            }
        });
    }

    renderEmployeeTypeWiseData("{{url("/Get-Employee-Type-Wise-Current-Date-Data-api/")}}");
    function renderEmployeeTypeWiseData(apiUrl) {
        $.ajax({
            url: apiUrl,
            type: "GET",
            dataType: "json",
            headers: {
                "Content-Type": "application/json"
            },
            success: function(response) {
                console.log("API URL:", apiUrl);
                console.log("Response:", response);

                let tableRows = "";

                response.forEach(record => {
                    const { EmpTypeName, TotalEmployees, Present, OnWeeklyOff, LatePunch, OnLeave } = record;

                    tableRows += `
                        <tr>
                            <td>${EmpTypeName}</td>
                            <td>${TotalEmployees}</td>
                            <td>${Present}</td>
                            <td>${OnWeeklyOff}</td>
                            <td>${LatePunch}</td>
                            <td>${OnLeave}</td>
                        </tr>`;
                });

                $("#employeeTypeResult").html(tableRows);
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
            }
        });
    }

    attendanceDataSet('{{url("/all-attandance-detail-with-let-api/")}}');
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
                const $tbody = $(targetElement);
                $tbody.empty();

                if (!response || response.length === 0) {
                    $tbody.html('<tr><td colspan="6" class="text-center">No Data Available</td></tr>');
                    return;
                }

                response.forEach(record => {
                    const { Shift_Name, TotalEmployees, Present, OnWeeklyOff, LatePunch, OnLeave } = record;

                    const row = `
                        <tr>
                            <td>${Shift_Name}</td>
                            <td>${TotalEmployees}</td>
                            <td>${Present}</td>
                            <td>${OnWeeklyOff}</td>
                            <td>${LatePunch}</td>
                            <td>${OnLeave}</td>
                        </tr>
                    `;

                    $tbody.append(row);
                });
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                $(targetElement).html('<tr><td colspan="6" class="text-center text-danger">Error loading data</td></tr>');
            }
        });
    }


</script>
@endsection

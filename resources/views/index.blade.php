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
                <a href="{{url('all-attendance')}}" class="small-box-footer">View Table <i class="fas fa-arrow-circle-right"></i></a>
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
                    <tbody>
                        <tr>
                            <td>Day Shift</td>
                            <td>21</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>Morning</td>
                            <td>1</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
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
                    <tbody>
                        <tr>
                            <td>Casual</td>
                            <td>9</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>Daily Wages</td>
                            <td>1</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>Full Time</td>
                            <td>7</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>Staff</td>
                            <td>5</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
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
                <table class="table table-bordered">
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
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h3 class="card-title">Absent List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Employee ID</th>
                            <th>Shift Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Aadarsh Namdev</td>
                            <td>18</td>
                            <td>Day Shift</td>
                        </tr>
                        <tr>
                            <td>Afraan Khatton</td>
                            <td>4</td>
                            <td>Day Shift</td>
                        </tr>
                        <tr>
                            <td>...</td>
                            <td>...</td>
                            <td>...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Top 10 Present List -->
    <div class="col-md-6">
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
                    <tbody>
                        <tr><td>John Doe</td><td>10</td></tr>
                        <tr><td>Jane Smith</td><td>9</td></tr>
                        <tr><td>Raj Patel</td><td>8</td></tr>
                        <tr><td>...</td><td>...</td></tr> <!-- Add real data -->
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




</script>
@endsection

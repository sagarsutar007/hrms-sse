@extends('adminlte::page')

@section('title', 'Admin Settings')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="{{url('css/common_class.css')}}">
<link rel="stylesheet" href="{{url('css/forms.css')}}">
<style>
    .card-admin {
        transition: all 0.3s;
        cursor: pointer;
        height: 100%;
    }

    .card-admin:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,.12), 0 4px 8px rgba(0,0,0,.06);
    }

    .nav-tabs .nav-link.active {
        background-color: #007bff;
        color: white;
    }
</style>
@stop

@section('content_header')
<div class="d-flex justify-content-between">
    <h1><i class="fas fa-cog"></i> Admin Settings</h1>
</div>
@stop

@section('content')
<div class="container-fluid">
    @isset($roler_permissions)
        @foreach ($roler_permissions as $roler_permis)
            @if ($roler_permis->role_name == 'Admin')
                <!-- Admin Permission Cards -->
                <div class="row">
                    <!-- Add Admin Card -->
                    @if ($roler_permis->Add_Admin == 1)
                    <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
                        <div class="card card-admin" onclick="location.href='{{url('add-admin')}}'">
                            <div class="card-body text-center">
                                <i class="fas fa-user-shield fa-3x mb-3 text-primary"></i>
                                <h5 class="card-title">Add Admin</h5>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Add HR Card -->
                    @if ($roler_permis->Add_HR == 1)
                    <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
                        <div class="card card-admin" onclick="location.href='{{url('add-HR')}}'">
                            <div class="card-body text-center">
                                <i class="fas fa-user-tie fa-3x mb-3 text-info"></i>
                                <h5 class="card-title">Add HR</h5>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Add Employee Card -->
                    @if ($roler_permis->Add_Employee == 1)
                    <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
                        <div class="card card-admin" onclick="location.href='{{url('registration')}}'">
                            <div class="card-body text-center">
                                <i class="fas fa-user-plus fa-3x mb-3 text-success"></i>
                                <h5 class="card-title">Add Employee</h5>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Add Guard Card -->
                    @if ($roler_permis->Add_Guard == 1)
                    <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
                        <div class="card card-admin" onclick="location.href='{{url('add-guard')}}'">
                            <div class="card-body text-center">
                                <i class="fas fa-user-secret fa-3x mb-3 text-warning"></i>
                                <h5 class="card-title">Add Guard</h5>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Role Settings Cards -->
                    @foreach ($roler_permissions as $rol_permiss)
                        @if ($rol_permiss->role_name != "Super admin")
                        <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
                            <div class="card card-admin" onclick="location.href='{{url('admin-settings')}}/{{$rol_permiss->role_name}}'">
                                <div class="card-body text-center">
                                    <i class="fas fa-users-cog fa-3x mb-3 text-secondary"></i>
                                    <h5 class="card-title">{{$rol_permiss->role_name}} Settings</h5>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach

                    <!-- All Users Card -->
                    <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
                        <div class="card card-admin" onclick="location.href='{{url('all-admins')}}'">
                            <div class="card-body text-center">
                                <i class="fas fa-users fa-3x mb-3 text-dark"></i>
                                <h5 class="card-title">All Users</h5>
                            </div>
                        </div>
                    </div>

                    <!-- All HRs Card -->
                    <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
                        <div class="card card-admin" onclick="location.href='{{url('all-attendance')}}'">
                            <div class="card-body text-center">
                                <i class="fas fa-user-tie fa-3x mb-3 text-info"></i>
                                <h5 class="card-title">All HRs</h5>
                            </div>
                        </div>
                    </div>

                    <!-- All Employees Card -->
                    <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
                        <div class="card card-admin">
                            <div class="card-body text-center">
                                <i class="fas fa-id-card fa-3x mb-3 text-success"></i>
                                <h5 class="card-title">All Employees</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Add Role Card -->
                    <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
                        <div class="card card-admin" data-toggle="modal" data-target="#addRoleModal">
                            <div class="card-body text-center">
                                <i class="fas fa-user-tag fa-3x mb-3 text-danger"></i>
                                <h5 class="card-title">Add Role</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Add Shift Card -->
                    <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
                        <div class="card card-admin" data-toggle="modal" data-target="#addShiftModal">
                            <div class="card-body text-center">
                                <i class="fas fa-clock fa-3x mb-3 text-purple"></i>
                                <h5 class="card-title">Add Shift</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Add Employee Type Card -->
                    <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
                        <div class="card card-admin" data-toggle="modal" data-target="#addEmployeeTypeModal">
                            <div class="card-body text-center">
                                <i class="fas fa-user-edit fa-3x mb-3 text-info"></i>
                                <h5 class="card-title">Add Employee Type</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Change Password Card -->
                    <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
                        <div class="card card-admin" data-toggle="modal" data-target="#changePasswordModal">
                            <div class="card-body text-center">
                                <i class="fas fa-key fa-3x mb-3 text-warning"></i>
                                <h5 class="card-title">Change Password</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tables Section -->
                <div class="card mt-4">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Manage Data</h3>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="role-tab" data-toggle="tab" href="#role" role="tab" aria-controls="role" aria-selected="true">Role</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="shift-tab" data-toggle="tab" href="#shift" role="tab" aria-controls="shift" aria-selected="false">Shift</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="employee-type-tab" data-toggle="tab" href="#employee-type" role="tab" aria-controls="employee-type" aria-selected="false">Employee Type</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-3" id="myTabContent">
                            <!-- Role Table -->
                            <div class="tab-pane fade show active" id="role" role="tabpanel" aria-labelledby="role-tab">
                                <table class="table table-bordered table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Roles</th>
                                            <th width="100">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($role_masrer as $role_m)
                                            @if ($role_m->id <= session('role_number'))
                                                <!-- Skip roles with lower IDs than session role number -->
                                            @else
                                                <tr>
                                                    <td>{{$role_m->roles}}</td>
                                                    <td>
                                                        <a href="{{url('/delete-role')}}/{{$role_m->id}}" class="btn btn-sm btn-danger">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </a>
                                                        <a href="{{url('/edit-role')}}/{{$role_m->id}}" class="btn btn-sm btn-primary">
                                                            <i class="fa-solid fa-pencil"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Shift Table -->
                            <div class="tab-pane fade" id="shift" role="tabpanel" aria-labelledby="shift-tab">
                                <table class="table table-bordered table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Shift Name</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Lunch Start Time</th>
                                            <th>Lunch End Time</th>
                                            <th>Shift Hours</th>
                                            <th width="100">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($shift_master as $Shift_m)
                                            <tr>
                                                <td>{{$Shift_m->Shift_Name}}</td>
                                                <td>{{$Shift_m->Shift_Start_Time}}</td>
                                                <td>{{$Shift_m->Shift_End_Time}}</td>
                                                <td>{{$Shift_m->Lunch_Start_Time}}</td>
                                                <td>{{$Shift_m->Lunch_end_Time}}</td>
                                                <td>{{$Shift_m->Shift_hours}}</td>
                                                <td>
                                                    <a href="{{url('/delete-shift')}}/{{$Shift_m->id}}" class="btn btn-sm btn-danger">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </a>
                                                    <a href="{{url('/edit-shift')}}/{{$Shift_m->id}}" class="btn btn-sm btn-primary">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Employee Type Table -->
                            <div class="tab-pane fade" id="employee-type" role="tabpanel" aria-labelledby="employee-type-tab">
                                <table class="table table-bordered table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Employee Type</th>
                                            <th>Daily Wages</th>
                                            <th>Eligible For Over Time</th>
                                            <th width="100">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employee_type_master as $emp_m)
                                            <tr>
                                                <td>{{$emp_m->EmpTypeName}}</td>
                                                <td>{{$emp_m->Daily_Wages}}</td>
                                                <td>
                                                    @if ($emp_m->Eligible_for_OverTime == 1)
                                                        <span class="badge badge-success">Yes</span>
                                                    @else
                                                        <span class="badge badge-danger">No</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{url('/delete-employee-type')}}/{{$emp_m->id}}" class="btn btn-sm btn-danger">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </a>
                                                    <a href="{{url('/edit-employee-type')}}/{{$emp_m->id}}" class="btn btn-sm btn-primary">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MODALS START -->

                <!-- Add Role Modal -->
                <div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog" aria-labelledby="addRoleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="{{route('add_role_form')}}" method="post">
                                @csrf
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="addRoleModalLabel"><i class="fas fa-user-tag"></i> Add Role</h5>
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="role" class="font-weight-bold">Role*</label>
                                        <input type="text" class="form-control" id="role" placeholder="Role" name="role" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Add Employee Type Modal -->
                <div class="modal fade" id="addEmployeeTypeModal" tabindex="-1" role="dialog" aria-labelledby="addEmployeeTypeModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="{{route('add_employee_type')}}" method="post">
                                @csrf
                                <div class="modal-header bg-info text-white">
                                    <h5 class="modal-title" id="addEmployeeTypeModalLabel"><i class="fas fa-user-edit"></i> Add Employee Type</h5>
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="emp_m" class="font-weight-bold">Employee Type*</label>
                                        <input type="text" class="form-control" id="emp_m" placeholder="Employee Type" name="emp_m" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="Daily_Wages" class="font-weight-bold">Daily Wages*</label>
                                        <input type="text" class="form-control" id="Daily_Wages" placeholder="Daily Wages" name="Daily_Wages" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="Eligible_for_OverTime" class="font-weight-bold">Eligible for OverTime*</label>
                                        <select class="form-control" id="Eligible_for_OverTime" name="Eligible_for_OverTime" required>
                                            <option value="">Select Eligibility</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-info">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Add Shift Modal -->
                <div class="modal fade" id="addShiftModal" tabindex="-1" role="dialog" aria-labelledby="addShiftModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <form action="{{route('add_shift')}}" method="post">
                                @csrf
                                <div class="modal-header bg-purple text-white">
                                    <h5 class="modal-title" id="addShiftModalLabel"><i class="fas fa-clock"></i> Add Shift</h5>
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Shift_Name" class="font-weight-bold">Shift Name*</label>
                                                <input type="text" class="form-control" id="Shift_Name" placeholder="Shift Name" name="Shift_Name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Shift_Start_Time" class="font-weight-bold">Shift Start Time*</label>
                                                <input type="time" class="form-control" id="Shift_Start_Time" name="Shift_Start_Time" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Shift_End_Time" class="font-weight-bold">Shift End Time*</label>
                                                <input type="time" class="form-control" id="Shift_End_Time" name="Shift_End_Time" onblur="calTimeInHr()" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Lunch_Start_Timee" class="font-weight-bold">Lunch Start Time*</label>
                                                <input type="time" class="form-control" id="Lunch_Start_Timee" name="Lunch_Start_Timee" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Lunch_end_Time" class="font-weight-bold">Lunch End Time*</label>
                                                <input type="time" class="form-control" id="Lunch_end_Time" name="Lunch_end_Time" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="totalHr" class="font-weight-bold">Shift Hours*</label>
                                                <input type="number" class="form-control" id="totalHr" name="Shift_hours" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-purple">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Change Password Modal -->
                <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="{{route('change_Password')}}" method="post">
                                @csrf
                                <div class="modal-header bg-warning text-white">
                                    <h5 class="modal-title" id="changePasswordModalLabel"><i class="fas fa-key"></i> Change Password</h5>
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="Employee_Id" class="font-weight-bold">Employee Id*</label>
                                        <select class="form-control" id="Employee_Id" name="Employee_Id" required>
                                            <option value="">Select User</option>
                                            @foreach ($users as $usr)
                                                <option value="{{$usr->Employee_id}}">{{$usr->Employee_id}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Password" class="font-weight-bold">Password*</label>
                                                <input type="password" class="form-control" id="Password" placeholder="Password" name="Password" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="CPassword" class="font-weight-bold">Confirm Password*</label>
                                                <input type="password" class="form-control" id="CPassword" placeholder="Confirm Password" name="CPassword" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-warning">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            @endif
        @endforeach
    @endisset
</div>
@stop

@section('js')
<script>
    $(function () {
        // Initialize DataTables for better table functionality
        $('table').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });

    // Calculate time difference for shifts
    function calTimeInHr() {
        var startTime = document.getElementById('Shift_Start_Time').value;
        var endTime = document.getElementById('Shift_End_Time').value;
        var difference = timeDifference(startTime, endTime);
        document.getElementById('totalHr').value = parseFloat(difference).toFixed(2);
    }

    function timeDifference(startTime, endTime) {
        // Parse the time strings into Date objects
        var start = new Date(`01/01/2000 ${startTime}`);
        var end = new Date(`01/01/2000 ${endTime}`);
        // Calculate the difference in milliseconds
        var diffMs = end - start;
        // Convert milliseconds to hours
        var diffHours = diffMs / (1000 * 60 * 60);
        // Handle negative differences (if endTime is earlier in the day than startTime)
        if (diffHours < 0) {
            diffHours += 24;
        }
        return diffHours;
    }

    // Active Menu Highlight
    document.getElementById("Dashboard_li").classList.remove('active_menu');
    document.getElementById("Employees_li").classList.remove('active_menu');
    document.getElementById("Attendance_li").classList.remove('active_menu');
    document.getElementById("Add_Employee_li").classList.remove('active_menu');
    document.getElementById("Super_Admin_Settings").classList.add('active_menu');
    document.getElementById("Admin_Settings_li").classList.remove('active_menu');
    document.getElementById("HR_Settings_li").classList.remove('active_menu');
</script>
@stop

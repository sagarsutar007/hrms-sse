@extends('adminlte::page')

@section('title', 'HR Settings')

@section('content_header')
    <h1>HR Settings</h1>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{url('css/common_class.css')}}">
    <link rel="stylesheet" href="{{url('css/dashboard.css')}}">
    <link rel="stylesheet" href="{{ URL('css/add_user.css')}}">
    <link rel="stylesheet" href="{{ URL('css/users.css')}}">
    <link rel="stylesheet" href="{{ URL('css/forms.css')}}">
    <style>
        .card-hr {
            cursor: pointer;
            transition: transform 0.2s;
        }
        .card-hr:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.12);
        }
        .card-hr h4 {
            color: #605ca8;
        }
        .modal-header {
            background-color: #605ca8;
            color: white;
        }
        .btn-purple {
            background-color: #605ca8;
            color: white;
        }
        .btn-purple:hover {
            background-color: #514d94;
            color: white;
        }
    </style>
@stop

@section('content')
<div class="container-fluid">
    <!-- HR Quick Actions -->
    <div class="row">
        <div class="col-md-3">
            <div class="card card-hr" onclick="location.href='{{url('registration')}}'">
                <div class="card-body text-center">
                    <i class="fas fa-user-plus fa-3x mb-3"></i>
                    <h4>Add Employee</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-hr" onclick="$('#addRoleModal').modal('show')">
                <div class="card-body text-center">
                    <i class="fas fa-user-tag fa-3x mb-3"></i>
                    <h4>Add Role</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-hr" onclick="$('#addShiftModal').modal('show')">
                <div class="card-body text-center">
                    <i class="fas fa-clock fa-3x mb-3"></i>
                    <h4>Add Shift</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-hr" onclick="$('#changePasswordModal').modal('show')">
                <div class="card-body text-center">
                    <i class="fas fa-key fa-3x mb-3"></i>
                    <h4>Change Password</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog" aria-labelledby="addRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRoleModalLabel">Add Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('add_role_form')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="role">Role <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="role" name="role" placeholder="Enter role name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-purple">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Shift Modal -->
<div class="modal fade" id="addShiftModal" tabindex="-1" role="dialog" aria-labelledby="addShiftModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addShiftModalLabel">Add Shift</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('add_shift')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Shift_Name">Shift Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="Shift_Name" name="Shift_Name" placeholder="Enter shift name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Shift_Start_Time">Shift Start Time <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" id="Shift_Start_Time" name="Shift_Start_Time" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Shift_End_Time">Shift End Time <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" id="Shift_End_Time" name="Shift_End_Time" onblur="calTimeInHr()" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Lunch_Start_Timee">Lunch Start Time <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" id="Lunch_Start_Timee" name="Lunch_Start_Timee" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Lunch_end_Time">Lunch End Time <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" id="Lunch_end_Time" name="Lunch_end_Time" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="totalHr">Shift Hours <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="totalHr" name="Shift_hours" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-purple">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('change_Password')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Employee_Id">Employee ID <span class="text-danger">*</span></label>
                        <select class="form-control" id="Employee_Id" name="Employee_Id" required>
                            <option value="">Select User</option>
                            @foreach ($users as $usr)
                                <option value="{{$usr->Employee_id}}">{{$usr->Employee_id}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Password">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="Password" name="Password" required>
                    </div>
                    <div class="form-group">
                        <label for="CPassword">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="CPassword" name="CPassword" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-purple">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    function calTimeInHr(){
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
</script>
@stop

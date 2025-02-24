@extends('adminlte::page')

@section('title', 'Settings')

@section('content_header')
    <h1>Settings</h1>
@stop

@section('content')
<div class="container">
    <!-- Buttons Section -->
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="btn-group">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">Add Users</button>
                <button class="btn btn-secondary" onclick="window.location.href='/all-users'">
                    All Users
                </button>
                <button class="btn btn-info">Department</button>
            </div>
            <div class="btn-group ml-2">
                <button class="btn btn-primary">Admin Settings</button>
                <button class="btn btn-secondary">Add Role</button>
            </div>
            <div class="btn-group ml-2">
                <button class="btn btn-primary">Employee Settings</button>
                <button class="btn btn-secondary">Add Leave Master</button>
            </div>
            <div class="btn-group ml-2">
                <button class="btn btn-primary">Guard Settings</button>
                <button class="btn btn-secondary">Add Shift</button>
            </div>
            <div class="btn-group ml-2">
                <button class="btn btn-primary">HR Settings</button>
                <button class="btn btn-secondary">Add Employee Type</button>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs" id="settingsTab">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#role">Role</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#shift">Shift</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#employeeType">Employee Type</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#department">Department Master</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#leaveMaster">Leave Master</a></li>
    </ul>

    <div class="tab-content">
        <!-- Role Tab -->
        <div id="role" class="tab-pane fade show active mt-3">
            <div class="card">
                <div class="card-header bg-primary text-white">Role Management</div>
                <div class="card-body">
                    <p>This section is for managing roles.</p>
                </div>
            </div>
        </div>

        <!-- Shift Tab -->
        <div id="shift" class="tab-pane fade mt-3">
            <div class="card">
                <div class="card-header bg-primary text-white">Shift Management</div>
                <div class="card-body">
                    <p>This section is for managing shifts.</p>
                </div>
            </div>
        </div>

        <!-- Employee Type Tab -->
        <div id="employeeType" class="tab-pane fade mt-3">
            <div class="card">
                <div class="card-header bg-primary text-white">Employee Type</div>
                <div class="card-body">
                    <p>This section is for managing employee types.</p>
                </div>
            </div>
        </div>

        <!-- Department Master Tab -->
        <div id="department" class="tab-pane fade mt-3">
            <div class="card">
                <div class="card-header bg-primary text-white">Department Master</div>
                <div class="card-body">
                    <p>This section is for managing departments.</p>
                </div>
            </div>
        </div>

        <!-- Leave Master Tab -->
        <div id="leaveMaster" class="tab-pane fade mt-3">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">Leave Master</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Leave Type</th>
                                <th>Short Name</th>
                                <th>Payment Status</th>
                                <th>Color</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Sick Leave</td>
                                <td>SL</td>
                                <td>Paid</td>
                                <td><span class="badge" style="background-color: #d22d2d;">#d22d2d</span></td>
                                <td>
                                    <a href="#" class="text-danger delete-btn"><i class="fas fa-trash"></i></a>
                                    <a href="#" class="text-primary ml-2 edit-btn" data-toggle="modal" data-target="#editLeaveModal"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>Casual Leave</td>
                                <td>CL</td>
                                <td>Unpaid</td>
                                <td><span class="badge" style="background-color: #ff00d0;">#ff00d0</span></td>
                                <td>
                                    <a href="#" class="text-danger delete-btn"><i class="fas fa-trash"></i></a>
                                    <a href="#" class="text-primary ml-2 edit-btn" data-toggle="modal" data-target="#editLeaveModal"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Starts --}}

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add Users</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>User Name *</label>
                            <input type="text" class="form-control" placeholder="User Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Email Id *</label>
                            <input type="email" class="form-control" placeholder="Email Id">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Mobile Number *</label>
                            <input type="text" class="form-control" placeholder="Mobile Number">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Role *</label>
                            <select class="form-control">
                                <option>Select Role</option>
                                <option>Super Admin</option>
                                <option>Admin</option>
                                <option>HR</option>
                                <option>Guard</option>
                                <option>Employee</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Password *</label>
                            <input type="password" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Confirm Password *</label>
                            <input type="password" class="form-control" placeholder="Confirm Password">
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Leave Modal -->
<div class="modal fade" id="editLeaveModal" tabindex="-1" aria-labelledby="editLeaveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLeaveModalLabel">Edit Leave</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label>Leave Type</label>
                        <input type="text" class="form-control" value="Sick Leave">
                    </div>
                    <div class="form-group">
                        <label>Short Name</label>
                        <input type="text" class="form-control" value="SL">
                    </div>
                    <div class="form-group">
                        <label>Payment Status</label>
                        <select class="form-control">
                            <option selected>Paid</option>
                            <option>Unpaid</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Color</label>
                        <input type="color" class="form-control" value="#d22d2d">
                    </div>
                    <button type="button" class="btn btn-primary btn-block">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <style>
        .btn-group {
            margin-bottom: 10px;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .badge {
            padding: 5px 10px;
            font-size: 14px;
        }
    </style>
@stop

@section('js')
<script>
    $(document).ready(function() {
        $('.delete-btn').click(function(e) {
            e.preventDefault();
            alert("Delete action triggered!");
        });

        $('.edit-btn').click(function() {
            $('#editLeaveModal').modal('show');
        });
    });
</script>
@stop

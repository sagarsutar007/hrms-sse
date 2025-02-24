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
                <button class="btn btn-info" data-toggle="modal" data-target="#addDepartmentModal">Department</button>
            </div>
            <div class="btn-group ml-2">
                <button class="btn btn-primary" onclick="window.location.href='/admin-settings/{role_name}'">Admin Settings</button>
                <button class="btn btn-secondary" data-toggle="modal" data-target="#addRoleModal">Add Role</button>
            </div>
            <div class="btn-group ml-2">
                <button class="btn btn-primary" onclick="window.location.href='/admin-settings/{role_name}'">Employee Settings</button>
                <button class="btn btn-secondary" data-toggle="modal" data-target="#addLeaveMasterModal">
                    Add Leave Master
                </button>
            </div>
            <div class="btn-group ml-2">
                <button class="btn btn-primary" onclick="window.location.href='/admin-settings/{role_name}'">Guard Settings</button>
                <button class="btn btn-secondary" data-toggle="modal" data-target="#addShiftModal">
                    Add Shift
                </button>
            </div>
            <div class="btn-group ml-2">
                <button class="btn btn-primary" onclick="window.location.href='/admin-settings/{role_name}'">HR Settings</button>
                <button class="btn btn-secondary" data-toggle="modal" data-target="#addEmployeeTypeModal">
                    Add Employee Type
                </button>
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
                <div class="card-header bg-primary text-white">
                    Role Management
                </div>
                <div class="card-body">
                    <!-- Roles Table -->
                    <table class="table table-bordered text-center">
                        <thead class="thead-light">
                            <tr>
                                <th>Roles</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Admin</td>
                                <td>
                                    <i class="fas fa-trash text-danger delete-role" data-role="Admin" title="Delete"></i>
                                    <i class="fas fa-edit text-primary ml-2 edit-role" data-role="Admin" title="Edit"></i>
                                </td>
                            </tr>
                            <tr>
                                <td>HR</td>
                                <td>
                                    <i class="fas fa-trash text-danger delete-role" data-role="HR" title="Delete"></i>
                                    <i class="fas fa-edit text-primary ml-2 edit-role" data-role="HR" title="Edit"></i>
                                </td>
                            </tr>
                            <tr>
                                <td>Guard</td>
                                <td>
                                    <i class="fas fa-trash text-danger delete-role" data-role="Guard" title="Delete"></i>
                                    <i class="fas fa-edit text-primary ml-2 edit-role" data-role="Guard" title="Edit"></i>
                                </td>
                            </tr>
                            <tr>
                                <td>Employee</td>
                                <td>
                                    <i class="fas fa-trash text-danger delete-role" data-role="Employee" title="Delete"></i>
                                    <i class="fas fa-edit text-primary ml-2 edit-role" data-role="Employee" title="Edit"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Shift Tab -->
        <div id="shift" class="tab-pane fade mt-3">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    <span>Shift Management</span>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Shift Name</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Lunch Start Time</th>
                                <th>Lunch End Time</th>
                                <th>Shift Hours</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Day Shift</td>
                                <td>09:00:00</td>
                                <td>17:30:00</td>
                                <td>13:00:00</td>
                                <td>13:30:00</td>
                                <td>8.5</td>
                                <td>
                                <button class="btn btn-sm btn-danger delete-shift" data-toggle="modal" data-target="#deleteShiftModal">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <button class="btn btn-sm btn-primary edit-shift">
                                    <i class="fas fa-edit"></i>
                                </button>

                                </td>
                            </tr>
                            <tr>
                                <td>Morning</td>
                                <td>04:00:00</td>
                                <td>08:00:00</td>
                                <td>08:30:00</td>
                                <td>12:30:00</td>
                                <td>8.5</td>
                                <td>
                                    <button class="btn btn-sm btn-danger delete-shift"><i class="fas fa-trash"></i></button>
                                    <button class="btn btn-sm btn-primary edit-shift"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>General Shift</td>
                                <td>21:16:00</td>
                                <td>17:16:00</td>
                                <td>13:00:00</td>
                                <td>17:17:00</td>
                                <td>20</td>
                                <td>
                                    <button class="btn btn-sm btn-danger delete-shift"><i class="fas fa-trash"></i></button>
                                    <button class="btn btn-sm btn-primary edit-shift"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <!-- Employee Type Tab -->
        <div id="employeeType" class="tab-pane fade mt-3">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    <span>Employee Type</span>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Employee Type</th>
                                <th>Daily Wages</th>
                                <th>Eligible For Over Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Casual</td>
                                <td>Yes</td>
                                <td>Yes</td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-employee-type" data-toggle="modal" data-target="#updateEmployeeTypeModal">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-employee-type" data-toggle="modal" data-target="#deleteEmployeeTypeModal">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <!-- Repeat rows dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Department Master Tab -->
        <div id="department" class="tab-pane fade mt-3">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    <span>Department Master</span>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Department</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Maintenance</td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-department" data-toggle="modal" data-target="#updateDepartmentModal">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-department" data-toggle="modal" data-target="#deleteDepartmentModal">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <!-- Repeat rows dynamically for other departments -->
                        </tbody>
                    </table>
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

<!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRoleLabel">Add Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addRoleForm">
                    <div class="form-row d-flex align-items-end">
                        <!-- Role Dropdown -->
                        <div class="form-group col-md-8">
                            <label for="role">Role *</label>
                            <select id="role" name="role" class="form-control" required>
                                <option value="" disabled selected>Select Role</option>
                                <option value="super_admin">Super Admin</option>
                                <option value="admin">Admin</option>
                                <option value="hr">HR</option>
                                <option value="guard">Guard</option>
                                <option value="employee">Employee</option>
                            </select>
                        </div>
                        <!-- Submit Button -->
                        <div class="form-group col-md-4 text-right">
                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Leave Master Modal -->
<div class="modal fade" id="addLeaveMasterModal" tabindex="-1" aria-labelledby="addLeaveMasterLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLeaveMasterLabel">Add Leave Master</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="leaveMasterForm">
                    <div class="form-row">
                        <!-- Leave Type -->
                        <div class="form-group col-md-6">
                            <label for="leaveType">Leave Type*</label>
                            <input type="text" class="form-control" id="leaveType" placeholder="Leave Type" required>
                        </div>
                        <!-- Short Name -->
                        <div class="form-group col-md-6">
                            <label for="shortName">Short Name*</label>
                            <input type="text" class="form-control" id="shortName" placeholder="Short Name" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <!-- Payment Status -->
                        <div class="form-group col-md-6">
                            <label for="paymentStatus">Payment Status*</label>
                            <select id="paymentStatus" class="form-control" required>
                                <option value="" disabled selected>Payment Status</option>
                                <option value="paid">Paid</option>
                                <option value="unpaid">Unpaid</option>
                            </select>
                        </div>
                        <!-- Color Picker -->
                        <div class="form-group col-md-6">
                            <label for="colorPicker">Color*</label>
                            <input type="color" class="form-control" id="colorPicker" required>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Department Modal -->
<div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-labelledby="addDepartmentLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Department</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="addDepartmentForm">
                    <div class="form-group">
                        <label>Department *</label>
                        <input type="text" class="form-control" placeholder="Department" required>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Shift Modal -->
<div class="modal fade" id="addShiftModal" tabindex="-1" aria-labelledby="addShiftLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addShiftLabel">Add Shift</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="shiftForm">
                    <div class="form-row">
                        <!-- Shift Name -->
                        <div class="form-group col-md-6">
                            <label for="shiftName">Shift Name*</label>
                            <input type="text" class="form-control" id="shiftName" placeholder="Shift Name" required>
                        </div>
                        <!-- Shift Start Time -->
                        <div class="form-group col-md-6">
                            <label for="shiftStartTime">Shift Start Time*</label>
                            <input type="time" class="form-control" id="shiftStartTime" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <!-- Shift End Time -->
                        <div class="form-group col-md-6">
                            <label for="shiftEndTime">Shift End Time*</label>
                            <input type="time" class="form-control" id="shiftEndTime" required>
                        </div>
                        <!-- Lunch Start Time -->
                        <div class="form-group col-md-6">
                            <label for="lunchStartTime">Lunch Start Time*</label>
                            <input type="time" class="form-control" id="lunchStartTime" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <!-- Lunch End Time -->
                        <div class="form-group col-md-6">
                            <label for="lunchEndTime">Lunch End Time*</label>
                            <input type="time" class="form-control" id="lunchEndTime" required>
                        </div>
                        <!-- Shift Hours -->
                        <div class="form-group col-md-6">
                            <label for="shiftHours">Shift Hours*</label>
                            <input type="text" class="form-control" id="shiftHours" placeholder="Total Hours" required>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Employee Type Modal -->
<div class="modal fade" id="addEmployeeTypeModal" tabindex="-1" aria-labelledby="addEmployeeTypeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEmployeeTypeLabel">Add Employee Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addEmployeeTypeForm">
                    <!-- Employee Type -->
                    <div class="form-group">
                        <label for="employeeType">Employee Type*</label>
                        <input type="text" class="form-control" id="employeeType" placeholder="Enter Employee Type" required>
                    </div>
                    <!-- Daily Wages -->
                    <div class="form-group">
                        <label for="dailyWages">Daily Wages*</label>
                        <input type="number" class="form-control" id="dailyWages" placeholder="Enter Daily Wages" required>
                    </div>
                    <!-- Eligible for Overtime -->
                    <div class="form-group">
                        <label for="overtimeEligibility">Eligible for Overtime*</label>
                        <select class="form-control" id="overtimeEligibility" required>
                            <option value="">Select Eligibility</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <!-- Submit Button -->
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Role Modal -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Role</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editRoleForm">
                    <div class="form-group">
                        <label>Select Role</label>
                        <select class="form-control" id="editRoleDropdown">
                            <option value="Admin">Admin</option>
                            <option value="HR">HR</option>
                            <option value="Guard">Guard</option>
                            <option value="Employee">Employee</option>
                        </select>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteRoleModal" tabindex="-1" aria-labelledby="deleteRoleLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the role <strong id="roleToDelete"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Shift Modal -->
<div id="deleteShiftModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this shift?</p>
            </div>
            <div class="modal-footer text-right">
                <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button id="confirmDelete" class="btn btn-danger">Delete</button>
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

<!-- Update Shift Modal -->
<div id="updateShiftModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Shift</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="updateShiftForm">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Shift Name*</label>
                                <input type="text" id="shiftName" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Shift Start Time*</label>
                                <input type="time" id="shiftStartTime" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Shift End Time*</label>
                                <input type="time" id="shiftEndTime" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Lunch Start Time*</label>
                                <input type="time" id="lunchStartTime" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Lunch End Time*</label>
                                <input type="time" id="lunchEndTime" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Shift Hours*</label>
                                <input type="number" id="shiftHours" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Update Shift</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Update Employee Type Modal -->
<div id="updateEmployeeTypeModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Employee Type</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="updateEmployeeTypeForm">
                    <div class="form-group">
                        <label>Employee Type*</label>
                        <input type="text" id="employeeTypeName" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Daily Wages*</label>
                        <input type="text" id="dailyWages" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Eligible for OverTime*</label>
                        <select id="overtimeEligibility" class="form-control" required>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Update Employee Type</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteEmployeeTypeModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this employee type?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger confirm-delete">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Update Department Modal -->
<div id="updateDepartmentModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Department</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="updateDepartmentForm">
                    <div class="form-group">
                        <label>Department Name*</label>
                        <input type="text" id="departmentName" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary float-right">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Department Modal -->
<div id="deleteDepartmentModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this department?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger">Delete</button>
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

        // Open Edit Role Modal with preselected role
        $(".edit-role").click(function() {
            let roleName = $(this).data("role");
            $("#editRoleDropdown").val(roleName); // Set selected value
            $("#editRoleModal").modal("show");
        });

        // Delete Role Modal
        $(".delete-role").click(function() {
            let roleName = $(this).data("role");
            $("#roleToDelete").text(roleName);
            $("#deleteRoleModal").modal("show");
        });

        // Confirm Delete
        $("#confirmDelete").click(function() {
            alert("Role deleted successfully!");
            $("#deleteRoleModal").modal("hide");
        });

        $('.edit-shift').click(function() {
            $('#updateShiftModal').modal('show');
        });
    });
</script>
@stop

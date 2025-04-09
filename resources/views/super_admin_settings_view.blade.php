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
            <button class="btn btn-primary" data-toggle="modal" data-target="#addUsersModal">Add Users</button>
            <button class="btn btn-secondary" onclick="window.location.href='/all-users'">
            All Users
            </button>
            <button class="btn btn-info" data-toggle="modal" data-target="#addDepartmentModal">Department</button>
         </div>
         <div class="btn-group ml-2 mb-2">
            @foreach ($roler_permissions as $rol_permiss)
                <button class="btn btn-primary"
                    onclick="window.location.href='{{ url('admin-settings/' . $rol_permiss->role_name) }}'">
                    <i class="fas fa-cogs"></i> {{ ucfirst($rol_permiss->role_name) }} Settings
                </button>
            @endforeach
         </div>
         <div class="btn-group ml-2 mb-2">
            <button class="btn btn-secondary" data-toggle="modal" data-target="#addRoleModal">Add Role</button>
            <button class="btn btn-secondary" data-toggle="modal" data-target="#leaveMasterModal">Add Leave Master</button>
            <button class="btn btn-secondary" data-toggle="modal" data-target="#addShiftModal">Add Shift</button>
            <button class="btn btn-secondary" data-toggle="modal" data-target="#addEmployeeTypeModal">Add Employee Type</button>
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
                     @foreach ($role_masrer as $role_m)
                     @if ($role_m->roles =='Super admin')
                     @else
                     <tr>
                        <td>{{$role_m->roles}}</td>
                        <td>
                           <a href="javascript:void(0)" class="text-danger delete-role"
                              onclick="confirmDelete('{{$role_m->id}}')" title="Delete">
                           <i class="fas fa-trash"></i>
                           </a>
                           <a href="javascript:void(0)" class="text-primary ml-2 edit-role"
                              data-id="{{$role_m->id}}" data-role="{{$role_m->roles}}" title="Edit">
                           <i class="fas fa-edit"></i>
                           </a>
                        </td>
                     </tr>
                     @endif
                     @endforeach
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
               <table class="table table-bordered table-striped">
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
                     @foreach ($shift_master as $Shift_m)
                     <tr>
                        <td>{{ $Shift_m->Shift_Name }}</td>
                        <td>{{ $Shift_m->Shift_Start_Time }}</td>
                        <td>{{ $Shift_m->Shift_End_Time }}</td>
                        <td>{{ $Shift_m->Lunch_Start_Time }}</td>
                        <td>{{ $Shift_m->Lunch_end_Time }}</td>
                        <td>{{ $Shift_m->Shift_hours }}</td>
                        <td>
                           <a href="{{ url('/delete-shift') }}/{{ $Shift_m->id }}" class="btn btn-sm btn-danger delete-shift">
                           <i class="fas fa-trash"></i>
                           </a>
                           <button type="button" class="btn btn-primary btn-sm edit-shift-btn"
                              data-id="{{ $Shift_m->id }}"
                              data-name="{{ $Shift_m->Shift_Name }}"
                              data-start="{{ $Shift_m->Shift_Start_Time }}"
                              data-end="{{ $Shift_m->Shift_End_Time }}"
                              data-lunch-start="{{ $Shift_m->Lunch_Start_Time }}"
                              data-lunch-end="{{ $Shift_m->Lunch_end_Time }}"
                              data-hours="{{ $Shift_m->Shift_hours }}"
                              data-eligible-ot="{{ $Shift_m->Eligible_for_OverTime ?? 0 }}">
                           <i class="fas fa-edit"></i>
                           </button>
                        </td>
                     </tr>
                     @endforeach
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
               <table class="table table-bordered table-hover">
                  <thead class="thead-light">
                     <tr>
                        <th>Employee Type</th>
                        <th>Daily Wages</th>
                        <th>Eligible For Over Time</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($employee_type_master as $emp_m)
                     <tr>
                        <td>{{ $emp_m->EmpTypeName }}</td>
                        <td>{{ $emp_m->Daily_Wages }}</td>
                        <td>{{ $emp_m->Eligible_for_OverTime == 1 ? 'Yes' : 'No' }}</td>
                        <td>
                           <a href="{{ url('/delete-employee-type/' . $emp_m->id) }}" class="btn btn-sm btn-danger delete-employee-type" title="Delete">
                           <i class="fas fa-trash"></i>
                           </a>
                           <a href="{{ url('/edit-employee-type/' . $emp_m->id) }}" class="btn btn-sm btn-primary edit-employee-type ml-1" title="Edit">
                           <i class="fas fa-edit"></i>
                           </a>
                        </td>
                     </tr>
                     @endforeach
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
               <table class="table table-bordered table-hover">
                  <thead class="thead-light">
                     <tr>
                        <th>Department</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($depatrment_master as $Department_array)
                     <tr>
                        <td>{{ $Department_array->Department_name }}</td>
                        <td>
                           <a href="{{ url('/delete-department-type/' . $Department_array->id) }}"
                              class="btn btn-sm btn-danger delete-department"
                              title="Delete">
                           <i class="fas fa-trash"></i>
                           </a>
                           <a href="javascript:void(0);"
                              onclick="open_department_type_master_form('{{ $Department_array->id }}')"
                              class="btn btn-sm btn-primary edit-department ml-1"
                              title="Edit">
                           <i class="fas fa-edit"></i>
                           </a>
                        </td>
                     </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
         </div>
      </div>
      <!-- Leave Master Tab -->
      <div id="leaveMaster" class="tab-pane fade mt-3">
         <div class="card">
            <div class="card-header bg-primary text-white">
               <h5 class="card-title mb-0">Leave Master</h5>
            </div>
            <div class="card-body">
               <table class="table table-bordered table-hover">
                  <thead class="thead-light">
                     <tr>
                        <th>Leave Type</th>
                        <th>Short Name</th>
                        <th>Payment Status</th>
                        <th>Color</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($leave_type_master as $lm)
                     <tr>
                        <td>{{ $lm->Name }}</td>
                        <td>{{ $lm->Short_Name }}</td>
                        <td>{{ $lm->Payment_Status }}</td>
                        <td>
                           <span class="badge rounded-pill" style="background-color: {{ $lm->Color }};">
                           &nbsp;&nbsp;&nbsp;
                           </span>
                           <span class="ml-1">{{ $lm->Color }}</span>
                        </td>
                        <td>
                           <a href="{{ url('/delete-Leave-Master-Form/' . $lm->id) }}"
                              class="btn btn-sm btn-danger delete-btn"
                              title="Delete">
                           <i class="fas fa-trash"></i>
                           </a>
                           <a href="javascript:void(0);"
                              onclick="open_leave_type_master_form({{ $lm->id }})"
                              class="btn btn-sm btn-primary edit-btn ml-1"
                              title="Edit">
                           <i class="fas fa-edit"></i>
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
</div>

{{-- Modal Starts --}}
<!-- Add Users Modal -->
<div class="modal fade" id="addUsersModal" tabindex="-1" aria-labelledby="addUsersModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <form method="post" id="Add_Users_form">
         @csrf
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="Add_Users_form_header">Add Users</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <input type="hidden" id="Add_Users_input_id" name="Add_Users_input_id">
               <input type="hidden" name="form_type" value="Add_Users">
               <input type="hidden" name="Employee_Id" value="">
               <div class="row mb-3">
                  <div class="col-md-6">
                     <label for="User_Name_Input" class="form-label">User Name *</label>
                     <input type="text" class="form-control" id="User_Name_Input" name="User_name" placeholder="User Name">
                  </div>
                  <div class="col-md-6">
                     <label for="Email_Id_Input" class="form-label">Email Id *</label>
                     <input type="email" class="form-control" id="Email_Id_Input" name="Email_Id" placeholder="Email Id">
                  </div>
               </div>
               <div class="row mb-3">
                  <div class="col-md-6">
                     <label for="Mobile_Number_Input" class="form-label">Mobile Number *</label>
                     <input type="number" class="form-control" id="Mobile_Number_Input" name="Mobile_Number" placeholder="Mobile Number">
                  </div>
                  <div class="col-md-6">
                     <label for="User_role" class="form-label">Role *</label>
                     <select class="form-select custom-select" id="User_role" name="User_role" required>
                        <option value="" disabled selected>Select Role</option>
                        @isset($role_masrer)
                        @foreach ($role_masrer as $role_item)
                        @if ($role_item->roles == "Super admin")
                        @if ($role == "Super admin")
                        <option value="{{ $role_item->id }}">{{ $role_item->roles }}</option>
                        @endif
                        @else
                        <option value="{{ $role_item->id }}">{{ $role_item->roles }}</option>
                        @endif
                        @endforeach
                        @endisset
                     </select>
                  </div>
               </div>
               <div class="row mb-3">
                  <div class="col-md-6">
                     <label for="Password_Input" class="form-label">Password *</label>
                     <input type="password" class="form-control" id="Password_Input" name="Password" placeholder="Password">
                  </div>
                  <div class="col-md-6">
                     <label for="Conform_Password_Input" class="form-label">Confirm Password *</label>
                     <input type="password" class="form-control" id="Conform_Password_Input" name="Conform_Password" placeholder="Confirm Password">
                  </div>
               </div>
            </div>
            <div class="modal-footer justify-content-end">
               <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
               <button type="submit" class="btn btn-primary" id="Add_Users_form_Btn">Submit</button>
            </div>
         </div>
      </form>
   </div>
</div>

<!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <form action="{{ route('add_role_form') }}" method="POST">
            @csrf
            <div class="modal-header bg-primary text-white">
               <h5 class="modal-title" id="addRoleModalLabel">Add Role</h5>
               <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span>&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label for="role">Role <span class="text-danger">*</span></label>
                  <input type="text" name="role" id="role" class="form-control" placeholder="Role" required>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">
               <i class="fas fa-times"></i> Cancel
               </button>
               <button type="submit" class="btn btn-primary">
               <i class="fas fa-save"></i> Submit
               </button>
            </div>
         </form>
      </div>
   </div>
</div>

<!-- Add Leave Master Modal -->
<div class="modal fade" id="leaveMasterModal" tabindex="-1" aria-labelledby="leaveMasterModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
    <form id="add_Leave_Master_Form">
        @csrf
        <input type="hidden" name="leav_master_id" id="leav_master_id">
        <div class="modal-header">
        <h5 class="modal-title" id="leaveMasterModalLabel">Add Leave Master</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
        <div class="row mb-3">
            <div class="col-md-6">
            <label for="Leave_Type_name" class="form-label">Leave Type *</label>
            <input type="text" class="form-control" name="Leave_Type" id="Leave_Type_name" placeholder="Leave Type" required>
            </div>
            <div class="col-md-6">
            <label for="Leave_Short_Name" class="form-label">Short Name *</label>
            <input type="text" class="form-control" name="Short_Name" id="Leave_Short_Name" placeholder="Short Name" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
            <label for="Leave_Payment_Status" class="form-label">Payment Status *</label>
            <select class="form-select custom-select" name="Payment_Status" id="Leave_Payment_Status" required>
                <option value="" disabled selected>Select Payment Status</option>
                <option value="Paid">Paid</option>
                <option value="Unpaid">Unpaid</option>
            </select>
            </div>
            <div class="col-md-6">
            <label for="Leave_Color" class="form-label">Color *</label>
            <input type="color" class="form-control form-control-color" name="Color" id="Leave_Color" value="#000000" title="Choose color" required>
            </div>
        </div>
        </div>

        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="submit_Leave_Master_Btn" class="btn btn-primary">Submit</button>
        </div>
    </form>
    </div>
</div>
</div>

<!-- Add Department Modal -->
<div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-labelledby="departmentModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <form id="addDepartmentForm" method="POST">
            @csrf
            <input type="hidden" name="Department_input_id" id="Department_input_id">
            <div class="modal-header bg-primary text-white">
               <h5 class="modal-title" id="departmentModalLabel">Add Department</h5>
               <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span>&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label for="Department_name">Department <span class="text-danger">*</span></label>
                  <input type="text" name="Department" id="Department_name" class="form-control" placeholder="Department" required>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">
               <i class="fas fa-times"></i> Cancel
               </button>
               <button type="button" id="submitDepartmentBtn" class="btn btn-primary">
               <i class="fas fa-save"></i> Submit
               </button>
            </div>
         </form>
      </div>
   </div>
</div>

<!-- Add Shift Modal -->
<div class="modal fade" id="addShiftModal" tabindex="-1" aria-labelledby="addShiftLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <form action="{{ route('add_shift') }}" method="POST">
         @csrf
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="addShiftLabel">Add Shift</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="container-fluid">
                  <div class="row mb-3">
                     <div class="col-md-6">
                        <label class="form-label">Shift Name*</label>
                        <input type="text" class="form-control" placeholder="Shift Name" name="Shift_Name">
                     </div>
                     <div class="col-md-6">
                        <label class="form-label">Shift Start Time*</label>
                        <input type="time" class="form-control" id="Shift_Start_Time" name="Shift_Start_Time">
                     </div>
                  </div>
                  <div class="row mb-3">
                     <div class="col-md-6">
                        <label class="form-label">Shift End Time*</label>
                        <input type="time" class="form-control" id="Shift_End_Time" name="Shift_End_Time" onblur="calTimeInHr()">
                     </div>
                     <div class="col-md-6">
                        <label class="form-label">Lunch Start Time*</label>
                        <input type="time" class="form-control" name="Lunch_Start_Timee">
                     </div>
                  </div>
                  <div class="row mb-3">
                     <div class="col-md-6">
                        <label class="form-label">Lunch End Time*</label>
                        <input type="time" class="form-control" name="Lunch_end_Time">
                     </div>
                     <div class="col-md-6">
                        <label class="form-label">Shift Hours*</label>
                        <input type="number" class="form-control" name="Shift_hours" id="totalHr" readonly>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
               <button type="submit" class="btn btn-success">Submit</button>
            </div>
         </div>
      </form>
   </div>
</div>

<!-- Add Employee Type Modal -->
<div class="modal fade" id="addEmployeeTypeModal" tabindex="-1" aria-labelledby="addEmployeeTypeModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
    <form action="{{ route('add_employee_type') }}" method="POST">
        @csrf
        <div class="modal-header">
        <h5 class="modal-title" id="addEmployeeTypeModalLabel">Add Employee Type</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
        <div class="mb-3">
            <label for="emp_type" class="form-label">Employee Type *</label>
            <input type="text" name="emp_m" class="form-control" id="emp_type" placeholder="Employee Type" required>
        </div>

        <div class="mb-3">
            <label for="daily_wages" class="form-label">Daily Wages *</label>
            <select name="Daily_Wages" id="daily_wages" class="form-select custom-select" required>
            <option value="" disabled selected>Select Option</option>
            <option value="1">Yes</option>
            <option value="0">No</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="overtime_eligible" class="form-label">Eligible for OverTime *</label>
            <select name="Eligible_for_OverTime" id="overtime_eligible" class="form-select custom-select" required>
            <option value="" disabled selected>Select Eligibility</option>
            <option value="1">Yes</option>
            <option value="0">No</option>
            </select>
        </div>
        </div>

        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <input type="submit" value="Submit" class="btn btn-primary">
        </div>
    </form>
    </div>
</div>
</div>

  <!-- Role Edit Modal -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="editRoleModalLabel">Update Role</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
         </div>
         <div class="modal-body">
            <form id="updateRoleForm" method="POST">
               @csrf
               <input type="hidden" id="role_id" name="id">
               <div class="form-group mb-3">
                  <label for="role">Role*</label>
                  <input type="text" class="form-control" id="role_input" name="role_inp" required>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Update</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

<!-- Delete Role Modal -->
<div class="modal fade" id="deleteRoleModal" tabindex="-1" aria-labelledby="deleteRoleLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="deleteRoleLabel">Confirm Deletion</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            Are you sure you want to delete this role?
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <!-- This is where the actual delete happens -->
            <a id="confirmDeleteBtn" class="btn btn-danger" href="#">Delete</a>
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
               @csrf
               <input type="hidden" name="id" id="shiftId">
               <div class="row">
                  <div class="col-6">
                     <div class="form-group">
                        <label>Shift Name*</label>
                        <input type="text" name="Shift_Name" id="shiftName" class="form-control" required>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label>Shift Start Time*</label>
                        <input type="time" name="Shift_Start_Time" id="shiftStartTime" class="form-control" required>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label>Shift End Time*</label>
                        <input type="time" name="Shift_End_Time" id="shiftEndTime" class="form-control" required>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label>Lunch Start Time*</label>
                        <input type="time" name="Lunch_Start_Time" id="lunchStartTime" class="form-control" required>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label>Lunch End Time*</label>
                        <input type="time" name="Lunch_end_Time" id="lunchEndTime" class="form-control" required>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label>Shift Hours*</label>
                        <input type="number" step="0.01" name="Shift_hours" id="shiftHours" class="form-control" required>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label>Eligible for OverTime</label>
                        <select name="Eligible_for_OverTime" id="Eligible_for_OverTime" class="form-control">
                           <option value="1">Yes</option>
                           <option value="0">No</option>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Update Shift</button>
               </div>
            </form>
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
   #User_role {
   border-radius: 0.375rem;
   padding: 0.5rem 0.75rem;
   font-size: 1rem;
   background-color: #fff;
   border: 1px solid #ced4da;
   box-shadow: none;
   transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
   }
   #User_role:focus {
   border-color: #86b7fe;
   outline: 0;
   box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
   }
</style>
@stop
@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
   $(document).ready(function () {
   // Delete button alert
   $('.delete-btn').click(function (e) {
       e.preventDefault();
       alert("Delete action triggered!");
   });

   // Edit leave modal
   $('.edit-btn').click(function () {
       $('#editLeaveModal').modal('show');
   });

   // Initialize Bootstrap tabs
   $('#adminTabs a').on('click', function (e) {
       e.preventDefault();
       $(this).tab('show');
   });

   // Listen for clicks on edit-role links
   $(document).on('click', '.edit-role', function () {
       const roleId = $(this).data('id');
       const roleName = $(this).data('role');

       $('#role_id').val(roleId);
       $('#role_input').val(roleName);
       $('#editRoleModal').modal('show');
   });

   // Handle form submission via AJAX
   $('#updateRoleForm').submit(function (e) {
       e.preventDefault();

       const formData = $(this).serialize();

       $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
       });

       $.ajax({
           url: '/edit-role',
           type: 'POST',
           data: formData,
           success: function (response) {
               // Evaluate returned <script> tags from controller
               var temp = document.createElement('div');
               temp.innerHTML = response;

               var scripts = temp.getElementsByTagName('script');
               for (var i = 0; i < scripts.length; i++) {
                   eval(scripts[i].innerText);
               }
           },
           error: function (xhr) {
               if (xhr.status === 403) {
                   alert('You do not have permission to edit roles');
               } else {
                   alert('An error occurred. Please try again.');
               }
           }
       });
   });

   });

   // Confirm delete function
   function confirmDelete(id) {
   // Set the href for the actual delete action inside the modal
   document.getElementById('confirmDeleteBtn').href = "{{ url('/delete-role') }}/" + id;

   // Show the modal (using Bootstrap 5 syntax)
   var modal = new bootstrap.Modal(document.getElementById('deleteRoleModal'));
   modal.show();
   }


   // Store the values globally when edit button is clicked
   var shiftData = {};

   $(document).on('click', '.edit-shift-btn', function(e) {
   e.preventDefault();

   // Store all data in the global variable
   shiftData = {
       id: $(this).data('id'),
       name: $(this).data('name'),
       startTime: $(this).data('start'),
       endTime: $(this).data('end'),
       lunchStart: $(this).data('lunch-start'),
       lunchEnd: $(this).data('lunch-end'),
       hours: $(this).data('hours'),
   };

   console.log("Data captured:", shiftData);

   // Immediately populate form fields before showing the modal
   $('#shiftId').val(shiftData.id);
   $('#shiftName').val(shiftData.name);
   $('#shiftStartTime').val(shiftData.startTime);
   $('#shiftEndTime').val(shiftData.endTime);
   $('#lunchStartTime').val(shiftData.lunchStart);
   $('#lunchEndTime').val(shiftData.lunchEnd);
   $('#shiftHours').val(shiftData.hours);

   // Then show the modal
   $('#updateShiftModal').modal('show');
   });

   // Additional check after modal is shown to ensure data is properly set
   $('#updateShiftModal').on('shown.bs.modal', function () {
   console.log("Modal shown, confirming data is set correctly:");

   // Double-check that form fields are populated
   if (!$('#shiftName').val()) {
       console.log("Re-setting form fields as they appear empty");
       $('#shiftId').val(shiftData.id);
       $('#shiftName').val(shiftData.name);
       $('#shiftStartTime').val(shiftData.startTime);
       $('#shiftEndTime').val(shiftData.endTime);
       $('#lunchStartTime').val(shiftData.lunchStart);
       $('#lunchEndTime').val(shiftData.lunchEnd);
       $('#shiftHours').val(shiftData.hours);
   }

   console.log("Final values after modal shown:");
   console.log("shiftId:", $('#shiftId').val());
   console.log("shiftName:", $('#shiftName').val());
   });

   // Form submission handler remains the same
   $('#updateShiftForm').submit(function(e) {
   e.preventDefault();

   $.ajax({
       url: "{{ route('update_shift') }}",
       type: "POST",
       data: $(this).serialize(),
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       },
       success: function(response) {
           if (response.success) {
               alert('Shift updated successfully!');
               $('#updateShiftModal').modal('hide');
               location.reload();
           } else {
               alert(response.message || 'Failed to update shift');
           }
       },
       error: function(xhr) {
           alert('Error updating shift. Please try again.');
           console.log(xhr.responseText);
       }
   });
   });

   $('#submitDepartmentBtn').on('click', function () {
   let formData = $('#addDepartmentForm').serialize();

   $.ajax({
       url: "{{ route('add_Department_form') }}",
       method: "POST",
       data: formData,
       headers: {
           'X-CSRF-TOKEN': $('input[name="_token"]').val()
       },
       success: function (response) {
           alert(response.message);
           $('#addDepartmentForm')[0].reset();
           $('#addDepartmentModal').modal('hide');
           // Optionally reload or update table
       },
       error: function (xhr) {
           alert('An error occurred: ' + xhr.responseText);
       }
   });
   });

   // Open modal for new department
   function open_Add_Department_form() {
       $('#departmentModalLabel').text('Add Department');
       $('#addDepartmentForm')[0].reset();
       $('#Department_input_id').val('');
       $('#addDepartmentModal').modal('show');
   }

   // Open modal for editing existing department
   function open_department_type_master_form(id) {
       $('#departmentModalLabel').text('Update Department');
       $('#addDepartmentForm')[0].reset();

       $.ajax({
           type: "GET",
           url: "{{ url('/depaetment-Master-view') }}/" + id,
           dataType: "json",
           success: function (response) {
               const r_data = response.data;
               $('#Department_input_id').val(id);
               $('#Department_name').val(r_data.Department_name);
               $('#addDepartmentModal').modal('show');
           },
           error: function (xhr) {
               alert('Error fetching department data.');
               console.log(xhr.responseText);
           }
       });
   }

   function open_Add_Role_form() {
       $('#addRoleModal').modal('show');
   }

   function close_Add_Role_form() {
       $('#addRoleModal').modal('hide');
   }

   function calTimeInHr(){
   var startTime = document.getElementById('Shift_Start_Time').value;
   var endTime = document.getElementById('Shift_End_Time').value;
   var difference = timeDifference(startTime, endTime);
   document.getElementById('totalHr').value = parseFloat(difference).toFixed(2);
   }

   function timeDifference(startTime, endTime) {
   var start = new Date(`01/01/2000 ${startTime}`);
   var end = new Date(`01/01/2000 ${endTime}`);
   var diffMs = end - start;
   var diffHours = diffMs / (1000 * 60 * 60);
   if (diffHours < 0) {
     diffHours += 24;
   }
   return diffHours;
   }

   $('#Add_Users_form_Btn').on('click', function (event) {
     event.preventDefault();
     var formData = $('#Add_Users_form').serialize();

     $.ajax({
       url: "{{ route('Add_Users') }}",
       method: "POST",
       data: formData,
       headers: {
         'X-CSRF-TOKEN': $('input[name="_token"]').val()
       },
       success: function (response) {
         alert(response.message);
         $('#addUsersModal').modal('hide');  // Close modal
         $('#Add_Users_form')[0].reset();    // Reset form
       },
       error: function (xhr) {
         alert('An error occurred: ' + xhr.responseText);
       }
     });
   });

   $('#submit_Leave_Master_Btn').on('click', function () {
      var formData = $('#add_Leave_Master_Form').serialize();
      $.ajax({
        url: "{{ route('add_Leave_Master_Form') }}",
        method: "POST",
        data: formData,
        headers: {
          'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        success: function (response) {
          alert(response.message);
          $('#leaveMasterModal').modal('hide');
          $('#add_Leave_Master_Form')[0].reset();
        },
        error: function (xhr, status, error) {
          alert('An error occurred: ' + xhr.responseText);
        }
      });
    });
</script>
@stop

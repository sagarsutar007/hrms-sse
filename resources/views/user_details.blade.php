@extends('adminlte::page')

@section('title', 'Employee Management')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-user-edit mr-2"></i>Employee Management</h1>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-md-3">
        <!-- Employee Card -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                         src="{{ asset('/storage/' . ($u_data['photo_name'] ?? 'employees/default-avatar.png')) }}"
                         alt="Employee profile picture">
                </div>
                <h3 class="profile-username text-center">{{ $u_data['f_name'] ?? '' }} {{ $u_data['l_name'] ?? '' }}</h3>
                <p class="text-muted text-center">{{ $u_data['designation'] ?? 'Employee' }}</p>
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>ID</b> <a class="float-right">{{ $u_data['Employee_id'] ?? '' }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Department</b> <a class="float-right">{{ $u_data['department'] ?? '' }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Status</b>
                        <span class="float-right badge {{ isset($u_data['status']) && $u_data['status'] == 'Active' ? 'badge-success' : 'badge-danger' }}">
                            {{ $u_data['status'] ?? 'Inactive' }}
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <!-- Main Tabs -->
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#personal" data-toggle="tab"><i class="fas fa-user mr-1"></i>Personal</a></li>
                    <li class="nav-item"><a class="nav-link" href="#set-salary" data-toggle="tab"><i class="fas fa-money-bill-alt mr-1"></i>Salary</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#leave" data-toggle="tab"><i class="fas fa-calendar-alt mr-1"></i>Leave</a></li>
                    <li class="nav-item"><a class="nav-link" href="#attendance" data-toggle="tab"><i class="fas fa-clock mr-1"></i>Attendance</a></li>
                    @if ($role == '1')
                    <li class="nav-item"><a class="nav-link" href="#documents" data-toggle="tab"><i class="fas fa-file-alt mr-1"></i>Documents</a></li>
                    @endif
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content">
                    <!-- Personal Tab -->
                    <div class="tab-pane active" id="personal">
                        <div class="card card-outline card-primary mb-0">
                           <div class="card-header">
                              <h3 class="card-title">Personal Information</h3>
                              <div class="card-tools">
                                 <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                 <i class="fas fa-minus"></i>
                                 </button>
                              </div>
                           </div>
                           <div class="card-body">
                              <form action="{{ route('update_basic_info') }}" method="post">
                                 @csrf
                                 <!-- Basic Information -->
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="employee_id">Employee ID</label>
                                          <div class="input-group">
                                             <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                             </div>
                                             <input type="text" class="form-control" id="employee_id" name="Employee_Id" readonly value="{{ $u_data['Employee_id'] ?? '' }}">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="first_name">First Name <span class="text-danger">*</span></label>
                                          <div class="input-group">
                                             <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                             </div>
                                             <input type="text" class="form-control" id="first_name" name="First_Name" required value="{{ $u_data['f_name'] ?? '' }}">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                          <div class="input-group">
                                             <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                             </div>
                                             <input type="text" class="form-control" id="last_name" name="Last_Name" required value="{{ $u_data['l_name'] ?? '' }}">
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <!-- Contact Information -->
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="email" id="email_p">Email <span class="text-danger" id="email_required">*</span></label>
                                          <div class="input-group">
                                             <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                             </div>
                                             <input type="email" class="form-control" id="email_field" name="Email" required value="{{ $u_data['email'] ?? '' }}">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="phone">Phone Number <span class="text-danger">*</span></label>
                                          <div class="input-group">
                                             <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                             </div>
                                             <input type="text" class="form-control" id="phone" name="Phone" maxlength="10" value="{{ $u_data['mobile_number'] ?? $u_data['phone'] ?? '' }}">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="dob">Date of Birth <span class="text-danger">*</span></label>
                                          <div class="input-group date" id="dob" data-target-input="nearest">
                                             <div class="input-group-prepend" data-target="#dob" data-toggle="datetimepicker">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                             </div>
                                             <input type="date" class="form-control" name="DOB" value="{{ $u_data['dob'] ?? '' }}">
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <!-- Personal Documents -->
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="aadhar">Aadhar Number <span class="text-danger">*</span></label>
                                          <div class="input-group">
                                             <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-id-card-alt"></i></span>
                                             </div>
                                             <input type="text" class="form-control" id="aadhar" name="Aadhar_Number" value="{{ $u_data['aadhaar_number'] ?? '' }}">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="pan">PAN Number</label>
                                          <div class="input-group">
                                             <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                             </div>
                                             <input type="text" class="form-control" id="pan" name="PAN_Number" value="{{ $u_data['pan_number'] ?? '' }}">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="voter_id">Voter ID Number</label>
                                          <div class="input-group">
                                             <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-vote-yea"></i></span>
                                             </div>
                                             <input type="text" class="form-control" id="voter_id" name="Voter_id_Number" maxlength="10" value="{{ $u_data['voter_id_number'] ?? '' }}">
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="ration_card">Ration Card Number <span class="text-danger">*</span></label>
                                          <div class="input-group">
                                             <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-file-invoice"></i></span>
                                             </div>
                                             <input type="text" class="form-control" id="ration_card" name="Ration_Card_Number" maxlength="21" value="{{ $u_data['ration_card_number'] ?? '' }}">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="gender">Gender</label>
                                          <div class="input-group">
                                             <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                             </div>
                                             <input type="text" class="form-control" id="gender" name="Gender" value="{{ $u_data['gender'] ?? '' }}">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="education">Education <span class="text-danger">*</span></label>
                                          <div class="input-group">
                                             <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                                             </div>
                                             <input type="text" class="form-control" id="education" name="Education" value="{{ $u_data['highest_qualification'] ?? '' }}">
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <!-- Address Information -->
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label for="current_address">Current Address</label>
                                          <textarea class="form-control" id="current_address" name="Current_Address" rows="3">{{ $u_data['current_address'] ?? $u_data['address'] ?? '' }}</textarea>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label for="permanent_address">Permanent Address <span class="text-danger">*</span></label>
                                          <textarea class="form-control" id="permanent_address" name="Parment_Addtess" rows="3">{{ $u_data['permanent_address'] ?? '' }}</textarea>
                                       </div>
                                    </div>
                                 </div>
                                 <!-- Employment Details -->
                                 <h5 class="mt-4 mb-3 border-bottom pb-2">Employment Details</h5>
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="joining_date">Date of Joining <span class="text-danger">*</span></label>
                                          <div class="input-group">
                                             <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-calendar-plus"></i></span>
                                             </div>
                                             <input type="date" class="form-control" id="joining_date" name="Joining_date" value="{{ $u_data['DOJ'] ?? '' }}">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="salary">Salary <span class="text-danger">*</span></label>
                                          <div class="input-group">
                                             <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-money-bill-alt"></i></span>
                                             </div>
                                             <input type="text" class="form-control" id="salary" name="Salary" required value="{{ $u_data['salary'] ?? '' }}">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="department">Department</label>
                                          <div class="input-group">
                                             <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-building"></i></span>
                                             </div>
                                             <select class="form-control" id="department" name="Department_inputr" required>
                                                <option value="0">Select Department</option>
                                                @isset($Department_master)
                                                @foreach ($Department_master as $dpm)
                                                @if ($u_data['Department'] == $dpm->id)
                                                <option value="{{$dpm->id}}" selected>{{$dpm->Department_name}}</option>
                                                @else
                                                <option value="{{$dpm->id}}">{{$dpm->Department_name}}</option>
                                                @endif
                                                @endforeach
                                                @endisset
                                             </select>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="shift">Shift Name</label>
                                          <div class="input-group">
                                             <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                             </div>
                                             <select class="form-control" id="shift" name="Shift_Number" required>
                                                <option value="0">Select Shift</option>
                                                @isset($shift_master)
                                                @foreach ($shift_master as $shift_m)
                                                @if ($u_data['shift_time'] == $shift_m->id)
                                                <option value="{{$shift_m->id}}" selected>{{$shift_m->Shift_Name}}</option>
                                                @else
                                                <option value="{{$shift_m->id}}">{{$shift_m->Shift_Name}}</option>
                                                @endif
                                                @endforeach
                                                @endisset
                                             </select>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="employee_type">Employee Type <span class="text-danger">*</span></label>
                                          <div class="input-group">
                                             <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                             </div>
                                             <select class="form-control" id="employee_type" name="Employee_Type" required>
                                                <option value="0">Select Employee Type</option>
                                                @isset($employee_type_master)
                                                @foreach ($employee_type_master as $employee_type)
                                                @if ($u_data['employee_type'] == $employee_type->id)
                                                <option value="{{$employee_type->id}}" selected>{{$employee_type->EmpTypeName}}</option>
                                                @else
                                                <option value="{{$employee_type->id}}">{{$employee_type->EmpTypeName}}</option>
                                                @endif
                                                @endforeach
                                                @endisset
                                             </select>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="role">Role <span class="text-danger">*</span></label>
                                          <div class="input-group">
                                             <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user-shield"></i></span>
                                             </div>
                                             <select class="form-control" id="role" name="Role" required>
                                                <option value="0">Select Employee Role</option>
                                                @isset($role_masrer)
                                                @foreach ($role_masrer as $role_m)
                                                @if ($u_data['role'] == $role_m->id)
                                                <option value="{{$role_m->id}}" selected>{{$role_m->roles}}</option>
                                                @else
                                                <option value="{{$role_m->id}}">{{$role_m->roles}}</option>
                                                @endif
                                                @endforeach
                                                @endisset
                                             </select>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="gate_off">Gate Off</label>
                                          <div class="input-group">
                                             <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-door-open"></i></span>
                                             </div>
                                             <select class="form-control" id="gate_off" name="Gate_Off" required>
                                                <option value="0">Select Gate Off</option>
                                                <option value="1" @if ($u_data['Gate_Off'] == 1) selected @endif>Yes</option>
                                                <option value="0" @if ($u_data['Gate_Off'] == 0) selected @endif>No</option>
                                             </select>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="can_login">Login Enabled <span class="text-danger">*</span></label>
                                          <div class="input-group">
                                             <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-sign-in-alt"></i></span>
                                             </div>
                                             <select class="form-control" id="can_login" name="Can_Login" onchange="set_required()">
                                                <option value="0">Select</option>
                                                <option value="1" @if ($u_data['can_login'] == 1) selected @endif>Yes</option>
                                                <option value="0" @if ($u_data['can_login'] != 1) selected @endif>No</option>
                                             </select>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <!-- Termination Details -->
                                 <h5 class="mt-4 mb-3 border-bottom pb-2">Termination Details (if applicable)</h5>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label for="termination_date">Termination Date</label>
                                          <div class="input-group">
                                             <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-calendar-times"></i></span>
                                             </div>
                                             <input type="date" class="form-control" id="termination_date" name="Termination_Date" value="{{ $u_data['termination_date'] ?? '' }}">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label for="termination_reason">Reason for Termination</label>
                                          <div class="input-group">
                                             <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                             </div>
                                             <input type="text" class="form-control" id="termination_reason" name="Reason_Of_Termination" value="{{ $u_data['reason_of_termination'] ?? '' }}">
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="form-group row mt-4">
                                    <div class="col-sm-12">
                                       <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>Update Personal Information</button>
                                    </div>
                                 </div>
                              </form>
                           </div>
                        </div>
                        <!-- Profile Picture Section -->
                        <div class="card card-outline card-success mt-4">
                           <div class="card-header">
                              <h3 class="card-title">Profile Picture</h3>
                              <div class="card-tools">
                                 <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                 <i class="fas fa-minus"></i>
                                 </button>
                              </div>
                           </div>
                           <div class="card-body">
                              <form action="{{ route('update_Profile_image') }}" method="post" enctype="multipart/form-data">
                                 @csrf
                                 <input type="text" name="Employee_Id" value="{{ $u_data['Employee_id'] ?? '' }}" hidden>
                                 <div class="row">
                                    <div class="col-md-4 text-center">
                                       <img src="{{ asset('/storage/' . ($u_data['photo_name'] ?? 'employees/default-avatar.png')) }}"
                                          alt="Profile Image" class="img-fluid img-thumbnail" style="max-height: 200px;">
                                    </div>
                                    <div class="col-md-8">
                                       <div class="form-group">
                                          <label for="profile_image">Select Profile Image</label>
                                          <div class="input-group">
                                             <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="profile_image" name="Front_path" accept="image/*">
                                                <label class="custom-file-label" for="profile_image">Choose file</label>
                                             </div>
                                          </div>
                                       </div>
                                       <button type="submit" class="btn btn-success"><i class="fas fa-upload mr-1"></i>Update Profile Image</button>
                                    </div>
                                 </div>
                              </form>
                           </div>
                        </div>
                        <!-- Bank Information -->
                        <div class="card card-outline card-info mt-4">
                           <div class="card-header">
                              <h3 class="card-title">Bank Information</h3>
                              <div class="card-tools">
                                 <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                 <i class="fas fa-minus"></i>
                                 </button>
                              </div>
                           </div>
                           <div class="card-body">
                              <button class="btn btn-sm btn-success mb-3" onclick="openAddBankAccountModal()">
                              <i class="fas fa-plus mr-1"></i>Add Bank Account
                              </button>
                              <div class="table-responsive">
                                 <table class="table table-bordered table-striped" id="account_table">
                                    <thead>
                                       <tr>
                                          <th>Account Holder Name</th>
                                          <th>Account Number</th>
                                          <th>Bank Name</th>
                                          <th>IFSC Code</th>
                                          <th width="15%">Actions</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <!-- Data will be loaded via AJAX -->
                                    </tbody>
                                 </table>
                              </div>
                              <!-- Add Bank Account Modal -->
                              <div class="modal fade" id="addBankAccountModal" tabindex="-1" role="dialog" aria-labelledby="addBankAccountModalLabel" aria-hidden="true">
                                 <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <h5 class="modal-title" id="addBankAccountModalLabel">Add Bank Account</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                          </button>
                                       </div>
                                       <form action="{{route('form_request')}}" method="post">
                                          @csrf
                                          <div class="modal-body">
                                             <input type="text" name="form_type" value="Bank_Account" hidden>
                                             <input type="text" name="Employee_Id" value="<?php if(isset($u_data['Employee_id'])){ echo $u_data['Employee_id']; } ?>" hidden>
                                             <div class="form-row">
                                                <div class="form-group col-md-6">
                                                   <label for="holderName">Account Holder Name*</label>
                                                   <input type="text" class="form-control" id="holderName" name="Holder_Name" placeholder="Account Holder Name" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                   <label for="bankName">Bank Name*</label>
                                                   <input type="text" class="form-control" id="bankName" name="Bank_Name" placeholder="Bank Name" required>
                                                </div>
                                             </div>
                                             <div class="form-row">
                                                <div class="form-group col-md-6">
                                                   <label for="accountNumber">Account Number*</label>
                                                   <input type="number" class="form-control" id="accountNumber" name="Account_Number" placeholder="Account Number" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                   <label for="ifscCode">IFSC Code*</label>
                                                   <input type="text" class="form-control" id="ifscCode" name="IFSC_Code" placeholder="IFSC Code" required>
                                                </div>
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
                              <!-- Update Bank Account Modal -->
                              <div class="modal fade" id="updateBankModal" tabindex="-1" aria-labelledby="updateBankModalLabel" aria-hidden="true">
                                 <div class="modal-dialog modal-lg">
                                    <!-- modal-lg for wider form -->
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <h5 class="modal-title" id="updateBankModalLabel">Update Bank Account</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                       </div>
                                       <form method="post" id="Update_bank_form">
                                          @csrf
                                          <div class="modal-body">
                                             <input type="hidden" name="form_type" value="Update_Bank_Account">
                                             <input type="hidden" name="bank_account_input_id" id="bank_account_input_id">
                                             <div class="row">
                                                <div class="col-md-6">
                                                   <div class="form-group">
                                                      <label>Account Holder Name*</label>
                                                      <input type="text" class="form-control" name="Holder_Name" id="Holder_Name_input" placeholder="Account Holder Name">
                                                   </div>
                                                </div>
                                                <div class="col-md-6">
                                                   <div class="form-group">
                                                      <label>Bank Name*</label>
                                                      <input type="text" class="form-control" name="Bank_Name" id="Bank_Name_input" placeholder="Bank Name">
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="row mt-3">
                                                <div class="col-md-6">
                                                   <div class="form-group">
                                                      <label>Account Number*</label>
                                                      <input type="number" class="form-control" name="Account_Number" id="Account_Number_input" placeholder="Account Number">
                                                   </div>
                                                </div>
                                                <div class="col-md-6">
                                                   <div class="form-group">
                                                      <label>IFSC Code*</label>
                                                      <input type="text" class="form-control" name="IFSC_Code" id="IFSC_Code_input" placeholder="IFSC Code">
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="modal-footer">
                                             <button type="submit" id="update_account_form_btn" class="btn btn-success">Submit</button>
                                             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                          </div>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        @if ($role == '1')
                        <!-- Emergency Contacts Section -->
                        <div class="card card-outline card-danger mt-4">
                           <div class="card-header">
                              <h3 class="card-title">Emergency Contacts</h3>
                              <div class="card-tools">
                                 <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                 <i class="fas fa-minus"></i>
                                 </button>
                              </div>
                           </div>
                           <div class="card-body">
                              <button class="btn btn-sm btn-success mb-3" onclick="open_Emergency_Contact_form()">
                              <i class="fas fa-plus mr-1"></i>Add Emergency Contact
                              </button>
                              <div class="table-responsive">
                                 <table class="table table-bordered table-striped">
                                    <thead>
                                       <tr>
                                          <th>Name</th>
                                          <th>Relationship</th>
                                          <th>Phone</th>
                                          <th>Email</th>
                                          <th width="15%">Actions</th>
                                       </tr>
                                    </thead>
                                    <tbody id="emergency_contacts_table">
                                       <!-- Data will be loaded via AJAX -->
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                        @endif
                    </div>

                    <!-- Salary Tab -->
                    <div class="tab-pane" id="set-salary">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Salary Card -->
                                <div class="card card-outline card-success">
                                    <div class="card-header">
                                        <h3 class="card-title">Salary & Compensation</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body p-1">
                                        <nav>
                                            <div class="nav nav-tabs" id="salary-nav-tab" role="tablist">
                                                <a class="nav-item nav-link active" id="nav-basic-salary-tab" data-toggle="tab" href="#nav-basic-salary" role="tab">
                                                    <i class="fas fa-money-bill mr-1"></i>Basic Salary
                                                </a>
                                                <a class="nav-item nav-link" id="nav-allowances-tab" data-toggle="tab" href="#nav-allowances" role="tab">
                                                    <i class="fas fa-plus-circle mr-1"></i>Allowances
                                                </a>
                                                <a class="nav-item nav-link" id="nav-deductions-tab" data-toggle="tab" href="#nav-deductions" role="tab">
                                                    <i class="fas fa-minus-circle mr-1"></i>Deductions
                                                </a>
                                                <a class="nav-item nav-link" id="nav-loan-tab" data-toggle="tab" href="#nav-loan" role="tab">
                                                    <i class="fas fa-hand-holding-usd mr-1"></i>Advances
                                                </a>
                                                @if ($role == '1')
                                                <a class="nav-item nav-link" id="nav-other-payments-tab" data-toggle="tab" href="#nav-other-payments" role="tab">
                                                    <i class="fas fa-coins mr-1"></i>Other Payments
                                                </a>
                                                <a class="nav-item nav-link" id="nav-overtime-tab" data-toggle="tab" href="#nav-overtime" role="tab">
                                                    <i class="fas fa-clock mr-1"></i>Overtime
                                                </a>
                                                @endif
                                            </div>
                                        </nav>
                                        <div class="tab-content py-3 px-1" id="salary-nav-tabContent">
                                            <!-- Basic Salary Tab -->
                                            <div class="tab-pane fade show active" id="nav-basic-salary" role="tabpanel">
                                                <button class="btn btn-sm btn-success mb-3" onclick="open_Basic_Salary_form()">
                                                    <i class="fas fa-plus mr-1"></i>Add Basic Salary
                                                </button>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped" id="basic_salary_table">
                                                        <!-- The table content will be dynamically populated by the load_basic_salary_data() function -->
                                                        <thead>
                                                            <tr>
                                                                <th><input type="checkbox" name="delet_data" id="select-all-checkbox"></th>
                                                                <th>Month-Year</th>
                                                                <th>Payslip Type</th>
                                                                <th>₹ Basic Salary</th>
                                                                <th width="15%">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- Data will be injected here by JavaScript -->
                                                            <tr>
                                                                <td colspan="5" class="text-center">Loading data...</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="mt-2">
                                                    <button class="btn btn-sm btn-danger" id="delete-selected" style="display: none;">
                                                        <i class="fas fa-trash mr-1"></i>Delete Selected
                                                    </button>
                                                </div>
                                            </div>


                                            <!-- Allowances Tab -->
                                            <div class="tab-pane fade" id="nav-allowances" role="tabpanel">
                                                <button class="btn btn-sm btn-success mb-3" onclick="open_Allowance_form()">
                                                    <i class="fas fa-plus mr-1"></i>Add Allowance
                                                </button>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped" id="allowances_table">
                                                        <thead>
                                                            <tr>
                                                                <th><input type="checkbox" name="delet_data" id=""></th>
                                                                <th>Month-Year</th>
                                                                <th>Allowance Title</th>
                                                                <th>₹ Amount</th>
                                                                <th width="15%">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- Data will be loaded via AJAX -->
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- Deductions Tab -->
                                            <div class="tab-pane fade" id="nav-deductions" role="tabpanel">
                                                <button class="btn btn-sm btn-success mb-3" onclick="open_Deduction_form()">
                                                    <i class="fas fa-plus mr-1"></i>Add Deduction
                                                </button>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped" id="deductions_table">
                                                        <thead>
                                                            <tr>
                                                                <th><input type="checkbox" name="delet_data" id=""></th>
                                                                <th>Month-Year</th>
                                                                <th>Deduction Title</th>
                                                                <th>₹ Amount</th>
                                                                <th width="15%">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- Data will be loaded via AJAX -->
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- Advances Tab -->
                                            <div class="tab-pane fade" id="nav-loan" role="tabpanel">
                                                <button class="btn btn-sm btn-success mb-3" onclick="open_loan_form()">
                                                    <i class="fas fa-plus mr-1"></i>Add Advance
                                                </button>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped" id="loan_table">
                                                        <thead>
                                                            <tr>
                                                                <th><input type="checkbox" name="delet_data" id=""></th>
                                                                <th>Advance Title</th>
                                                                <th>Month-Year</th>
                                                                <th>Reason</th>
                                                                <th>Number of installment</th>
                                                                <th>₹ Amount</th>
                                                                <th>₹ Remaining</th>
                                                                <th width="15%">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- Data will be loaded via AJAX -->
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            @if ($role == '1')
                                            <!-- Other Payments Tab -->
                                            <div class="tab-pane fade" id="nav-other-payments" role="tabpanel">
                                                <button class="btn btn-sm btn-success mb-3" onclick="open_Other_Payment_form()">
                                                    <i class="fas fa-plus mr-1"></i>Add Other Payment
                                                </button>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped" id="other_payments_table">
                                                        <thead>
                                                            <tr>
                                                                <th><input type="checkbox" name="delet_data" id=""></th>
                                                                <th>Month-Year</th>
                                                                <th>Payment Title</th>
                                                                <th>₹ Amount</th>
                                                                <th width="15%">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- Data will be loaded via AJAX -->
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- Overtime Tab -->
                                            <div class="tab-pane fade" id="nav-overtime" role="tabpanel">
                                                <button class="btn btn-sm btn-success mb-3" onclick="open_overtime_form()">
                                                    <i class="fas fa-plus mr-1"></i>Add Overtime
                                                </button>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped" id="overtime_table">
                                                        <thead>
                                                            <tr>
                                                                <th><input type="checkbox" name="delet_data" id=""></th>
                                                                <th>Month-Year</th>
                                                                <th>Title</th>
                                                                <th>Hours</th>
                                                                <th>Rate (₹/hour)</th>
                                                                <th>Total Amount</th>
                                                                <th width="15%">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- Data will be loaded via AJAX -->
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Leave Tab -->
                    <div class="tab-pane" id="leave">
                        <div class="card card-outline card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Leave Management</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-12 col-sm-6 col-md-3">
                                        <div class="info-box bg-success">
                                            <span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Annual Leave</span>
                                                <span class="info-box-number">{{ $u_data['annual_leave_balance'] ?? '0' }} / {{ $u_data['annual_leave_total'] ?? '0' }}</span>
                                                <div class="progress">
                                                    <div class="progress-bar" style="width: {{ $u_data['annual_leave_balance'] ?? 0 / ($u_data['annual_leave_total'] ?? 1) * 100 }}%"></div>
                                                </div>
                                                <span class="progress-description">Available days</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-3">
                                        <div class="info-box bg-info">
                                            <span class="info-box-icon"><i class="fas fa-first-aid"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Sick Leave</span>
                                                <span class="info-box-number">{{ $u_data['sick_leave_balance'] ?? '0' }} / {{ $u_data['sick_leave_total'] ?? '0' }}</span>
                                                <div class="progress">
                                                    <div class="progress-bar" style="width: {{ $u_data['sick_leave_balance'] ?? 0 / ($u_data['sick_leave_total'] ?? 1) * 100 }}%"></div>
                                                </div>
                                                <span class="progress-description">Available days</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-3">
                                        <div class="info-box bg-warning">
                                            <span class="info-box-icon"><i class="fas fa-house-user"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Personal Leave</span>
                                                <span class="info-box-number">{{ $u_data['personal_leave_balance'] ?? '0' }} / {{ $u_data['personal_leave_total'] ?? '0' }}</span>
                                                <div class="progress">
                                                    <div class="progress-bar" style="width: {{ $u_data['personal_leave_balance'] ?? 0 / ($u_data['personal_leave_total'] ?? 1) * 100 }}%"></div>
                                                </div>
                                                <span class="progress-description">Available days</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-3">
                                        <div class="info-box bg-danger">
                                            <span class="info-box-icon"><i class="fas fa-calendar-times"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Unpaid Leave</span>
                                                <span class="info-box-number">{{ $u_data['unpaid_leave_count'] ?? '0' }} days</span>
                                                <div class="progress">
                                                    <div class="progress-bar" style="width: 100%"></div>
                                                </div>
                                                <span class="progress-description">Taken this year</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-sm btn-success mb-3" onclick="open_leave_form()">
                                    <i class="fas fa-plus mr-1"></i>Apply for Leave
                                </button>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover" id="leave_table">
                                        <thead>
                                            <tr>
                                                <th>Leave Type</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Duration</th>
                                                <th>Applied On</th>
                                                <th>Status</th>
                                                <th width="15%">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Data will be loaded via AJAX -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Tab -->
                    <div class="tab-pane" id="attendance">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Attendance Records</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <div class="small-box bg-info">
                                            <div class="inner">
                                                <div class="row">
                                                    <div class="col-md-3 text-center">
                                                        <h3>{{ $u_data['on_time_percentage'] ?? '0' }}%</h3>
                                                        <p>On-Time Arrival</p>
                                                    </div>
                                                    <div class="col-md-3 text-center">
                                                        <h3>{{ $u_data['present_days'] ?? '0' }}</h3>
                                                        <p>Present Days</p>
                                                    </div>
                                                    <div class="col-md-3 text-center">
                                                        <h3>{{ $u_data['late_days'] ?? '0' }}</h3>
                                                        <p>Late Arrivals</p>
                                                    </div>
                                                    <div class="col-md-3 text-center">
                                                        <h3>{{ $u_data['absent_days'] ?? '0' }}</h3>
                                                        <p>Absent Days</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="icon">
                                                <i class="far fa-clock"></i>
                                            </div>
                                            <a href="#" class="small-box-footer">
                                                Current Month Statistics
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Filter by Month:</label>
                                            <select class="form-control" id="attendance-month-filter">
                                                <option value="">All Months</option>
                                                <option value="1">January</option>
                                                <option value="2">February</option>
                                                <option value="3">March</option>
                                                <option value="4">April</option>
                                                <option value="5">May</option>
                                                <option value="6">June</option>
                                                <option value="7">July</option>
                                                <option value="8">August</option>
                                                <option value="9">September</option>
                                                <option value="10">October</option>
                                                <option value="11">November</option>
                                                <option value="12">December</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Filter by Year:</label>
                                            <select class="form-control" id="attendance-year-filter">
                                                <option value="">All Years</option>
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                                <option value="2025">2025</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Filter by Status:</label>
                                            <select class="form-control" id="attendance-status-filter">
                                                <option value="">All Status</option>
                                                <option value="on-time">On Time</option>
                                                <option value="late">Late</option>
                                                <option value="absent">Absent</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <button class="btn btn-primary" id="attendance-filter-btn">
                                            <i class="fas fa-filter mr-1"></i>Filter
                                        </button>
                                        <button class="btn btn-default ml-2" id="attendance-reset-btn">
                                            <i class="fas fa-redo mr-1"></i>Reset
                                        </button>
                                    </div>
                                </div>

                                <button class="btn btn-sm btn-success mb-3" onclick="open_Attendance_form()">
                                    <i class="fas fa-plus mr-1"></i>Add Attendance Record
                                </button>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="attendance_table">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Clock In</th>
                                                <th>Clock Out</th>
                                                <th>Status</th>
                                                <th>Working Hours</th>
                                                <th width="15%">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Data will be loaded via AJAX -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Documents Tab -->
                    @if ($role == '1')
                    <div class="tab-pane" id="documents">
                        <div class="card card-outline card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Employee Documents</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <button class="btn btn-sm btn-success mb-3" onclick="open_Document_form()">
                                    <i class="fas fa-plus mr-1"></i>Add Document
                                </button>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="document_table">
                                        <thead>
                                            <tr>
                                                <th>Document Type</th>
                                                <th>Title</th>
                                                <th>Date Added</th>
                                                <th>Expiry Date</th>
                                                <th width="15%">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Data will be loaded via AJAX -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    .nav-tabs-hightlight .nav-link {
        border-left: 3px solid transparent;
    }
    .nav-tabs-hightlight .nav-link.active {
        border-left: 3px solid #007bff;
        background-color: rgba(0, 123, 255, 0.1);
    }
    .tab-pane {
        padding-top: 20px;
    }
    .info-box-content .progress {
        height: 5px;
    }
    .info-box-content .progress-description {
        font-size: 12px;
    }
    .custom-file-input:lang(en)~.custom-file-label::after {
        content: "Browse";
    }
    .card-primary.card-outline {
        border-top: 3px solid #007bff;
    }
    .card-success.card-outline {
        border-top: 3px solid #28a745;
    }
    .card-info.card-outline {
        border-top: 3px solid #17a2b8;
    }
    .card-warning.card-outline {
        border-top: 3px solid #ffc107;
    }
    .card-danger.card-outline {
        border-top: 3px solid #dc3545;
    }
    .card-secondary.card-outline {
        border-top: 3px solid #6c757d;
    }
</style>
@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
<script>
    $(function () {
        // Initialize date picker
        $('.date').datetimepicker({
            format: 'YYYY-MM-DD'
        });

        // Initialize Select2 for dropdowns
        $('.select2').select2();

        // Custom file input
        $(document).on('change', '.custom-file-input', function () {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

        // Add event listeners for filters
        $('#attendance-filter-btn').on('click', function() {
            loadAttendanceData({
                month: $('#attendance-month-filter').val(),
                year: $('#attendance-year-filter').val(),
                status: $('#attendance-status-filter').val()
            });
        });

        $('#attendance-reset-btn').on('click', function() {
            $('#attendance-month-filter').val('');
            $('#attendance-year-filter').val('');
            $('#attendance-status-filter').val('');
            loadAttendanceData();
        });
    });

    $(document).ready(function() {
        // Initialize tabs
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr("href"); // activated tab
            console.log('Shown tab: ' + target);
        });
    });

    $(document).ready(function() {
        load_bank_data("{{url('bank_account_api/')}}/" + {{$u_data['Employee_id']}});

        // Handle form submission for update
        $('#update_account_form_btn').on('click', function(event) {
            event.preventDefault();
            // Serialize form data
            var formData = $('#Update_bank_form').serialize();

            // Make AJAX POST request
            $.ajax({
                url: "{{ route('update_bank_account') }}", // Laravel route
                method: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val() // CSRF token
                },
                success: function(response) {
                    // Handle success response
                    alert(response.message);

                    $('#Update_bank_form')[0].reset(); // Reset the form
                    close_update_Bank_Account_form();
                    load_bank_data("{{url('bank_account_api/')}}/" + {{$u_data['Employee_id']}});
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    alert('An error occurred: ' + xhr.responseText);
                }
            });
        });
    });

    function openAddBankAccountModal() {
        $('#addBankAccountModal').modal('show');
    }

    function open_Update_bank_form(id, name, bank, acc_number, ifsc) {
        console.log("Editing bank account:", { id, name, bank, acc_number, ifsc });
        console.log("Opening modal with data:");
        console.log("ID:", id);
        console.log("Holder Name:", name);
        console.log("Bank Name:", bank);
        console.log("Account Number:", acc_number);
        console.log("IFSC Code:", ifsc);

        $('#bank_account_input_id').val(id);
        $('#Holder_Name_input').val(name);
        $('#Bank_Name_input').val(bank);
        $('#Account_Number_input').val(acc_number);
        $('#IFSC_Code_input').val(ifsc);

        console.log("Attempting to open modal...");

        $('#updateBankModal').modal('show'); // Bootstrap modal
    }

    $(document).ready(function() {
        $('#update_account_form_btn').on('click', function(event) {
            event.preventDefault();

            var formData = $('#Update_bank_form').serialize();

            $.ajax({
                url: "{{ route('update_bank_account') }}",
                method: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    });

                    $('#Update_bank_form')[0].reset();
                    $('#updateBankModal').modal('hide');

                    load_bank_data("{{ url('bank_account_api/' . $u_data['Employee_id']) }}");
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: xhr.responseJSON?.message || 'Something went wrong.',
                    });
                }
            });
        });
    });


    // Function to open the Update Bank Account modal
    function openUpdateBankAccountModal(id) {
        // Set the bank account ID in the hidden input
        $('#bank_account_input_id').val(id);

        // Show loading indicator if needed
        if (typeof show_animation === 'function') {
            
        }

        // Fetch the bank account details to populate the form
        $.ajax({
            url: `/get-account/${id}`,
            type: "GET",
            dataType: "json",
            headers: {
                "Content-Type": "application/json"
            },
            success: function(response) {
                console.log("Account details:", response);

                if (response.success && response.data) {
                    const account = response.data;

                    // Populate the form fields with existing data
                    $('#Holder_Name_input').val(account.Account_Holder_Name);
                    $('#Bank_Name_input').val(account.Bank_Name);
                    $('#Account_Number_input').val(account.Account_Number);
                    $('#IFSC_Code_input').val(account.IFSC_Code);

                    // Show the modal
                    $('#updateBankAccountModal').modal('show');
                } else {
                    console.error("Failed to get account details");
                    alert("Failed to load account details. Please try again.");
                }

                // Hide loading indicator
                if (typeof hide_animation === 'function') {
                    
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching account details:", error);
                alert("Error loading account details. Please try again.");

                // Hide loading indicator
                if (typeof hide_animation === 'function') {
                    
                }
            }
        });
    }

    // Load bank data on page load
    load_bank_data("{{ url('bank_account_api/' . $u_data['Employee_id']) }}");

    function load_bank_data(url_input) {
        if (typeof show_animation === 'function') {
            
        }

        $.ajax({
            url: url_input,
            type: "GET",
            dataType: "json",
            headers: {
                "Content-Type": "application/json"
            },
            success: function(response) {
                console.log("Response:", response);

                let all_data = response.data;
                let table_html = `
                    <thead>
                        <tr>
                            <th>Account Holder Name</th>
                            <th>Account Number</th>
                            <th>Bank Name</th>
                            <th>IFSC Code</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                `;

                all_data.forEach(function(acc) {
                    table_html += `
                        <tr>
                            <td>${acc.Account_Holder_Name}</td>
                            <td>${acc.Account_Number}</td>
                            <td>${acc.Bank_Name}</td>
                            <td>${acc.IFSC_Code}</td>
                            <td>
                                <button class="btn btn-sm btn-primary"
                                    onclick="open_Update_bank_form(
                                        \`${acc.id}\`,
                                        \`${acc.Account_Holder_Name}\`,
                                        \`${acc.Bank_Name}\`,
                                        \`${acc.Account_Number}\`,
                                        \`${acc.IFSC_Code}\`
                                    )">
                                    <i class="fas fa-pencil-alt"></i> Edit
                                </button>


                                <a href="{{url('/delete')}}/${acc.id}/accounts" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>`;
                });

                table_html += `</tbody>`;

                $("#account_table").html(table_html);

                if (typeof hide_animation === 'function') {
                    
                }
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                if (typeof hide_animation === 'function') {
                    
                }
            }
        });
    }

    // Modal Form Functions
    function open_Bank_Account_form() {
        $('#bankAccountModal').modal('show');
    }

    $(document).ready(function() {
        load_basic_salary_data("{{url('basic_salary_api/')}}/" + {{$u_data['Employee_id']}});
    });

    function load_basic_salary_data(url_input) {
        console.log("Function called with URL:", url_input);
        

        $.ajax({
            url: url_input,
            type: "GET",
            dataType: "json",
            headers: {
                "Content-Type": "application/json"
            },
            success: function(response) {
                console.log("Response received:", response);

                // Check if response.data exists and has items
                if (!response.data || response.data.length === 0) {
                    console.log("No data found in response or empty array");
                    $("#basic_salary_table tbody").html("<tr><td colspan='5' class='text-center'>No data available</td></tr>");
                    
                    return;
                }

                // Table Header - leave in place, don't recreate thead
                var table_html_data = "";

                // Populate Table Rows
                response.data.forEach(function(salary) {
                    console.log("Processing salary item:", salary);
                    table_html_data += `
                        <tr>
                            <td><input type="checkbox" name="delet_data" id=""></td>
                            <td>${salary.month} ${salary.year}</td>
                            <td>${salary.Payslip_Type}</td>
                            <td>${salary.Basic_Salary}</td>
                            <td>
                                <span onclick="basic_salary_view('${salary.id}')"><i class="fa-regular fa-eye"></i></span>
                                <span onclick="open_basic_salary_update_form('${salary.id}')" class="B_Salary_a"><i class="fa-solid fa-pencil"></i></span>
                                <a href="{{url('/delete')}}/${salary.id}/basic_salary" class="Delete_Set_Salary_a"><i class="fa-solid fa-trash-can"></i></a>
                            </td>
                        </tr>`;
                });

                // Only update the tbody, not the whole table
                console.log("Generated HTML:", table_html_data);
                $("#basic_salary_table tbody").html(table_html_data);
                
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", xhr.status, error);
                console.error("Response text:", xhr.responseText);
                $("#basic_salary_table tbody").html(`<tr><td colspan='5' class='text-center'>Error loading data: ${error}</td></tr>`);
                
            }
        });
    }

    $(document).ready(function() {
        load_allowances_data("{{url('allowances_view_api/')}}/" + {{$u_data['Employee_id']}});
    });

    function load_allowances_data(url_input) {
        
        $.ajax({
            url: url_input, // API endpoint URL
            type: "GET", // HTTP method
            dataType: "json",
            headers: {
                "Content-Type": "application/json"
            },
            success: function(response) {
                console.log("Response:", response); // Log the successful response
                $("#allowances_table tbody").empty();

                // Populate Table Rows
                var all_data = response.data;
                all_data.forEach($allowance => {
                    var row = `
                        <tr>
                            <td><input type="checkbox" name="delet_data" id=""></td>
                            <td>${$allowance.Month} ${$allowance.year}</td>
                            <td>${$allowance.Alloweance_Titel}</td>
                            <td>${$allowance.Allowance_Ammount_in_INR}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" onclick="Allowances_view('${$allowance.id}')">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-primary" onclick="open_Update_Allowance_form('${$allowance.id}')">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                                <a href="{{url('/delete')}}/${$allowance.id}/alloweance" class="btn btn-sm btn-danger">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>
                        </tr>`;
                    $("#allowances_table tbody").append(row);
                });
                
            },
            error: function(xhr, status, error) {
                console.error("Error:", error); // Log the error
                
            }
        });
    }

    $(document).ready(function() {
        load_deductions_data("{{url('Deductions_view_api/')}}/" + {{$u_data['Employee_id']}});
    });

    function load_deductions_data(url_input) {
        
        $.ajax({
            url: url_input, // API endpoint URL
            type: "GET", // HTTP method
            dataType: "json",
            headers: {
                "Content-Type": "application/json"
            },
            success: function(response) {
                console.log("Response:", response); // Log the successful response
                $("#deductions_table tbody").empty();

                // Populate Table Rows
                var all_data = response.data;
                all_data.forEach($deduction => {
                    var row = `
                        <tr>
                            <td><input type="checkbox" name="delet_data" id=""></td>
                            <td>${$deduction.Month}</td>
                            <td>${$deduction.deduction_Titel}</td>
                            <td>${$deduction.deduction_Amount_in_INR}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" onclick="Deductions_view('${$deduction.id}')">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-primary" onclick="open_Update_Deduction_form('${$deduction.id}')">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                                <a href="{{url('/delete')}}/${$deduction.id}/deductions" class="btn btn-sm btn-danger">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>
                        </tr>`;
                    $("#deductions_table tbody").append(row);
                });
                
            },
            error: function(xhr, status, error) {
                console.error("Error:", error); // Log the error
                
            }
        });
    }

    $(document).ready(function() {
        load_loan_data("{{url('loan_view_api/')}}/" + {{$u_data['Employee_id']}});
    });

    function load_loan_data(url_input) {
        
        $.ajax({
            url: url_input, // API endpoint URL
            type: "GET", // HTTP method
            dataType: "json",
            headers: {
                "Content-Type": "application/json"
            },
            success: function(response) {
                console.log("Response:", response); // Log the successful response
                $("#loan_table tbody").empty();

                // Populate Table Rows
                var all_data = response.data;
                all_data.forEach($loan => {
                    const inputDate = $loan.Month;
                    const date = new Date(inputDate);
                    const options = { year: 'numeric', month: 'long' };
                    const formattedDate = date.toLocaleDateString('en-US', options);

                    var row = `
                        <tr>
                            <td><input type="checkbox" name="delet_data" id=""></td>
                            <td>${$loan.Title}</td>
                            <td>${formattedDate}</td>
                            <td>${$loan.Reason}</td>
                            <td>${$loan.Number_of_installment}</td>
                            <td>${$loan.Loan_Amount_in_INR}</td>
                            <td>${$loan.Loan_Remaining}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" onclick="loan_view('${$loan.id}')">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-primary" onclick="open_Update_Loan_form('${$loan.Loan_id}')">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                                <a href="{{url('/delete')}}/${$loan.id}/loan" class="btn btn-sm btn-danger">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>
                        </tr>`;
                    $("#loan_table tbody").append(row);
                });
                
            },
            error: function(xhr, status, error) {
                console.error("Error:", error); // Log the error
                
            }
        });
    }

    $(document).ready(function() {
        load_other_payments_data("{{url('other_payments_view_api/')}}/" + {{$u_data['Employee_id']}});
    });

    function load_other_payments_data(url_input) {
        
        $.ajax({
            url: url_input, // API endpoint URL
            type: "GET", // HTTP method
            dataType: "json",
            headers: {
                "Content-Type": "application/json"
            },
            success: function(response) {
                console.log("Response:", response); // Log the successful response
                $("#other_payments_table tbody").empty();

                // Populate Table Rows
                var all_data = response.data;
                all_data.forEach($payment => {
                    var row = `
                        <tr>
                            <td><input type="checkbox" name="delet_data" id=""></td>
                            <td>${$payment.Month} ${$payment.Year}</td>
                            <td>${$payment.Titel}</td>
                            <td>${$payment.Amount_in_INR}</td>
                            <td>
                                <a href="{{url('/other-payments')}}/${$payment.id}" class="btn btn-sm btn-info">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                                <a href="{{url('/edit-other-payments')}}/${$payment.id}" class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                                <a href="{{url('/delete')}}/${$payment.id}/other_payments" class="btn btn-sm btn-danger">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>
                        </tr>`;
                    $("#other_payments_table tbody").append(row);
                });
                
            },
            error: function(xhr, status, error) {
                console.error("Error:", error); // Log the error
                
            }
        });
    }

    $(document).ready(function() {
        load_overtime_data("{{url('overtime_view_api/')}}/" + {{$u_data['Employee_id']}});
    });

    function load_overtime_data(url_input) {
        
        $.ajax({
            url: url_input, // API endpoint URL
            type: "GET", // HTTP method
            dataType: "json",
            headers: {
                "Content-Type": "application/json"
            },
            success: function(response) {
                console.log("Response:", response); // Log the successful response
                $("#overtime_table tbody").empty();

                // Populate Table Rows
                var all_data = response.data;
                all_data.forEach($overtime => {
                    var row = `
                        <tr>
                            <td><input type="checkbox" name="delet_data" id=""></td>
                            <td>${$overtime.Month} ${$overtime.Year}</td>
                            <td>${$overtime.Titel}</td>
                            <td>${$overtime.Total_Hours}</td>
                            <td>${$overtime.Rate}</td>
                            <td>${$overtime.Rate * $overtime.Total_Hours}</td>
                            <td>
                                <a href="{{url('/over-time')}}/${$overtime.id}" class="btn btn-sm btn-info">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                                <a href="{{url('/edit-over-time')}}/${$overtime.id}" class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                                <a href="{{url('/delete')}}/${$overtime.id}/overtime" class="btn btn-sm btn-danger">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>
                        </tr>`;
                    $("#overtime_table tbody").append(row);
                });
                
            },
            error: function(xhr, status, error) {
                console.error("Error:", error); // Log the error
                
            }
        });
    }
    
</script>

<script>

    load_basic_salary_data("{{url('basic_salary_api/')}}/" + {{$u_data['Employee_id']}})
    
    function load_basic_salary_data(url_input) {
        
        $.ajax({
            url: url_input,  // API endpoint URL
            type: "GET",  // HTTP method
            dataType: "json",
            headers: {
                "Content-Type": "application/json"
            },
            success: function(response) {
                console.log("Salary Response:", response);  // Handle the successful response here
                $("#basic_salary_table").empty();
                
                // Table Header
                var table_html_data = `
                    <thead>
                        <tr>
                            <th><input type="checkbox" name="delet_data" id=""></th>
                            <th>Month-Year</th>
                            <th>Payslip Type</th>
                            <th>(₹) Basic Salary</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>`;

                // Populate Table Rows
                var all_data = response.data;
                all_data.forEach($salary => {
                    table_html_data += `
                        <tr>
                            <td><input type="checkbox" name="delet_data" id=""></td>
                            <td>${$salary.month} ${$salary.year}</td>
                            <td>${$salary.Payslip_Type}</td>
                            <td>${$salary.Basic_Salary}</td>
                            <td>
                                <span onclick="basic_salary_view('${$salary.id}')"><i class="fa-regular fa-eye"></i></span>
                                <span onclick="open_basic_salary_update_form('${$salary.id}')" class="B_Salary_a"><i class="fa-solid fa-pencil"></i></span>
                                <a href="{{url('/delete')}}/${$salary.id}/basic_salary" class="Delete_Set_Salary_a"><i class="fa-solid fa-trash-can"></i></a>
                            </td>
                        </tr>`;
                });

                table_html_data += `</tbody>`;
                $("#basic_salary_table").html(table_html_data);
                
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);  // Handle the error here
                
            }
        });
    }

    $(document).ready(function() {
        // Handle form submission
        $('#Add_Basic_Salary_form_Btn').on('click', function(event) {
            event.preventDefault();
            // Serialize form data
            var formData = $('#Add_Basic_Salary_form').serialize();

            // Make AJAX POST request
            $.ajax({
                url: "{{ route('form_request') }}", // Laravel route
                method: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val() // CSRF token
                },
                success: function(response) {
                    // Handle success response
                    alert(response.message);
                    close_Basic_Salary_form() // Hide the form
                    $('#Add_Basic_Salary_form')[0].reset(); // Reset the form
                    load_basic_salary_data("{{url('basic_salary_api/')}}/" + {{$u_data['Employee_id']}})
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    alert('An error occurred: ' + xhr.responseText);
                }
            });
        });
    });
</script>
@stop

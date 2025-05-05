@extends('adminlte::page')

@section('title', 'Employee Management')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-user-edit mr-2"></i>Employee Management</h1>
    </div>
@stop

@section('content')
<div class="conatiner-fluid">
    <div class="row">
        <!-- Left Column -->
        <div class="col-md-4">
           <!-- Employee Card -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                <h3 class="card-title">Employee Card</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                            src="{{ asset('/storage/' . ($u_data['photo_name'] ?? 'employees/default-avatar.png')) }}"
                            alt="Employee profile picture">
                    </div>
                    <h3 class="profile-username text-center">{{ $u_data['f_name'] ?? '' }} {{ $u_data['l_name'] ?? '' }}</h3>
                    <p class="text-muted text-center">{{ $u_data['designation'] ?? 'Employee' }}</p>
                    <ul class="list-group list-group-bordered mb-3">
                        <li class="list-group-item">
                            <b>ID</b> <a class="float-right">{{ $u_data['Employee_id'] ?? '' }}</a>
                        </li>
                    </ul>
                </div>
            </div>

           <!-- Profile Picture Section -->
            <div class="card card-outline card-success mb-4">
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

           <!-- Bank Information Section -->
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
                        <table class="table table-bordered table-striped table-hover" id="account_table">
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
        </div>

        <!-- Right Column - Personal Information -->
        <div class="col-md-8">
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
                                                      <input type="text" class="form-control" id="first_name" name="First_Name" value="{{ $u_data['f_name'] ?? '' }}">
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
                                                      <input type="text" class="form-control" id="last_name" name="Last_Name" value="{{ $u_data['l_name'] ?? '' }}">
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
                                                      <input type="email" class="form-control" id="email_field" name="Email" value="{{ $u_data['email'] ?? '' }}">
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
                                                      <input type="text" class="form-control" id="salary" name="Salary" value="{{ $u_data['salary'] ?? '' }}">
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
                                                      <select class="form-control" id="department" name="Department_inputr">
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
                                                      <select class="form-control" id="shift" name="Shift_Number">
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
                                                      <select class="form-control" id="employee_type" name="Employee_Type">
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
                                                      <select class="form-control" id="role" name="Role">
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
                                                      <select class="form-control" id="gate_off" name="Gate_Off">
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
                                                            <input type="date" class="form-control" id="termination_date" name="termination_date" value="{{ $u_data['termination_date'] ?? '' }}">
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
                                                            <input type="text" class="form-control" id="termination_reason" name="reason_of_termination" value="{{ $u_data['reason_of_termination'] ?? '' }}">
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
                                         <table class="table table-bordered table-striped table-hover">
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
                                                        <a class="nav-item nav-link" id="nav-penalty-tab" data-toggle="tab" href="#nav-penalty" role="tab">
                                                            <i class="fas fa-receipt mr-1"></i>Penalty
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
                                                        {{-- <button class="btn btn-sm btn-success mb-3" onclick="open_Basic_Salary_form()">
                                                            <i class="fas fa-plus mr-1"></i>Add Basic Salary
                                                        </button> --}}
                                                        <div class="table-responsive" style="height: 500px; overflow-y: auto;">
                                                            <table class="table table-bordered table-striped table-hover" id="basic_salary_table">
                                                                <thead>
                                                                    <tr>
                                                                        <th><input type="checkbox" id="select_all_checkboxes"></th>
                                                                        <th>Month-Year</th>
                                                                        <th>Basic Salary (₹)</th>
                                                                        <th>Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody></tbody>
                                                            </table>
                                                        </div>
                                                        <div class="mt-2">
                                                            <button class="btn btn-sm btn-danger" id="delete-selected" style="display: none;">
                                                                <i class="fas fa-trash mr-1"></i>Delete Selected
                                                            </button>
                                                        </div>

                                                        <!-- Basic Salary Modal -->
                                                        <div class="modal fade" id="BasicSalaryModal" tabindex="-1" role="dialog" aria-labelledby="BasicSalaryModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <form method="post" id="Add_Basic_Salary_form">
                                                                @csrf
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="Basic_Salary_form_header">Add Basic Salary</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span>&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">

                                                                    <input type="number" id="basic_salary_input_id" name="basic_salary_input_id" hidden>
                                                                    <input type="text" name="form_type" value="Basic_Salary" hidden>
                                                                    <input type="text" name="Employee_Id" value="{{ $u_data['Employee_id'] ?? '' }}" hidden>

                                                                    <div class="form-group">
                                                                    <label>Basic Salary *</label>
                                                                    <input type="number" name="Basic_Salary" class="form-control" id="Basic_Salary_amount" placeholder="Basic Salary">
                                                                    </div>

                                                                    <div class="form-group">
                                                                    <label>Month *</label>
                                                                    <input type="month" name="month" class="form-control" id="Basic_Salary_month">
                                                                    </div>

                                                                    <div class="form-group">
                                                                    <label>Year *</label>
                                                                    <input type="text" name="year" class="form-control" id="Basic_Salary_year" placeholder="Year">
                                                                    </div>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary" id="Add_Basic_Salary_form_Btn">Submit</button>
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                </div>
                                                                </form>
                                                            </div>
                                                            </div>
                                                        </div>

                                                        <!-- Basic Salary View Modal -->
                                                        <div class="modal fade" id="basicSalaryModal" tabindex="-1" role="dialog" aria-labelledby="basicSalaryModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-md" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-primary">
                                                                        <h5 class="modal-title" id="basicSalaryModalLabel">Basic Salary View</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true" style="font-size: 26px;">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body" id="basic_salary_modal_body">
                                                                        <p class="text-muted text-center">Loading...</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Delete Confirmation Modal -->
                                                        <x-adminlte-modal id="deleteSalaryModal" title="Confirm Deletion" theme="danger" icon="fas fa-trash" static-backdrop>
                                                            <p>Are you sure you want to delete this salary record?</p>

                                                            <x-slot name="footerSlot">
                                                                <form id="deleteSalaryForm" method="GET">
                                                                    @csrf
                                                                    <x-adminlte-button class="mr-auto" theme="secondary" label="Cancel" data-dismiss="modal" />
                                                                    <x-adminlte-button theme="danger" type="submit" label="Delete" />
                                                                </form>
                                                            </x-slot>
                                                        </x-adminlte-modal>
                                                    </div>


                                                    <!-- Allowances Tab -->
                                                    <div class="tab-pane fade" id="nav-allowances" role="tabpanel">
                                                        <x-adminlte-button label="Add Allowance" theme="success" icon="fas fa-plus" class="mb-3" data-toggle="modal" data-target="#addAllowanceModal" />
                                                        <div class="table-responsive" style="height: 500px; overflow-y: auto;">
                                                            <table class="table table-bordered table-striped table-hover" id="allowances_table">
                                                                <thead>
                                                                    <tr>
                                                                        <th><input type="checkbox" id="select_all_allowances"></th>
                                                                        <th>Month-Year</th>
                                                                        <th>Allowance Title</th>
                                                                        <th>₹ Amount</th>
                                                                        <th width="15%">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody></tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <!-- Add Allowance Modal -->
                                                    <x-adminlte-modal id="addAllowanceModal" title="Add Allowance" size="lg" theme="success" icon="fas fa-plus" static-backdrop>
                                                        <form id="add_Allowance_form">
                                                            @csrf
                                                            <input type="hidden" name="form_type" value="Allowanceform">
                                                            <input type="hidden" id="Allowance_id_input" name="Allowance_id_input" value="">
                                                            <input type="hidden" name="Employee_Id" value="{{ $u_data['Employee_id'] ?? '' }}">

                                                            <x-adminlte-input name="Allowance_Title" label="Allowance Title" placeholder="Enter Allowance Title" required />
                                                            <x-adminlte-input name="Allowance_Amount" label="Allowance Amount (₹)" placeholder="Enter Amount" type="number" required />

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <x-adminlte-input name="Month" label="Month" type="month" required />
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <x-adminlte-input name="Year" label="Year" placeholder="Enter Year" required />
                                                                </div>
                                                            </div>

                                                            <x-slot name="footerSlot">
                                                                <x-adminlte-button label="Submit" class="mr-auto" id="Allowance_form_submit_btn" theme="primary" />
                                                                <x-adminlte-button label="Close" data-dismiss="modal" theme="secondary" />
                                                            </x-slot>
                                                        </form>
                                                    </x-adminlte-modal>

                                                    <!-- Allowance view modal -->
                                                    <x-adminlte-modal id="viewAllowanceModal" title="Allowance Details" size="lg" theme="info" icon="fas fa-eye" static-backdrop>
                                                        <div id="viewAllowanceContent">
                                                            <!-- Dynamic content will be injected here -->
                                                            <p>Loading...</p>
                                                        </div>
                                                    </x-adminlte-modal>

                                                    <div class="modal fade" id="confirmDeleteModal" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-danger">
                                                                <h5 class="modal-title">Confirm Delete</h5>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to delete this allowance?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Yes, Delete</a>
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <!-- Deductions Tab -->
                                                    <div class="tab-pane fade" id="nav-deductions" role="tabpanel">
                                                        <button class="btn btn-sm btn-success mb-3" data-toggle="modal" data-target="#deductionModal">
                                                            <i class="fas fa-plus mr-1"></i>Add Deduction
                                                        </button>
                                                        <div class="table-responsive" style="height: 500px; overflow-y: auto;">
                                                            <table class="table table-bordered table-striped table-hover" id="Deductions_table">
                                                                <thead>
                                                                    <tr>
                                                                        <th><input type="checkbox" name="delet_data" id=""></th>
                                                                        <th>Month-Year</th>
                                                                        <th>Deduction Title</th>
                                                                        <th>₹ Amount</th>
                                                                        <th>Against Advance</th>
                                                                        <th>Paid Flag</th>
                                                                        <th width="15%">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <!-- Data will be loaded via AJAX -->
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div class="tab-pane fade pt-0" id="nav-penalty" role="tabpanel">
                                                        <button class="btn btn-sm btn-success mb-3 float-right" data-toggle="modal" data-target="#penaltyModal">
                                                            <i class="fas fa-plus mr-1"></i>Add Penalty
                                                        </button>
                                                        <form action="{{ route('addPenalty') }}" method="post" id="add_penalty_form" autocomplete="off">
                                                            @csrf
                                                            <input type="hidden" name="employee_id" value="{{ $u_data['Employee_id'] ?? '' }}">
                                                            <input type="hidden" name="penalty_id" id="penalty-id" value="">
                                                            <div class="modal fade" id="penaltyModal" tabindex="-1" role="dialog" aria-labelledby="penaltyModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header bg-primary p-2">
                                                                            <h5 class="modal-title text-white" id="penaltyModalLabel"><i class="fas fa-minus-circle mr-2"></i> Add Penalty </h5>
                                                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="row">
                                                                                <div class="col-md-4 mb-3">
                                                                                    <span class="label">Amount</span>
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text"><i class="fas fa-money-bill"></i></span>
                                                                                        </div>
                                                                                        <input type="text" class="form-control" id="penalty-amount" name="amount" value="">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 mb-3">
                                                                                    <span class="label">Penalty Date</span>
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                                                        </div>
                                                                                        <input type="text" class="form-control" id="penalty-date" name="penalty_date" value="">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 mb-3">
                                                                                    <span class="label">Waived Off Amount</span>
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text"><i class="fas fa-money-bill-1"></i></span>
                                                                                        </div>
                                                                                        <input type="text" class="form-control" id="waived-off" name="waived_off" value="">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 mb-3">
                                                                                    <span class="label">Waived Off By</span>
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                                                        </div>
                                                                                        <input type="text" class="form-control" id="waived-off-by" name="waived_off_by" value="">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 mb-3">
                                                                                    <span class="label">Waived On</span>
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                                                        </div>
                                                                                        <input type="text" class="form-control" id="waived-on" name="waived_on" value="">
                                                                                    </div>
                                                                                </div>
                                                                                <!-- <div class="col-md-4 mb-3">
                                                                                    <span class="label">Payment Status</span>
                                                                                    <br>
                                                                                    <div class="form-check form-check-inline mt-2">
                                                                                        <input class="form-check-input" type="radio" name="payment_status" id="paid" value="Paid">
                                                                                        <label class="form-check-label" for="paid">Paid</label>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline">
                                                                                        <input class="form-check-input" type="radio" name="payment_status" id="pending" value="Pending" checked>
                                                                                        <label class="form-check-label" for="pending">Pending</label>
                                                                                    </div>
                                                                                </div> -->
                                                                                <div class="col-md-6 mb-3">
                                                                                    <span class="label">Penalty Reason</span>
                                                                                    <textarea class="form-control" name="penalty_reason" id="penalty-reason"></textarea>
                                                                                </div>
                                                                                <div class="col-md-6 mb-3">
                                                                                    <span class="label">Waive Off Reason</span>
                                                                                    <textarea class="form-control" name="waive_off_reason" id="waive-off-reason"></textarea>
                                                                                </div>
                                                                                <div class="col-12 mb-3">
                                                                                    <label><strong>Payments</strong></label>
                                                                                    <div id="payment-rows">
                                                                                        <!-- Payment rows will be added dynamically here -->
                                                                                    </div>
                                                                                </div>

                                                                            </div>

                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-success float-right mr-3" id="add-payment"><i class="fas fa-plus"></i> Add Payment</button>
                                                                            <button type="submit" class="btn btn-primary float-right" id="save-penalty-btn">Add Penalty <i class="fas fa-arrow-right ml-1"></i></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>

                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-striped table-hover" id="penalties_table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Sl.</th>
                                                                        <th>Date</th>
                                                                        <th>Amount</th>
                                                                        <th>Reason</th>
                                                                        <th>Waived Off</th>
                                                                        <th>Waived On</th>
                                                                        <th>Payment Status</th>
                                                                        <th width="15%">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($penalties as $index => $penalty)
                                                                    @php
                                                                        $payments = $penalty->extra_Info ? json_decode($penalty->extra_Info, true) : [];
                                                                    @endphp
                                                                    <tr>
                                                                        <td>{{ $index + 1 }}</td>
                                                                        <td>{{ \Carbon\Carbon::parse($penalty->Date_of_Penalty)->format('d-m-Y') }}</td>
                                                                        <td>{{ $penalty->Amount }}</td>
                                                                        <td>{{ $penalty->Reason }}</td>
                                                                        <td>{{ $penalty->Waived_Off }}</td>
                                                                        <td>{{ \Carbon\Carbon::parse($penalty->Waived_On)->format('d-m-Y') }}</td>
                                                                        <td>{{ ucfirst($penalty->Payment_Status) }}</td>
                                                                        <td>
                                                                            @if($penalty->Payment_Status !== 'success')
                                                                                <button
                                                                                    class="btn btn-sm btn-primary edit-penalty"
                                                                                    data-id="{{ $penalty->id }}"
                                                                                    data-amount="{{ $penalty->Amount }}"
                                                                                    data-date="{{ $penalty->Date_of_Penalty }}"
                                                                                    data-waived="{{ $penalty->Waived_Off }}"
                                                                                    data-waived-by="{{ $penalty->Waived_off_By }}"
                                                                                    data-waived-on="{{ $penalty->Waived_On }}"
                                                                                    data-reason="{{ $penalty->Reason }}"
                                                                                    data-waive-reason="{{ $penalty->Reason_of_Waive_Off }}"
                                                                                    data-payments='@json($payments)'
                                                                                >
                                                                                    <i class="fas fa-edit"></i>
                                                                                </button>

                                                                                <form action="{{ route('deletePenalty', $penalty->id) }}" method="POST" style="display:inline;">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">
                                                                                        <i class="fas fa-trash"></i>
                                                                                    </button>
                                                                                </form>
                                                                            @else
                                                                                <span class="badge bg-success">Paid</span>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <!-- Deduction Form Modal -->
                                                    <div class="modal fade" id="deductionModal" tabindex="-1" role="dialog" aria-labelledby="deductionModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <form action="{{ route('form_request') }}" method="post" id="add_deductions_form">
                                                                    @csrf
                                                                    <input type="text" name="form_type" value="Deduction_form" hidden>
                                                                    <input type="number" name="Deduction_id_input" id="Deduction_id_input" hidden>
                                                                    <input type="text" name="Employee_Id" style="padding: 5px 10px; width:100%;" value="<?php if(isset($u_data['Employee_id'])){ echo $u_data['Employee_id']; } ?>" hidden>

                                                                    <!-- Modal Header -->
                                                                    <div class="modal-header bg-primary">
                                                                        <h5 class="modal-title text-white" id="add_deductions_form_header">
                                                                            <i class="fas fa-minus-circle mr-2"></i> Add Deduction
                                                                        </h5>
                                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" onclick="close_Deduction_form()">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>

                                                                    <!-- Modal Body -->
                                                                    <div class="modal-body">
                                                                        <div class="alert alert-info">
                                                                            <i class="fas fa-info-circle mr-1"></i> Deductions are applied to the month <strong>following</strong> the selected month.
                                                                        </div>

                                                                        <div class="form-group row">
                                                                            <div class="col-md-6">
                                                                                <label class="input_lable_p">Select Month *</label>
                                                                                <input type="month" class="form-control" id="Deduction_month" name="Month_Year" required>
                                                                                <small class="text-muted">Deduction will apply to the following month</small>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label class="input_lable_p">Deduction Title *</label>
                                                                                <input type="text" class="form-control" name="Deduction_Title" id="Deduction_Title" placeholder="Deduction Title *" required>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label class="input_lable_p">(₹) Deduction Amount *</label>
                                                                            <input type="text" class="form-control" name="Deduction_Amount" id="Deduction_Amount" placeholder="Deduction Amount" required>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Modal Footer -->
                                                                    <div class="modal-footer justify-content-between">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="close_Deduction_form()">
                                                                            <i class="fas fa-times mr-1"></i> Cancel
                                                                        </button>
                                                                        <input type="submit" value="Submit" class="btn btn-success" id="_submit_btn">
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Deduction View Modal -->
                                                    <div class="modal fade" id="deductionViewModal" tabindex="-1" role="dialog" aria-labelledby="deductionViewLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-top-centered" role="document">
                                                          <div class="modal-content">
                                                            <div class="modal-header bg-info">
                                                              <h5 class="modal-title" id="deductionViewLabel">Deduction Details</h5>
                                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                              </button>
                                                            </div>
                                                            <div class="modal-body">
                                                              <!-- Filled dynamically by JS -->
                                                            </div>
                                                            <div class="modal-footer">
                                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div>




                                                    <!-- Advances Tab -->
                                                    <div class="tab-pane fade" id="nav-loan" role="tabpanel">
                                                        <button type="button" class="btn btn-sm btn-success mb-3 add-advance-btn">
                                                            <i class="fas fa-plus mr-1"></i> Add Advance
                                                        </button>
                                                        <div class="table-responsive" style="height: 500px; overflow-y: auto;">
                                                            <table class="table table-bordered table-striped table-hover" id="loan_table">
                                                                <thead>
                                                                    <tr>
                                                                        <th><input type="checkbox" name="delet_data"></th>
                                                                        <th>Month-Year</th>
                                                                        <th>Reason</th>
                                                                        <th>Number of installment</th>
                                                                        <th>₹ Amount</th>
                                                                        <th>₹ Remaining</th>
                                                                        <th width="15%">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="loan_view_table">
                                                                    <!-- AJAX data will load here -->
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <!-- Loan / Advance Modal -->
                                                    <div class="modal fade" id="loanModal" tabindex="-1" role="dialog" aria-labelledby="loanModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-xl" role="document">
                                                        <div class="modal-content">
                                                            <form action="{{ route('form_request') }}" method="post" id="add_loan_form">
                                                                @csrf
                                                                <input type="hidden" name="form_type" value="Loan_form">
                                                                <input type="hidden" name="loan_Id_input" id="loan_Id_input">
                                                                <input type="hidden" name="Employee_Id" value="{{ $u_data['Employee_id'] }}">

                                                                <div class="modal-header bg-primary">
                                                                    <h5 class="modal-title text-white" id="loanModalLabel"><i class="fas fa-money-check-alt mr-1"></i> Add Advance</h5>
                                                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="loan_month">Month <span class="text-danger">*</span></label>
                                                                            <input type="month" name="Month" id="loan_month" class="form-control" onchange="genrate_table()" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="loan_reason">Reason <span class="text-danger">*</span></label>
                                                                            <textarea class="form-control" name="Reason" id="loan_reason" rows="1" required></textarea>
                                                                        </div>
                                                                    </div>
                                                                    </div>

                                                                    <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="loan_amount">(₹) Amount <span class="text-danger">*</span></label>
                                                                            <input type="number" name="Amount" id="loan_amount" class="form-control" placeholder="Amount in INR" onkeyup="genrate_table()" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="number_of_loan_installment">Number of Installments <span class="text-danger">*</span></label>
                                                                            <input type="number" name="Number_of_installment" id="number_of_loan_installment" class="form-control" placeholder="Installments" onkeyup="genrate_table()" required>
                                                                        </div>
                                                                    </div>
                                                                    </div>

                                                                    <hr>
                                                                    <h6 class="text-muted mb-2">Installment Breakdown</h6>
                                                                    <div class="table-responsive">
                                                                    <table class="table table-bordered table-striped table-hover">
                                                                        <thead class="thead-dark">
                                                                            <tr>
                                                                                <th>Sr. No</th>
                                                                                <th>Month - Year</th>
                                                                                <th>Amount</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="monthList">
                                                                            <!-- Auto-filled installment rows -->
                                                                        </tbody>
                                                                    </table>
                                                                    </div>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                                    <i class="fas fa-times mr-1"></i> Cancel
                                                                    </button>
                                                                    <button type="button" class="btn btn-primary" id="loan_form_submit_btn">
                                                                        <i class="fas fa-save mr-1"></i> Submit
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        </div>
                                                    </div>

                                                    <!-- View Advance (Loan) Modal -->
                                                    <div class="modal fade" id="loanViewModal" tabindex="-1" aria-labelledby="loanViewModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- center & large -->
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-info">
                                                                    <h5 class="modal-title text-white" id="loanViewModalLabel">View Advance Details</h5>
                                                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body" id="loanViewModalContent">
                                                                    <!-- Dynamic content will be injected here -->
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <!-- Delete Confirmation Modal -->
                                                    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content bg-danger text-white">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="confirmDeleteLabel">Confirm Delete</h5>
                                                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete this advance record?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancel</button>
                                                                    <a href="#" class="btn btn-light" id="confirmDeleteBtn">Delete</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    @if ($role == '1')
                                                    <!-- Other Payments Tab -->
                                                    <div class="tab-pane fade" id="nav-other-payments" role="tabpanel">
                                                        <button class="btn btn-sm btn-success mb-3" onclick="open_Other_Payment_form()">
                                                            <i class="fas fa-plus mr-1"></i>Add Other Payment
                                                        </button>
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-striped table-hover" id="other_payments_table">
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
                                                            <table class="table table-bordered table-striped table-hover" id="overtime_table">
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
                                        <button class="btn btn-sm btn-success mb-3" data-toggle="modal" data-target="#leaveModal">
                                            <i class="fas fa-plus mr-1"></i> Apply for Leave
                                        </button>

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover table-hover" id="leave_table">
                                                <thead>
                                                    <tr>
                                                        <th><input type="checkbox" name="delet_data" /></th>
                                                        <th>Leave Type</th>
                                                        <th>Start Date</th>
                                                        <th>End Date</th>
                                                        <th>Department</th>
                                                        <th>Duration</th>
                                                        <th>Applied On</th>
                                                        <th width="15%">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="leave_table_body">
                                                    <!-- Data will be loaded via AJAX -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            {{-- Leave Application Modal --}}
                            <div class="modal fade" id="leaveModal" tabindex="-1" role="dialog" aria-labelledby="leaveModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document"> {{-- Use modal-xl for even more width --}}
                                    <div class="modal-content">
                                        <form action="{{ route('form_request') }}" method="post" id="add_leave_form">
                                            @csrf
                                            <input type="hidden" name="form_type" value="leave_form">
                                            <input type="hidden" id="add_leave_id_input" name="add_leave_id_input">
                                            <input type="hidden" name="Employee_Id" value="{{ $u_data['Employee_id'] ?? '' }}">

                                            <div class="modal-header bg-primary">
                                                <h5 class="modal-title text-white" id="leaveModalLabel">
                                                    <i class="fas fa-plane-departure mr-1"></i> Apply for Leave
                                                </h5>
                                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">

                                                {{-- Leave Type and Dates --}}
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="leave_type_select">Leave Type <span class="text-danger">*</span></label>
                                                        <select id="leave_type_select" class="form-control" name="Leave_Type" required>
                                                            <option value="">Select Leave Type</option>
                                                            @isset($leave_type_master)
                                                                @foreach ($leave_type_master as $ltm)
                                                                    <option value="{{ $ltm->id }}">{{ $ltm->Name }}</option>
                                                                @endforeach
                                                            @endisset
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-md-3">
                                                        <label for="leave_start_date">Start Date <span class="text-danger">*</span></label>
                                                        <input type="date" class="form-control" name="Start_Date" id="leave_start_date" required>
                                                    </div>

                                                    <div class="form-group col-md-3">
                                                        <label for="leave_end_date">End Date <span class="text-danger">*</span></label>
                                                        <input type="date" class="form-control" name="End_Date" id="leave_end_date" required>
                                                    </div>
                                                </div>

                                                {{-- Duration and Status --}}
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="leave_total_days">Total Days <span class="text-danger">*</span></label>
                                                        <input type="number" step="0.5" class="form-control" name="Total_Days" id="leave_total_days" placeholder="Enter total leave days" required>
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="leave_Status">Status <span class="text-danger">*</span></label>
                                                        <select id="leave_Status" class="form-control" name="status" required>
                                                            <option value="">Select Status</option>
                                                            <option value="pending">Pending</option>
                                                            <option value="approved">Approved</option>
                                                            <option value="Rejected">Rejected</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- Descriptions --}}
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="leave_description">Description <span class="text-danger">*</span></label>
                                                        <textarea class="form-control" name="Description" id="leave_description" rows="3" required></textarea>
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="leave_Remarks_by_Approver">Remarks by Approver <span class="text-danger">*</span></label>
                                                        <textarea class="form-control" name="Remarks_by_Approver" id="leave_Remarks_by_Approver" rows="3" required></textarea>
                                                    </div>
                                                </div>

                                                {{-- Notification --}}
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="half_daY_check_box" name="notifaction" value="yes">
                                                        <label class="form-check-label" for="half_daY_check_box">Notify via Email/SMS</label>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="modal-footer justify-content-between">
                                                <button type="submit" class="btn btn-success">
                                                    <i class="fas fa-check-circle mr-1"></i> Submit
                                                </button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    <i class="fas fa-times mr-1"></i> Cancel
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Leave View Modal Placeholder -->
                            <div class="modal fade" id="leaveViewModal" tabindex="-1" role="dialog" aria-hidden="true">
                                <!-- Content gets filled by JS -->
                            </div>

                            <!-- Delete Confirmation Modal -->
                            <div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel" aria-hidden="true">
                                <div class="modal-dialog modal-sm" role="document">
                                    <div class="modal-content border-danger">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="deleteConfirmLabel">
                                                <i class="fas fa-exclamation-triangle mr-1"></i> Confirm Delete
                                            </h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <p class="mb-3">Are you sure you want to delete this leave entry?</p>
                                            <form id="deleteForm" method="POST" action="">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-block">
                                                    <i class="fas fa-trash-alt mr-1"></i> Yes, Delete
                                                </button>
                                                <button type="button" class="btn btn-secondary btn-block mt-2" data-dismiss="modal">
                                                    <i class="fas fa-times mr-1"></i> Cancel
                                                </button>
                                            </form>
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
                                        <button class="btn btn-sm btn-success mb-3" data-toggle="modal" data-target="#attendanceModal">
                                            <i class="fas fa-plus mr-1"></i>Add Attendance Record
                                        </button>

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover" id="Attendance_table">
                                                <thead>
                                                    <tr>
                                                        <th><input type="checkbox" /></th>
                                                        <th>Attendance Date</th>
                                                        <th>In Time</th>
                                                        <th>Out Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="Attendance_table_body"> <!-- Changed tbody id for clarity -->
                                                    <!-- Data will be dynamically loaded here via AJAX -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Attendance Modal --}}

                            <div class="modal fade" id="attendanceModal" tabindex="-1" role="dialog" aria-labelledby="attendanceModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-md" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('form_request') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="form_type" value="Attendance_form">
                                            <input type="hidden" name="Employee_Id" value="{{ $u_data['Employee_id'] ?? '' }}">

                                            <div class="modal-header bg-success">
                                                <h5 class="modal-title" id="attendanceModalLabel">Add Attendance</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true" style="font-size: 28px;">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="attendance_date">Attendance Date <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" name="date" id="attendance_date" required>
                                                </div>
                                            </div>

                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success">Submit</button>
                                            </div>
                                        </form>
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
                                            <table class="table table-bordered table-striped table-hover" id="document_table">
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
</div>
@stop

@section('css')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

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

    span.label {
        font-size: 12px;
        font-weight: bold;
    }

    .ui-datepicker {
        z-index: 9999 !important;
    }
</style>
@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>

    function open_Deduction_form() {
        $('#deductionModal').modal('show');
    }

    function close_Deduction_form() {
        $('#deductionModal').modal('hide');
    }
    $(function () {
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
                            <td style="text-align: end;">
                                <button class="btn btn-sm btn-primary mb-2"
                                    onclick="open_Update_bank_form(
                                        \`${acc.id}\`,
                                        \`${acc.Account_Holder_Name}\`,
                                        \`${acc.Bank_Name}\`,
                                        \`${acc.Account_Number}\`,
                                        \`${acc.IFSC_Code}\`
                                    )">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>


                                <a href="{{url('/delete')}}/${acc.id}/accounts" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
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

    $('#Allowance_form_submit_btn').on('click', function(event) {
        event.preventDefault();
        // Serialize form data
        var formData = $('#add_Allowance_form').serialize();

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
                close_Allowance_form() // Hide the form
                $('#add_Allowance_form')[0].reset(); // Reset the form

                load_allowances_data("{{url('allowances_view_api/')}}/" + {{$u_data['Employee_id']}});
            },
            error: function(xhr, status, error) {
                // Handle error response
                alert('An error occurred: ' + xhr.responseText);
            }
        });
    });

    $(document).ready(function() {
        load_allowances_data("{{url('allowances_view_api/')}}/" + {{$u_data['Employee_id']}});
    });

    function load_allowances_data(url_input) {
        $.ajax({
            url: url_input,
            type: "GET",
            dataType: "json",
            headers: {
                "Content-Type": "application/json"
            },
            success: function (response) {
                const table = $("#allowances_table");
                const tableBody = table.find("tbody");
                tableBody.empty();

                const all_data = response.data;
                all_data.forEach($allowance => {
                    // Format month name properly
                    const monthNames = ["January", "February", "March", "April", "May", "June",
                                       "July", "August", "September", "October", "November", "December"];
                    let monthName = "";
                    let yearValue = $allowance.year;

                    // Check if Month is in YYYY-MM format
                    if (String($allowance.Month).includes("-")) {
                        const dateParts = String($allowance.Month).split("-");
                        if (dateParts.length === 2) {
                            // If already in YYYY-MM format, extract month
                            const monthIndex = parseInt(dateParts[1]) - 1;
                            yearValue = dateParts[0]; // Use year from the date string
                            if (monthIndex >= 0 && monthIndex < 12) {
                                monthName = monthNames[monthIndex];
                            }
                        }
                    } else if (!isNaN($allowance.Month)) {
                        // Handle if it's just a month number
                        const monthIndex = parseInt($allowance.Month) - 1;
                        if (monthIndex >= 0 && monthIndex < 12) {
                            monthName = monthNames[monthIndex];
                        }
                    } else {
                        // Already a month name
                        monthName = $allowance.Month;
                    }

                    const row = `
                        <tr>
                            <td><input type="checkbox" name="delet_data" id=""></td>
                            <td>${monthName} ${yearValue}</td>
                            <td>${$allowance.Alloweance_Titel}</td>
                            <td>${$allowance.Allowance_Ammount_in_INR}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" onclick="Allowances_view('${$allowance.id}')">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-primary" onclick="open_Update_Allowance_form('${$allowance.id}')">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                                <button type="button"
                                        class="btn btn-sm btn-danger"
                                        data-toggle="modal"
                                        data-target="#confirmDeleteModal"
                                        data-href="/delete/${$allowance.id}/alloweance">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </td>
                        </tr>`;
                    tableBody.append(row);
                });

                // Re-initialize DataTables (no column mismatch!)
                if ($.fn.DataTable.isDataTable("#allowances_table")) {
                    table.DataTable().clear().destroy();
                }

                table.DataTable({
                    responsive: true,
                    ordering: true,
                    paging: true,
                    searching: true,
                    autoWidth: false,
                    info: true
                });
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
            }
        });
    }



    function Allowances_view(id) {
        $.ajax({
            type: "GET",
            url: "/alloweance/" + id,
            dataType: "json",
            success: function(response) {
                console.log("Single Allowance Response:", response);
                var r_data = response.data;

                var modalContent = `
                    <div style="display: flex; padding:20px 10px;">
                        <div>
                            <h5>Allowance Title: ${r_data.Alloweance_Titel}</h5>
                            <h5>Amount: ₹ ${r_data.Allowance_Ammount_in_INR}</h5>
                        </div>
                        <div style="margin-left: 40px">
                            <h5>Year: ${r_data.year}</h5>
                            <h5>Month: ${r_data.Month}</h5>
                        </div>
                    </div>
                `;

                $("#viewAllowanceContent").html(modalContent);
                $("#viewAllowanceModal").modal('show');
            },
            error: function(xhr) {
                $("#viewAllowanceContent").html("<p class='text-danger'>Failed to load data.</p>");
                $("#viewAllowanceModal").modal('show');
            }
        });
    }

    $('#confirmDeleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var href = button.data('href');

        // Set the href on the delete button inside modal
        $(this).find('#confirmDeleteBtn').attr('href', href);
    });


    function open_Update_Allowance_form(id) {
        // Update the header text
        $("#addAllowanceModal .modal-title").text("Update Allowance");

        // Set the ID field
        $("#Allowance_id_input").val(id);

        // Open modal
        $('#addAllowanceModal').modal('show');

        // Fetch data and populate the form
        $.ajax({
            type: "GET",
            url: "/alloweance/" + id,
            dataType: "json",
            success: function(response) {
                var r = response.data;
                $("#Allowance_Title").val(r.Alloweance_Titel);
                $("#Allowance_Amount").val(r.Allowance_Ammount_in_INR);
                $("#Month").val(r.Month);
                $("#Year").val(r.year);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }

    function loan_view(id) {
        $.ajax({
            type: "GET",
            url: "/Loan/" + id,
            dataType: "json",
            success: function (response) {
                console.log("Loan Response:", response);

                if (response.success) {
                    var r_data = response.data;

                    // Basic loan information
                    var modalContent = `
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5><strong>Reason:</strong> ${r_data.Reason}</h5>
                                <h5><strong>Amount:</strong> ₹ ${r_data.Loan_Amount_in_INR}</h5>
                                <h5><strong>Installments:</strong> ${r_data.Number_of_installment}</h5>
                            </div>
                            <div class="col-md-6">
                                <h5><strong>Month:</strong> ${r_data.Month}</h5>
                                <h5><strong>Year:</strong> ${r_data.Year || ''}</h5>
                            </div>
                        </div>
                    `;

                    // Installment breakdown section
                    modalContent += `
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3"><strong>Installment Breakdown</strong></h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Sr. No</th>
                                                <th>Month - Year</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                    `;

                    if (r_data.installments && r_data.installments.length > 0) {
                        // Show actual installment records - sort them to ensure proper order
                        const sortedInstallments = [...r_data.installments].sort((a, b) => {
                            // Try to parse dates for comparison
                            const dateA = new Date(a.Month?.replace(/(\w+)\s+(\d{4})/, "$2-$1-01") || "");
                            const dateB = new Date(b.Month?.replace(/(\w+)\s+(\d{4})/, "$2-$1-01") || "");

                            if (!isNaN(dateA) && !isNaN(dateB)) {
                                return dateA - dateB;
                            }
                            return 0; // Keep original order if can't parse
                        });

                        sortedInstallments.forEach((installment, index) => {
                            modalContent += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${installment.Month || 'N/A'}</td>
                                    <td>₹ ${parseFloat(installment.Amount || 0).toFixed(2)}</td>
                                </tr>
                            `;
                        });
                    } else {
                        // Generate installments if missing
                        const totalAmount = parseFloat(r_data.Loan_Amount_in_INR);
                        const numberOfInstallments = parseInt(r_data.Number_of_installment);

                        if (totalAmount && numberOfInstallments) {
                            const installmentAmount = (totalAmount / numberOfInstallments).toFixed(2);

                            // Parse the date properly
                            let startDate;
                            try {
                                // Check if Month is in yyyy-mm-dd format
                                if (r_data.Month && r_data.Month.match(/^\d{4}-\d{2}-\d{2}$/)) {
                                    startDate = new Date(r_data.Month);
                                }
                                // Check if Month is in yyyy-mm format
                                else if (r_data.Month && r_data.Month.match(/^\d{4}-\d{2}$/)) {
                                    startDate = new Date(r_data.Month + "-01");
                                }
                                // Otherwise use current date
                                else {
                                    startDate = new Date();
                                }

                                // Validate that we have a valid date
                                if (isNaN(startDate.getTime())) {
                                    startDate = new Date(); // Use current date as fallback
                                }
                            } catch (e) {
                                console.error("Date parsing error:", e);
                                startDate = new Date(); // Use current date as fallback
                            }

                            // UPDATED: Start with NEXT month after the loan month (to match backend logic)
                            const baseYear = startDate.getFullYear();
                            let baseMonth = startDate.getMonth() + 1 + 1; // +1 for zero-based months, +1 for NEXT month

                            // Handle month overflow
                            let adjustedBaseYear = baseYear;
                            if (baseMonth > 12) {
                                baseMonth = baseMonth - 12;
                                adjustedBaseYear++;
                            }

                            for (let i = 0; i < numberOfInstallments; i++) {
                                // Calculate each installment month
                                const currentMonth = (baseMonth + i - 1) % 12 + 1; // Convert to 1-12 range
                                const currentYear = adjustedBaseYear + Math.floor((baseMonth + i - 1) / 12);

                                // Create date object for formatting
                                const monthDate = new Date(currentYear, currentMonth - 1, 1);

                                // Format the date properly
                                const monthName = monthDate.toLocaleString("default", { month: "long" });
                                const formattedDate = `${monthName} ${currentYear}`;

                                modalContent += `
                                    <tr>
                                        <td>${i + 1}</td>
                                        <td>${formattedDate}</td>
                                        <td>₹ ${installmentAmount}</td>
                                    </tr>
                                `;
                            }
                        } else {
                            modalContent += `
                                <tr>
                                    <td colspan="3" class="text-center">No installment data available</td>
                                </tr>
                            `;
                        }
                    }

                    modalContent += `
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    `;

                    $("#loanViewModalContent").html(modalContent);
                    $("#loanViewModal").modal("show");

                } else {
                    $("#loanViewModalContent").html(`<p class="text-danger">${response.message}</p>`);
                    $("#loanViewModal").modal("show");
                }
            },
            error: function (xhr) {
                console.log("Error:", xhr.responseText);
                $("#loanViewModalContent").html(`<p class="text-danger">Something went wrong.</p>`);
                $("#loanViewModal").modal("show");
            }
        });
    }

    $('#confirmDeleteModal').on('show.bs.modal', function(e) {
        var href = $(e.relatedTarget).data('href');
        $('#confirmDeleteBtn').attr('href', href);
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

    load_basic_salary_data("{{url('basic_salary_api/')}}/" + {{$u_data['Employee_id']}})

    function load_basic_salary_data(url_input) {
        $.ajax({
            url: url_input,
            type: "GET",
            dataType: "json",
            success: function (response) {
                const table = $('#basic_salary_table');
                const tableBody = table.find('tbody');
                tableBody.empty(); // Clear old data

                response.data.forEach((salary) => {
                // Convert numeric month to name
                const monthNames = ["January", "February", "March", "April", "May", "June",
                                    "July", "August", "September", "October", "November", "December"];

                const parts = salary.month.split("-"); // e.g., "2024-03"
                const year = salary.year;
                let monthName = "Invalid";

                if (parts.length === 2) {
                    const monthIndex = parseInt(parts[1], 10) - 1; // Convert "03" to 2
                    if (monthIndex >= 0 && monthIndex < 12) {
                        monthName = monthNames[monthIndex];
                    }
                }

                const row = `
                    <tr>
                        <td><input type="checkbox" class="row_checkbox" value="${salary.id}"></td>
                        <td>${monthName} ${year}</td>
                        <td>${salary.Basic_Salary}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-info" onclick="basic_salary_view('${salary.id}')">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                                <button class="btn btn-warning" onclick="open_basic_salary_update_form('${salary.id}')">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                            </div>
                        </td>
                    </tr>`;
                tableBody.append(row);
            });


                // Re-initialize DataTable
                if ($.fn.DataTable.isDataTable("#basic_salary_table")) {
                    table.DataTable().clear().destroy();
                }

                table.DataTable({
                    responsive: true,
                    ordering: true,
                    paging: true,
                    searching: true,
                    autoWidth: false,
                    info: true
                });
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
            }
        });
    }



    function basic_salary_view(id) {
        $("#basicSalaryModal").modal('show'); // Open modal
        $("#basic_salary_modal_body").html('<p class="text-muted text-center">Loading...</p>');

        $.ajax({
            type: "GET",
            url: "{{ url('/basic-salary') }}/" + id,
            dataType: "json",
            success: function(response) {
                console.log(response);
                var r = response.data;

                let html = `
                    <div class="px-2">
                        <h5><strong>Basic Salary:</strong> ₹${r.Basic_Salary}</h5>
                        <h5><strong>Month:</strong> ${r.month}</h5>
                        <h5><strong>Year:</strong> ${r.year}</h5>
                    </div>
                `;

                $("#basic_salary_modal_body").html(html);
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                $("#basic_salary_modal_body").html('<div class="text-danger">Failed to load data.</div>');
            }
        });
    }

    function confirmDeleteSalary(id) {
        const form = document.getElementById("deleteSalaryForm");
        form.action = `{{ url('/delete') }}/${id}/basic_salary`;
        $('#deleteSalaryModal').modal('show');
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

    function open_Basic_Salary_form() {
        $('#BasicSalaryModal').modal('show');
        $('#Basic_Salary_form_header').text('Add Basic Salary');
        $('#Add_Basic_Salary_form')[0].reset();
        $('#basic_salary_input_id').val('');
    }


    function open_basic_salary_update_form(id) {
        $('#BasicSalaryModal').modal('show'); // show modal
        $("#Basic_Salary_form_header").text("Update Basic Salary");
        $("#basic_salary_input_id").val(id);

        $.ajax({
            type: "GET",
            url: "{{ url('/basic-salary/') }}/" + id,
            dataType: "json",
            success: function(response) {
                var r_data = response.data;
                $("#Basic_Salary_amount").val(r_data.Basic_Salary);
                $("#Basic_Salary_month").val(r_data.month);
                $("#Basic_Salary_year").val(r_data.year);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }

//    $(document).ready(function() {
//        // Handle form submission
//        $('#Add_Basic_Salary_form_Btn').on('click', function(event) {
//            event.preventDefault();
//            // Serialize form data
//            var formData = $('#Add_Basic_Salary_form').serialize();

//            // Make AJAX POST request
//            $.ajax({
//                url: "{{ route('form_request') }}", // Laravel route
//                method: "POST",
//                data: formData,
//                headers: {
//                    'X-CSRF-TOKEN': $('input[name="_token"]').val() // CSRF token
//                },
//                success: function(response) {
//                    // Handle success response
//                    alert(response.message);
//                    close_Basic_Salary_form() // Hide the form
//                    $('#Add_Basic_Salary_form')[0].reset(); // Reset the form
//                    load_basic_salary_data("{{url('basic_salary_api/')}}/" + {{$u_data['Employee_id']}})
//                },
//                error: function(xhr, status, error) {
//                    // Handle error response
//                    alert('An error occurred: ' + xhr.responseText);
//                }
//            });
//        });
//    });

   load_deductions_data("{{url('Deductions_view_api/')}}/" + {{$u_data['Employee_id']}});

   // First, load the deductions
function load_deductions_data(url_input) {
    // First, fetch all loans to create a lookup table
    $.ajax({
        url: url_input, // Endpoint that returns all loans for the employee
        type: "GET",
        dataType: "json",
        success: function(loansResponse) {
            // Create a lookup map of loan IDs to reasons
            var loanReasons = {};
            if (loansResponse.success && loansResponse.data) {
                loansResponse.data.forEach(function(loan) {
                    loanReasons[loan.id] = loan.Reason;
                    if (loan.Loan_id) {
                        loanReasons[loan.Loan_id] = loan.Reason;
                    }
                });
            }

            // Now fetch and display deductions with loan reasons
            fetchDeductions(url_input, loanReasons);
        },
        error: function(xhr, status, error) {
            console.error("Error fetching loans:", error);
            // Still try to fetch deductions even if loans fetch fails
            fetchDeductions(url_input, {});
        }
    });
}

function fetchDeductions(url_input) {
    $.ajax({
        url: url_input,
        type: "GET",
        dataType: "json",
        success: function(response) {
            console.log("Deduction Response:", response);

            // Empty the table body
            $("#Deductions_table tbody").empty();

            // Table Header
            var table_html_data = `
                <thead>
                    <tr>
                        <th><input type="checkbox" name="delet_data" id=""></th>
                        <th>Month-Year</th>
                        <th>Title/Reason</th>
                        <th>(₹) Amount</th>
                        <th>Against Advance</th>
                        <th>Paid Flag</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>`;

            // Populate Table Rows
            var all_data = response.data;
            all_data.forEach(function($deduction) {
                const againstAdvance = ($deduction.Advance_Ids && $deduction.Advance_Ids != 0) ? "Yes" : "No";
                const paidFlag = ($deduction.Deduction_Paid_Flag == 1) ? "Yes" : "No";

                // Combine title and reason if available
                let titleDisplay = $deduction.deduction_Titel || "";

                // Check if this deduction is against an advance and we have a reason for it
                if (againstAdvance === "Yes" && $deduction.loan_reason) {
                    titleDisplay += ` <small class="text-muted">(${$deduction.loan_reason})</small>`;
                }

                // Conditional buttons based on paid flag
                let actionButtons = `
                    <button type="button" class="btn btn-sm btn-info" onclick="Deductions_view('${$deduction.id}')">
                        <i class="fa-regular fa-eye"></i>
                    </button>`;

                // Only show edit and delete buttons if Deduction_Paid_Flag is not 1
                if ($deduction.Deduction_Paid_Flag != 1) {
                    actionButtons += `
                        <button type="button" class="btn btn-sm btn-primary" onclick="open_Update_Deduction_form('${$deduction.id}')">
                            <i class="fa-solid fa-pencil"></i>
                        </button>
                        <button type="button"
                                class="btn btn-sm btn-danger"
                                data-toggle="modal"
                                data-target="#confirmDeleteModal"
                                data-href="/delete/${$deduction.id}/deductions">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>`;
                }

                table_html_data += `
                    <tr>
                        <td><input type="checkbox" name="delet_data" id=""></td>
                        <td>${$deduction.Month || ""}</td>
                        <td>${titleDisplay}</td>
                        <td>${$deduction.deduction_Amount_in_INR ? parseFloat($deduction.deduction_Amount_in_INR).toFixed(2) : ""}</td>
                        <td>${againstAdvance}</td>
                        <td>${paidFlag}</td>
                        <td>${actionButtons}</td>
                    </tr>`;
            });

            table_html_data += `</tbody>`;

            // Append the data to the table
            $("#Deductions_table").html(table_html_data);

            // Reinitialize DataTables after data is loaded
            if ($.fn.DataTable.isDataTable('#Deductions_table')) {
                $('#Deductions_table').DataTable().clear().destroy();
            }

            $('#Deductions_table').DataTable({
                responsive: true,
                ordering: true,
                paging: true,
                searching: true,
                autoWidth: false,
                info: true
            });
        },
        error: function(xhr, status, error) {
            console.error("Error:", error);
        }
    });
}

    function Deductions_view(id) {
        $.ajax({
            url: "{{ url('/Deductions') }}/" + id,
            type: "GET",
            dataType: "json",
            success: function(response) {
                const deduction = response.data;

                // Build the HTML content dynamically
                const viewContent = `
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Deduction Amount:</strong> ₹ ${deduction.deduction_Amount_in_INR || '0'}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Year:</strong> ${deduction.Year || 'N/A'}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Deduction Title:</strong> ${deduction.deduction_Titel || 'N/A'}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Month:</strong> ${deduction.Month || 'N/A'}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Paid:</strong> ${deduction.Deduction_Paid_Flag == 1 ? 'Yes' : 'No'}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Against Advance:</strong> ${deduction.Advance_Ids && deduction.Advance_Ids != 0 ? 'Yes' : 'No'}</p>
                        </div>
                    </div>
                `;

                // Set the content inside the modal body
                $("#deductionViewModal .modal-body").html(viewContent);

                // Show the modal
                $("#deductionViewModal").modal("show");
            },
            error: function(xhr, status, error) {
                console.error("Error fetching deduction details:", error);
                alert("Unable to fetch deduction details. Please try again.");
            }
        });
    }



    function open_Update_Deduction_form(id) {
        open_Deduction_form();
        $("#add_deductions_form_header").text("Update Deduction");
        $("#Deduction_id_input").val(id);

        $.ajax({
            type: "GET",
            url: "{{url('/Deductions/')}}/" + id,
            dataType: "json",
            success: function(response) {
                console.log(response);
                var r_data = response.data;
                $("#Deduction_Title").val(r_data.deduction_Titel);
                $("#Deduction_Amount").val(r_data.deduction_Amount_in_INR);

                // Extract the date from deductions_Month and convert back to the original input month
                // The stored deductions_Month is for the next month (e.g., "2025-04-15" for April)
                // We need to display the previous month (e.g., "2025-03" for March)
                const deductionFullDate = r_data.deductions_Month; // e.g., "2025-04-15"
                const parts = deductionFullDate.split('-');

                // Get the year and month from the stored date
                let year = parseInt(parts[0]);
                let month = parseInt(parts[1]);

                // Calculate the previous month (the month that was originally selected)
                month = month - 1;
                if (month === 0) {
                    month = 12;
                    year = year - 1;
                }

                // Format month with leading zero if needed
                const formattedMonth = month.toString().padStart(2, '0');

                // Create the value in YYYY-MM format for the month input
                const originalMonth = `${year}-${formattedMonth}`;

                // Set the value of the month input
                $("#Deduction_month").val(originalMonth);
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                // Handle the error here
            }
        });
    }

    $("#add_deductions_form").on('submit', function(e) {
        e.preventDefault();

        // Show loading indicator if needed
        // $("#_submit_btn").html('<i class="fa fa-spinner fa-spin"></i> Processing...');
        $("#_submit_btn").prop('disabled', true);

        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    // Success message
                    alert(response.message);
                    // Close modal
                    close_Deduction_form();
                    // Reload data or update UI as needed
                    location.reload(); // or update just the table
                } else {
                    // Error message
                    alert("Error: " + response.message);
                }
                $("#_submit_btn").prop('disabled', false);
            },
            error: function(xhr, status, error) {
                console.error("Error submitting form:", xhr.responseText);
                alert("An error occurred. Please try again.");
                $("#_submit_btn").prop('disabled', false);
            }
        });
    });

    // Optional: Form validation
    $("#Deduction_Amount").on('input', function() {
        // Allow only numbers and decimal point
        $(this).val($(this).val().replace(/[^0-9.]/g, ''));
    });



    load_loan_data("{{ url('loan_view_api/' . $u_data['Employee_id']) }}");

    function load_loan_data(url_input) {
    // Show a loading indicator (optional)
    $.ajax({
        url: url_input,
        type: "GET",
        dataType: "json",
        headers: {
            "Content-Type": "application/json"
        },
        success: function (response) {
            console.log("Loan Response:", response);
            $("#loan_view_table").empty(); // Clear tbody contents

            let table_html_data = ``;
            let all_data = response.data;

            if (all_data && all_data.length > 0) {
                all_data.forEach(loan => {
                    const date = new Date(loan.Month);
                    const formattedDate = date.toLocaleDateString('en-US', { year: 'numeric', month: 'long' });

                    table_html_data += `
                        <tr>
                            <td><input type="checkbox" name="delet_data"></td>
                            <td>${formattedDate}</td>
                            <td>${loan.Reason || '-'}</td>
                            <td>${loan.Number_of_installment || '-'}</td>
                            <td>₹ ${loan.Loan_Amount_in_INR || '0'}</td>
                            <td>₹ ${loan.Loan_Remaining || '0'}</td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="loan_view('${loan.id}')"><i class="fas fa-eye"></i></button>
                                <button type="button" class="btn btn-sm btn-info" onclick="open_loan_modal('${loan.id}')">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <a href="{{ url('/delete') }}/${loan.id}/loan" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>`;
                });

                // Update the table body with rows
                $("#loan_view_table").html(table_html_data);

                // Destroy and reinitialize DataTable only if there's data
                if ($.fn.DataTable.isDataTable('#loan_table')) {
                    $('#loan_table').DataTable().clear().destroy();
                }

                $('#loan_table').DataTable({
                    responsive: true,
                    ordering: true,
                    paging: true,
                    searching: true,
                    autoWidth: false,
                    info: true,
                    columns: [
                        { orderable: false }, // checkbox
                        null,                 // Month-Year
                        null,                 // Reason
                        null,                 // Installment
                        null,                 // Amount
                        null,                 // Remaining
                        { orderable: false }  // Actions
                    ]
                });

            } else {
                // Show fallback row only, skip DataTable initialization
                table_html_data = '<tr><td colspan="7" class="text-center">No loan data available</td></tr>';
                $("#loan_view_table").html(table_html_data);

                // Destroy any existing DataTable
                if ($.fn.DataTable.isDataTable('#loan_table')) {
                    $('#loan_table').DataTable().clear().destroy();
                }
            }

            // Debug log of rendered HTML
            // console.log("Generated HTML:", table_html_data);
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
            $("#loan_view_table").html('<tr><td colspan="7" class="text-center">Error loading data. Please try again.</td></tr>');
        }
    });
}



    // Function to open the loan/advance modal
    function open_loan_modal(id = null) {
        // Reset the form first
        $("#add_loan_form")[0].reset();
        console.log("Form data:", $(this).serialize());
        $("#monthList").empty();

        if (id) {
            // Update mode
            $(".modal-title").html('<i class="fas fa-money-check-alt mr-1"></i> Update Advance');
            $("#loan_Id_input").val(id);

            // Fetch existing loan data
            $.ajax({
                type: "GET",
                url: "/Loan/" + id,
                dataType: "json",
                success: function(response) {
                    console.log("Response:", response);

                    if (response.success) {
                        const r_data = response.data;

                        // Populate form fields with response data
                        // For month field (appears to be using a date picker)
                        if (r_data.Month) {
                            $("#loan_month").val(r_data.Month.slice(0, 7));
                        }

                        // For other fields (using the IDs from the screenshot)
                        $("#loan_reason").val(r_data.Reason || "");
                        $("#loan_amount").val(r_data.Loan_Amount_in_INR || "");
                        $("#number_of_loan_installment").val(r_data.Number_of_installment || "");

                        // Generate installment table
                        if (r_data.installments && r_data.installments.length > 0) {
                            genrate_table(r_data.installments);
                        } else {
                            setTimeout(genrate_table, 100); // Small delay to ensure values are set
                        }
                    } else {
                        console.warn("Error in response:", response.message || "Unknown error");
                        alert("Error loading data. Please try again.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", status, error);
                    alert("Error loading data. Please try again.");
                }
            });
        } else {
            // Add new mode
            $(".modal-title").html('<i class="fas fa-money-check-alt mr-1"></i> Add Advance');
            $("#loan_Id_input").val("");
        }

        // Open the modal
        $("#loanModal").modal("show");
    }

    // Modify your genrate_table function to include hidden inputs
    function genrate_table(existingInstallments = null) {
        // Clear previous results
        $("#monthList").empty();

        // Remove any existing hidden input container
        $(".installment-hidden-inputs").remove();

        // Create a new container for hidden inputs
        const hiddenInputsContainer = $("<div class='installment-hidden-inputs'></div>");
        $("#add_loan_form").append(hiddenInputsContainer);

        if (existingInstallments && existingInstallments.length > 0) {
            for (let i = 0; i < existingInstallments.length; i++) {
                const installment = existingInstallments[i];
                $("#monthList").append(`
                    <tr>
                        <td>${i + 1}</td>
                        <td>${installment.Month || 'Unknown'}</td>
                        <td>${parseFloat(installment.Amount || 0).toFixed(2)}</td>
                    </tr>
                `);

                hiddenInputsContainer.append(`
                    <input type="hidden" name="installments[${i}][Month]" value="${installment.Month || ''}">
                    <input type="hidden" name="installments[${i}][Amount]" value="${parseFloat(installment.Amount || 0).toFixed(2)}">
                    <input type="hidden" name="installments[${i}][Id]" value="${installment.Id || ''}">
                `);
            }
        } else {
            const selectedDate = $("#loan_month").val();
            const number_of_loop = parseInt($("#number_of_loan_installment").val()) || 0;
            const advance_amount = parseFloat($("#loan_amount").val()) || 0;

            if (selectedDate && number_of_loop > 0 && advance_amount > 0) {
                const startDate = new Date(selectedDate);
                const year = startDate.getFullYear();
                const startMonth = startDate.getMonth() + 1; // Start from next month

                for (let i = 0; i < number_of_loop; i++) {
                    const monthDate = new Date(year, startMonth + i, 1);
                    const monthName = monthDate.toLocaleString("default", { month: "long" });
                    const displayYear = monthDate.getFullYear();
                    const installmentAmount = (advance_amount / number_of_loop).toFixed(2);
                    const monthYearString = `${monthDate.getFullYear()}-${String(monthDate.getMonth() + 1).padStart(2, '0')}`;

                    $("#monthList").append(`
                        <tr>
                            <td>${i + 1}</td>
                            <td>${monthName} ${displayYear}</td>
                            <td>${installmentAmount}</td>
                        </tr>
                    `);

                    hiddenInputsContainer.append(`
                        <input type="hidden" name="installments[${i}][Month]" value="${monthYearString}">
                        <input type="hidden" name="installments[${i}][Amount]" value="${installmentAmount}">
                    `);
                }
            }
        }
    }


    // Make sure your edit buttons use this function
    $(document).ready(function() {
        // For your "Add Advance" button
        $(document).on("click", ".add-advance-btn", function() {
            open_loan_modal();
        });

        // For your edit icons in the table
        $(document).on("click", ".edit-loan-btn", function() {
            const loanId = $(this).data("id");
            open_loan_modal(loanId);
        });
    });

    $(document).ready(function() {
        $('#loan_form_submit_btn').on('click', function(event) {
            event.preventDefault();

            // Make sure all required fields are filled
            if(!$('#loan_month').val() || !$('#loan_amount').val() || !$('#number_of_loan_installment').val() || !$('#loan_reason').val()) {
                alert('Please fill all required fields');
                return;
            }


            // Format the month input for the backend as "YYYY-MM-DD"
            var monthInput = $('#loan_month').val(); // Format: "2025-03"
            var formattedDate = monthInput + "-01"; // Add day to make it "2025-03-01"

            var formData = {
                form_type: "Loan_form",
                Employee_Id: $('input[name="Employee_Id"]').val(),
                Month: formattedDate, // Use "2025-03-01" format
                Amount: $('#loan_amount').val(),
                Number_of_installment: $('#number_of_loan_installment').val(),
                Reason: $('#loan_reason').val(),
                loan_Id_input: $('#loan_Id_input').val() || '',
                _token: $('input[name="_token"]').val()
            };

            console.log("Form data being sent:", formData);

            $.ajax({
                url: $('#add_loan_form').attr('action'),
                method: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                beforeSend: function() {
                    // Show loading state
                    $('#loan_form_submit_btn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');
                },
                success: function(response) {
                    console.log("Success response:", response);
                    if(response.success) {
                        alert(response.message);
                        $('#loanModal').modal('hide');
                        $('#add_loan_form')[0].reset();
                        $("#loanModalLabel").html('<i class="fas fa-money-check-alt mr-1"></i> Add Advance');
                        // Check if function exists to avoid undefined errors
                        window.location.reload();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', xhr.responseText);
                    alert('An error occurred. Please try again later.');
                },
                complete: function() {
                    // Re-enable button
                    $('#loan_form_submit_btn').prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Submit');
                }
            });
        });
    });




    load_leave_data("{{ url('Leave_view_api/' . $u_data['Employee_id']) }}");

    function load_leave_data(url_input) {
        $.ajax({
            url: url_input,
            type: "GET",
            dataType: "json",
            headers: {
                "Content-Type": "application/json"
            },
            success: function(response) {
                console.log("Leave Response:", response);
                const $table = $('#leave_table');

                // Destroy existing instance if exists
                if ($.fn.DataTable.isDataTable($table)) {
                    $table.DataTable().destroy();
                }

                $("#leave_table_body").empty();

                let table_rows = '';
                const all_data = response.data;

                all_data.forEach($leave => {
                    table_rows += `
                        <tr>
                            <td><input type="checkbox" name="delet_data"></td>
                            <td>${$leave.Leave_Type}</td>
                            <td>${formatDate($leave.Start_Date)}</td>
                            <td>${formatDate($leave.End_Date)}</td>
                            <td>${$leave.notification}</td>
                            <td>${$leave.Total_Days}</td>
                            <td>${$leave.created_at}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-info" onclick="Leave_view('${$leave.id}')" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning" onclick="open_Update_leave_form('${$leave.id}')" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="{{ url('/delete') }}/${$leave.id}/_leave" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>`;
                });

                $("#leave_table_body").html(table_rows);

                // Re-initialize DataTable after populating
                $table.DataTable({
                    responsive: true,
                    ordering: true,
                    paging: true,
                    searching: true,
                    autoWidth: false,
                    info: true
                });
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
            }
        });
    }
    function formatDate(dateStr) {
        if (!dateStr) return '';
        const date = new Date(dateStr);
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0'); // Month is 0-based
        const year = date.getFullYear();
        return `${day}-${month}-${year}`;
    }




    function Leave_view(id) {
        $.ajax({
            type: "GET",
            url: "{{ url('/leave-view') }}/" + id,
            dataType: "json",
            success: function (response) {
                const r = response.data;

                const modalHtml = `
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h5 class="modal-title text-white"><i class="fas fa-eye mr-1"></i> Leave Details</h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Start Date</label>
                                                <input type="text" class="form-control" value="${r.Start_Date}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>End Date</label>
                                                <input type="text" class="form-control" value="${r.End_Date}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Remarks By Approver</label>
                                                <textarea class="form-control" rows="2" readonly>${r.Remarks_by_Approve}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Half Day</label>
                                                <input type="text" class="form-control" value="${r.Half_Day}" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <input type="text" class="form-control" value="${r.Status}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Total Days</label>
                                                <input type="text" class="form-control" value="${r.Total_Days}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Leave Type</label>
                                                <input type="text" class="form-control" value="${r.Leave_Type}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea class="form-control" rows="2" readonly>${r.Description}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                    <i class="fas fa-times mr-1"></i> Close
                                </button>
                            </div>
                        </div>
                    </div>`;

                $("#leaveViewModal").html(modalHtml);
                $("#leaveViewModal").modal("show");
            },
            error: function (xhr) {
                console.error("Error loading leave data:", xhr.responseText);
            }
        });
    }

    function open_Update_leave_form(id) {
        // Clear previous errors and form
        $('#add_leave_form')[0].reset();
        $('#add_leave_id_input').val(id); // set hidden field

        $.ajax({
            type: "GET",
            url: `/leave-view/${id}`, // update as per your route
            dataType: "json",
            success: function(response) {
                const data = response.data;

                // Fill form fields
                $('#leave_type_select').val(data.Leave_Type);
                $('#leave_start_date').val(data.Start_Date);
                $('#leave_end_date').val(data.End_Date);
                $('#leave_total_days').val(data.Total_Days);
                $('#leave_Status').val(data.Status);
                $('#leave_description').val(data.Description);
                $('#leave_Remarks_by_Approver').val(data.Remarks_by_Approve);

                if (data.Half_Day === 'yes') {
                    $('#half_daY_check_box').prop('checked', true);
                } else {
                    $('#half_daY_check_box').prop('checked', false);
                }

                // Update Modal Title & Button (Optional but clean)
                $('#leaveModalLabel').html('<i class="fas fa-edit mr-1"></i> Update Leave');
                $('#add_leave_form button[type="submit"]').html('<i class="fas fa-save mr-1"></i> Update');

                // Show modal
                $('#leaveModal').modal('show');
            },
            error: function(xhr) {
                console.error('Error fetching data:', xhr.responseText);
            }
        });
    }

    load_attendance_data("{{url('Attendance_view_user_api/')}}/" + {{$u_data['Employee_id']}});

    function load_attendance_data(url_input) {
        $.ajax({
            url: url_input,
            type: "GET",
            dataType: "json",
            headers: {
                "Content-Type": "application/json"
            },
            success: function (response) {
                console.log("Attendance Response:", response);

                const $table = $('#Attendance_table');
                let table_html_data = "";
                const all_data = response.data;

                // Clear existing rows
                $("#Attendance_table_body").empty();

                if (all_data && all_data.length > 0) {
                    all_data.forEach($attendance => {
                        table_html_data += `
                            <tr>
                                <td><input type="checkbox" /></td>
                                <td>${formatDate($attendance.attandence_Date)}</td>
                                <td>${$attendance.in_time || '-'}</td>
                                <td>${$attendance.out_time || '-'}</td>
                            </tr>`;
                    });

                    $("#Attendance_table_body").html(table_html_data);

                    // Destroy and reinitialize DataTable
                    if ($.fn.DataTable.isDataTable($table)) {
                        $table.DataTable().clear().destroy();
                    }

                    $table.DataTable({
                        responsive: true,
                        ordering: true,
                        paging: true,
                        searching: true,
                        autoWidth: false,
                        info: true,
                        columns: [
                            { orderable: false }, // checkbox
                            null,                 // Attendance Date
                            null,                 // In Time
                            null                  // Out Time
                        ]
                    });

                } else {
                    table_html_data = `
                        <tr>
                            <td colspan="4" class="text-center">No attendance records found</td>
                        </tr>`;
                    $("#Attendance_table_body").html(table_html_data);

                    // Destroy any existing DataTable to avoid error
                    if ($.fn.DataTable.isDataTable($table)) {
                        $table.DataTable().clear().destroy();
                    }
                }

                // Debug log
                // console.log("Generated Attendance HTML:", table_html_data);
            },
            error: function (xhr, status, error) {
                console.error("Error loading attendance data:", error);
                $("#Attendance_table_body").html('<tr><td colspan="4" class="text-center">Error loading data. Please try again.</td></tr>');
            }
        });
    }


    $(document).ready(function() {
        $("#penalties_table").DataTable({
            "columnDefs": [
                { "orderable": false, "targets": -1 }
            ]
        });

        $('#penaltyModal').on('shown.bs.modal', function() {
            $("#penalty-date, #waived-on, .payment-date").datepicker({
                dateFormat: "dd-mm-yy",
                changeMonth: true,
                changeYear: true,
                yearRange: "2000:2035"
            });
        });

        let paymentIndex = 1;

        function createPaymentRow(payment = { amount: '', date: '' }) {
            const html = `
                <div class="row payment-row mb-2">
                    <div class="col-md-5">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                            </div>
                            <input type="text" name="payments[${paymentIndex}][amount]" class="form-control" placeholder="Paid Amount" value="${payment.amount}">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                            </div>
                            <input type="text" name="payments[${paymentIndex}][date]" class="form-control payment-date" placeholder="Paid Date" value="${payment.date}">
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-center">
                        <button type="button" class="btn btn-danger btn-sm remove-payment"><i class="fas fa-trash"></i></button>
                    </div>
                </div>`;

            paymentIndex++;
            return html;
        }

        $('#add-payment').click(function() {
            $('#payment-rows').append(createPaymentRow());

            $(".payment-date").datepicker({
                dateFormat: "dd-mm-yy",
                changeMonth: true,
                changeYear: true,
                yearRange: "2000:2035"
            });
        });

        $(document).on('click', '.remove-payment', function() {
            $(this).closest('.payment-row').remove();
        });

        $('.edit-penalty').on('click', function() {
            $('#penalty-id').val($(this).data('id'));
            $('#penalty-amount').val($(this).data('amount'));
            $('#penalty-date').val($(this).data('date'));
            $('#waived-off').val($(this).data('waived'));
            $('#waived-off-by').val($(this).data('waived-by'));
            $('#waived-on').val($(this).data('waived-on'));
            $('#penalty-reason').val($(this).data('reason'));
            $('#waive-off-reason').val($(this).data('waive-reason'));

            $('#penaltyModalLabel').html('<i class="fas fa-edit mr-2"></i> Edit Penalty');
            $('#save-penalty-btn').html('Update Penalty <i class="fas fa-save ml-1"></i>');

            // Reset old payments
            $('#payment-rows').empty();
            paymentIndex = 1;

            let payments = $(this).data('payments');
            if (payments && payments.length > 0) {
                payments.forEach(function(payment) {
                    $('#payment-rows').append(createPaymentRow(payment));
                });

                $(".payment-date").datepicker({
                    dateFormat: "dd-mm-yy",
                    changeMonth: true,
                    changeYear: true,
                    yearRange: "2000:2035"
                });
            }

            $('#penaltyModal').modal('show');
        });

        $('[data-target="#penaltyModal"]').on('click', function() {
            $('#add_penalty_form')[0].reset();
            $('#penalty-id').val('');
            $('#payment-rows').empty();
            paymentIndex = 1;
            $('#payment-rows').append(createPaymentRow());

            $('#penaltyModalLabel').html('<i class="fas fa-minus-circle mr-2"></i> Add Penalty');
            $('#save-penalty-btn').html('Add Penalty <i class="fas fa-arrow-right ml-1"></i>');
        });
    });

</script>
@stop

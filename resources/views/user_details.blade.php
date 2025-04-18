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
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-striped" id="Deductions_table">
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

                                                                <div class="form-group row">
                                                                <div class="col-md-6">
                                                                    <label class="input_lable_p">Month *</label>
                                                                    <input type="month" class="form-control" id="Deduction_month" name="Month_Year" required>
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
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-striped" id="loan_table">
                                                                <thead>
                                                                    <tr>
                                                                        <th><input type="checkbox" name="delet_data"></th>
                                                                        <th>Advance Title</th>
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
                                                                            <label for="loan_title">Title <span class="text-danger">*</span></label>
                                                                            <input type="text" name="Title" id="loan_title" class="form-control" placeholder="Advance title" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="loan_amount">(₹) Amount <span class="text-danger">*</span></label>
                                                                            <input type="number" name="Amount" id="loan_amount" class="form-control" placeholder="Amount in INR" onkeyup="genrate_table()" required>
                                                                        </div>
                                                                    </div>
                                                                    </div>

                                                                    <div class="row">
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
                                                                    <table class="table table-bordered table-striped">
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
                                        <button class="btn btn-sm btn-success mb-3" data-toggle="modal" data-target="#leaveModal">
                                            <i class="fas fa-plus mr-1"></i> Apply for Leave
                                        </button>

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover">
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
                                                <tbody id="leave_table">
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
                                            <table class="table table-bordered table-striped" id="Attendance_table">
                                                <thead>
                                                    <tr>
                                                        <th><input type="checkbox" /></th>
                                                        <th>Attendance Date</th>
                                                        <th>In Time</th>
                                                        <th>Out Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
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
    function open_Deduction_form() {
        $('#deductionModal').modal('show');
    }

    function close_Deduction_form() {
        $('#deductionModal').modal('hide');
    }
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
                                <button type="button"
                                        class="btn btn-sm btn-danger"
                                        data-toggle="modal"
                                        data-target="#confirmDeleteModal"
                                        data-href="/delete/${$allowance.id}/alloweance">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>

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



    $(document).ready(function() {
        load_deductions_data("{{url('Deductions_view_api/')}}/" + {{$u_data['Employee_id']}});
    });



    function loan_view(id) {
        $.ajax({
            type: "GET",
            url: "/Loan/" + id,
            dataType: "json",
            success: function(response) {
                console.log("Loan Response:", response);

                if (response.success) {
                    var r_data = response.data;

                    // Basic loan information
                    var modalContent = `
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5><strong>Title:</strong> ${r_data.Title}</h5>
                                <h5><strong>Amount:</strong> ₹ ${r_data.Loan_Amount_in_INR}</h5>
                                <h5><strong>Installments:</strong> ${r_data.Number_of_installment}</h5>
                            </div>
                            <div class="col-md-6">
                                <h5><strong>Month:</strong> ${r_data.Month}</h5>
                                <h5><strong>Year:</strong> ${r_data.Year || ''}</h5>
                                <h5><strong>Reason:</strong> ${r_data.Reason}</h5>
                            </div>
                        </div>
                    `;

                    // Installment details
                    modalContent += `
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3"><strong>Installment Breakdown</strong></h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Sr. No</th>
                                                <th>Month - Year</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                    `;

                    // Check if installments exist
                    if (r_data.installments && r_data.installments.length > 0) {
                        // Add installment rows
                        r_data.installments.forEach((installment, index) => {
                            const status = installment.Status ? installment.Status : 'Pending';
                            const statusClass = status.toLowerCase() === 'paid' ? 'text-success' : 'text-warning';

                            modalContent += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${installment.Month || 'N/A'}</td>
                                    <td>₹ ${parseFloat(installment.Amount || 0).toFixed(2)}</td>
                                    <td class="${statusClass}"><strong>${status}</strong></td>
                                </tr>
                            `;
                        });
                    } else {
                        // Calculate installments if not provided in the response
                        const totalAmount = parseFloat(r_data.Loan_Amount_in_INR);
                        const numberOfInstallments = parseInt(r_data.Number_of_installment);

                        if (totalAmount && numberOfInstallments) {
                            const installmentAmount = (totalAmount / numberOfInstallments).toFixed(2);

                            // Get month and year from the response
                            let startDate;
                            if (r_data.Month) {
                                // Try to parse the month string to create a date object
                                startDate = new Date(r_data.Month + '-01');
                            } else {
                                startDate = new Date(); // Fallback to current date
                            }

                            for (let i = 0; i < numberOfInstallments; i++) {
                                const monthDate = new Date(startDate);
                                monthDate.setMonth(startDate.getMonth() + i);
                                const monthName = monthDate.toLocaleString("default", { month: "long" });
                                const year = monthDate.getFullYear();

                                modalContent += `
                                    <tr>
                                        <td>${i + 1}</td>
                                        <td>${monthName} ${year}</td>
                                        <td>₹ ${installmentAmount}</td>
                                        <td class="text-warning"><strong>Pending</strong></td>
                                    </tr>
                                `;
                            }
                        } else {
                            // No way to calculate installments
                            modalContent += `
                                <tr>
                                    <td colspan="4" class="text-center">No installment data available</td>
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
            error: function(xhr) {
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
                                <div class="btn-group btn-group-sm" role="group" aria-label="Basic Salary Actions">
                                    <button type="button" class="btn btn-info" onclick="basic_salary_view('${$salary.id}')">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>

                                    <button type="button" class="btn btn-warning B_Salary_a" onclick="open_basic_salary_update_form('${$salary.id}')">
                                        <i class="fa-solid fa-pencil"></i>
                                    </button>

                                    <button type="button" class="btn btn-danger" onclick="confirmDeleteSalary('${$salary.id}')">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
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

    function load_deductions_data(url_input) {
        $.ajax({
            url: url_input, // API endpoint URL
            type: "GET", // HTTP method
            dataType: "json",
            headers: {
                "Content-Type": "application/json"
            },
            success: function(response) {
                console.log("Deduction Response:", response); // Log the successful response
                $("#Deductions_table").empty();

                // Table Header
                var table_html_data = `
                    <thead>
                        <tr>
                            <th><input type="checkbox" name="delet_data" id=""></th>
                            <th>Month-Year</th>
                            <th>Title</th>
                            <th>(₹) Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>`;

                // Populate Table Rows
                var all_data = response.data;
                all_data.forEach($deduction => {
                    table_html_data += `
                        <tr>
                            <td><input type="checkbox" name="delet_data" id=""></td>
                            <td>${$deduction.Month} </td>
                            <td>${$deduction.deduction_Titel}</td>
                            <td>${$deduction.deduction_Amount_in_INR}</td>
                           <td>
                                <button type="button" class="btn btn-sm btn-info" onclick="Deductions_view('${$deduction.id}')">
                                    <i class="fa-regular fa-eye"></i>
                                </button>

                                <button type="button" class="btn btn-sm btn-primary" onclick="open_Update_Deduction_form('${$deduction.id}')">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>

                                <button type="button"
                                    class="btn btn-sm btn-danger"
                                    data-toggle="modal"
                                    data-target="#confirmDeleteModal"
                                    data-href="/delete/${$deduction.id}/deductions">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </td>

                        </tr>`;
                });

                table_html_data += `</tbody>`;
                $("#Deductions_table").html(table_html_data);
            },
            error: function(xhr, status, error) {
                console.error("Error:", error); // Log the error
            }
        });
    }

    function Deductions_view(id) {
        $.ajax({
            type: "GET",
            url: "/Deductions/" + id,
            dataType: "json",
            success: function(response) {
                var r_data = response.data;
                var modalBody = `
                    <div>
                        <p><strong>Deduction Title:</strong> ${r_data.deduction_Titel}</p>
                        <p><strong>Deduction Amount:</strong> ₹${r_data.deduction_Amount_in_INR}</p>
                        <p><strong>Month:</strong> ${r_data.Month}</p>
                        <p><strong>Year:</strong> ${r_data.Year}</p>
                    </div>
                `;

                $('#deductionViewModal .modal-body').html(modalBody);
                $('#deductionViewModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }


    function open_Update_Deduction_form(id) {
        open_Deduction_form()
        $("#add_deductions_form_header").text("Update Deduction");
        $("#Deduction_id_input").val(id);
        $.ajax({
        type: "GET",
        url: "{{url("/Deductions/")}}/"+id,
        dataType: "json",
        success: function(response) {
        console.log(response);
        var r_data = response.data
        $("#Deduction_Title").val(r_data.deduction_Titel);
        $("#Deduction_Amount").val(r_data.deduction_Amount_in_INR);
        // Extract the 'YYYY-MM' part from 'YYYY-MM-DD'
        const deductionMonth = r_data.deductions_Month.substring(0, 7); // This will extract '2025-06'

        // Set the value of the month input
        $("#Deduction_month").val(deductionMonth);

        },
        error: function(xhr, status, error) {
        console.log(xhr.responseText);
        // Handle the error here
        }
        });

    }

    load_loan_data("{{ url('loan_view_api/' . $u_data['Employee_id']) }}");

    function load_loan_data(url_input) {
        $.ajax({
            url: url_input,
            type: "GET",
            dataType: "json",
            headers: {
                "Content-Type": "application/json"
            },
            success: function (response) {
                console.log("Loan Response:", response);
                $("#loan_view_table").empty(); // tbody only

                let table_html_data = ``;
                let all_data = response.data;

                all_data.forEach(loan => {
                    const date = new Date(loan.Month);
                    const formattedDate = date.toLocaleDateString('en-US', { year: 'numeric', month: 'long' });

                    table_html_data += `
                        <tr>
                            <td><input type="checkbox" name="delet_data"></td>
                            <td>${loan.Title}</td>
                            <td>${formattedDate}</td>
                            <td>${loan.Reason}</td>
                            <td>${loan.Number_of_installment}</td>
                            <td>₹ ${loan.Loan_Amount_in_INR}</td>
                            <td>₹ ${loan.Loan_Remaining}</td>
                           <td>
                                <button class="btn btn-sm btn-info" onclick="loan_view('${loan.id}')"><i class="fas fa-eye"></i></button>
                                <button type="button" class="btn btn-sm btn-info" onclick="open_loan_modal('${loan.id}')">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <a href="{{ url('/delete') }}/${loan.id}/loan" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>`;
                });

                $("#loan_view_table").html(table_html_data);
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
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
                        $("#loan_title").val(r_data.Title || "");
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

        // Also clear any previous hidden installment inputs
        $(".installment-hidden-inputs").remove();

        // Create a container for hidden inputs
        const hiddenInputsContainer = $("<div class='installment-hidden-inputs'></div>");
        $("#add_loan_form").append(hiddenInputsContainer);

        if (existingInstallments && existingInstallments.length > 0) {
            // Display existing installments
            for (let i = 0; i < existingInstallments.length; i++) {
                const installment = existingInstallments[i];
                $("#monthList").append(`
                    <tr>
                        <td>${i + 1}</td>
                        <td>${installment.Month || 'Unknown'}</td>
                        <td>${parseFloat(installment.Amount || 0).toFixed(2)}</td>
                    </tr>
                `);

                // Add hidden inputs for each installment
                hiddenInputsContainer.append(`
                    <input type="hidden" name="installments[${i}][Month]" value="${installment.Month || ''}">
                    <input type="hidden" name="installments[${i}][Amount]" value="${parseFloat(installment.Amount || 0).toFixed(2)}">
                    <input type="hidden" name="installments[${i}][Id]" value="${installment.Id || ''}">
                `);
            }
        } else {
            // Generate new installment breakdown
            const selectedDate = $("#loan_month").val();
            const number_of_loop = parseInt($("#number_of_loan_installment").val()) || 0;
            const advance_amount = parseFloat($("#loan_amount").val()) || 0;

            if (selectedDate && number_of_loop > 0 && advance_amount > 0) {
                const startDate = new Date(selectedDate);
                const year = startDate.getFullYear();
                const startMonth = startDate.getMonth();

                for (let i = 0; i < number_of_loop; i++) {
                    const monthDate = new Date(year, startMonth + i, 1);
                    const monthName = monthDate.toLocaleString("default", {
                        month: "long"
                    });
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

                    // Add hidden inputs for each new installment
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

            var formData = $('#add_loan_form').serialize();

            $.ajax({
                url: "{{ route('form_request') }}",
                method: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                success: function(response) {
                    alert(response.message);
                    close_Loan_form(); // Hide modal (assuming this function exists)
                    $('#add_loan_form')[0].reset();
                    $("#add_loan_form_header").text("Add Loan"); // if this exists
                    load_loan_data("{{url('loan_view_api/')}}/" + {{$u_data['Employee_id']}});
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + xhr.responseText);
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
                $("#leave_table").empty();

                let table_rows = '';
                const all_data = response.data;

                all_data.forEach($leave => {
                    table_rows += `
                        <tr>
                            <td><input type="checkbox" name="delet_data"></td>
                            <td>${$leave.Leave_Type}</td>
                            <td>${$leave.Start_Date}</td>
                            <td>${$leave.End_Date}</td>
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

                $("#leave_table").html(table_rows);
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
            }
        });
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
            success: function(response) {
                console.log("Attendance Response:", response);

                // Build table rows only
                var table_html_data = "";
                var all_data = response.data;

                if (all_data.length > 0) {
                    all_data.forEach($attendance => {
                        table_html_data += `
                            <tr>
                                <td><input type="checkbox" /></td>
                                <td>${$attendance.attandence_Date}</td>
                                <td>${$attendance.in_time}</td>
                                <td>${$attendance.out_time}</td>
                            </tr>`;
                    });
                } else {
                    table_html_data += `
                        <tr>
                            <td colspan="4" class="text-center">No attendance records found</td>
                        </tr>`;
                }

                // Inject only <tbody>
                $("#Attendance_table tbody").html(table_html_data);
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
            }
        });
    }


</script>
@stop

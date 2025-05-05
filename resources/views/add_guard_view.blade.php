@extends('adminlte::page')

@section('title', 'Add Guard')

@section('content_header')
    <h1>Add Guard</h1>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@stop

@section('content')
<div class="container-fluid">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-user-plus"></i>
                Guard Information
            </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('add_user') }}" method="post">
                @csrf
                <div class="row">
                    <!-- Personal Information -->
                    <div class="col-md-12">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Personal Information</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="f_name">First Name <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa-regular fa-circle-user"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="f_name" name="f_name" placeholder="First Name" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="m_name">Middle Name</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa-regular fa-circle-user"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="m_name" name="m_name" placeholder="Middle Name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="l_name">Last Name <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa-regular fa-circle-user"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="l_name" name="l_name" placeholder="Last Name" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="m_number">Mobile Number <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="m_number" name="m_number" placeholder="Mobile Number" maxlength="10" inputmode="numeric" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label id="email_p" for="email_field">Email</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                                                </div>
                                                <input type="email" class="form-control" id="email_field" name="email" placeholder="Email Address">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="dob">Date of Birth</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa-regular fa-calendar-days"></i></span>
                                                </div>
                                                <input type="date" class="form-control" id="dob" name="dob">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="c_address">Current Address</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa-solid fa-location-dot"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="c_address" name="c_address" placeholder="Current Address">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="p_address">Permanent Address</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa-solid fa-location-dot"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="p_address" name="p_address" placeholder="Permanent Address">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="gender">Gender</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                                </div>
                                                <select class="form-control" id="gender" name="shift">
                                                    <option value="Male">Select Gender</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="marital_status">Marital Status</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-ring"></i></span>
                                                </div>
                                                <select class="form-control" id="marital_status" name="shift">
                                                    <option value="Unmarried">Select Marital Status</option>
                                                    <option value="Married">Married</option>
                                                    <option value="Unmarried">Unmarried</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="highest_qualification">Highest Qualification</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="highest_qualification" placeholder="Highest Qualification">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Identity Documents -->
                    <div class="col-md-12 mt-3">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Identity Documents</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="aadhaar_number">Aadhaar</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa-solid fa-address-card"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="aadhaar_number" name="aadhaar_number" placeholder="Aadhaar" inputmode="numeric" maxlength="12">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="voter_ID">Voter ID</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa-solid fa-address-card"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="voter_ID" name="voter_ID" placeholder="Voter ID" maxlength="20">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="rasancard_number">Ration Card</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                                </div>
                                                <input type="number" class="form-control" id="rasancard_number" name="rasancard_number" placeholder="Ration Card" maxlength="25">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Pan_number">PAN Number</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa-solid fa-address-card"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="Pan_number" name="Pan_number" placeholder="PAN Number" maxlength="20">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Employment Details -->
                    <div class="col-md-12 mt-3">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Employment Details</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Salary">Salary <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                                                </div>
                                                <input type="number" class="form-control" id="Salary" name="Salary" placeholder="Salary" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="can_login">Login Enabled</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                                </div>
                                                <select class="form-control" id="can_login" name="can_login" onchange="setRequired()">
                                                    <option value="0">Select Status</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="DOJ">Date of Joining</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                                                </div>
                                                <input type="date" class="form-control" id="DOJ" name="DOJ">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="shift">Shift <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                                </div>
                                                <select class="form-control" id="shift" name="shift" required>
                                                    <option value="">Select Shift</option>
                                                    @foreach ($shift_master as $shift_m)
                                                        <option value="{{ $shift_m->id }}">{{ $shift_m->Shift_Name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="emp_type">Employee Type <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                                </div>
                                                <select class="form-control" id="emp_type" name="emp_type" required>
                                                    <option value="">Select Employee Type</option>
                                                    @foreach ($employee_type_master as $emp_type)
                                                        <option value="{{ $emp_type->id }}">{{ $emp_type->EmpTypeName }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="role">Employee Role <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user-shield"></i></span>
                                                </div>
                                                <select class="form-control" id="role" name="role" required>
                                                    <option value="">Select Employee Role</option>
                                                    @foreach ($role_masrer as $role_m)
                                                        @if ($role_m->id >= session('role_number'))
                                                            <option value="{{ $role_m->id }}">{{ $role_m->roles }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Fields -->
                    <div class="col-md-4" style="display: none">
                        <div class="form-group">
                            <label for="login_Status">Status</label>
                            <select class="form-control" id="login_Status" name="login_Status">
                                <option value="1">Select Status</option>
                                <option selected value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mt-3 text-right">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i> Add Guard
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    $(document).ready(function() {
        // Initialize any plugins or components here
        $('[data-toggle="tooltip"]').tooltip();
    });

    function setRequired() {
        var canLogin = document.getElementById('can_login').value;

        if (canLogin == 1) {
            document.getElementById('email_field').required = true;
            document.getElementById('email_p').innerHTML = 'Email <span class="text-danger">*</span>';
        } else {
            document.getElementById('email_field').required = false;
            document.getElementById('email_p').innerHTML = 'Email';
        }
    }

    // Active menu highlight
    $(document).ready(function() {
        // Deactivate all menu items
        $("#Dashboard_li, #Employees_li, #Attendance_li, #Add_Employee_li, #Super_Admin_Settings, #Admin_Settings_li, #HR_Settings_li")
            .removeClass('active');

        // Set active menu item
        $("#Add_Employee_li").addClass('active');
    });
</script>
@stop

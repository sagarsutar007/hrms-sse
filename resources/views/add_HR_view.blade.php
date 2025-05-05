@extends('adminlte::page')

@section('title', 'Add HR')

@section('content_header')
    <h1>Add HR</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">HR Information</h3>
                </div>
                <!-- /.card-header -->

                <!-- form start -->
                <form action="{{ route('add_user') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <!-- Personal Information Section -->
                            <div class="col-md-12 mb-3">
                                <h4><i class="fas fa-user-circle"></i> Personal Information</h4>
                                <hr>
                            </div>

                            <!-- First Name -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="f_name">First Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="f_name" name="f_name" placeholder="First Name" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Middle Name -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="m_name">Middle Name</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="m_name" name="m_name" placeholder="Middle Name">
                                    </div>
                                </div>
                            </div>

                            <!-- Last Name -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="l_name">Last Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="l_name" name="l_name" placeholder="Last Name" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Mobile Number -->
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

                            <!-- Email -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email_field" id="email_p">Email</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input type="email" class="form-control" id="email_field" name="email" placeholder="Email Address">
                                    </div>
                                </div>
                            </div>

                            <!-- Date of Birth -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="dob">Date of Birth</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="date" class="form-control" id="dob" name="dob">
                                    </div>
                                </div>
                            </div>

                            <!-- Current Address -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="c_address">Current Address</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="c_address" name="c_address" placeholder="Current Address">
                                    </div>
                                </div>
                            </div>

                            <!-- Permanent Address -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="p_address">Permanent Address</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-home"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="p_address" name="p_address" placeholder="Permanent Address">
                                    </div>
                                </div>
                            </div>

                            <!-- ID Information Section -->
                            <div class="col-md-12 mb-3 mt-4">
                                <h4><i class="fas fa-id-card"></i> ID Information</h4>
                                <hr>
                            </div>

                            <!-- Aadhaar -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="aadhaar_number">Aadhaar</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="aadhaar_number" name="aadhaar_number" placeholder="Aadhaar" maxlength="12" inputmode="numeric">
                                    </div>
                                </div>
                            </div>

                            <!-- PAN Number -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Pan_number">PAN Number</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-id-card-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="Pan_number" name="Pan_number" placeholder="PAN Number" maxlength="20">
                                    </div>
                                </div>
                            </div>

                            <!-- Voter ID -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="voter_ID">Voter ID</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-vote-yea"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="voter_ID" name="voter_ID" placeholder="Voter ID" maxlength="20">
                                    </div>
                                </div>
                            </div>

                            <!-- Ration Card -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="rasancard_number">Ration Card</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                                        </div>
                                        <input type="number" class="form-control" id="rasancard_number" name="rasancard_number" placeholder="Ration Card" maxlength="25">
                                    </div>
                                </div>
                            </div>

                            <!-- Personal Details Section -->
                            <div class="col-md-12 mb-3 mt-4">
                                <h4><i class="fas fa-user-cog"></i> Personal Details</h4>
                                <hr>
                            </div>

                            <!-- Gender -->
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

                            <!-- Marital Status -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="marital_status">Marital Status</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-heart"></i></span>
                                        </div>
                                        <select class="form-control" id="marital_status" name="shift">
                                            <option value="Unmarried">Select Marital Status</option>
                                            <option value="Married">Married</option>
                                            <option value="Unmarried">Unmarried</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Highest Qualification -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="qualification">Highest Qualification</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="qualification" name="qualification" placeholder="Highest Qualification">
                                    </div>
                                </div>
                            </div>

                            <!-- Employment Details Section -->
                            <div class="col-md-12 mb-3 mt-4">
                                <h4><i class="fas fa-briefcase"></i> Employment Details</h4>
                                <hr>
                            </div>

                            <!-- Salary -->
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

                            <!-- Date of Joining -->
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

                            <!-- Shift -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="shift">Shift <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                        </div>
                                        <select class="form-control" id="shift" name="shift" required>
                                            <option>Select Shift</option>
                                            @foreach ($shift_master as $shift_m)
                                                <option value="{{ $shift_m->id }}">{{ $shift_m->Shift_Name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Employee Type -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="emp_type">Employee Type <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                        </div>
                                        <select class="form-control" id="emp_type" name="emp_type" required>
                                            <option>Select Employee Type</option>
                                            @foreach ($employee_type_master as $emp_type)
                                                <option value="{{ $emp_type->id }}">{{ $emp_type->EmpTypeName }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Employee Role -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="role">Employee Role <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-shield"></i></span>
                                        </div>
                                        <select class="form-control" id="role" name="role" required>
                                            <option>Select Employee Role</option>
                                            @foreach ($role_masrer as $role_m)
                                                @if ($role_m->id >= session('role_number'))
                                                    <option value="{{ $role_m->id }}">{{ $role_m->roles }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Login Settings -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="can_login">Login Enabled</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-sign-in-alt"></i></span>
                                        </div>
                                        <select class="form-control" id="can_login" name="can_login" onchange="set_required()">
                                            <option value="0">Select Status</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Hidden Status Field -->
                            <div class="col-md-4" style="display: none;">
                                <div class="form-group">
                                    <label for="login_Status">Status</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-toggle-on"></i></span>
                                        </div>
                                        <select class="form-control" id="login_Status" name="login_Status">
                                            <option value="1">Select Status</option>
                                            <option selected value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Add HR</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>
    function set_required() {
        let can_login_flag = document.getElementById('can_login').value;

        if (can_login_flag == 1) {
            document.getElementById('email_field').required = true;
            document.getElementById('email_p').innerHTML = 'Email <span class="text-danger">*</span>';
        } else {
            document.getElementById('email_field').required = false;
            document.getElementById('email_p').innerHTML = 'Email';
        }
    }

    $(document).ready(function () {
        // Set active sidebar menu
        $('li.nav-item').removeClass('active');
        $('#Add_Employee_li').addClass('active');
    });
</script>
@stop

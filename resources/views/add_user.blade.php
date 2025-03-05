@extends('adminlte::page')

@section('title', 'Add Employee')

@section('content_header')
    <h1> Add Employee</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">Employee Details</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('add_user') }}" method="post">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <x-adminlte-input name="f_name" label="First Name*" placeholder="First Name" required icon="fas fa-user" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="m_name" label="Middle Name" placeholder="Middle Name" icon="fas fa-user" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="l_name" label="Last Name*" placeholder="Last Name" required icon="fas fa-user" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="m_number" label="Mobile Number" placeholder="Mobile Number" maxlength="10" inputmode="numeric" icon="fas fa-phone" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="email" label="Email" placeholder="Email Address" type="email" id="email_field" icon="fas fa-envelope" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="dob" label="Date Of Birth" placeholder="Date Of Birth" type="date" icon="fas fa-calendar-alt" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="c_address" label="Current Address" placeholder="Current Address" icon="fas fa-map-marker-alt" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="p_address" label="Permanent Address" placeholder="Permanent Address" icon="fas fa-map-marker-alt" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="aadhaar_number" label="Aadhaar" placeholder="Aadhaar" maxlength="12" inputmode="numeric" icon="fas fa-id-card" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-select name="gender" label="Gender" icon="fas fa-venus-mars">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </x-adminlte-select>
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-select name="marital_status" label="Marital Status" icon="fas fa-ring">
                            <option value="">Select Marital Status</option>
                            <option value="Married">Married</option>
                            <option value="Unmarried">Unmarried</option>
                        </x-adminlte-select>
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="voter_ID" label="Voter ID" placeholder="Voter ID" maxlength="20" icon="fas fa-id-badge" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="rasancard_number" label="Ration Card" placeholder="Ration Card" maxlength="25" icon="fas fa-box" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="qualification" label="Highest Qualification" placeholder="Highest Qualification" icon="fas fa-graduation-cap" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="Salary" label="Salary*" placeholder="Salary" type="number" required icon="fas fa-money-bill" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="Pan_number" label="Pan Number" placeholder="Pan Number" maxlength="20" icon="fas fa-id-card-alt" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-select name="can_login" label="Login Enabled" id="can_login" onchange="set_required()" icon="fas fa-sign-in-alt">
                            <option value="0">Select Status</option>
                            <option value="1" selected>Yes</option>
                            <option value="0">No</option>
                        </x-adminlte-select>
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-select name="shift" label="Shift*" required icon="fas fa-clock">
                            <option value="">Select Shift</option>
                            @foreach ($shift_master as $shift_m)
                                <option value="{{ $shift_m->id }}">{{ $shift_m->Shift_Name }}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-select name="emp_type" label="Employee Type*" required icon="fas fa-briefcase">
                            <option value="">Select Employee Type</option>
                            @foreach ($employee_type_master as $emp_type)
                                <option value="{{ $emp_type->id }}">{{ $emp_type->EmpTypeName }}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-select name="role" label="Employee Role*" required icon="fas fa-user-tag">
                            <option value="">Select Employee Role</option>
                            @foreach ($role_masrer as $role_m)
                                @if ($role_m->id >= session('role_number'))
                                    <option value="{{ $role_m->id }}">{{ $role_m->roles }}</option>
                                @endif
                            @endforeach
                        </x-adminlte-select>
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="DOJ" label="Date Of Joining*" type="date" required icon="fas fa-calendar-check" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="Account_Number" label="Account Number*" placeholder="Account Number" type="number" required icon="fas fa-university" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="Bank_Hoalder_Name" label="Bank Holder Name*" placeholder="Bank Holder Name" required icon="fas fa-user-tie" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="IFSC_Code" label="IFSC Code*" placeholder="IFSC Code" required icon="fas fa-barcode" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="Bank_Name" label="Bank Name*" placeholder="Bank Name" required icon="fas fa-landmark" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-select name="department_master" label="Department*" required icon="fas fa-building">
                            <option value="">Select Department</option>
                            @foreach ($department_master as $dpm)
                                <option value="{{ $dpm->id }}">{{ $dpm->Department_name }}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>
                </div>

                <div class="mt-3 text-right">
                    <x-adminlte-button label="Add Employee" theme="primary" icon="fas fa-plus-circle" type="submit" />
                </div>
            </form>
        </div>
    </div>

    <script>
        function set_required(){
            let can_login_flag = document.getElementById('can_login').value;
            if(can_login_flag == 1){
                document.getElementById('email_field').required = true;
            }
        }
    </script>
@endsection

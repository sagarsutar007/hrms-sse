@extends('adminlte::page')

@section('title', 'Add Employee')

@section('content_header')
    <h1>Add Employee</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">Employee Details</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('add_user') }}" method="post" id="employeeForm">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="f_name">First Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <input type="text" name="f_name" id="f_name" class="form-control" placeholder="First Name" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="m_name" label="Middle Name" placeholder="Middle Name" icon="fas fa-user" />
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="l_name">Last Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <input type="text" name="l_name" id="l_name" class="form-control" placeholder="Last Name" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="m_number" label="Mobile Number" placeholder="Mobile Number" maxlength="10" inputmode="numeric" icon="fas fa-phone" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="email" label="Email" placeholder="Email Address" type="email" id="email_field" icon="fas fa-envelope" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="dob" label="Date Of Birth" type="date" icon="fas fa-calendar-alt" />
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
                        <x-adminlte-input name="Salary" label="Salary" placeholder="Salary" type="number" icon="fas fa-money-bill" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="Pan_number" label="Pan Number" placeholder="Pan Number" maxlength="20" icon="fas fa-id-card-alt" />
                    </div>
                    <div class="col-md-6" style="display: none;">
                        <x-adminlte-select name="can_login" label="Login Enabled" id="can_login" icon="fas fa-sign-in-alt">
                            <option value="">Select Status</option>
                            <option value="1">Yes</option>
                            <option value="0" selected>No</option>
                        </x-adminlte-select>
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-select name="shift" label="Shift" icon="fas fa-clock">
                            <option value="">Select Shift</option>
                            @foreach ($shift_master as $shift_m)
                                <option value="{{ $shift_m->id }}">{{ $shift_m->Shift_Name }}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-select name="emp_type" label="Employee Type" icon="fas fa-briefcase">
                            <option value="">Select Employee Type</option>
                            @foreach ($employee_type_master as $emp_type)
                                <option value="{{ $emp_type->id }}">{{ $emp_type->EmpTypeName }}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>
                    <div class="col-md-6" style="display: none;">
                        <x-adminlte-select name="role" label="Employee Role" icon="fas fa-user-tag" disabled>
                            <option value="3" selected>Employee</option>
                        </x-adminlte-select>
                        <input type="hidden" name="role" value="3">
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="DOJ" label="Date Of Joining" type="date" value="{{ \Carbon\Carbon::now()->toDateString() }}" icon="fas fa-calendar-check" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="Account_Number" label="Account Number" type="number" icon="fas fa-university" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="Bank_Hoalder_Name" label="Bank Holder Name" icon="fas fa-user-tie" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="IFSC_Code" label="IFSC Code" icon="fas fa-barcode" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="Bank_Name" label="Bank Name" icon="fas fa-landmark" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-select name="department_master" label="Department" icon="fas fa-building">
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

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="successModalLabel">Employee Added Successfully</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 48px;"></i>
                    </div>
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Employee Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <p><strong>Name:</strong> <span id="modal-name"></span></p>
                                    <p><strong>Employee ID:</strong> <span id="modal-employee-id"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    $('#employeeForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Populate modal with employee details
                    $('#modal-name').text(response.F_name + ' ' + response.L_name);
                    $('#modal-employee-id').text(response.Employee_id);
                    $('#modal-password').text(response.Password);

                    // Show the success modal
                    $('#successModal').modal('show');

                    // Redirect after 3 seconds
                    setTimeout(function() {
                        window.location.href = "{{ url('employees') }}"; // Redirect to employees view page
                    }, 3000);
                } else {
                    alert(response.Message || 'An error occurred');
                }
            },
            error: function(xhr) {
                console.error('AJAX Error:', xhr);
                alert('An error occurred: ' + xhr.statusText);
            }
        });
    });
</script>

@endsection

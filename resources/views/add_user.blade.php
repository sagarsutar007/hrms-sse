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
            <form action="{{ route('add_user') }}" method="post" id="employeeForm">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <x-adminlte-input name="f_name" label="First Name" placeholder="First Name" icon="fas fa-user" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="m_name" label="Middle Name" placeholder="Middle Name" icon="fas fa-user" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="l_name" label="Last Name" placeholder="Last Name" icon="fas fa-user" />
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
                        <x-adminlte-input name="Salary" label="Salary" placeholder="Salary" type="number" icon="fas fa-money-bill" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="Pan_number" label="Pan Number" placeholder="Pan Number" maxlength="20" icon="fas fa-id-card-alt" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-select name="can_login" label="Login Enabled" id="can_login" icon="fas fa-sign-in-alt">
                            <option value="0">Select Status</option>
                            <option value="1" selected>Yes</option>
                            <option value="0">No</option>
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
                    <div class="col-md-6">
                        <x-adminlte-select name="role" label="Employee Role" icon="fas fa-user-tag">
                            <option value="">Select Employee Role</option>
                            @foreach ($role_masrer as $role_m)
                                @if ($role_m->id >= session('role_number'))
                                    <option value="{{ $role_m->id }}">{{ $role_m->roles }}</option>
                                @endif
                            @endforeach
                        </x-adminlte-select>
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="DOJ" label="Date Of Joining" type="date" icon="fas fa-calendar-check" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="Account_Number" label="Account Number" placeholder="Account Number" type="number" icon="fas fa-university" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="Bank_Hoalder_Name" label="Bank Holder Name" placeholder="Bank Holder Name" icon="fas fa-user-tie" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="IFSC_Code" label="IFSC Code" placeholder="IFSC Code" icon="fas fa-barcode" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="Bank_Name" label="Bank Name" placeholder="Bank Name" icon="fas fa-landmark" />
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
                                <div class="col-md-6">
                                    <p><strong>Name:</strong> <span id="modal-name"></span></p>
                                    <p><strong>Email:</strong> <span id="modal-email"></span></p>
                                    <p><strong>Mobile:</strong> <span id="modal-mobile"></span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Employee ID:</strong> <span id="modal-employee-id"></span></p>
                                    <p><strong>Password:</strong> <span id="modal-password"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="redirectBtn">Go to Employees</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add AJAX handling for the form submission
            $('#employeeForm').on('submit', function(e) {
    e.preventDefault();

    // Get the form data
    let formData = $(this).serialize();

    $.ajax({
        url: $(this).attr('action'),
        method: $(this).attr('method'),
        data: formData,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Build name from first and last name
                let fullName = [response.F_name, response.L_name].filter(Boolean).join(' ');

                // Populate modal with available data
                $('#modal-name').text(fullName || 'Not provided');
                $('#modal-employee-id').text(response.Employee_id || 'Not available');
                $('#modal-password').text(response.Password || 'Not available');

                // Show success modal
                $('#successModal').modal('show');

                // Set redirect button action
                $('#redirectBtn').off('click').on('click', function() {
                    window.location.href = "{{ route('view_employee') }}";
                });
            } else {
                // Show detailed error message
                let errorMessage = response.Message || 'An error occurred';
                let errorDetails = '';

                if (response.error) {
                    errorDetails += '\n\nError details: ' + response.error;
                    console.error('Error details:', response.error);
                }

                if (response.trace) {
                    console.error('Stack trace:', response.trace);
                }

                if (response.attempted_data) {
                    console.error('Attempted data:', response.attempted_data);
                }

                alert(errorMessage + errorDetails);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', status, error);
            console.error('Response:', xhr.responseText);

            let errorMessage = 'An error occurred while processing your request.';
            try {
                const response = JSON.parse(xhr.responseText);
                if (response.message) {
                    errorMessage += '\n\nServer message: ' + response.message;
                }
            } catch (e) {
                // If parsing fails, include the raw response text
                errorMessage += '\n\nServer response: ' + xhr.responseText;
            }

            alert(errorMessage);
        }
    });
});
        });
    </script>
@endsection

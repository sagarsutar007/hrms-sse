@extends('adminlte::page')

@section('title', 'Employee List')

@section('content_header')
    <h1>All Employee List</h1>
@endsection

@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="btn-group">
                <button class="btn btn-secondary me-2"><i class="fas fa-download"></i> Download ID Cards</button>
                <button class="btn btn-primary me-2" data-toggle="modal" data-target="#addEmployeeModal"><i class="fas fa-plus"></i> Add New Employee</button>
                <button class="btn btn-success me-2" data-toggle="modal" data-target="#bulkUploadModal"><i class="fas fa-upload"></i> Bulk Upload</button>
                <button class="btn btn-danger me-2"><i class="fas fa-trash"></i> Bulk Delete</button>
            </div>
            <div class="ml-auto">
                <input type="text" id="searchBox" class="form-control" placeholder="Search Employee...">
            </div>
        </div>


        <div class="card-body">
            <table id="employeeTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th><input type="checkbox"></th>
                        <th>Name</th>
                        <th>Employee ID</th>
                        <th>Mobile Number</th>
                        <th>Employee Type</th>
                        <th>Role</th>
                        <th>Weekly Off</th>
                        <th>Department</th>
                        <th>Gate Off</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td>John Doe</td>
                        <td>1001</td>
                        <td>9876543210</td>
                        <td>Full Time</td>
                        <td>Employee</td>
                        <td>Sunday</td>
                        <td>Production</td>
                        <td>1</td>
                        <td>
                            <button class="btn btn-info btn-sm"><i class="fas fa-eye"></i></button>
                            <button class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-primary btn-sm"><i class="fas fa-download"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td>Jane Smith</td>
                        <td>1002</td>
                        <td>9876543211</td>
                        <td>Casual</td>
                        <td>Employee</td>
                        <td>Sunday</td>
                        <td>Quality</td>
                        <td>1</td>
                        <td>
                            <button class="btn btn-info btn-sm"><i class="fas fa-eye"></i></button>
                            <button class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-primary btn-sm"><i class="fas fa-download"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td>Michael Johnson</td>
                        <td>1003</td>
                        <td>9876543212</td>
                        <td>Daily Wages</td>
                        <td>Employee</td>
                        <td>Sunday</td>
                        <td>Production</td>
                        <td>1</td>
                        <td>
                            <button class="btn btn-info btn-sm"><i class="fas fa-eye"></i></button>
                            <button class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-primary btn-sm"><i class="fas fa-download"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td>Emily Davis</td>
                        <td>1004</td>
                        <td>9876543213</td>
                        <td>Full Time</td>
                        <td>Employee</td>
                        <td>Sunday</td>
                        <td>Store</td>
                        <td>1</td>
                        <td>
                            <button class="btn btn-info btn-sm"><i class="fas fa-eye"></i></button>
                            <button class="btn btn-warning btn-sm" onclick="window.location.href='/user-details'"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-primary btn-sm"><i class="fas fa-download"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>

<x-adminlte-modal id="addEmployeeModal" title="Add Employee" theme="primary" size="lg" v-centered scrollable>
    <form action="{{ route('add_user') }}" method="POST">
        @csrf
        <div class="row">

            <!-- First Name -->
            <div class="col-md-4">
                <x-adminlte-input name="first_name" label="First Name*" placeholder="First Name" required>
                    <x-slot name="prependSlot">
                        <div class="input-group-text"><i class="fas fa-user"></i></div>
                    </x-slot>
                </x-adminlte-input>
            </div>

            <!-- Middle Name -->
            <div class="col-md-4">
                <x-adminlte-input name="middle_name" label="Middle Name" placeholder="Middle Name">
                    <x-slot name="prependSlot">
                        <div class="input-group-text"><i class="fas fa-user"></i></div>
                    </x-slot>
                </x-adminlte-input>
            </div>

            <!-- Last Name -->
            <div class="col-md-4">
                <x-adminlte-input name="last_name" label="Last Name*" placeholder="Last Name" required>
                    <x-slot name="prependSlot">
                        <div class="input-group-text"><i class="fas fa-user"></i></div>
                    </x-slot>
                </x-adminlte-input>
            </div>

            <!-- Mobile Number -->
            <div class="col-md-4">
                <x-adminlte-input name="mobile" label="Mobile Number" placeholder="Mobile Number">
                    <x-slot name="prependSlot">
                        <div class="input-group-text"><i class="fas fa-phone"></i></div>
                    </x-slot>
                </x-adminlte-input>
            </div>

            <!-- Email -->
            <div class="col-md-4">
                <x-adminlte-input name="email" label="Email" type="email" placeholder="Email Address">
                    <x-slot name="prependSlot">
                        <div class="input-group-text"><i class="fas fa-envelope"></i></div>
                    </x-slot>
                </x-adminlte-input>
            </div>

            <!-- Date of Birth -->
            <div class="col-md-4">
                <x-adminlte-input name="dob" label="Date Of Birth" type="date">
                    <x-slot name="prependSlot">
                        <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                    </x-slot>
                </x-adminlte-input>
            </div>

            <!-- Aadhaar -->
            <div class="col-md-4">
                <x-adminlte-input name="aadhaar" label="Aadhaar" placeholder="Aadhaar">
                    <x-slot name="prependSlot">
                        <div class="input-group-text"><i class="fas fa-id-card"></i></div>
                    </x-slot>
                </x-adminlte-input>
            </div>

            <!-- Voter ID -->
            <div class="col-md-4">
                <x-adminlte-input name="voter_id" label="Voter ID" placeholder="Voter ID">
                    <x-slot name="prependSlot">
                        <div class="input-group-text"><i class="fas fa-id-card"></i></div>
                    </x-slot>
                </x-adminlte-input>
            </div>

            <!-- PAN Number -->
            <div class="col-md-4">
                <x-adminlte-input name="pan_number" label="Pan Number" placeholder="Pan Number">
                    <x-slot name="prependSlot">
                        <div class="input-group-text"><i class="fas fa-id-card"></i></div>
                    </x-slot>
                </x-adminlte-input>
            </div>

            <!-- Ration Card -->
            <div class="col-md-4">
                <x-adminlte-input name="ration_card" label="Ration Card" placeholder="Ration Card" />
            </div>

            <!-- Highest Qualification -->
            <div class="col-md-4">
                <x-adminlte-input name="highest_qualification" label="Highest Qualification" placeholder="Enter qualification" />
            </div>

            <!-- Login Enabled -->
            <div class="col-md-4">
                <x-adminlte-select name="login_enabled" label="Login Enabled">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </x-adminlte-select>
            </div>

            <!-- Current Address -->
            <div class="col-md-6">
                <x-adminlte-textarea name="current_address" label="Current Address" placeholder="Enter address">
                    <x-slot name="prependSlot">
                        <div class="input-group-text"><i class="fas fa-map-marker-alt"></i></div>
                    </x-slot>
                </x-adminlte-textarea>
            </div>

            <!-- Permanent Address -->
            <div class="col-md-6">
                <x-adminlte-textarea name="permanent_address" label="Permanent Address" placeholder="Enter address">
                    <x-slot name="prependSlot">
                        <div class="input-group-text"><i class="fas fa-map-marker-alt"></i></div>
                    </x-slot>
                </x-adminlte-textarea>
            </div>

            <!-- Gender -->
            <div class="col-md-4">
                <x-adminlte-select name="gender" label="Gender">
                    <option>Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </x-adminlte-select>
            </div>

            <!-- Marital Status -->
            <div class="col-md-4">
                <x-adminlte-select name="marital_status" label="Marital Status">
                    <option>Select Marital Status</option>
                    <option value="single">Single</option>
                    <option value="married">Married</option>
                </x-adminlte-select>
            </div>

            <!-- Employee Type -->
            <div class="col-md-4">
                <x-adminlte-select name="employee_type" label="Employee Type*" required>
                    <option>Select Employee Type</option>
                    <option value="permanent">Permanent</option>
                    <option value="contract">Contract</option>
                </x-adminlte-select>
            </div>

            <!-- Employee Role -->
            <div class="col-md-4">
                <x-adminlte-select name="employee_role" label="Employee Role*" required>
                    <option>Select Employee Role</option>
                </x-adminlte-select>
            </div>

            <!-- Shift -->
            <div class="col-md-4">
                <x-adminlte-select name="shift" label="Shift*" required>
                    <option>Select Shift</option>
                </x-adminlte-select>
            </div>

            <!-- Salary -->
            <div class="col-md-4">
                <x-adminlte-input name="salary" label="Salary*" placeholder="Enter salary" required />
            </div>

            <!-- Bank Details -->
            <div class="col-md-4">
                <x-adminlte-input name="account_number" label="Account Number" placeholder="Account Number"/>
            </div>

            <div class="col-md-4">
                <x-adminlte-input name="bank_holder_name" label="Bank Holder Name" placeholder="Bank Holder Name"/>
            </div>

            <div class="col-md-4">
                <x-adminlte-input name="bank_name" label="Bank Name" placeholder="Bank Name"/>
            </div>

            <div class="col-md-4">
                <x-adminlte-input name="ifsc_code" label="IFSC Code" placeholder="IFSC Code"/>
            </div>

            <!-- Date of Joining -->
            <div class="col-md-4">
                <x-adminlte-input name="doj" label="Date Of Joining*" type="date" required />
            </div>

            <!-- Department -->
            <div class="col-md-4">
                <x-adminlte-select name="department" label="Department*" required>
                    <option>Select Department</option>
                </x-adminlte-select>
            </div>

        </div>

        <!-- Submit Button -->
        <div class="d-flex justify-content-end mt-3">
            <x-adminlte-button type="submit" label="Add Employee" theme="primary"/>
        </div>
    </form>
</x-adminlte-modal>

<x-adminlte-modal id="bulkUploadModal" title="Import Users" theme="primary" size="md" v-centered>
    <form action="{{ route('bulk_uoploade_request') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="text-center">
            <!-- File Input -->
            <x-adminlte-input-file name="user_file" label="Choose File" placeholder="No file chosen">
                <x-slot name="prependSlot">
                    <div class="input-group-text"><i class="fas fa-file-upload"></i></div>
                </x-slot>
            </x-adminlte-input-file>
        </div>

        <div class="d-flex flex-column gap-2 mt-3">
            <!-- Upload Button -->
            <x-adminlte-button type="submit" label="Upload" theme="dark" class="btn-block"/>

            <!-- Download Template Button -->
            <a href="{{url('/sample.csv')}}" class="btn btn-success btn-block">
                <i class="fas fa-file-excel"></i> Download XLS Format
            </a>

            <!-- Cancel Button -->
            <x-adminlte-button label="Cancel" theme="danger" data-dismiss="modal" class="btn-block"/>
        </div>
    </form>
</x-adminlte-modal>


@endsection

@section('js')
<script>
    $(document).ready(function () {
        $('#employeeTable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });

        // Search functionality
        $('#searchBox').on('keyup', function () {
            $('#employeeTable').DataTable().search($(this).val()).draw();
        });
    });
</script>
@endsection

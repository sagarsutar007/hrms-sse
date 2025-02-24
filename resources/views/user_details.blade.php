@extends('adminlte::page')

@section('title', 'Edit User Details')

@section('content_header')
    <h1>Edit User Details</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title">General Information</h3>
    </div>
    <div class="card-body">
        <form>
            <div class="row">
                <!-- Employee ID -->
                <div class="col-md-4">
                    <label for="employee_id">Employee ID *</label>
                    <input type="text" class="form-control" id="employee_id" value="2" readonly>
                </div>

                <!-- First Name -->
                <div class="col-md-4">
                    <label for="first_name">First Name *</label>
                    <input type="text" class="form-control" id="first_name" value="Sheela" required>
                </div>

                <!-- Last Name -->
                <div class="col-md-4">
                    <label for="last_name">Last Name *</label>
                    <input type="text" class="form-control" id="last_name" value="Devi" required>
                </div>
            </div>

            <div class="row mt-3">
                <!-- Email -->
                <div class="col-md-4">
                    <label for="email">Email *</label>
                    <input type="email" class="form-control" id="email" value="readesy414@gmail.com" required>
                </div>

                <!-- Phone -->
                <div class="col-md-4">
                    <label for="phone">Phone *</label>
                    <input type="tel" class="form-control" id="phone" value="6207820314" required>
                </div>

                <!-- Date of Birth -->
                <div class="col-md-4">
                    <label for="dob">Date of Birth *</label>
                    <input type="date" class="form-control" id="dob" value="1990-01-01" required>
                </div>
            </div>

            <div class="row mt-3">
                <!-- Employee Type -->
                <div class="col-md-4">
                    <label for="employee_type">Employee Type *</label>
                    <select class="form-control" id="employee_type">
                        <option selected>Full Time</option>
                        <option>Casual</option>
                    </select>
                </div>

                <!-- Role -->
                <div class="col-md-4">
                    <label for="role">Role *</label>
                    <select class="form-control" id="role">
                        <option selected>Employee</option>
                        <option>Manager</option>
                    </select>
                </div>

                <!-- Salary -->
                <div class="col-md-4">
                    <label for="salary">Salary *</label>
                    <input type="number" class="form-control" id="salary" value="10500" required>
                </div>
            </div>

            <div class="row mt-3">
                <!-- Department -->
                <div class="col-md-4">
                    <label for="department">Department *</label>
                    <select class="form-control" id="department">
                        <option selected>Production</option>
                        <option>Quality</option>
                    </select>
                </div>

                <!-- Date of Joining -->
                <div class="col-md-4">
                    <label for="joining_date">Date of Joining *</label>
                    <input type="date" class="form-control" id="joining_date" value="2014-09-05" required>
                </div>

                <!-- Gender -->
                <div class="col-md-4">
                    <label for="gender">Gender *</label>
                    <select class="form-control" id="gender">
                        <option selected>Female</option>
                        <option>Male</option>
                    </select>
                </div>
            </div>

            <div class="row mt-3">
                <!-- Aadhar Number -->
                <div class="col-md-4">
                    <label for="aadhar_number">Aadhar Number *</label>
                    <input type="text" class="form-control" id="aadhar_number" value="0" required>
                </div>

                <!-- PAN Number -->
                <div class="col-md-4">
                    <label for="pan_number">PAN Number</label>
                    <input type="text" class="form-control" id="pan_number" value="ABCTY1234D">
                </div>

                <!-- Gate Off -->
                <div class="col-md-4">
                    <label for="gate_off">Gate Off *</label>
                    <select class="form-control" id="gate_off">
                        <option selected>Yes</option>
                        <option>No</option>
                    </select>
                </div>
            </div>

            <!-- Update Button -->
            <div class="text-center mt-4">
                <button type="button" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@stop

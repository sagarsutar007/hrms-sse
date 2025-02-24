@extends('adminlte::page')

@section('title', 'Admin Settings')

@section('content_header')
    <h1>Admin Settings</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-header bg-primary">
        <h3 class="card-title text-white">Admin Settings</h3>
    </div>
    <div class="card-body">
        <form action="#" method="POST">
            <div class="row">
                <!-- HR Management -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-secondary">
                            <strong class="text-white">HR Management</strong>
                        </div>
                        <div class="card-body">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" checked>
                                <label class="form-check-label">Add HR</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" checked>
                                <label class="form-check-label">Update HR</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" checked>
                                <label class="form-check-label">Delete HR</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Employee Management -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-info">
                            <strong class="text-white">Employee Management</strong>
                        </div>
                        <div class="card-body">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" checked>
                                <label class="form-check-label">Add Employee</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" checked>
                                <label class="form-check-label">Update Employee</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" checked>
                                <label class="form-check-label">Delete Employee</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Salary Management -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-warning">
                            <strong class="text-dark">Salary Management</strong>
                        </div>
                        <div class="card-body">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" checked>
                                <label class="form-check-label">Set Salary</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" checked>
                                <label class="form-check-label">Update Salary</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" checked>
                                <label class="form-check-label">Delete Salary</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project & Task Management -->
                <div class="col-md-4 mt-3">
                    <div class="card shadow-sm">
                        <div class="card-header bg-danger">
                            <strong class="text-white">Project & Task Management</strong>
                        </div>
                        <div class="card-body">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" checked>
                                <label class="form-check-label">View Project & Task</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" checked>
                                <label class="form-check-label">Manage Project & Task</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Role & Permission Management -->
                <div class="col-md-4 mt-3">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success">
                            <strong class="text-white">Role & Permission</strong>
                        </div>
                        <div class="card-body">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" checked>
                                <label class="form-check-label">Add Role</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" checked>
                                <label class="form-check-label">Edit Role</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" checked>
                                <label class="form-check-label">Delete Role</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" checked>
                                <label class="form-check-label">Change Password</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- General Settings -->
                <div class="col-md-4 mt-3">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary">
                            <strong class="text-white">General Settings</strong>
                        </div>
                        <div class="card-body">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" checked>
                                <label class="form-check-label">View Core HR</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" checked>
                                <label class="form-check-label">View Payslip</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit & Cancel Buttons -->
            <div class="text-right mt-4">
                <a href="#" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection

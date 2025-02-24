@extends('adminlte::page')

@section('title', 'Edit Permissions')

@section('content_header')
    <h1>Edit Permissions</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="card-title text-white">Edit User Permissions</h3>
        </div>
        <div class="card-body">
            <form action="#" method="POST">
                <div class="row">
                    <!-- First Column -->
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-secondary">
                                <strong class="text-white">User Management</strong>
                            </div>
                            <div class="card-body">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" checked>
                                    <label class="form-check-label">Add User</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" checked>
                                    <label class="form-check-label">Update User</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" checked>
                                    <label class="form-check-label">Delete User</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Second Column -->
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-info">
                                <strong class="text-white">Salary Management</strong>
                            </div>
                            <div class="card-body">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" checked>
                                    <label class="form-check-label">Add Set Salary</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" checked>
                                    <label class="form-check-label">Update Set Salary</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" checked>
                                    <label class="form-check-label">Delete Set Salary</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Third Column -->
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-success">
                                <strong class="text-white">Other Permissions</strong>
                            </div>
                            <div class="card-body">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" checked>
                                    <label class="form-check-label">View Menu Items</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" checked>
                                    <label class="form-check-label">View Home Page Options</label>
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
@stop

@section('css')
    <style>
        .card {
            border-radius: 8px;
        }
        .form-check {
            margin-bottom: 10px;
        }
    </style>
@stop

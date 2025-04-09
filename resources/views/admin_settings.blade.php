@extends('adminlte::page')

@section('title', 'Admin Settings')

@section('content_header')
    <h1>Admin Settings</h1>
@stop

@section('css')
    <style>
        .permission-section {
            background: white;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 1px 1px rgba(0,0,0,0.1);
        }

        .permission-section h3 {
            font-size: 18px;
            margin-top: 0;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            color: #3c8dbc;
        }

        .permission-item {
            margin-bottom: 10px;
            padding-left: 5px;
        }

        .permission-item label {
            font-weight: normal;
            margin-left: 5px;
            cursor: pointer;
        }

        .action-buttons {
            margin-top: 20px;
            text-align: right;
        }

        .action-buttons .btn {
            margin-left: 10px;
            min-width: 100px;
        }

        #cancel-btn {
            background: #ddd;
            color: #333;
        }

        #cancel-btn:hover {
            background: #ccc;
        }
    </style>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Admin Settings</h3>
                </div>

                <form action="{{ route('edit_admin_permissions') }}" method="post">
                    @csrf
                    <input type="text" name="role_name" hidden value="{{ $role_name }}">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="permission-section">
                                    <h3>HR Management</h3>
                                    <div class="permission-item">
                                        <input type="checkbox" name="Add_HR" id="Add_HR" {{ $admin_permissionData->Add_HR ? 'checked' : '' }}>
                                        <label for="Add_HR">Add HR</label>
                                    </div>
                                    <div class="permission-item">
                                        <input type="checkbox" name="Update_HR" id="Update_HR" {{ $admin_permissionData->Update_HR ? 'checked' : '' }}>
                                        <label for="Update_HR">Update HR</label>
                                    </div>
                                    <div class="permission-item">
                                        <input type="checkbox" name="Delete_HR" id="Delete_HR" {{ $admin_permissionData->Delete_HR ? 'checked' : '' }}>
                                        <label for="Delete_HR">Delete HR</label>
                                    </div>
                                </div>

                                <div class="permission-section">
                                    <h3>Project & Task Management</h3>
                                    <div class="permission-item">
                                        <input type="checkbox" name="view_Project_Task" id="view_Project_Task_inp" {{ $admin_permissionData->view_Project_Task ? 'checked' : '' }}>
                                        <label for="view_Project_Task_inp">View Project & Task</label>
                                    </div>
                                    <div class="permission-item">
                                        <input type="checkbox" name="Manage_Project_Task" id="Manage_Project_Task" {{ $admin_permissionData->Manage_Project_Task ? 'checked' : '' }}>
                                        <label for="Manage_Project_Task">Manage Project & Task</label>
                                    </div>
                                </div>

                                <div class="permission-section">
                                    <h3>Salary Management</h3>
                                    <div class="permission-item">
                                        <input type="checkbox" name="view_Set_Salary" id="view_Set_Salary" {{ $admin_permissionData->view_Set_Salary ? 'checked' : '' }}>
                                        <label for="view_Set_Salary">Set Salary</label>
                                    </div>
                                    <div class="permission-item">
                                        <input type="checkbox" name="Update_Salary" id="Update_Salary" {{ $admin_permissionData->Update_Salary ? 'checked' : '' }}>
                                        <label for="Update_Salary">Update Salary</label>
                                    </div>
                                    <div class="permission-item">
                                        <input type="checkbox" name="Delete_Salary" id="Delete_Salary" {{ $admin_permissionData->Delete_Salary ? 'checked' : '' }}>
                                        <label for="Delete_Salary">Delete Salary</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="permission-section">
                                    <h3>Employee Management</h3>
                                    <div class="permission-item">
                                        <input type="checkbox" name="Add_Employee" id="Add_Employee" {{ $admin_permissionData->Add_Employee ? 'checked' : '' }}>
                                        <label for="Add_Employee">Add Employee</label>
                                    </div>
                                    <div class="permission-item">
                                        <input type="checkbox" name="Update_Employee" id="Update_Employee" {{ $admin_permissionData->Update_Employee ? 'checked' : '' }}>
                                        <label for="Update_Employee">Update Employee</label>
                                    </div>
                                    <div class="permission-item">
                                        <input type="checkbox" name="Delete_Employee" id="Delete_Employee" {{ $admin_permissionData->Delete_Employee ? 'checked' : '' }}>
                                        <label for="Delete_Employee">Delete Employee</label>
                                    </div>
                                </div>

                                <div class="permission-section">
                                    <h3>Role & Permission</h3>
                                    <div class="permission-item">
                                        <input type="checkbox" name="Add_Role" id="Add_Role" {{ $admin_permissionData->Add_Role ? 'checked' : '' }}>
                                        <label for="Add_Role">Add Role</label>
                                    </div>
                                    <div class="permission-item">
                                        <input type="checkbox" name="Edit_Role" id="Edit_Role" {{ $admin_permissionData->Edit_Role ? 'checked' : '' }}>
                                        <label for="Edit_Role">Edit Role</label>
                                    </div>
                                    <div class="permission-item">
                                        <input type="checkbox" name="Delete_Role" id="Delete_Role" {{ $admin_permissionData->Delete_Role ? 'checked' : '' }}>
                                        <label for="Delete_Role">Delete Role</label>
                                    </div>
                                    <div class="permission-item">
                                        <input type="checkbox" name="Change_Password" id="Change_Password" {{ $admin_permissionData->Change_Password ? 'checked' : '' }}>
                                        <label for="Change_Password">Change Password</label>
                                    </div>
                                </div>

                                <div class="permission-section">
                                    <h3>General Settings</h3>
                                    <div class="permission-item">
                                        <input type="checkbox" name="view_Core_HR" id="view_Core_HR" {{ $admin_permissionData->view_Core_HR ? 'checked' : '' }}>
                                        <label for="view_Core_HR">View Core HR</label>
                                    </div>
                                    <div class="permission-item">
                                        <input type="checkbox" name="view_Payslip" id="view_Payslip" {{ $admin_permissionData->view_Payslip ? 'checked' : '' }}>
                                        <label for="view_Payslip">View Payslip</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="action-buttons">
                            <button type="button" id="cancel-btn" class="btn btn-default" onclick="history.back()">Cancel</button>
                            <button type="submit" id="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        // You can add any JavaScript functionality here if needed
        $(document).ready(function() {
            // Initialize any plugins or add custom JS
        });
    </script>
@stop

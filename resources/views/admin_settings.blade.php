@extends('adminlte::page')

@section('title', $role_name . ' Settings')

@section('content_header')
    <h1>{{ $role_name }} Settings</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Permission Management</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('edit_admin_permissions') }}" method="post">
            @csrf
            <input type="text" name="role_name" hidden value="{{ $role_name }}">

            <div class="row">
                <!-- HR Permissions -->
                <div class="col-md-4">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">HR Management</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="Add_HR" id="Add_HR">
                                    <label class="custom-control-label" for="Add_HR">Add HR</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="Update_HR" id="Update_HR">
                                    <label class="custom-control-label" for="Update_HR">Update HR</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="Delete_HR" id="Delete_HR">
                                    <label class="custom-control-label" for="Delete_HR">Delete HR</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Employee Permissions -->
                <div class="col-md-4">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Employee Management</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="Add_Employee" id="Add_Employee">
                                    <label class="custom-control-label" for="Add_Employee">Add Employee</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="Update_Employee" id="Update_Employee">
                                    <label class="custom-control-label" for="Update_Employee">Update Employee</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="Delete_Employee" id="Delete_Employee">
                                    <label class="custom-control-label" for="Delete_Employee">Delete Employee</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Guard Permissions -->
                <div class="col-md-4">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Guard Management</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="Add_Guard" id="Add_Guard">
                                    <label class="custom-control-label" for="Add_Guard">Add Guard</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="Update_Guard" id="Update_Guard">
                                    <label class="custom-control-label" for="Update_Guard">Update Guard</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="Delete_Guard" id="Delete_Guard">
                                    <label class="custom-control-label" for="Delete_Guard">Delete Guard</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <!-- Admin Permissions -->
                <div class="col-md-4">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Admin Management</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="Add_Admin" id="Add_Admin">
                                    <label class="custom-control-label" for="Add_Admin">Add Admin</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="Update_Admin" id="Update_Admin">
                                    <label class="custom-control-label" for="Update_Admin">Update Admin</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="Delete_Admin" id="Delete_Admin">
                                    <label class="custom-control-label" for="Delete_Admin">Delete Admin</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- General Permissions -->
                <div class="col-md-4">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">General Permissions</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="view_General_Informations" id="view_General_Informations">
                                    <label class="custom-control-label" for="view_General_Informations">General Information</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="view_Profile" id="view_Profile">
                                    <label class="custom-control-label" for="view_Profile">View Profile</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="view_Set_Salary" id="view_Set_Salary">
                                    <label class="custom-control-label" for="view_Set_Salary">Set Salary</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project & HR Permissions -->
                <div class="col-md-4">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Project & HR Access</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="view_Project_Task" id="view_Project_Task_inp">
                                    <label class="custom-control-label" for="view_Project_Task_inp">View Project & Task</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="view_Payslip" id="view_Payslip">
                                    <label class="custom-control-label" for="view_Payslip">View Payslip</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="view_Core_HR" id="view_Core_HR">
                                    <label class="custom-control-label" for="view_Core_HR">View Core HR</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <!-- Shift Permissions -->
                <div class="col-md-4">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Shift Management</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="Add_Shift" id="Add_Shift">
                                    <label class="custom-control-label" for="Add_Shift">Add Shift</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="Edit_Shift" id="Edit_Shift">
                                    <label class="custom-control-label" for="Edit_Shift">Update Shift</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="Delete_Shift" id="Delete_Shift">
                                    <label class="custom-control-label" for="Delete_Shift">Delete Shift</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Employee Type Permissions -->
                <div class="col-md-4">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Employee Type Management</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="Add_Employee_Type" id="Add_Employee_Type">
                                    <label class="custom-control-label" for="Add_Employee_Type">Add Employee Type</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="Edit_Employee_Type" id="Edit_Employee_Type">
                                    <label class="custom-control-label" for="Edit_Employee_Type">Edit Employee Type</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="Delete_Employee_Type" id="Delete_Employee_Type">
                                    <label class="custom-control-label" for="Delete_Employee_Type">Delete Employee Type</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Role & Password Permissions -->
                <div class="col-md-4">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Role Management</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="Add_Role" id="Add_Role">
                                    <label class="custom-control-label" for="Add_Role">Add Role</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="Edit_Role" id="Edit_Role">
                                    <label class="custom-control-label" for="Edit_Role">Edit Role</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="Delete_Role" id="Delete_Role">
                                    <label class="custom-control-label" for="Delete_Role">Delete Role</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="Change_Password" id="Change_Password">
                                    <label class="custom-control-label" for="Change_Password">Change Password</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12 text-right">
                    <button type="button" class="btn btn-default mr-2" onclick="history.back()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>
    $(function() {
        @foreach ($admin_permissionData as $item)
            @if($item->Add_HR == 1)
                $("#Add_HR").prop('checked', true);
            @endif
            @if($item->Update_HR == 1)
                $("#Update_HR").prop('checked', true);
            @endif
            @if($item->Delete_HR == 1)
                $("#Delete_HR").prop('checked', true);
            @endif

            @if($item->Add_Employee == 1)
                $("#Add_Employee").prop('checked', true);
            @endif
            @if($item->Update_Employee == 1)
                $("#Update_Employee").prop('checked', true);
            @endif
            @if($item->Delete_Employee == 1)
                $("#Delete_Employee").prop('checked', true);
            @endif

            @if($item->Add_Guard == 1)
                $("#Add_Guard").prop('checked', true);
            @endif
            @if($item->Update_Guard == 1)
                $("#Update_Guard").prop('checked', true);
            @endif
            @if($item->Delete_Guard == 1)
                $("#Delete_Guard").prop('checked', true);
            @endif

            @if($item->Add_Admin == 1)
                $("#Add_Admin").prop('checked', true);
            @endif
            @if($item->Update_Admin == 1)
                $("#Update_Admin").prop('checked', true);
            @endif
            @if($item->Delete_Admin == 1)
                $("#Delete_Admin").prop('checked', true);
            @endif

            @if($item->view_General_Informations == 1)
                $("#view_General_Informations").prop('checked', true);
            @endif
            @if($item->view_Profile == 1)
                $("#view_Profile").prop('checked', true);
            @endif
            @if($item->view_Set_Salary == 1)
                $("#view_Set_Salary").prop('checked', true);
            @endif
            @if($item->view_Core_HR == 1)
                $("#view_Core_HR").prop('checked', true);
            @endif
            @if($item->view_Project_Task == 1)
                $("#view_Project_Task_inp").prop('checked', true);
            @endif
            @if($item->view_Payslip == 1)
                $("#view_Payslip").prop('checked', true);
            @endif

            @if($item->Add_Shift == 1)
                $("#Add_Shift").prop('checked', true);
            @endif
            @if($item->Edit_Shift == 1)
                $("#Edit_Shift").prop('checked', true);
            @endif
            @if($item->Delete_Shift == 1)
                $("#Delete_Shift").prop('checked', true);
            @endif

            @if($item->Add_Employee_Type == 1)
                $("#Add_Employee_Type").prop('checked', true);
            @endif
            @if($item->Edit_Employee_Type == 1)
                $("#Edit_Employee_Type").prop('checked', true);
            @endif
            @if($item->Delete_Employee_Type == 1)
                $("#Delete_Employee_Type").prop('checked', true);
            @endif

            @if($item->Add_Role == 1)
                $("#Add_Role").prop('checked', true);
            @endif
            @if($item->Edit_Role == 1)
                $("#Edit_Role").prop('checked', true);
            @endif
            @if($item->Delete_Role == 1)
                $("#Delete_Role").prop('checked', true);
            @endif

            @if($item->Change_Password == 1)
                $("#Change_Password").prop('checked', true);
            @endif
        @endforeach
    });
</script>
@stop

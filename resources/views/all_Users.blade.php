@extends('adminlte::page')

@section('title', 'All Users')

@section('content_header')
    <h1>User Management</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">User List</h3>
                        <div class="card-tools">
                            <button class="btn btn-primary float-right" onclick="open_add_user_form()">
                                <i class="fas fa-plus"></i> Add New User
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="users-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Sr. N.</th>
                                        <th>Name <a href="#"></a></th>
                                        <th>User ID <a href="#"></a></th>
                                        <th>Email ID <a href="#"></a></th>
                                        <th>Mobile Number <a href="#"></a></th>
                                        <th>Role</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="users-data">
                                    <!-- Data will be populated via AJAX -->
                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="dataTables_paginate paging_simple_numbers">
                                    <ul class="pagination" id="pagination_div">
                                        <!-- Pagination links will be populated via AJAX -->
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 text-right">
                                <div id="pagination-info">
                                    <!-- Pagination info will be populated via AJAX -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="AddUserModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AddUserModalLabel">Add User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="Add_Users_form">
                    @csrf
                    <input type="number" id="Add_Users_input_id" name="Add_Users_input_id" hidden>
                    <input type="text" name="form_type" value="Add_Users" hidden>
                    <input type="text" name="Employee_Id" value="" hidden>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="User_Name_Input">User Name *</label>
                            <input type="text" class="form-control" id="User_Name_Input" name="User_name" placeholder="User Name">
                        </div>
                        <div class="form-group">
                            <label for="Email_Id_Input">Email Id *</label>
                            <input type="email" class="form-control" id="Email_Id_Input" name="Email_Id" placeholder="Email Id">
                        </div>
                        <div class="form-group">
                            <label for="Mobile_Number_Input">Mobile Number *</label>
                            <input type="number" class="form-control" id="Mobile_Number_Input" name="Mobile_Number" placeholder="Mobile Number">
                        </div>
                        <div class="form-group">
                            <label for="role_select">Role *</label>
                            <select class="form-control custom-select" id="role_select" name="User_role">
                                <option value="">Select Role</option>
                                @isset($role_masrer)
                                    @foreach ($role_masrer as $role)
                                        @if ($role->roles == "Super admin")
                                            @if ($role == "Super admin")
                                                <option value="{{$role->id}}">{{$role->roles}}</option>
                                            @endif
                                        @else
                                            <option value="{{$role->id}}">{{$role->roles}}</option>
                                        @endif
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Password_Input">Password *</label>
                            <input type="password" class="form-control" id="Password_Input" name="Password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="Conform_Password_Input">Confirm Password *</label>
                            <input type="password" class="form-control" id="Conform_Password_Input" name="Conform_Password" placeholder="Confirm Password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        var limit = 50;
        var inp = "";
        var f_name_click_count = 1;
        var employ_id_click_count = 1;
        var attendance_time_click_count = 1;
        var attendance_Date_click_count = 1;
        var section_role_input = $("#section_role_input").val();

        // Load data
        function lode_data() {
            page_url = "{{url('/all-users-api')}}" + "/" + limit;
            attendance_data_set(page_url);
        }

        // Attendance data set
        function attendance_data_set(url_input) {
            $.ajax({
                url: url_input,
                type: "GET",
                dataType: "json",
                headers: {
                    "Content-Type": "application/json"
                },
                success: function(response) {
                    $("#users-data").empty();
                    var count_flag = 1;
                    var all_data = response.data;
                    var all_attendance = response.attandence_data.data;
                    var table_html_data = "";

                    var attandance_data_count = 1;
                    all_attendance.forEach(all_attendance => {
                        if (all_attendance.roles == 'Super admin') {
                            if (section_role_input == "Super admin") {
                                table_html_data += `
                                    <tr id="employee_id${all_attendance.Employee_id}">
                                        <td>${attandance_data_count}</td>
                                        <td>${all_attendance.name}</td>
                                        <td>${all_attendance.Employee_id}</td>
                                        <td>${all_attendance.email}</td>
                                        <td>${all_attendance.mobile_number}</td>
                                        <td>${all_attendance.roles}</td>
                                        <td>
                                            <a href="#" title="Edit User" onclick="open_update_Users_form(${all_attendance.Employee_id})" class="text-primary mx-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#" title="Delete User" onclick="delete_user(${all_attendance.Employee_id})" class="text-danger mx-1">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                            <a href="{{ url('/edit-permissions') }}/${all_attendance.Employee_id}" title="User Permissions" class="text-warning mx-1">
                                                <i class="fas fa-user-cog"></i>
                                            </a>
                                        </td>
                                    </tr>
                                `;
                            }
                        } else {
                            table_html_data += `
                                <tr id="employee_id${all_attendance.Employee_id}">
                                    <td>${attandance_data_count}</td>
                                    <td>${all_attendance.name}</td>
                                    <td>${all_attendance.Employee_id}</td>
                                    <td>${all_attendance.email}</td>
                                    <td>${all_attendance.mobile_number}</td>
                                    <td>${all_attendance.roles}</td>
                                    <td>
                                        <a href="#" title="Edit User" onclick="open_update_Users_form(${all_attendance.Employee_id})" class="table_icons"><i class="fa-solid fa-pencil"></i></a>
                                        <a href="#" title="Delete User" onclick="delete_user(${all_attendance.Employee_id})" class="table_icons"><i class="fa-solid fa-trash-can"></i></a>
                                        <a href="{{url('/edit-permissions')}}/${all_attendance.Employee_id}" title="User Permissions" class="table_icons"><i class="fa-solid fa-pen-to-square"></i></a>
                                    </td>
                                </tr>
                            `;
                        }
                        attandance_data_count++;
                    });

                    $("#users-data").html(table_html_data);
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        }

        // Modal functions
        function open_add_user_form() {
            $("#AddUserModal").modal('show');
            $("#AddUserModalLabel").text("Add User");
        }

        function close_add_user_form() {
            $("#AddUserModal").modal('hide');
            $('#Add_Users_form')[0].reset();
        }

        function open_update_Users_form(id) {
            $("#AddUserModal").modal('show');
            $("#AddUserModalLabel").text("Update User");
            $("#Add_Users_input_id").val(id);

            $.ajax({
                type: "GET",
                url: "{{url('/one-user-data-with-id/')}}" + "/" + id,
                dataType: "json",
                success: function(response) {
                    var r_data = response.attandence_data[0];
                    $("#User_Name_Input").val(r_data.name);
                    $("#Email_Id_Input").val(r_data.email);
                    $("#Mobile_Number_Input").val(r_data.mobile_number);
                    $("#role_select").val(r_data.role);
                    $("#Password_Input").val(r_data.password);
                    $("#Conform_Password_Input").val(r_data.password);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }

        // Form submission
        $('#Add_Users_form').on('submit', function(event) {
            event.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: "{{ route('Add_Users') }}",
                method: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                success: function(response) {
                    alert(response.message);
                    close_add_user_form();
                    lode_data();
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + xhr.responseText);
                }
            });
        });

        // Delete user
        function delete_user(id) {
            const userConfirmed = confirm("Are you sure Delete This User , User Id : " + id);
            if (userConfirmed) {
                window.location.href = "{{url('/delet-user-with-id')}}" + "/" + id;
            }
        }

        // Initialize
        $(document).ready(function() {
            lode_data();
        });
    </script>
@stop

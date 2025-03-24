@extends('adminlte::page')

@section('title', 'User Management')

@section('content_header')
    <h1>User Management</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">User List</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-primary btn-sm" onclick="open_add_user_form()">
                    <i class="fas fa-plus"></i> Add User
                </button>
            </div>
            <input type="text" id="section_role_input" value="{{$role}}" hidden>
        </div>
        <div class="card-body">
            <table id="users_table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="5%">Sr. No.</th>
                        <th>Name</th>
                        <th>User ID</th>
                        <th>Email ID</th>
                        <th>Mobile Number</th>
                        <th>Role</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Add/Edit User -->
    <div class="modal fade" id="userFormModal" tabindex="-1" role="dialog" aria-labelledby="userFormModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="Add_Users_form_header">Add User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="Add_Users_form">
                    @csrf
                    <div class="modal-body">
                        <input type="number" id="Add_Users_input_id" name="Add_Users_input_id" hidden>
                        <input type="text" name="form_type" value="Add_Users" hidden>
                        <input type="text" name="Employee_Id" value="" hidden>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="User_Name_Input">User Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="User Name" name="User_name" id="User_Name_Input" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Email_Id_Input">Email ID <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" placeholder="Email Id" name="Email_Id" id="Email_Id_Input" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Mobile_Number_Input">Mobile Number <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" placeholder="Mobile Number" name="Mobile_Number" id="Mobile_Number_Input" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role_select">Role <span class="text-danger">*</span></label>
                                    <select class="form-control" name="User_role" id="role_select" required>
                                        <option value="">Select Role</option>
                                        @isset($role_masrer)
                                            @foreach ($role_masrer as $role_masrer)
                                                @if ($role_masrer->roles == "Super admin")
                                                    @if ($role == "Super admin")
                                                        <option value="{{$role_masrer->id}}">{{$role_masrer->roles}}</option>
                                                    @endif
                                                @else
                                                    <option value="{{$role_masrer->id}}">{{$role_masrer->roles}}</option>
                                                @endif
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Password_Input">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" placeholder="Password" name="Password" id="Password_Input" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Conform_Password_Input">Confirm Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" placeholder="Confirm Password" name="Conform_Password" id="Conform_Password_Input" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="Add_Users_form_Btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .action-btn {
            margin: 0 3px;
            cursor: pointer;
        }
    </style>
@stop

@section('js')

    <script>
        $(function () {
            var section_role_input = $("#section_role_input").val();
            var limit = 10; // Default limit

            // Initialize DataTable with client-side processing
            var usersTable = $('#users_table').DataTable({
                processing: true,
                serverSide: false, // Changed to false to handle data on client side
                ajax: {
                    url: "{{url('/all-users-api')}}/"+limit,
                    type: "GET",
                    dataSrc: function(json) {
                        // Process the data to match DataTables format
                        var return_data = [];
                        var count = 1;

                        if (json.attandence_data && json.attandence_data.data) {
                            var data = json.attandence_data.data;

                            for (var i = 0; i < data.length; i++) {
                                // Only show super admin records if current user is super admin
                                if (data[i].roles == 'Super admin' && section_role_input != 'Super admin') {
                                    continue;
                                }

                                var actions = '';
                                actions += '<button class="btn btn-info btn-sm action-btn" onclick="open_update_Users_form(' + data[i].Employee_id + ')" title="Edit User"><i class="fas fa-pencil-alt"></i></button>';
                                actions += '<button class="btn btn-danger btn-sm action-btn" onclick="delete_user(' + data[i].Employee_id + ')" title="Delete User"><i class="fas fa-trash"></i></button>';
                                actions += '<a href="{{url("/edit-permissions")}}/' + data[i].Employee_id + '" class="btn btn-warning btn-sm action-btn" title="User Permissions"><i class="fas fa-key"></i></a>';

                                // Push data in the format expected by DataTables
                                return_data.push({
                                    "DT_RowIndex": count,
                                    "name": data[i].name,
                                    "Employee_id": data[i].Employee_id,
                                    "email": data[i].email,
                                    "mobile_number": data[i].mobile_number,
                                    "roles": data[i].roles,
                                    "actions": actions
                                });

                                count++;
                            }
                        }

                        return return_data;
                    }
                },
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'name'},
                    {data: 'Employee_id'},
                    {data: 'email'},
                    {data: 'mobile_number'},
                    {data: 'roles'},
                    {data: 'actions', orderable: false, searchable: false}
                ],
                responsive: true,
                lengthChange: true,
                autoWidth: false,
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        className: 'btn btn-secondary btn-sm'
                    },
                    {
                        extend: 'csv',
                        className: 'btn btn-secondary btn-sm'
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-secondary btn-sm'
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-secondary btn-sm'
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-secondary btn-sm'
                    },
                    {
                        extend: 'colvis',
                        className: 'btn btn-secondary btn-sm'
                    }
                ],
                initComplete: function() {
                    usersTable.buttons().container()
                        .appendTo('#custom_buttons');
                }
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search...",
                    processing: '<i class="fas fa-spinner fa-spin fa-3x fa-fw"></i>'
                },
                order: [[1, 'asc']]
            });

            // Handle pagination change to update limit
            $('#users_table').on('length.dt', function(e, settings, len) {
                limit = len;
                usersTable.ajax.url("{{url('/all-users-api')}}/"+limit).load();
            });

            // Handle form validation and submission
            $('#Add_Users_form').submit(function(e) {
                e.preventDefault();

                // Basic validation
                var username = $('#User_Name_Input').val();
                var email = $('#Email_Id_Input').val();
                var mobile = $('#Mobile_Number_Input').val();
                var role = $('#role_select').val();
                var password = $('#Password_Input').val();
                var confirmPassword = $('#Conform_Password_Input').val();

                var isValid = true;
                var errorMessage = '';

                // Clear previous errors
                $('.is-invalid').removeClass('is-invalid');

                // Check required fields
                if (!username) {
                    $('#User_Name_Input').addClass('is-invalid');
                    isValid = false;
                    errorMessage = 'Please enter a username';
                }

                if (!email) {
                    $('#Email_Id_Input').addClass('is-invalid');
                    isValid = false;
                    errorMessage = 'Please enter an email';
                }

                if (!mobile) {
                    $('#Mobile_Number_Input').addClass('is-invalid');
                    isValid = false;
                    errorMessage = 'Please enter a mobile number';
                }

                if (!role) {
                    $('#role_select').addClass('is-invalid');
                    isValid = false;
                    errorMessage = 'Please select a role';
                }

                if (!password) {
                    $('#Password_Input').addClass('is-invalid');
                    isValid = false;
                    errorMessage = 'Please enter a password';
                }

                if (!confirmPassword) {
                    $('#Conform_Password_Input').addClass('is-invalid');
                    isValid = false;
                    errorMessage = 'Please confirm your password';
                }

                if (password !== confirmPassword) {
                    $('#Conform_Password_Input').addClass('is-invalid');
                    isValid = false;
                    errorMessage = 'Passwords do not match';
                }

                // If validation fails
                if (!isValid) {
                    Swal.fire({
                        title: 'Error!',
                        text: errorMessage,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return false;
                }

                // If validation passes, submit the form
                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('Add_Users') }}",
                    method: "POST",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                        $('#userFormModal').modal('hide');
                        $('#Add_Users_form')[0].reset();
                        usersTable.ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = 'An error occurred';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            title: 'Error!',
                            text: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });

        function open_add_user_form() {
            $('#Add_Users_form')[0].reset();
            $("#Add_Users_form_header").text("Add User");
            $("#Add_Users_input_id").val('');
            $('#userFormModal').modal('show');
        }

        function open_update_Users_form(id) {
            $("#Add_Users_form_header").text("Update User");
            $("#Add_Users_input_id").val(id);

            // Show loading overlay
            Swal.fire({
                title: 'Loading...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                type: "GET",
                url: "{{url('/one-user-data-with-id/')}}/"+id,
                dataType: "json",
                success: function(response) {
                    var r_data = response.attandence_data[0];
                    $("#User_Name_Input").val(r_data.name);
                    $("#Email_Id_Input").val(r_data.email);
                    $("#Mobile_Number_Input").val(r_data.mobile_number);
                    $("#role_select").val(r_data.role);
                    $("#Password_Input").val(r_data.password);
                    $("#Conform_Password_Input").val(r_data.password);

                    // Close loading and show modal
                    Swal.close();
                    $('#userFormModal').modal('show');
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Could not load user data',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }

        function delete_user(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to delete user with ID: " + id,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{url('/delet-user-with-id')}}/"+id,
                        method: "GET",
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'User has been deleted successfully.',
                                'success'
                            );
                            $('#users_table').DataTable().ajax.reload();
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Error!',
                                'An error occurred while deleting the user.',
                                'error'
                            );
                        }
                    });
                }
            });
        }

        function show_animation() {
            // Show loading animation
            $('#result').append('<div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>');
        }

        function hide_animation() {
            // Hide loading animation
            $('#result .overlay').remove();
        }
    </script>
@stop

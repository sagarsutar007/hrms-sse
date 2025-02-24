@extends('adminlte::page')

@section('title', 'User List')

@section('content_header')
    <h1>User List</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center">
        <div>
            <button class="btn btn-secondary" id="exportExcel">Excel</button>
            <button class="btn btn-secondary" id="exportPDF">PDF</button>
            <button class="btn btn-secondary" id="printTable">Print</button>
            <div class="btn-group">
                <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">Column visibility</button>
                <div class="dropdown-menu" id="columnVisibility"></div>
            </div>
        </div>
        <div class="ml-auto"> <!-- Added ml-auto to push this div to the right -->
            <button class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">
                <i class="fas fa-user-plus"></i> Add New User
            </button>
        </div>
    </div>

    <div class="card-body">
        <table id="userTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Sr. N.</th>
                    <th>Name</th>
                    <th>User ID</th>
                    <th>Email ID</th>
                    <th>Mobile Number</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Vikash Kumar</td>
                    <td>1</td>
                    <td>readesy01@gmail.com</td>
                    <td>6207820351</td>
                    <td>Super Admin</td>
                    <td>
                        <button class="btn btn-warning btn-sm edit-user" data-toggle="modal" data-target="#editUserModal"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm delete-user" data-toggle="modal" data-target="#deleteUserModal"><i class="fas fa-trash"></i></button>
                        <button class="btn btn-primary btn-sm edit-permission" onclick="window.location.href='/edit-permissions/{employee_id}'"><i class="fas fa-key"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add User</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>User Name *</label>
                                <input type="text" class="form-control" placeholder="User Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email ID *</label>
                                <input type="email" class="form-control" placeholder="Email ID">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Mobile Number *</label>
                                <input type="text" class="form-control" placeholder="Mobile Number">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Role *</label>
                                <select class="form-control">
                                    <option>Select Role</option>
                                    <option>Super Admin</option>
                                    <option>Admin</option>
                                    <option>HR</option>
                                    <option>Guard</option>
                                    <option>Employee</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password *</label>
                                <input type="password" class="form-control" placeholder="Password">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Confirm Password *</label>
                                <input type="password" class="form-control" placeholder="Confirm Password">
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editUserModalLabel">Update User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="editUserForm">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="userName">User Name *</label>
                  <input type="text" class="form-control" id="userName" value="Vikash Kumar">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="email">Email ID *</label>
                  <input type="email" class="form-control" id="email" value="readesy01@gmail.com">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="mobileNumber">Mobile Number *</label>
                  <input type="text" class="form-control" id="mobileNumber" value="6207820351">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="role">Role *</label>
                  <select class="form-control" id="role">
                    <option selected>Super Admin</option>
                    <option>Admin</option>
                    <option>HR</option>
                    <option>Guard</option>
                    <option>Employee</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="password">Password *</label>
                  <input type="password" class="form-control" id="password" value="******">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="confirmPassword">Confirm Password *</label>
                  <input type="password" class="form-control" id="confirmPassword" value="123123">
                </div>
              </div>
            </div>
            <div class="text-right">
              <button type="submit" class="btn btn-primary">Update User</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


<!-- Delete User Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this user?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Permission Modal -->
<div class="modal fade" id="editPermissionModal" tabindex="-1" aria-labelledby="editPermissionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Permissions</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label>Select Role</label>
                        <select class="form-control">
                            <option>Super Admin</option>
                            <option>Admin</option>
                            <option>HR</option>
                            <option>Guard</option>
                            <option>Employee</option>
                        </select>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#userTable').DataTable();
    });
</script>
@endsection

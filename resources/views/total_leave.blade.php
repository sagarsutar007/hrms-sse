@extends('adminlte::page')

@section('title', 'All Leave')

@section('content_header')
    <h1>All Leave</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-success">Excel</button>
                <button class="btn btn-danger">PDF</button>
                <button class="btn btn-secondary">Print</button>
                <div class="btn-group">
                    <button class="btn btn-dark dropdown-toggle" data-toggle="dropdown">Column visibility</button>
                    <div class="dropdown-menu"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <table id="leaveTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Sr. No.</th>
                    <th>Name</th>
                    <th>Employee ID</th>
                    <th>Leave Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Description</th>
                    <th>Remarks by Approver</th>
                    <th>Department</th>
                    <th>Status</th>
                    <th>Half Day</th>
                    <th>Total Days</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>John Doe</td>
                    <td>21</td>
                    <td>Sick Leave</td>
                    <td>2025-01-01</td>
                    <td>2025-01-05</td>
                    <td>fgfffmf</td>
                    <td>nn</td>
                    <td>Maintenance</td>
                    <td>Approved</td>
                    <td>No</td>
                    <td>5</td>
                    <td>
                        <button class="btn btn-info btn-sm view-leave" data-toggle="modal" data-target="#leaveModal" data-name="John Doe" data-employee="21" data-leave="Sick Leave" data-start="2025-01-01" data-end="2025-01-05" data-description="fgfffmf" data-remarks="nn" data-status="Approved" data-total="5"><i class="fas fa-eye"></i></button>
                        <button class="btn btn-warning btn-sm edit-leave"><i class="fas fa-edit" data-toggle="modal" data-target="#editLeaveModal" data-name="John Doe" data-employee="21" data-leave="Sick Leave" data-start="2025-01-01" data-end="2025-01-05" data-description="fgfffmf" data-remarks="nn" data-status="Approved" data-total="5"></i></button>

                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Leave Details Modal -->
<div class="modal fade" id="leaveModal" tabindex="-1" role="dialog" aria-labelledby="leaveModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="leaveModalLabel">Leave Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group"><label>Name:</label> <input type="text" class="form-control" id="leaveName" readonly></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"><label>Employee ID:</label> <input type="text" class="form-control" id="leaveEmployee" readonly></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"><label>Leave Type:</label> <input type="text" class="form-control" id="leaveType" readonly></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"><label>Start Date:</label> <input type="text" class="form-control" id="leaveStart" readonly></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"><label>End Date:</label> <input type="text" class="form-control" id="leaveEnd" readonly></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"><label>Description:</label> <input type="text" class="form-control" id="leaveDescription" readonly></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"><label>Remarks by Approver:</label> <input type="text" class="form-control" id="leaveRemarks" readonly></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"><label>Status:</label> <input type="text" class="form-control" id="leaveStatus" readonly></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"><label>Total Days:</label> <input type="text" class="form-control" id="leaveTotal" readonly></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Leave Modal -->
<div class="modal fade" id="editLeaveModal" tabindex="-1" role="dialog" aria-labelledby="editLeaveModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Leave</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Leave Type *</label>
                                <input type="text" class="form-control" id="editLeaveType">
                            </div>
                        </div>
                        <div class="col-md-6 d-flex align-items-center mt-2">
                            <label class="mr-2 mb-0">Half Day:</label>
                            <input type="checkbox" id="editHalfDay" class="ml-2" style="transform: scale(1.5);">
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Start Date *</label>
                                <input type="date" class="form-control" id="editStartDate">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>End Date *</label>
                                <input type="date" class="form-control" id="editEndDate">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Total Days *</label>
                                <input type="text" class="form-control" id="editTotalDays">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Description *</label>
                                <input type="text" class="form-control" id="editDescription">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Remarks by Approver *</label>
                                <input type="text" class="form-control" id="editRemarks">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status *</label>
                                <select class="form-control" id="editStatus">
                                    <option>Approved</option>
                                    <option>Rejected</option>
                                    <option>Pending</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary mt-3">Submit</button>
                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#leaveTable').DataTable();

            $(".view-leave").click(function () {
            $("#leaveName").val($(this).data("name"));
            $("#leaveEmployee").val($(this).data("employee"));
            $("#leaveType").val($(this).data("leave"));
            $("#leaveStart").val($(this).data("start"));
            $("#leaveEnd").val($(this).data("end"));
            $("#leaveDescription").val($(this).data("description"));
            $("#leaveRemarks").val($(this).data("remarks"));
            $("#leaveStatus").val($(this).data("status"));
            $("#leaveTotal").val($(this).data("total"));
        });

        $(".edit-leave").click(function () {
            $("#editLeaveType").val($(this).data("leave"));
            $("#editStartDate").val($(this).data("start"));
            $("#editEndDate").val($(this).data("end"));
            $("#editTotalDays").val($(this).data("total"));
            $("#editDescription").val($(this).data("description"));
            $("#editRemarks").val($(this).data("remarks"));
            $("#editStatus").val($(this).data("status"));
        });
        });
    </script>
@endsection

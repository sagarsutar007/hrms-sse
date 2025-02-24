@extends('adminlte::page')

@section('title', 'Present/Absent List')

@section('content_header')
    <h1>Present/Absent List</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div>
            <button class="btn btn-secondary" id="exportExcel">Excel</button>
            <button class="btn btn-secondary" id="exportPDF">PDF</button>
            <button class="btn btn-secondary" id="printTable">Print</button>
            <div class="btn-group">
                <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">Column visibility</button>
                <div class="dropdown-menu" id="columnVisibility"></div>
            </div>
        </div>
        <div class="ml-auto">
            <input type="text" class="form-control" placeholder="Search by name & Email">
        </div>
    </div>
    <div class="card-body">
        <table id="attendanceTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Employee Type</th>
                    <th>Shift</th>
                    <th>In Time</th>
                    <th>Out Time</th>
                    <th>Total Hours</th>
                    <th>Total Minutes</th>
                    <th>OT Hours</th>
                    <th>OT Minutes</th>
                    <th>Early</th>
                    <th>Late</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 2; $i <= 16; $i++)
                <tr>
                    <td>{{ $i }}</td>
                    <td>Employee {{ $i }}</td>
                    <td>Production</td>
                    <td>Full Time</td>
                    <td>Day Shift</td>
                    <td>10:18:19</td>
                    <td>10:18:19</td>
                    <td>0.00</td>
                    <td>0</td>
                    <td>0.00</td>
                    <td>0</td>
                    <td>No</td>
                    <td>Yes</td>
                    <td>
                        <button class="btn btn-sm btn-primary editEntry" data-id="{{ $i }}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-success addEntry" data-id="{{ $i }}">
                            <i class="fas fa-plus"></i>
                        </button>
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>
    </div>
    <div class="card-footer d-flex justify-content-between">
        <div>
            <button class="btn btn-sm btn-light">&laquo; Previous</button>
            <button class="btn btn-sm btn-primary">1</button>
            <button class="btn btn-sm btn-light">2</button>
            <button class="btn btn-sm btn-light">Next &raquo;</button>
        </div>
        <div>
            <span>Page Size: 15</span>
            <span>Total Records: 22</span>
        </div>
    </div>
</div>

<!-- Update Attendance Modal -->
<div class="modal fade" id="updateAttendanceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Attendance</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="updateAttendanceForm">
                    <div class="form-group">
                        <label>In Time</label>
                        <input type="time" class="form-control" id="inTime">
                    </div>
                    <div class="form-group">
                        <label>Out Time</label>
                        <input type="time" class="form-control" id="outTime">
                    </div>
                    <div class="form-group">
                        <label>Attendance Date</label>
                        <input type="date" class="form-control" id="attendanceDate">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" id="attendanceStatus">
                            <option value="present">Present</option>
                            <option value="absent">Absent</option>
                            <option value="half-day">Half Day</option>
                            <option value="leave">On Leave</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="updateNow">Update</button>
            </div>
        </div>
    </div>
</div>

<div id="punchCardModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content text-center">
            <div class="modal-body d-flex justify-content-center align-items-center" style="height: 80vh;">
                <div class="card text-center" style="width: 250px; border-radius: 10px; box-shadow: 2px 2px 10px rgba(0,0,0,0.1);">
                    <div class="card-header bg-secondary text-white" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
                        <h5 class="m-0">Punch Card</h5>
                    </div>
                    <div class="card-body">
                        <div style="background: gray; height: 80px; width: 100%; position: relative;">
                            <span style="position: absolute; top: 10px; left: 50%; transform: translateX(-50%); width: 30px; height: 5px; background: white; border-radius: 5px;"></span>
                            <img src="/path-to-placeholder.png" alt="Placeholder" style="position: absolute; top: 30px; left: 50%; transform: translateX(-50%); width: 20px; height: 20px;">
                        </div>
                        <h5 class="mt-3 font-weight-bold" id="punchCardEmployee"></h5>
                        <p class="text-muted">Employee</p>
                        <p class="text-danger font-weight-bold">Punch Out Ok</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
$(document).ready(function () {
    $('#attendanceTable').DataTable();

    $('.editEntry').on('click', function () {
        let id = $(this).data('id');
        alert('Edit entry for Employee ID: ' + id);
    });

    $('.addEntry').on('click', function () {
        let id = $(this).data('id');
        $('#punchCardEmployee').text('Employee ' + id);
        $('#punchCardModal').modal('show');
    });
});
</script>
@endsection

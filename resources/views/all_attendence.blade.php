@extends('adminlte::page')

@section('title', 'Attendance List')

@section('content_header')
    <h1>Attendance List</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <button class="btn btn-secondary" id="exportExcel">Excel</button>
        <button class="btn btn-secondary" id="exportPDF">PDF</button>
        <button class="btn btn-secondary" id="printTable">Print</button>
        <div class="btn-group">
            <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">Column visibility</button>
            <div class="dropdown-menu" id="columnVisibility"></div>
        </div>
        <button class="btn btn-primary float-right" id="generateAttendance">
            <i class="fas fa-calendar-plus"></i> Generate Attendance
        </button>
        <button class="btn btn-danger float-right mr-2" id="bulkDelete">
            <i class="fas fa-trash"></i> Bulk Delete
        </button>
    </div>
    <div class="card-body">
        <table id="attendanceTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th>Employee ID</th>
                    <th>Attendance Time</th>
                    <th>Attendance Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < 20; $i++)
                <tr>
                    <td><input type="checkbox" class="selectRow"></td>
                    <td>21</td>
                    <td>14:18:{{ 20 - $i }}</td>
                    <td>2025-02-13</td>
                    <td>
                        <button class="btn btn-sm btn-primary editEntry" data-id="{{ $i }}">
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="modalForm" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Attendance</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="attendanceForm">
                    <input type="hidden" id="entryId">
                    <div class="form-group">
                        <label>Employee ID</label>
                        <input type="text" class="form-control" id="employeeId" readonly>
                    </div>
                    <div class="form-group">
                        <label>Attendance Time</label>
                        <input type="time" class="form-control" id="attendanceTime">
                    </div>
                    <div class="form-group">
                        <label>Attendance Date</label>
                        <input type="date" class="form-control" id="attendanceDate">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveChanges">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Generate Attendance Modal -->
<div class="modal fade" id="generateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Generate Attendance</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="generateAttendanceForm">
                    <div class="form-group">
                        <label>From Date</label>
                        <input type="date" class="form-control" id="fromDate">
                    </div>
                    <div class="form-group">
                        <label>To Date</label>
                        <input type="date" class="form-control" id="toDate">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="generateNow">Generate</button>
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
        $('#entryId').val(id);
        $('#employeeId').val(21);
        $('#attendanceTime').val('14:18:00');
        $('#attendanceDate').val('2025-02-13');
        $('#modalForm').modal('show');
    });

    $('#saveChanges').on('click', function () {
        let id = $('#entryId').val();
        alert('Saved changes for entry ID: ' + id);
        $('#modalForm').modal('hide');
    });

    $('#generateAttendance').on('click', function () {
        $('#generateModal').modal('show');
    });

    $('#generateNow').on('click', function () {
        let fromDate = $('#fromDate').val();
        let toDate = $('#toDate').val();
        alert('Generating attendance from ' + fromDate + ' to ' + toDate);
        $('#generateModal').modal('hide');
    });
});
</script>
@endsection

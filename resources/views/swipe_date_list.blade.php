@extends('adminlte::page')

@section('title', 'Swap Date List')

@section('content_header')
    <h1>Swap Date List</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row align-items-end">
            <div class="col-md-2">
                <label for="holiday_date"><i class="fas fa-calendar-alt"></i> Holiday Date</label>
                <div class="input-group">
                    <input type="text" class="form-control datepicker" id="holiday_date" placeholder="dd-mm-yyyy">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <label for="swap_date"><i class="fas fa-exchange-alt"></i> Swap Date</label>
                <div class="input-group">
                    <input type="text" class="form-control datepicker" id="swap_date" placeholder="dd-mm-yyyy">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <label for="public_holiday"><i class="fas fa-check-circle"></i> Public Holiday</label>
                <select class="form-control" id="public_holiday">
                    <option>Yes</option>
                    <option>No</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="message"><i class="fas fa-comment"></i> Message</label>
                <input type="text" class="form-control" id="message">
            </div>
            <div class="col-md-2 text-right mt-3">
            <button class="btn btn-success"><i class="fas fa-save"></i> Save Swap Holiday</button>
        </div>
        </div>


    </div>

    <div class="card-body">
        <table id="swapTable" class="table table-striped table-bordered nowrap" style="width:100%">
            <thead>
                <tr>
                    <th><input type="checkbox"></th>
                    <th>Name</th>
                    <th>Employee ID</th>
                    <th>Shift Time</th>
                    <th>Employee Type</th>
                    <th>Role</th>
                    <th>Weekly Off</th>
                    <th>Department</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>SHEELA DEVI</td>
                    <td>2</td>
                    <td>Day Shift</td>
                    <td>Full Time</td>
                    <td>Employee</td>
                    <td>Sunday</td>
                    <td>Production</td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>BABITA DEVI</td>
                    <td>3</td>
                    <td>Day Shift</td>
                    <td>Full Time</td>
                    <td>Employee</td>
                    <td>Sunday</td>
                    <td>Production</td>
                </tr>
                <!-- Add more static rows here -->
            </tbody>
        </table>
    </div>
</div>
@stop

@section('js')
<script>
    $(document).ready(function () {
        // Initialize DataTable with responsiveness
        $('#swapTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "responsive": true

        });

        // Initialize Datepicker
        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true
        });
    });
</script>
@stop

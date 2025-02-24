<!-- resources/views/salary/index.blade.php -->
@extends('adminlte::page')

@section('title', 'Salary Sheet')

@section('content_header')
    <h1>Salary Sheet</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="btn-group">
                    <button type="button" class="btn btn-success" title="Excel">
                        <i class="fas fa-file-excel"></i> Excel
                    </button>
                    <button type="button" class="btn btn-danger" title="PDF">
                        <i class="fas fa-file-pdf"></i> PDF
                    </button>
                    <button type="button" class="btn btn-default" title="Print">
                        <i class="fas fa-print"></i> Print
                    </button>
                    <button type="button" class="btn btn-default" title="Toggle Days">
                        <i class="fas fa-calendar-day"></i> Toggle Days
                    </button>
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-success btn-block" id="pay-salary-btn" data-toggle="modal" data-target="#confirmPayModal">
                    <i class="fas fa-money-bill-wave"></i> Pay All Employee Salary
                </button>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <input type="month" class="form-control" value="{{ date('Y-m') }}">
                    <div class="input-group-append">
                        <button class="btn btn-default">
                            <i class="fas fa-calendar"></i>
                        </button>
                    </div>
                    <input type="text" id="search" class="form-control ml-2" placeholder="Search..." style="width: 200px;">
                </div>
            </div>
        </div>
    </div>

    <div class="card-body" style="max-height: 1000px; overflow-y: auto; overflow-x: auto; white-space: nowrap;">
        <div class="mb-2">
            <span style="display:inline-block; width:15px; height:15px; background-color:#00FFFF; margin-right:5px;"></span> Weekly Off
            <span style="display:inline-block; width:15px; height:15px; background-color:#FFFF00; margin-right:5px;"></span> Holiday
            <span style="display:inline-block; width:15px; height:15px; background-color:#FFA500; margin-right:5px;"></span> Swap Day
            <span style="display:inline-block; width:15px; height:15px; background-color:#FF0000; margin-right:5px;"></span> Sick Leave
            <span style="display:inline-block; width:15px; height:15px; background-color:#FF00FF; margin-right:5px;"></span> Casual Leave
        </div>
        <table id="salary-table" class="table table-bordered table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Sl No</th>
                    <th>Name</th>
                    <th>Employee ID</th>
                    <th>Shift Hrs</th>
                    <th colspan="6">Saturday, February 01, 2025</th>
                    <th colspan="6">Sunday, February 02, 2025</th>
                    <th colspan="6">Sunday, February 02, 2025</th>
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>In</th>
                    <th>Out</th>
                    <th>Total Hrs</th>
                    <th>OT Min</th>
                    <th>OT Amt</th>
                    <th>Daily Amt</th>
                    <th>In</th>
                    <th>Out</th>
                    <th>Total Hrs</th>
                    <th>OT Min</th>
                    <th>OT Amt</th>
                    <th>Daily Amt</th>
                    <th>In</th>
                    <th>Out</th>
                    <th>Total Hrs</th>
                    <th>OT Min</th>
                    <th>OT Amt</th>
                    <th>Daily Amt</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Sheela Devi</td>
                    <td>2</td>
                    <td>8.5</td>
                    <td>09:23</td>
                    <td>17:27</td>
                    <td>08:04</td>
                    <td>0</td>
                    <td>0.00</td>
                    <td>375.00</td>
                    <td>09:18</td>
                    <td>17:20</td>
                    <td>08:01</td>
                    <td>0</td>
                    <td>0.00</td>
                    <td>750.00</td>
                    <td>09:20</td>
                    <td>17:22</td>
                    <td>08:02</td>
                    <td>5</td>
                    <td>10.00</td>
                    <td>760.00</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Babita Devi</td>
                    <td>3</td>
                    <td>8.5</td>
                    <td>09:08</td>
                    <td>17:17</td>
                    <td>08:09</td>
                    <td>0</td>
                    <td>0.00</td>
                    <td>382.14</td>
                    <td>09:12</td>
                    <td>17:02</td>
                    <td>07:43</td>
                    <td>0</td>
                    <td>0.00</td>
                    <td>764.29</td>
                    <td>09:20</td>
                    <td>17:22</td>
                    <td>08:02</td>
                    <td>5</td>
                    <td>10.00</td>
                    <td>760.00</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Rajesh Kumar</td>
                    <td>4</td>
                    <td>8.5</td>
                    <td>09:00</td>
                    <td>17:15</td>
                    <td>08:15</td>
                    <td>15</td>
                    <td>25.00</td>
                    <td>400.00</td>
                    <td>09:05</td>
                    <td>17:10</td>
                    <td>08:05</td>
                    <td>5</td>
                    <td>10.00</td>
                    <td>800.00</td>
                    <td>09:20</td>
                    <td>17:22</td>
                    <td>08:02</td>
                    <td>5</td>
                    <td>10.00</td>
                    <td>760.00</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Priya Singh</td>
                    <td>5</td>
                    <td>8.5</td>
                    <td>09:15</td>
                    <td>17:30</td>
                    <td>08:15</td>
                    <td>15</td>
                    <td>25.00</td>
                    <td>375.00</td>
                    <td>09:10</td>
                    <td>17:15</td>
                    <td>08:05</td>
                    <td>5</td>
                    <td>10.00</td>
                    <td>750.00</td>
                    <td>09:20</td>
                    <td>17:22</td>
                    <td>08:02</td>
                    <td>5</td>
                    <td>10.00</td>
                    <td>760.00</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Amit Sharma</td>
                    <td>6</td>
                    <td>8.5</td>
                    <td>09:20</td>
                    <td>17:25</td>
                    <td>08:05</td>
                    <td>5</td>
                    <td>10.00</td>
                    <td>380.00</td>
                    <td>09:15</td>
                    <td>17:20</td>
                    <td>08:05</td>
                    <td>5</td>
                    <td>10.00</td>
                    <td>760.00</td>
                    <td>09:20</td>
                    <td>17:22</td>
                    <td>08:02</td>
                    <td>5</td>
                    <td>10.00</td>
                    <td>760.00</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmPayModal" tabindex="-1" role="dialog" aria-labelledby="confirmPayModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmPayModalLabel">Confirm Salary Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to pay all employee salaries?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirm-pay-btn">Yes, Pay Salaries</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap4.min.css">
<style>
    .btn-group .btn {
        margin-right: 5px;
    }
    .btn i {
        margin-right: 5px;
    }
    .dataTables_wrapper {
        position: relative;
    }
    .dataTables_wrapper .dataTables_paginate {
        position: fixed;
        right: 20px;
        bottom: 20px;
        background: white;
        padding: 5px;
        border-radius: 5px;
        z-index: 1000;
    }
    .card-body {
        overflow-x: auto;
        white-space: nowrap;
        position: relative;
    }
    #salary-table {
        min-width: 100%;
    }
</style>
@stop

@section('js')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {
    var table = $('#salary-table').DataTable({
        "pageLength": 5,
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
        "ordering": true,
        "searching": false,
        "responsive": true,
        "buttons": [],
        "columnDefs": [
            {
                "targets": [4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15],
                "orderable": false
            }
        ]
    });

    // Toggle Days button functionality
    $('.btn-group .btn:first-child').on('click', function() {
        var sunday = [10, 11, 12, 13, 14, 15];
        $.each(sunday, function(i, col) {
            var column = table.column(col);
            column.visible(!column.visible());
        });
    });

    // Excel export
    $('.btn-group .btn:nth-child(2)').on('click', function() {
        table.button('.buttons-excel').trigger();
    });

    // PDF export
    $('.btn-group .btn:nth-child(3)').on('click', function() {
        table.button('.buttons-pdf').trigger();
    });

    // Print
    $('.btn-group .btn:last-child').on('click', function() {
        table.button('.buttons-print').trigger();
    });

    $('#pay-salary-btn').on('click', function() {
        $('#confirmPayModal').modal('hide');
        // Add AJAX request or form submission logic here
    });
});
</script>
@stop

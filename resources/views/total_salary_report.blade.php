@extends('adminlte::page')

@section('title', 'Salary Sheet - ' . date('m - Y'))

@section('content_header')
    <h1>Salary Sheet for {{ date('m - Y') }}</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col-md-10">
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
                </div>
            </div>
            <div class="col-md-2">
                <div class="input-group">
                    <input type="date" class="form-control" value="{{ date('Y-m-d') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <table id="salarySheetReportTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Shift Name</th>
                    <th>OT Amount</th>
                    <th>Salary Amount</th>
                    <th>Total Paid Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>12</td>
                    <td>Gayatri (H.K)</td>
                    <td>Day Shift</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>21</td>
                    <td>Arbind Kumar</td>
                    <td>Day Shift</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Guddu</td>
                    <td>Day Shift</td>
                    <td>0</td>
                    <td>6250</td>
                    <td>6250</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Babita Devi</td>
                    <td>Day Shift</td>
                    <td>0</td>
                    <td>5350</td>
                    <td>5350</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Heela Devi</td>
                    <td>Day Shift</td>
                    <td>0</td>
                    <td>12000</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>20</td>
                    <td>Arpit Mihra</td>
                    <td>Day Shift</td>
                    <td>0</td>
                    <td>18286</td>
                    <td>18286</td>
                </tr>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td>0</td>
                    <td>46336</td>
                    <td>34336</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#salarySheetReportTable').DataTable({
            "responsive": true,
            "autoWidth": false,
            "paging": true,
            "lengthMenu": [10, 25, 50, 100],
            "pageLength": 10,
            "searching": true,
            "ordering": true,
            "buttons": ["excel", "pdf", "print"],
            "dom": 'Bfrtip'
        });
    });
</script>
@endsection

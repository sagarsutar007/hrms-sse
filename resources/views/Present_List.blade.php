@extends('adminlte::page')

@section('title', 'Present List')

@section('content_header')
    <h1>Present List</h1>
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
                    <input type="date" class="form-control">
                    <div class="input-group-append">
                        <button class="btn btn-primary">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <table id="presentTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Sr. No.</th>
                    <th>Employee Name</th>
                    <th>Employee ID</th>
                    <th>Shift Name</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Aadarsh Namdev</td>
                    <td>18</td>
                    <td>Day Shift</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#presentTable').DataTable({
            "responsive": true,
            "autoWidth": false,
            "buttons": ["excel", "pdf", "print"],
            "dom": 'Bfrtip'
        });
    });
</script>
@endsection

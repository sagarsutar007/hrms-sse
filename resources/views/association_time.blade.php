@extends('adminlte::page')

@section('title', 'Association Time List')

@section('content_header')
    <h1>Association Time List</h1>
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
        <table id="associationTimeTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Sr. No.</th>
                    <th>Employee Name</th>
                    <th>DOJ</th>
                    <th>Years Months Difference</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Sheela Devi</td>
                    <td>2014-09-05</td>
                    <td>10 years 5 months</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Babita Devi</td>
                    <td>2015-09-05</td>
                    <td>9 years 5 months</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Afsana Khatoon</td>
                    <td>2019-12-12</td>
                    <td>5 years 2 months</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Guddu</td>
                    <td>2020-06-19</td>
                    <td>4 years 8 months</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Chanda Devi</td>
                    <td>2020-08-12</td>
                    <td>4 years 6 months</td>
                </tr>
                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#associationTimeTable').DataTable({
            "responsive": true,
            "autoWidth": false,
            "buttons": ["excel", "pdf", "print"],
            "dom": 'Bfrtip'
        });
    });
</script>
@endsection

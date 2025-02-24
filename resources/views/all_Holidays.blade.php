@extends('adminlte::page')

@section('title', 'Holiday List')

@section('content_header')
    <h1>Holiday List</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <!-- Export Buttons -->
            <div class="col-md-8">
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

            <!-- Date Search Field -->
            <div class="col-md-3">
                <div class="input-group">
                    <input type="date" class="form-control" placeholder="Select Date">
                    <div class="input-group-append">
                        <button class="btn btn-primary">Search</button>
                    </div>
                </div>
            </div>

            <!-- Add New Button (moved after Date input) -->
            <div class="col-md-1 text-end">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addHolidayModal">
                    <i class="fas fa-plus"></i> Add New
                </button>
            </div>
        </div>
    </div>

    <div class="card-body">
        <table id="holidayTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Sr. No.</th>
                    <th>Holiday Name</th>
                    <th>Date</th>
                    <th>Day</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>New Year</td>
                    <td>01-01-2025</td>
                    <td>Wednesday</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Republic Day</td>
                    <td>26-01-2025</td>
                    <td>Sunday</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Independence Day</td>
                    <td>15-08-2025</td>
                    <td>Friday</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Holiday Modal -->
<div class="modal fade" id="addHolidayModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Holiday</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label>Holiday Name</label>
                        <input type="text" class="form-control" placeholder="Enter Holiday Name">
                    </div>
                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-success">Save Holiday</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#holidayTable').DataTable({
            "responsive": true,
            "autoWidth": false,
            "buttons": ["excel", "pdf", "print"],
            "dom": 'Bfrtip'
        });
    });
</script>
@endsection

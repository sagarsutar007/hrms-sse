@extends('adminlte::page')

@section('title', 'Salary Sheet - ' . date('m - Y'))

@section('content_header')
    <h1>Salary Sheet for {{ date('m - Y') }}</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-end">
        <div class="row g-2 align-items-center">
            <!-- Year Dropdown -->
            <div class="col-md-5">
                <select class="form-control" id="yearSelect">
                    <option value="">Select Year</option>
                </select>
            </div>

            <!-- Search Button -->
            <div class="col-md-7">
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
        <!-- Export Buttons -->
        <div class="mb-3">
            <button class="btn btn-secondary export-btn" data-type="excel">
                <i class="fas fa-file-excel"></i> Excel
            </button>
            <button class="btn btn-secondary export-btn" data-type="pdf">
                <i class="fas fa-file-pdf"></i> PDF
            </button>
            <button class="btn btn-secondary export-btn" data-type="print">
                <i class="fas fa-print"></i> Print
            </button>
        </div>

        <!-- Company-Wise -->
        <h4><strong>Company Wise</strong></h4>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr><th>OT Amount</th><th>Salary Amount</th><th>Total Paid Amount</th></tr>
            </thead>
            <tbody><tr><td>0</td><td>46336</td><td>34336</td></tr></tbody>
        </table>

        <!-- Department-Wise -->
        <h4><strong>Department Wise</strong></h4>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr><th>Department</th><th>Total Salary Amount</th><th>Total OT Amount</th><th>Total Paid Amount</th><th>Total Employees</th></tr>
            </thead>
            <tbody>
                <tr><td>Production</td><td>28050</td><td>0</td><td>16050</td><td>9</td></tr>
                <tr><td>Quality</td><td>18286</td><td>0</td><td>18286</td><td>4</td></tr>
                <tr><td>Packing</td><td>0</td><td>0</td><td>0</td><td>3</td></tr>
                <tr><td>Maintenance</td><td>0</td><td>0</td><td>0</td><td>1</td></tr>
                <tr><td>House Keeping</td><td>0</td><td>0</td><td>0</td><td>1</td></tr>
                <tr><td>Store</td><td>0</td><td>0</td><td>0</td><td>2</td></tr>
                <tr><td>Admin</td><td>0</td><td>0</td><td>0</td><td>1</td></tr>
                <tr><td>Accounts</td><td>0</td><td>0</td><td>0</td><td>1</td></tr>
            </tbody>
        </table>

        <!-- Role-Wise -->
        <h4><strong>Role Wise</strong></h4>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr><th>Role Name</th><th>Total Salary Amount</th><th>Total OT Amount</th><th>Total Paid Amount</th><th>Total Employees</th></tr>
            </thead>
            <tbody>
                <tr><td>Employee</td><td>46336</td><td>0</td><td>34336</td><td>22</td></tr>
            </tbody>
        </table>

        <!-- Employee Type-Wise -->
        <h4><strong>Employee Type Wise</strong></h4>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr><th>Employee Type</th><th>Total Salary Amount</th><th>Total OT Amount</th><th>Total Paid Amount</th><th>Total Employees</th></tr>
            </thead>
            <tbody>
                <tr><td>Staff</td><td>18286</td><td>0</td><td>18286</td><td>5</td></tr>
                <tr><td>Full Time</td><td>17350</td><td>0</td><td>5350</td><td>7</td></tr>
                <tr><td>Casual</td><td>10700</td><td>0</td><td>10700</td><td>9</td></tr>
                <tr><td>Daily Wages</td><td>0</td><td>0</td><td>0</td><td>1</td></tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('css')
<style>
    .export-btn { margin-right: 5px; }
</style>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Populate Year Dropdown in Descending Order
        let yearSelect = $('#yearSelect');
        let currentYear = new Date().getFullYear();
        let startYear = 1900; // Change this if needed

        for (let year = currentYear + 50; year >= startYear; year--) {
            let option = new Option(year, year);
            yearSelect.append(option);
        }

        // Set Default Selected Year to Current Year
        yearSelect.val(currentYear);

        // Initialize Date Picker with Current Date
        $('#dateSelect').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        }).datepicker('setDate', new Date());

        // Search Button Click Event
        $('#searchBtn').on('click', function() {
            let selectedYear = $('#yearSelect').val();
            let selectedDate = $('#dateSelect').val();

            if (!selectedYear) {
                alert('Please select a year.');
                return;
            }

            alert(`Searching for Year: ${selectedYear}, Date: ${selectedDate}`);
            // Perform actual search logic here (e.g., AJAX call)
        });

        // Export Button Logic
        $('.export-btn').on('click', function() {
            let exportType = $(this).data('type');
            alert(`Exporting as ${exportType}`);
            // Implement export logic here
        });
    });
</script>


@endsection

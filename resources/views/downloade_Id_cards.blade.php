<!-- resources/views/salary/index.blade.php -->
@extends('adminlte::page')

@section('title', 'Punch Card')

@section('content_header')
    <h1>Punch Card</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row align-items-center justify-content-end">
            <!-- Print Punch Cards Button -->
            <div class="col-auto">
                <button type="button" class="btn btn-success" id="print-punch-cards">
                    <i class="fas fa-print"></i> Print Punch Cards
                </button>
            </div>

            <!-- Select All & Deselect All Buttons -->
            <div class="col-auto">
                <button type="button" class="btn btn-primary mx-1" id="select-all">
                    <i class="fas fa-check-double"></i> Select All
                </button>
                <button type="button" class="btn btn-danger mx-1" id="deselect-all">
                    <i class="fas fa-times-circle"></i> Deselect All
                </button>
            </div>

            <!-- Search Input -->
            <div class="col-auto">
                <input type="text" id="search" class="form-control" placeholder="Search..." style="width: 200px;">
            </div>
        </div>
    </div>



    <div class="card-body" style="max-height: 1000px; overflow-y: auto; overflow-x: auto; white-space: nowrap;">
        <div class="cards-container">
            @foreach(['GUDDU', 'RAJKUMAR'] as $employee)
            <div class="card-stack">
                <div class="stacked-card"></div>
                <div class="stacked-card"></div>
                <div class="stacked-card"></div>

                <div class="main-card">
                    <div class="punch-card-header">
                        <input type="checkbox" class="card-checkbox">

                        <h2>Punch Card</h2>
                        <div class="image-container">
                            <img src="https://i.pinimg.com/originals/f2/d0/ac/f2d0ac079588297a2bd818a4c061ec71.jpg" alt="Employee Photo" class="employee-image">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="employee-name">{{ $employee }}</div>
                        <div class="employee-type">Employee</div>
                        <div class="qr-container">
                            <img src="https://miro.medium.com/v2/resize:fit:720/format:webp/1*A9YcoX1YxBUsTg7p-P6GBQ.png" alt="QR Code" class="qr-code">
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@stop

@section('css')
<style>
 .cards-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    padding: 20px;
}

.card-stack {
    position: relative;
    width: 2in;
    margin: 20px;
}

.stacked-card {
    position: absolute;
    width: 2in;
    height: 3.5in; /* Increased height */
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.stacked-card:nth-child(1) { transform: translate(-6px, -6px); }
.stacked-card:nth-child(2) { transform: translate(-4px, -4px); }
.stacked-card:nth-child(3) { transform: translate(-2px, -2px); }

.main-card {
    position: relative;
    width: 2in;
    height: 3.5in; /* Increased height */
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    z-index: 4;
}

.punch-card-header {
    height: 35%; /* Reduced header height percentage */
    background: gray;
    border-radius: 8px 8px 0 0;
    padding: 15px;
    position: relative;
}

.id-tag {
    background: white;
    padding: 5px 15px;
    border-radius: 15px;
    display: inline-block;
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 0.8rem;
}

.card-checkbox {
    position: absolute;
    top: 10px;
    left: 10px;
    transform: scale(1.2);
}

.punch-card-header h2 {
    color: white;
    font-size: 1rem;
    margin-top: 20px;
    text-align: center;
}

.image-container {
    display: flex;
    justify-content: center;
    margin-top: 10px;
}

.employee-image {
    width: 80px;
    height: 80px;
    border: 4px solid rgba(255,255,255,0.2);
    background: white;
    object-fit: cover;
}

.card-body {
    position: relative;
    height: 65%; /* Increased body height percentage */
    padding: 15px 0;
}

.employee-name {
    text-align: center;
    font-weight: bold;
    margin: 15px 0;
    font-size: 1rem;
}

.employee-type {
    background: gray;
    color: white;
    text-align: center;
    padding: 2px 0;
    font-size: 0.8rem;
    margin: 10px 0;
}

.qr-container {
    position: absolute;
    bottom: 20px;
    left: 0;
    right: 0;
    display: flex;
    justify-content: center;
}

.qr-code {
    width: 100px;
    height: 100px;
    background: white;
    padding: 5px;
    border: 1px solid #ddd;
}

@media print {
    .card-stack {
        page-break-inside: avoid;
    }

    .stacked-card {
        display: none;
    }
}
</style>
@stop

@section('js')

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

    $('#select-all').click(function() {
        $('.card-checkbox').prop('checked', true);
    });

    $('#deselect-all').click(function() {
        $('.card-checkbox').prop('checked', false);
    });

    $('#print-cards').click(function() {
        if (!$('.card-checkbox:checked').length) {
            alert('Please select at least one employee');
            return;
        }
        window.print();
    });
});
</script>
@stop

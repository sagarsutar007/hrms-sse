@extends('adminlte::page')

@section('title', 'Employee Association Time List')

@section('content_header')
    <h1 class="m-0 text-dark">Association Time List</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Association Time Details</h3>
        </div>

        <div class="card-body">
            <div class="row mb-3 align-items-end">
                <div class="col-md-6">
                    <label for="date_input"><strong>Filter by Date</strong></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        </div>
                        <input type="date" id="date_input" class="form-control">
                        <div class="input-group-append">
                            <button class="btn btn-primary" id="search_btn"><i class="fas fa-search"></i> Search</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-md-right mt-3 mt-md-0">
                    <div id="export-buttons" class="d-inline-block"></div>
                </div>
            </div>

            <div class="table-responsive">
                <table id="association-time-table" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Employee Name</th>
                            <th>Date of Joining</th>
                            <th>Years Months Difference</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<input type="hidden" value="{{ session('role_number') }}" id="role_number">
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css">
    <style>
        #export-buttons .dt-buttons {
            margin-bottom: 10px;
        }

        .dt-button {
            margin-right: 5px;
        }

        .dataTables_paginate {
            margin-top: 15px;
        }
    </style>
@endsection

@section('js')
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>

    <script>
        $(document).ready(function () {
            function getFormattedToday() {
                const today = new Date();
                return today.toISOString().split('T')[0];
            }

            $('#date_input').val(getFormattedToday());

            const table = $('#association-time-table').DataTable({
                processing: true,
                serverSide: true,
                info: false,
                ajax: {
                    url: "{{ url('/association_time_api') }}",
                    type: 'GET',
                    data: function (d) {
                        d.date = $('#date_input').val();
                    }
                },
                columns: [
                    {
                        data: null,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { data: 'name', name: 'name' },
                    { data: 'DOJ', name: 'DOJ' },
                    { data: 'years_months_diff', name: 'years_months_diff' }
                ],
                responsive: true,
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                order: [[0, 'asc']],
                dom: '<"#export-buttons"B>frtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        className: 'btn btn-success btn-sm'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: 'btn btn-danger btn-sm'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print',
                        className: 'btn btn-dark btn-sm'
                    },
                    {
                        extend: 'colvis',
                        text: 'Column visibility',
                        className: 'btn btn-light btn-sm'
                    }
                ]
            });

            $('#search_btn').on('click', function () {
                table.draw();
            });
        });
    </script>
@endsection

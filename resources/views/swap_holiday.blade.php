@extends('adminlte::page')

@section('title', 'Swap Holiday List')

@section('content_header')
    <h1 class="m-0 text-dark">Swap Holiday List</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped" id="holidayTable">
                <thead>
                    <tr>
                        <th>Sl No</th>
                        <th>Employee Name</th>
                        <th>Holiday Date</th>
                        <th>Swap Date</th>
                        <th>Public Holiday</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($holidays as $index => $holiday)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $holiday->Employee_Name }}</td>
                            <td>{{ $holiday->Holiday_Date }}</td>
                            <td>{{ $holiday->Swap_Date }}</td>
                            <td>
                                @if($holiday->Public_Holiday == 1)
                                    Yes
                                @else
                                    No
                                @endif
                            </td>
                            <td>{{ $holiday->Message }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">
    <style>
        .dt-buttons {
            margin-bottom: 10px;
        }
        .dt-buttons .btn {
            margin-right: 5px;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

    <script>
        $(function () {
            $('#holidayTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "buttons": [
                    {
                        extend: 'excel',
                        className: 'btn-success',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn-danger',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn-primary',
                        text: '<i class="fas fa-print"></i> Print',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'colvis',
                        className: 'btn-info',
                        text: '<i class="fas fa-columns"></i> Columns'
                    }
                ],
                // This positions the buttons at the top of the DataTable
                dom: "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
                     "<'row'<'col-sm-12'tr>>" +
                     "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
            }).buttons().container().appendTo('#holidayTable_wrapper .col-md-6:eq(0)');
        });
    </script>
@stop

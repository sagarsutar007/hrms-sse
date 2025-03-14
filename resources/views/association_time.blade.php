@extends('adminlte::page')

@section('title', 'Employee Association Time List')

@section('content_header')
    <h1>Association Time List</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_input">Filter by Date:</label>
                                <div class="input-group" style="width: 250px;">
                                    <input type="date" class="form-control" id="date_input">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" id="search_date_btn">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-success" id="export_excel">
                                    <i class="fas fa-file-excel mr-1"></i> Excel
                                </button>
                                <button type="button" class="btn btn-danger" id="export_pdf">
                                    <i class="fas fa-file-pdf mr-1"></i> PDF
                                </button>
                                <button type="button" class="btn btn-info" id="print_table">
                                    <i class="fas fa-print mr-1"></i> Print
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="error_message" class="alert alert-danger mt-3" style="display:none;">
                        Error loading data. Please try again.
                    </div>

                    <div id="loading_animation" class="text-center mt-3" style="display:none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="employees_table" class="table table-bordered table-striped table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center" width="80">Sr. No.</th>
                                    <th>Employee Name</th>
                                    <th class="text-center" width="120">DOJ</th>
                                    <th class="text-center" width="180">Years Months Difference</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be loaded here via DataTables -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap4.min.css">
<style>
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 15px;
    }
    .dt-buttons {
        margin-bottom: 15px;
    }
    #employees_table_wrapper .row:first-child {
        align-items: center;
    }
</style>
@stop

@section('js')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap4.min.js"></script>
<script>
    $(function() {
        // Variables
        let baseUrl = "{{ url('/association_time_api') }}";
        let dataTable;

        // Initialize
        setCurrentDate();
        initializeDataTable();

        // Set current date in date input
        function setCurrentDate() {
            const today = new Date();
            const formattedDate = today.toISOString().split('T')[0];
            $('#date_input').val(formattedDate);
        }

        // Event handlers
        $('#search_date_btn').on('click', function() {
            reloadTable();
        });

        $('#export_excel').on('click', exportTableToExcel);
        $('#export_pdf').on('click', exportTableToPDF);
        $('#print_table').on('click', printTable);

        // Functions
        function initializeDataTable() {
            dataTable = $('#employees_table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: baseUrl,
                    type: "GET",
                    data: function(d) {
                        d.date = $('#date_input').val();
                        return d;
                    },
                    error: function(xhr, error, thrown) {
                        $("#error_message").show().text("Error: " + (xhr.responseJSON?.message || thrown || "Failed to load data"));
                    }
                },
                columns: [
                    {
                        data: null,
                        orderable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        className: 'text-center'
                    },
                    {
                        data: 'name',
                        render: function(data) {
                            return data ? escapeHtml(data) : '-';
                        }
                    },
                    {
                        data: 'DOJ',
                        className: 'text-center',
                        render: function(data) {
                            return data ? escapeHtml(data) : '-';
                        }
                    },
                    {
                        data: 'years_months_diff',
                        className: 'text-center',
                        render: function(data) {
                            return data && !isNaN(data) ? escapeHtml(data) : '-';
                        }
                    }
                ],
                order: [[1, 'asc']],
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                pageLength: 25,
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                },
                drawCallback: function() {
                    hideAnimation();
                }
            });
        }

        function reloadTable() {
            showAnimation();
            dataTable.ajax.reload();
        }

        function showAnimation() {
            $("#loading_animation").show();
        }

        function hideAnimation() {
            $("#loading_animation").hide();
        }

        function exportTableToExcel() {
            exportTable('excel');
        }

        function exportTableToPDF() {
            exportTable('pdf');
        }

        function exportTable(format) {
            const date = $('#date_input').val() || 'all_dates';
            const filename = `employee_association_time_${date}.${format}`;

            showAnimation();
            $.ajax({
                url: `${baseUrl}/export/${format}`,
                type: 'GET',
                data: {
                    date: $('#date_input').val(),
                    search: $('#employees_table_filter input').val()
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(blob) {
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.style.display = 'none';
                    a.href = url;
                    a.download = filename;
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    hideAnimation();
                },
                error: function(xhr, status, error) {
                    console.error(`${format.toUpperCase()} export error:`, error);
                    alert(`Failed to export ${format.toUpperCase()} file. Please try again.`);
                    hideAnimation();
                }
            });
        }

        function printTable() {
            const date = $('#date_input').val() || 'All Dates';
            const tableHeader = `
                <h2 class="text-center">Employee Association Time List</h2>
                <p class="text-center">Date: ${date}</p>
            `;

            const printWindow = window.open('', '_blank');

            printWindow.document.write(`
                <html>
                <head>
                    <title>Print - Employee Association Time List</title>
                    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
                    <style>
                        body { font-family: Arial, sans-serif; padding: 20px; }
                        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                        table, th, td { border: 1px solid #ddd; }
                        th, td { padding: 8px; text-align: left; }
                        th { background-color: #f2f2f2; }
                        h2, p { margin-bottom: 10px; }
                        .text-center { text-align: center; }
                        @media print {
                            @page { margin: 0.5cm; }
                        }
                    </style>
                </head>
                <body>
                    ${tableHeader}
                    <table>
                        <thead>
                            <tr>
                                <th class="text-center">Sr. No.</th>
                                <th>Employee Name</th>
                                <th class="text-center">DOJ</th>
                                <th class="text-center">Years Months Difference</th>
                            </tr>
                        </thead>
                        <tbody>
            `);

            // Get current DataTable data and add rows
            const data = dataTable.rows().data();
            data.each(function(item, index) {
                printWindow.document.write(`
                    <tr>
                        <td class="text-center">${index + 1}</td>
                        <td>${escapeHtml(item.name || '-')}</td>
                        <td class="text-center">${escapeHtml(item.DOJ || '-')}</td>
                        <td class="text-center">${escapeHtml(item.years_months_diff && !isNaN(item.years_months_diff) ? item.years_months_diff : '-')}</td>
                    </tr>
                `);
            });

            printWindow.document.write(`</tbody></table></body></html>`);
            printWindow.document.close();

            printWindow.onload = function() {
                printWindow.focus();
                printWindow.print();
            };
        }

        function escapeHtml(unsafe) {
            return unsafe
                ? String(unsafe)
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;")
                : '-';
        }
    });
</script>

@stop

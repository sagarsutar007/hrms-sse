@extends('adminlte::page')

@section('title', 'Late Comers List')

@section('content_header')
    <h1>Late Comers List</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-6">
                    <h5>Employee Late Comers List</h5>
                </div>
                <div class="col-6">
                    <div class="float-right">
                        <div class="input-group">
                            <input type="date" class="form-control" id="date_input" value="{{ request('date', date('Y-m-d')) }}">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="search_btn">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <div class="float-right">
                        <button type="button" class="btn btn-success" onclick="exportTableToExcel()">
                            <i class="fas fa-file-excel"></i> Excel
                        </button>
                        <button type="button" class="btn btn-danger" onclick="exportTableToPDF()">
                            <i class="fas fa-file-pdf"></i> PDF
                        </button>
                        <button type="button" class="btn btn-primary" onclick="printTable()">
                            <i class="fas fa-print"></i> Print
                        </button>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table id="lateComersTable" class="table table-bordered table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th>Sr. N.</th>
                            <th>Employee Name</th>
                            <th>Department</th>
                            <th>Shift Name</th>
                        </tr>
                    </thead>
                    <tbody id="table_body">
                        <!-- Data will be loaded here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <input type="text" value="{{session('role_number')}}" id="role_number" hidden>
@stop


@section('js')
    <script>
        $(function() {
            loadData();

            // Search button click
            $('#search_btn').click(function() {
                loadData();
            });
        });

        function loadData() {
            const date = $('#date_input').val() || '{{ date("Y-m-d") }}';
            const url = "{{ url('/let-Commers-list') }}/" + date;

            $.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                headers: {
                    "Content-Type": "application/json"
                },
                success: function(response) {
                    renderTable(response.data);
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    $('#table_body').html(`
                        <tr>
                            <td colspan="4" class="text-center">Failed to load data. Please try again.</td>
                        </tr>
                    `);
                }
            });
        }

        function renderTable(data) {
            $('#table_body').empty();

            if (!data || data.length === 0) {
                $('#table_body').html(`
                    <tr>
                        <td colspan="4" class="text-center">No records found</td>
                    </tr>
                `);
                return;
            }

            let html = '';
            data.forEach((item, index) => {
                html += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.name}</td>
                        <td>${item.Department_name}</td>
                        <td>${item.Shift_Name}</td>
                    </tr>
                `;
            });

            $('#table_body').html(html);

            dataTable = $('#lateComersTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "pageLength": 10,
                "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                "columnDefs": [
                    { "orderable": false, "targets": 0 } // Disable sorting on Sr. N. column
                ],
                "order": [[1, 'asc']], // Sort by Employee Name by default
                "drawCallback": function(settings) {
                    // Renumber rows on each page
                    let api = this.api();
                    let startIndex = api.page.info().start;

                    api.column(0, {page: 'current'}).nodes().each(function(cell, i) {
                        cell.innerHTML = i + 1 + startIndex;
                    });
                }
            });
        }



        function printTable() {
            // Get the HTML table element
            var table = document.getElementById("lateComersTable").outerHTML;

            // Open a new window
            var newWindow = window.open('', '', 'width=800,height=600');

            // Add the table HTML and styling
            newWindow.document.write('<html><head><title>Late Comers List</title>');
            newWindow.document.write('<style>');
            newWindow.document.write('table { border-collapse: collapse; width: 100%; }');
            newWindow.document.write('th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }');
            newWindow.document.write('th { background-color: #f2f2f2; }');
            newWindow.document.write('</style></head><body>');
            newWindow.document.write('<h2>Late Comers List - ' + $('#date_input').val() + '</h2>');
            newWindow.document.write(table);
            newWindow.document.write('</body></html>');

            // Close the document and print
            newWindow.document.close();
            newWindow.focus();
            newWindow.print();
            newWindow.close();
        }

        function exportTableToExcel() {
            // Check if the SheetJS library is available
            if (typeof XLSX === 'undefined') {
                alert('SheetJS library is not loaded. Please include it in your project.');
                return;
            }

            // Get the table data
            const table = document.getElementById('lateComersTable');
            const wb = XLSX.utils.table_to_book(table, {sheet: "Late Comers"});

            // Generate file name with date
            const fileName = 'LateComers_' + $('#date_input').val() + '.xlsx';

            // Write the file
            XLSX.writeFile(wb, fileName);
        }

        function exportTableToPDF() {
            // Check if jsPDF is available
            if (typeof jspdf === 'undefined' || typeof jspdf.jsPDF === 'undefined') {
                alert('jsPDF library is not loaded. Please include it in your project.');
                return;
            }

            const { jsPDF } = jspdf;
            const doc = new jsPDF();

            // Add title
            doc.text('Late Comers List - ' + $('#date_input').val(), 14, 15);

            // Add the table
            doc.autoTable({
                html: '#lateComersTable',
                startY: 20,
                theme: 'grid',
                styles: {
                    fontSize: 8
                },
                headStyles: {
                    fillColor: [220, 220, 220],
                    textColor: [0, 0, 0]
                }
            });

            // Save the PDF
            doc.save('LateComers_' + $('#date_input').val() + '.pdf');
        }
    </script>

    <!-- Add these scripts in your layout or append them here -->
    <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
    <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>
    <script src="https://unpkg.com/jspdf-autotable@3.5.25/dist/jspdf.plugin.autotable.js"></script>
@stop

@extends('adminlte::page')

@section('title', 'Salary Sheet')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Salary Sheet for <span id="month_year_span">March 2024</span></h3>

                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: auto;">
                            <label for="date_input" class="mr-2">Date:</label>
                            <input type="date" id="date_input" class="form-control mr-2" onchange="changeDate()">
                            <button type="button" class="btn btn-default" id="search_btn" onclick="changeDate()">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="dataTables_length">
                                <label>Show
                                    <select name="employees_table_length" id="table_length_select" class="custom-select custom-select-sm form-control form-control-sm">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select> entries
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6 text-right">
                            <div class="btn-group">
                                <button class="btn btn-success btn-sm" id="export_excel">
                                    <i class="fas fa-file-excel"></i> Excel
                                </button>
                                <button class="btn btn-danger btn-sm mx-1" id="export_pdf">
                                    <i class="fas fa-file-pdf"></i> PDF
                                </button>
                                <button class="btn btn-primary btn-sm" id="print_table">
                                    <i class="fas fa-print"></i> Print
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="salary_table" class="table table-hover table-bordered table-striped">
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
                                    <tbody id="table_body">
                                        <!-- Data will be loaded here via AJAX -->
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Total</th>
                                            <th colspan="2"></th>
                                            <th id="total_ot">0</th>
                                            <th id="total_salary">0</th>
                                            <th id="total_paid">0</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="dataTables_info" id="pagination_info" role="status" aria-live="polite">
                                Showing 0 to 0 of 0 entries
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="dataTables_paginate paging_simple_numbers" id="pagination_controls">
                                <ul class="pagination">
                                    <li class="paginate_button page-item previous disabled" id="prev_page">
                                        <a class="page-link" href="#" tabindex="0">Previous</a>
                                    </li>
                                    <li class="paginate_button page-item active" id="page_1">
                                        <a class="page-link" href="#" tabindex="0">1</a>
                                    </li>
                                    <li class="paginate_button page-item next disabled" id="next_page">
                                        <a class="page-link" href="#" tabindex="0">Next</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    .dataTables_length select {
        width: 60px;
        display: inline-block;
        margin: 0 5px;
    }

    .pagination {
        justify-content: flex-end;
    }

    #loading_animation {
        display: none;
        text-align: center;
        margin: 20px 0;
    }

    #error_message {
        display: none;
        color: red;
        text-align: center;
        margin: 20px 0;
    }

    @media print {
        .no-print {
            display: none;
        }
        .card {
            border: none;
            box-shadow: none;
        }
    }
</style>
@stop

@section('js')
<script>
    $(function() {
        // Variables
        let limit = 50;
        let baseUrl = "{{ url('/totall-salary-amount') }}";
        let page_url = baseUrl;
        let current_page = 1;
        let total_pages = 1;
        let total_records = 0;
        let search_term = '';

        // Initialize
        setCurrentDate();
        loadData();

        // Set current date in date input
        function setCurrentDate() {
            const today = new Date();
            const formattedDate = today.toISOString().split('T')[0];
            $('#date_input').val(formattedDate);

            let month = today.getMonth() + 1;
            let year = today.getFullYear();
            month = month.toString().padStart(2, '0');
            document.getElementById("month_year_span").innerHTML = `${month}-${year}`;
        }

        // Event handlers
        $('#table_length_select').on('change', function() {
            limit = parseInt($(this).val());
            current_page = 1;
            loadData();
        });

        $('#search_input').on('keyup', function(e) {
            search_term = $(this).val();
            if (e.key === "Enter" || search_term.length === 0) {
                current_page = 1;
                loadData();
            }
        });

        $('#export_excel').on('click', exportTableToExcel);
        $('#export_pdf').on('click', exportTableToPDF);
        $('#print_table').on('click', printTable);

        // Functions
        function changeDate() {
            const date = $('#date_input').val();
            page_url = date ? `${baseUrl}/${date}` : baseUrl;
            current_page = 1;
            loadData();
        }

        function loadData() {
            showAnimation();

            $.ajax({
                url: page_url,
                type: "GET",
                dataType: "json",
                data: {
                    page: current_page,
                    limit: limit,
                    search: search_term
                },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                    "Content-Type": "application/json"
                },
                success: function(response) {
                    console.log("Response:", response);
                    $("#table_body").empty();
                    $("#error_message").hide();

                    const data = response.data || [];
                    total_pages = response.total_pages || 1;
                    total_records = response.total_records || 0;

                    let Total_Paid_Amount = 0;
                    let Total_OT_Amount = 0;
                    let Total_Salary_amount = 0;

                    if (data.length === 0) {
                        $("#table_body").append(`
                            <tr>
                                <td colspan="6" class="text-center">No records found</td>
                            </tr>
                        `);
                    } else {
                        data.forEach(function(item, index) {
                            Total_Paid_Amount += parseInt(item.Total_Paid_Amount);
                            Total_OT_Amount += parseInt(item.OT_Amount);
                            Total_Salary_amount += parseInt(item.Salary_amount);

                            $("#table_body").append(`
                                <tr>
                                    <td>${item.Employee_id}</td>
                                    <td>${item.name}</td>
                                    <td>${item.shift_name}</td>
                                    <td>${item.OT_Amount}</td>
                                    <td>${item.Salary_amount}</td>
                                    <td>${item.Total_Paid_Amount}</td>
                                </tr>
                            `);
                        });
                    }

                    $("#total_ot").text(Total_OT_Amount);
                    $("#total_salary").text(Total_Salary_amount);
                    $("#total_paid").text(Total_Paid_Amount);

                    updatePaginationInfo();
                    hideAnimation();
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    $("#table_body").empty();
                    $("#table_body").append(`
                        <tr>
                            <td colspan="6" class="text-center">Error loading data</td>
                        </tr>
                    `);
                    $("#error_message").show().text("Error: " + (xhr.responseJSON?.message || error || "Failed to load data"));
                    hideAnimation();
                }
            });
        }

        function updatePaginationInfo() {
            const start = Math.min((current_page - 1) * limit + 1, total_records);
            const end = Math.min(current_page * limit, total_records);

            $('#pagination_info').text(
                total_records > 0
                ? `Showing ${start} to ${end} of ${total_records} entries`
                : 'No entries to show'
            );
        }

        function showAnimation() {
            $("#loading_animation").show();
        }

        function hideAnimation() {
            $("#loading_animation").hide();
        }

        function exportTableToExcel() {
            const date = $('#date_input').val() || 'all_dates';
            const filename = `salary_sheet_${date}.xlsx`;

            showAnimation();
            $.ajax({
                url: `${baseUrl}/export/excel`,
                type: 'GET',
                data: {
                    date: $('#date_input').val(),
                    search: search_term
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
                    console.error("Excel export error:", error);
                    alert("Failed to export Excel file. Please try again.");
                    hideAnimation();
                }
            });
        }

        function exportTableToPDF() {
            const date = $('#date_input').val() || 'all_dates';
            const filename = `salary_sheet_${date}.pdf`;

            showAnimation();
            $.ajax({
                url: `${baseUrl}/export/pdf`,
                type: 'GET',
                data: {
                    date: $('#date_input').val(),
                    search: search_term
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
                    console.error("PDF export error:", error);
                    alert("Failed to export PDF file. Please try again.");
                    hideAnimation();
                }
            });
        }

        function printTable() {
            const tableHeader = `
                <h2 class="text-center">Salary Sheet</h2>
                <p class="text-center">Date: ${$('#date_input').val() || 'All Dates'}</p>
            `;

            const printWindow = window.open('', '_blank');

            printWindow.document.write(`
                <html>
                <head>
                    <title>Print - Salary Sheet</title>
                    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
                    <style>
                        body { font-family: Arial, sans-serif; }
                        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                        table, th, td { border: 1px solid #ddd; }
                        th, td { padding: 8px; text-align: left; }
                        th { background-color: #f2f2f2; }
                        h2, p { margin-bottom: 10px; }
                        @media print {
                            body { padding: 20px; }
                        }
                    </style>
                </head>
                <body>
                    ${tableHeader}
                    <table>
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
                            ${$('#table_body').html()}
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <th colspan="2"></th>
                                <th>${$("#total_ot").text()}</th>
                                <th>${$("#total_salary").text()}</th>
                                <th>${$("#total_paid").text()}</th>
                            </tr>
                        </tfoot>
                    </table>
                </body>
                </html>
            `);

            printWindow.document.close();

            printWindow.onload = function() {
                printWindow.focus();
                printWindow.print();
            };
        }
    });
</script>
@stop

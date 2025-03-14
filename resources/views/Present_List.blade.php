@extends('adminlte::page')

@section('title', 'Present List')

@section('content_header')
    <h1>Present List</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Employee Present List</h3>
                    <div class="card-tools">
                        <div class="input-group" style="width: 350px;">
                            <input type="date" class="form-control float-right" id="date_input" onchange="change_date()">
                            <div class="input-group-append">
                                <button class="btn btn-default" onclick="change_date()">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-success mr-2" onclick="exportTable('excel')">
                                <i class="fas fa-file-excel"></i> Excel
                            </button>
                            <button class="btn btn-danger mr-2" onclick="exportTable('pdf')">
                                <i class="fas fa-file-pdf"></i> PDF
                            </button>
                            <button class="btn btn-primary" onclick="exportTable('print')">
                                <i class="fas fa-print"></i> Print
                            </button>
                        </div>
                    </div>
                    <div id="result" class="table-responsive">
                        <table id="id_of_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Sr. N.</th>
                                    <th>Employee Name</th>
                                    <th>Employee ID</th>
                                    <th>Shift Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be loaded here via AJAX -->
                            </tbody>
                        </table>
                        <div id="error_message" class="alert alert-danger" style="display:none;">
                            Error loading data. Please try again.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    $(document).ready(function() {
        $('#id_of_table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true
        });
    });

    var page_url;
    load_data();

    function load_data() {
        page_url = "{{url('/present-employee-list/')}}/";
        attendance_data_set(page_url);
    }

    function change_date() {
        var date = $('#date_input').val();
        page_url = "{{url('/present-employee-list/')}}/" + date;
        attendance_data_set(page_url);
    }

    function attendance_data_set(url_input) {
        $.ajax({
            url: url_input,
            type: "GET",
            dataType: "json",
            headers: {
                "Content-Type": "application/json"
            },
            success: function(response) {
                console.log("Response:", response);
                var table = $('#id_of_table').DataTable();
                table.clear();
                $("#error_message").hide();

                var count_flag = 1;
                var all_users_data = response.data;
                all_users_data.forEach(function(all_users) {
                    table.row.add([
                        count_flag,
                        all_users.name,
                        all_users.EmployeeID,
                        all_users.Shift_name
                    ]).draw(false);
                    count_flag++;
                });
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                $("#error_message").show();
            }
        });
    }

    function exportTable(type) {
        var table = document.getElementById("id_of_table");
        if (type === "print") {
            var newWindow = window.open('', '', 'width=800,height=600');
            newWindow.document.write('<html><head><title>Print Table</title>');
            newWindow.document.write('<style>table { border-collapse: collapse; width: 100%; } th, td { border: 1px solid black; padding: 8px; text-align: left; }</style>');
            newWindow.document.write('</head><body>');
            newWindow.document.write(table.outerHTML);
            newWindow.document.write('</body></html>');
            newWindow.document.close();
            newWindow.focus();
            newWindow.print();
            newWindow.close();
        } else if (type === "pdf") {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            doc.autoTable({ html: table, startY: 10, theme: 'grid', headStyles: { fillColor: [22, 160, 133] }, styles: { fontSize: 5 } });
            doc.save("table.pdf");
        } else if (type === "excel") {
            var wb = XLSX.utils.table_to_book(table, {sheet: "Sheet1"});
            XLSX.writeFile(wb, "table.xlsx");
        }
    }
</script>
@stop

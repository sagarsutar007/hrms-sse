@extends('adminlte::page')

@section('title', '100% Attendance List')

@section('content_header')
    <h1>100% Attendance List</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Employee 100% Attendance List</h3>
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
                            <button class="btn btn-success mr-2" onclick="exportTableToExcel()">
                                <i class="fas fa-file-excel"></i> Excel
                            </button>
                            <button class="btn btn-danger mr-2" onclick="exportTableToPDF()">
                                <i class="fas fa-file-pdf"></i> PDF
                            </button>
                            <button class="btn btn-primary" onclick="printTable()">
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
                                    <th>Present</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be loaded here via AJAX -->
                            </tbody>
                        </table>
                        <div id="error_message" class="alert alert-danger" style="display:none;">
                            Error loading data. Please try again.
                        </div>
                        <div id="loading_animation" class="text-center" style="display:none;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
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
    var limit = 50;
    var page_url;

    load_data();

    function load_data() {
        page_url = "{{url('/attandance_100_list_api/')}}/";
        attendance_data_set(page_url);
    }

    function change_date() {
        var date = $('#date_input').val();
        page_url = "{{url('/attandance_100_list_api/')}}/" + date;
        attendance_data_set(page_url);
    }

    function attendance_data_set(url_input) {
        show_animation();

        $.ajax({
            url: url_input,
            type: "GET",
            dataType: "json",
            headers: {
                "Content-Type": "application/json"
            },
            success: function(response) {
                console.log("Response:", response);
                $("#result table tbody").empty();
                $("#error_message").hide();

                var count_flag = 1;
                var all_users_data = response.data;
                all_users_data.forEach(function(all_users) {
                    $("#result table tbody").append(`
                        <tr>
                            <td>${count_flag}</td>
                            <td>${all_users.name}</td>
                            <td>${all_users.Present}</td>
                        </tr>
                    `);
                    count_flag++;
                });
                hide_animation();
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                $("#error_message").show();
                hide_animation();
            }
        });
    }

    function show_animation() {
        $("#loading_animation").show();
    }

    function hide_animation() {
        $("#loading_animation").hide();
    }

    // Placeholder functions for export and print
    function exportTableToExcel() {
        alert('Excel export functionality would be implemented here');
    }

    function exportTableToPDF() {
        alert('PDF export functionality would be implemented here');
    }

    function printTable() {
        alert('Print functionality would be implemented here');
    }
</script>
@stop

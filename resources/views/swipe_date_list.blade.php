@extends('adminlte::page')

@section('title', 'Swap Date List')

@section('content_header')
    <h1>Swap Date List</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row align-items-end">
            <div class="col-md-2">
                <label for="holiday_date"><i class="fas fa-calendar-alt"></i> Holiday Date</label>
                <div class="input-group">
                    <input type="text" class="form-control datepicker" id="holiday_date" placeholder="dd-mm-yyyy">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <label for="swap_date"><i class="fas fa-exchange-alt"></i> Swap Date</label>
                <div class="input-group">
                    <input type="text" class="form-control datepicker" id="swap_date" placeholder="dd-mm-yyyy">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <label for="public_holiday"><i class="fas fa-check-circle"></i> Public Holiday</label>
                <select class="form-control" id="public_holiday">
                    <option>Yes</option>
                    <option>No</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="message"><i class="fas fa-comment"></i> Message</label>
                <input type="text" class="form-control" id="message">
            </div>
            <div class="col-md-2 text-right mt-3">
                <button class="btn btn-success" id="saveSwapHoliday"><i class="fas fa-save"></i> Save Swap Holiday</button>
            </div>
        </div>
    </div>

    <div class="card-body">
        <!-- Hidden input for role number -->
        <input type="hidden" id="role_number" value="1">

        <table id="swapTable" class="table table-striped table-bordered nowrap" style="width:100%">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select_all"></th>
                    <th>Name</th>
                    <th>Employee ID</th>
                    <th>Shift Time</th>
                    <th>Employee Type</th>
                    <th>Role</th>
                    <th>Weekly Off</th>
                    <th>Department</th>
                </tr>
            </thead>
            <tbody id="result">
                <!-- Table data will be loaded here -->
            </tbody>
        </table>
    </div>
</div>
@stop

@section('js')
<script>
    $(document).ready(function () {
        // Initialize DataTable with responsiveness
        var table = $('#swapTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "responsive": true
        });

        // Initialize Datepicker
        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true
        });

        // Call function to fetch data
        attendance_data_set('/api/get-employees');

        // Handle select all checkbox
        $("#select_all").change(function() {
            $(".checkbox_ids").prop('checked', $(this).prop('checked'));
        });

        // Save Swap Holiday button click event
        $("#saveSwapHoliday").click(function() {
            saveSwapHoliday();
        });
    });

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

                // Clear existing table rows
                $("#result").empty();

                var all_users_data = response.all_users.data;
                var role_number = $("#role_number").val() || 0;

                // Add rows to the table
                all_users_data.forEach(function(user) {
                    if (user.role >= role_number) {
                        $("#result").append(`
                            <tr id="employee_id${user.id}">
                                <td><input type="checkbox" name="delet_ids" class="checkbox_ids" value="${user.Employee_id}"></td>
                                <td>${user.f_name} ${user.m_name} ${user.l_name}</td>
                                <td>${user.Employee_id}</td>
                                <td>${user.Shift_Name}</td>
                                <td>${user.EmpTypeName}</td>
                                <td>${user.roles}</td>
                                <td>${user.Weekly_Off}</td>
                                <td>${user.Department_name}</td>
                            </tr>
                        `);
                    }
                });

                // Refresh the DataTable
                $('#swapTable').DataTable().destroy();
                $('#swapTable').DataTable({
                    "paging": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "responsive": true
                });
            },
            error: function(xhr, status, error) {
                console.error("Error fetching data:", error);
                $("#result").html('<tr><td colspan="8" class="text-center">Error loading data. Please try again.</td></tr>');
            }
        });
    }

    function saveSwapHoliday() {
        // Get selected employee IDs
        var selectedEmployees = [];
        $('.checkbox_ids:checked').each(function() {
            selectedEmployees.push($(this).val());
        });

        // Get form data
        var holidayDate = $('#holiday_date').val();
        var swapDate = $('#swap_date').val();
        var isPublicHoliday = $('#public_holiday').val();
        var message = $('#message').val();

        // Validate inputs
        if (!holidayDate || !swapDate) {
            alert("Please select both holiday date and swap date.");
            return;
        }

        if (selectedEmployees.length === 0) {
            alert("Please select at least one employee.");
            return;
        }

        // Send data to server
        $.ajax({
            url: '/api/save-swap-holiday',
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify({
                holiday_date: holidayDate,
                swap_date: swapDate,
                public_holiday: isPublicHoliday,
                message: message,
                employee_ids: selectedEmployees
            }),
            success: function(response) {
                alert("Swap holiday saved successfully!");
                // Reset form
                $('#holiday_date').val('');
                $('#swap_date').val('');
                $('#message').val('');
                $('.checkbox_ids').prop('checked', false);
                $('#select_all').prop('checked', false);
            },
            error: function(xhr, status, error) {
                console.error("Error saving swap holiday:", error);
                alert("Error saving swap holiday. Please try again.");
            }
        });
    }

    // Sort function for table columns
    function short_data(column) {
        // Toggle sort direction
        var currentDir = $("#" + column + "_span").attr("data-sort") || "asc";
        var newDir = currentDir === "asc" ? "desc" : "asc";

        // Update sort icon
        $("#" + column + "_span").attr("data-sort", newDir);

        // Sort the DataTable
        var table = $('#swapTable').DataTable();
        var columnIndex = 0;

        // Determine column index
        switch(column) {
            case 'f_name':
                columnIndex = 1;
                break;
            case 'Employee_id':
                columnIndex = 2;
                break;
            default:
                columnIndex = 1;
        }

        table.order([columnIndex, newDir]).draw();
    }
</script>
@stop

@extends('adminlte::page')

@section('title', 'Swap Date List')

@section('content_header')
    <h1>Swap Date List</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title">Manage Swap Dates</h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="button" class="btn btn-success" id="save_swap_holiday_btn">
                                <i class="fa-regular fa-floppy-disk"></i> Save Swap Holiday
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3 d-none">
                        <div class="col-md-6">
                            <div class="form-group mt-4">
                                <input type="text" value="{{ session('role_number') }}" id="role_number" hidden>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="holiday_date_input">Holiday Date</label>
                                <input type="date" name="holiday_date" id="holiday_date_input" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="swap_date_input">Swap Date</label>
                                <input type="date" name="swap_date" id="swap_date_input" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="Public_Holiday">Public Holiday</label>
                                <select name="Public_Holiday" id="Public_Holiday" class="form-control">
                                    <option value="1" id="yes_opt">Yes</option>
                                    <option value="0" id="no_opt">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="message_input">Message</label>
                                <input type="text" name="message" id="message_input" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div id="result">
                                <div class="text-center" id="loading" style="display: none;">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <p>Loading data...</p>
                                </div>

                                <div id="data-container">
                                    <table id="employees_table" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" name="" id="sellect_all_ids" onchange="sellect_all()"></th>
                                                <th>Name</th>
                                                <th>Employee ID</th>
                                                <th>Shift Time</th>
                                                <th>Employee Type</th>
                                                <th>Role</th>
                                                <th>Weekly Off</th>
                                                <th>Department</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Data will be filled by AJAX -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
@stop

@section('js')
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
<script>
    var public_holiday = '';
    var public_holiday_date = '';
    var select_date_day = '';
    var employeesTable;

    $(document).ready(function() {
        // Initialize DataTable with empty data
        employeesTable = $('#employees_table').DataTable({
            processing: true,
            pageLength: 50,
            columns: [
                { data: 'checkbox', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'employee_id', name: 'employee_id' },
                { data: 'shift', name: 'shift' },
                { data: 'type', name: 'type' },
                { data: 'role', name: 'role' },
                { data: 'weekly_off', name: 'weekly_off' },
                { data: 'department', name: 'department' },
                { data: 'actions', orderable: false, searchable: false }
            ],
            language: {
                lengthMenu: "Show _MENU_ entries",
                search: "Search:",
                zeroRecords: "No matching records found",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "Showing 0 to 0 of 0 entries",
                infoFiltered: "(filtered from _MAX_ total entries)"
            }
        });

        // Load initial data
        load_data();

        $('#holiday_date_input').on('change', function() {
            const dateInput = $(this).val();
            if (dateInput) {
                const date = new Date(dateInput);
                const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                const dayOfWeek = days[date.getDay()];
                $('#dayDisplay').text(`${dayOfWeek}`);
                var url_input = '{{ url('/all-holiday-search-api/10') }}/' + dateInput;
                $.ajax({
                    url: url_input,
                    type: "GET",
                    dataType: "json",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    success: function(response) {
                        console.log("Holiday search Response:", response);
                        var holiday = response.all_users.data;

                        if (holiday != '') {
                            $("#yes_opt").attr("selected", "selected");
                            $("#no_opt").removeAttr("selected");
                            public_holiday = 'No';

                            page_url = "{{ url('/show-all-employees-api') }}";
                            attendance_data_set(page_url);
                        } else {
                            $("#yes_opt").removeAttr("selected");
                            $("#no_opt").attr("selected", "selected");
                            public_holiday = 'Yes';

                            page_url = "{{ url('/show-all-employees-api') }}/" + dayOfWeek;
                            attendance_data_set(page_url);
                        }
                        public_holiday_date = dateInput;
                        select_date_day = dayOfWeek;
                    },
                    error: function(xhr, status, error) {
                        console.error("Holiday search Error:", error);
                        console.error("Status:", status);
                        console.error("XHR Object:", xhr);
                        show_error("Error loading holiday data");
                    }
                });
            }
        });

        $('#save_swap_holiday_btn').click(function(e) {
            var swap_date = $('#swap_date_input').val();
            var holiday_date = $('#holiday_date_input').val();
            var Public_Holiday = $('#Public_Holiday').val();
            var message_inpu = $('#message_input').val();
            var all_ids = [];

            $('input:checkbox[name=delet_ids]:checked').each(function() {
                all_ids.push($(this).val());
            });

            if (holiday_date == "" || all_ids.length == 0) {
                if (holiday_date == "") {
                    show_error("Please Enter Holiday Date");
                } else {
                    show_error("Please select Employee");
                }
            } else {
                $.ajax({
                    url: "{{ route('add_holiday') }}",
                    type: "POST",
                    data: {
                        holiday_date: holiday_date,
                        Public_Holiday: Public_Holiday,
                        message_inpu: message_inpu,
                        swap_date: swap_date,
                        ids: all_ids,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        show_success(response.success);
                        setTimeout(() => {
                            location.reload();
                        }, 3000);
                    },
                    error: function(xhr, status, error) {
                        console.error("Save holiday Error:", error);
                        show_error("Error saving holiday data");
                    }
                });
            }
        });
    });

    function sellect_all() {
        const checkAllCheckbox = document.getElementById("sellect_all_ids");
        const itemCheckboxes = document.querySelectorAll(".checkbox_ids");
        itemCheckboxes.forEach(checkbox => {
            checkbox.checked = checkAllCheckbox.checked;
        });
    }

    function load_data() {
        show_loading(true);
        $.ajax({
            url: "{{ url('/all-employees-api') }}/50",
            type: "GET",
            dataType: "json",
            headers: {
                "Content-Type": "application/json"
            },
            success: function(response) {
                show_loading(false);
                populate_datatable(response);
            },
            error: function(xhr, status, error) {
                console.error("Data load Error:", error);
                show_loading(false);
                show_error("Error loading data. Please try again.");
            }
        });
    }

    function attendance_data_set(url_input) {
        show_loading(true);
        $.ajax({
            url: url_input,
            type: "GET",
            dataType: "json",
            headers: {
                "Content-Type": "application/json"
            },
            success: function(response) {
                show_loading(false);
                populate_datatable(response);
            },
            error: function(xhr, status, error) {
                console.error("Data load Error:", error);
                show_loading(false);
                show_error("Error loading data. Please try again.");
            }
        });
    }

    function populate_datatable(response) {
        if (!response || !response.all_users || !response.all_users.data) {
            employeesTable.clear().draw();
            return;
        }

        var all_users_data = response.all_users.data;
        var role_number = $("#role_number").val();
        var tableData = [];

        all_users_data.forEach(user => {
            if (user.role >= role_number) {
                tableData.push({
                    checkbox: `<input type="checkbox" name="delet_ids" class="checkbox_ids" value="${user.Employee_id}">`,
                    name: `${user.f_name} ${user.m_name} ${user.l_name}`,
                    employee_id: user.Employee_id,
                    shift: user.Shift_Name,
                    type: user.EmpTypeName,
                    role: user.roles,
                    weekly_off: user.Weekly_Off,
                    department: user.Department_name,
                    actions: ''
                });
            }
        });

        // Clear the table and add new data
        employeesTable.clear();
        employeesTable.rows.add(tableData).draw();
    }

    function show_loading(show) {
        if (show) {
            $('#loading').show();
            $('#data-container').hide();
        } else {
            $('#loading').hide();
            $('#data-container').show();
        }
    }

    function show_error(message) {
        toastr.error(message);
    }

    function show_success(message) {
        toastr.success(message);
    }
</script>
@stop

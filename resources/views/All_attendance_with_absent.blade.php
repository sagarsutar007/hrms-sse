@extends('adminlte::page')

@section('title', 'Attendance List')

@section('content_header')
    <h1>Present/Absent List</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    <h3 class="card-title">Attendance Records</h3>
                </div>
                <div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-info" id="exportExcel">
                            <i class="fas fa-file-excel"></i> Excel
                        </button>
                        <button type="button" class="btn btn-danger" id="exportPDF">
                            <i class="fas fa-file-pdf"></i> PDF
                        </button>
                        <button type="button" class="btn btn-secondary" id="printTable">
                            <i class="fas fa-print"></i> Print
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <form action="{{ route('all_attendance_search') }}" method="post" class="form-inline">
                    @csrf
                    <div class="input-group">
                        <input type="search" class="form-control" name="search_input" id="search_input"
                            placeholder="Search by name & Email">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary" id="search_btn">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-responsive" id="result">
                <!-- Table will be loaded here by AJAX -->
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3" id="pagination_div">
                <!-- Pagination will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Update Attendance Modal -->
    <div class="modal fade" id="updateAttendanceModal" tabindex="-1" role="dialog" aria-labelledby="updateAttendanceModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('update_attamdance_data') }}" method="post" id="attendanceEditForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateAttendanceModalLabel">Update Attendance</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="pup_up_form_inner_div">
                        <!-- Form fields will be loaded here via AJAX -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>
    <script>
        $(function() {
            // Load attendance data on page load
            loadAttendance("{{ url('/get-attandence-data-api') }}");

            // Handle pagination click
            $('#pagination_div').on('click', '.page-link', function(e) {
                e.preventDefault();
                var page = $(this).data('page');
                loadAttendance(page);
            });

            // Handle search button click
            $("#search_btn").on("click", function(event) {
                event.preventDefault();
                var searchTerm = $("#search_input").val();
                loadAttendance("{{ url('/get-attandence-data-search-api') }}/" + searchTerm);
            });

            // Handle export buttons
            $("#exportExcel").on("click", function() {
                exportTableToExcel();
            });

            $("#exportPDF").on("click", function() {
                exportTableToPDF();
            });

            $("#printTable").on("click", function() {
                printTable();
            });

            // Submit attendance edit form
            $("#attendanceEditForm").on("submit", function(e) {
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $("#updateAttendanceModal").modal('hide');

                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Attendance updated successfully'
                        });

                        // Reload table data
                        loadAttendance("{{ url('/get-attandence-data-api') }}");
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to update attendance'
                        });
                    }
                });
            });
        });

        // Function to load attendance data
        function loadAttendance(url) {
            // Show loading spinner
            $("#result").html('<div class="text-center"><i class="fas fa-spinner fa-spin fa-2x"></i></div>');

            $.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                headers: {
                    "Content-Type": "application/json"
                },
                success: function(response) {
                    $("#result").empty();

                    var all_attendance = response.attendance_data.data;

                    var table_html_data = `
                        <table id="attendance_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Employee ID <i class="fas fa-sort"></i></th>
                                    <th>Name <i class="fas fa-sort"></i></th>
                                    <th>Department</th>
                                    <th>Employee Type</th>
                                    <th>Shift</th>
                                    <th>In Time</th>
                                    <th>Out Time</th>
                                    <th>Total Hours</th>
                                    <th>Total Minutes</th>
                                    <th>OT Hours</th>
                                    <th>OT Minutes</th>
                                    <th>Early</th>
                                    <th>Late</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>`;

                                all_attendance.forEach(user_data => {
                                    var othrs = user_data.OTHrs;

                                    // Check if attendance is punched (both in_time and out_time exist)
                                    var isAttendancePunched = user_data.in_time && user_data.out_time;

                                    table_html_data += `
                                        <tr>
                                            <td>${user_data.Employee_id}</td>
                                            <td>${user_data.NAME}</td>
                                            <td>${user_data.Department_name}</td>
                                            <td>${user_data.EmpTypeName}</td>
                                            <td>${user_data.Shift_Name}</td>
                                            <td>${user_data.in_time ?? " "}</td>
                                            <td>${user_data.out_time ?? " "}</td>
                                            <td>${user_data.WorkingHours ? parseFloat(user_data.WorkingHours).toFixed(2) : " "}</td>
                                            <td>${user_data.Total_Minutes ?? " "}</td>
                                            <td>${parseFloat(othrs).toFixed(2)}</td>
                                            <td>${user_data.OTMinutes ?? " "}</td>
                                            <td>${user_data.EarlyGoing ?? " "}</td>
                                            <td>${user_data.LateEntry ?? " "}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center" style="gap: 10px;">
                                                    <a href="login/${user_data.Employee_id}" class="btn btn-success btn-sm" title="Add Attendance">
                                                        <i class="fas fa-user-check"></i>
                                                    </a>
                                                    ${isAttendancePunched ? `
                                                    <button type="button" class="btn btn-primary btn-sm edit-btn"
                                                        data-employee-id="${user_data.Employee_id}"
                                                        data-in-time-id="${user_data.in_time_id}"
                                                        data-out-time-id="${user_data.out_time_id}"
                                                        title="Edit Attendance">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    ` : ''}
                                                </div>
                                            </td>
                                        </tr>`;
                                });

                    table_html_data += `</tbody></table>`;
                    $("#result").html(table_html_data);

                    // Handle edit button clicks
                    $('.edit-btn').on('click', function() {
                        var employeeId = $(this).data('employee-id');
                        var inTimeId = $(this).data('in-time-id');
                        var outTimeId = $(this).data('out-time-id');
                        openAttendanceModal(employeeId, '1', inTimeId, outTimeId);
                    });

                    // Build pagination
                    var pajination_data = response.attendance_data.links;
                    var pagination_html = '<ul class="pagination">';

                    pajination_data.forEach(element => {
                        pagination_html += `<li class="page-item ${element.active ? 'active' : ''}">`;
                        pagination_html += `<a class="page-link" href="#" data-page="${element.url}">${element.label}</a>`;
                        pagination_html += `</li>`;
                    });

                    pagination_html += `</ul>
                        <div>
                            <span class="text-muted">Page Size: ${response.attendance_data.per_page}</span> |
                            <span class="text-muted">Total Records: ${response.attendance_data.total}</span>
                        </div>`;

                    $("#pagination_div").html(pagination_html);

                    // Initialize DataTables for sorting
                    $('#attendance_table').DataTable({
                        "paging": false,
                        "searching": false,
                        "info": false
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    $("#result").html('<div class="alert alert-danger">Failed to load data</div>');
                }
            });
        }

        // Function to open attendance edit modal
        function openAttendanceModal(employeeId, date, inTimeId, outTimeId) {
            // Show loading in modal body
            $("#pup_up_form_inner_div").html('<div class="text-center py-4"><i class="fas fa-spinner fa-spin fa-2x"></i><p class="mt-2">Loading...</p></div>');

            // Show the modal
            $("#updateAttendanceModal").modal('show');

            $.ajax({
                url: "{{ url('/get-attandence-single-data-api/') }}/" + employeeId + "/" + date,
                type: "GET",
                dataType: "json",
                headers: {
                    "Content-Type": "application/json"
                },
                success: function(response) {
                    if (response.status == 'true') {
                        var form_html = `
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>In Time</label>
                                        <input type="time" class="form-control" name="in_time" value="${response.data[0].in_time.substring(0, 5)}">
                                        <input type="hidden" name="Employee_id" value="${response.Employee_id}">
                                        <input type="hidden" name="in_time_id" value="${inTimeId}">
                                        <input type="hidden" name="out_time_id" value="${outTimeId}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Out Time</label>
                                        <input type="time" class="form-control" name="out_time" value="${response.data[0].out_time.substring(0, 5)}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Attendance Date</label>
                                        <input type="date" class="form-control" readonly name="attendance_date" value="${response.data[0].attandence_Date}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option value="">Select Status</option>
                                            <option value="present" ${response.data[0].status === 'present' ? 'selected' : ''}>Present</option>
                                            <option value="absent" ${response.data[0].status === 'absent' ? 'selected' : ''}>Absent</option>
                                        </select>
                                    </div>
                                </div>
                            </div>`;

                        $("#pup_up_form_inner_div").html(form_html);
                    } else {
                        $("#updateAttendanceModal").modal('hide');
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: "You Can't Update This User"
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    $("#updateAttendanceModal").modal('hide');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to fetch attendance data'
                    });
                }
            });
        }

        // Export functions (kept the same since they're essential functionality)
        function exportTableToExcel() {
            // Excel export logic here
            var wb = XLSX.utils.table_to_book(document.getElementById('attendance_table'));
            XLSX.writeFile(wb, 'attendance_data.xlsx');
        }

        function exportTableToPDF() {
            // PDF export logic here
            const doc = new jsPDF();
            doc.autoTable({ html: '#attendance_table' });
            doc.save('attendance_data.pdf');
        }

        function printTable() {
            // Print logic
            var printContents = document.getElementById('result').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>
@stop

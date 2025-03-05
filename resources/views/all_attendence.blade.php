@extends('adminlte::page')

@section('title', 'Attendance List')

@section('content_header')
    <h1>Attendance List</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
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
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            Column visibility
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" data-column="0">Name</a></li>
                            <li><a class="dropdown-item" href="#" data-column="1">Employee ID</a></li>
                            <li><a class="dropdown-item" href="#" data-column="2">Attendance Time</a></li>
                            <li><a class="dropdown-item" href="#" data-column="3">Attendance Date</a></li>
                        </ul>
                    </div>
                </div>
                <div>
                    <button type="button" class="btn btn-danger" id="bulk-delete-btn">
                        <i class="fas fa-trash"></i> Bulk Delete
                    </button>
                    <button type="button" class="btn btn-primary" id="generate-attendance-btn">
                        <i class="fas fa-gears"></i> Generate Attendance
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-9">
                    <div class="form-group">
                        <label>Show
                            <select id="entries-select" class="form-control form-control-sm d-inline-block w-auto ml-1">
                                <option value="10" selected>10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            entries
                        </label>
                    </div>
                </div>
                <div class="col-md-3 d-flex justify-content-end">
                    <form action="{{ route('search_attendence') }}" method="post" class="form-inline">
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
            </div>


            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="attendance-table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all-checkbox"></th>
                            <th class="sortable" data-column="name">Name</th>
                            <th class="sortable" data-column="Employee_id">Employee ID</th>
                            <th class="sortable" data-column="attendance_time">Attendance Time</th>
                            <th class="sortable" data-column="attendance_Date">Attendance Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="result">
                        <!-- Data will be loaded here -->
                    </tbody>
                </table>
            </div>

            <div class="row">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info" id="pagination-info">
                        <!-- Pagination info will be shown here -->
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers" id="pagination_div">
                        <!-- Pagination will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Generate Attendance Modal -->
    <div class="modal fade" id="generate-attendance-modal" tabindex="-1" role="dialog" aria-labelledby="generateAttendanceModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="generateAttendanceModalLabel">Generate Attendance</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="generateAttendanceForm">
                        <div class="form-group">
                            <label for="from-date">From Date</label>
                            <input type="date" class="form-control" id="from-date" name="from_date">
                        </div>
                        <div class="form-group">
                            <label for="to-date">To Date</label>
                            <input type="date" class="form-control" id="to-date" name="to_date">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="generate-btn">Generate</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Preview Modal -->
    <div class="modal fade" id="attendancePreviewModal" tabindex="-1" role="dialog" aria-labelledby="attendancePreviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Attendance Preview</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 600px; overflow-y: auto;">
                    <table class="table table-bordered table-striped text-center">
                        <thead class="thead-dark">
                            <tr>
                                <th>Date</th>
                                <th>Employee ID</th>
                                <th>Employee Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="attendancePreviewBody">
                            <!-- Attendance Data Will Be Inserted Here Dynamically -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="downloadAttendancePDF">
                        <i class="fas fa-file-pdf"></i> Download PDF
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>




    <!-- Edit Attendance Modal -->
    <div class="modal fade" id="edit-attendance-modal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Attendance</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="updateAttendanceForm">
              @csrf
              <div class="modal-body">
                <div id="Attendance_edit_div">
                  <!-- Attendance details will be loaded here -->
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
              </div>
            </form>
          </div>
        </div>
      </div>

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    // Variables for pagination and sorting
    var limit = 10;
    var inp = "";
    var page = 1;
    var sortColumn = "";
    var sortDirection = "asc";

    $(function() {
        // Initial page load
        lode_data();

        // Search input keyup
        $("#search_input").on("keyup", function() {
            inp = $(this).val();
            page = 1; // Reset to first page when searching
            lode_data();
        });

        // Change number of entries
        $("#entries-select").on("change", function() {
            limit = $(this).val();
            page = 1; // Reset to first page when changing limit
            lode_data();
        });

        // Column sorting
        $(".sortable").on("click", function() {
            sortColumn = $(this).data("column");
            sortDirection = sortDirection === "asc" ? "desc" : "asc";
            lode_data();
        });

        // Select all checkboxes
        $("#select-all-checkbox").on("click", function() {
            $(".checkbox_ids").prop("checked", $(this).prop("checked"));
        });

        // Generate Attendance button
        $("#generate-attendance-btn").on("click", function() {
            $("#generate-attendance-modal").modal("show");
        });

        $(document).ready(function () {
            $("#generate-btn").on("click", function (event) {
                event.preventDefault(); // Prevent default action

                const employeeIDs = [1,2,3,4,5,6,7,8,9,10,11,12,14,15,16,17,18,19,20];
                var from_date = $("#from-date").val();
                var to_date = $("#to-date").val();

                if (!from_date || !to_date) {
                    Swal.fire("Error", "Please provide both 'From Date' and 'To Date'.", "error");
                    return;
                }

                var startDate = new Date(from_date);
                var endDate = new Date(to_date);

                if (startDate > endDate) {
                    Swal.fire("Error", "'From Date' cannot be later than 'To Date'.", "error");
                    return;
                }

                $("#generate-attendance-modal").modal("hide");

                Swal.fire({
                    title: "Generating Attendance",
                    text: "Please wait while the attendance data is being generated...",
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                let attendanceData = []; // Store attendance results

                function sendAjaxForDateAndEmployee(currentDate, employeeIndex) {
                    if (currentDate > endDate) {
                        if (employeeIndex >= employeeIDs.length - 1) {
                            Swal.close(); // Close loading message
                            showAttendancePreview(attendanceData); // Show the modal
                            return;
                        }

                        currentDate = new Date(from_date);
                        employeeIndex++;
                    }

                    var formattedDate = currentDate.toISOString().split('T')[0];
                    var employeeID = employeeIDs[employeeIndex];

                    $.ajax({
                        url: `{{url('genrate-attandance')}}/${formattedDate}/${formattedDate}/${employeeID}`,
                        type: "GET",
                        data: {
                            employeeID: employeeID,
                            _token: '{{csrf_token()}}'
                        },
                        success: function (response) {
                            attendanceData.push({
                                date: formattedDate,
                                employee_id: employeeID,
                                employee_name: "Employee " + employeeID,
                                status: response.status ? "Present" : "Absent"
                            });

                            currentDate.setDate(currentDate.getDate() + 1);
                            sendAjaxForDateAndEmployee(currentDate, employeeIndex);
                        },
                        error: function (xhr, status, error) {
                            attendanceData.push({
                                date: formattedDate,
                                employee_id: employeeID,
                                employee_name: "Employee " + employeeID,
                                status: "Error"
                            });

                            currentDate.setDate(currentDate.getDate() + 1);
                            sendAjaxForDateAndEmployee(currentDate, employeeIndex);
                        }
                    });
                }

                sendAjaxForDateAndEmployee(startDate, 0);
            });


            function showAttendancePreview(data) {
                let tbody = $("#attendancePreviewBody");
                tbody.empty(); // Clear previous data

                if (data.length === 0) {
                    tbody.append('<tr><td colspan="4">No attendance data available.</td></tr>');
                } else {
                    data.forEach(item => {
                        let row = `
                            <tr>
                                <td>${item.date}</td>
                                <td>${item.employee_id}</td>
                                <td>${item.employee_name}</td>
                                <td>${item.status}</td>
                            </tr>
                        `;
                        tbody.append(row);
                    });
                }

                $("#attendancePreviewModal").modal("show"); // Show modal
            }


            // Function to download the attendance data as a PDF
            $("#downloadAttendancePDF").on("click", function () {
                let fromDate = $("#from-date").val();
                let toDate = $("#to-date").val();

                if (!fromDate || !toDate) {
                    Swal.fire("Error", "Missing date range. Please regenerate attendance.", "error");
                    return;
                }

                let pdfFileName = `Attendance_${fromDate}_to_${toDate}.pdf`;

                let doc = new jsPDF('p', 'mm', 'a4');
                doc.setFont("helvetica", "bold");
                doc.setFontSize(16);
                doc.text("Attendance Report", 105, 15, null, null, "center");

                doc.setFont("helvetica", "normal");
                doc.setFontSize(12);
                doc.text(`From: ${fromDate}  To: ${toDate}`, 105, 25, null, null, "center");

                let tableData = [];
                $("#attendancePreviewBody tr").each(function () {
                    let row = [];
                    $(this).find("td").each(function () {
                        row.push($(this).text().trim());
                    });
                    tableData.push(row);
                });

                doc.autoTable({
                    head: [["Date", "Employee ID", "Employee Name", "Status"]],
                    body: tableData,
                    startY: 30,
                    theme: "grid",
                    styles: { fontSize: 10 },
                    headStyles: { fillColor: [40, 40, 40] },
                    margin: { top: 30 },
                });

                doc.save(pdfFileName);
            });



        });


        // Bulk Delete button
        $("#bulk-delete-btn").on("click", function() {
            var selectedIds = [];
            $(".checkbox_ids:checked").each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) {
                alert("Please select at least one record to delete");
                return;
            }

            if (confirm("Are you sure you want to delete the selected records?")) {
                $.ajax({
                    url: "{{url('/bulk-delete-attendance')}}",
                    type: "POST",
                    data: {
                        ids: selectedIds
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            alert("Records deleted successfully");
                            lode_data();
                        } else {
                            alert("Failed to delete records");
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert("An error occurred");
                    }
                });
            }
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

        // Column visibility
        $(".dropdown-item").on("click", function(e) {
            e.preventDefault();
            var column = $(this).data("column");
            // Toggle column visibility
            $("table").find("tr").each(function() {
                $(this).find("th:eq(" + (parseInt(column) + 1) + "), td:eq(" + (parseInt(column) + 1) + ")").toggle();
            });
        });

        // Form submission handler
        // $(document).on('submit', '#updateAttendanceForm', function (e) {
        //     e.preventDefault();

        //     var formData = $(this).serialize();

        //     $.ajax({
        //         url: '{{URL("/update-attendance")}}',
        //         type: 'POST',
        //         data: formData,
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         success: function (response) {
        //             if (response.success) {
        //                 alert(response.message);
        //                 $('#edit-attendance-modal').modal('hide');
        //                 lode_data();
        //             } else {
        //                 alert('Failed to update attendance.');
        //             }
        //         },
        //         error: function (xhr) {
        //             console.error(xhr.responseText);
        //             alert('An error occurred while updating attendance.');
        //         }
        //     });
        // });
    });

    // Load initial data
    function lode_data() {
        var url = "{{url('/all-attandence-api')}}/" + limit;

        if (inp) {
            url = "{{url('/all-attandence-search-api')}}/" + limit + "/" + inp;
        }

        if (sortColumn) {
            url = "{{url('/all-attandence-short-api')}}/" + limit + "/" + sortColumn + "/" + sortDirection;
        }

        attendance_data_set(url);
    }

    // Main function to fetch and display attendance data
    function attendance_data_set(url_input) {
        // Show loading spinner
        $("#result").html('<tr><td colspan="5" class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</td></tr>');

        $.ajax({
            url: url_input,
            type: "GET",
            dataType: "json",
            headers: {
                "Content-Type": "application/json"
            },
            success: function(response) {
                console.log("Full Response:", response); // Log the entire response
                console.log("Attendance Data:", response.attandence_data); // Check attendance data structure

                let all_attendance = response.attandence_data.data;
                console.log("All Attendance Records:", all_attendance); // Log all records

                $("#result").empty();
                let table_html_data = '';

                if (all_attendance && all_attendance.length > 0) {
                    all_attendance.forEach(attendance => {
                        table_html_data += `
                            <tr>
                                <td><input type="checkbox" class="checkbox_ids" value="${attendance.id}"></td>
                                <td>${(attendance.f_name || '') + ' ' + (attendance.m_name || '') + ' ' + (attendance.l_name || '')}</td>
                                <td>${attendance.Employee_id}</td>
                                <td>${attendance.attendance_time}</td>
                                <td>${attendance.attendance_Date}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-btn" onclick="open_att_form(${attendance.id})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    table_html_data = '<tr><td colspan="5" class="text-center">No attendance records found</td></tr>';
                }

                $("#result").html(table_html_data);

                // Pagination
                var pajination_data = response.attandence_data.links;
                var pagination_html = '<ul class="pagination">';

                if (pajination_data && pajination_data.length > 0) {
                    // Previous button
                    pagination_html += `
                        <li class="paginate_button page-item previous ${!pajination_data[0].url ? 'disabled' : ''}">
                            <a href="#" class="page-link" data-page="${pajination_data[0].url}" aria-label="Previous">
                                <span aria-hidden="true">Previous</span>
                            </a>
                        </li>
                    `;

                    // Page numbers
                    for (var i = 1; i < pajination_data.length - 1; i++) {
                        pagination_html += `
                            <li class="paginate_button page-item ${pajination_data[i].active ? 'active' : ''}">
                                <a href="#" class="page-link" data-page="${pajination_data[i].url}">${pajination_data[i].label}</a>
                            </li>
                        `;
                    }

                    // Next button
                    pagination_html += `
                        <li class="paginate_button page-item next ${!pajination_data[pajination_data.length - 1].url ? 'disabled' : ''}">
                            <a href="#" class="page-link" data-page="${pajination_data[pajination_data.length - 1].url}" aria-label="Next">
                                <span aria-hidden="true">Next</span>
                            </a>
                        </li>
                    `;
                }

                pagination_html += '</ul>';
                $("#pagination_div").html(pagination_html);

                // Pagination info
                var from = (response.attandence_data.current_page - 1) * response.attandence_data.per_page + 1;
                var to = from + response.attandence_data.data.length - 1;
                var total = response.attandence_data.total;

                $("#pagination-info").html(`Showing ${from} to ${to} of ${total} entries`);

                // Attach click event to pagination links
                $('.page-link').on('click', function(e) {
                    e.preventDefault();
                    var pageUrl = $(this).data('page');
                    if (pageUrl) {
                        attendance_data_set(pageUrl);
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                $("#result").html('<tr><td colspan="5" class="text-center">Error loading data. Please try again.</td></tr>');
            }
        });
    }

    // Open attendance edit form
    function open_att_form(id) {
    $('#edit-attendance-modal').modal('show'); // Show AdminLTE modal
    $('#Attendance_edit_div').empty().html('<p class="text-center text-info">Loading...</p>'); // Show loading text

    $.ajax({
        url: '{{ url("/edit-attendance") }}/' + id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log('Success:', response);
            var emp_data = response.emp_type_Data;

            if (emp_data && emp_data.length > 0) {
                var attendance = emp_data[0];

                // Format Full Name (Avoid extra spaces)
                var fullName = [attendance.f_name, attendance.m_name, attendance.l_name].filter(Boolean).join(' ');

                var edit_form_data = `
                    <form id="updateAttendanceForm">
                        <input type="hidden" name="attendance_id" value="${attendance.id}">

                        <div class="form-group">
                            <label>Employee ID:</label>
                            <input type="text" class="form-control" value="${attendance.Employee_id}" disabled>
                        </div>

                        <div class="form-group">
                            <label>Employee Name:</label>
                            <input type="text" class="form-control" value="${fullName}" disabled>
                        </div>

                        <div class="form-group">
                            <label>Attendance Date:</label>
                            <input type="date" name="attendance_date" class="form-control" value="${attendance.attendance_Date}">
                        </div>

                        <div class="form-group">
                            <label>Attendance Time:</label>
                            <input type="time" name="attendance_time" class="form-control" value="${attendance.attendance_time}">
                        </div>
                    </form>
                `;

                $('#Attendance_edit_div').empty().html(edit_form_data); // Clear before adding new content
            } else {
                $('#Attendance_edit_div').empty().html('<p class="text-danger">No data found</p>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            $('#Attendance_edit_div').empty().html('<p class="text-danger">Error loading data. Please try again.</p>');
        }
    });
}


    $(document).on('submit', '#updateAttendanceForm', function (e) {
        e.preventDefault(); // Prevent default form submission

        var formData = $(this).serialize(); // Serialize form data

        $.ajax({
            url: '{{ url("/update-attendance") }}', // Laravel update route
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF Token
            },
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    $('#edit-attendance-modal').modal('hide'); // Close modal
                    location.reload(); // Refresh page to see updated data
                } else {
                    alert('Failed to update attendance.');
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('An error occurred while updating attendance.');
            }
        });
    });


</script>
@endsection

@section('css')
<style>
    .sortable {
        cursor: pointer;
    }

    .sortable:hover {
        background-color: #f5f5f5;
    }

    .edit-btn {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
    }

    /* Make the pagination look like in the screenshot */
    .pagination {
        justify-content: flex-end;
    }

    #pagination-info {
        margin-top: 0.5rem;
    }

    /* Style for the table */
    .table th {
        background-color: #f4f6f9;
    }
</style>
@endsection

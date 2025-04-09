@extends('adminlte::page')

@section('title', 'Employee Management')

@section('content_header')
    <h1>Employee Management</h1>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap4.min.css">
    <style>
        .action-btns {
            display: flex;
            gap: 10px;
        }
        .action-btns a {
            font-size: 16px;
        }
        .dt-buttons .btn {
            margin-right: 5px;
        }
        #bulk-upload-modal .modal-body {
            padding: 20px;
        }
        .btn-action {
            margin-right: 5px;
        }
        #employee-view-modal .modal-body {
            max-height: 70vh;
            overflow-y: auto;
        }
        #employee-view-modal .employee-info {
            margin-bottom: 15px;
        }
        #employee-view-modal .info-label {
            font-weight: bold;
        }
        .cursor-pointer {
            cursor: pointer;
        }
    </style>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
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
            <div class="btn-group">
                <button type="button" class="btn btn-primary btn-action" id="download-selected">
                    <i class="fas fa-download"></i> Download ID Cards
                </button>
                <a href="{{ url('/registration') }}" class="btn btn-success btn-action">
                    <i class="fas fa-plus"></i> Add New
                </a>
                <button type="button" class="btn btn-info btn-action" data-toggle="modal" data-target="#bulk-upload-modal">
                    <i class="fas fa-upload"></i> Bulk Upload
                </button>
                <button type="button" class="btn btn-danger btn-action" id="bulk-delete">
                    <i class="fas fa-trash"></i> Bulk Delete
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="employees-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>Name</th>
                        <th>Employee ID</th>
                        <th>Mobile Number</th>
                        <th>Email Id</th>
                        <th>Aadhar Number</th>
                        <th>Pan Number</th>
                        <th>Date of birth</th>
                        <th>Current Address</th>
                        <th>Permanent Address</th>
                        <th>Gender</th>
                        <th>Marital Status</th>
                        <th>DOJ</th>
                        <th>Highest Qualification</th>
                        <th>Salary</th>
                        <th>Shift Time</th>
                        <th>Employee Type</th>
                        <th>Role</th>
                        <th>Weekly Off</th>
                        <th>Department</th>
                        <th>Gate Off</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be loaded via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bulk Upload Modal -->
<div class="modal fade" id="bulk-upload-modal" tabindex="-1" role="dialog" aria-labelledby="bulkUploadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkUploadModalLabel">Import Users</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('bulk_uoploade_request') }}" method="POST" enctype="multipart/form-data" id="bulk-upload-form">
                    @csrf
                    <div class="form-group">
                        <label>Select CSV File</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="csv_file" accept=".csv" required id="csv-file">
                            <label class="custom-file-label" for="csv-file">Choose file</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <a href="{{ url('/sample.csv') }}" class="btn btn-success btn-block">
                            <i class="fas fa-download"></i> Download XLS Format
                        </a>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Employee View Modal -->
<div class="modal fade" id="employee-view-modal" tabindex="-1" role="dialog" aria-labelledby="employeeViewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="employeeViewModalLabel">Employee Details</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div class="spinner-border text-primary" role="status" id="employee-loading">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div id="employee-details" class="row" style="display: none;">
                    <!-- Personal Information -->
                    <div class="col-md-12 mb-3">
                        <h4 class="border-bottom pb-2">Personal Information</h4>
                    </div>
                    <div class="col-md-6 employee-info">
                        <div class="info-label">Name:</div>
                        <div id="employee-name"></div>
                    </div>
                    <div class="col-md-6 employee-info">
                        <div class="info-label">Employee ID:</div>
                        <div id="employee-id"></div>
                    </div>
                    <div class="col-md-6 employee-info">
                        <div class="info-label">Date of Birth:</div>
                        <div id="employee-dob"></div>
                    </div>
                    <div class="col-md-6 employee-info">
                        <div class="info-label">Gender:</div>
                        <div id="employee-gender"></div>
                    </div>
                    <div class="col-md-6 employee-info">
                        <div class="info-label">Marital Status:</div>
                        <div id="employee-marital-status"></div>
                    </div>

                    <!-- Contact Information -->
                    <div class="col-md-12 mt-3 mb-3">
                        <h4 class="border-bottom pb-2">Contact Information</h4>
                    </div>
                    <div class="col-md-6 employee-info">
                        <div class="info-label">Mobile Number:</div>
                        <div id="employee-mobile"></div>
                    </div>
                    <div class="col-md-6 employee-info">
                        <div class="info-label">Email:</div>
                        <div id="employee-email"></div>
                    </div>
                    <div class="col-md-6 employee-info">
                        <div class="info-label">Current Address:</div>
                        <div id="employee-current-address"></div>
                    </div>
                    <div class="col-md-6 employee-info">
                        <div class="info-label">Permanent Address:</div>
                        <div id="employee-permanent-address"></div>
                    </div>

                    <!-- Official Information -->
                    <div class="col-md-12 mt-3 mb-3">
                        <h4 class="border-bottom pb-2">Official Information</h4>
                    </div>
                    <div class="col-md-6 employee-info">
                        <div class="info-label">Department:</div>
                        <div id="employee-department"></div>
                    </div>
                    <div class="col-md-6 employee-info">
                        <div class="info-label">Role:</div>
                        <div id="employee-role"></div>
                    </div>
                    <div class="col-md-6 employee-info">
                        <div class="info-label">Date of Joining:</div>
                        <div id="employee-doj"></div>
                    </div>
                    <div class="col-md-6 employee-info">
                        <div class="info-label">Salary:</div>
                        <div id="employee-salary"></div>
                    </div>
                    <div class="col-md-6 employee-info">
                        <div class="info-label">Employee Type:</div>
                        <div id="employee-type"></div>
                    </div>
                    <div class="col-md-6 employee-info">
                        <div class="info-label">Shift Time:</div>
                        <div id="employee-shift"></div>
                    </div>
                    <div class="col-md-6 employee-info">
                        <div class="info-label">Weekly Off:</div>
                        <div id="employee-weekly-off"></div>
                    </div>
                    <div class="col-md-6 employee-info">
                        <div class="info-label">Gate Off:</div>
                        <div id="employee-gate-off"></div>
                    </div>

                    <!-- Legal Information -->
                    <div class="col-md-12 mt-3 mb-3">
                        <h4 class="border-bottom pb-2">Legal Information</h4>
                    </div>
                    <div class="col-md-6 employee-info">
                        <div class="info-label">Aadhaar Number:</div>
                        <div id="employee-aadhaar"></div>
                    </div>
                    <div class="col-md-6 employee-info">
                        <div class="info-label">PAN Number:</div>
                        <div id="employee-pan"></div>
                    </div>

                    <!-- Education -->
                    <div class="col-md-12 mt-3 mb-3">
                        <h4 class="border-bottom pb-2">Education</h4>
                    </div>
                    <div class="col-md-6 employee-info">
                        <div class="info-label">Highest Qualification:</div>
                        <div id="employee-qualification"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="#" class="btn btn-warning" id="edit-employee-btn">
                    <i class="fas fa-pencil-alt"></i> Edit
                </a>
                <a href="#" class="btn btn-success" id="download-id-card-btn">
                    <i class="fas fa-download"></i> Download ID Card
                </a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="punchCardModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Punch Card</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <!-- Punch card content will be dynamically inserted here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="downloadModalPunchCard()">Download</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>
<script>
    $(function() {
        // Initialize DataTable
        var table = $('#employees-table').DataTable({
            processing: true,
            ajax: {
                url: "{{ url('/all-employees-api') }}/" + 50, // Default limit of 50
                type: "GET",
                dataSrc: function(response) {
                    // Transform the API response to DataTables format
                    var role_number = $("#role_number").val() || 0;
                    var data = [];

                    if (response.all_users && response.all_users.data) {
                        response.all_users.data.forEach(function(user) {
                            if (user.role >= role_number) {
                                // Create the checkbox cell
                                var checkboxCell = '<input type="checkbox" class="employee-checkbox" value="' + user.id + '">';

                                // Create the name cell by combining first, middle and last name
                                var nameCell = user.f_name + ' ' + (user.m_name || '') + ' ' + (user.l_name || '');

                                // Create the actions cell with view opening modal
                                var actionsCell = '<div class="action-btns">' +
                                    '<a href="javascript:void(0);" class="text-primary view-employee cursor-pointer" data-id="' + user.id + '" title="View">' +
                                    '<i class="fas fa-eye"></i></a> ' +
                                    '<a href="user-details/' + user.id + '" class="text-warning" title="Edit">' +
                                    '<i class="fas fa-pencil-alt"></i></a> ' +
                                    '<a href="dounloade-user-id-catd/' + user.id + '" class="text-success" title="Download ID Card">' +
                                    '<i class="fas fa-download"></i></a>' +
                                    '</div>';

                                // Push the formatted row data
                                data.push({
                                    checkbox: checkboxCell,
                                    name: nameCell,
                                    Employee_id: user.Employee_id,
                                    mobile_number: user.mobile_number,
                                    email: user.email,
                                    aadhaar_number: user.aadhaar_number,
                                    pan_number: user.pan_number,
                                    dob: user.dob,
                                    current_address: user.current_address,
                                    permanent_address: user.permanent_address,
                                    gender: user.gender,
                                    marital_status: user.marital_status,
                                    DOJ: user.DOJ,
                                    highest_qualification: user.highest_qualification,
                                    salary: user.salary,
                                    Shift_Name: user.Shift_Name,
                                    EmpTypeName: user.EmpTypeName,
                                    roles: user.roles,
                                    Weekly_Off: user.Weekly_Off,
                                    Department_name: user.Department_name,
                                    Gate_Off: user.Gate_Off,
                                    actions: actionsCell,
                                    userData: user
                                });
                            }
                        });
                    }

                    console.log("Processed data for DataTable:", data);
                    return data;
                }
            },
            columns: [
                {data: 'checkbox', orderable: false, searchable: false},
                {data: 'name'},
                {data: 'Employee_id'},
                {data: 'mobile_number'},
                {data: 'email'},
                {data: 'aadhaar_number'},
                {data: 'pan_number'},
                {data: 'dob'},
                {data: 'current_address'},
                {data: 'permanent_address'},
                {data: 'gender'},
                {data: 'marital_status'},
                {data: 'DOJ'},
                {data: 'highest_qualification'},
                {data: 'salary', render: function(data) {
                    return '₹' + data;
                }},
                {data: 'Shift_Name'},
                {data: 'EmpTypeName'},
                {data: 'roles'},
                {data: 'Weekly_Off'},
                {data: 'Department_name'},
                {data: 'Gate_Off'},
                {data: 'actions', orderable: false, searchable: false}
            ],
            dom: 'lBfrtip',
            buttons: [
                'colvis',
            ],
            order: [[1, 'asc']],
            responsive: true,
            autoWidth: false,
            scrollX: true,
            scrollCollapse: true,
            fixedHeader: true,
            pagingType: 'full_numbers',
            language: {
                paginate: {
                    previous: 'Previous',
                    next: 'Next'
                }
            }
        });

        // Handle view employee click (open modal)
        $('#employees-table').on('click', '.view-employee', function() {
            var employeeId = $(this).data('id');
            var tableData = table.rows().data().toArray();
            var employeeData = null;

            // Find the employee data from our DataTable
            for (var i = 0; i < tableData.length; i++) {
                if (tableData[i].userData && tableData[i].userData.id == employeeId) {
                    employeeData = tableData[i].userData;
                    break;
                }
            }

            // Show loading spinner
            $('#employee-loading').show();
            $('#employee-details').hide();

            if (employeeData) {
                populateEmployeeModal(employeeData);
            } else {
                // Fallback to AJAX call if we don't have the data
                $.ajax({
                    url: "{{ url('/get-employee-details') }}/" + employeeId,
                    type: "GET",
                    success: function(response) {
                        populateEmployeeModal(response.employee);
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to load employee details.'
                        });
                        $('#employee-loading').hide();
                    }
                });
            }

            // Set the edit and download buttons
            $('#edit-employee-btn').attr('href', 'user-details/' + employeeId);
            // $('#download-id-card-btn').attr('href', 'dounloade-user-id-catd/' + employeeId);

            // Show the modal
            $('#employee-view-modal').modal('show');
        });

        // Function to populate employee modal with data
        function populateEmployeeModal(employee) {
            // Populate all fields
            $('#employee-name').text((employee.f_name || '') + ' ' + (employee.m_name || '') + ' ' + (employee.l_name || ''));
            $('#employee-id').text(employee.Employee_id || '');
            $('#employee-dob').text(employee.dob || '');
            $('#employee-gender').text(employee.gender || '');
            $('#employee-marital-status').text(employee.marital_status || '');
            $('#employee-mobile').text(employee.mobile_number || '');
            $('#employee-email').text(employee.email || '');
            $('#employee-current-address').text(employee.current_address || '');
            $('#employee-permanent-address').text(employee.permanent_address || '');
            $('#employee-department').text(employee.Department_name || '');
            $('#employee-role').text(employee.roles || '');
            $('#employee-doj').text(employee.DOJ || '');
            $('#employee-salary').text('₹' + (employee.salary || ''));
            $('#employee-type').text(employee.EmpTypeName || '');
            $('#employee-shift').text(employee.Shift_Name || '');
            $('#employee-weekly-off').text(employee.Weekly_Off || '');
            $('#employee-gate-off').text(employee.Gate_Off || '');
            $('#employee-aadhaar').text(employee.aadhaar_number || '');
            $('#employee-pan').text(employee.pan_number || '');
            $('#employee-qualification').text(employee.highest_qualification || '');

            // Hide loading, show details
            $('#employee-loading').hide();
            $('#employee-details').show();
        }

        // Add CSS to ensure proper styling and fixed headers
        $('head').append(`
            <style>
                /* Fixed header and navigation styles */
                .dataTables_wrapper {
                    position: relative;
                }

                .dataTables_scrollHead {
                    position: sticky !important;
                    top: 0;
                    z-index: 10;
                    background-color: #fff;
                    box-shadow: 0 2px 4px rgba(0,0,0,.1);
                }

                .dataTables_paginate {
                    float: right !important;
                    margin-top: 10px !important;
                }

                .dataTables_info {
                    padding-top: 10px !important;
                }

                .pagination {
                    justify-content: flex-end !important;
                }

                /* Table navigation controls */
                .table-nav-controls {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 10px;
                    padding: 8px 0;
                    background-color: #f8f9fa;
                    border-radius: 4px;
                }

                .table-nav-controls button {
                    padding: 6px 12px;
                    margin: 0 5px;
                    background-color: #fff;
                    border: 1px solid #dee2e6;
                    border-radius: 4px;
                    cursor: pointer;
                }

                .table-nav-controls button:hover {
                    background-color: #e9ecef;
                }

                .table-nav-controls button:disabled {
                    opacity: 0.5;
                    cursor: not-allowed;
                }

                /* Responsive table container */
                .table-responsive {
                    position: relative;
                    overflow-x: hidden !important; /* Hide default horizontal scrollbar */
                }

                /* Visible columns indicator */
                .columns-indicator {
                    margin-left: 10px;
                    font-size: 0.9em;
                    color: #6c757d;
                }
            </style>
        `);

        // Add navigation buttons above the table
        var $tableContainer = $('#employees-table').closest('.table-responsive');
        $tableContainer.before(`
            <div class="table-nav-controls">
                <div>
                    <button id="prev-columns" disabled>Previous Columns</button>
                    <button id="next-columns">Next Columns</button>
                    <span class="columns-indicator">Showing columns 1-6 of 22</span>
                </div>
                <div>
                    <button id="show-essential">Essential Columns</button>
                    <button id="show-all">All Columns</button>
                </div>
            </div>
        `);

        // Set up column groups for navigation
        var visibleColumns = 6; // Number of columns to show at once
        var totalColumns = table.columns().nodes().length;
        var currentPosition = 0;

        // Update columns indicator
        function updateColumnsIndicator() {
            var start = currentPosition + 1;
            var end = Math.min(currentPosition + visibleColumns, totalColumns);
            $('.columns-indicator').text('Showing columns ' + start + '-' + end + ' of ' + totalColumns);

            // Enable/disable navigation buttons
            $('#prev-columns').prop('disabled', currentPosition === 0);
            $('#next-columns').prop('disabled', currentPosition + visibleColumns >= totalColumns);
        }

        // Navigate to previous columns
        $('#prev-columns').on('click', function() {
            if (currentPosition > 0) {
                currentPosition = Math.max(0, currentPosition - visibleColumns);
                navigateToColumn(currentPosition);
                updateColumnsIndicator();
            }
        });

        // Navigate to next columns
        $('#next-columns').on('click', function() {
            if (currentPosition + visibleColumns < totalColumns) {
                currentPosition = Math.min(totalColumns - visibleColumns, currentPosition + visibleColumns);
                navigateToColumn(currentPosition);
                updateColumnsIndicator();
            }
        });

        // Function to navigate to a specific column position
        function navigateToColumn(position) {
            // Get the DataTables scrolling wrapper
            var $scrollBody = $('.dataTables_scrollBody');

            // Calculate position to scroll to (column width * position)
            var columnWidth = $scrollBody.find('table').find('th').eq(position).outerWidth();
            var scrollPos = columnWidth * position;

            // Animate scroll to new position
            $scrollBody.animate({ scrollLeft: scrollPos }, 300);
        }

        // Show only essential columns
        $('#show-essential').on('click', function() {
            table.columns().visible(false);
            var essentialColumns = [0, 1, 2, 3, 4, 14, 19, 21]; // Checkbox, Name, ID, Mobile, Email, Salary, Department, Actions
            essentialColumns.forEach(function(colIdx) {
                table.column(colIdx).visible(true);
            });

            currentPosition = 0;
            updateColumnsIndicator();
        });

        // Show all columns
        $('#show-all').on('click', function() {
            table.columns().visible(true);
            updateColumnsIndicator();
        });

        // Handle select all checkbox
        $('#select-all').on('click', function() {
            $('.employee-checkbox').prop('checked', $(this).prop('checked'));
        });

        // Download selected ID cards
        $('#download-selected').on('click', function() {
            let selectedIds = [];
            $('.employee-checkbox:checked').each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length > 0) {
                window.location.href = "{{ url('dounloade-user-id-catd') }}/" + selectedIds.join(',');
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'No employees selected',
                    text: 'Please select at least one employee to download ID cards.'
                });
            }
        });

        // Bulk delete
        $('#bulk-delete').on('click', function() {
            let selectedIds = [];
            $('.employee-checkbox:checked').each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length > 0) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete them!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('delete_employee') }}",
                            type: "POST",
                            data: {
                                ids: selectedIds,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Deleted!',
                                    response.success,
                                    'success'
                                );
                                table.ajax.reload();
                            }
                        });
                    }
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'No employees selected',
                    text: 'Please select at least one employee to delete.'
                });
            }
        });

        // Show filename in custom file input
        $(document).on('change', '.custom-file-input', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

        $('#exportExcel').on('click', function() {
            table.button('.buttons-excel').trigger();
        });

        // Export to PDF button
        $('#exportPDF').on('click', function() {
            table.button('.buttons-pdf').trigger();
        });

        // Print table button
        $('#printTable').on('click', function() {
            table.button('.buttons-print').trigger();
        });
    });

    function openPunchCardModal(id) {
        // Find the specific punch card div
        var originalPunchCard = document.getElementById(id);

        // Clone the original punch card
        var punchCardContent = originalPunchCard.cloneNode(true);

        // Ensure the cloned content is visible
        punchCardContent.style.visibility = 'visible';

        // Clear previous content and add the cloned punch card
        var modalBody = document.querySelector('#punchCardModal .modal-body');
        modalBody.innerHTML = '';
        modalBody.appendChild(punchCardContent);

        // Regenerate QR code in the modal
        var originalQRCodeDiv = originalPunchCard.querySelector('[id^="qrcode"]');
        var modalQRCodeDiv = punchCardContent.querySelector('[id^="qrcode"]');

        if (originalQRCodeDiv && modalQRCodeDiv) {
            // Get the QR code text from the original div
            var qrCodeText = originalQRCodeDiv.getAttribute('data-qr-text');

            // Clear any existing QR code
            modalQRCodeDiv.innerHTML = '';

            // Regenerate QR code
            new QRCode(modalQRCodeDiv, {
                text: qrCodeText,
                width: 85,
                height: 85
            });
        }

        // Show the modal
        $('#punchCardModal').modal('show');
    }

    function downloadModalPunchCard() {
        var modalContent = document.querySelector('#punchCardModal .modal-body .id_inner_Div');

        html2canvas(modalContent, {
            scale: 2,
            useCORS: true
        }).then(function(canvas) {
            // Convert the canvas to a data URL
            var imgData = canvas.toDataURL('image/jpeg');

            // Create a temporary link to trigger the download
            var link = document.createElement('a');
            link.href = imgData;
            link.download = 'punch-card.jpg';
            link.click();
        }).catch(function(error) {
            console.error('Error downloading punch card:', error);
            alert('Failed to download punch card. Please try again.');
        });
    }

    // Modify existing HTML to prepare for modal
    document.addEventListener('DOMContentLoaded', function() {
        // Add data attribute for QR code text to each qr code div
        document.querySelectorAll('[id^="qrcode"]').forEach(function(qrCodeDiv) {
            var qrCodeText = qrCodeDiv.getAttribute('data-text') ||
                             qrCodeDiv.querySelector('img').getAttribute('src');
            qrCodeDiv.setAttribute('data-qr-text', qrCodeText);
        });

        // Update download buttons to use modal
        document.querySelectorAll('.downloade_btn').forEach(function(btn) {
            var punchCardDiv = btn.previousElementSibling;

            // Replace onclick with modal trigger
            btn.querySelector('button').setAttribute('onclick',
                'openPunchCardModal("' + punchCardDiv.id + '")');
        });
    });
</script>
@stop

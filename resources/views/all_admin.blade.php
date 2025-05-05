@extends('adminlte::page')

@section('title', 'User List')

@section('content_header')
    <h1>User List</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title">All Users</h3>
            <div class="card-tools">
                {{-- Buttons can be added here if needed
                <a href="{{ url('/registration') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Add New
                </a>
                <a href="{{ url('/bulk-uploade') }}" class="btn btn-info btn-sm">
                    <i class="fas fa-upload"></i> Bulk Upload
                </a>
                --}}
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="float-left btn-toolbar">
                    <div class="btn-group mr-2">
                        <button type="button" class="btn btn-info" onclick="exportTableToExcel()">
                            <i class="fas fa-file-excel"></i> Excel
                        </button>
                        <button type="button" class="btn btn-danger" onclick="exportTableToPDF()">
                            <i class="fas fa-file-pdf"></i> PDF
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="printTable()">
                            <i class="fas fa-print"></i> Print
                        </button>
                    </div>

                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            Column visibility <span class="caret"></span>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item active" href="#" onclick="show_hide_name()" id="Name_item">
                                <i class="fas fa-check"></i> Name
                            </a>
                            <a class="dropdown-item active" href="#" onclick="show_hide_Employee_ID()" id="Employee_ID_item">
                                <i class="fas fa-check"></i> Employee ID
                            </a>
                            <a class="dropdown-item active" href="#" onclick="show_hide_Mobile_Number()" id="Mobile_Number_item">
                                <i class="fas fa-check"></i> Mobile Number
                            </a>
                            <a class="dropdown-item active" href="#" onclick="show_hide_Aadhar_Number()" id="Aadhar_Number_item">
                                <i class="fas fa-check"></i> Role
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-2">
                <div class="input-group">
                    <input type="search" class="form-control" id="search_input" placeholder="Search by name & Email" autocomplete="off">
                    <div class="input-group-append">
                        {{-- <button type="button" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button> --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="id_of_table">
                <thead>
                    <tr>
                        <th width="5%">Sr.N.</th>
                        <th>Name</th>
                        <th>Employee ID</th>
                        <th>Mobile Number</th>
                        <th>Role</th>
                        <th>Gender</th>
                        <th>Total Permissions</th>
                        <th width="10%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = 1;
                    @endphp
                    @foreach($users as $user)
                    <tr id="employee_id{{ $user->id }}">
                        <td>{{ $count }}</td>
                        <td>{{ $user->f_name }} {{ $user->m_name }} {{ $user->l_name }}</td>
                        <td>{{ $user->Employee_id }}</td>
                        <td>{{ $user->mobile_number }}</td>
                        <td>{{ $user->roles }}</td>
                        <td>{{ $user->gender }}</td>
                        <td>{{ $user->roles }}</td>
                        <td>
                            <a href="edit-permissions/{{ $user->Employee_id }}" class="btn btn-sm btn-info">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        </td>
                    </tr>
                    @php
                        $count++;
                    @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop

@section('css')
    <style>
        .table-responsive {
            overflow-x: auto;
        }

        /* Custom styling for export buttons to match screenshot */
        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        /* Add hover effects */
        .btn:hover {
            opacity: 0.9;
        }

        /* Active search styling */
        #search_input:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        /* Style for highlighting search results */
        .highlight {
            background-color: yellow;
        }
    </style>
@stop

@section('js')
    <!-- Required libraries for export functionality -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

    <script>
        // Export table to Excel function with implementation
        function exportTableToExcel() {
            const table = document.getElementById("id_of_table");
            const fileName = "users_list.xlsx";

            /* Create a workbook */
            const wb = XLSX.utils.book_new();

            /* Convert table to worksheet */
            const ws = XLSX.utils.table_to_sheet(table);

            /* Add worksheet to workbook */
            XLSX.utils.book_append_sheet(wb, ws, "Users");

            /* Generate file and download */
            XLSX.writeFile(wb, fileName);
        }

        // Export table to PDF function with implementation
        function exportTableToPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            doc.text("Users List", 14, 15);

            // Create the PDF table
            doc.autoTable({
                html: '#id_of_table',
                startY: 20,
                theme: 'grid',
                styles: {
                    fontSize: 8
                },
                headStyles: {
                    fillColor: [66, 139, 202],
                    textColor: 255
                }
            });

            // Save the PDF
            doc.save('users_list.pdf');
        }

        // Print table function
        function printTable() {
            const printContents = document.getElementById("id_of_table").outerHTML;
            const originalContents = document.body.innerHTML;

            document.body.innerHTML = `
                <html>
                <head>
                    <title>Users List</title>
                    <style>
                        table { border-collapse: collapse; width: 100%; }
                        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                        th { background-color: #f2f2f2; }
                    </style>
                </head>
                <body>
                    <h2>Users List</h2>
                    ${printContents}
                </body>
                </html>
            `;

            window.print();
            document.body.innerHTML = originalContents;
        }

        // Column visibility toggle functions
        function show_hide_name() {
            let nameItem = document.getElementById("Name_item");
            nameItem.classList.toggle("active");

            // Toggle column visibility
            $("table th:nth-child(2), table td:nth-child(2)").toggle();

            // Update icon
            if (nameItem.classList.contains("active")) {
                $(nameItem).find("i").removeClass("fa-square").addClass("fa-check");
            } else {
                $(nameItem).find("i").removeClass("fa-check").addClass("fa-square");
            }
        }

        function show_hide_Employee_ID() {
            let idItem = document.getElementById("Employee_ID_item");
            idItem.classList.toggle("active");

            // Toggle column visibility
            $("table th:nth-child(3), table td:nth-child(3)").toggle();

            // Update icon
            if (idItem.classList.contains("active")) {
                $(idItem).find("i").removeClass("fa-square").addClass("fa-check");
            } else {
                $(idItem).find("i").removeClass("fa-check").addClass("fa-square");
            }
        }

        function show_hide_Mobile_Number() {
            let mobileItem = document.getElementById("Mobile_Number_item");
            mobileItem.classList.toggle("active");

            // Toggle column visibility
            $("table th:nth-child(4), table td:nth-child(4)").toggle();

            // Update icon
            if (mobileItem.classList.contains("active")) {
                $(mobileItem).find("i").removeClass("fa-square").addClass("fa-check");
            } else {
                $(mobileItem).find("i").removeClass("fa-check").addClass("fa-square");
            }
        }

        function show_hide_Aadhar_Number() {
            let roleItem = document.getElementById("Aadhar_Number_item");
            roleItem.classList.toggle("active");

            // Toggle column visibility
            $("table th:nth-child(5), table td:nth-child(5)").toggle();

            // Update icon
            if (roleItem.classList.contains("active")) {
                $(roleItem).find("i").removeClass("fa-square").addClass("fa-check");
            } else {
                $(roleItem).find("i").removeClass("fa-check").addClass("fa-square");
            }
        }

        $(document).ready(function() {
            // Live search functionality on keypress
            $("#search_input").on("keyup", function() {
                const value = $(this).val().toLowerCase();
                $("#id_of_table tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>
@stop

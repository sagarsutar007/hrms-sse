@extends('adminlte::page')

@section('title', 'Holiday List')

@section('content_header')
    <h1>Holiday List</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-inline-flex align-items-center ml-auto">
                <div class="mr-2">
                    <input type="month" id="month_input" class="form-control" onchange="set_month()">
                </div>
                <a href="{{url('/calendar')}}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="btn-group">
                    <button type="button" class="btn btn-default" onclick="exportTableToExcel()">
                        <i class="fas fa-file-excel"></i> Excel
                    </button>
                    <button type="button" class="btn btn-default" onclick="exportTableToPDF()">
                        <i class="fas fa-file-pdf"></i> PDF
                    </button>
                    <button type="button" class="btn btn-default" onclick="printTable()">
                        <i class="fas fa-print"></i> Print
                    </button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false" onclick="Togle_chose_item_div()">
                            Column visibility <span id="down_angle"></span>
                        </button>
                        <div class="dropdown-menu" id="show_hide_items_div" style="display: none;">
                            <a class="dropdown-item chose_item_active" href="javascript:void(0)" id="Name_item">Holiday Date</a>
                            <a class="dropdown-item chose_item_active" href="javascript:void(0)" id="Employee_ID_item">Swap with Date</a>
                            <a class="dropdown-item chose_item_active" href="javascript:void(0)" id="Mobile_Number_item">Holiday Name</a>
                            <a class="dropdown-item chose_item_active" href="javascript:void(0)" id="Aadhar_Number_item">Public Holiday</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="float-right d-flex">
                    <div class="mr-2">
                        <select id="length_select" class="form-control" onchange="changeLength()">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50" selected>50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <form action="{{route('search_attendence')}}" method="post" class="form-inline">
                        @csrf
                        <div class="input-group">
                            <input type="search" class="form-control" id="search_input" name="search_val" placeholder="Search by name & Email" required onkeyup="search_on_key_press()">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default" id="search_btn">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="result">
            <!-- Table data will be loaded here -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="pagination_div" class="d-flex justify-content-end"></div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this holiday?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <a href="#" id="confirmDelete" class="btn btn-danger">Delete</a>
      </div>
    </div>
  </div>
</div>
@stop

@section('js')
<script src="{{ URL('js/export.js')}}"></script>
<script>
    var limit = 50;
    var name_item_click_count = 1;
    var Employee_ID_item_click_count = 1;
    var Mobile_Number_item_click_count = 1;
    var Aadhar_Number_item_click_count = 1;

    $(document).ready(function () {
        // Set current month
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        $("#month_input").val(`${year}-${month}`);

        // Load initial data
        load_data();

        // Set up event listeners
        $("#Name_item").on("click", function() {
            show_hide_name();
        });

        $("#Employee_ID_item").on("click", function() {
            show_hide_Employee_ID();
        });

        $("#Mobile_Number_item").on("click", function() {
            show_hide_Mobile_Number();
        });

        $("#Aadhar_Number_item").on("click", function() {
            show_hide_Aadhar_Number();
        });

        // Event listener for pagination
        $('#pagination_div').on('click', '.page-btn', function() {
            var page = $(this).data('page');
            attendance_data_set(page);
        });

        // Event listener for search button
        $("#search_btn").on("click", function(event) {
            event.preventDefault();
            search_on_key_press();
        });

        // Event listener for delete buttons
        $(document).on('click', '.delete-btn', function() {
            let id = $(this).data('id');
            $('#confirmDelete').attr('href', 'delete-holiday/' + id);
        });
    });

    function changeLength() {
        limit = $("#length_select").val();
        var page_url = "{{url('/all-holiday-api')}}/"+limit;
        attendance_data_set(page_url);
    }

    function search_on_key_press() {
        var inp = $("#search_input").val();
        var page_url = "{{url('/all-holiday-search-api')}}/"+limit+ "/"+ inp;
        attendance_data_set(page_url);
    }

    function set_month() {
        var inp = $("#month_input").val();
        if (!inp) {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            $("#month_input").val(`${year}-${month}`);
            inp = $("#month_input").val();
        }
        var page_url = "{{url('/all-holiday-search-api')}}/"+limit+ "/"+ inp;
        attendance_data_set(page_url);
    }

    function sort_data(sort_by) {
        var method;
        if (sort_by === 'holiday_Date') {
            method = (name_item_click_count++ % 2 === 0) ? 'asc' : 'desc';
        } else if (sort_by === 'Swap_with_Date') {
            method = (Employee_ID_item_click_count++ % 2 === 0) ? 'asc' : 'desc';
        } else if (sort_by === 'Public_Holiday') {
            method = (Mobile_Number_item_click_count++ % 2 === 0) ? 'asc' : 'desc';
        } else if (sort_by === 'Holiday_name') {
            method = (Aadhar_Number_item_click_count++ % 2 === 0) ? 'asc' : 'desc';
        }

        var page_url = "{{url('all-holiday-short-api')}}/" + limit + "/" + sort_by + "/" + method;
        attendance_data_set(page_url);
    }

    function load_data() {
        var page_url = "{{url('/all-holiday-api')}}/"+limit;
        attendance_data_set(page_url);
    }

    function show_hide_column(col_no, do_show) {
        const table = document.getElementById('id_of_table');
        if (table) {
            const rows = table.getElementsByTagName('tr');
            for (let i = 0; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('th').length > 0 ?
                              rows[i].getElementsByTagName('th') :
                              rows[i].getElementsByTagName('td');

                if (cells.length > col_no) {
                    cells[col_no].style.display = do_show ? "" : "none";
                }
            }
        }
    }

    function Togle_chose_item_div() {
        $('#show_hide_items_div').toggle();
    }

    function show_hide_name() {
        if (name_item_click_count % 2 == 0) {
            $("#Name_item").addClass("chose_item_active");
            show_hide_column(1, true);
        } else {
            $("#Name_item").removeClass("chose_item_active");
            show_hide_column(1, false);
        }
        name_item_click_count++;
        Togle_chose_item_div();
    }

    function show_hide_Employee_ID() {
        if (Employee_ID_item_click_count % 2 == 0) {
            $("#Employee_ID_item").addClass("chose_item_active");
            show_hide_column(2, true);
            $("th:nth-child(3), td:nth-child(3)").show();
        } else {
            $("#Employee_ID_item").removeClass("chose_item_active");
            show_hide_column(2, false);
            $("th:nth-child(3), td:nth-child(3)").hide();
        }
        Employee_ID_item_click_count++;
        Togle_chose_item_div();
    }

    function show_hide_Mobile_Number() {
        if (Mobile_Number_item_click_count % 2 == 0) {
            $("#Mobile_Number_item").addClass("chose_item_active");
            show_hide_column(3, true);
        } else {
            $("#Mobile_Number_item").removeClass("chose_item_active");
            show_hide_column(3, false);
        }
        Mobile_Number_item_click_count++;
        Togle_chose_item_div();
    }

    function show_hide_Aadhar_Number() {
        if (Aadhar_Number_item_click_count % 2 == 0) {
            $("#Aadhar_Number_item").addClass("chose_item_active");
            show_hide_column(4, true);
            $("th:nth-child(5), td:nth-child(5)").show();
        } else {
            $("#Aadhar_Number_item").removeClass("chose_item_active");
            show_hide_column(4, false);
            $("th:nth-child(5), td:nth-child(5)").hide();
        }
        Aadhar_Number_item_click_count++;
        Togle_chose_item_div();
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
                $("#result").empty();
                var all_attendance = response.all_users.data;
                var table_html_data = `
                <table id="id_of_table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Sr.N.</th>
                            <th>Holiday Date <a href="javascript:void(0)" onclick="sort_data('holiday_Date')"><i class="fas fa-sort"></i></a></th>
                            <th ${Employee_ID_item_click_count % 2 == 1 ? 'hidden' : ''}>Swap with Date <a href="javascript:void(0)" onclick="sort_data('Swap_with_Date')"><i class="fas fa-sort"></i></a></th>
                            <th>Holiday Name <a href="javascript:void(0)" onclick="sort_data('Holiday_name')"><i class="fas fa-sort"></i></a></th>
                            <th ${Aadhar_Number_item_click_count % 2 == 1 ? 'hidden' : ''}>Public Holiday <a href="javascript:void(0)" onclick="sort_data('Public_Holiday')"><i class="fas fa-sort"></i></a></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>`;

                var count = 0;
                all_attendance.forEach(holiday => {
                    count++;
                    table_html_data += `
                        <tr>
                            <td>${count}</td>
                            <td>${holiday.holiday_Date}</td>
                            <td ${Employee_ID_item_click_count % 2 == 1 ? 'hidden' : ''}>${holiday.Swap_with_Date || 'N/A'}</td>
                            <td>${holiday.Holiday_name}</td>
                            <td ${Aadhar_Number_item_click_count % 2 == 1 ? 'hidden' : ''}>${holiday.Public_Holiday || 'No'}</td>
                            <td>
                                <button class="btn btn-sm btn-danger delete-btn" data-toggle="modal" data-target="#deleteModal" data-id="${holiday.id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>`;
                });

                table_html_data += `</tbody></table>`;
                $("#result").html(table_html_data);

                var pagination_html = '<ul class="pagination">';
                response.all_users.links.forEach(element => {
                    let activeClass = element.active ? 'active' : '';
                    let disabledClass = element.url === null ? 'disabled' : '';
                    pagination_html += `
                    <li class="page-item ${activeClass} ${disabledClass}">
                        <a class="page-link page-btn" href="javascript:void(0)" data-page="${element.url}">
                            ${element.label}
                        </a>
                    </li>`;
                });

                pagination_html += '</ul>';
                $("#pagination_div").html(pagination_html);
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                toastr.error('Error loading data');
            }
        });
    }

    function exportTableToExcel() {
        var table = document.getElementById("id_of_table");
        if (table) {
            var workbook = XLSX.utils.table_to_book(table, {sheet: "Holiday List"});
            XLSX.writeFile(workbook, "Holiday_List.xlsx");
        } else {
            toastr.error('No data available to export');
        }
    }

    function exportTableToPDF() {
        var table = document.getElementById("id_of_table");
        if (table) {
            var doc = new jsPDF('p', 'pt', 'letter');
            var res = doc.autoTableHtmlToJson(table);
            doc.autoTable(res.columns, res.data, {
                startY: 60,
                margin: {top: 60},
                styles: {overflow: 'linebreak'},
                bodyStyles: {valign: 'top'},
                theme: 'grid'
            });
            doc.text("Holiday List", 40, 30);
            doc.save("Holiday_List.pdf");
        } else {
            toastr.error('No data available to export');
        }
    }

    function printTable() {
        var table = document.getElementById("id_of_table");
        if (table) {
            var win = window.open('', '', 'height=700,width=700');
            win.document.write('<html><head><title>Holiday List</title>');
            win.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">');
            win.document.write('</head>');
            win.document.write('<body>');
            win.document.write('<h1 class="text-center">Holiday List</h1>');
            win.document.write('<table class="table table-bordered table-striped">');
            win.document.write(table.outerHTML);
            win.document.write('</table></body></html>');
            win.document.close();
            win.print();
        } else {
            toastr.error('No data available to print');
        }
    }
</script>
@stop

@extends('adminlte::page')

@section('title', 'Swap Date List')

@section('content_header')
    <h1>Swap Date List</h1>
@stop

@section('content')
<div class="container-fluid">
    <!-- Alert Messages -->
    <div class="alert alert-danger" id="error_sms_div" style="display: none; position: fixed; top: 70px; right: 20px; z-index: 99;">
        <p class="masage_p"></p>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title">Swap Holiday Management</h3>
                <button type="button" class="btn btn-primary delet_add_records">
                    <i class="fas fa-save"></i> Save Swap Holiday
                </button>
            </div>
        </div>

        <div class="card-body">
            <!-- Holiday Form Section -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="holiday_date_input">Holiday Date</label>
                        <div class="input-group">
                            <input type="date" class="form-control" name="holiday_date" id="holiday_date_input">
                            <div class="input-group-append">
                                <span class="input-group-text font-weight-bold" id="dayDisplay"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="swap_date_input">Swap Date</label>
                        <input type="date" class="form-control" name="swap_date" id="swap_date_input">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="Public_Holiday">Public Holiday</label>
                        <select name="Public_Holiday" id="Public_Holiday" class="form-control">
                            <option value="1" id="yes_opt">Yes</option>
                            <option value="0" id="no_opt">No</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="message_input">Message</label>
                        <input type="text" class="form-control" name="message" id="message_input">
                    </div>
                </div>
            </div>

            <!-- Search & Controls Section -->
            <div class="row mb-3">
                <div class="col-md-9">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="search_input">Search Employee</label>
                        <div class="input-group">
                            <input type="search" class="form-control" name="search_val" id="search_input" placeholder="Search Employee by Name, Number etc" onkeypress="serch_on_key_presh()">
                            <div class="input-group-append">
                                <button type="button" id="search_btn" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="text" value="{{session('role_number')}}" id="role_number" hidden>
            </div>

            <!-- Table Results -->
            <div id="result">
                <!-- Table content will be loaded here dynamically -->
            </div>

            <!-- Pagination and Save Button -->
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="d-flex justify-content-end align-items-center">
                        <div id="pagination_div" class="mr-3">
                            <!-- Pagination will be loaded here dynamically -->
                        </div>
                        <button type="button" id="save_btn" class="btn btn-outline-primary delet_add_records">Save Swap Holiday</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    #pagination_div {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    #pagination_div p {
        padding: 5px 10px;
        margin: 0;
        border: 1px solid #dee2e6;
        cursor: pointer;
    }

    #pagination_div p.active {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }

    .page-btn {
        cursor: pointer;
    }

    th span {
        cursor: pointer;
    }

    th span i {
        margin-left: 5px;
    }
</style>
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
var public_holiday = '';
var public_holiday_date = '';
var select_date_day = '';

$(document).ready(function() {
    // Attach a change event listener to the date input
    $('#holiday_date_input').on('change', function() {
        // Get the selected date
        const dateInput = $(this).val();
        if (dateInput) {
            // Create a new Date object
            const date = new Date(dateInput);

            // Array of weekday names
            const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

            // Get the day of the week
            const dayOfWeek = days[date.getDay()];

            // Display the day of the week
            $('#dayDisplay').text(`${dayOfWeek}`);

            var url_input = '{{url('/all-holiday-search-api/10')}}/'+ dateInput
            $.ajax({
                url: url_input,
                type: "GET",
                dataType: "json",
                headers: {
                    "Content-Type": "application/json"
                },
                success: function(response) {
                    console.log("Response:", response);
                    var holiday = response.all_users.data;

                    if (holiday != '') {
                        // Set "yes" option as selected and remove selection from "no"
                        $("#yes_opt").attr("selected", "selected");
                        $("#no_opt").removeAttr("selected");
                        public_holiday = 'No';

                        // Set the page URL
                        page_url = "{{url('/show-all-employees-api')}}";
                        attendance_data_set(page_url);
                    } else {
                        // Set "no" option as selected and remove selection from "yes"
                        $("#yes_opt").removeAttr("selected");
                        $("#no_opt").attr("selected", "selected");
                        public_holiday = 'Yes';

                        // Set the page URL with the day of the week
                        page_url = "{{url('/show-all-employees-api')}}/" + dayOfWeek;
                        attendance_data_set(page_url);
                    }
                    public_holiday_date = dateInput;
                    select_date_day = dayOfWeek;
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    console.error("Status:", status);
                    console.error("XHR Object:", xhr);
                }
            });
        }
    });
});

function search_when_holiday_selected(search_input) {
    if(public_holiday == "No"){
        page_url = "{{url('/search-when-holiday-selected')}}/" + select_date_day + "/"+ search_input;
        attendance_data_set(page_url);
    } else {
        page_url = "{{url('/all-employees-search-wid-limit_api')}}/" + search_input;
        attendance_data_set(page_url);
    }
}

function sellect_all() {
    const checkAllCheckbox = document.getElementById("sellect_all_ids");
    const itemCheckboxes = document.querySelectorAll(".checkbox_ids");
    itemCheckboxes.forEach(checkbox => {
        checkbox.checked = checkAllCheckbox.checked;
    });
}

function show_all_data() {
    page_url = "{{url('/show-all-employees-api')}}";
    attendance_data_set(page_url);
}

$(function(e){
    var all_ids = [];

    $('.delet_add_records').click(function(e){
        var swap_date = $('#swap_date_input').val();
        var holiday_date = $('#holiday_date_input').val();
        var Public_Holiday = $('#Public_Holiday').val();
        var message_inpu = $('#message_input').val();

        all_ids = [];
        $('input:checkbox[name=delet_ids]:checked').each(function(){
            all_ids.push($(this).val());
        });

        if (holiday_date == "" || all_ids.length == 0) {
            if (holiday_date == ""){
                show_error("Please Enter Holiday Date");
            } else {
                show_error("Please select Employee");
            }
        } else {
            $.ajax({
                url: "{{route('add_holiday')}}",
                type: "POST",
                data: {
                    holiday_date: holiday_date,
                    Public_Holiday: Public_Holiday,
                    message_inpu: message_inpu,
                    swap_date: swap_date,
                    ids: all_ids,
                    _token: '{{csrf_token()}}'
                },
                success: function(response){
                    show_sucess(response.success);
                    setTimeout(() => {
                        location.reload();
                    }, 3000);
                },
                error: function(xhr, status, error) {
                    show_error("Error: " + error);
                }
            });
        }
    });
});

var limit = 50;
var page_url;

// Initial data load
lode_data();

function lode_data() {
    page_url = "{{url('/all-employees-api')}}/"+ limit;
    attendance_data_set(page_url);
}

var f_name_click_count = 1;
var employ_id_click_count = 1;
var mobile_number_click_count = 1;
var email_click_count = 1;
var aadhaar_number_click_count = 1;
var pan_number_click_count = 1;

$("#search_btn").on("click", function(event) {
    event.preventDefault(); // Prevent the link's default action
    serch_on_key_presh();
});

function set_limit(){
    limit = $("#limit_inputt").val();
    page_url = "{{url('/all-employees-api')}}/"+limit;
    attendance_data_set(page_url);
}

function serch_on_key_presh() {
    var inp = $("#search_input").val();
    var holiday_date = $("#holiday_date_input").val();

    if(holiday_date != ""){
        search_when_holiday_selected(inp);
    } else {
        page_url = "{{url('/all-employees-search-api')}}/"+limit+ "/"+ inp;
        attendance_data_set(page_url);
    }
}

$('#pagination_div').on('click', '.page-btn', function () {
    var page = $(this).data('page'); // Get the page number from the button's data attribute
    attendance_data_set(page);
});

function short_data(short_by) {
    if(short_by == 'f_name'){
        if(f_name_click_count % 2 == 0){
            methid = 'asc';
        }else{
            methid = 'desc';
        }
        f_name_click_count++;
        page_url = "{{url('all-employees-short-api')}}/" + limit +"/"+short_by +"/"+ methid;
        attendance_data_set(page_url);
    } else if (short_by == 'Employee_id') {
        if(employ_id_click_count % 2 == 0){
            methid = 'asc';
        }else{
            methid = 'desc';
        }
        employ_id_click_count++;
        page_url = "{{url('all-employees-short-api')}}/" + limit +"/"+short_by +"/"+ methid;
        attendance_data_set(page_url);
    } else if (short_by == 'mobile_number') {
        if(mobile_number_click_count % 2 == 0){
            methid = 'asc';
        }else{
            methid = 'desc';
        }
        mobile_number_click_count++;
        page_url = "{{url('all-employees-short-api')}}/" + limit +"/"+short_by +"/"+ methid;
        attendance_data_set(page_url);
    } else if (short_by == 'email') {
        if(email_click_count % 2 == 0){
            methid = 'asc';
        }else{
            methid = 'desc';
        }
        email_click_count++;
        page_url = "{{url('all-employees-short-api')}}/" + limit +"/"+short_by +"/"+ methid;
        attendance_data_set(page_url);
    } else if (short_by == 'aadhaar_number') {
        if(aadhaar_number_click_count % 2 == 0){
            methid = 'asc';
        }else{
            methid = 'desc';
        }
        aadhaar_number_click_count++;
        page_url = "{{url('all-employees-short-api')}}/" + limit +"/"+short_by +"/"+ methid;
        attendance_data_set(page_url);
    } else if (short_by == 'pan_number') {
        if(pan_number_click_count % 2 == 0){
            methid = 'asc';
        }else{
            methid = 'desc';
        }
        pan_number_click_count++;
        page_url = "{{url('all-employees-short-api')}}/" + limit +"/"+short_by +"/"+ methid;
        attendance_data_set(page_url);
    }
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
            $("#result").empty();
            var all_users_data = response.all_users.data;
            var role_number = $("#role_number").val();

            var table_html_data = `
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="id_of_table">
                    <thead>
                        <tr>
                            <th width="40px"><input type="checkbox" name="" id="sellect_all_ids" onchange="sellect_all()"></th>
                            <th>Name <span onclick="short_data('f_name')" id="f_name_span"><i class="fas fa-sort"></i></span></th>
                            <th>Employee ID <span onclick="short_data('Employee_id')" id="Employee_id_span"><i class="fas fa-sort"></i></span></th>
                            <th>Shift Time</th>
                            <th>Employee Type</th>
                            <th>Role</th>
                            <th>Weekly Off</th>
                            <th>Department</th>
                        </tr>
                    </thead>
                    <tbody>`;

            all_users_data.forEach(all_users_data => {
                if (all_users_data.role >= role_number) {
                    table_html_data += `
                    <tr id="employee_id${all_users_data.id}">
                        <td><input type="checkbox" name="delet_ids" class="checkbox_ids" value="${all_users_data.Employee_id}"></td>
                        <td>${all_users_data.f_name} ${all_users_data.m_name} ${all_users_data.l_name}</td>
                        <td>${all_users_data.Employee_id}</td>
                        <td>${all_users_data.Shift_Name}</td>
                        <td>${all_users_data.EmpTypeName}</td>
                        <td>${all_users_data.roles}</td>
                        <td>${all_users_data.Weekly_Off}</td>
                        <td>${all_users_data.Department_name}</td>
                    </tr>`;
                }
            });

            table_html_data += `
                    </tbody>
                </table>
            </div>`;

            $("#result").html(table_html_data);

            // Pagination
            var pajination_data = response.all_users.links;
            var pagination_html = `<ul class="pagination m-0">`;
            var page_count = 0;

            pajination_data.forEach(element => {
                if (element.label === "&laquo; Previous") {
                    pagination_html += `<li class="page-item ${element.active ? 'active' : ''}">
                        <a class="page-link page-btn" href="#" data-page='${element.url}'>&laquo;</a>
                    </li>`;
                } else if (element.label === "Next &raquo;") {
                    pagination_html += `<li class="page-item ${element.active ? 'active' : ''}">
                        <a class="page-link page-btn" href="#" data-page='${element.url}'>&raquo;</a>
                    </li>`;
                } else {
                    pagination_html += `<li class="page-item ${element.active ? 'active' : ''}">
                        <a class="page-link page-btn" href="#" data-page='${element.url}'>${element.label}</a>
                    </li>`;
                }
                page_count++;
            });

            pagination_html += `</ul>`;

            // Update sort icons based on current sort state
            if(f_name_click_count % 2 == 0){
                document.getElementById('f_name_span').innerHTML = '<i class="fas fa-sort-up"></i>';
            } else {
                document.getElementById('f_name_span').innerHTML = '<i class="fas fa-sort-down"></i>';
            }

            if(employ_id_click_count % 2 == 0){
                document.getElementById('Employee_id_span').innerHTML = '<i class="fas fa-sort-up"></i>';
            } else {
                document.getElementById('Employee_id_span').innerHTML = '<i class="fas fa-sort-down"></i>';
            }

            $("#pagination_div").html(pagination_html);
        },
        error: function(xhr, status, error) {
            console.error("Error:", error);
            show_error("Failed to load data: " + error);
        }
    });
}

function show_error(message) {
    $("#error_sms_div").removeClass("alert-success").addClass("alert-danger");
    $("#error_sms_div").css("display", "block");
    $("#error_sms_div").html(message);
    setTimeout(() => {
        $("#error_sms_div").css("display", "none");
        $("#error_sms_div").html("");
    }, 3000);
}

function show_sucess(message) {
    $("#error_sms_div").removeClass("alert-danger").addClass("alert-success");
    $("#error_sms_div").css("display", "block");
    $("#error_sms_div").html(message);
    setTimeout(() => {
        $("#error_sms_div").css("display", "none");
        $("#error_sms_div").html("");
    }, 3000);
}
</script>
@stop

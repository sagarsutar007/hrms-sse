@extends('adminlte::page')

@section('title', 'Employees')

@section('content')

<div id="data_div">

    <div id="data_inner_div" style="overflow: scroll">
        <div id="data_heading_div">

                <p>All Employee List
                </p>

            <div style="display: flex">
                <p class="buttons_p" onclick="collectSelectedIds()"><i class="fa-solid fa-download"></i> Download Id Cards</p>
                <p class="buttons_p" onclick="location.href='{{url('/registration')}}'"><i class="fa-solid fa-plus"></i> Add New</p>
                <p class="buttons_p" onclick="open_bulk_uplaode()"><i class="fa-solid fa-arrow-up-from-bracket"></i> Bulk Upload</p>
                <p class="buttons_p" id="delet_add_records"> <i class="fa-solid fa-circle-minus"></i> Bulk Delete</p>


            </div>

        </div>
        <div id="export_and_print">
            <div style="display: flex">
                <div style="display: flex">
                    <div>
                        <form action="{{route('set_limit')}}" method="get">
                            @csrf

                            <input type="number" id="limit_inputt" required name="limit_num" min="10"  onkeyup="set_limit()" placeholder="set Limit" style="width: 100px">


                        </form>
                    </div>

                    <div id="export_main_div">




<p  onclick="exportTableToExcel()" >Excel</p>
<p onclick="exportTableToPDF()" >PDF</p>
<p onclick="printTable()">Print</p>
<div id="visibility_div" >
    <P class="chose_item" style="background: transparent" onclick="Togle_chose_item_div()">Column visibility   <span id="down_angle" ><i class="fa-solid fa-angle-down"></i></span></P>

    <div id="visibility_down_div">
        <div id="show_hide_items_div">
            <P class="single_items chose_item_active" onclick="show_hide_name()" id="Name_item">Name</P>
            <P  class="single_items chose_item_active" onclick="show_hide_Employee_ID()" id="Employee_ID_item">Employee ID</P>
            <P  class="single_items chose_item_active" onclick="show_hide_Mobile_Number()" id="Mobile_Number_item">Mobile Number</P>
            <P  class="single_items chose_item_active" onclick="show_hide_Aadhar_Number()" id="Aadhar_Number_item">Email ID</P>
            <P  class="single_items chose_item_active" onclick="show_hide_Email_id()" id="Email_id_item">Aadhar Number</P>
            <P  class="single_items chose_item_active" onclick="show_hide_Pan_Number()" id="Pan_Number_item">Pan Number</P>
            <P  class="single_items chose_item_active" onclick="show_hide_Employee_Type()" id="Employee_Type_item">Date of birth</P>
            <P  class="single_items chose_item_active" onclick="show_hide_Current_Address()" id="Current_Address_item">Current Address</P>

            <P  class="single_items chose_item_active" onclick="show_hide_Permanent_Address()" id="Permanent_Address_item">Permanent Address</P>
            <P  class="single_items chose_item_active" onclick="show_hide_Gender()" id="Gender_item">Gender</P>
            <P  class="single_items chose_item_active" onclick="show_hide_Marital_Status()" id="Marital_Status_item">Marital Status</P>
            <P  class="single_items chose_item_active" onclick="show_hide_DOJ()" id="DOJ_item">DOJ</P>
            <P  class="single_items chose_item_active" onclick="show_hide_Highest_Qualification()" id="Highest_Qualification_item">	Highest Qualification</P>
            <P  class="single_items chose_item_active" onclick="show_hide_Salary()" id="Salary_item">	Salary</P>
            <P  class="single_items chose_item_active" onclick="show_hide_Shift_Time()" id="Shift_Time_item">	Shift Time</P>

        </div>
    </div>
</div>
<input type="text" value="{{session('role_number')}}" id="role_number" hidden>


                    </div>
                </div>

            </div>
            <div style="display: flex">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <form action="{{route('search_employee')}}" method="post">
                        @csrf
                    <div id="search_box_div">
                        <input type="search" name="search_val" id="search_input"
                            placeholder="Search Employee by Name Number etc" required onkeyup="serch_on_key_presh()">
                        <button type="submit" id="search_btn">Search</button>


                    </div>
                    </form>

                </div>

            </div>


        </div>
        <div style="padding: 15px; overflow-x: scroll " id="result">
            {{-- tables --}}


            {{-- tables --}}
        </div>
            {{-- paginatitin html --}}
            <div class="pagination" id="pagination_div">

            </div>
    {{-- paginatitin html --}}

    </div>

</div>





<script>
    function collectSelectedIds() {
        // Collect all checked checkboxes
        const checkboxes = document.querySelectorAll('input[name="delet_ids"]:checked');
        let ids = Array.from(checkboxes).map(cb => cb.value);

        // Convert the IDs array into a comma-separated string
        const searchInput = ids.join(',');
        location.href = "{{url('downloade-selected-id-cards/')}}/" + searchInput;

    }
</script>

    <script>
        var limit = 50;
          var page_url;
    lode_data();
    function lode_data() {
      page_url = "{{url('/all-employees-api')}}/"+ limit
     attendance_data_set(page_url)
    }
var f_name_click_count =1;
var employ_id_click_count =1;
var mobile_number_click_count =1;
var email_click_count =1;
var aadhaar_number_click_count =1;
var pan_number_click_count =1;

$("#search_btn").on("click", function(event) {
        event.preventDefault(); // Prevent the link's default action

        // Perform your custom logic
        serch_on_key_presh()
    });
    function set_limit(){
        limit  = $("#limit_inputt").val();
        page_url = "{{url('/all-employees-api')}}/"+limit
     attendance_data_set(page_url)

    }

function serch_on_key_presh() {
        var inp  = $("#search_input").val();
     page_url = "{{url('/all-employees-search-api')}}/"+limit+ "/"+ inp
     attendance_data_set(page_url)
    }

    $('#pagination_div').on('click', '.page-btn', function () {
    var page = $(this).data('page'); // Get the page number from the button's data attribute
    attendance_data_set(page)

  });

    function short_data(short_by) {
    if(short_by == 'f_name'){
    if(f_name_click_count % 2 == 0){
        methid = 'asc'
    }else{
       methid = 'desc'
    }
    f_name_click_count ++ ;
    page_url = "{{url('all-employees-short-api')}}/" + limit +"/"+short_by +"/"+ methid
    attendance_data_set(page_url)

   }else if (short_by == 'Employee_id') {
    if(employ_id_click_count % 2 == 0){
        methid = 'asc'
    }else{
  methid = 'desc'

    }
    employ_id_click_count ++ ;
    page_url = "{{url('all-employees-short-api')}}/" + limit +"/"+short_by +"/"+ methid
    attendance_data_set(page_url)

   }else if (short_by == 'mobile_number') {
    if(mobile_number_click_count % 2 == 0){
        methid = 'asc'
    }else{
 methid = 'desc'

    }
    mobile_number_click_count ++ ;
    page_url = "{{url('all-employees-short-api')}}/" + limit +"/"+short_by +"/"+ methid
    attendance_data_set(page_url)

  }else if (short_by == 'email') {
    if(email_click_count % 2 == 0){
        methid = 'asc'
    }else{
 methid = 'desc'

    }
    email_click_count ++ ;
    page_url = "{{url('all-employees-short-api')}}/" + limit +"/"+short_by +"/"+ methid
    attendance_data_set(page_url)

  }else if (short_by == 'aadhaar_number') {
    if(aadhaar_number_click_count % 2 == 0){
        methid = 'asc'
    }else{
 methid = 'desc'

    }
    aadhaar_number_click_count ++ ;
    page_url = "{{url('all-employees-short-api')}}/" + limit +"/"+short_by +"/"+ methid
    attendance_data_set(page_url)

  }else if (short_by == 'pan_number') {
    if(pan_number_click_count % 2 == 0){
        methid = 'asc'
    }else{
 methid = 'desc'

    }
    pan_number_click_count ++ ;
    page_url = "{{url('all-employees-short-api')}}/" + limit +"/"+short_by +"/"+ methid
    attendance_data_set(page_url)

  }else{

}

}


function attendance_data_set(url_input) {
    $.ajax({
  url:  url_input,  // API endpoint URL
  type: "GET",  // HTTP method, e.g., GET, POST, PUT, DELETE
  dataType: "json",

  headers: {
    // "Authorization": "Bearer YOUR_ACCESS_TOKEN",  // Add headers if needed
    "Content-Type": "application/json"
  },
  success: function(response) {
    console.log("Response:", response);  // Handle the successful response here
    $("#result").empty();
   var count_flag = 1;
   var all_data = response.data;
   var role_number = $("#role_number").val();
   var all_users_data = response.all_users.data ;
   var table_html_data =`<table  id="id_of_table">
                <col class="col1" />
                <col class="col2" />
                <col class="col3" />
                <col class="col4" />
                <col class="col5" />
                <col class="col6" />
                <col class="col7" />
                <col class="col8" />
                <col class="col9" />
                <col class="col10" />
                <col class="col11" />
                <col class="col12" />
                <col class="col13" />
                <col class="col14" />
                <col class="col15" />
                <col class="col16" />
                <col class="col17" />
                <col class="col18" />
                <col class="col18" />
                <thead >
                    <tr >
                        <th><input type="checkbox" name="" id="sellect_all_ids" ></th>
                        <th>Name <span onclick="short_data('f_name')" id="f_name_span"><i class="fa-solid fa-arrow-down-wide-short"></i></span></th>
                        <th> Employee ID <span onclick="short_data('Employee_id')" id="Employee_id_span"><i class="fa-solid fa-arrow-down-wide-short"></i></span></th>
                        <th>Mobile Number <span onclick="short_data('mobile_number')" id="mobile_number_span"><i class="fa-solid fa-arrow-down-wide-short"></i></span></th>
                        <th>Email Id <span onclick="short_data('email')" id="email_span"><i class="fa-solid fa-arrow-down-wide-short"></i></span></th>
                        <th>Aadhar Number <span onclick="short_data('aadhaar_number')" id="aadhaar_number_span"><i class="fa-solid fa-arrow-down-wide-short"></i></span></th>
                        <th>Pan Number <span onclick="short_data('pan_number')" id="pan_number_span"><i class="fa-solid fa-arrow-down-wide-short"></i></span></th>
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
                <form id="userForm" action="{{url('/downloade-Id-cards')}}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" id="search_input" name="search_input" value="">
                `
                all_users_data.forEach(all_users_data => {
                    if (all_users_data.role >= role_number) {
                        table_html_data +=   `<tr id="value="employee_id${all_users_data.id }"  >
                                <td><input type="checkbox"  name="delet_ids" class="checkbox_ids" value="${all_users_data.id }"></td>
                                <td> ${all_users_data.f_name } ${all_users_data.m_name } ${all_users_data.l_name }</td>
                                <td>${all_users_data.Employee_id } </td>
                                <td>${all_users_data.mobile_number } </td>
                                <td>${all_users_data.email }</td>
                                <td> ${all_users_data.aadhaar_number }</td>
                                <td>${all_users_data.pan_number }</td>
                                <td>${all_users_data.dob }</td>
                                <td>${all_users_data.current_address }</td>
                                <td>${all_users_data.permanent_address } </td>
                                <td>${all_users_data.gender } </td>
                                <td>${all_users_data.marital_status } </td>
                                <td>${all_users_data.DOJ } </td>
                                <td>${all_users_data.highest_qualification } </td>
                                <td>₹${all_users_data.salary }</td>
                                <td>${all_users_data.Shift_Name }</td>
                                <td>${all_users_data.EmpTypeName }</td>
                                <td>${all_users_data.roles }</td>
                                <td>${all_users_data.Weekly_Off }</td>
                                <td>${all_users_data.Department_name }</td>
                                <td>${all_users_data.Gate_Off }</td>

                                <td>  <a href="view-details/${all_users_data.id }" class="table_icons"><i class="fa-regular fa-eye" title="view"></i></a> <a href="user-details/${all_users_data.id }" class="table_icons" ><i class="fa-solid fa-pencil" title="Edit User Data"></i></a> <a href="dounloade-user-id-catd/${all_users_data.id }" class="table_icons"><i class="fa-solid fa-download" title="Download ID Cards"></i></a></td>
                            </tr>`
                    }else{

                    }



            });
            table_html_data +=  ` <button type="button" onclick="collectSelectedIds()" hidden>Submit</button>
    </form></table>`
 $("#result").html(table_html_data);
//code for pagination
   var pajination_data = response.all_users.links   ;
   var pagination_html = ``
         var page_count = 0;
   pajination_data.forEach(element => {
    pagination_html +=`<p  data-page='${pajination_data[page_count].url}' `
    pagination_html += `class="${pajination_data[page_count].active} page-btn" `
    pagination_html += ` >${pajination_data[page_count].label}</p>`
    page_count++
   });


   if(f_name_click_count % 2 == 0){
        document.getElementById('f_name_span').innerHTML = '<i class="fa-solid fa-arrow-up-short-wide"></i>'
    }else{
 document.getElementById('f_name_span').innerHTML = '<i class="fa-solid fa-arrow-down-short-wide"></i>'
    }

    if(employ_id_click_count % 2 == 0){
         document.getElementById('Employee_id_span').innerHTML = '<i class="fa-solid fa-arrow-up-short-wide"></i>'
    }else{
  document.getElementById('Employee_id_span').innerHTML = '<i class="fa-solid fa-arrow-down-short-wide"></i>'
    }
    if(mobile_number_click_count % 2 == 0){
         document.getElementById('mobile_number_span').innerHTML = '<i class="fa-solid fa-arrow-up-short-wide"></i>'
    }else{
  document.getElementById('mobile_number_span').innerHTML = '<i class="fa-solid fa-arrow-down-short-wide"></i>'
    }
    if(email_click_count % 2 == 0){
         document.getElementById('email_span').innerHTML = '<i class="fa-solid fa-arrow-up-short-wide"></i>'
    }else{
  document.getElementById('email_span').innerHTML = '<i class="fa-solid fa-arrow-down-short-wide"></i>'
    }

    if(aadhaar_number_click_count % 2 == 0){
         document.getElementById('aadhaar_number_span').innerHTML = '<i class="fa-solid fa-arrow-up-short-wide"></i>'
    }else{
  document.getElementById('aadhaar_number_span').innerHTML = '<i class="fa-solid fa-arrow-down-short-wide"></i>'
    }

    if(pan_number_click_count % 2 == 0){
         document.getElementById('pan_number_span').innerHTML = '<i class="fa-solid fa-arrow-up-short-wide"></i>'
    }else{
  document.getElementById('pan_number_span').innerHTML = '<i class="fa-solid fa-arrow-down-short-wide"></i>'
    }





   $("#pagination_div").html(pagination_html);
  },
     error: function(xhr, status, error) {
    console.error("Error:", error);  // Handle the error here
  }
});
}

        // const btnHide = document.getElementById('btnHide')
        // btnHide.addEventListener("click", () => show_hide_column(2, false))




    </script>


<script>
    var item_click_count = 1;
    var name_item_click_count = 2;
    var Employee_ID_item_click_count = 2;
    var Mobile_Number_item_click_count = 2;
    var Aadhar_Number_item_click_count = 2;
    var Email_id_item_click_count = 2;
    var Pan_Number_item_click_count = 2;
    var Employee_Type_item_click_count =2;
    var Current_Address= 1;
    var Permanent_Address= 1;
    var  Gender= 1;
    var  Marital_Status= 1;
    var   DOJ= 1;
    var  Highest_Qualification= 1;
    var  Salary= 1;
    var Shift_Time= 1;
    var Employee_Type= 1;
    var  Actions= 1;












    function set_column_visibility(url_input) {
    $.ajax({
  url:  url_input,  // API endpoint URL
  type: "GET",  // HTTP method, e.g., GET, POST, PUT, DELETE
  dataType: "json",

  headers: {
    // "Authorization": "Bearer YOUR_ACCESS_TOKEN",  // Add headers if needed
    "Content-Type": "application/json"
  },
  success: function(response) {
    console.log("Response:", response);  // Handle the successful response here
    var col_data = response.data

    col_data.forEach(c_data => {
     name_item_click_count = c_data.col1;
     Employee_ID_item_click_count =  c_data.col2;
     Mobile_Number_item_click_count =  c_data.col3;
     Aadhar_Number_item_click_count =  c_data.col4;
     Email_id_item_click_count =  c_data.col5;
     Pan_Number_item_click_count =  c_data.col6;
     Employee_Type_item_click_count = c_data.col7;
     Current_Address=  c_data.col8;
     Permanent_Address= c_data.col9;
      Gender=  c_data.col10;
      Marital_Status=  c_data.col11;
      DOJ=  c_data.col12;
     Highest_Qualification=  c_data.col13;
     Salary=  c_data.col14;
    Shift_Time=  c_data.col15;
    Employee_Type=  c_data.col16;
     Actions=  c_data.col17;

     console.log(c_data.col1)

     show_hide_name()
 show_hide_Gender()
show_hide_Employee_ID()
show_hide_Mobile_Number()
show_hide_Aadhar_Number()
show_hide_Email_id()
show_hide_Pan_Number()
show_hide_Employee_Type()
 show_hide_Current_Address()
show_hide_Permanent_Address()
show_hide_Marital_Status()
 show_hide_DOJ()
show_hide_Highest_Qualification()
 show_hide_Salary()
 show_hide_Shift_Time()
 console.log(c_data.col1)
    });






  },
     error: function(xhr, status, error) {
    console.error("Error:", error);  // Handle the error here
  }
});
}


function update_column_visibility(url_input) {
    $.ajax({
  url:  url_input,  // API endpoint URL
  type: "GET",  // HTTP method, e.g., GET, POST, PUT, DELETE
  dataType: "json",

  headers: {
    // "Authorization": "Bearer YOUR_ACCESS_TOKEN",  // Add headers if needed
    "Content-Type": "application/json"
  },
  success: function(response) {
    console.log("Response:", response);  // Handle the successful response here


  },
     error: function(xhr, status, error) {
    console.error("Error:", error);  // Handle the error here
  }
});
}

set_column_visibility("{{url('/col-visibility/all_employees')}}")


    function Togle_chose_item_div(){
        if(item_click_count % 2 == 0){
            document.getElementById("show_hide_items_div").style.display="none";

        }else{
            document.getElementById("show_hide_items_div").style.display="block";

        }
        item_click_count++
    }
    function show_hide_name(){
        if(name_item_click_count % 2 == 0){
            document.getElementById("show_hide_items_div").style.display="none";
            document.getElementById("Name_item").classList.add("chose_item_active");
            item_click_count = 1;

            show_hide_column(1, true)
            update_column_visibility("{{url('/update-col-visibility/all_employees/col1/2')}}")
        }else{
            document.getElementById("show_hide_items_div").style.display="none";
            document.getElementById("Name_item").classList.remove("chose_item_active");
            item_click_count = 1;
            show_hide_column(1, false)
            update_column_visibility("{{url('/update-col-visibility/all_employees/col1/1')}}")

        }
        name_item_click_count++
    }
    function show_hide_Employee_ID(){
        if(Employee_ID_item_click_count % 2 == 0){
            document.getElementById("show_hide_items_div").style.display="none";
            document.getElementById("Employee_ID_item").classList.add("chose_item_active");
            show_hide_column(2, true)
            update_column_visibility("{{url('/update-col-visibility/all_employees/col2/2')}}")
            item_click_count = 1;
        }else{
            document.getElementById("show_hide_items_div").style.display="none";
            document.getElementById("Employee_ID_item").classList.remove("chose_item_active");

            show_hide_column(2, false)
            update_column_visibility("{{url('/update-col-visibility/all_employees/col2/1')}}")
            item_click_count = 1;

        }
        Employee_ID_item_click_count++
    }
    function show_hide_Mobile_Number(){
        if(Mobile_Number_item_click_count % 2 == 0){
            document.getElementById("show_hide_items_div").style.display="none";
            document.getElementById("Mobile_Number_item").classList.add("chose_item_active");
            show_hide_column(3, true)
            update_column_visibility("{{url('/update-col-visibility/all_employees/col3/2')}}")
            item_click_count = 1;
        }else{
            document.getElementById("show_hide_items_div").style.display="none";
            document.getElementById("Mobile_Number_item").classList.remove("chose_item_active");
            show_hide_column(3, false)
            update_column_visibility("{{url('/update-col-visibility/all_employees/col3/1')}}")
            item_click_count = 1;

        }
        Mobile_Number_item_click_count++
    }

    function show_hide_Aadhar_Number(){
        if(Aadhar_Number_item_click_count % 2 == 0){
            document.getElementById("show_hide_items_div").style.display="none";
            document.getElementById("Aadhar_Number_item").classList.add("chose_item_active");
            show_hide_column(4, true)
            update_column_visibility("{{url('/update-col-visibility/all_employees/col4/2')}}")
            item_click_count = 1;
        }else{
            document.getElementById("show_hide_items_div").style.display="none";
            document.getElementById("Aadhar_Number_item").classList.remove("chose_item_active");
            show_hide_column(4, false)
            update_column_visibility("{{url('/update-col-visibility/all_employees/col4/1')}}")
            item_click_count = 1;

        }
        Aadhar_Number_item_click_count++
    }

    function show_hide_Email_id(){
        if(Email_id_item_click_count % 2 == 0){
            document.getElementById("show_hide_items_div").style.display="none";
            document.getElementById("Email_id_item").classList.add("chose_item_active");
            show_hide_column(5, true)
            update_column_visibility("{{url('/update-col-visibility/all_employees/col5/2')}}")
            item_click_count = 1;
        }else{
            document.getElementById("show_hide_items_div").style.display="none";
            document.getElementById("Email_id_item").classList.remove("chose_item_active");
            update_column_visibility("{{url('/update-col-visibility/all_employees/col5/1')}}")
            show_hide_column(5, false)
            item_click_count = 1;

        }
        Email_id_item_click_count++
    }

    function show_hide_Pan_Number(){
        if(Pan_Number_item_click_count % 2 == 0){
            document.getElementById("show_hide_items_div").style.display="none";
            document.getElementById("Pan_Number_item").classList.add("chose_item_active");
            show_hide_column(6, true)
            update_column_visibility("{{url('/update-col-visibility/all_employees/col6/2')}}")
            item_click_count = 1;
        }else{
            document.getElementById("show_hide_items_div").style.display="none";
            document.getElementById("Pan_Number_item").classList.remove("chose_item_active");
            show_hide_column(6, false)
            update_column_visibility("{{url('/update-col-visibility/all_employees/col6/1')}}")
            item_click_count = 1;

        }
        Pan_Number_item_click_count++
    }


    function show_hide_Employee_Type(){
        if(Employee_Type_item_click_count % 2 == 0){
            document.getElementById("show_hide_items_div").style.display="none";
            document.getElementById("Employee_Type_item").classList.add("chose_item_active");
            show_hide_column(7, true)
            update_column_visibility("{{url('/update-col-visibility/all_employees/col7/2')}}")
            item_click_count = 1;
        }else{
            document.getElementById("show_hide_items_div").style.display="none";
            document.getElementById("Employee_Type_item").classList.remove("chose_item_active");
            show_hide_column(7, false)
            update_column_visibility("{{url('/update-col-visibility/all_employees/col7/1')}}")
            item_click_count = 1;

        }
        Employee_Type_item_click_count++
    }


    function show_hide_Current_Address(){
        if(Current_Address % 2 == 0){
            document.getElementById("show_hide_items_div").style.display="none";
            document.getElementById("Current_Address_item").classList.add("chose_item_active");
            show_hide_column(8, true)
            update_column_visibility("{{url('/update-col-visibility/all_employees/col8/2')}}")
            item_click_count = 1;
        }else{
            document.getElementById("show_hide_items_div").style.display="none";
            document.getElementById("Current_Address_item").classList.remove("chose_item_active");
            show_hide_column(8, false)
            update_column_visibility("{{url('/update-col-visibility/all_employees/col8/1')}}")
            item_click_count = 1;

        }
        Current_Address++
    }


    function show_hide_Permanent_Address(){
        if(Permanent_Address % 2 == 0){
            document.getElementById("show_hide_items_div").style.display="none";
            document.getElementById("Permanent_Address_item").classList.add("chose_item_active");
            show_hide_column(9, true)
            update_column_visibility("{{url('/update-col-visibility/all_employees/col9/2')}}")
            item_click_count = 1;
        }else{
            document.getElementById("show_hide_items_div").style.display="none";
            document.getElementById("Permanent_Address_item").classList.remove("chose_item_active");
            show_hide_column(9, false)
            update_column_visibility("{{url('/update-col-visibility/all_employees/col9/1')}}")
            item_click_count = 1;

        }
        Permanent_Address++
    }

    function show_hide_Gender(){
        if(Gender % 2 == 0){
            document.getElementById("show_hide_items_div").style.display="none";
            document.getElementById("Gender_item").classList.add("chose_item_active");
            show_hide_column(10, true)
            update_column_visibility("{{url('/update-col-visibility/all_employees/col10/2')}}")
            item_click_count = 1;
        }else{
            document.getElementById("show_hide_items_div").style.display="none";
            document.getElementById("Gender_item").classList.remove("chose_item_active");
            show_hide_column(10, false)
            update_column_visibility("{{url('/update-col-visibility/all_employees/col10/1')}}")
            item_click_count = 1;

        }
        Gender++
    }

    function show_hide_Marital_Status(){
        if(Marital_Status % 2 == 0){
            document.getElementById("show_hide_items_div").style.display="none";
            document.getElementById("Marital_Status_item").classList.add("chose_item_active");
            show_hide_column(11, true)
            update_column_visibility("{{url('/update-col-visibility/all_employees/col11/2')}}")
            item_click_count = 1;
        }else{
            document.getElementById("show_hide_items_div").style.display="none";
            document.getElementById("Marital_Status_item").classList.remove("chose_item_active");
            show_hide_column(11, false)
            update_column_visibility("{{url('/update-col-visibility/all_employees/col11/1')}}")
            item_click_count = 1;

        }
        Marital_Status++
    }

    function show_hide_DOJ(){
        if(DOJ % 2 == 0){
            document.getElementById("show_hide_items_div").style.display="none";
            document.getElementById("DOJ_item").classList.add("chose_item_active");
            show_hide_column(12, true)
            update_column_visibility("{{url('/update-col-visibility/all_employees/col12/2')}}")
            item_click_count = 1;
        }else{
            document.getElementById("show_hide_items_div").style.display="none";
            document.getElementById("DOJ_item").classList.remove("chose_item_active");
            show_hide_column(12, false)
            update_column_visibility("{{url('/update-col-visibility/all_employees/col12/1')}}")
            item_click_count = 1;

        }
        DOJ++
    }

    function show_hide_Highest_Qualification(){
        if(Highest_Qualification % 2 == 0){
            document.getElementById("show_hide_items_div").style.display="none";
            document.getElementById("Highest_Qualification_item").classList.add("chose_item_active");
            show_hide_column(13, true)
            update_column_visibility("{{url('/update-col-visibility/all_employees/col13/2')}}")
            item_click_count = 1;
        }else{
            document.getElementById("show_hide_items_div").style.display="none";
            document.getElementById("Highest_Qualification_item").classList.remove("chose_item_active");
            show_hide_column(13, false)
            update_column_visibility("{{url('/update-col-visibility/all_employees/col13/1')}}")
            item_click_count = 1;

        }
        Highest_Qualification++
    }

    function show_hide_Salary(){
        if(Salary % 2 == 0){
            document.getElementById("show_hide_items_div").style.display="none";
            document.getElementById("Salary_item").classList.add("chose_item_active");
            show_hide_column(14, true)
            update_column_visibility("{{url('/update-col-visibility/all_employees/col14/2')}}")
            item_click_count = 1;
        }else{
            document.getElementById("show_hide_items_div").style.display="none";
            document.getElementById("Salary_item").classList.remove("chose_item_active");
            show_hide_column(14, false)
            update_column_visibility("{{url('/update-col-visibility/all_employees/col14/1')}}")
            item_click_count = 1;

        }
        Salary++
    }

    function show_hide_Shift_Time(){
        if(Shift_Time % 2 == 0){
            document.getElementById("show_hide_items_div").style.display="none";
            document.getElementById("Shift_Time_item").classList.add("chose_item_active");
            show_hide_column(15, true)
            update_column_visibility("{{url('/update-col-visibility/all_employees/col15/2')}}")
            item_click_count = 1;
        }else{
            document.getElementById("show_hide_items_div").style.display="none";
            document.getElementById("Shift_Time_item").classList.remove("chose_item_active");
            update_column_visibility("{{url('/update-col-visibility/all_employees/col15/1')}}")
            show_hide_column(15, false)
            item_click_count = 1;

        }
        Shift_Time++
    }




    function show_hide_column(col_no, do_show) {
            const table = document.getElementById('id_of_table')
            const column = table.getElementsByTagName('col')[col_no]
            if (column) {
                column.style.visibility = do_show ? "" : "collapse";
            }
        }

</script>

<style>
    #show_hide_coloun_div{
        position: absolute;

        margin-top: -20px;
        margin-left: 10px;

        width: 150px;

    }
    #delet_add_records{
        text-decoration: none;
        padding: 6px 5px;

    }
    #show_hide_items_div{
        position: relative;
        top: 0;
        left: 0;
         display: none ;
         z-index: 2;

    }
    .show_hide_items_div{
        display: block;
    }
    .chose_item{
        background: blue;
        color: black;
        padding: 8px 10px;
        text-align: left;
    }
    .chose_item_active{
        background: rgba(6, 6, 85, 0.524);
        color: blue;
    }
    #down_angle{
        margin-left: 10px;
        cursor: pointer;
    }
    .single_items{
padding: 8px 10px;
    }
    .single_items:hover{
        background: blue;
        color: white;
    }
    .table_icons{
        font-size: 16px;
        margin: 0px 5px;
    }
    #export_table_div p {
        text-align: left;
    }
</style>



    {{-- <button  onclick="show_hide_column(1, false)">hide Name</button>
    <button  onclick="show_hide_column(1, true)">show Name</button>
    <button  onclick="show_hide_column(2, false)">hide Employee ID</button>
    <button  onclick="show_hide_column(2, true)">show Employee ID</button>
    <button  onclick="show_hide_column(3, false)">hide Mobile Number</button>
    <button  onclick="show_hide_column(3, true)">show Mobile Number</button> --}}







    <script>
        $(function(e){
            var all_ids = [];
            $("#sellect_all_ids").click(function(){
                $(".checkbox_ids").prop('checked',$(this).prop('checked'))
            })
            $('#delet_add_records').click(function(e){


                $('input:checkbox[name=delet_ids]:checked').each(function(){
                    all_ids.push($(this).val());
                })

                $.ajax({
                    url:"{{route('delete_employee')}}",
                    type:"POST",
                    data:{
                        ids:all_ids,
                        _token:'{{csrf_token()}}'
                    },
                    success:function(response){

                   alert(response.success)
                   location.reload()


                    }

                })






            })





        })




        function printTable() {
    // Get the HTML table element
    var table = document.getElementById("id_of_table").outerHTML;

    // Open a new window
    var newWindow = window.open('', '', 'width=800,height=600');

    // Add the table HTML and a print button to the new window
    newWindow.document.write('<html><head><title>Print Table</title>');
    newWindow.document.write('<style>table { border-collapse: collapse; width: 100%; } th, td { border: 1px solid black; padding: 8px; text-align: left; }</style>');
    newWindow.document.write('</head><body>');
    newWindow.document.write(table);
    newWindow.document.write('</body></html>');

    // Automatically trigger print dialog
    newWindow.document.close(); // Close the document to finish loading
    newWindow.focus(); // Ensure the new window is in focus
    newWindow.print(); // Trigger the print dialog
    newWindow.close(); // Close the print window after printing
  }


function exportTableToPDF() {
    // Create a new instance of jsPDF
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Get the HTML table
    var table = document.getElementById("id_of_table");

    // Use autoTable plugin to convert table to PDF
    doc.autoTable({
      html: table, // Reference the table element
      startY: 10, // Starting position on the Y axis
      theme: 'grid', // You can change the theme ('grid', 'striped', 'plain')
      headStyles: { fillColor: [22, 160, 133] }, // Optional styling for header
      styles: { fontSize: 5 } // Set font size to 8px
    });




    // Save the generated PDF
    doc.save("table.pdf");
  }
  function exportTableToExcel() {
    // Get the table element
    var table = document.getElementById("id_of_table");

    // Create a new workbook
    var wb = XLSX.utils.table_to_book(table, {sheet: "Sheet1"});

    // Export the workbook to an Excel file
    XLSX.writeFile(wb, "table.xlsx");
  }




    </script>

    <script>
           document.getElementById("Dashboard_li").classList.remove('active_menu')
        document.getElementById("Employees_li").classList.add('active_menu')
        document.getElementById("Attendance_li").classList.remove('active_menu')
        document.getElementById("Add_Employee_li").classList.remove('active_menu')
        document.getElementById("Super_Admin_Settings").classList.remove('active_menu')
        document.getElementById("Admin_Settings_li").classList.remove('active_menu')
        document.getElementById("HR_Settings_li").classList.remove('active_menu')





    </script>

    <!-- end main Dashboard -->



<style>

#pup_up{
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.37);
    position: fixed;
    top:0px;
    left:0px;
    width: 100%;
    height: 100%;
    display: none;
}
#pup_up_inner{
    width: 350px;
        height: 400px;
        display: flex;
        flex-direction: column;
        background: white;
        padding: 20px;
        border-radius: 10px;
}
.btn{
    width: 100%;
    padding: 10px;
    background: #202A44;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
.btn:hover{

    background: #131929;
    color: white;

}

</style>

<div id="pup_up" >
    <div id="pup_up_inner">


    <h4>Import Users </h4>
    <hr>
    <form action="{{ route('bulk_uoploade_request') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="csv_file" accept=".csv" required style="border: none">
        <br><br>
        <button type="submit" class="btn">Upload </button>
        <style>
            .cancle_btn:hover{
                color: rgb(255, 255, 255);
                background: red;
            }
        </style>
        <p onclick="window.location.href='{{url('/sample.csv')}}'" class="btn" style="background: #013220; margin-top: 20px ; padding:8px; border-radius: 4px; color:white; text-align: center">Download XLS Format</p>
        <p onclick="close_bulk_uplaode()" class="btn cancle_btn" style="background:  transparent; margin-top: 20px; border:1px solid red; color:red">Cancel</p>
    </form>
</div>

</div>
<script>
    function close_bulk_uplaode(){
        document.getElementById('pup_up').style.display= "none"
    }

    function open_bulk_uplaode(){
        document.getElementById('pup_up').style.display= "flex"
    }
</script>




@endsection







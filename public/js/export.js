 

    function show_hide_column(col_no, do_show) {
        const table = document.getElementById('id_of_table')
        const column = table.getElementsByTagName('col')[col_no]
        if (column) {
            column.style.visibility = do_show ? "" : "collapse";
        }
    }

    // const btnHide = document.getElementById('btnHide')
    // btnHide.addEventListener("click", () => show_hide_column(2, false))


   


var item_click_count = 1;
var name_item_click_count = 1;
var Employee_ID_item_click_count = 1;
var Mobile_Number_item_click_count = 1;
var Aadhar_Number_item_click_count = 1;
var Email_id_item_click_count = 1;
var Pan_Number_item_click_count = 1;
var Employee_Type_item_click_count = 1;

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
    }else{
        document.getElementById("show_hide_items_div").style.display="none";
        document.getElementById("Name_item").classList.remove("chose_item_active");
        item_click_count = 1;
        show_hide_column(1, false)

    }
    name_item_click_count++
}
function show_hide_Employee_ID(){
    if(Employee_ID_item_click_count % 2 == 0){
        document.getElementById("show_hide_items_div").style.display="none";
        document.getElementById("Employee_ID_item").classList.add("chose_item_active");
        show_hide_column(2, true)
        item_click_count = 1;
    }else{
        document.getElementById("show_hide_items_div").style.display="none";
        document.getElementById("Employee_ID_item").classList.remove("chose_item_active");
       
        show_hide_column(2, false)
        item_click_count = 1;

    }
    Employee_ID_item_click_count++
}
function show_hide_Mobile_Number(){
    if(Mobile_Number_item_click_count % 2 == 0){
        document.getElementById("show_hide_items_div").style.display="none";
        document.getElementById("Mobile_Number_item").classList.add("chose_item_active");
        show_hide_column(3, true)
        item_click_count = 1;
    }else{
        document.getElementById("show_hide_items_div").style.display="none";
        document.getElementById("Mobile_Number_item").classList.remove("chose_item_active");
        show_hide_column(3, false)
        item_click_count = 1;

    }
    Mobile_Number_item_click_count++
}

function show_hide_Aadhar_Number(){
    if(Aadhar_Number_item_click_count % 2 == 0){
        document.getElementById("show_hide_items_div").style.display="none";
        document.getElementById("Aadhar_Number_item").classList.add("chose_item_active");
        show_hide_column(4, true)
        item_click_count = 1;
    }else{
        document.getElementById("show_hide_items_div").style.display="none";
        document.getElementById("Aadhar_Number_item").classList.remove("chose_item_active");
        show_hide_column(4, false)
        item_click_count = 1;

    }
    Aadhar_Number_item_click_count++
}

function show_hide_Email_id(){
    if(Email_id_item_click_count % 2 == 0){
        document.getElementById("show_hide_items_div").style.display="none";
        document.getElementById("Email_id_item").classList.add("chose_item_active");
        show_hide_column(5, true)
        item_click_count = 1;
    }else{
        document.getElementById("show_hide_items_div").style.display="none";
        document.getElementById("Email_id_item").classList.remove("chose_item_active");
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
        item_click_count = 1;
    }else{
        document.getElementById("show_hide_items_div").style.display="none";
        document.getElementById("Pan_Number_item").classList.remove("chose_item_active");
        show_hide_column(6, false)
        item_click_count = 1;

    }
    Pan_Number_item_click_count++
}


function show_hide_Employee_Type(){
    if(Employee_Type_item_click_count % 2 == 0){
        document.getElementById("show_hide_items_div").style.display="none";
        document.getElementById("Employee_Type_item").classList.add("chose_item_active");
        show_hide_column(7, true)
        item_click_count = 1;
    }else{
        document.getElementById("show_hide_items_div").style.display="none";
        document.getElementById("Employee_Type_item").classList.remove("chose_item_active");
        show_hide_column(7, false)
        item_click_count = 1;

    }
    Employee_Type_item_click_count++
}
show_hide_Current_Address()
function show_hide_Current_Address(){
    if(Current_Address % 2 == 0){
        document.getElementById("show_hide_items_div").style.display="none";
        document.getElementById("Current_Address_item").classList.add("chose_item_active");
        show_hide_column(8, true)
        item_click_count = 1;
    }else{
        document.getElementById("show_hide_items_div").style.display="none";
        document.getElementById("Current_Address_item").classList.remove("chose_item_active");
        show_hide_column(8, false)
        item_click_count = 1;

    }
    Current_Address++
}
show_hide_Permanent_Address()
function show_hide_Permanent_Address(){
    if(Permanent_Address % 2 == 0){
        document.getElementById("show_hide_items_div").style.display="none";
        document.getElementById("Permanent_Address_item").classList.add("chose_item_active");
        show_hide_column(9, true)
        item_click_count = 1;
    }else{
        document.getElementById("show_hide_items_div").style.display="none";
        document.getElementById("Permanent_Address_item").classList.remove("chose_item_active");
        show_hide_column(9, false)
        item_click_count = 1;

    }
    Permanent_Address++
}
show_hide_Gender()
function show_hide_Gender(){
    if(Gender % 2 == 0){
        document.getElementById("show_hide_items_div").style.display="none";
        document.getElementById("Gender_item").classList.add("chose_item_active");
        show_hide_column(10, true)
        item_click_count = 1;
    }else{
        document.getElementById("show_hide_items_div").style.display="none";
        document.getElementById("Gender_item").classList.remove("chose_item_active");
        show_hide_column(10, false)
        item_click_count = 1;

    }
    Gender++
}
show_hide_Marital_Status()
function show_hide_Marital_Status(){
    if(Marital_Status % 2 == 0){
        document.getElementById("show_hide_items_div").style.display="none";
        document.getElementById("Marital_Status_item").classList.add("chose_item_active");
        show_hide_column(11, true)
        item_click_count = 1;
    }else{
        document.getElementById("show_hide_items_div").style.display="none";
        document.getElementById("Marital_Status_item").classList.remove("chose_item_active");
        show_hide_column(11, false)
        item_click_count = 1;

    }
    Marital_Status++
}
show_hide_DOJ()
function show_hide_DOJ(){
    if(DOJ % 2 == 0){
        document.getElementById("show_hide_items_div").style.display="none";
        document.getElementById("DOJ_item").classList.add("chose_item_active");
        show_hide_column(12, true)
        item_click_count = 1;
    }else{
        document.getElementById("show_hide_items_div").style.display="none";
        document.getElementById("DOJ_item").classList.remove("chose_item_active");
        show_hide_column(12, false)
        item_click_count = 1;

    }
    DOJ++
}
show_hide_Highest_Qualification()
function show_hide_Highest_Qualification(){
    if(Highest_Qualification % 2 == 0){
        document.getElementById("show_hide_items_div").style.display="none";
        document.getElementById("Highest_Qualification_item").classList.add("chose_item_active");
        show_hide_column(13, true)
        item_click_count = 1;
    }else{
        document.getElementById("show_hide_items_div").style.display="none";
        document.getElementById("Highest_Qualification_item").classList.remove("chose_item_active");
        show_hide_column(13, false)
        item_click_count = 1;

    }
    Highest_Qualification++
}
show_hide_Salary()
function show_hide_Salary(){
    if(Salary % 2 == 0){
        document.getElementById("show_hide_items_div").style.display="none";
        document.getElementById("Salary_item").classList.add("chose_item_active");
        show_hide_column(14, true)
        item_click_count = 1;
    }else{
        document.getElementById("show_hide_items_div").style.display="none";
        document.getElementById("Salary_item").classList.remove("chose_item_active");
        show_hide_column(14, false)
        item_click_count = 1;

    }
    Salary++
}
show_hide_Shift_Time()
function show_hide_Shift_Time(){
    if(Shift_Time % 2 == 0){
        document.getElementById("show_hide_items_div").style.display="none";
        document.getElementById("Shift_Time_item").classList.add("chose_item_active");
        show_hide_column(15, true)
        item_click_count = 1;
    }else{
        document.getElementById("show_hide_items_div").style.display="none";
        document.getElementById("Shift_Time_item").classList.remove("chose_item_active");
        show_hide_column(15, false)
        item_click_count = 1;

    }
    Shift_Time++
}





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





       document.getElementById("Dashboard_li").classList.remove('active_menu')
    document.getElementById("Employees_li").classList.add('active_menu')
    document.getElementById("Attendance_li").classList.remove('active_menu')
    document.getElementById("Add_Employee_li").classList.remove('active_menu')
    document.getElementById("Super_Admin_Settings").classList.remove('active_menu')
    document.getElementById("Admin_Settings_li").classList.remove('active_menu')
    document.getElementById("HR_Settings_li").classList.remove('active_menu')

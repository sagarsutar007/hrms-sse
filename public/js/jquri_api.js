$(function() {
    $("#search_btn").on("click", function(event) {
        event.preventDefault(); // Prevent the link's default action
        // Perform your custom logic
        serch_on_key_presh() 
    });
 var attandence_Date = '1';
 var   att_id ;
    $.ajax({
  url: "{{url('/get-attandence-data-api')}}",  // API endpoint URL
  type: "GET",  // HTTP method, e.g., GET, POST, PUT, DELETE
  dataType: "json",

  headers: {
    // "Authorization": "Bearer YOUR_ACCESS_TOKEN",  // Add headers if needed
    "Content-Type": "application/json"
  },
  success: function(response) {
  //  console.log("Response:", response);  // Handle the successful response here
    $("#result").empty();
   var count_flag = 1;
   var all_data = response.data;
   var all_attendance = response.attendance_data;
   var table_html_data =` `
$("#result").append("<p> "+ table_html_data +"</p>");
  },
  error: function(xhr, status, error) {
    console.error("Error:", error);  // Handle the error here
  }
});

});
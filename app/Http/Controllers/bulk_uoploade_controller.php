<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class bulk_uoploade_controller extends Controller
{
    public function bulk_uoploade_view() {
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');

        
        if(isset( $EmployeesID)){
         return view("bulk_uploade")
        
         ->with('role',$role);
        
        }else{
          return redirect()->route('login');
        }
    }
    public function bulk_uoploade_request(Request $request) {

         // Validate the request (ensure the file is uploaded and it's a CSV file)
         $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048',
        ]);

        // Handle the uploaded file
        $file = $request->file('csv_file');
        $filePath = $file->getRealPath(); // Get the temporary file path

        // Open the file and read its contents
        $dataArray = [];
        if (($handle = fopen($filePath, 'r')) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $dataArray[] = $data; // Store each row in the array
            }
            fclose($handle); // Close the file after reading
        }
// print_r($dataArray);
$import_data = array();
 $arr_main_count =   count($dataArray) ;
for ($x = 1; $x < $arr_main_count; $x++) {
    $innerarray = $dataArray[$x];
    $inner_array_count =   count($innerarray) ;
    $row_data = array();
    for ($y = 0; $y < $inner_array_count; $y++) {
        
        if($y == 0)
        {
            $row_data["f_name"] = $innerarray[0];
        }
        if($y == 1)
        {
            $row_data["m_name"] = $innerarray[1];
        }
        if($y == 2)
        {
            $row_data["l_name"] = $innerarray[2];
        }
        if($y == 3)
        {
            $row_data["Employee_id"] = $innerarray[3];
        }
        if($y == 4)
        {
            $row_data["pan_number"] = $innerarray[4];
        }
        if($y == 5)
        {
            $row_data["email"] = $innerarray[5];
        }
        if($y == 6)
        {
            $row_data["voter_id_number"] = $innerarray[6];
        }
        if($y == 7)
        {
            $row_data["aadhaar_number"] = $innerarray[7];
        }
        if($y == 8)
        {
            $row_data["mobile_number"] = $innerarray[8];
        }
        if($y == 9)
        {
            $row_data["password"] = $innerarray[9];
        }
        if($y == 10)
        {
            $row_data["dob"] = $innerarray[10];
        }
        if($y == 11)
        {
            $row_data["current_address"] = $innerarray[11];
        }
        if($y == 12)
        {
            $row_data["permanent_address"] = $innerarray[12];
        }
        if($y == 13)
        {
            $row_data["gender"] = $innerarray[13];
        }
        if($y == 14)
        {
            $row_data["photo_name"] = $innerarray[14];
        }
        if($y == 15)
        {
            $row_data["marital_status"] = $innerarray[15];
        }
        if($y == 16)
        {
            $row_data["ration_card_number"] = $innerarray[16];
        }
        if($y == 17)
        {
            $row_data["DOJ"] = $innerarray[17];
        }
        if($y == 18)
        {
            $row_data["highest_qualification"] = $innerarray[18];
        }
        if($y == 19)
        {
            $row_data["salary"] = $innerarray[19];
        }

        if($y == 20)
        {
            $row_data["shift_time"] = $innerarray[20];
        }

        if($y == 21)
        {
            $row_data["employee_type"] = $innerarray[21];
        }
        if($y == 22)
        {
            $row_data["role"] = $innerarray[22];
        }
        if($y == 23)
        {
            $row_data["QR_Code"] = $innerarray[23];
        }
        if($y == 24)
        {
            $row_data["termination_date"] = $innerarray[24];
        }
        if($y == 25)
        {
            $row_data["reason_of_termination"] = $innerarray[25];
        }
        if($y == 26)
        {
            $row_data["created_by"] = $innerarray[26];
        }
        if($y == 27)
        {
            $row_data["updated_by"] = $innerarray[27];
        }
        if($y == 28)
        {
            $row_data["created_at"] = $innerarray[28];
        }
        if($y == 29)
        {
            $row_data["updated_at"] = $innerarray[29];
        }
        if($y ==  30)
        {
            $row_data["can_login"] = $innerarray[30];
        }
        
    }

    
    array_push($import_data,$row_data);

}
$users = DB::table('all_users')
->insertOrIgnore($import_data);
if($users){
?>
<script>
alert('Data Inserted')
history.back();
</script>
<?php


   
}else{
    ?>
<script>
alert('Sorry Data Not Inserted')
history.back();
</script>
<?php
   
}


//       $arr_main_count =   count($dataArray);
     
//       for ($x = 3; $x < $arr_main_count; $x++) {
//         $inner_array_count = $dataArray[$x];
   
//         for ($y = 0; $y < $inner_array_count; $y++) {
// echo $dataArray[$x][$y];
//         }


//       }

        // Print the array or process it further
       //return response()->json($dataArray);



    }
}
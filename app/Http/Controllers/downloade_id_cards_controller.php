<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class downloade_id_cards_controller extends Controller
{
    public function downloade_Id_cards() {
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');

        
        if(isset( $EmployeesID)){
       //payslip
      $user_data = DB::table('all_users')
      ->join('role_masrer', 'role_masrer.id', '=', 'all_users.Role')
      ->select('all_users.*', 'role_masrer.roles' )
      ->where('all_users.role' , '>', 1 )
      ->get();
         return view("downloade_Id_cards")
         ->with('user_data',$user_data)
         ->with('role',$role);
        }else{
          return redirect()->route('login');
        }
    }



    public function dounloade_user_id_catd(Request $req){
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');
      if(isset( $EmployeesID)){
     //payslip
    $user_data = DB::table('all_users')
    ->join('role_masrer', 'role_masrer.id', '=', 'all_users.Role')
      ->select('all_users.*', 'role_masrer.roles' )
    ->where('all_users.id',$req->id)
    ->get();
       return view("dounloade_user_id_catd")
       ->with('user_data',$user_data)
       ->with('role',$role);
      }else{
        return redirect()->route('login');
      }
    }


    

    public function attendance_response(Request $req){
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');
      if(isset( $EmployeesID)){
     //payslip
    $user_data = DB::table('all_users')
    ->join('role_masrer', 'role_masrer.id', '=', 'all_users.Role')
      ->select('all_users.*', 'role_masrer.roles' )
    ->where('all_users.Employee_id',$req->id)
    ->get();
      $response_message = '';
      $color_name = "black";
      $att_date = now()->toDateString();
      $all_attendance_data = DB::table('attendance_info')
      ->where('Employee_id',$req->id)
      ->where('attendance_Date', $att_date)
      ->get();

      if($all_attendance_data){
        $all_attendance_count = count($all_attendance_data);
         
        if($all_attendance_count %2 == 0){

          $response_message = 'Punch Out Ok';
         $color_name = "red";


       
        }else{
          $response_message = 'Punch In Ok';
          $color_name = "Green";
        }
      }
       return view("attendance_response")
       ->with('user_data',$user_data)
       ->with('response_message',$response_message)
       ->with('color_name',$color_name)
       ->with('role',$role);
      }else{
        return redirect()->route('login');
      }
    }




    public function limit_for_daownload_id(Request $req) {
      $search_input = $req->search_input;
          $EmployeesID = session()->get('EmployeeID');
          $role = session()->get('role');
          $employee_ids = array_map('trim', explode(',', $search_input));

          // Check if the count of Employee IDs is greater than 2
        
          if (isset($EmployeesID)) {
            if (count($employee_ids) > 1) {
    // Call your function or perform the desired action
    $user_data = DB::table('all_users')
    ->join('role_masrer', 'role_masrer.id', '=', 'all_users.Role')
    ->select('all_users.*', 'role_masrer.roles')
    ->whereIn('all_users.Employee_id', $employee_ids)
    ->get();

if ($user_data->isNotEmpty()) {
    return view("downloade_Id_cards")
        ->with('user_data', $user_data)
        ->with('role', $role);
} else {
    ?>
<script>
alert('Data not found');
history.back();
</script>
<?php
}
            }else{
              // Perform the search
              $user_data = DB::table('all_users')
                  ->join('role_masrer', 'role_masrer.id', '=', 'all_users.Role')
                  ->select('all_users.*', 'role_masrer.roles')
                  ->where(DB::raw("CONCAT(all_users.f_name, '', all_users.m_name, ' ', all_users.l_name)"), 'like', '%' . $search_input . '%')
                  ->orWhere('all_users.email', 'like', '%' . $search_input . '%')
                  ->orWhere('all_users.Employee_id', 'like', '%' . $search_input . '%')
                  ->orWhere('all_users.mobile_number', 'like', '%' . $search_input . '%')
                  ->orWhere('all_users.aadhaar_number', 'like', '%' . $search_input . '%')
                  ->orWhere('all_users.pan_number', 'like', '%' . $search_input . '%')
                  ->orWhere('all_users.dob', 'like', '%' . $search_input . '%')
                  ->orWhere('all_users.shift_time', 'like', '%' . $search_input . '%')
                  ->orWhere('all_users.employee_type', 'like', '%' . $search_input . '%')
                  ->orWhere('all_users.DOJ', 'like', '%' . $search_input . '%')
                  ->orWhere('role_masrer.roles', 'like', '%' . $search_input . '%')
                  
                  ->get();
      
              if ($user_data->isNotEmpty()) {
                  return view("downloade_Id_cards")
                      ->with('user_data', $user_data)
                      ->with('role', $role);
              } else {
                  ?>
<script>
alert('Data not found');
history.back();
</script>
<?php
              }
            }
          } else {
              return redirect()->route('login');
          }
          
        }




        public function downloade_selected_id_cards(Request $req) {
          $search_input = $req->search_input;
              $EmployeesID = session()->get('EmployeeID');
              $role = session()->get('role');
              $employee_ids = array_map('trim', explode(',', $search_input));
    
              // Check if the count of Employee IDs is greater than 2
            
              if (isset($EmployeesID)) {
                if (count($employee_ids) > 1) {
        // Call your function or perform the desired action
        $user_data = DB::table('all_users')
        ->join('role_masrer', 'role_masrer.id', '=', 'all_users.Role')
        ->select('all_users.*', 'role_masrer.roles')
        ->whereIn('all_users.Employee_id', $employee_ids)
        ->get();
    
    if ($user_data->isNotEmpty()) {
        return view("downloade_Id_cards")
            ->with('user_data', $user_data)
            ->with('role', $role);
    } else {
        ?>
<script>
alert('Data not found');
history.back();
</script>
<?php
    }
  }

              } else {
                  return redirect()->route('login');
              }
              
            }
    



 
    

    
}
<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class update_all_controller extends Controller
{

//viwe

//ticket_info
public function view_ticket(Request $req) {
  $EmployeesID = session()->get('EmployeeID');
  $role = session()->get('role');
  if(isset( $EmployeesID)){
    $emp_type_Data = DB::table('ticket_info')
    ->where('id',$req->id)
    ->get();
    return view("view_ticket")
    ->with('emp_type_Data', $emp_type_Data)
  ->with('role',$role);
  }else{
  return redirect()->route('login');
  }
  
  }
  
//view_transfer
public function view_transfer (Request $req) {
  $EmployeesID = session()->get('EmployeeID');
  $role = session()->get('role');
  if(isset( $EmployeesID)){
    $emp_type_Data = DB::table('transfer_info')
    ->where('id',$req->id)
    ->get();
    return view("view_transfer")
    ->with('emp_type_Data', $emp_type_Data)
  ->with('role',$role);
  }else{
  return redirect()->route('login');
  }
  
  }

  //view_promotion
public function view_promotion (Request $req) {
  $EmployeesID = session()->get('EmployeeID');
  $role = session()->get('role');
  if(isset( $EmployeesID)){
    $emp_type_Data = DB::table('_promotion')
    ->where('id',$req->id)
    ->get();
    return view("view_promotion")
    ->with('emp_type_Data', $emp_type_Data)
  ->with('role',$role);
  }else{
  return redirect()->route('login');
  }
  
  }

    //view_complaints
public function view_complaints (Request $req) {
  $EmployeesID = session()->get('EmployeeID');
  $role = session()->get('role');
  if(isset( $EmployeesID)){
    $emp_type_Data = DB::table('complaints')
    ->where('id',$req->id)
    ->get();
    return view("view_complaints")
    ->with('emp_type_Data', $emp_type_Data)
  ->with('role',$role);
  }else{
  return redirect()->route('login');
  }
  
  }

     //view_warning
public function view_warning (Request $req) {
  $EmployeesID = session()->get('EmployeeID');
  $role = session()->get('role');
  if(isset( $EmployeesID)){
    $emp_type_Data = DB::table('warning')
    ->where('id',$req->id)
    ->get();
    return view("view_warning")
    ->with('emp_type_Data', $emp_type_Data)
  ->with('role',$role);
  }else{
  return redirect()->route('login');
  }
  
  }

//view_projects
public function view_projects (Request $req) {
  $EmployeesID = session()->get('EmployeeID');
  $role = session()->get('role');
  if(isset( $EmployeesID)){
    $emp_type_Data = DB::table('projects')
    ->where('id',$req->id)
    ->get();
    return view("view_projects")
    ->with('emp_type_Data', $emp_type_Data)
  ->with('role',$role);
  }else{
  return redirect()->route('login');
  }
  
  }

  //view_tasks
public function view_tasks (Request $req) {
  $EmployeesID = session()->get('EmployeeID');
  $role = session()->get('role');
  if(isset( $EmployeesID)){
    $emp_type_Data = DB::table('tasks')
    ->where('id',$req->id)
    ->get();
    return view("view_tasks")
    ->with('emp_type_Data', $emp_type_Data)
  ->with('role',$role);
  }else{
  return redirect()->route('login');
  }
  
  }

    //view_payslip
public function view_payslip (Request $req) {
  $EmployeesID = session()->get('EmployeeID');
  $role = session()->get('role');
  if(isset( $EmployeesID)){
    $emp_type_Data = DB::table('payslip')
    ->where('id',$req->id)
    ->get();
    return view("view_payslip")
    ->with('emp_type_Data', $emp_type_Data)
  ->with('role',$role);
  }else{
  return redirect()->route('login');
  }
  
  }


    // edit_leave
public function edit_leave (Request $req) {
    $EmployeesID = session()->get('EmployeeID');
    $role = session()->get('role');
    if(isset( $EmployeesID)){
      $emp_type_Data = DB::table('_leave')
      ->where('id',$req->id)
      ->get();
      return view("edit_leave")
      ->with('emp_type_Data', $emp_type_Data)
    ->with('role',$role);
    }else{
    return redirect()->route('login');
    }
    
    }

    // edit_award
    public function edit_award (Request $req) {
    $EmployeesID = session()->get('EmployeeID');
    $role = session()->get('role');
    if(isset( $EmployeesID)){


      $emp_type_Data = DB::table('award_info')
      ->where('id',$req->id)
      ->get();
      return view("edit_award")
      ->with('emp_type_Data', $emp_type_Data)
    ->with('role',$role);
    
  
    }else{
    return redirect()->route('login');
    }
    }
    //edit_Other_Payment
    public function edit_Other_Payment (Request $req) {
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');
      if(isset( $EmployeesID)){
  

        $emp_type_Data = DB::table('other_payments')
        ->where('id',$req->id)
        ->get();
        return view("edit_other_paymrnt")
        ->with('emp_type_Data', $emp_type_Data)
      ->with('role',$role);
      
    
      }else{
      return redirect()->route('login');
      }
      }

    


    // edit_travel
    public function edit_travel (Request $req) {
    $EmployeesID = session()->get('EmployeeID');
    $role = session()->get('role');
    if(isset( $EmployeesID)){
      $emp_type_Data = DB::table('travel_info')
      ->where('id',$req->id)
      ->get();
      return view("edit_travel")
      ->with('emp_type_Data', $emp_type_Data)
    ->with('role',$role);




    
    
    }else{
    return redirect()->route('login');
    }
    }

    // edit_training
    public function edit_training (Request $req) {
    $EmployeesID = session()->get('EmployeeID');
    $role = session()->get('role');
    if(isset( $EmployeesID)){
      $emp_type_Data = DB::table('training_info')
      ->where('id',$req->id)
      ->get();
      return view("edit_training")
      ->with('emp_type_Data', $emp_type_Data)
    ->with('role',$role);



    
   
    }else{
    return redirect()->route('login');
    }
    }

    // edit_ticket
    public function edit_ticket(Request $req) {
    $EmployeesID = session()->get('EmployeeID');
    $role = session()->get('role');
    if(isset( $EmployeesID)){

      $emp_type_Data = DB::table('ticket_info')
      ->where('id',$req->id)
      ->get();
      return view("edit_ticket")
      ->with('emp_type_Data', $emp_type_Data)
    ->with('role',$role);


    
   
    }else{
    return redirect()->route('login');
    }
    }

    // edit_transfer
    public function edit_transfer(Request $req) {
    $EmployeesID = session()->get('EmployeeID');
    $role = session()->get('role');
    if(isset( $EmployeesID)){
      $emp_type_Data = DB::table('transfer_info')
      ->where('id',$req->id)
      ->get();
      return view("edit_transfer")
      ->with('emp_type_Data', $emp_type_Data)
    ->with('role',$role);


    
    
    }else{
    return redirect()->route('login');
    }
    }

    // edit_promotion
    public function edit_promotion(Request $req) {
    $EmployeesID = session()->get('EmployeeID');
    $role = session()->get('role');
    if(isset( $EmployeesID)){
      $emp_type_Data = DB::table('_promotion')
      ->where('id',$req->id)
      ->get();
      return view("edit_promotion")
      ->with('emp_type_Data', $emp_type_Data)
    ->with('role',$role);



    
    
    }else{
    return redirect()->route('login');
    }
    }

    // edit_complaints
    public function edit_complaints(Request $req) {
    $EmployeesID = session()->get('EmployeeID');
    $role = session()->get('role');
    if(isset( $EmployeesID)){
      $emp_type_Data = DB::table('complaints')
      ->where('id',$req->id)
      ->get();
      return view("edit_complaints")
      ->with('emp_type_Data', $emp_type_Data)
    ->with('role',$role);



    
 
    }else{
    return redirect()->route('login');
    }
    }

    // edit_warning
    public function edit_warning(Request $req) {
    $EmployeesID = session()->get('EmployeeID');
    $role = session()->get('role');
    if(isset( $EmployeesID)){
      $emp_type_Data = DB::table('warning')
      ->where('id',$req->id)
      ->get();
      return view("edit_warning")
      ->with('emp_type_Data', $emp_type_Data)
    ->with('role',$role);



    
    
    }else{
    return redirect()->route('login');
    }
    }

    // edit_projects
    public function edit_projects(Request $req) {
    $EmployeesID = session()->get('EmployeeID');
    $role = session()->get('role');
    if(isset( $EmployeesID)){
      $emp_type_Data = DB::table('projects')
      ->where('id',$req->id)
      ->get();
      return view("edit_projects")
      ->with('emp_type_Data', $emp_type_Data)
    ->with('role',$role);



    
   
    }else{
    return redirect()->route('login');
    }
    }

    // edit_tasks
    public function edit_tasks(Request $req) {
    $EmployeesID = session()->get('EmployeeID');
    $role = session()->get('role');
    if(isset( $EmployeesID)){
      $emp_type_Data = DB::table('tasks')
      ->where('id',$req->id)
      ->get();
      return view("edit_tasks")
      ->with('emp_type_Data', $emp_type_Data)
    ->with('role',$role);



   
    
    }else{
    return redirect()->route('login');
    }
    }

    // edit_payslip
    public function edit_payslip(Request $req) {
    $EmployeesID = session()->get('EmployeeID');
    $role = session()->get('role');
    if(isset( $EmployeesID)){
      $emp_type_Data = DB::table('payslip')
      ->where('id',$req->id)
      ->get();
      return view("edit_payslip")
      ->with('emp_type_Data', $emp_type_Data)
    ->with('role',$role);



  
    }else{
    return redirect()->route('login');
    }
    }

    public function edit_attendance(Request $req) {
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');
      
      if (isset($EmployeesID)) {
          $emp_type_Data = DB::table('attendance_info')
              ->where('id', $req->id)
              ->get();
          
          // Return the data as a JSON response
          return response()->json([
              'emp_type_Data' => $emp_type_Data,
              'role' => $role,
          ]);
      } else {
          return response()->json([
              'error' => 'Unauthorized',
              'message' => 'Please log in.',
          ], 401); // HTTP status 401 for unauthorized
      }
  }
  

      // edit_qualifications
      public function edit_qualification(Request $req) {
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
        if(isset( $EmployeesID)){
          $emp_type_Data = DB::table('_qualifications')
          ->where('id',$req->id)
          ->get();
          return view("edit_qualification")
          ->with('emp_type_Data', $emp_type_Data)
        ->with('role',$role);
        }else{
        return redirect()->route('login');
        }
        }

        //edit_attamdance_data
        public function edit_attamdance_data(Request $req) {
          $EmployeesID = session()->get('EmployeeID');
          $role = session()->get('role');
          if(isset( $EmployeesID)){
            $emp_type_Data = DB::table('all_attandencetable')
            ->where('Employee_id',$req->id)
            ->where('created_at', '>=', date('Y-m-d').' 00:00:00')
            ->get();
            return view("edit_attamdance_data")
            ->with('emp_type_Data', $emp_type_Data)
          ->with('role',$role);
          }else{
          return redirect()->route('login');
          }
          }

          public function update_attamdance_data(Request $req)
          {
           
               
                    // Update in-time
                    $update_in_time = DB::table('attendance_info')
                        ->where('id', $req->in_time_id)
                        ->update([
                            'attendance_time' => $req->in_time,
                        ]);
                        if($req->out_time_id == $req->in_time_id){
                        $insert_attendanceQrey=DB::table('attendance_info')
                        ->insertOrIgnore([
                            'Employee_id'=>$req->Employee_id,
                            'attendance_time' => $req->out_time,
                            'attendance_Date'=>$req->attendance_date,
                            'created_by'=>1,
                            'updated_by'=>1,
                            'created_at'=>now(),
                            'updated_at'=>now()
                  
                         ]);
if($insert_attendanceQrey){
  $update_in_time2 = 1;
}else{
  $update_in_time2 = 0;
}



                        }else{
                        $update_in_time2 = DB::table('attendance_info')
                        ->where('id', $req->out_time_id)
                        ->update([
                            'attendance_time' => $req->out_time,
                        ]);

                        }



                        // $insert_attendanceQrey=DB::table('attendance_info')
                        // ->insertOrIgnore([
                        //     'Employee_id'=>$Employee_id,
                        //     'attendance_time' => $req->out_time,
                        //     'attendance_Date'=>now()->toDateString(),
                        //     'created_by'=>$Inserter_id,
                        //     'updated_by'=>$Inserter_id,
                        //     'created_at'=>now(),
                        //     'updated_at'=>now()
                  
                        // ]);


                        $update =    $update_in_time .$update_in_time2 ;

                       // Determine the message based on the update results
if ($update == "01") {
    $message = "Out Time Updated";
} else if ($update == "10") {
    $message = "In Time Updated";
} else if ($update == "11") {
    $message = "Attendance Updated";
} else if ($update == "00") {
    $message = "Attendance Not Updated";
} else {
    $message = "Unexpected Error";
}
// Output JavaScript for alert and history back
$url = url('/all-attendance');
return redirect($url);
}
          


    
    // update_leave
    public function update_leave(Request $req) {
    $EmployeesID = session()->get('EmployeeID');
    $role = session()->get('role');
    if(isset( $EmployeesID)){

      if($req->half_day == ""){
        $half_day = "0";
      }else{
        $half_day = $req->half_day;
      }
    $update_emp_tyoe = DB::table('_leave')
    ->where('id', $req->id)
    ->update( [
    'Leave_Type' =>$req->Leave_Type,
    'Start_Date' =>$req->Start_Date,
    'End_Date' =>$req->End_Date,
    'Description' =>$req->Description,
    'Remarks_by_Approve' =>$req->Remarks_by_Approver,
    'Status' =>$req->status,
    'Half_Day' => $half_day,

    'Total_Days' =>$req->Total_Days,
    'updated_by' =>$EmployeesID,
    'updated_at' => now(),
    ]);
    
    
    if($update_emp_tyoe){
    ?>
<script>
alert("data updated");
history.back();
</script>
<?php
          }else{
            ?>
<script>
alert("data not updated");
history.back();
</script>
<?php
          }
         }else{
           return redirect()->route('login');
         }
    }


    // update_award
    public function update_award(Request $req) {
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
      
       
        if(isset( $EmployeesID)){
          $update_emp_tyoe = DB::table('award_info') 
          ->where('id', $req->id) 
           ->update( [ 
           'Award_Name' =>$req->Award_Name, 
           'Gift' =>$req->Gift, 
           'Award_date' =>$req->Award_Date, 
           'Award_by' =>$req->Awarded_BY, 
           'updated_by' =>$EmployeesID, 
           'updated_at' => now(), 
          ]); 
      
      
          if($update_emp_tyoe){
            ?>
<script>
alert("data updated");
history.back();
</script>
<?php
          }else{
            ?>
<script>
alert("data not updated");
history.back();
</script>
<?php
          }
         }else{
           return redirect()->route('login');
         }
    }

  
    // update_travel
    public function update_travel(Request $req) {
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
      
       
        if(isset( $EmployeesID)){
          $update_emp_tyoe = DB::table('travel_info') 
          ->where('id', $req->id) 
           ->update( [ 
           'Summary' =>$req->Summary, 
           'Place_Of_Visit' =>$req->Place_Of_Visit, 
           'Travel_start_date' =>$req->Start_Date, 
           'Travel_end_date' =>$req->End_Date, 
           
           'updated_by' =>$EmployeesID, 
           'updated_at' => now(), 
          ]); 
      
      
          if($update_emp_tyoe){
            ?>
<script>
alert("data updated");
history.back();
</script>
<?php
          }else{
            ?>
<script>
alert("data not updated");
history.back();
</script>
<?php
          }
         }else{
           return redirect()->route('login');
         }
    }

    // update_training
    public function update_training(Request $req) {
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
      
       
        if(isset( $EmployeesID)){
          $update_emp_tyoe = DB::table('training_info') 
          ->where('id', $req->id) 
           ->update( [ 
           'Training_Typ' =>$req->Training_Type, 
           'Trainer' =>$req->Trainer, 
           'Training_start_date' => $req->Start_Date, 
           'Training_end_date' => $req->End_Date, 
           'updated_by' =>$EmployeesID, 
           'updated_at' => now(), 
          ]); 
      
      
          if($update_emp_tyoe){
            ?>
<script>
alert("data updated");
history.back();
</script>
<?php
          }else{
            ?>
<script>
alert("data not updated");
history.back();
</script>
<?php
          }
         }else{
           return redirect()->route('login');
         }
    }


    // update_ticket
    public function update_ticket(Request $req) {
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
      
       
        if(isset( $EmployeesID)){
          $update_emp_tyoe = DB::table('ticket_info') 
          ->where('id', $req->id) 
           ->update( [ 
           'Ticket_Details' =>$req->Ticket_Details, 
           'Subject' =>$req->Subject, 
           'Priority' => $req->Priority, 
           'Date' => $req->Date, 
           'updated_by' =>$EmployeesID, 
           'updated_at' => now(), 
          ]); 
      
      
          if($update_emp_tyoe){
            ?>
<script>
alert("data updated");
history.back();
</script>
<?php
          }else{
            ?>
<script>
alert("data not updated");
history.back();
</script>
<?php
          }
         }else{
           return redirect()->route('login');
         }
    }


    // update_transfer
    public function update_transfer(Request $req) {
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
        if(isset( $EmployeesID)){
          $update_emp_tyoe = DB::table('transfer_info') 
          ->where('id', $req->id) 
           ->update( [ 
           'From_Department' =>$req->From_Department, 
           'To_Department' =>$req->To_Department, 
           'Company' => $req->Company, 
           'Date' => $req->Date, 
           'updated_by' =>$EmployeesID, 
           'updated_at' => now(), 
          ]); 
      
      
          if($update_emp_tyoe){
            ?>
<script>
alert("data updated");
history.back();
</script>
<?php
          }else{
            ?>
<script>
alert("data not updated");
history.back();
</script>
<?php
          }
         }else{
           return redirect()->route('login');
         }
    }

    // update_promotion
    public function update_promotion(Request $req) {
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
      
       
        if(isset( $EmployeesID)){
          $update_emp_tyoe = DB::table('_promotion') 
          ->where('id', $req->id) 
           ->update( [ 
           'Promotion_titel' =>$req->Promotion_titel, 
           'promated_by' =>$req->Promated_BY, 
           'Promotion_Date' => $req->Date, 
           'updated_by' =>$EmployeesID, 
           'updated_at' => now(), 
          ]); 
      
      
          if($update_emp_tyoe){
            ?>
<script>
alert("data updated");
history.back();
</script>
<?php
          }else{
            ?>
<script>
alert("data not updated");
history.back();
</script>
<?php
          }
         }else{
           return redirect()->route('login');
         }
    }


    // update_complaints
    public function update_complaints(Request $req) {
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
      
       
        if(isset( $EmployeesID)){
          $update_emp_tyoe = DB::table('complaints') 
          ->where('id', $req->id) 
           ->update( [ 
           'Complaint_From' =>$req->Complaint_From, 
           'Complaint_To' =>$req->Complaint_To, 
           'Complaint_Title' => $req->Complaint_Title, 
           'Complaint_Date' => $req->Date, 
           'updated_by' =>$EmployeesID, 
           'updated_at' => now(), 
          ]); 
      
      
          if($update_emp_tyoe){
            ?>
<script>
alert("data updated");
history.back();
</script>
<?php
          }else{
            ?>
<script>
alert("data not updated");
history.back();
</script>
<?php
          }
         }else{
           return redirect()->route('login');
         }
    }

    // update_warning
    public function update_warning(Request $req) {
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
      
       
        if(isset( $EmployeesID)){
          $update_emp_tyoe = DB::table('warning') 
          ->where('id', $req->id) 
           ->update( [ 
           'Subject' =>$req->Subject, 
           'Status' =>$req->status, 
           'warning_Date' => $req->date, 
           'updated_by' =>$EmployeesID, 
           'updated_at' => now(), 
          ]); 
      
      
          if($update_emp_tyoe){
            ?>
<script>
alert("data updated");
history.back();
</script>
<?php
          }else{
            ?>
<script>
alert("data not updated");
history.back();
</script>
<?php
          }
         }else{
           return redirect()->route('login');
         }
    }

    // 
     // update_tasks
     public function update_tasks(Request $req) {
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');
      if(isset( $EmployeesID)){
        $update_emp_tyoe = DB::table('tasks') 
        ->where('id', $req->id) 
         ->update( [ 
          'Tasks_Title' =>$req->Task_Title, 
         'Start_date' =>$req->Start_Date, 
          'End_date' => $req->End_Date, 
          'Status' => $req->status, 
         'Assigned_Employees' => $req->Assigned_Employees, 
          'task_Progress' => $req->task_Progress, 
         'updated_by' =>$EmployeesID, 
         'updated_at' => now(), 
        ]); 
    
    
        if($update_emp_tyoe){
          ?>
<script>
alert("data updated");
history.back();
</script>
<?php
        }else{
          ?>
<script>
alert("data not updated");
history.back();
</script>
<?php
        }
       }else{
         return redirect()->route('login');
       }
  }





    // update_projects
    public function update_projects(Request $req) {
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
        if(isset( $EmployeesID)){
          $update_emp_tyoe = DB::table('projects') 
          ->where('id', $req->id) 
           ->update( [ 
           'Project_Summary' =>$req->Project_Summary, 
           'Priority' =>$req->Project_Progress, 
           'Assigned_Employees' => $req->Assigned_Employees, 
           'Client' => $req->Client, 
           'End_Date' => $req->Date, 
           'Project_Progress' => $req->Project_Progress, 
           'updated_by' =>$EmployeesID, 
           'updated_at' => now(), 
          ]); 
      
      
          if($update_emp_tyoe){
            ?>
<script>
alert("data updated");
history.back();
</script>
<?php
          }else{
            ?>
<script>
alert("data not updated");
history.back();
</script>
<?php
          }
         }else{
           return redirect()->route('login');
         }
    }


    // update_payslip
    public function update_payslip(Request $req) {
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
      
       
        if(isset( $EmployeesID)){
          $update_emp_tyoe = DB::table('payslip') 
          ->where('id', $req->id) 
           ->update( [ 
           'Net_Salarye' =>$req->Net_Salary, 
           'Salary_Month' =>$req->Salary_Month, 
           'Payroll_Date' => $req->Salary_Date, 
           'Status' => $req->status, 
           'updated_by' =>$EmployeesID, 
           'updated_at' => now(), 
          ]); 
      
      
          if($update_emp_tyoe){
            ?>
<script>
alert("data updated");
history.back();
</script>
<?php
          }else{
            ?>
<script>
alert("data not updated");
history.back();
</script>
<?php
          }
         }else{
           return redirect()->route('login');
         }
    }


     // update qualification
     public function update_qualification(Request $req) {
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');
    
     
      if(isset( $EmployeesID)){
        $update_emp_tyoe = DB::table('_qualifications') 
        ->where('id', $req->id) 
         ->update( [ 
         'School_University' =>$req->School_University, 
         'Education_Level' =>$req->Education_Level, 
         'From' => $req->section_start, 
         'to' => $req->section_end, 
         'Language' => $req->section_Language, 
         'Professional_Skills' => $req->Professional_Skills, 
         'updated_by' =>$EmployeesID, 
         'updated_at' => now(), 
        ]); 
    
    
        if($update_emp_tyoe){
          ?>
<script>
alert("data updated");
history.back();
</script>
<?php
        }else{
          ?>
<script>
alert("data not updated");
history.back();
</script>
<?php
        }
       }else{
         return redirect()->route('login');
       }
  }

    public function update_attendance(Request $req) {
    $EmployeesID = session()->get('EmployeeID');
    $role = session()->get('role');

    if (isset($EmployeesID)) {
        // Update the attendance record
        $update_emp_type = DB::table('attendance_info')
            ->where('id', $req->id)
            ->update([
                'updated_by' => $EmployeesID,
                'attendance_Date' => $req->date,
                'attendance_time' => $req->Time,
                'updated_at' => now(),
            ]);

        // Return a JSON response based on the update result
        if ($update_emp_type) {
            return response()->json([
                'success' => true,
                'message' => 'Attendance data updated successfully.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update attendance data.',
            ]);
        }
    } else {
        // Return a JSON response for unauthorized access
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized access. Please log in.',
        ], 401);
    }
}



    public function view_attendance(Request $req) {
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');
      if(isset($EmployeesID)){
        $emp_type_Data = DB::table('attendance_info')
        ->where('id',$req->id)
        ->get();
        return view("attandence_view")
        ->with('emp_type_Data', $emp_type_Data)
      ->with('role',$role);
      }else{
        return redirect()->route('login');
      }
    }


}
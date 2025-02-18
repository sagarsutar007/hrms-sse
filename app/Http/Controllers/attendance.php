<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
date_default_timezone_set("Asia/Kolkata");

class attendance extends Controller
{
    public function insert_attendance(Request $atte)
    {
        $Employee_id =  $atte->employee_id;
        $Inserter_id =  $atte->inserter_id;

        if(isset($Employee_id) && $Inserter_id){

            try { 
                $insert_attendanceQrey=DB::table('attendance_info')
                ->insertOrIgnore([
                    'Employee_id'=>$Employee_id,
                    'attendance_time'=>now()->toTimeString(),
                    'attendance_Date'=>now()->toDateString(),
                    'created_by'=>$Inserter_id,
                    'updated_by'=>$Inserter_id,
                    'created_at'=>now(),
                    'updated_at'=>now()
          
                ]);
                if(isset($insert_attendanceQrey)){
                   
                      $retur = url("/")."/attendance-response/". $Employee_id ;
                      return redirect($retur) ;
                      $arr = array(
                        'result' => $Employee_id . ' Attendance added Successfully',  
                      ); 
                     
                      echo json_encode($arr);
                }else{
                     $arr = array(
                    'result' => 'Attendance was not taken due to technical problem',  
                  ); 
                 
                  echo json_encode($arr);
                }
               } catch(QueryException $ex){ 
                 

                 $arr = array(
                    'result' => $ex->getMessage(),  
                  ); 
                 
                  echo json_encode($arr);
               }
        }else{



if(isset($Employee_id)){

  $arr = array(
    'result' => 'please Provide Inserter Id',  
  ); 
  echo json_encode($arr);
}else{

  $arr = array(
    'result' => 'please Provide Employee Id',  
  ); 
  echo json_encode($arr);
}


        }
    }



    public function insert_attendance2(Request $atte)
    {
        $Employee_id =  $atte->employee_id;
        $Inserter_id =  session()->get('EmployeeID');

        if(isset($Employee_id) && $Inserter_id){

            try { 
                $insert_attendanceQrey=DB::table('attendance_info')
                ->insertOrIgnore([
                    'Employee_id'=>$Employee_id,
                    'attendance_time'=>now()->toTimeString(),
                    'attendance_Date'=>now()->toDateString(),
                    'created_by'=>$Inserter_id,
                    'updated_by'=>$Inserter_id,
                    'created_at'=>now(),
                    'updated_at'=>now()
          
                ]);
                if(isset($insert_attendanceQrey)){
                  $retur = url("/")."/attendance-response/". $Employee_id ;
                  return redirect($retur) ;


//                   $att_date = now()->toDateString();
//                   $all_attendance_data = DB::table('all_attandencetable')
//                   ->where('Employee_id',$Employee_id)
//                  ->where('attandence_Date', $att_date)
//                   ->get();

//                   if($all_attendance_data){
//                     $all_attendance_count = count($all_attendance_data);
    
//                     if($all_attendance_count != 1){
                    


//                       $user_data = DB::table('all_users')
//                        ->join('shift_master', 'all_users.shift_time', '=', 'shift_master.id')
//                        ->select('all_users.*', 'shift_master.Shift_hours')
//                        ->where('all_users.Employee_id',$Employee_id)
//                        ->get();
//                        $Shift_Hours;
                       
//                        foreach($user_data as $u_data){
//                        $Shift_Hours = $u_data->Shift_hours;
//                        $salary = $u_data->salary;
//                        }
//                        $rate_finder_cradinceal = 8*30*60;
//                        $over_time_rate = floatval ($salary / $rate_finder_cradinceal) ;
//                      $insert_all_attendance=DB::table('all_attandencetable')
//                      ->insertOrIgnore([
//                     'Employee_id'=>$Employee_id,
//                     'in_time'=>now()->toTimeString(),
//                     'out_time'=>now()->toTimeString(),
//                     'attandence_Date'=>now()->toDateString(),
//                     'Shift_Hours'=>$Shift_Hours,
//                     'Over_Ttime_Rate'=>$over_time_rate,
//                     'created_by'=>$Inserter_id,
//                     'updated_by'=>$Inserter_id,
//                     'created_at'=>now(),
//                     'updated_at'=>now()
          
//                 ]);

//                 $retur = url("/")."/attendance-response/". $Employee_id ;
//                         return redirect($retur) ;
//                       $arr = array(
//                         'result' => 'Attendance added Successfully'  ,  
//                       ); 
//                     }else{
//                       $att_date = now()->toDateString();

//                       $get_all_attandence_data = DB::table('all_attandencetable')
//                       ->where('Employee_id',$Employee_id)
//                       ->where('attandence_Date', $att_date)
//                       ->get();
//                       $Shift_Hours;
//                       $in_time;
//                       foreach($get_all_attandence_data as $att_data){
//                       $Shift_Hours = $att_data->Shift_Hours;
//                       $in_time = $att_data->in_time;
//                       $salary_rate = $att_data->Over_Ttime_Rate;
//                       }
//                      // time defrece
//                      $start = new \DateTime($in_time);
//                      $end = new \DateTime(now()->toTimeString());
//                      $interval = $start->diff($end);
//                       // Extract hours, minutes, and seconds
//     $hours = $interval->h;
//     $minutes = $interval->i;
//     $seconds = $interval->s;

//     // Handle cases where endTime is earlier in the day than startTime (crossing midnight)
//     if ($interval->invert) {
//         $hours = 24 - $hours;
//         if ($minutes > 0 || $seconds > 0) {
//             $hours--; // Adjust for the hour wrap-around
//         }
//         if ($minutes > 0) {
//             $minutes = 60 - $minutes; // Adjust minutes
//         }
//         if ($seconds > 0) {
//             $seconds = 60 - $seconds; // Adjust seconds
//         }
//     }
//     $diff_hours = $interval->h + ($interval->i / 60);
//     if ($interval->invert) {
//       $diff_hours = 24 - $diff_hours;
//     }
// $totel_time = $hours.':'.$minutes.':'. $seconds;
// if($diff_hours > $Shift_Hours){
//   $ovt_hr = $diff_hours - $Shift_Hours ;
//   $over_time_minuts = $ovt_hr * 60;
// }else{
//   $over_time_minuts = 0;
// }
//  $day_normal_amount = $Shift_Hours *60 * $salary_rate;
//  $day_over_time_amount = $salary_rate * $over_time_minuts;
//  $day_total_amount = $day_normal_amount + $day_over_time_amount;
//                       $update_basic_info = DB::table('all_attandencetable') 
//                       ->where('Employee_id',$Employee_id)
//                       ->where('attandence_Date', $att_date)
//                        ->update( [ 
//                       'out_time'=>now()->toTimeString(),
//                       'Total_Time'=>$totel_time,
//                       'Totel_Hours'=>$hours,
//                       'Total_Minutes'=>$minutes,
//                       'Minutes_Part'=>  $over_time_minuts ,
//                       'Overtime'=> $over_time_minuts,
//                       'Over_Time_Amount'=>  $day_over_time_amount,
//                       'Day_Total_Amount'=> $day_total_amount,
//                       'updated_by'=>$Inserter_id,
//                      'updated_at'=>now()
//                       ]); 
//                       if($update_basic_info){
                     
//                         $retur = url("/")."/attendance-response/". $Employee_id ;
//                         return redirect($retur) ;
                        
//                       }else{
//                         $arr = array(
//                           'result' =>  'Attendance added Successfully but data not updated' ,  
//                         ); 
//                       }
                     
//                     }
//                   }else{
//                     echo "aaa";
//                   }
//                     // $arr = array(
//                     //     'result' => $Employee_id . ' Attendance added Successfully',  
//                     //   ); 
                     
//                       echo json_encode($arr);
                }else{
                     $arr = array(
                    'result' => 'Attendance was not taken due to technical problem',  
                  ); 
                 
                  echo json_encode($arr);
                }
               } catch(QueryException $ex){ 
                 $arr = array(
                    'result' => $ex->getMessage(),  
                  ); 
                  echo json_encode($arr);
               }
        }else{
if(isset($Employee_id)){
  $arr = array(
    'result' => 'please Provide Inserter Id',  
  ); 
  echo json_encode($arr);
}else{
  $arr = array(
    'result' => 'please Provide Employee Id',  
  ); 
  echo json_encode($arr);
}
        }
    }

    public function mark_as_absent(Request $atte){
      $Employee_id = $atte->id;
      $Inserter_id = session()->get('EmployeeID');
      $role = session()->get('role');
      $insert_attendanceQrey= DB::table('all_attandencetable') 
      ->where('Employee_id',$Employee_id)
      
       ->update( [ 
      'out_time'=>'00:00:00',
      'updated_by'=>$Inserter_id,
      'attandence_Date'=>now()->toDateString(),
      'created_by'=>$Inserter_id,
     'updated_at'=>now()
      ]); 
      if(isset($insert_attendanceQrey)){
        ?>
<script>
alert("Attendance Updated")
history.back()
</script>
<?php
      }else{
        ?>
<script>
alert("Attendance Not Updated")
history.back()
</script>
<?php
      }
    } 


//api fatch present and absent api
public function get_attandence_data_api(){
  $attandance_persent_sql = "SELECT * FROM `dailyattendance`;";
  $emp_type_Data = DB::table('dailyattendance')
  ->paginate();
            $user_data = DB::table('all_users')
            ->get();
  $arr = array(
    'status'=>'true',
    'message' => ' data found success',  
    'data'=>$user_data,
    'attendance_data'=>$emp_type_Data,
     ); 
                   
 echo json_encode($arr);
}
//short data

public function get_attandence_data_api_short_by(Request $req){
  $short_by_key = $req->short_by_key;
  // $method = 'desc';
 // $method = 'asc';
  $method = $req->method;
  if(isset($short_by_key) && isset($method)){

    $emp_type_Data = DB::table('dailyattendance')->orderBy($short_by_key, $method) 
    ->paginate();
  

  $user_data = DB::table('all_users')
  ->get();


$arr = array(
'status'=>'true',
'message' => ' data found success',  
'data'=>$user_data,
'attendance_data'=>$emp_type_Data,
); 
         
echo json_encode($arr);
  }
}


//search attandence
public function get_attandence_data_search_api(Request $req){
$search_by_inp = $req->search_by;
if (isset($req->search_by)) {
 if ($req->search_by != "") {
  $emp_type_Data = DB::table('dailyattendance')
  ->whereAny([
    'NAME',
    'Shift_Name',
    'Department_name',
    'EmpTypeName',
    'in_time',
    'out_time',
    
], 'like', '%'.$search_by_inp.'%')
->paginate();


            $user_data = DB::table('all_users')
            ->get();


  $arr = array(
    'status'=>'true',
    'message' => ' data found success',  
    'data'=>$user_data,
    'attendance_data'=>$emp_type_Data,
     ); 
                  
 echo json_encode($arr);
 }else{

$arr = array(
'status'=>'true',
'message' => ' data  not found success',  
); 
         
echo json_encode($arr);
 }
}
 
  
}

// 
//api fatch present and absent api
public function get_single_attandence_data_api(Request $req){
  if($req->date == 1){
   // $date = date('Y-m-d');
    $date = date('Y-m-d');
  }else{
    $date = $req->date;
  }

  $emp_type_Data = DB::table('all_attandencetable')
            ->where('Employee_id',  $req->id)
            ->where('attandence_Date', '=', $date)
           
            ->get();

        //  dd($req) ;  

        ///$req->date

     $permCounr = count( $emp_type_Data);

     if($permCounr == 1){
      $arr = array(
        'status'=>'true',
        'message' => ' data found success',  
        'data'=> $emp_type_Data,
        'date'=>$date,
        'Employee_id'=>$req->id
      
         ); 
     }else{
      $arr = array(
        'status'=>'false',
        'message' => ' data not Found',  
        'data'=> $emp_type_Data,
        'date'=>$date,
        'Employee_id'=>$req->id
      
         ); 
     }
                   
 echo json_encode($arr);
}


//true false
      
















}
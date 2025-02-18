<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class Salary_CalculationsController extends Controller
{
    public function Salary_Calculations() {
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');

        
      if(isset( $EmployeesID)){
      $user_data = DB::table('all_users')
      ->join('shift_master', 'all_users.shift_time', '=', 'shift_master.id')
     ->select('all_users.*', 'shift_master.Shift_hours')
      ->get();

      //attendance_info
      $attendance_info_data = DB::table('all_attandencetable')
      ->orderBy('attandence_Date', 'ASC')
      ->get();

      //attendance_info
      $leave_type_master_data = DB::table('leave_type_master')
      ->get();

         return view("Salary_Calculations")
         ->with('user_data',$user_data)
         ->with('attendance_info_data', $attendance_info_data)
         ->with('leave_type_master_data', $leave_type_master_data)
         ->with('role',$role);
        
        }else{
          return redirect()->route('login');
        }
    }



    public function report_1() {
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');

      
    if(isset( $EmployeesID)){
    $user_data = DB::table('all_users')
    ->join('shift_master', 'all_users.shift_time', '=', 'shift_master.id')
   ->select('all_users.*', 'shift_master.Shift_hours')
    ->get();

    //attendance_info
    $attendance_info_data = DB::table('all_attandencetable')
    ->orderBy('attandence_Date', 'ASC')
    ->get();

    //attendance_info
    $leave_type_master_data = DB::table('leave_type_master')
    ->get();

       return view("report_1")
       ->with('user_data',$user_data)
       ->with('attendance_info_data', $attendance_info_data)
       ->with('leave_type_master_data', $leave_type_master_data)
       ->with('role',$role);
      
      }else{
        return redirect()->route('login');
      }
  }

 
    public function Salary_Calculations_api(Request $req){
      $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
        $currentMonth =  $req->month;
          $currentYear = $req->year;
        $cYear =  $currentYear;
        $cMonth =  $currentMonth;
      if(isset( $EmployeesID)){
        
        $user_data = DB::table('all_users')
        ->join('shift_master', 'all_users.shift_time', '=', 'shift_master.id')
        ->leftJoin('arrear_table', function ($join) use ($cYear,$cMonth) { // Pass $cYear into the closure
          $join->on('all_users.Employee_id', '=', 'arrear_table.Employee_id')
               ->whereYear('arrear_table.Arrear_Month', '=',$cYear) // Corrected usage
              ->whereMonth('arrear_table.Arrear_Month', '=',$cMonth); // Fixed January
      })
      ->orderBy('all_users.Employee_id', 'asc') // Explicit ascending order
        ->select(
            'all_users.*',
            'shift_master.Shift_hours',
            'shift_master.Shift_Name',
            'arrear_table.Arrear_Amount',
            'arrear_table.Arrear_Reasons',
            'arrear_table.Paid_Flag',
            'arrear_table.Paid_Amount'
        )
        ->paginate($req->limit);

      //attendance_info
      $attendance_info_data = DB::table('all_attandencetable')
      ->whereMonth('attandence_Date', $req->month)
      ->whereYear('attandence_Date',  $req->year)
      ->get();


 //calendar_data
 $calendar_data = DB::table('calendar')
 ->where('month', $req->month)
 ->where('year',  $req->year)
 ->get();

      $deductions_data = DB::table('deductions')
      ->where('Month', $req->year . "-" . $req->month )
      
      ->get();

      $yearMonth = $req->year . "-" . $req->month . "-01"; // Convert input year and month to a valid date

      $advance_data = DB::table('loan')
      ->whereDate('start_month','<=', $yearMonth )
       ->whereDate('end_month' , '>=',$yearMonth )
      ->get();

      $penalty_data = DB::table('penalty_master')
      ->whereMonth('created_at', $req->month)
      ->whereYear('created_at',  $req->year)
      ->get();

      $other_payments_data = DB::table('other_payments')
      ->whereMonth('created_at', $req->month)
      ->whereYear('created_at',  $req->year)
      ->get();
      $holiday_quri = DB::table('holiday_master')
      ->whereMonth('holiday_Date', $req->month)
      ->whereYear('holiday_Date',  $req->year)
      ->get()
      ->toArray();

      $deductions_quri = DB::table('deductions')
      ->whereMonth('deductions_Month', $req->month)
      ->whereYear('deductions_Month',  $req->year)
      
      ->get()
      ->toArray();
     
      $holiday_count = count($holiday_quri);
      //leave data 
      $leave_quri = DB::table('_leave')
      ->join('leave_type_master', '_leave.Leave_Type', '=', 'leave_type_master.id')
      ->get()
      ->toArray();




      $arr = array(
        'status'=>'true',
        'message' => 'data Found',  
        'all_users'=> $user_data,
        'attendance_info_data'=> $attendance_info_data,
        'deductions'=> $deductions_data,
        'other_payments'=> $other_payments_data,
        'advance_data'=> $advance_data,
        'penalty_data'=> $penalty_data,
        'holiday_count'=> $holiday_count ,
        'leave_data'=> $leave_quri ,
        'calendar_data'=> $calendar_data ,
        'holiday_data'=> $holiday_quri ,
        'deductions_data'=> $deductions_quri ,
        'role'=> $role
         ); 
      echo json_encode($arr);

  
        
        }else{
          return redirect()->route('login');
        }
    }



    
    public function salary_calculations_short_api(Request $req){
      $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');

        
      if(isset( $EmployeesID)){
      $user_data = DB::table('all_users')
      ->join('shift_master', 'all_users.shift_time', '=', 'shift_master.id')
     ->select('all_users.*', 'shift_master.Shift_hours')
     ->orderBy($req->short_by, $req->method)
     ->paginate($req->limit );

      //attendance_info
      $attendance_info_data = DB::table('all_attandencetable')
      ->whereMonth('attandence_Date', $req->month)
      ->whereYear('attandence_Date',  $req->year)
      ->get();

      //calendar_data
      $calendar_data = DB::table('calendar')
      ->where('month', $req->month)
      ->where('year',  $req->year)
      ->orderBy('day',ASC)
      ->get();



      $deductions_data = DB::table('deductions')
      ->where('Month', $req->year . "-" . $req->month )
      ->get();

      $advance_data = DB::table('loan')
      ->where('Month', $req->year . "-" . $req->month )
      ->get();
      
      $penalty_data = DB::table('penalty_master')
      ->whereMonth('created_at', $req->month)
      ->whereYear('created_at',  $req->year)
      ->get();

      $other_payments_data = DB::table('other_payments')
      ->whereMonth('created_at', $req->month)
      ->whereYear('created_at',  $req->year)
      ->get();

      $holiday_quri = DB::table('holiday_master')
      ->whereMonth('holiday_Date', $req->month)
      ->whereYear('holiday_Date',  $req->year)
      ->get()
      ->toArray();
     
      $holiday_count = count($holiday_quri);
      //leave data 
      $leave_quri = DB::table('_leave')
      ->join('leave_type_master', '_leave.Leave_Type', '=', 'leave_type_master.id')
      ->get()
      ->toArray();




      $arr = array(
        'status'=>'true',
        'message' => 'data Found',  
        'all_users'=> $user_data,
        'attendance_info_data'=> $attendance_info_data,
        'deductions'=> $deductions_data,
        'other_payments'=> $other_payments_data,
        'advance_data'=> $advance_data,
        'penalty_data'=> $penalty_data,
        'holiday_count'=> $holiday_count ,
        'calendar_data'=> $calendar_data ,
        'leave_data'=> $leave_quri ,
        'holiday_data'=> $holiday_quri ,
        'role'=> $role
         ); 
      echo json_encode($arr);

  
        
        }else{
          return redirect()->route('login');
        }
    }



    public function Salary_Calculations_search_api(Request $req){
      $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
        $search_by_inp = $req->search_inp;
        
      if(isset( $EmployeesID)){
      $user_data = DB::table('all_users')
      ->join('shift_master', 'all_users.shift_time', '=', 'shift_master.id')
     ->select('all_users.*', 'shift_master.Shift_hours')
     ->whereAny([
      'f_name',
      'l_name',
      'm_name',
      'Employee_id',
      'email',
      'mobile_number',
  ], 'like', '%'.$search_by_inp.'%')
     ->paginate($req->limit );

      //attendance_info
      $attendance_info_data = DB::table('all_attandencetable')
      ->whereMonth('attandence_Date', $req->month)
      ->whereYear('attandence_Date',  $req->year)
      ->get();


 //calendar_data
 $calendar_data = DB::table('calendar')
 ->where('month', $req->month)
 ->where('year',  $req->year)
 ->get();

      $deductions_data = DB::table('deductions')
      ->where('Month', $req->year . "-" . $req->month )
      
      ->get();

      $yearMonth = $req->year . "-" . $req->month . "-01"; // Convert input year and month to a valid date

      $advance_data = DB::table('loan')
      ->whereDate('start_month','<=', $yearMonth )
       ->whereDate('end_month' , '>=',$yearMonth )
      ->get();

      $penalty_data = DB::table('penalty_master')
      ->whereMonth('created_at', $req->month)
      ->whereYear('created_at',  $req->year)
      ->get();

      $other_payments_data = DB::table('other_payments')
      ->whereMonth('created_at', $req->month)
      ->whereYear('created_at',  $req->year)
      ->get();
      $holiday_quri = DB::table('holiday_master')
      ->whereMonth('holiday_Date', $req->month)
      ->whereYear('holiday_Date',  $req->year)
      ->get()
      ->toArray();

      $deductions_quri = DB::table('deductions')
      ->whereMonth('deductions_Month', $req->month)
      ->whereYear('deductions_Month',  $req->year)
      
      ->get()
      ->toArray();
     
      $holiday_count = count($holiday_quri);
      //leave data 
      $leave_quri = DB::table('_leave')
      ->join('leave_type_master', '_leave.Leave_Type', '=', 'leave_type_master.id')
      ->get()
      ->toArray();




      $arr = array(
        'status'=>'true',
        'message' => 'data Found',  
        'all_users'=> $user_data,
        'attendance_info_data'=> $attendance_info_data,
        'deductions'=> $deductions_data,
        'other_payments'=> $other_payments_data,
        'advance_data'=> $advance_data,
        'penalty_data'=> $penalty_data,
        'holiday_count'=> $holiday_count,
        'leave_data'=> $leave_quri,
        'calendar_data'=> $calendar_data,
        'holiday_data'=> $holiday_quri,
        'deductions_data'=> $deductions_quri,
        'role'=> $role
         ); 
      echo json_encode($arr);
        }else{
          return redirect()->route('login');
        }
    }




    
    public function save_salary_data(Request $req){





      
      $arr = array(
        'status'=>'true',
        'message' => 'data Found',  
        'data' => $req,  
       
         ); 
      echo json_encode($arr);
    }



}
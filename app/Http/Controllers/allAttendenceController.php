<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class allAttendenceController extends Controller
{
    public function all_attendence()
    {
        $role = session()->get('role');
        $users = DB::table('attendance_info')
            ->join('all_users', 'attendance_info.Employee_id', '=', 'all_users.Employee_id')
            ->select('attendance_info.*', 'all_users.f_name', 'all_users.l_name', 'all_users.m_name')
            ->orderBy('id', 'DESC')
            ->paginate(50);

        $users_qur = DB::table('all_users')->get();

        return view('all_attendence')
            ->with('role', $role)
            ->with('all_users', $users_qur)
            ->with('users', $users);
    }

    public function search_attendence(Request $setch_req)
    {
        $inputSValue = $setch_req->search_val;
        $role = session()->get('role');
        if (isset($inputSValue)) {
            $users = DB::table('attendance_info')
                ->join('all_users', 'attendance_info.Employee_id', '=', 'all_users.Employee_id')

                ->whereAll([
                    'attendance_info.id', 'attendance_info.Employee_id', 'attendance_info.attendance_time', 'attendance_info.attendance_Date', 'all_users.f_name',
                ], 'like', '%' . $inputSValue . '%')
                ->select('attendance_info.*', 'all_users.f_name', 'all_users.l_name', 'all_users.m_name')
                ->orderBy('id', 'DESC')
                ->paginate(10);

            $usersCount = count($users);
            if ($usersCount == 1) {
                return view('all_attendence')
                    ->with('role', $role)
                    ->with('users', $users);
            } else {

                ?>
<script>
alert("No Record Found");
history.back();
</script>
<?php
}

        }

    }

    
    public function delete_swap_day_api(Request $delete_req)
    {
        $id = $delete_req->id;
            DB::table('all_holiday')->where('id', $id)->delete();
        return response()->json(['success' => 'Swap Day Data Deleted']);
    }

    public function delete_attendence(Request $delete_req)
    {
        $ids = $delete_req->ids;

        foreach ($ids as $id) {
            DB::table('attendance_info')->where('id', $id)->delete();
        }

        return response()->json(['success' => 'Data Deleted']);
    }


     ///APIS


  public function all_attandence_api(Request $req){
    $EmployeesID = session()->get('EmployeeID');
    $role = session()->get('role');
    if(isset( $EmployeesID)){
        $role = session()->get('role');
        $users_attandence_data = DB::table('attendance_info')
            ->join('all_users', 'attendance_info.Employee_id', '=', 'all_users.Employee_id')
            ->select('attendance_info.*', 'all_users.f_name', 'all_users.l_name', 'all_users.m_name')
            ->orderBy('id', 'DESC')
            ->paginate($req->limit);

        $users_qur = DB::table('all_users')->get();


      

    $arr = array(
      'status'=>'true',
      'message' => 'data Found',  
      'attandence_data'=> $users_attandence_data,
      'all_users'=> $users_qur,
      'role'=> $role
       ); 
    echo json_encode($arr);


    }else{
    return redirect()->route('login');
    }
}

public function all_swap_day_list_api(Request $req){
    $EmployeesID = session()->get('EmployeeID');
    $role = session()->get('role');
    if(isset( $EmployeesID)){
        $role = session()->get('role');
        $users_attandence_data = DB::table('all_holiday')
            ->join('all_users', 'all_holiday.Employee_id', '=', 'all_users.Employee_id')
            ->select('all_holiday.*', 'all_users.f_name', 'all_users.l_name', 'all_users.m_name')
            ->orderBy('id', 'DESC')
            ->paginate($req->limit);

        $users_qur = DB::table('all_users')->get();
    $arr = array(
      'status'=>'true',
      'message' => 'data Found',  
      'attandence_data'=> $users_attandence_data,
      'all_users'=> $users_qur,
      'role'=> $role
       ); 
    echo json_encode($arr);


    }else{
    return redirect()->route('login');
    }
}


public function all_attandence_short_api(Request $req){
    $EmployeesID = session()->get('EmployeeID');
    $role = session()->get('role');
    if(isset( $EmployeesID)){
        $role = session()->get('role');
        $users_attandence_data = DB::table('attendance_info')
        ->join('all_users', 'attendance_info.Employee_id', '=', 'all_users.Employee_id')
        ->select('attendance_info.*', 'all_users.f_name', 'all_users.l_name', 'all_users.m_name')
            ->orderBy($req->short_by, $req->method)
            ->paginate($req->limit);

        $users_qur = DB::table('all_users')->get();
        

      

    $arr = array(
      'status'=>'true',
      'message' => 'data Found',  
      'attandence_data'=> $users_attandence_data,
      'all_users'=> $users_qur,
      'role'=> $role
       ); 
    echo json_encode($arr);


    }else{
    return redirect()->route('login');
    }
}




public function all_swap_day_list_short_api(Request $req){
    $EmployeesID = session()->get('EmployeeID');
    $role = session()->get('role');
    if(isset( $EmployeesID)){
        $role = session()->get('role');
        $users_attandence_data = DB::table('all_holiday')
            ->join('all_users', 'all_holiday.Employee_id', '=', 'all_users.Employee_id')
            ->select('all_holiday.*', 'all_users.f_name', 'all_users.l_name', 'all_users.m_name')
            ->orderBy($req->short_by, $req->method)
            ->paginate($req->limit);

        $users_qur = DB::table('all_users')->get();
        

      

    $arr = array(
      'status'=>'true',
      'message' => 'data Found',  
      'attandence_data'=> $users_attandence_data,
      'all_users'=> $users_qur,
      'role'=> $role
       ); 
    echo json_encode($arr);


    }else{
    return redirect()->route('login');
    }
}


public function all_attandence_search_api(Request $req){
    $EmployeesID = session()->get('EmployeeID');
    $search_by_inp = $req->search_inp;
    $role = session()->get('role');
    if(isset( $EmployeesID)){
        $role = session()->get('role');
        $users_attandence_data = DB::table('attendance_info')
        ->join('all_users', 'attendance_info.Employee_id', '=', 'all_users.Employee_id')
        ->select('attendance_info.*', 'all_users.f_name', 'all_users.l_name', 'all_users.m_name')
            ->whereAny([
                'all_users.f_name',
                'all_users.m_name',
                'all_users.l_name',
                'attendance_info.attendance_Date',
                'attendance_info.attendance_time',
            ], 'like', '%'.$search_by_inp.'%')
            ->paginate($req->limit);
        $users_qur = DB::table('all_users')->get();
    $arr = array(
      'status'=>'true',
      'message' => 'data Found',  
      'attandence_data'=> $users_attandence_data,
      'all_users'=> $users_qur,
      'role'=> $role
       ); 
    echo json_encode($arr);


    }else{
    return redirect()->route('login');
    }
}


public function all_swap_day_list_search_api(Request $req){
    $EmployeesID = session()->get('EmployeeID');
    $search_by_inp = $req->search_inp;
    $role = session()->get('role');
    if(isset( $EmployeesID)){
        $role = session()->get('role');
        $users_attandence_data = DB::table('attendance_info')
            ->join('all_users', 'attendance_info.Employee_id', '=', 'all_users.Employee_id')
            ->select('attendance_info.*', 'all_users.f_name', 'all_users.l_name', 'all_users.m_name')
            ->whereAny([
                'all_users.f_name',
                'all_users.m_name',
                'all_users.l_name',
                'attendance_info.attendance_Date',
                'attendance_info.attendance_time',
                'attendance_info.Employee_id',
            ], 'like', '%'.$search_by_inp.'%')
            ->paginate($req->limit);
        $users_qur = DB::table('all_users')->get();
    $arr = array(
      'status'=>'true',
      'message' => 'data Found',  
      'attandence_data'=> $users_attandence_data,
      'all_users'=> $users_qur,
      'role'=> $role
       ); 
    echo json_encode($arr);


    }else{
    return redirect()->route('login');
    }
}


public function insertAttendanceForAll(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $empID = $request->employeeID;
        
        if (!$startDate || !$endDate) {
            return response()->json([
                'status' => 'error',
                'message' => 'Start and end dates are required.',
            ]);
        }

        try {
            
             $this->insertAttendanceRecords($empID, $startDate, $endDate);
             
            //$employees = DB::table('all_users')->select('Employee_id')->get();

            //foreach ($employees as $employee) {
              //  $this->insertAttendanceRecords($employee->Employee_id, $startDate, $endDate);
            //}

            return response()->json([
                'status' => 'success',
                'message' => 'Attendance records inserted successfully.',
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    private function insertAttendanceRecords($employeeId, $startDate, $endDate)
    {
        $currentDate = $startDate;
    
        while (strtotime($currentDate) <= strtotime($endDate)) {
            $dayOfWeek = date('w', strtotime($currentDate)); // 0 = Sunday
    
            
                //  $timeSlots = [
                //     [32400, 1800], // Near 09:00 AM
                //     [43200, 1800], // Near 12:00 PM
                //     [46800, 1800], // Near 01:00 PM
                //     [61200, 1800]  // Near 06:00 PM
                // ];

                $timeSlots = [
                    [32400, 1800], // Near 09:00 AM
                    [61200, 1800]  // Near 06:00 PM
                ];
                 
    
                foreach ($timeSlots as $slot) {
                    $attendanceTimes = [
                        $this->generateRandomTime($slot[0], $slot[1]),
                        $this->generateRandomTime($slot[0], $slot[1]),
                    ];
    
                    foreach ($attendanceTimes as $attendanceTime) {
                        // Call the method using $this->insert_api222()
                        $this->insert_api222($employeeId, $attendanceTime, $currentDate, 1);
                    }
                }
            
    
            // Increment the date
            $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
        }
    }


    
    public function all_attandance_detail_with_let_api()
    {
        $sql = "CALL `GetShitWiseCurrentDateData`()";
        // Execute the stored procedure and get the result set
        $attandance_summary_result = DB::select($sql);
        // Return the result as a JSON response
        return response()->json($attandance_summary_result);
    }

      
    public function Get_Employee_Type_Wise_Current_Date_Data_api()
    {
        $sql = "CALL `GetEmployeeTypeWiseCurrentDateData`();";
        // Execute the stored procedure and get the result set
        $attandance_summary_result = DB::select($sql);
        // Return the result as a JSON response
        return response()->json($attandance_summary_result);
    }
    public function Late_Commer_Current_Date_Data_api()
    {

        $sql = "select distinct d.Department_name as Department , e.EmpTypeName, sh.Shift_Name, sh.Shift_Start_Time, sh.Shift_hours,   u.f_name,u.m_name, u.l_name, a.Employee_id, a.in_time, a.attandence_Date from all_attandencetable a \n"

        . "inner join all_users u on a.Employee_id = u.Employee_id\n"
    
        . "inner join shift_master sh on u.shift_time = sh.id\n"
    
        . "inner join shift__employee_type_master as e on u.employee_type = e.id\n"
        . "INNER JOIN department_master d ON u.Department = d.id\n"
    
        . "where a.attandence_Date = CURRENT_DATE AND a.in_time > DATE_ADD(sh.Shift_Start_Time, INTERVAL 5 MINUTE)\n"
    
        . "order by u.f_name, u.m_name, u.l_name, u.Employee_id;";
        // Execute the stored procedure and get the result set
        $attandance_summary_result = DB::select($sql);
        // Return the result as a JSON response
        return response()->json($attandance_summary_result);
    }
   
    public function daily_ot_hrs_api()
    {

        $daily_ot_hrs_sql = "SELECT * FROM `dailyothrs`;";
        // Execute the stored procedure and get the result set
        $daily_ot_hrs_result = DB::select($daily_ot_hrs_sql);
        // Return the result as a JSON response
        return response()->json($daily_ot_hrs_result);
    }
    


    
    
    
    private function generateRandomTime($startSeconds, $rangeSeconds)
    {
        $randomSeconds = $startSeconds + rand(0, $rangeSeconds);
        return gmdate('H:i:s', $randomSeconds);
    }
    
    public function insert_api222($employeeId, $attendanceTime, $attendanceDate, $inserterId)
    {
        DB::table('attendance_info')->insertOrIgnore([
            'Employee_id' => $employeeId,
            'attendance_time' => $attendanceTime,
            'attendance_Date' => $attendanceDate,
            'created_by' => $inserterId,
            'updated_by' => $inserterId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    

  

}
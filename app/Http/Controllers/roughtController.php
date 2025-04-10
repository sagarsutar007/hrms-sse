<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class roughtController extends Controller
{



  public function dashboard() {
    $role = session()->get('role');
    $EmployeesID = session()->get('EmployeeID');
   if(isset($EmployeesID)){
    $login_u_data = DB::table('users')
        ->where('Employee_id',$EmployeesID)
        ->get();
        $emergency__contactsCount = count( $login_u_data);
        if ($emergency__contactsCount == 1) {
          foreach ( $login_u_data as $c_data) {
            $Employee_name = $c_data->f_name ;
            $Employee_id = $c_data->Employee_id;
            $mobile_number= $c_data->mobile_number;
            $permanent_address= "";
            $photo_name= "";
            $email = $c_data->email;
            // $Address = $c_data->address;
            // $mobile = $c_data->mobile;
            $em_data = array(
                "Employee_id" => $Employee_id,
                "Name" =>  $Employee_name,
                "email" =>  $email,
                "mobile_number" =>  $mobile_number,
                "permanent_address" =>  $permanent_address,
                "photo_name" =>  $photo_name,
            );
            $employee_numbersql = "Select   \n"

            . "count(u.id) as TotalEmployees\n"

            . "from all_users u \n"

            . "where (u.DOJ is null or u.DOJ<= CURRENT_DATE) and (u.termination_date is null or u.termination_date>= CURRENT_DATE);";

            $employee_number_qr = DB::statement($employee_numbersql);
            $employee_number = $employee_number_qr;


            $total_on_leave_sql = "SELECT Sum(case when Half_Day=1 then 0.5 else 1 end ) as TotalOnLeave
            FROM _leave
         Where CURRENT_DATE between Start_Date and End_Date";


            $leave_number_qr = DB::statement($total_on_leave_sql);
            $leave_number =$leave_number_qr;

            $all_attandencet_sql = "SELECT * FROM `dailystats`;";
            $all_attandencet_qr = DB::select($all_attandencet_sql); // Use DB::select to fetch the results as an array

            if (!empty($all_attandencet_qr)) {
                // Assuming you only want the first row
                $val = $all_attandencet_qr[0];

                $employee_number = $val->TotalEmployees;
                $Present_number = $val->Present;
                $OnWeeklyOff_number = $val->OnWeeklyOff;
                $OnLeave_number = $val->OnLeave;
                $Absent_number = $val->Absent;
                $LatePunch = $val->LatePunch;
            }




            $user_permission = DB::table('user_permissions')
    ->where('Employee_id', $EmployeesID)
    ->first();
    $view_home_page_options = $user_permission->view_home_page_options;
    $view_menu_items = $user_permission->view_menu_items;

            if(isset( $em_data)){
                return view("index")
                ->with('login_u_data', $em_data)
                ->with('role',$role)
                ->with('employee_number',$employee_number)
                ->with('Present_number',$Present_number)
                ->with('Absent_number',$Absent_number)
                ->with('LatePunch',$LatePunch)
                ->with('view_home_page_options',$view_home_page_options)
                ->with('view_menu_items',$view_menu_items)
                ->with('leave_number',$OnLeave_number );

               }else{
                 return redirect()->route('login');
               }


        }

        }else{
          ?>
<script>
alert('Please Login again')
</script>
<?php
return redirect()->route('login');
      }

    echo $role = session()->get('role');
   }else{
    return redirect()->route('login');
   }



  }

    public function dashboard2() {
    $EmployeesID = session()->get('EmployeeID');
    $role = session()->get('role');
    if(isset($EmployeesID)){
        $login_u_data = DB::table('all_users')
        ->where('Employee_id',$EmployeesID)
        ->get();

        if (isset( $login_u_data)) {

            $emergency__contactsCount = count( $login_u_data);
        if ($emergency__contactsCount == 1) {
            foreach ( $login_u_data as $c_data) {
                $Employee_name = $c_data->f_name . " " . $c_data->m_name . " " . $c_data->l_name;
                $Employee_id = $c_data->Employee_id;
                $mobile_number= $c_data->mobile_number;
                $permanent_address= $c_data->permanent_address;
                $photo_name= $c_data->photo_name;
                $email = $c_data->email;
                // $Address = $c_data->address;
                // $mobile = $c_data->mobile;
                $em_data = array(
                    "Employee_id" => $Employee_id,
                    "Name" =>  $Employee_name,
                    "email" =>  $email,
                    "mobile_number" =>  $mobile_number,
                    "permanent_address" =>  $permanent_address,
                    "photo_name" =>  $photo_name,
                );
                $employee_numbersql = "Select   \n"

                . "count(u.id) as TotalEmployees\n"

                . "from all_users u \n"

                . "where (u.DOJ is null or u.DOJ<= CURRENT_DATE) and (u.termination_date is null or u.termination_date>= CURRENT_DATE);";

                $employee_number_qr = DB::statement($employee_numbersql);
                $employee_number = $employee_number_qr;


                $total_on_leave_sql = "SELECT Sum(case when Half_Day=1 then 0.5 else 1 end ) as TotalOnLeave
                FROM _leave
             Where CURRENT_DATE between Start_Date and End_Date";


                $leave_number_qr = DB::statement($total_on_leave_sql);
                $leave_number =$leave_number_qr;

                $all_attandencet_sql = "SELECT * FROM `dailystats`;";
                $all_attandencet_qr = DB::select($all_attandencet_sql); // Use DB::select to fetch the results as an array

                if (!empty($all_attandencet_qr)) {
                    // Assuming you only want the first row
                    $val = $all_attandencet_qr[0];

                    $employee_number = $val->TotalEmployees;
                    $Present_number = $val->Present;
                    $OnWeeklyOff_number = $val->OnWeeklyOff;
                    $OnLeave_number = $val->OnLeave;
                    $Absent_number = $val->Absent;
                    $LatePunch = $val->LatePunch;
                }
                $vwabsentemployee_statement = "SELECT * FROM `vwabsentemployee`;";
                $vwabsentemployee_data= DB::statement($vwabsentemployee_statement);





                if(isset( $em_data)){
                    return view("index")
                    ->with('login_u_data', $em_data)
                    ->with('role',$role)
                    ->with('employee_number',$employee_number)
                    ->with('Present_number',$Present_number)
                    ->with('Absent_number',$Absent_number)
                    ->with('LatePunch',$LatePunch)
                    ->with('absent_data',$vwabsentemployee_data)
                    ->with('leave_number',$OnLeave_number );

                   }else{
                     return redirect()->route('login');
                   }


            }


        }else{
            ?>
<script>
alert('Please Login again')
</script>
<?php
return redirect()->route('login');
        }

        }else
        {
            ?>
<script>
alert('Server Error Please Login again')
</script>
<?php
            return redirect()->route('login');
        }

    }else{
        return redirect()->route('login');
    }
    }

    public function attendanceRecords()
    {
        $EmployeeTypes = DB::table('dailyattendance')->distinct()->get();
        $Departments = DB::table('dailyattendance')->distinct()->get();

        return view('attendance-records', compact('EmployeeTypes', 'Departments'));
    }

    public function fetchAttendance(Request $request)
{
    $fromDate = $request->input('from_date');
    $toDate = $request->input('to_date');
    $employeeType = $request->input('employee_type');
    $department = $request->input('department');

    // Build your query with filters
    $query = Attendance::query();

    if ($fromDate && $toDate) {
        $query->whereBetween('attandence_Date', [$fromDate, $toDate]);
    }

    if ($employeeType) {
        $query->where('EmpTypeName', $employeeType);
    }

    if ($department) {
        $query->where('Department_name', $department);
    }

    $attendanceData = $query->get();

    return response()->json([
        'attendance_data' => [
            'data' => $attendanceData
        ]
    ]);
}

public function index(Request $request)
{
    $attendance = AttendanceInfo::paginate(15);
    return response()->json($attendance);
}

public function search(Request $request)
{
    $query = AttendanceInfo::query();

    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->where('NAME', 'LIKE', "%{$request->search}%")
              ->orWhere('Employee_id', 'LIKE', "%{$request->search}%");
        });
    }

    if ($request->filled('from_date')) {
        $query->where('attendance_Date', '>=', $request->from_date);
    }

    if ($request->filled('to_date')) {
        $query->where('attendance_Date', '<=', $request->to_date);
    }

    $attendance = $query->paginate(15);
    return response()->json($attendance);
}

public function all_attendance(){
    $EmployeesID = session()->get('EmployeeID');
    $role = session()->get('role');
    if(isset( $EmployeesID)){
      $emp_type_Data = DB::statement("SELECT *  FROM `all_attandencetable` WHERE `attandence_Date` = '2024-12-08' ORDER BY `attandence_Date` DESC ");

      $all_users = DB::table('all_users')
      ->get();

      return view("All_attendance_with_absent")
      ->with('emp_type_Data', $emp_type_Data)
      ->with('all_users', $all_users)
    ->with('role',$role);

    }else{
    return redirect()->route('login');
    }
}

    // all_holidays
    public function all_holidays(){
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
        if(isset( $EmployeesID)){
          $emp_type_Data = DB::table('holiday_master')
          ->get();
          return view("all_Holidays")
          ->with('emp_type_Data', $emp_type_Data)
        ->with('role',$role);
        }else{
        return redirect()->route('login');
        }
    }
    public function all_leave(){
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
        if(isset( $EmployeesID)){


          $emp_type_Data = DB::table('_leave')

          ->get();
          return view("all_Leave_Request")
          ->with('emp_type_Data', $emp_type_Data)
        ->with('role',$role);


        }else{
        return redirect()->route('login');
        }
    }
    public function all_travel(){
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
        if(isset( $EmployeesID)){
          $emp_type_Data = DB::table('travel_info')
          ->get();
          return view("All_Travel_Request")
          ->with('emp_type_Data', $emp_type_Data)
        ->with('role',$role);


        }else{
        return redirect()->route('login');
        }
    }
    public function all_tranings(){
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
        if(isset( $EmployeesID)){
          $emp_type_Data = DB::table('training_info')
          ->get();
          return view("All_Tranings")
          ->with('emp_type_Data', $emp_type_Data)
        ->with('role',$role);
        }else{
        return redirect()->route('login');
        }
    }
    public function all_projects(){
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
        if(isset( $EmployeesID)){


          $emp_type_Data = DB::table('projects')
          ->join('all_users', 'all_users.Employee_id', '=', 'projects.Employee_id')
          ->select('all_users.*', 'projects.*')
          ->get();
          return view("All_ Projects")
          ->with('emp_type_Data', $emp_type_Data)
        ->with('role',$role);


        }else{
        return redirect()->route('login');
        }
    }
    public function all_tasks(){
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
        if(isset( $EmployeesID)){
          $emp_type_Data = DB::table('tasks')
          ->join('all_users', 'all_users.Employee_id', '=', 'tasks.Employee_id')
          ->select('all_users.*', 'tasks.*')
          ->get();
          return view("All_Tasks")
          ->with('emp_type_Data', $emp_type_Data)
        ->with('role',$role);
        }else{
        return redirect()->route('login');
        }
    }
    public function all_allowances(){
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
        if(isset( $EmployeesID)){


          $emp_type_Data = DB::table('alloweance')
          ->join('all_users', 'all_users.Employee_id', '=', 'alloweance.Employee_id')
          ->select('all_users.*', 'alloweance.*')
          ->get();
          return view("All_Alloweance")
          ->with('emp_type_Data', $emp_type_Data)
        ->with('role',$role);


        }else{
        return redirect()->route('login');
        }
    }
    public function all_loan(){
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
        if(isset( $EmployeesID)){


          $emp_type_Data = DB::table('loan')
          ->join('all_users', 'all_users.Employee_id', '=', 'loan.Employee_id')
          ->select('all_users.*', 'loan.*')
          ->get();
          return view("All_Loan")
          ->with('emp_type_Data', $emp_type_Data)
        ->with('role',$role);


        }else{
        return redirect()->route('login');
        }
    }
    public function all_deductions(){
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
        if(isset( $EmployeesID)){


          $emp_type_Data = DB::table('deductions')
          ->join('all_users', 'all_users.Employee_id', '=', 'deductions.Employee_id')
          ->select('all_users.*', 'deductions.*')
          ->get();
          return view("All_Deductions")
          ->with('emp_type_Data', $emp_type_Data)
        ->with('role',$role);


        }else{
        return redirect()->route('login');
        }
    }
    public function all_other_payment(){
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
        if(isset( $EmployeesID)){


          $emp_type_Data = DB::table('other_payments')
          ->join('all_users', 'all_users.Employee_id', '=', 'other_payments.Employee_id')
          ->select('all_users.*', 'other_payments.*')
          ->get();
          return view("All_Other_Payment")
          ->with('emp_type_Data', $emp_type_Data)
        ->with('role',$role);


        }else{
        return redirect()->route('login');
        }
    }
    public function all_overtime(){
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
    public function all_award(){
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
        if(isset( $EmployeesID)){
          $emp_type_Data = DB::table('award_info')
          ->get();
          return view("All_Award")
          ->with('emp_type_Data', $emp_type_Data)
        ->with('role',$role);


        }else{
        return redirect()->route('login');
        }
    }
    public function all_ticket(){
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
        if(isset( $EmployeesID)){


          $emp_type_Data = DB::table('ticket_info')
          ->join('all_users', 'all_users.Employee_id', '=', 'ticket_info.Employee_id')
          ->select('all_users.*', 'ticket_info.*')
          ->get();
          return view("All_Ticket")
          ->with('emp_type_Data', $emp_type_Data)
        ->with('role',$role);


        }else{
        return redirect()->route('login');
        }
    }
    public function all_transfer(){
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
        if(isset( $EmployeesID)){


          $emp_type_Data = DB::table('transfer_info')
          ->join('all_users', 'all_users.Employee_id', '=', 'transfer_info.Employee_id')
          ->select('all_users.*', 'transfer_info.*')
          ->get();
          return view("All_Transfer")
          ->with('emp_type_Data', $emp_type_Data)
        ->with('role',$role);


        }else{
        return redirect()->route('login');
        }
    }
    public function all_promotion(){
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
        if(isset( $EmployeesID)){


          $emp_type_Data = DB::table('_promotion')
          ->join('all_users', 'all_users.Employee_id', '=', '_promotion.Employee_id')
          ->select('all_users.*', '_promotion.*')
          ->get();
          return view("All_Promotion")
          ->with('emp_type_Data', $emp_type_Data)
        ->with('role',$role);


        }else{
        return redirect()->route('login');
        }
    }
    public function all_complaints(){
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
        if(isset( $EmployeesID)){


          $emp_type_Data = DB::table('complaints')
          ->join('all_users', 'all_users.Employee_id', '=', 'complaints.Employee_id')
          ->select('all_users.*', 'complaints.*')
          ->get();
          return view("All_Complaints")
          ->with('emp_type_Data', $emp_type_Data)
        ->with('role',$role);


        }else{
        return redirect()->route('login');
        }
    }
    public function all_warning(){
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
        if(isset( $EmployeesID)){


          $emp_type_Data = DB::table('warning')
          ->join('all_users', 'all_users.Employee_id', '=', 'warning.Employee_id')
          ->select('all_users.*', 'warning.*')
          ->get();
          return view("All_Warning")
          ->with('emp_type_Data', $emp_type_Data)
        ->with('role',$role);


        }else{
        return redirect()->route('login');
        }
    }
    public function all_payslip(){
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
        if(isset( $EmployeesID)){


          $emp_type_Data = DB::table('payslip')
          ->join('all_users', 'all_users.Employee_id', '=', 'payslip.Employee_id')
          ->select('all_users.*', 'payslip.*')
          ->get();
          return view("All_Payslip")
          ->with('emp_type_Data', $emp_type_Data)
        ->with('role',$role);


        }else{
        return redirect()->route('login');
        }
    }



    // search all

    // all_attendance
    public function all_attendance_search(Request $req){
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');
      if(isset( $EmployeesID)){
        $emp_type_Data = DB::table('all_attandencetable')
        ->whereAny([
          'id','Employee_id','in_time','out_time'

        ], 'like', '%'. $req->search_input.'%')
        ->get();

        $all_users = DB::table('all_users')
        ->get();
        if($emp_type_Data){
          return view("All_attendance_with_absent")
          ->with('emp_type_Data', $emp_type_Data)
          ->with('all_users', $all_users)
        ->with('role',$role);
        }else{
          ?>
<script>
alert("No record found")
history.back()
</script>
<?php
        }




      }else{
      return redirect()->route('login');
      }
  }

  // all_holidays
  public function all_holidays_search(Request $req){
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');
      if(isset( $EmployeesID)){
        $emp_type_Data = DB::table('holiday_master')
        ->whereAny([
          'holiday_master.id','holiday_master.holiday_Date',

        ], 'like', '%'. $req->search_input.'%')
        ->get();
if($emp_type_Data){
  return view("all_Holidays")
  ->with('emp_type_Data', $emp_type_Data)

->with('role',$role);
}else{
  ?>
<script>
alert("No record found")
history.back()
</script>
<?php
}


      }else{
      return redirect()->route('login');
      }
  }
  public function all_leave_search(Request $req){
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');
      if(isset( $EmployeesID)){
        $emp_type_Data = DB::table('_leave')
        ->whereAny([
          '_leave.id','_leave.Name','_leave.Leave_Type','_leave.Employee_id',

        ], 'like', '%'. $req->search_input.'%')
        ->get();
        return view("all_Leave_Request")
        ->with('emp_type_Data', $emp_type_Data)
      ->with('role',$role);


      }else{
      return redirect()->route('login');
      }
  }
  public function all_travel_search(Request $req){
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');
      if(isset( $EmployeesID)){
        $emp_type_Data = DB::table('travel_info')
        ->whereAny([
          'travel_info.id','travel_info.Name','travel_info.Place_Of_Visit','travel_info.Summary','travel_info.Employee_id','travel_info.Travel_start_date',

        ], 'like', '%'. $req->search_input.'%')
        ->get();
        return view("All_Travel_Request")
        ->with('emp_type_Data', $emp_type_Data)
      ->with('role',$role);


      }else{
      return redirect()->route('login');
      }
  }
  public function all_tranings_search(Request $req){
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');
      if(isset( $EmployeesID)){
        $emp_type_Data = DB::table('training_info')
        ->whereAny([
          'training_info.id','training_info.Name','training_info.Training_Typ','training_info.Employee_id','training_info.Trainer',

        ], 'like', '%'. $req->search_input.'%')
        ->get();
        return view("All_Tranings")
        ->with('emp_type_Data', $emp_type_Data)
      ->with('role',$role);
      }else{
      return redirect()->route('login');
      }
  }
  public function all_projects_search(Request $req){
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');
      if(isset( $EmployeesID)){


        $emp_type_Data = DB::table('projects')
        ->join('all_users', 'all_users.Employee_id', '=', 'projects.Employee_id')
        ->select('all_users.*', 'projects.*')
        ->whereAny([
          'projects.id','projects.Project_Summary','projects.Priority','projects.Employee_id','projects.Assigned_Employees','projects.Project_Progress',

        ], 'like', '%'. $req->search_input.'%')
        ->get();
        return view("All_ Projects")
        ->with('emp_type_Data', $emp_type_Data)
      ->with('role',$role);


      }else{
      return redirect()->route('login');
      }
  }
  public function all_tasks_search(Request $req){
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');
      if(isset( $EmployeesID)){
        $emp_type_Data = DB::table('tasks')
        ->join('all_users', 'all_users.Employee_id', '=', 'tasks.Employee_id')
        ->select('all_users.*', 'tasks.*')
        ->whereAny([
          'tasks.id','tasks.Tasks_Title','tasks.Start_date','tasks.Employee_id','tasks.Status','tasks.task_Progress'

        ], 'like', '%'. $req->search_input.'%')
        ->get();
        return view("All_Tasks")
        ->with('emp_type_Data', $emp_type_Data)
      ->with('role',$role);
      }else{
      return redirect()->route('login');
      }
  }
  public function all_allowances_search(Request $req){
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');
      if(isset( $EmployeesID)){


        $emp_type_Data = DB::table('alloweance')
        ->join('all_users', 'all_users.Employee_id', '=', 'alloweance.Employee_id')
        ->select('all_users.*', 'alloweance.*')
        ->whereAny([
          'alloweance.id','alloweance.Month','alloweance.Alloweance_Titel','alloweance.Employee_id','alloweance.Allowance_Ammount_in_INR'

        ], 'like', '%'. $req->search_input.'%')
        ->get();
        return view("All_Alloweance")
        ->with('emp_type_Data', $emp_type_Data)
      ->with('role',$role);


      }else{
      return redirect()->route('login');
      }
  }
  public function all_loan_search(Request $req){
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');
      if(isset( $EmployeesID)){


        $emp_type_Data = DB::table('loan')
        ->join('all_users', 'all_users.Employee_id', '=', 'loan.Employee_id')
        ->select('all_users.*', 'loan.*')
        ->whereAny([
          'loan.id','loan.Month','loan.Year','loan.Employee_id','loan.Title','loan.Loan_Amount_in_INR'
        ], 'like', '%'. $req->search_input.'%')
        ->get();
        return view("All_Loan")
        ->with('emp_type_Data', $emp_type_Data)
      ->with('role',$role);


      }else{
      return redirect()->route('login');
      }
  }
  public function all_deductions_search(Request $req){
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');
      if(isset( $EmployeesID)){


        $emp_type_Data = DB::table('deductions')
        ->join('all_users', 'all_users.Employee_id', '=', 'deductions.Employee_id')
        ->select('all_users.*', 'deductions.*')
        ->whereAny([
          'deductions.id','deductions.Month','deductions.Year','deductions.Employee_id','deductions.deduction_Titel','deductions.deduction_Amount_in_INR'
        ], 'like', '%'. $req->search_input.'%')
        ->get();
        return view("All_Deductions")
        ->with('emp_type_Data', $emp_type_Data)
      ->with('role',$role);


      }else{
      return redirect()->route('login');
      }
  }

  public function all_other_payment_search(Request $req){
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');
      if(isset( $EmployeesID)){
        $emp_type_Data = DB::table('other_payments')
        ->join('all_users', 'all_users.Employee_id', '=', 'other_payments.Employee_id')
        ->select('all_users.*', 'other_payments.*')
        ->whereAny([
          'other_payments.id','other_payments.Month','other_payments.Year','other_payments.Employee_id','other_payments.Titel','other_payments.Amount_in_INR'
        ], 'like', '%'. $req->search_input.'%')
        ->get();
        return view("All_Other_Payment")
        ->with('emp_type_Data', $emp_type_Data)
      ->with('role',$role);
      }else{
      return redirect()->route('login');
      }
  }

  public function all_overtime_search(Request $req){
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');
      if(isset($EmployeesID)){
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
  public function all_award_search(Request $req){
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');
      if(isset( $EmployeesID)){
        $emp_type_Data = DB::table('award_info')
        ->whereAny([
          'award_info.id','award_info.Name','award_info.Award_Name','award_info.Employee_id','award_info.Gift','award_info.Award_date'
        ], 'like', '%'. $req->search_input.'%')
        ->get();
        return view("All_Award")
        ->with('emp_type_Data', $emp_type_Data)
      ->with('role',$role);


      }else{
      return redirect()->route('login');
      }
  }

  public function single_account_data(Request $req)
  {
      $id = $req->id;

      // Fetch data from the database
      $account_Data = DB::table('accounts')
          ->where('id', $id)
          ->first(); // Get a single record

      // Return the response as JSON
      return response()->json([
          'success' => true,
          'data' => $account_Data,
          'message' => $account_Data ? 'Data fetched successfully' : 'No data found'
      ]);
  }

  public function all_ticket_search(Request $req){
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');
      if(isset( $EmployeesID)){


        $emp_type_Data = DB::table('ticket_info')
        ->join('all_users', 'all_users.Employee_id', '=', 'ticket_info.Employee_id')
        ->select('all_users.*', 'ticket_info.*')
        ->whereAny([
          'ticket_info.id','ticket_info.Ticket_Details','ticket_info.Subject','ticket_info.Employee_id','ticket_info.Priority','ticket_info.Date'
        ], 'like', '%'. $req->search_input.'%')
        ->get();
        return view("All_Ticket")
        ->with('emp_type_Data', $emp_type_Data)
      ->with('role',$role);


      }else{
      return redirect()->route('login');
      }
  }
  public function all_transfer_search(Request $req){
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');
      if(isset( $EmployeesID)){


        $emp_type_Data = DB::table('transfer_info')
        ->join('all_users', 'all_users.Employee_id', '=', 'transfer_info.Employee_id')
        ->select('all_users.*', 'transfer_info.*')
        ->whereAny([
          'transfer_info.id','transfer_info.From_Department','transfer_info.To_Department','transfer_info.Employee_id','transfer_info.Company','transfer_info.Date'
        ], 'like', '%'. $req->search_input.'%')
        ->get();
        return view("All_Transfer")
        ->with('emp_type_Data', $emp_type_Data)
      ->with('role',$role);


      }else{
      return redirect()->route('login');
      }
  }
  public function all_promotion_search(Request $req){
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');
      if(isset( $EmployeesID)){


        $emp_type_Data = DB::table('_promotion')
        ->join('all_users', 'all_users.Employee_id', '=', '_promotion.Employee_id')
        ->select('all_users.*', '_promotion.*')
        ->whereAny([
          '_promotion.id','_promotion.Promotion_titel','_promotion.promated_by','_promotion.Promotion_Date','_promotion.Employee_id'
        ], 'like', '%'. $req->search_input.'%')
        ->get();
        return view("All_Promotion")
        ->with('emp_type_Data', $emp_type_Data)
      ->with('role',$role);


      }else{
      return redirect()->route('login');
      }
  }
  public function all_complaints_search(Request $req){
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');
      if(isset( $EmployeesID)){


        $emp_type_Data = DB::table('complaints')
        ->join('all_users', 'all_users.Employee_id', '=', 'complaints.Employee_id')
        ->select('all_users.*', 'complaints.*')
        ->whereAny([
          'complaints.id','complaints.Complaint_From','complaints.Complaint_To','complaints.Complaint_Title','complaints.Employee_id','complaints.Complaint_Date'
        ], 'like', '%'. $req->search_input.'%')
        ->get();
        return view("All_Complaints")
        ->with('emp_type_Data', $emp_type_Data)
      ->with('role',$role);


      }else{
      return redirect()->route('login');
      }
  }
  public function all_warning_search(Request $req){
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');
      if(isset( $EmployeesID)){


        $emp_type_Data = DB::table('warning')
        ->join('all_users', 'all_users.Employee_id', '=', 'warning.Employee_id')
        ->select('all_users.*', 'warning.*')
        ->whereAny([
          'warning.id','warning.Subject','warning.Status','warning.warning_Date','warning.Employee_id',
        ], 'like', '%'. $req->search_input.'%')
        ->get();
        return view("All_Warning")
        ->with('emp_type_Data', $emp_type_Data)
      ->with('role',$role);


      }else{
      return redirect()->route('login');
      }
  }
  public function all_payslip_search(Request $req){
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');
      if(isset( $EmployeesID)){


        $emp_type_Data = DB::table('payslip')
        ->join('all_users', 'all_users.Employee_id', '=', 'payslip.Employee_id')
        ->select('all_users.*', 'payslip.*')
        ->whereAny([
          'payslip.id','payslip.Net_Salarye','payslip.Salary_Month','payslip.Payroll_Date','payslip.Employee_id','payslip.Status',
        ], 'like', '%'. $req->search_input.'%')
        ->get();
        return view("All_Payslip")
        ->with('emp_type_Data', $emp_type_Data)
      ->with('role',$role);


      }else{
      return redirect()->route('login');
      }
  }


  public function all_swap_day_list(){
    $EmployeesID = session()->get('EmployeeID');
    $role = session()->get('role');
    if(isset( $EmployeesID)){

      return view("all_swipe_list")
    ->with('role',$role);


    }else{
    return redirect()->route('login');
    }
}

public function add_arrear_api(Request $req)
{
    // Validate the incoming request
    $validatedData = $req->validate([
        'Employee_Id'   => 'required|integer',
        'Arrear_Amount' => 'required|numeric|min:0',
        'Arrear_Reason' => 'required|string|max:255',
    ]);

    // Get current date and year
    $currentMonth = now()->format('m');
    $currentYear = now()->format('Y');

    // Check if the arrear entry already exists
    $existingArrear = DB::table('arrear_table')
        ->where('Employee_id', $validatedData['Employee_Id'])
        ->whereMonth('Arrear_Month', $currentMonth)
        ->whereYear('Arrear_Month', $currentYear)
        ->first();

    if ($existingArrear) {
        // Update existing arrear entry
        $updateSuccess = DB::table('arrear_table')
            ->where('id', $existingArrear->id) // Assuming "id" is the primary key
            ->update([
                'Arrear_Amount' => $validatedData['Arrear_Amount'],
                'Arrear_Reasons'=> $validatedData['Arrear_Reason'],

            ]);

        if ($updateSuccess) {
            return response()->json([
                'status' => 'success',
                'message' => 'Arrear updated successfully',
            ], 200); // HTTP 200: OK
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update arrear entry',
            ], 500); // HTTP 500: Internal Server Error
        }
    } else {
        // Insert new arrear entry
        $insertSuccess = DB::table('arrear_table')->insert([
            'Employee_id'   => $validatedData['Employee_Id'],
            'Arrear_Amount' => $validatedData['Arrear_Amount'],
            'Arrear_Reasons'=> $validatedData['Arrear_Reason'],
            'Arrear_Month'  => now(),
            'Arrear_Year'   => $currentYear,

        ]);

        if ($insertSuccess) {
            return response()->json([
                'status' => 'success',
                'message' => 'Arrear added successfully',
            ], 201); // HTTP 201: Created
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add arrear entry',
            ], 500); // HTTP 500: Internal Server Error
        }
    }
}








  public function holiday_report(){
    $EmployeesID = session()->get('EmployeeID');
    $role = session()->get('role');
    if(isset( $EmployeesID)){

      return view("holiday_report")
    ->with('role',$role);


    }else{
    return redirect()->route('login');
    }
}




public function for_me(){
 $for_me =  DB::statement('DROP TABLE `accounts`, `advance_master`, `alloweance`, `all_attandencetable`, `all_holiday`, `all_users`, `all__document`, `attendance_info`, `award_info`, `basic_salary`, `cache`, `cache_locks`, `calendar`, `complaints`, `deductions`, `department_master`, `failed_jobs`, `holiday_master`, `jobs`, `job_batches`, `leave_info`, `loan`, `migrations`, `other_payments`, `overtime`, `password_reset_tokens`, `penalty_master`, `per_day_work`, `projects`, `remaining_leave`, `roler_permissions`, `role_masrer`, `sessions`, `shift_master`, `shift__employee_type_master`, `tasks`, `test_bulk_uploade`, `ticket_info`, `training_info`, `transfer_info`, `travel_info`, `users`, `user_permissions`, `warning`, `_admin_settings`, `_attendance`, `_award__info`, `_emergency__contacts`, `_leave`, `_promotion`, `_qualifications`, `_social__profile`, `_work__experience`;');

 if ($for_me) {
 echo "yes";
 }else{
  echo "No";
 }
}



// view apis
// bank view
public function bank_account_api(Request $req){
  $emp_type_Data = DB::table('accounts')
  ->where('Employee_id', $req->Employee_id)
      ->get();

  return response()->json([
      'status' => 'success',
      'data' => $emp_type_Data
  ]);
}

// bank view
public function basic_salary_api(Request $req){
  $emp_type_Data = DB::table('basic_salary')
  ->where('Employee_id', $req->Employee_id)
      ->get();

  return response()->json([
      'status' => 'success',
      'data' => $emp_type_Data
  ]);
}

// bank view
public function allowances_view_api(Request $req){
  $emp_type_Data = DB::table('alloweance')
  ->where('Employee_id', $req->Employee_id)
      ->get();

  return response()->json([
      'status' => 'success',
      'data' => $emp_type_Data
  ]);
}

// loan view
public function loan_view_api(Request $req){
  $emp_type_Data = DB::table('loan')
  ->where('Employee_id', $req->Employee_id)
      ->get();

  return response()->json([
      'status' => 'success',
      'data' => $emp_type_Data
  ]);
}

// Deductions view
public function Deductions_view_api(Request $req){
  $emp_type_Data = DB::table('deductions')
  ->where('Employee_id', $req->Employee_id)
      ->get();

  return response()->json([
      'status' => 'success',
      'data' => $emp_type_Data
  ]);
}
// Deductions view
public function Leave_view_api(Request $req){
  $emp_type_Data = DB::table('_leave')
  ->where('Employee_id', $req->Employee_id)
      ->get();

  return response()->json([
      'status' => 'success',
      'data' => $emp_type_Data
  ]);
}



// Attendance_view_api view
public function Attendance_view_api(Request $req){
  $emp_type_Data = DB::table('all_attandencetable')
  ->where('Employee_id', $req->Employee_id)
      ->get();

  return response()->json([
      'status' => 'success',
      'data' => $emp_type_Data
  ]);
}



// absent_employee_list
public function absent_employee_list(Request $req)
{
    // If no date is provided, set $p0 to the current date
    $p0 = $req->date ?? Carbon::now()->toDateString(); // Default to current date if $date is null

    // Execute the stored procedure with the provided or default date
    $result = DB::select("CALL GetAbsenteesByDate(:date)", ['date' => $p0]);

    // Assign the result to the variable
    $vwabsentemployee_data = $result;

    // Return the response
    return response()->json([
        'status' => 'success',
        'data' => $vwabsentemployee_data
    ]);
}

// present_employee_list
public function present_employee_list(Request $req)
{
    // If no date is provided, set $p0 to the current date
    $p0 = $req->date ?? Carbon::now()->toDateString(); // Default to current date if $date is null

    // Execute the stored procedure with the provided or default date
    $result = DB::select("CALL GetPresenteesByDate(:date)", ['date' => $p0]);

    // Assign the result to the variable
    $vwabsentemployee_data = $result;

    // Return the response
    return response()->json([
        'status' => 'success',
        'data' => $vwabsentemployee_data
    ]);



}
// Let_commers_list
public function Let_commers_list(Request $req)
{
    // If no date is provided, set $p0 to the current date
    $p0 = $req->date ?? Carbon::now()->toDateString(); // Default to current date if $date is null

    // Execute the stored procedure with the provided or default date
    $result = DB::select("CALL GetLateComerByDate(:date)", ['date' => $p0]);

    // Assign the result to the variable
    $vwabsentemployee_data = $result;

    // Return the response
    return response()->json([
        'status' => 'success',
        'data' => $vwabsentemployee_data
    ]);



}

// 100 % attandence

public function attandance_100_top_10_list_api(Request $req)
{
   // Parse the date or use the current date if none is provided
  $parsedDate = $req->date ? Carbon::parse($req->date) : Carbon::now();
  $year = $parsedDate->year;  // Extracts the year
     $month = $parsedDate->format('m'); // Extracts the month in two-digit format (e.g., "01" for January)
  // Set parameters for the stored procedure
  $year = $year;
  $param1 = $month;
  $param2 = 10;
    // Execute the stored procedure
    $attendanceData = DB::select("CALL Get100PercentAttendanceTopN(?, ?, ?)", [$year, $param1, $param2]);
    // Return the response
    return response()->json([
        'status' => 'success',
        'data' => $attendanceData
    ]);
}


// top_10_present_list

public function top_10_present_list(Request $req) {
  // Parse the date or use the current date if none is provided
  $parsedDate = $req->date ? Carbon::parse($req->date) : Carbon::now();
  $year = $parsedDate->year;  // Extracts the year
     $month = $parsedDate->format('m'); // Extracts the month in two-digit format (e.g., "01" for January)
  // Set parameters for the stored procedure
  $year = $year;
  $param1 = $month;
  $param2 = 10;
  // Execute the stored procedure
  $attendanceData = DB::select("CALL Get100PercentAttendanceTopN(?, ?, ?)", [$year, $param1, $param2]);
  // Return the response
  return response()->json([
      'status' => 'success',
      'data' => $attendanceData
  ]);
}


public function totall_salary_amount_role_wise(Request $req) {
  try {
      // Parse the date from request or use the current date
      $parsedDate = $req->date ? Carbon::parse($req->date) : Carbon::now();
      $year = $parsedDate->year;
      $month = $parsedDate->format('m'); // Two-digit month format

      // Fetch salary data role-wise
      $salaryData = DB::table('arrear_table as a')
      ->join('all_users as u', 'u.Employee_id', '=', 'a.Employee_id')
      ->join('shift_master as s', 'u.shift_time', '=', 's.id')
      ->join('shift__employee_type_master as et', 'u.employee_type', '=', 'et.id')
      ->join('department_master as d', 'u.Department', '=', 'd.id')
      ->join('role_masrer as r', 'u.role', '=', 'r.id')
          ->select([
              'r.roles AS Role', // Grouping by Role
              'r.id AS Role_id', // Grouping by Role
              DB::raw("SUM(a.Salary_amount) AS Total_Salary_Amount"),
              DB::raw("SUM(a.OT_Amount) AS Total_OT_Amount"),
              DB::raw("SUM(a.Paid_Amount) AS Total_Paid_Amount"),
              DB::raw("COUNT(DISTINCT a.Employee_id) AS Total_Employees")
          ])
          ->whereYear('a.Arrear_Month', $year)
          ->whereMonth('a.Arrear_Month', $month)
          ->groupBy('r.roles','r.id') // Grouping by Role
          ->orderBy('Total_Salary_Amount', 'DESC') // Highest salary role first
          ->get();

      // Return success response
      return response()->json([
          'status' => 'success',
          'data' => $salaryData
      ], 200);

  } catch (\Exception $e) {
      // Log the error for debugging
      \Log::error("Error fetching role-wise salary: " . $e->getMessage());

      // Return a JSON response with the error message
      return response()->json([
          'status' => 'error',
          'message' => 'An error occurred while fetching salary data.',
          'error_details' => $e->getMessage() // Optional: Send error details in response
      ], 500);
  }
}




public function totall_salary_amount_employ_wise(Request $req) {
  try {
      // Parse the date from request or use the current date
      $parsedDate = $req->date ? Carbon::parse($req->date) : Carbon::now();
      $year = $parsedDate->year;
      $month = $parsedDate->format('m'); // Two-digit month format

      // Fetch salary data employee_type-wise
      $salaryData = DB::table('arrear_table as a')
      ->join('all_users as u', 'u.Employee_id', '=', 'a.Employee_id')
      ->join('shift_master as s', 'u.shift_time', '=', 's.id')
      ->join('shift__employee_type_master as et', 'u.employee_type', '=', 'et.id')
      ->join('department_master as d', 'u.Department', '=', 'd.id')
      ->join('role_masrer as r', 'u.role', '=', 'r.id')
          ->select([
              'et.EmpTypeName AS Employee_Type', // Grouping by Employee Type
              'et.id AS Employee_Type_id', // Grouping by Employee Type
              DB::raw("SUM(a.Salary_amount) AS Total_Salary_Amount"),
              DB::raw("SUM(a.OT_Amount) AS Total_OT_Amount"),
              DB::raw("SUM(a.Paid_Amount) AS Total_Paid_Amount"),
              DB::raw("COUNT(DISTINCT a.Employee_id) AS Total_Employees")
          ])
          ->whereYear('a.Arrear_Month', $year)
          ->whereMonth('a.Arrear_Month', $month)
          ->groupBy('et.EmpTypeName','et.id') // Grouping by Employee Type
          ->orderBy('Total_Salary_Amount', 'DESC') // Highest salary first
          ->get();

      // Return the response in JSON format
      return response()->json([
          'status' => 'success',
          'data' => $salaryData
      ]);

  } catch (\Exception $e) {
      \Log::error("Error fetching employee type-wise salary: " . $e->getMessage());
      return response()->json([
          'status' => 'error',
          'message' => 'An error occurred while fetching salary data.'
      ], 500);
  }
}


public function totall_salary_amount_department_wise(Request $req) {
  try {
      // Parse the date from request or use the current date
      $parsedDate = $req->date ? Carbon::parse($req->date) : Carbon::now();
      $year = $parsedDate->year;
      $month = $parsedDate->format('m'); // Two-digit month format

      // Fetch salary data department-wise
      $salaryData = DB::table('arrear_table as a')
      ->join('all_users as u', 'u.Employee_id', '=', 'a.Employee_id')
      ->join('shift_master as s', 'u.shift_time', '=', 's.id')
      ->join('shift__employee_type_master as et', 'u.employee_type', '=', 'et.id')
      ->join('department_master as d', 'u.Department', '=', 'd.id')
      ->join('role_masrer as r', 'u.role', '=', 'r.id')
          ->select([
              'd.Department_name', // Grouping by department
              'd.id as Department_id', // Grouping by department
              DB::raw("SUM(a.Salary_amount) AS Total_Salary_Amount"),
              DB::raw("SUM(a.OT_Amount) AS Total_OT_Amount"),
              DB::raw("SUM(a.Paid_Amount) AS Total_Paid_Amount"),
              DB::raw("COUNT(DISTINCT a.Employee_id) AS Total_Employees")
          ])
          ->whereYear('a.Arrear_Month', $year)
          ->whereMonth('a.Arrear_Month', $month)
          ->groupBy('d.Department_name','d.id') // Grouping by department
          ->orderBy('Total_Salary_Amount', 'DESC') // Highest salary department first
          ->get();

      // Return the response in JSON format
      return response()->json([
          'status' => 'success',
          'data' => $salaryData
      ]);

  } catch (\Exception $e) {
      \Log::error("Error fetching department-wise salary: " . $e->getMessage());
      return response()->json([
          'status' => 'error',
          'message' => 'An error occurred while fetching salary data.'
      ], 500);
  }
}



//totall salary amount month wise
public function totall_salary_amount(Request $req) {
    echo "<pre>";
    print_r($req->all());
    echo "</pre>";
    exit;
  try {
      // Define the target year and month (defaulting to November 2024 if not provided)

      $parsedDate = $req->date ? Carbon::parse($req->date) : Carbon::now();

      $year = $parsedDate->year;  // Extracts the year
     $month = $parsedDate->format('m'); // Extracts the month in two-digit format (e.g., "01" for January)




      // Execute the query using raw SQL
      $arrearData = DB::table('arrear_table as a')
      ->join('all_users as u', 'u.Employee_id', '=', 'a.Employee_id')
      ->join('shift_master as s', 'u.shift_time', '=', 's.id')
      ->join('shift__employee_type_master as et', 'u.employee_type', '=', 'et.id')
      ->join('department_master as d', 'u.Department', '=', 'd.id')
      ->join('role_masrer as r', 'u.role', '=', 'r.id')
      ->select([
          's.shift_name',
          'et.EmpTypeName',
          'd.Department_name',
          'r.roles',
          DB::raw("CONCAT(MONTHNAME(a.Arrear_Month), ' ', a.Arrear_Year) AS MonthYear"),
          'a.Employee_id',
          'a.OT_Amount',
          'a.Salary_amount',
          'a.OT_Hours',
          DB::raw("COALESCE(SUM(a.Paid_Amount), 0) AS Total_Paid_Amount"),
          DB::raw("
              TRIM(
                  REGEXP_REPLACE(
                      CONCAT_WS(
                          ' ',
                          COALESCE(CONCAT(UPPER(LEFT(u.f_name, 1)), LOWER(SUBSTRING(u.f_name, 2))), ''),
                          COALESCE(CONCAT(UPPER(LEFT(u.m_name, 1)), LOWER(SUBSTRING(u.m_name, 2))), ''),
                          COALESCE(CONCAT(UPPER(LEFT(u.l_name, 1)), LOWER(SUBSTRING(u.l_name, 2))), '')
                      ),
                      '\\s+',
                      ' '
                  )
              ) AS name
          ")
      ])
      ->whereYear('a.Arrear_Month', $year)
      ->whereMonth('a.Arrear_Month', $month)
      ->groupBy('s.shift_name', 'et.EmpTypeName', 'd.Department_name', 'r.roles', 'a.Arrear_Year', 'a.Arrear_Month', 'a.Employee_id')
      ->orderBy('s.shift_name')
      ->orderBy('et.EmpTypeName')
      ->orderBy('d.Department_name')
      ->orderBy('r.roles')
      ->orderBy('a.Arrear_Year')
      ->orderBy('a.Arrear_Month')
      ->orderBy('name')
      ->get();



      // Return the response in JSON format
      return response()->json([
          'status' => 'success',
          'data' => $arrearData
      ]);

  } catch (\Exception $e) {
      return response()->json([
          'status' => 'error',
          'message' => $e->getMessage()
      ], 500);
  }
}



//yrar wise



public function totall_salary_amount_role_wise_year(Request $req) {
  try {
      // Parse the date from request or use the current date
      $year = $req->year;  // Extracts the year

      // Fetch salary data role-wise
      $salaryData = DB::table('arrear_table as a')
      ->join('all_users as u', 'u.Employee_id', '=', 'a.Employee_id')
      ->join('shift_master as s', 'u.shift_time', '=', 's.id')
      ->join('shift__employee_type_master as et', 'u.employee_type', '=', 'et.id')
      ->join('department_master as d', 'u.Department', '=', 'd.id')
      ->join('role_masrer as r', 'u.role', '=', 'r.id')
          ->select([
              'r.roles AS Role', // Grouping by Role
              'r.id AS Role_id', // Grouping by Role
              DB::raw("SUM(a.Salary_amount) AS Total_Salary_Amount"),
              DB::raw("SUM(a.OT_Amount) AS Total_OT_Amount"),
              DB::raw("SUM(a.Paid_Amount) AS Total_Paid_Amount"),
              DB::raw("COUNT(DISTINCT a.Employee_id) AS Total_Employees")
          ])
          ->whereYear('a.Arrear_Month', $year)

          ->groupBy('r.roles','r.id') // Grouping by Role
          ->orderBy('Total_Salary_Amount', 'DESC') // Highest salary role first
          ->get();

      // Return success response
      return response()->json([
          'status' => 'success',
          'data' => $salaryData
      ], 200);

  } catch (\Exception $e) {
      // Log the error for debugging
      \Log::error("Error fetching role-wise salary: " . $e->getMessage());

      // Return a JSON response with the error message
      return response()->json([
          'status' => 'error',
          'message' => 'An error occurred while fetching salary data.',
          'error_details' => $e->getMessage() // Optional: Send error details in response
      ], 500);
  }
}




public function totall_salary_amount_employ_wise_year(Request $req) {
  try {
      // Parse the date from request or use the current date
      $year = $req->year;  // Extracts the year

      // Fetch salary data employee_type-wise
      $salaryData = DB::table('arrear_table as a')
      ->join('all_users as u', 'u.Employee_id', '=', 'a.Employee_id')
      ->join('shift_master as s', 'u.shift_time', '=', 's.id')
      ->join('shift__employee_type_master as et', 'u.employee_type', '=', 'et.id')
      ->join('department_master as d', 'u.Department', '=', 'd.id')
      ->join('role_masrer as r', 'u.role', '=', 'r.id')
          ->select([
              'et.EmpTypeName AS Employee_Type', // Grouping by Employee Type
              'et.id AS Employee_Type_id', // Grouping by Employee Type
              DB::raw("SUM(a.Salary_amount) AS Total_Salary_Amount"),
              DB::raw("SUM(a.OT_Amount) AS Total_OT_Amount"),
              DB::raw("SUM(a.Paid_Amount) AS Total_Paid_Amount"),
              DB::raw("COUNT(DISTINCT a.Employee_id) AS Total_Employees")
          ])
          ->whereYear('a.Arrear_Month', $year)

          ->groupBy('et.EmpTypeName','et.id') // Grouping by Employee Type
          ->orderBy('Total_Salary_Amount', 'DESC') // Highest salary first
          ->get();

      // Return the response in JSON format
      return response()->json([
          'status' => 'success',
          'data' => $salaryData
      ]);

  } catch (\Exception $e) {
      \Log::error("Error fetching employee type-wise salary: " . $e->getMessage());
      return response()->json([
          'status' => 'error',
          'message' => 'An error occurred while fetching salary data.'
      ], 500);
  }
}


public function totall_salary_amount_department_wise_year(Request $req) {
  try {
      // Parse the date from request or use the current date
      $year = $req->year;  // Extracts the year

      // Fetch salary data department-wise
      $salaryData = DB::table('arrear_table as a')
      ->join('all_users as u', 'u.Employee_id', '=', 'a.Employee_id')
      ->join('shift_master as s', 'u.shift_time', '=', 's.id')
      ->join('shift__employee_type_master as et', 'u.employee_type', '=', 'et.id')
      ->join('department_master as d', 'u.Department', '=', 'd.id')
      ->join('role_masrer as r', 'u.role', '=', 'r.id')
          ->select([
              'd.Department_name', // Grouping by department
              'd.id as Department_id', // Grouping by department
              DB::raw("SUM(a.Salary_amount) AS Total_Salary_Amount"),
              DB::raw("SUM(a.OT_Amount) AS Total_OT_Amount"),
              DB::raw("SUM(a.Paid_Amount) AS Total_Paid_Amount"),
              DB::raw("COUNT(DISTINCT a.Employee_id) AS Total_Employees")
          ])
          ->whereYear('a.Arrear_Month', $year)

          ->groupBy('d.Department_name','d.id') // Grouping by department
          ->orderBy('Total_Salary_Amount', 'DESC') // Highest salary department first
          ->get();

      // Return the response in JSON format
      return response()->json([
          'status' => 'success',
          'data' => $salaryData
      ]);

  } catch (\Exception $e) {
      \Log::error("Error fetching department-wise salary: " . $e->getMessage());
      return response()->json([
          'status' => 'error',
          'message' => 'An error occurred while fetching salary data.'
      ], 500);
  }
}



//totall salary amount month wise
public function totall_salary_amount_year(Request $req) {
  try {
      // Define the target year and month (defaulting to November 2024 if not provided)
      $year = $req->year;  // Extracts the year


      // Execute the query using raw SQL
      $arrearData = DB::table('arrear_table as a')
      ->join('all_users as u', 'u.Employee_id', '=', 'a.Employee_id')
      ->join('shift_master as s', 'u.shift_time', '=', 's.id')
      ->join('shift__employee_type_master as et', 'u.employee_type', '=', 'et.id')
      ->join('department_master as d', 'u.Department', '=', 'd.id')
      ->join('role_masrer as r', 'u.role', '=', 'r.id')
      ->select([
          's.shift_name',
          'et.EmpTypeName',
          'd.Department_name',
          'r.roles',
          DB::raw("CONCAT(MONTHNAME(a.Arrear_Month), ' ', a.Arrear_Year) AS MonthYear"),
          'a.Employee_id',
          'a.OT_Amount',
          'a.Salary_amount',
          'a.OT_Hours',
          DB::raw("COALESCE(SUM(a.Paid_Amount), 0) AS Total_Paid_Amount"),
          DB::raw("
              TRIM(
                  REGEXP_REPLACE(
                      CONCAT_WS(
                          ' ',
                          COALESCE(CONCAT(UPPER(LEFT(u.f_name, 1)), LOWER(SUBSTRING(u.f_name, 2))), ''),
                          COALESCE(CONCAT(UPPER(LEFT(u.m_name, 1)), LOWER(SUBSTRING(u.m_name, 2))), ''),
                          COALESCE(CONCAT(UPPER(LEFT(u.l_name, 1)), LOWER(SUBSTRING(u.l_name, 2))), '')
                      ),
                      '\\s+',
                      ' '
                  )
              ) AS name
          ")
      ])
      ->whereYear('a.Arrear_Month', $year)

      ->groupBy('s.shift_name', 'et.EmpTypeName', 'd.Department_name', 'r.roles', 'a.Arrear_Year', 'a.Arrear_Month', 'a.Employee_id')
      ->orderBy('s.shift_name')
      ->orderBy('et.EmpTypeName')
      ->orderBy('d.Department_name')
      ->orderBy('r.roles')
      ->orderBy('a.Arrear_Year')
      ->orderBy('a.Arrear_Month')
      ->orderBy('name')
      ->get();

      // Return the response in JSON format
      return response()->json([
          'status' => 'success',
          'data' => $arrearData
      ]);

  } catch (\Exception $e) {
      return response()->json([
          'status' => 'error',
          'message' => $e->getMessage()
      ], 500);
  }
}









public function Default_Absentees_By_Month(Request $req) {
  try {
      // Retrieve date or use current date if not provided
      $parsedDate = $req->date ? Carbon::parse($req->date) : Carbon::now();

      // Extract year and month from the parsed date
      $year = $parsedDate->year;  // Extract year
      $month = $parsedDate->month; // Extract month

      // Format the year and month in YYYY-MM format
      $p0 = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT); // Ensure month has two digits

      // Execute the stored procedure with the correct value
      $attendanceData = DB::select("CALL GetDefaultAbsenteesByMonth(:p0)", [
          'p0' => $p0
      ]);

      return response()->json([
          'status' => 'success',
          'data' => $attendanceData
      ]);
  } catch (\Exception $e) {
      return response()->json([
          'status' => 'error',
          'message' => $e->getMessage()
      ], 500);
  }
}



//attandance_100_list
public function attandance_100_list_api(Request $req, $number = null)
{
  $parsedDate = $req->date ? Carbon::parse($req->date) : Carbon::now();
  // Parse the date or use the current date if none is provided
  $year = $parsedDate->year;
  $month = $parsedDate->month;
  // Set parameters for the stored procedure
  $year = 2024;
  $param1 = $month ;
  $param2 = 0;
  // Execute the stored procedure
  $attendanceData = DB::select("CALL Get100PercentAttendanceTopN(?, ?, ?)", [$year, $param1, $param2]);
  // Return the response
  return response()->json([
      'status' => 'success',
      'data' => $attendanceData
  ]);
}

// association_time_api
public function association_time_api(Request $req)
{
    try {
        // Fetch data from the database
        $attendanceData = DB::table('vwassociatedyears')->get();

        // Return a successful JSON response
        return response()->json([
            'status' => 'success',
            'data' => $attendanceData
        ], 200); // Use proper HTTP status codes
    } catch (\Exception $e) {
        // Handle exceptions and return an error response
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to retrieve data.',
            'error' => $e->getMessage() // Provide detailed error for debugging if needed
        ], 500); // Internal server error
    }
}



public function company_lable_data(Request $req) {
  try {
      // Retrieve date or use current date if not provided
      $parsedDate = $req->date ? Carbon::parse($req->date) : Carbon::now();

      // Extract year and month from the parsed date
      $year = $parsedDate->year;  // Extract year
      $month = $parsedDate->month; // Extract month

      // Define stored procedure parameters
      $p0 = 0; // Adjust as needed
      $p1 = 0; // Adjust as needed
      $p2 = 0; // Adjust as needed
      $p3 = 0; // Adjust as needed
      $p4 = $year;   // Pass extracted year
      $p5 = $month;  // Pass extracted month

      // Execute the stored procedure
      $salaryData = DB::select("CALL GetSalaryAndOTDetails(?, ?, ?, ?, ?, ?)", [
          $p0, $p1, $p2, $p3, $p4, $p5
      ]);

      return response()->json([
          'status' => 'success',
          'data' => $salaryData
      ]);
  } catch (\Exception $e) {
      return response()->json([
          'status' => 'error',
          'message' => $e->getMessage()
      ], 500);
  }
}



public function role_lable_data(Request $req) {
  try {
      // Retrieve date or use current date if not provided
      $parsedDate = $req->date ? Carbon::parse($req->date) : Carbon::now();

      // Extract year and month from the parsed date
      $year = $parsedDate->year;  // Extract year
      $month = $parsedDate->month; // Extract month

      // Define stored procedure parameters
      $p0 = 0; // Adjust as needed
      $p1 = 0; // Adjust as needed
      $p2 = 0; // Adjust as needed
      $p3 = 0; // Adjust as needed
      $p4 = $year;   // Pass extracted year
      $p5 = $month;  // Pass extracted month

      // Execute the stored procedure
      $salaryData = DB::select("CALL GetSalaryAndOTDetails(?, ?, ?, ?, ?, ?)", [
          $p0, $p1, $p2, $p3, $p4, $p5
      ]);

      return response()->json([
          'status' => 'success',
          'data' => $salaryData
      ]);
  } catch (\Exception $e) {
      return response()->json([
          'status' => 'error',
          'message' => $e->getMessage()
      ], 500);
  }
}




public function department_lable_data(Request $req) {
  try {
      // Retrieve date or use current date if not provided
      $parsedDate = $req->date ? Carbon::parse($req->date) : Carbon::now();

      // Extract year and month from the parsed date
      $year = $parsedDate->year;  // Extract year
      $month = $parsedDate->month; // Extract month

      // Define stored procedure parameters
      $p0 = 0; // Adjust as needed
      $p1 = 0; // Adjust as needed
      $p2 = 0; // Adjust as needed
      $p3 = 0; // Adjust as needed
      $p4 = $year;   // Pass extracted year
      $p5 = $month;  // Pass extracted month

      // Execute the stored procedure
      $salaryData = DB::select("CALL GetSalaryAndOTDetails(?, ?, ?, ?, ?, ?)", [
          $p0, $p1, $p2, $p3, $p4, $p5
      ]);

      return response()->json([
          'status' => 'success',
          'data' => $salaryData
      ]);
  } catch (\Exception $e) {
      return response()->json([
          'status' => 'error',
          'message' => $e->getMessage()
      ], 500);
  }
}



public function emptype_type_lable_data(Request $req) {
  try {
      // Retrieve date or use current date if not provided
      $parsedDate = $req->date ? Carbon::parse($req->date) : Carbon::now();

      // Extract year and month from the parsed date
      $year = $parsedDate->year;  // Extract year
      $month = $parsedDate->month; // Extract month

      // Define stored procedure parameters
      $p0 = 0; // Adjust as needed
      $p1 = 0; // Adjust as needed
      $p2 = 0; // Adjust as needed
      $p3 = 0; // Adjust as needed
      $p4 = $year;   // Pass extracted year
      $p5 = $month;  // Pass extracted month

      // Execute the stored procedure
      $salaryData = DB::select("CALL GetSalaryAndOTDetails(?, ?, ?, ?, ?, ?)", [
          $p0, $p1, $p2, $p3, $p4, $p5
      ]);

      return response()->json([
          'status' => 'success',
          'data' => $salaryData
      ]);
  } catch (\Exception $e) {
      return response()->json([
          'status' => 'error',
          'message' => $e->getMessage()
      ], 500);
  }
}




public function company_data_all_parms(Request $req) {
  try {

// Extract year and month from the parsed date
$year = $req->year;  // Extract year
$month = $req->month; // Extract month
// Define stored procedure parameters
$p0 = 0; // Adjust as needed
$p1 = $req->emp_type; // Adjust as needed
$p2 =  $req->department; // Adjust as needed
$p3 = $req->role; // Adjust as needed
$p4 = $year;   // Pass extracted year
$p5 = $month;  // Pass extracted month



      // Execute the stored procedure
      $salaryData = DB::select("CALL GetSalaryAndOTDetails(?, ?, ?, ?, ?, ?)", [
          $p0, $p1, $p2, $p3, $p4, $p5
      ]);

      return response()->json([
          'status' => 'success',
          'data' => $salaryData
      ]);
  } catch (\Exception $e) {
      return response()->json([
          'status' => 'error',
          'message' => $e->getMessage()
      ], 500);
  }
}

public function company_data_all_parms_2(Request $req) {
  try {

    $parsedDate = $req->date ? Carbon::parse($req->date) : Carbon::now();

    // Extract year and month from the parsed date
    $year = $parsedDate->year;  // Extract year
    $month = $parsedDate->month; // Extract month
// Define stored procedure parameters
$p0 = 0; // Adjust as needed
$p1 = $req->emp_type; // Adjust as needed
$p2 =  $req->department; // Adjust as needed
$p3 = $req->role; // Adjust as needed
$p4 = $year;   // Pass extracted year
$p5 = $month;  // Pass extracted month



      // Execute the stored procedure
      $salaryData = DB::select("CALL GetSalaryAndOTDetails(?, ?, ?, ?, ?, ?)", [
          $p0, $p1, $p2, $p3, $p4, $p5
      ]);

      return response()->json([
          'status' => 'success',
          'data' => $salaryData
      ]);
  } catch (\Exception $e) {
      return response()->json([
          'status' => 'error',
          'message' => $e->getMessage()
      ], 500);
  }
}









//true false











}

<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class leaveController extends Controller
{
    public function total_leave(Request $req) {
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');

        if ($EmployeesID) {
            $leave_Data = DB::table('_leave')->get();
            return view("total_leave")
                ->with('users', $leave_Data)
                ->with('role', $role);
        } else {
            return redirect()->route('login');
        }
    }



    // reports

    public function total_salary(Request $req) {
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');
      if(isset($EmployeesID)){
        $leave_Data = DB::table('_leave')
        ->get();
        return view("total_salary_report")
        ->with('users', $leave_Data)
      ->with('role',$role);
      }else{
        return redirect()->route('login');
      }
    }

    // Absent_List
    public function Absent_List(Request $req) {
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');
      if(isset($EmployeesID)){
        $leave_Data = DB::table('_leave')
        ->get();
        return view("Absent_List")
        ->with('users', $leave_Data)
      ->with('role',$role);
      }else{
        return redirect()->route('login');
      }
    }


     // Absent_List
     public function Defult_Absent_List(Request $req) {
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');
      if(isset($EmployeesID)){
        $leave_Data = DB::table('_leave')
        ->get();
        return view("defult_absent")
        ->with('users', $leave_Data)
      ->with('role',$role);
      }else{
        return redirect()->route('login');
      }
    }


         // Absent_List
         public function total_salary_summary(Request $req) {
          $EmployeesID = session()->get('EmployeeID');
          $role = session()->get('role');
          if(isset($EmployeesID)){
            $leave_Data = DB::table('_leave')
            ->get();
            return view("total_salary_summary")
            ->with('users', $leave_Data)
          ->with('role',$role);
          }else{
            return redirect()->route('login');
          }
        }


    // Present List

    public function Present_List(Request $req) {
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');
      if(isset($EmployeesID)){
        $leave_Data = DB::table('_leave')
        ->get();
        return view("Present_List")
        ->with('users', $leave_Data)
      ->with('role',$role);
      }else{
        return redirect()->route('login');
      }
    }

    //Let_Commers_List()
    public function Let_Commers_List(Request $req) {
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');
      if(isset($EmployeesID)){
        $leave_Data = DB::table('_leave')
        ->get();
        return view("late_commers_list")
        ->with('users', $leave_Data)
      ->with('role',$role);
      }else{
        return redirect()->route('login');
      }
    }

//attandance_100_list
public function attandance_100_list(Request $req) {
  $EmployeesID = session()->get('EmployeeID');
  $role = session()->get('role');
  if(isset($EmployeesID)){
    $leave_Data = DB::table('_leave')
    ->get();
    return view("attandance_100_list")
    ->with('users', $leave_Data)
  ->with('role',$role);
  }else{
    return redirect()->route('login');
  }
}

// attandance_100_top_10_list
public function attandance_100_top_10_list(Request $req) {
  $EmployeesID = session()->get('EmployeeID');
  $role = session()->get('role');
  if(isset($EmployeesID)){
    $leave_Data = DB::table('_leave')
    ->get();
    return view("attandance_100_top_10_list")
    ->with('users', $leave_Data)
  ->with('role',$role);
  }else{
    return redirect()->route('login');
  }
}

//
// association_time
public function association_time(Request $req) {
  $EmployeesID = session()->get('EmployeeID');
  $role = session()->get('role');
  if(isset($EmployeesID)){
    $leave_Data = DB::table('_leave')
    ->get();
    return view("association_time")
    ->with('users', $leave_Data)
  ->with('role',$role);
  }else{
    return redirect()->route('login');
  }
}


      public function total_deducations(Request $req) {
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
        if(isset($EmployeesID)){
          $leave_Data = DB::table('_leave')
          ->get();
          return view("deduction_report")
          ->with('users', $leave_Data)
        ->with('role',$role);
        }else{
          return redirect()->route('login');
        }
      }

      public function total_Loan(Request $req) {
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
        if(isset($EmployeesID)){
          $leave_Data = DB::table('_leave')
          ->get();
          return view("loan_report")
          ->with('users', $leave_Data)
        ->with('role',$role);
        }else{
          return redirect()->route('login');
        }
      }



      public function search_deductions(Request $req) {

         // Fetch data from the database
    // $deductionsData =


    $search_by_inp = $req->search_inp;
    $role = session()->get('role');
    $users = DB::table('deductions')
    ->join('all_users', 'deductions.Employee_id', '=', 'all_users.Employee_id')
    ->select(
        'deductions.*',
        'all_users.f_name',
        'all_users.m_name',
        'all_users.l_name'
    )

    ->whereAny([
      'all_users.f_name',
        'all_users.m_name',
        'all_users.l_name',
       'deductions.Employee_id', 'deductions.Month', 'deductions.Year', 'deductions.deduction_Titel', 'deductions.deduction_Amount_in_INR', 'deductions.created_by', 'deductions.updated_by', 'deductions.created_at', 'deductions.updated_at'



    ], 'like', '%'.$search_by_inp.'%')
    ->paginate($req->limit);

    $arr = array(
        'status'=>'true',
        'message' => 'data Found',
        'all_users'=> $users,
        'role'=> $role
         );
      echo json_encode($arr);

}



      public function deducations_short_api(Request $req)
      {
          $role = session()->get('role');

          $users = $leave_Data = DB::table('deductions')
          ->join('all_users', 'deductions.Employee_id', '=', 'all_users.Employee_id')
          ->select(
              'deductions.*',
              'all_users.f_name',
              'all_users.m_name',
              'all_users.l_name'
          )

          ->orderBy($req->short_by, $req->method)
          ->paginate($req->limit);

          $arr = array(
              'status'=>'true',
              'message' => 'data Found',
              'all_users'=> $users,
              'role'=> $role
               );
            echo json_encode($arr);

      }



      public function search_leave(Request $req) {
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
        if(isset($EmployeesID)){
          $leave_Data = DB::table('_leave')
          ->whereAny([
            'Name','Employee_id','Leave_Type','Start_Date','End_Date',
            'Description','Remarks_by_Approve','Status','Total_Days',

          ], 'like', '%'. $req->search_input.'%')
          ->get();


          if($leave_Data){
            return view("total_leave")
            ->with('users', $leave_Data)
          ->with('role',$role);
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















      public function all_leaves_api(Request $req)
            {
                $role = session()->get('role');
                $users = $leave_Data = DB::table('_leave')
                ->join('leave_type_master', 'leave_type_master.id', '=', '_leave.Leave_Type')
                ->join('all_users', 'all_users.Employee_id', '=', '_leave.Employee_id')
                ->join('department_master', 'department_master.id', '=', 'all_users.Department')
                ->select('_leave.*', 'leave_type_master.Name as leave_Name','department_master.Department_name')
                ->paginate($req->limit);

                $arr = array(
                    'status'=>'true',
                    'message' => 'data Found',
                    'all_users'=> $users,
                    'role'=> $role
                     );
                  echo json_encode($arr);

            }


            public function all_leaves_short_api(Request $req)
            {
                $role = session()->get('role');

                $users = $leave_Data = DB::table('_leave')
                ->join('leave_type_master', 'leave_type_master.id', '=', '_leave.Leave_Type')
                ->join('all_users', 'all_users.Employee_id', '=', '_leave.Employee_id')
                ->join('department_master', 'department_master.id', '=', 'all_users.Department')
                ->select('_leave.*', 'leave_type_master.Name as leave_Name','department_master.Department_name')
                ->orderBy($req->short_by, $req->method)
                ->paginate($req->limit);




                $arr = array(
                    'status'=>'true',
                    'message' => 'data Found',
                    'all_users'=> $users,
                    'role'=> $role
                     );
                  echo json_encode($arr);

            }



            public function all_leaves_search_api(Request $req)
            {
                $search_by_inp = $req->search_inp;
                $role = session()->get('role');
                $users = $leave_Data = DB::table('_leave')
                ->join('leave_type_master', 'leave_type_master.id', '=', '_leave.Leave_Type')
                ->join('all_users', 'all_users.Employee_id', '=', '_leave.Employee_id')
                ->join('department_master', 'department_master.id', '=', 'all_users.Department')
                ->select('_leave.*', 'leave_type_master.Name as leave_Name','department_master.Department_name')

                ->whereAny([
                    '_leave.Name',
                    '_leave.Employee_id',
                    '_leave.Leave_Type',
                    '_leave.Start_Date',
                    '_leave.Description',
                    'department_master.Department_name',
                    'leave_type_master.Name',


                ], 'like', '%'.$search_by_inp.'%')
                ->paginate($req->limit);

                $arr = array(
                    'status'=>'true',
                    'message' => 'data Found',
                    'all_users'=> $users,
                    'role'=> $role
                     );
                  echo json_encode($arr);

            }


            // all_holiday_api
            public function all_holiday_api(Request $req)
            {
              $role = session()->get('role');
              $users = $leave_Data = DB::table('holiday_master')
              ->paginate($req->limit);

              $arr = array(
                  'status'=>'true',
                  'message' => 'data Found',
                  'all_users'=> $users,
                  'role'=> $role
                   );
                echo json_encode($arr);

          }

          public function all_holiday_short_api(Request $req)
          {
              $role = session()->get('role');

              $users = $leave_Data = DB::table('holiday_master')
              ->orderBy($req->short_by, $req->method)
              ->paginate($req->limit);
              $arr = array(
                  'status'=>'true',
                  'message' => 'data Found',
                  'all_users'=> $users,
                  'role'=> $role
                   );
                echo json_encode($arr);

          }

          public function all_holiday_search_api(Request $req)
          {
              $search_by_inp = $req->search_inp;
              $role = session()->get('role');

              $users = DB::table('holiday_master')
              ->whereAny([
                'Holiday_name',
                'holiday_Date',
            ], 'like', '%'.$search_by_inp.'%')
            ->paginate($req->limit);


              return response()->json([
                  'status' => 'true',
                  'message' => 'Data Found',
                  'all_users' => $users,
                  'role' => $role
              ]);
          }



}

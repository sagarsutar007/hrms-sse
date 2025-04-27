<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class user_details_Controller extends Controller
{

    public function all_users(){
        $role = session()->get('role');
        //role_masrer
$role_masrer = DB::table('role_masrer')
->get();
        return view("all_Users")
        ->with('role_masrer',$role_masrer)
            ->with('role', $role);
    }
    public function lock_arrear_data(Request $req)
    {
        $arrear_month = $req->arrear_month;
        $insert_m = $req->arrear_month;
        $paid_amount = $req->paid_amount;
        $net_amount = $req->net_amount;
        $OT_Hours = $req->OT_Hours;
        $OT_Amount = $req->OT_Amount;



        // If arrear_month is 0, set it to the current year and month
        if ($arrear_month == 0) {
            $arrear_month = now()->format('Y-m');

            $deduction_month=now()->format('F');
            $insert_m =  now()->format('Y-m');
        }

        if (strpos($arrear_month, '-') !== false) {
            [$year, $month] = explode('-', $arrear_month);
            $insert_m = $year . '-' . $month . '-' . '28';
        } else {
            return response()->json([
                'error' => 'Invalid arrear_month format. Expected YYYY-MM.',
                'value_received' => $arrear_month
            ], 400);
        }




          $formattedDate = Carbon::create($year, $month, 1)->format('F-Y');

          $months = array(
            1 => "January", 2 => "February", 3 => "March",
            4 => "April", 5 => "May", 6 => "June",
            7 => "July", 8 => "August", 9 => "September",
            10 => "October", 11 => "November", 12 => "December"
        );

        $ddm = $months[01].' ' .$year;



        // Query the arrear_table with the Employee ID, Year, and Month
        $arrearData = DB::table('arrear_table')
            ->where('Employee_id', $req->emp_id)
            ->whereYear('Arrear_Month', $year) // Assuming 'created_at' is the date column
            ->whereMonth('Arrear_Month', $month)
            ->get();

            $dudections_ids =  DB::table('deductions')
            ->where('Employee_id', $req->emp_id,)
            ->where('Month', $ddm)
            ->get()
            ->toArray();
            $a = 0;
            if(count($dudections_ids) >= 1 ){
                $a = 1;

            foreach ($dudections_ids as $dd_ids) {
                if(isset($dd_ids->Advance_Ids)){
                    $loanRemaining = DB::table('loan')
                    ->where('Loan_id', $dd_ids->Advance_Ids)
                    ->value('Loan_Remaining');

                    $updated = DB::table('loan')
                ->where('Loan_id', $dd_ids->Advance_Ids)
                ->update(['Loan_Remaining' => $loanRemaining - 1000]); // Set to the desired value
                }
            }

                $update_deduction =   DB::table('deductions')
                ->where('Employee_id', $req->emp_id,)
                ->where('Month', $ddm)
                ->update(['Deduction_Paid_Flag' => 1]);
            }







        // Return a JSON response
        $cont = count($arrearData);
        if( $cont == 0){
            $insert_arrear_Data = DB::table('arrear_table')
            ->insertOrIgnore([
            'Employee_id'=>$req->emp_id,
            'Arrear_Amount'=> 0,
             'Arrear_Reasons'=> ' ',
             'Arrear_Month'=>$insert_m,
             'Arrear_Year'=>$year,
             'Paid_Amount'=> $paid_amount,
             'Paid_Flag'=> 1,
             'Salary_amount'=>  $net_amount,
             'OT_Hours'=> $OT_Hours,
             'OT_Amount'=> $OT_Amount,

             'Pay_Date'=> now()

            ]);
        }else {
            $update_quri = DB::table('arrear_table')
            ->where('Employee_id', $req->emp_id)
            ->whereYear('Arrear_Month', $year) // Assuming 'created_at' is the date column
            ->whereMonth('Arrear_Month', $month)
             ->update( [
            'Paid_Flag'=> 1,
            'Paid_Amount'=> $paid_amount,
             'Pay_Date'=> now()

            ]);
        }

        if($net_amount - $paid_amount != 0){
            $insert_m2 = $year . '-' .$month + 1 . '-' . 28 ;
            if($month == 12){
                $year = $year + 1;
                $month = '01';
                $insert_m2 = $year . '-' .$month. '-' . 28 ;
            }else{
              $month = $month + 1  ;
            }

            $arrearData2 = DB::table('arrear_table')
            ->where('Employee_id', $req->emp_id)
            ->whereYear('Arrear_Month', $year) // Assuming 'created_at' is the date column
            ->whereMonth('Arrear_Month', $month)
            ->get()
            ->toArray();

            if(count($arrearData2) == 1){
                foreach ($arrearData2 as $data) {
                    $new_arrear_amt =  $data->arrear_amount ; // Prints arrear_amount for each record
                    $new_arrear_reason =  $data->Arrear_Reasons ; // Prints arrear_amount for each record
                }
                $update_quri2 = DB::table('arrear_table')
                ->where('Employee_id', $req->emp_id)
                ->whereYear('Arrear_Month', $year) // Assuming 'created_at' is the date column
                ->whereMonth('Arrear_Month', $month)
                 ->update( [

                'Arrear_Amount'=>  $new_arrear_amt + $net_amount - $paid_amount,
                 'Arrear_Reasons'=> $new_arrear_reason . ' And Previous month remaining amount',
                ]);


            }else{


                $insert_arrear_Data = DB::table('arrear_table')
                ->insertOrIgnore([
                'Employee_id'=>$req->emp_id,
                'Arrear_Amount'=> $net_amount - $paid_amount,
                 'Arrear_Reasons'=> 'Previous month remaining amount',
                 'Arrear_Month'=>$insert_m2,
                 'Arrear_Year'=>$year,

                ]);
            }


        }

        return response()->json([
            'success' => true,
            'message' => 'Salary Paid successfully '
        ]);
    }

    public function lock_one_click_arrear_data(Request $req)
    {



        $employee_ids = DB::table('all_users')->pluck('Employee_id')->toArray(); // Array of Employee IDs

        foreach ($employee_ids as $employee_id) {
            $arrear_month = $req->arrear_month;
            $insert_m = $req->arrear_month;

            // If arrear_month is 0, set it to the current year and month
            if ($arrear_month == 0) {
                $arrear_month = now()->format('Y-m');

                $deduction_month=now()->format('F');
                $insert_m =  now()->format('Y-m');
            }

            // Extract year and month from arrear_month
            [$year, $month] = explode('-', $arrear_month);
            $insert_m = $year . '-' .$month . '-' . 28 ;


              $formattedDate = Carbon::create($year, $month, 1)->format('F-Y');

              $months = array(
                1 => "January", 2 => "February", 3 => "March",
                4 => "April", 5 => "May", 6 => "June",
                7 => "July", 8 => "August", 9 => "September",
                10 => "October", 11 => "November", 12 => "December"
            );

            $ddm = $months[01].' ' .$year;



            // Query the arrear_table with the Employee ID, Year, and Month
            $arrearData = DB::table('arrear_table')
                ->where('Employee_id', $employee_id)
                ->whereYear('Arrear_Month', $year) // Assuming 'created_at' is the date column
                ->whereMonth('Arrear_Month', $month)
                ->get();

                $dudections_ids =  DB::table('deductions')
                ->where('Employee_id', $employee_id,)
                ->where('Month', $ddm)
                ->get()
                ->toArray();
                $a = 0;
                if(count($dudections_ids) >= 1 ){
                    $a = 1;

    foreach ($dudections_ids as $dd_ids) {
        if(isset($dd_ids->Advance_Ids)){
            $loanRemaining = DB::table('loan')
            ->where('Loan_id', $dd_ids->Advance_Ids)
            ->value('Loan_Remaining');

            $updated = DB::table('loan')
          ->where('Loan_id', $dd_ids->Advance_Ids)
          ->update(['Loan_Remaining' => $loanRemaining - 1000]); // Set to the desired value
        }
    }

                    $update_deduction =   DB::table('deductions')
                    ->where('Employee_id', $employee_id,)

                    ->where('Month', $ddm)
                    ->update(['Deduction_Paid_Flag' => 1]);
                }







            // Return a JSON response
            $cont = count($arrearData);
            if( $cont == 0){
                $insert_arrear_Data = DB::table('arrear_table')
                ->insertOrIgnore([
                'Employee_id'=>$employee_id,
                'Arrear_Amount'=> 0,
                 'Arrear_Reasons'=> ' ',
                 'Arrear_Month'=>$insert_m,
                 'Arrear_Year'=>$year,
                 'Paid_Flag'=> 1,
                 'Pay_Date'=> now()

                ]);
            }else {
                $update_quri = DB::table('arrear_table')
                ->where('Employee_id', $employee_id)
                ->whereYear('Arrear_Month', $year) // Assuming 'created_at' is the date column
                ->whereMonth('Arrear_Month', $month)
                 ->update( [
                'Paid_Flag'=> 1,
                 'Pay_Date'=> now()

                ]);
            }



        }
        return response()->json([
            'success' => true,
            'message' => 'Salary Paid successfully for all employees',
        ]);
    }



    public function  one_user_data_with_id(Request $req){
        // Fetch user data with pagination
        $userData = DB::table('users')
        ->join('role_masrer', 'users.role', '=', 'role_masrer.id')
        ->where('Employee_id', $req->id)
        ->get();

        // Return a JSON response
        return response()->json([
            'success' => true,
            'message' => 'Users retrieved successfully.',
            'attandence_data' => $userData,
        ]);
    }

    public function delet_user_with_id(Request $req)
    {
        $deleted = DB::table('users')->where('Employee_id', $req->id)->delete(); // Returns the number of records deleted

        if ($deleted) {
            echo '<script> alert("User Deleted") history.back()</script>';
        } else {
            echo '<script>
            alert("User Not Deleted")
            history.back()
            </script>';
        }
    }



    public function all_users_api(Request $req)
    {

        // Fetch user data with pagination
        $userData = DB::table('users')
        ->join('role_masrer', 'users.role', '=', 'role_masrer.id')
            ->paginate($req->limit);

        // Return a JSON response
        return response()->json([
            'success' => true,
            'message' => 'Users retrieved successfully.',
            'attandence_data' => $userData, // Current page's user data

        ]);
    }

    public function all_users_short_api(Request $req){
              // Fetch user data with pagination
              $userData = DB::table('users')
              ->join('role_masrer', 'users.role', '=', 'role_masrer.id')
              ->orderby($req->short_by , $req->method)
                  ->paginate($req->limit);

              // Return a JSON response
              return response()->json([
                  'success' => true,
                  'message' => 'Users retrieved successfully.',
                  'attandence_data' => $userData, // Current page's user data

              ]);
    }

    public function all_users_search_api(Request $req){


  // Fetch user data with pagination

  $search_by_inp = $req->input;
  $userData = DB::table('users')
  ->join('role_masrer', 'users.role', '=', 'role_masrer.id')
  ->whereAny([
    'users.name',
    'users.email',
    'users.mobile_number',
    'users.Employee_id',
    'role_masrer.roles',
], 'like', '%'.$search_by_inp.'%')
->paginate($req->limit);
  // Return a JSON response
  return response()->json([
      'success' => true,
      'message' => 'Users retrieved successfully.',
      'attandence_data' => $userData, // Current page's user data
  ]);

    }


  public function  single_user(Request $req){
    $user_id =  $req->id;
    if (isset($user_id)) {
      $userData = DB::table('all_users')
      ->where('id', $user_id)
      ->get();
      if (isset($userData)) {
        $userCount = count($userData);

        if ($userCount === 1) {
          foreach ($userData as $user) {
            $name = $user->f_name . " " . $user->m_name . " " . $user->l_name;
            $email = $user->email;
            $Employee_id = $user->Employee_id;
            $mobile_number = $user->mobile_number;
            $pan_number = $user->pan_number;
            $dob = $user->dob;
            $current_address = $user->current_address;
            $permanent_address = $user->permanent_address;
            $aadhaar_number = $user->aadhaar_number;
            $gender = $user->gender;
            $f_name = $user->f_name;
            $l_name = $user->l_name;
            $m_name = $user->m_name;
            $photo_name = $user->photo_name;
            $highest_qualification = $user->highest_qualification;
            $DOJ = $user->DOJ;
            $password = $user->password;
            $voter_id_number = $user->voter_id_number;
            $marital_status = $user->marital_status;
            $salary = $user->salary;
            $ration_card_number = $user->ration_card_number;
            $shift_time = $user->shift_time;
            $employee_type = $user->employee_type;
            $role = $user->role;
            $termination_date = $user->termination_date;
            $reason_of_termination = $user->reason_of_termination;
            $can_login = $user->can_login;

            $dbData = array("name" => $name,
                "can_login" => $can_login,
                "reason_of_termination" => $reason_of_termination,
                "termination_date" => $termination_date,
                "role" => $role,
                "employee_type" => $employee_type,
                "shift_time" => $shift_time,
                "salary" => $salary,
                "ration_card_number" => $ration_card_number,
                "marital_status" => $marital_status,
                "voter_id_number" => $voter_id_number,
                "password" => $password,
                "email" => $email,
                "Employee_id" => $Employee_id,
                "mobile_number" => $mobile_number,
                "f_name" => $f_name,
                "l_name" => $l_name,
                "m_name" => $m_name,
                "mobile_number" => $mobile_number,
                "pan_number" => $pan_number,
                "dob" => $dob,
                "current_address" => $current_address,
                "permanent_address" => $permanent_address,
                "aadhaar_number" => $aadhaar_number,
                "gender" => $gender,
                "photo_name" => $photo_name,
                "highest_qualification" => $highest_qualification,
                "DOJ" => $DOJ,
            );
          }
            //leave_type_master
            $leave_type_master = DB::table('leave_type_master')
            ->get();

        //shift_master
        $shift_master = DB::table('shift_master')
            ->get();

//employee_type_master
        $employee_type_master = DB::table('shift__employee_type_master')
            ->get();
//role_masrer
        $role_masrer = DB::table('role_masrer')
            ->get();


          return view("single_user")
          ->with('u_data', $dbData)
          ->with('shift_master', $shift_master)
          ->with('role_masrer', $role_masrer)
          ->with('employee_type_master', $employee_type_master)
          ->with('leave_type_master', $leave_type_master)
          ->with('role', $role);
        }else{
          ?>
<script>
alert("User data Not Found")
history.back();
</script>
<?php
        }
      }else{
        ?>
<script>
alert("User data Not Found")
history.back();
</script>
<?php
      }


    }else{
      ?>
<script>
alert("please Provide User Id")
history.back();
</script>
<?php
      }
  }


  public function one_user(Request $req)
  {
      $role = session()->get('role');
      $id = $req->id;
      if (isset($id)) {
          $userData = DB::table('all_users')
              ->where('id', $id)
              ->get();
          if (isset($userData)) {
              $userCount = count($userData);

              if ($userCount === 1) {
                foreach ($userData as $user) {
                      $name = $user->f_name . " " . $user->m_name . " " . $user->l_name;
                      $email = $user->email;
                      $Employee_id = $user->Employee_id;
                      $mobile_number = $user->mobile_number;
                      $pan_number = $user->pan_number;
                      $dob = $user->dob;
                      $current_address = $user->current_address;
                      $permanent_address = $user->permanent_address;
                      $aadhaar_number = $user->aadhaar_number;
                      $gender = $user->gender;
                      $f_name = $user->f_name;
                      $l_name = $user->l_name;
                      $m_name = $user->m_name;
                      $photo_name = $user->photo_name;
                      $highest_qualification = $user->highest_qualification;
                      $DOJ = $user->DOJ;
                      $password = $user->password;
                      $voter_id_number = $user->voter_id_number;
                      $marital_status = $user->marital_status;
                      $salary = $user->salary;
                      $ration_card_number = $user->ration_card_number;
                      $shift_time = $user->shift_time;
                      $employee_type = $user->employee_type;
                      $role = $user->role;
                      $termination_date = $user->termination_date;
                      $reason_of_termination = $user->reason_of_termination;
                      $can_login = $user->can_login;
                      $Department = $user->Department;
                      $Gate_Off = $user->Gate_Off;


                      $dbData = array("name" => $name,
                          "can_login" => $can_login,
                          "reason_of_termination" => $reason_of_termination,
                          "termination_date" => $termination_date,
                          "role" => $role,
                          "employee_type" => $employee_type,
                          "shift_time" => $shift_time,
                          "salary" => $salary,
                          "ration_card_number" => $ration_card_number,
                          "marital_status" => $marital_status,
                          "voter_id_number" => $voter_id_number,
                          "password" => $password,
                          "email" => $email,
                          "Employee_id" => $Employee_id,
                          "mobile_number" => $mobile_number,
                          "f_name" => $f_name,
                          "l_name" => $l_name,
                          "m_name" => $m_name,
                          "mobile_number" => $mobile_number,
                          "pan_number" => $pan_number,
                          "dob" => $dob,
                          "current_address" => $current_address,
                          "permanent_address" => $permanent_address,
                          "aadhaar_number" => $aadhaar_number,
                          "gender" => $gender,
                          "photo_name" => $photo_name,
                          "highest_qualification" => $highest_qualification,
                          "Department" => $Department,
                          "Gate_Off" => $Gate_Off,
                          "DOJ" => $DOJ,
                      );
                    }
                      // em
                      $em_contect = DB::table('_emergency__contacts')
                          ->where('Employee_id', $Employee_id)
                          ->get();

                      //  social profile
                      $socialData = DB::table('_social__profile')
                          ->where('Employee_id', $Employee_id)
                          ->get();

                      $social_pCount = count($socialData);

                      if ($social_pCount == 1) {

                          foreach ($socialData as $social_p) {

                              $socialData = array("name" => $name,
                                  "id" => $social_p->id,
                                  "Facebook_Profile" => $social_p->Facebook_Profile,
                                  "LinkedIn_Profile" => $social_p->LinkedIn_Profile,
                                  "Twitter_Profile" => $social_p->Twitter_Profile,
                                  "Whats_App_Profile" => $social_p->Whats_App_Profile,

                              );
                          }

                      } else {
                        $socialData = array("name" => $name,
                                  "id" => "",
                                  "Facebook_Profile" => "",
                                  "LinkedIn_Profile" => "",
                                  "Twitter_Profile" => "",
                                  "Whats_App_Profile" => "",

                              );
                      }

                      //documents
                      $document = DB::table('all__document')

                          ->where('Employee_id', $Employee_id)
                          ->get();

                      //Qualifications
                      $Qualifications = DB::table('_qualifications')

                          ->where('Employee_id', $Employee_id)
                          ->get();

                      //Work Experience
                      $work__experience = DB::table('_work__experience')
                          ->where('Employee_id', $Employee_id)
                          ->get();

                      //accounts
                      $accounts = DB::table('accounts')
                          ->where('Employee_id', $Employee_id)
                          ->get();

                      //Leave
                      $leave_data = DB::table('_leave')
                          ->where('Employee_id', $Employee_id)
                          ->get();

                      //basic_salary
                      $basic_salary_data = DB::table('basic_salary')
                          ->where('Employee_id', $Employee_id)
                          ->get();

                      //alloweance
                      $alloweance_data = DB::table('alloweance')
                          ->where('Employee_id', $Employee_id)
                          ->get();

                      //loan
                      $loan_data = DB::table('loan')
                          ->where('Employee_id', $Employee_id)
                          ->get();

                      //deductions
                      $deductions_data = DB::table('deductions')
                          ->where('Employee_id', $Employee_id)
                          ->get();

                      //other_payments
                      $other_payments_data = DB::table('other_payments')
                          ->where('Employee_id', $Employee_id)
                          ->get();
                      //over Time
                      $overtime_data = DB::table('overtime')
                          ->where('Employee_id', $Employee_id)
                          ->get();

                      //attendance_info
                      $attendance_info_data = DB::table('all_attandencetable')
                          ->orderBy('attandence_Date', 'ASC')
                          ->where('Employee_id', $Employee_id)
                          ->get();

                      // award_info
                      $award_info_data = DB::table('award_info')
                          ->where('Employee_id', $Employee_id)
                          ->get();

                      //travel_info
                      $travel_info_data = DB::table('travel_info')
                          ->where('Employee_id', $Employee_id)
                          ->get();

                      //    training_info
                      $training_info_data = DB::table('training_info')
                          ->where('Employee_id', $Employee_id)
                          ->get();

                      //ticket_info
                      $ticket_info_data = DB::table('ticket_info')
                          ->where('Employee_id', $Employee_id)
                          ->get();

                      //transfer_info
                      $transfer_info_data = DB::table('transfer_info')
                          ->where('Employee_id', $Employee_id)
                          ->get();
                      //_promotion
                      $promotion_data = DB::table('_promotion')
                          ->where('Employee_id', $Employee_id)
                          ->get();

                      //complaints
                      $complaints_data = DB::table('complaints')
                          ->where('Employee_id', $Employee_id)
                          ->get();

                      //warning
                      $warning_data = DB::table('warning')
                          ->where('Employee_id', $Employee_id)
                          ->get();

                      //project
                      $projects_data = DB::table('projects')
                          ->where('Employee_id', $Employee_id)
                          ->get();
                      //tasks
                      $tasks_data = DB::table('tasks')
                          ->where('Employee_id', $Employee_id)
                          ->get();

                      //payslip
                      $payslip_data = DB::table('payslip')
                          ->where('Employee_id', $Employee_id)
                          ->get();

                      //permissions
                      $permissions = DB::table('user_permissions')
                          ->where('Employee_id', $Employee_id)
                          ->get();

                      //role Permissions
                      $roler_permissions = DB::table('roler_permissions')
                          ->where('role_name', session()->get('role'))
                          ->get();

                      //leave_type_master
                      $leave_type_master = DB::table('leave_type_master')
                          ->get();

                      //shift_master
                      $shift_master = DB::table('shift_master')
                          ->get();

                        //employee_type_master
                      $employee_type_master = DB::table('shift__employee_type_master')
                          ->get();
                        //role_masrer
                      $role_masrer = DB::table('role_masrer')
                          ->get();
                          //
                          $Department_master = DB::table('department_master')
                          ->get();

                        $penalties = DB::table('penalty_master')
                          ->where('EmpID', $Employee_id)
                          ->orderBy('Date_of_Penalty', 'desc')
                          ->get();

                      return view("user_details")
                          ->with('u_data', $dbData)
                          ->with('Department_master', $Department_master)
                          ->with('em_contect', $em_contect)
                          ->with('socialData', $socialData)
                          ->with('document', $document)
                          ->with('Qualifications', $Qualifications)
                          ->with('work__experience', $work__experience)
                          ->with('accounts', $accounts)
                          ->with('leave_data', $leave_data)
                          ->with('Basic_Salary', $basic_salary_data)
                          ->with('alloweance', $alloweance_data)
                          ->with('loan_data', $loan_data)
                          ->with('deductions', $deductions_data)
                          ->with('other_payments', $other_payments_data)
                          ->with('overtime', $overtime_data)
                          ->with('attendance_info', $attendance_info_data)
                          ->with('award_info', $award_info_data)
                          ->with('travel_info', $travel_info_data)
                          ->with('training_info', $training_info_data)
                          ->with('ticket_info', $ticket_info_data)
                          ->with('transfer_info', $transfer_info_data)
                          ->with('promotion', $promotion_data)
                          ->with('complaints', $complaints_data)
                          ->with('warning', $warning_data)
                          ->with('projects', $projects_data)
                          ->with('tasks', $tasks_data)
                          ->with('role', $role)
                          ->with('payslip', $payslip_data)
                          ->with('roler_permissions', $roler_permissions)
                          ->with('shift_master', $shift_master)
                          ->with('role_masrer', $role_masrer)
                          ->with('employee_type_master', $employee_type_master)
                          ->with('leave_type_master', $leave_type_master)
                          ->with('penalties', $penalties)
                          ->with('permissions', $permissions);
              } else {
                  echo "data not found";
              }
          } else {
              echo "No record";
          }

      } else {
          echo "No record";
      }
  }

// add Emergency Contacts
    public function form_request(Request $freq)
    {
        $formType = $freq->form_type;
        if (isset($formType)) {
            if ($formType == "Emergency Contacts") {

                $emp_id = $freq->Employee_Id;
                $name = $freq->name;
                $Relatrion = $freq->Relatrion;
                $email = $freq->email;
                $mobile_number = $freq->mobile_number;

                $created_by = session()->get('EmployeeID');
                $Emergency_ContactsQR = DB::table('_emergency__contacts')
                    ->insertOrIgnore([

                        'Employee_id' => $emp_id,
                        'Relation' => $Relatrion,
                        'email' => $email,
                        'Name' => $name,
                        'mobile' => $mobile_number,
                        'created_by' => $created_by,
                        'created_at' => now(),
                        'updated_at' => now(),

                    ]);

                if ($Emergency_ContactsQR) {
                    ?>
<script>
alert("Registration Success")
history.back();
</script>
<?php
} else {
                    ?>
<script>
alert("Registration faield")
history.back()
</script>
<?php
}

            } else if ($formType == "Document_form") {

                $emp_id = $freq->Employee_Id;
                $duc_type = $freq->duc_type;
                $duc_titel = $freq->duc_titel;
                $exp_date = $freq->exp_date;
                $duc_discription = $freq->duc_discription;
                $Document_path = "";
                $created_by = session()->get('EmployeeID');
                $file = $freq->file('file_front');
                $freq->validate([
                    'file_front' => 'required|mimes:jpg,png,pdf|max:3072',
                ]);
                $path = $freq->file('file_front')->store('file_fronte', 'public');

                if ($freq->file('file_back')) {
                    $file = $freq->file('file_back');
                    $freq->validate([
                        'file_back' => 'required|mimes:jpg,png,pdf|max:3072',
                    ]);
                    $path2 = $freq->file('file_back')->store('file_back', 'public');

                } else {
                    $path2 = "";
                }
                if ($path) {
                    $Qualification_formQR = DB::table('all__document')
                        ->insertOrIgnore([
                            'Employee_id' => $emp_id,
                            'Document_Type' => $duc_type,
                            'Title' => $duc_titel,
                            'Expired_Date' => $exp_date,
                            'Description' => $duc_discription,
                            'Document_path' => $path,
                            'Document_path_back' => $path2,
                            'created_by' => $created_by,
                            'created_at' => now(),
                            'updated_at' => now(),

                        ]);

                    if ($Qualification_formQR) {
                        ?>
<script>
alert("Data Inserted Success")
history.back();
</script>
<?php
} else {
                        ?>
<script>
alert("Data Not Inserted faield")
history.back()
</script>
<?php
}
                }
            } else if ($formType == "Qualification_form") {

                $emp_id = $freq->Employee_Id;
                $School_University = $freq->School_University;
                $Education_Level = $freq->Education_Level;
                $From_section = $freq->section_start;
                $To_section = $freq->section_end;
                $Description = "";
                $Professional_Skills = $freq->Professional_Skills;
                $section_Language = $freq->section_Language;

                $created_by = session()->get('EmployeeID');
                $Qualification_formQR = DB::table('_qualifications')
                    ->insertOrIgnore([

                        'Employee_id' => $emp_id,
                        'School_University' => $School_University,
                        'Education_Level' => $Education_Level,
                        'Language' => $section_Language,
                        'From' => $From_section,
                        'to' => $To_section,
                        'Professional_Skills' => $Professional_Skills,
                        'Description' => $Description,
                        'created_by' => $created_by,
                        'created_at' => now(),
                        'updated_at' => now(),

                    ]);

                if ($Qualification_formQR) {
                    ?>
<script>
alert("Data Inserted Success")
history.back();
</script>
<?php
} else {
                    ?>
<script>
alert("Data not Inserted")
history.back()
</script>
<?php
}

            } else if ($formType == "Work_Experience") {

                $emp_id = $freq->Employee_Id;
                $Company_name = $freq->Company_Name;
                $Pos = $freq->post;
                $From_section = $freq->starting;
                $To_section = $freq->ending;
                $Description = $freq->discriptions;

                $created_by = session()->get('EmployeeID');
                $Work_ExperienceQR = DB::table('_work__experience')
                    ->insertOrIgnore([

                        'Employee_id' => $emp_id,
                        'Company' => $Company_name,
                        'Pos' => $Pos,
                        'From' => $From_section,
                        'to' => $To_section,
                        'Description' => $Description,
                        'created_by' => $created_by,
                        'created_at' => now(),
                        'updated_at' => now(),

                    ]);

                if ($Work_ExperienceQR) {
                    ?>
<script>
alert("Data Inserted Success")
history.back();
</script>
<?php
} else {
                    ?>
<script>
alert("Data Not Inserted")
history.back()
</script>
<?php
}

            } else if ($formType == "Bank_Account") {

                $emp_id = $freq->Employee_Id;
                $Holder_Name = $freq->Holder_Name;
                $Bank_Name = $freq->Bank_Name;
                $Account_Number = $freq->Account_Number;
                $IFSC_Code = $freq->IFSC_Code;

                $created_by = session()->get('EmployeeID');
                $Bank_AccountQR = DB::table('accounts')
                    ->insertOrIgnore([
                        'Employee_id' => $emp_id,
                        'Account_Holder_Name' => $Holder_Name,
                        'Bank_Name' => $Bank_Name,
                        'Account_Number' => $Account_Number,
                        'IFSC_Code' => $IFSC_Code,
                        'created_by' => $created_by,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                if ($Bank_AccountQR) {
                    ?>
<script>
alert("Data Inserted Success")
history.back();
</script>
<?php
} else {
                    ?>
<script>
alert("Data Not Inserted faield")
history.back()
</script>
<?php
}

            } else if ($formType == "Basic_Salary") {

                $emp_id = $freq->Employee_Id;
                $month = $freq->month;
                $year = $freq->year;
                $Basic_Salary = $freq->Basic_Salary;
                $basic_salary_input_id = $freq->basic_salary_input_id;

if (isset($basic_salary_input_id)) {

    $update_quri = DB::table('basic_salary')
        ->where('id',  $basic_salary_input_id)
         ->update( [
         'Employee_id' => $emp_id,
        'month' => $month,
        'Year' => $year,
        'Basic_Salary' => $Basic_Salary,
        'updated_at' => now(),

        ]);


    if ($update_quri) {
        return response()->json([
            'success' => true,
            'message' => 'Data Updated successfully.',
        ], 201); // 201 Created
} else {
return response()->json([
'success' => false,
'message' => 'Data not Updated.',
], 400); // 400 Bad Request
}


}else {

                $created_by = session()->get('EmployeeID');
                $Bank_AccountQR = DB::table('basic_salary')
                    ->insertOrIgnore([

                        'Employee_id' => $emp_id,
                        'month' => $month,
                        'Year' => $year,
                        'Basic_Salary' => $Basic_Salary,
                        'created_by' => $created_by,
                        'created_at' => now(),
                        'updated_at' => now(),

                    ]);

                if ($Bank_AccountQR) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Data inserted successfully.',
                    ], 201); // 201 Created
} else {
    return response()->json([
        'success' => false,
        'message' => 'Data not inserted. Possible duplicate entry.',
    ], 400); // 400 Bad Request
}

            }

            } else if ($formType == "leave_form") {
                $emp_id = $freq->Employee_Id;
                $user = DB::table('all_users')
                ->where('Employee_Id', $emp_id)
                ->selectRaw("CONCAT(f_name, ' ', COALESCE(m_name, ''), ' ', l_name) AS full_name")
                ->first();


                $fullName = $user->full_name ; // Remove extra spaces if m_name is null




                $Leave_Type = $freq->Leave_Type;
                $Start_Date = $freq->Start_Date;
                $End_Date = $freq->End_Date;
                $Total_Days = $freq->Total_Days;
                $Description = $freq->Description;
                $Remarks_by_Approver = $freq->Remarks_by_Approver;
                $status = $freq->status;
                $add_leave_id_input = $freq->add_leave_id_input;

                if (isset($add_leave_id_input)) {
                    $update_quri = DB::table('_leave')
                    ->where('id',  $add_leave_id_input)
                     ->update( [

                        'Leave_Type' => $Leave_Type,
                        'Start_Date' => $Start_Date,
                        'End_Date' => $End_Date,
                        'Description' => $Description,
                        'Status' => $status,
                        'Total_Days' => $Total_Days,
                        'updated_at' => now(),

                    ]);


                if ($update_quri) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Data Updated successfully.',
                    ], 201); // 201 Created
            } else {
            return response()->json([
            'success' => false,
            'message' => 'Data not Updated.',
            ], 400); // 400 Bad Request
            }
                }else{


                $created_by = session()->get('EmployeeID');
                $Bank_AccountQR = DB::table('_leave')
                    ->insertOrIgnore([

                        'Employee_id' => $emp_id,
                        'Leave_Type' => $Leave_Type,
                        'Name' => $fullName,

                        'Start_Date' => $Start_Date,
                        'End_Date' => $End_Date,
                        'Description' => $Description,
                        'Status' => $created_by,

                        'Total_Days' => $Total_Days,
                        'created_by' => $created_by,

                        'created_at' => now(),
                        'updated_at' => now(),

                    ]);

                if ($Bank_AccountQR) {

                    return response()->json([
                        'success' => true,
                        'message' => 'Data Inserted successfully.',
                    ], 201); // 201 Created
            } else {
            return response()->json([
            'success' => false,
            'message' => 'Data not Inserted.',
            ], 400); // 400 Bad Request
            }
        }

            } else if ($formType == "Allowanceform") {
                $emp_id = $freq->Employee_Id;
                $Allowance_Title = $freq->Allowance_Title;
                $Allowance_Amount = $freq->Allowance_Amount;
                $Month = $freq->Month;
                $Year = $freq->Year;
                $Allowance_id_input = $freq->Allowance_id_input;
                if(isset($Allowance_id_input)){
                    $update_quri = DB::table('alloweance')
                    ->where('id',  $Allowance_id_input)
                     ->update( [
                        'Employee_id' => $emp_id,
                        'Alloweance_Titel' => $Allowance_Title,
                        'Month' => $Month,
                        'year' => $Year,
                        'Allowance_Ammount_in_INR' => $Allowance_Amount,
                        'updated_at' => now(),

                    ]);


                if ($update_quri) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Data Updated successfully.',
                    ], 201); // 201 Created
            } else {
            return response()->json([
            'success' => false,
            'message' => 'Data not Updated.',
            ], 400); // 400 Bad Request
            }

                }else{

                $created_by = session()->get('EmployeeID');
                $Bank_AccountQR = DB::table('alloweance')
                    ->insertOrIgnore([
                        'Employee_id' => $emp_id,
                        'Alloweance_Titel' => $Allowance_Title,
                        'Month' => $Month,
                        'year' => $Year,
                        'Allowance_Ammount_in_INR' => $Allowance_Amount,

                        'created_by' => $created_by,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                if ($Bank_AccountQR) {
              return response()->json([
                        'success' => true,
                        'message' => 'Allowance inserted successfully.',
                    ], 201); // 201 Created
} else {
    return response()->json([
        'success' => false,
        'message' => 'Data not inserted',
    ], 400); // 400 Bad Request
}
                }



            } else if ($formType == "Loan_form") {
                $emp_id = $freq->Employee_Id;
                $Month = $freq->Month;
                $Loan_Option = $freq->Loan_Option;
                $Amount = $freq->Amount;
                $Number_of_installment = $freq->Number_of_installment;
                $Reason = $freq->Reason;
                $loan_Id_input = $freq->loan_Id_input;
                $Title = $freq->Title;



                if (isset($loan_Id_input)) {
                    // Update loan data
                    $update_query = DB::table('loan')
                        ->where('id', $loan_Id_input)
                        ->orWhere('Loan_id', $loan_Id_input)
                        ->update([
                            'Month' => date('Y-m', strtotime($Month)),
                            'Loan_type' => $Loan_Option ?? null,
                            'Loan_Amount_in_INR' => $Amount,
                            'Number_of_installment' => $Number_of_installment,
                            'Title' => $Title,
                            'Reason' => $Reason,
                            'updated_at' => now(),
                        ]);


                    if ($update_query) {
                        // Delete existing deductions related to the loan
                        DB::table('deductions')->where('Advance_Ids', $loan_Id_input)->delete();

                        // Recalculate and insert updated deductions
                        $year = date('Y', strtotime($Month));
                        $month = date('n', strtotime($Month));
                        $deduction_amount = $Amount / $Number_of_installment;
                        $months = [];

                        for ($i = 1; $i <= $Number_of_installment; $i++) {
                            $currentMonth = ($month + $i - 1) % 12;
                            $currentYear = $year + floor(($month + $i - 1) / 12);
                            $currentMonth = $currentMonth === 0 ? 12 : $currentMonth;

                            $monthName = date('F', mktime(0, 0, 0, $currentMonth, 1, $currentYear));
                            $formattedDate = date('Y-m-d', mktime(0, 0, 0, $currentMonth, 12, $currentYear));

                            DB::table('deductions')->insertOrIgnore([
                                'Employee_id' => $emp_id,
                                'Month' => $monthName . " " . $currentYear,
                                'deductions_Month' => $formattedDate,
                                'Year' => date('Y', strtotime($formattedDate)),
                                'deduction_Titel' => $Title,
                                'deduction_Amount_in_INR' => $deduction_amount,
                                'created_at' => now(),
                                'updated_at' => now(),
                                'Advance_Ids' => $loan_Id_input,
                            ]);
                        }

                        return response()->json([
                            'success' => true,
                            'message' => 'Loan and related deductions updated successfully.',
                        ], 201); // 201 Created
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => 'Loan updated, but deductions update failed.',
                        ], 400); // 400 Bad Request
                    }
                } else {
                    // Insert new loan and deductions logic
                    $Loan_id = now()->timestamp;
                    $created_by = session()->get('EmployeeID');
                    $Bank_AccountQR = DB::table('loan')->insertOrIgnore([
                        'Employee_id' => $emp_id,
                        'Month' => $Month,
                        'Year' => date('Y'),
                        'Loan_type' => $Loan_Option ?? null,
                        'Loan_Amount_in_INR' => $Amount,
                        'Number_of_installment' => $Number_of_installment,
                        'Loan_duration' => '',
                        'Loan_Remaining' => $Amount,
                        'Title' => $Title,
                        'Reason' => $Reason,
                        'created_by' => $created_by,
                        'created_at' => now(),
                        'updated_at' => now(),
                        'Loan_id' => $Loan_id,
                    ]);

                    // Generate deductions and insert into the database
                    $year = date('Y', strtotime($Month));
                    $month = date('n', strtotime($Month));
                    $deduction_amount = $Amount / $Number_of_installment;

                    for ($i = 1; $i <= $Number_of_installment; $i++) {
                        $currentMonth = ($month + $i - 1) % 12;
                        $currentYear = $year + floor(($month + $i - 1) / 12);
                        $currentMonth = $currentMonth === 0 ? 12 : $currentMonth;

                        $monthName = date('F', mktime(0, 0, 0, $currentMonth, 1, $currentYear));
                        $formattedDate = date('Y-m-d', mktime(0, 0, 0, $currentMonth, 12, $currentYear));

                        DB::table('deductions')->insertOrIgnore([
                            'Employee_id' => $emp_id,
                            'Month' => $monthName . " " . $currentYear,
                            'deductions_Month' => $formattedDate,
                            'Year' => date('Y', strtotime($formattedDate)),
                            'deduction_Titel' => $Title,
                            'deduction_Amount_in_INR' => $deduction_amount,
                            'created_at' => now(),
                            'updated_at' => now(),
                            'Advance_Ids' => $Loan_id,
                        ]);
                    }

                    return response()->json([
                        'success' => true,
                        'message' => 'Loan and related deductions inserted successfully.',
                    ], 201); // 201 Created
                }







            } else if ($formType == "Deduction_form") {

                $emp_id = $freq->Employee_Id;
                $Month_Year = $freq->Month_Year;
                $Deduction_Title = $freq->Deduction_Title;
                $Deduction_Amount = $freq->Deduction_Amount;
                $Deduction_id_input = $freq->Deduction_id_input;
                if (isset($Deduction_id_input)) {

// Extract Year and Month
$Month_Year = $freq->Month_Year; // Example: '2025-01'
if (!preg_match('/^\d{4}-\d{2}$/', $Month_Year)) {
    return response()->json([
        'success' => false,
        'message' => 'Invalid Month_Year format. Expected format: YYYY-MM.',
    ], 400); // Bad Request
}

[$year, $month] = explode('-', $Month_Year);

// Format the month for display
$months = [
    '01' => "January", '02' => "February", '03' => "March",
    '04' => "April", '05' => "May", '06' => "June",
    '07' => "July", '08' => "August", '09' => "September",
    '10' => "October", '11' => "November", '12' => "December"
];

if (!isset($months[$month])) {
    return response()->json([
        'success' => false,
        'message' => 'Invalid month provided.',
    ], 400); // Bad Request
}

// Update the database record
$updated = DB::table('deductions')
    ->where('id', $Deduction_id_input)
    ->update([
        'Month' => $months[$month] . ' ' . $year, // Example: "January 2025"
        'deductions_Month' => "$year-$month-15", // Example: "2025-01-15"
        'deduction_Titel' => $Deduction_Title,
        'deduction_Amount_in_INR' => $Deduction_Amount,
        'updated_at' => now(),
    ]);

// Respond based on the update status
if ($updated) {
    return response()->json([
        'success' => true,
        'message' => 'Data updated successfully.',
    ], 201); // 201 Created
} else {
    return response()->json([
        'success' => false,
        'message' => 'Data not updated.',
    ], 400); // 400 Bad Request
}
                }else{


// Extract Year and Month
$Month_Year = $freq->Month_Year; // Example: '2025-01'
if (!preg_match('/^\d{4}-\d{2}$/', $Month_Year)) {
    return response()->json([
        'success' => false,
        'message' => 'Invalid Month_Year format. Expected format: YYYY-MM.',
    ], 400); // Bad Request
}

[$year, $month] = explode('-', $Month_Year);

// Format the month for display
$months = [
    '01' => "January", '02' => "February", '03' => "March",
    '04' => "April", '05' => "May", '06' => "June",
    '07' => "July", '08' => "August", '09' => "September",
    '10' => "October", '11' => "November", '12' => "December"
];

if (!isset($months[$month])) {
    return response()->json([
        'success' => false,
        'message' => 'Invalid month provided.',
    ], 400); // Bad Request
}

// Ensure EmployeeID exists in session
$created_by = session()->get('EmployeeID');
if (!$created_by) {
    return response()->json([
        'success' => false,
        'message' => 'Employee ID is required.',
    ], 400); // Bad Request
}

// Insert Deduction
$inserted = DB::table('deductions')->insertOrIgnore([
    'Employee_id' => $emp_id,
    'Month' => $months[$month] . ' ' . $year, // Example: "January 2025"
    'deductions_Month' => $year . '-' . $month . '-15', // Example: "2025-01-15"
    'Year' => $year, // Year extracted from Month_Year
    'deduction_Titel' => $Deduction_Title,
    'deduction_Amount_in_INR' => $Deduction_Amount,
    'created_by' => $created_by,
    'created_at' => now(),
    'updated_at' => now(),
]);

// Response Based on Insertion Status
if ($inserted) {
    return response()->json([
        'success' => true,
        'message' => 'Deduction inserted successfully.',
    ], 201); // Created
} else {
    return response()->json([
        'success' => false,
        'message' => 'Data not inserted.',
    ], 400); // Bad Request
}
                }
            } else if ($formType == "Other_Payment_form") {



                $emp_id = $freq->Employee_Id;
                $Month_Year = $freq->Month_Year;
                $Title = $freq->Title;
                $Amount = $freq->Amount;
                $created_by = session()->get('EmployeeID');
                $Bank_AccountQR = DB::table('other_payments')
                    ->insertOrIgnore([
                        'Employee_id' => $emp_id,
                        'Month' => $Month_Year ,
                        'Year' => date('Y'),
                        'Titel' => $Title,
                        'Amount_in_INR' => $Amount,
                        'created_by' => $created_by,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                if ($Bank_AccountQR) {
                    ?>
<script>
alert("Data Inserted Success")
history.back();
</script>
<?php
} else {
                    ?>
<script>
alert("Data Not Inserted faield")
history.back()
</script>
<?php
}
            } else if ($formType == "Overtime_form") {
                $emp_id = $freq->Employee_Id;
                $Title = $freq->Title;
                $Total_Hours = $freq->Total_Hours;
                $Month_and_Year = $freq->month_year;
                $rate = $freq->rate;
                $created_by = session()->get('EmployeeID');
                $Bank_AccountQR = DB::table('overtime')
                    ->insertOrIgnore([
                        'Employee_id' => $emp_id,

                        'Month' => $Month_and_Year,
                        'Year' => date('Y'),
                        'Titel' => $Title,
                        'Total_Hours' => $Total_Hours,
                        'Rate' => $rate,

                        'updated_by' => $created_by,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                if ($Bank_AccountQR) {
                    ?>
<script>
alert("Data Inserted Success")
history.back();
</script>
<?php
} else {
                    ?>
<script>
alert("Data Not Inserted faield")
history.back()
</script>
<?php
}
            } else if ($formType == "Attendance_form") {
                $emp_id = $freq->Employee_Id;
                $Date = $freq->date;
                $created_by = session()->get('EmployeeID');
                $Bank_AccountQR = DB::table('attendance_info')
                    ->insertOrIgnore([
                        'Employee_id' => $emp_id,
                        'attendance_Date' => $Date,
                        'attendance_time' => now()->toTimeString(),
                        'updated_by' => $created_by,
                        'created_by' => $created_by,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                if ($Bank_AccountQR) {
                    ?>
<script>
alert("Data Inserted Success")
history.back();
</script>
<?php
} else {
                    ?>
<script>
alert("Data Not Inserted faield")
history.back()
</script>
<?php
}

// baki hai form banana

            } else if ($formType == "Award_Info_form") {
                $emp_id = $freq->Employee_Id;
                $Award_Name = $freq->Award_Name;
                $Gift = $freq->Gift;
                $Award_date = $freq->Award_Date;
                $Award_by = $freq->Awarded_BY;

                $created_by = session()->get('EmployeeID');
                $Bank_AccountQR = DB::table('award_info')
                    ->insertOrIgnore([
                        'Employee_id' => $emp_id,
                        'Award_Name' => $Award_Name,
                        'updated_by' => $created_by,
                        'created_by' => $created_by,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                if ($Bank_AccountQR) {
                    ?>
<script>
alert("Data Inserted Success")
history.back();
</script>
<?php
} else {
                    ?>
<script>
alert("Data Not Inserted faield")
history.back()
</script>
<?php
}
            } else if ($formType == "Travel_Info_form") {
                $emp_id = $freq->Employee_Id;
                $Summary = $freq->Summary;
                $Place_Of_Visit = $freq->Place_Of_Visit;
                $Travel_start_date = $freq->Start_Date;
                $Travel_end_date = $freq->End_Date;

                $created_by = session()->get('EmployeeID');
                $Bank_AccountQR = DB::table('travel_info')
                    ->insertOrIgnore([
                        'Employee_id' => $emp_id,
                        'Summary' => $Summary,
                        'Place_Of_Visit' => $Place_Of_Visit,
                        'Travel_start_date' => $Travel_start_date,
                        'Travel_end_date' => $Travel_end_date,
                        'updated_by' => $created_by,
                        'created_by' => $created_by,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                if ($Bank_AccountQR) {
                    ?>
<script>
alert("Data Inserted Success")
history.back();
</script>
<?php
} else {
                    ?>
<script>
alert("Data Not Inserted faield")
history.back()
</script>
<?php
}
            } else if ($formType == "Training_Info_form") {
                $emp_id = $freq->Employee_Id;
                $Training_Type = $freq->Training_Type;
                $Trainer = $freq->Trainer;
                $Training_start_date = $freq->Start_Date;
                $Training_end_date = $freq->End_Date;

                $created_by = session()->get('EmployeeID');
                $Bank_AccountQR = DB::table('training_info')
                    ->insertOrIgnore([
                        'Employee_id' => $emp_id,
                        'Training_Typ' => $Training_Type,
                        'Trainer' => $Trainer,
                        'Training_start_date' => $Training_start_date,
                        'Training_end_date' => $Training_end_date,
                        'updated_by' => $created_by,
                        'created_by' => $created_by,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                if ($Bank_AccountQR) {
                    ?>
<script>
alert("Data Inserted Success")
history.back();
</script>
<?php
} else {
                    ?>
<script>
alert("Data Not Inserted faield")
history.back()
</script>
<?php
}
            } else if ($formType == "Ticket_Info_form") {
                $emp_id = $freq->Employee_Id;
                $Ticket_Details = $freq->Ticket_Details;
                $Subject = $freq->Subject;
                $Priority = $freq->Priority;
                $Date = $freq->Date;
                $created_by = session()->get('EmployeeID');
                $Bank_AccountQR = DB::table('ticket_info')
                    ->insertOrIgnore([
                        'Employee_id' => $emp_id,
                        'Ticket_Details' => $Ticket_Details,
                        'Subject' => $Subject,
                        'Priority' => $Priority,
                        'Date' => $Date,
                        'updated_by' => $created_by,
                        'created_by' => $created_by,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                if ($Bank_AccountQR) {
                    ?>
<script>
alert("Data Inserted Success")
history.back();
</script>
<?php
} else {
                    ?>
<script>
alert("Data Not Inserted faield")
history.back()
</script>
<?php
}
            } else if ($formType == "Transfer_Info_form") {
                $emp_id = $freq->Employee_Id;
                $From_Department = $freq->From_Department;
                $To_Department = $freq->To_Department;
                $Company = $freq->Company;
                $Date = $freq->Date;
                $created_by = session()->get('EmployeeID');
                $Bank_AccountQR = DB::table('transfer_info')
                    ->insertOrIgnore([
                        'Employee_id' => $emp_id,
                        'From_Department' => $From_Department,
                        'To_Department' => $To_Department,
                        'Company' => $Company,
                        'Date' => $Date,
                        'updated_by' => $created_by,
                        'created_by' => $created_by,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                if ($Bank_AccountQR) {
                    ?>
<script>
alert("Data Inserted Success")
history.back();
</script>
<?php
} else {
                    ?>
<script>
alert("Data Not Inserted faield")
history.back()
</script>
<?php
}
            } else if ($formType == "Promotion_Info_form") {
                $emp_id = $freq->Employee_Id;
                $Promotion_titel = $freq->Promotion_Titlet;
                $promated_by = $freq->Promated_BY;
                $Date = $freq->Date;
                $created_by = session()->get('EmployeeID');
                $Bank_AccountQR = DB::table('_promotion')
                    ->insertOrIgnore([
                        'Employee_id' => $emp_id,
                        'Promotion_titel' => $Promotion_titel,
                        'promated_by' => $promated_by,

                        'Promotion_Date' => $Date,
                        'updated_by' => $created_by,
                        'created_by' => $created_by,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                if ($Bank_AccountQR) {
                    ?>
<script>
alert("Data Inserted Success")
history.back();
</script>
<?php
} else {
                    ?>
<script>
alert("Data Not Inserted faield")
history.back()
</script>
<?php
}
            } else if ($formType == "Complaints_Info_form") {
                $emp_id = $freq->Employee_Id;
                $Complaint_From = $freq->Complaint_From;
                $Complaint_To = $freq->Complaint_To;
                $Complaint_Title = $freq->Complaint_Title;
                $Date = $freq->Complaint_Date;
                $created_by = session()->get('EmployeeID');
                $Bank_AccountQR = DB::table('complaints')
                    ->insertOrIgnore([
                        'Employee_id' => $emp_id,
                        'Complaint_From' => $Complaint_From,
                        'Complaint_To' => $Complaint_To,
                        'Complaint_Date' => $Date,
                        'Complaint_Title' => $Complaint_Title,
                        'updated_by' => $created_by,
                        'created_by' => $created_by,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                if ($Bank_AccountQR) {
                    ?>
<script>
alert("Data Inserted Success")
history.back();
</script>
<?php
} else {
                    ?>
<script>
alert("Data Not Inserted faield")
history.back()
</script>
<?php
}
            } else if ($formType == "Complaints_Info_form") {
                $emp_id = $freq->Employee_Id;
                $Complaint_From = $freq->Complaint_From;
                $Complaint_To = $freq->Complaint_To;
                $Complaint_Title = $freq->Complaint_Title;
                $Date = $freq->Complaint_Date;
                $created_by = session()->get('EmployeeID');
                $Bank_AccountQR = DB::table('complaints')
                    ->insertOrIgnore([
                        'Employee_id' => $emp_id,
                        'Complaint_From' => $Complaint_From,
                        'Complaint_To' => $Complaint_To,
                        'Complaint_Date' => $Date,
                        'Complaint_Title' => $Complaint_Title,
                        'updated_by' => $created_by,
                        'created_by' => $created_by,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                if ($Bank_AccountQR) {
                    ?>
<script>
alert("Data Inserted Success")
history.back();
</script>
<?php
} else {
                    ?>
<script>
alert("Data Not Inserted faield")
history.back()
</script>
<?php
}
            } else if ($formType == "Warning_Info_form") {
                $emp_id = $freq->Employee_Id;
                $Subject = $freq->Subject;
                $Status = $freq->Status;
                $Date = $freq->Warning_Date;
                $created_by = session()->get('EmployeeID');
                $Bank_AccountQR = DB::table('warning')
                    ->insertOrIgnore([
                        'Employee_id' => $emp_id,
                        'Subject' => $Subject,
                        'Status' => $Status,
                        'warning_Date' => $Date,

                        'updated_by' => $created_by,
                        'created_by' => $created_by,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                if ($Bank_AccountQR) {
                    ?>
<script>
alert("Data Inserted Success")
history.back();
</script>
<?php
} else {
                    ?>
<script>
alert("Data Not Inserted faield")
history.back()
</script>
<?php
}
            } else if ($formType == "Projects_Info_form") {
                $emp_id = $freq->Employee_Id;
                $Project_Summary = $freq->Project_Summary;
                $Assigned_Employees = $freq->Assigned_Employees;
                $Client = $freq->Client;
                $End_Date = $freq->End_Date;
                $Project_Progress = $freq->Project_Progress;
                $created_by = session()->get('EmployeeID');
                $Bank_AccountQR = DB::table('projects')
                    ->insertOrIgnore([
                        'Employee_id' => $emp_id,
                        'Project_Summary' => $Project_Summary,
                        'Assigned_Employees' => $Assigned_Employees,
                        'Client' => $Client,
                        'End_Date' => $End_Date,
                        'Project_Progress' => $Project_Progress,

                        'updated_by' => $created_by,
                        'created_by' => $created_by,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                if ($Bank_AccountQR) {
                    ?>
<script>
alert("Data Inserted Success")
history.back();
</script>
<?php
} else {
                    ?>
<script>
alert("Data Not Inserted faield")
history.back()
</script>
<?php
}
            } else if ($formType == "tasks_Info_form") {
                $emp_id = $freq->Employee_Id;
                $Tasks_Title = $freq->Task_Title;
                $Assigned_Employees = $freq->Assigned_Employees;
                $Start_date = $freq->Start_Date;
                $End_Date = $freq->End_Date;
                $Status = $freq->status;
                $task_Progress = $freq->task_Progress;
                $created_by = session()->get('EmployeeID');
                $Bank_AccountQR = DB::table('tasks')
                    ->insertOrIgnore([
                        'Employee_id' => $emp_id,
                        'Tasks_Title' => $Tasks_Title,
                        'Start_date' => $Start_date,
                        'Status' => $Status,
                        'End_Date' => $End_Date,
                        'Assigned_Employees' => $Assigned_Employees,
                        'task_Progress' => $task_Progress,

                        'updated_by' => $created_by,
                        'created_by' => $created_by,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                if ($Bank_AccountQR) {
                    ?>
<script>
alert("Data Inserted Success")
history.back();
</script>
<?php
} else {
                    ?>
<script>
alert("Data Not Inserted faield")
history.back()
</script>
<?php
}
            } else if ($formType == "tasks_Info_form") {
                $emp_id = $freq->Employee_Id;
                $Tasks_Title = $freq->Task_Title;
                $Assigned_Employees = $freq->Assigned_Employees;
                $Start_date = $freq->Start_Date;
                $End_Date = $freq->End_Date;
                $Status = $freq->status;
                $task_Progress = $freq->task_Progress;
                $created_by = session()->get('EmployeeID');
                $Bank_AccountQR = DB::table('tasks')
                    ->insertOrIgnore([
                        'Employee_id' => $emp_id,
                        'Tasks_Title' => $Tasks_Title,
                        'Start_date' => $Start_date,
                        'Status' => $Status,
                        'End_Date' => $End_Date,
                        'Assigned_Employees' => $Assigned_Employees,
                        'task_Progress' => $task_Progress,

                        'updated_by' => $created_by,
                        'created_by' => $created_by,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                if ($Bank_AccountQR) {
                    ?>
<script>
alert("Data Inserted Success")
history.back();
</script>
<?php
} else {
                    ?>
<script>
alert("Data Not Inserted faield")
history.back()
</script>
<?php
}
            } else if ($formType == "Payslip_Info_form") {
                $emp_id = $freq->Employee_Id;
                $Net_Salary = $freq->Net_Salary;
                $Salary_Month = $freq->Salary_Month;
                $Salary_Date = $freq->Salary_Date;

                $Status = $freq->status;

                $created_by = session()->get('EmployeeID');
                $Bank_AccountQR = DB::table('payslip')
                    ->insertOrIgnore([
                        'Employee_id' => $emp_id,
                        'Net_Salarye' => $Net_Salary,
                        'Salary_Month' => $Salary_Month,
                        'Payroll_Date' => $Salary_Date,
                        'Status' => $Status,

                        'updated_by' => $created_by,
                        'created_by' => $created_by,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                if ($Bank_AccountQR) {
                    ?>
<script>
alert("Data Inserted Success")
history.back();
</script>
<?php
} else {
                    ?>
<script>
alert("Data Not Inserted faield")
history.back()
</script>
<?php
}
            }
        }

    }

    public function addPenalty(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'amount' => 'required|numeric',
            'penalty_date' => 'required|date',
        ]);

        $emp_id = $request->employee_id;
        $amount = $request->amount;
        $penalty_date = Carbon::parse($request->penalty_date)->format('Y-m-d');
        $waived_off = $request->waived_off ?? 0;
        $waived_off_by = $request->waived_off_by;
        $waived_on = $request->waived_on ? Carbon::parse($request->waived_on)->format('Y-m-d') : null;
        $penalty_reason = $request->penalty_reason;
        $waive_off_reason = $request->waive_off_reason;
        $penalty_id = $request->penalty_id;

        $final_amount = $amount - $waived_off;

        $paid_total = 0;
        if ($request->has('payments')) {
            foreach ($request->payments as $payment) {
                $paid_total += isset($payment['amount']) ? (float)$payment['amount'] : 0;
            }
        }
        
        if ($final_amount <= $paid_total) {
            $payment_status = "success";
        } else {
            $payment_status = "pending";
        }
        
        if ($request->has('payments')) {
            $payments = [];
            foreach ($request->payments as $payment) {
                $payments[] = [
                    'amount' => $payment['amount'],
                    'date' => $payment['date'],
                ];
            }
            $payments = json_encode($payments);
        } else {
            $payments = NULL;
        }

        $data = [
            'EmpID' => $emp_id,
            'Amount' => $amount,
            'Final_Amount' => $final_amount,
            'Date_of_Penalty' => $penalty_date,
            'Waived_Off' => $waived_off,
            'Waived_off_By' => $waived_off_by,
            'Waived_On' => $waived_on,
            'Reason' => $penalty_reason,
            'Reason_of_Waive_Off' => $waive_off_reason,
            'payment_status' => $payment_status,
            'extra_Info' => $payments,
            'updated_by' => session()->get('EmployeeID'),
            'updated_at' => now(),
        ];

        if (empty($penalty_id)) {
            $data['created_by'] = session()->get('EmployeeID');
            $data['created_at'] = now();
            DB::table('penalty_master')->insert($data);
            return back()->with('success', 'Penalty added successfully.');
        } else {
            DB::table('penalty_master')->where('id', $penalty_id)->update($data);
            return back()->with('success', 'Penalty updated successfully.');
        }
    }

    public function deletePenalty($id)
    {
        DB::table('penalty_master')->where('id', $id)->delete();
        return back()->with('success', 'Penalty deleted successfully.');
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class registrationController extends Controller
{
    public function add_user_view()
    {
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
        if (isset($EmployeesID)) {

//shift_master
$shift_master = DB::table('shift_master')
->get();
// depart master

$department_master = DB::table('department_master')
->get();

//employee_type_master
$employee_type_master = DB::table('shift__employee_type_master')
->get();
//role_masrer
$role_masrer = DB::table('role_masrer')
->get();
            return view("add_user")
                ->with('reg_id', "0")
                ->with('reg_email', "0")
                ->with('role', $role)
                ->with('shift_master', $shift_master)
                ->with('department_master', $department_master)
                ->with('role_masrer', $role_masrer)
                ->with('employee_type_master', $employee_type_master)
                ->with('stape', 1);

        } else {
            return redirect()->route('login');
        }
    }

//add admin
public function add_admin_view()
    {
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
        if (isset($EmployeesID)) {

//shift_master
$shift_master = DB::table('shift_master')
->get();

// depart master

$department_master = DB::table('department_master')
->get();

//employee_type_master
$employee_type_master = DB::table('shift__employee_type_master')
->get();

//role_masrer
$role_masrer = DB::table('role_masrer')
->get();
            return view("add_admin_view")
                ->with('reg_id', "0")
                ->with('reg_email', "0")
                ->with('role', $role)
                ->with('shift_master', $shift_master)
                ->with('role_masrer', $role_masrer)
                ->with('department_master', $department_master)
                ->with('employee_type_master', $employee_type_master)
                ->with('stape', 1);

        } else {
            return redirect()->route('login');
        }
    }

    //add super admin
public function add_super_admin_view()
{
    $EmployeesID = session()->get('EmployeeID');
    $role = session()->get('role');
    if (isset($EmployeesID)) {

//shift_master
$shift_master = DB::table('shift_master')
->get();

//employee_type_master
$employee_type_master = DB::table('shift__employee_type_master')
->get();

//role_masrer
$role_masrer = DB::table('role_masrer')
->get();
        return view("add_super_admin_view")
            ->with('reg_id', "0")
            ->with('reg_email', "0")
            ->with('role', $role)
            ->with('shift_master', $shift_master)
            ->with('role_masrer', $role_masrer)
            ->with('employee_type_master', $employee_type_master)
            ->with('stape', 1);

    } else {
        return redirect()->route('login');
    }
}
//add HR
public function add_HR_view()
{
    $EmployeesID = session()->get('EmployeeID');
    $role = session()->get('role');
    if (isset($EmployeesID)) {

//shift_master
$shift_master = DB::table('shift_master')
->get();

//employee_type_master
$employee_type_master = DB::table('shift__employee_type_master')
->get();

//role_masrer
$role_masrer = DB::table('role_masrer')
->get();
        return view("add_HR_view")
            ->with('reg_id', "0")
            ->with('reg_email', "0")
            ->with('role', $role)
            ->with('shift_master', $shift_master)
            ->with('role_masrer', $role_masrer)
            ->with('employee_type_master', $employee_type_master)
            ->with('stape', 1);

    } else {
        return redirect()->route('login');
    }
}

//add_guard

public function add_guard()
{
    $EmployeesID = session()->get('EmployeeID');
    $role = session()->get('role');
    if (isset($EmployeesID)) {

//shift_master
$shift_master = DB::table('shift_master')
->get();

//employee_type_master
$employee_type_master = DB::table('shift__employee_type_master')
->get();

//role_masrer
$role_masrer = DB::table('role_masrer')
->get();
        return view("add_guard_view")
            ->with('reg_id', "0")
            ->with('reg_email', "0")
            ->with('role', $role)
            ->with('shift_master', $shift_master)
            ->with('role_masrer', $role_masrer)
            ->with('employee_type_master', $employee_type_master)
            ->with('stape', 1);

    } else {
        return redirect()->route('login');
    }
}



public function Add_Users(Request $add){

    if($add->Password == $add->Conform_Password){
        if ($add->User_role == "") {
            return response()->json(['success' => true, 'message' => 'Please Select User Role']);
        }else{

            if($add->Add_Users_input_id =="" || $add->Add_Users_input_id ==null){
                $users = DB::table('users')
                ->insertOrIgnore([
                    'name' => $add->User_name,
                    'f_name' => $add->User_name,
                    'm_name' => "",
                    'l_name' => "",
                    'email' => $add->Email_Id,
                    'mobile_number' => $add->Mobile_Number,
                    'password'=> $add->Password,
                     'role' =>$add->User_role,
                    'created_at' => now(),
                    'updated_at' => now(),

                ]);

                if($users){
                    return response()->json(['success' => true, 'message' => 'User added successfully.']);
                    }else{
                        return response()->json(['success' => true, 'message' => 'User Not added.']);
                    }
            }else{
                $users = DB::table('users')
                ->where('Employee_id', $add->Add_Users_input_id)
                ->update( [
                   'name' => $add->User_name,
                    'f_name' => $add->User_name,
                    'm_name' => "",
                    'l_name' => "",
                    'email' => $add->Email_Id,
                    'mobile_number' => $add->Mobile_Number,
                    'password'=> $add->Password,
                     'role' =>$add->User_role,
                    'updated_at' => now(),
                ]);

                if($users){
                    return response()->json(['success' => true, 'message' => 'User details Updated successfully.']);
                    }else{
                        return response()->json(['success' => true, 'message' => 'User details Not Updated .']);
                    }
            }




    }
}else{
    return response()->json(['success' => true, 'message' => 'Password And Conform Password Are Not Same']);
}
}

public function add_user(Request $add)
{
    try {
        // Get only the first and last name
        $F_name = $add->f_name;
        $L_name = $add->l_name;

        // Get the next Employee_id
        try {
            $lastEmployee = DB::table('all_users')->latest('Employee_id')->first();
            $Employee_id = $lastEmployee ? $lastEmployee->Employee_id + 1 : 1;
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'Message' => 'Error getting last employee ID',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }

        // Generate a random password
        $Password = rand(100000, 999999);

        // Get the current user's ID
        $created_by = session()->get('EmployeeID') ?? 1;

        // Prepare data for insertion with all required fields
        $userData = [
            'f_name' => $F_name,
            'l_name' => $L_name,
            'm_name' => "",
            'email' => "",
            'mobile_number' => "",
            'dob' => null,
            'password' => $Password,
            'Employee_id' => $Employee_id,
            'current_address' => "",
            'permanent_address' => "",
            'gender' => "",
            'marital_status' => "",
            'aadhaar_number' => "",
            'voter_id_number' => "",
            'pan_number' => "", // Add this field as it's required
            'photo_name' => "", // Add the missing photo_name field with an empty default
            'ration_card_number'=> "",
            'salary' => 0,      // Add default salary
            'role' => 1,        // Default role
            'employee_type' => 1, // Default employee type
            'Department' => 1,  // Default department
            'shift_time' => 1,  // Default shift
            'created_by' => $created_by,
            'updated_by' => $created_by,
            'can_login' => 1,   // Allow login by default
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Log the data we're trying to insert
        \Log::info('Attempting to insert user with data:', $userData);

        // Insert information into the all_users table
        try {
            $users = DB::table('all_users')->insert($userData);
            if (!$users) {
                return response()->json([
                    'success' => false,
                    'Message' => 'Failed to insert user data',
                    'attempted_data' => $userData
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'Message' => 'Error inserting user data',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'attempted_data' => $userData
            ]);
        }

        // Create a minimal account record
        try {
            $accountData = [
                'Employee_id' => $Employee_id,
                'Account_Holder_Name' => $F_name . ' ' . $L_name,
                'Bank_Name' => "",
                'Account_Number' => "",
                'IFSC_Code' => "",
                'created_by' => $created_by,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            \Log::info('Attempting to insert account with data:', $accountData);

            $Bank_AccountQR = DB::table('accounts')->insert($accountData);

            if (!$Bank_AccountQR) {
                // If account insert fails, log it but continue
                \Log::warning('Failed to insert account data:', $accountData);
            }
        } catch (\Exception $e) {
            // If account insert throws an exception, log it but continue
            \Log::error('Error inserting account data: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
        }

        // Insert default permissions
        try {
            $permissionsData = [
                'Employee_id' => $Employee_id,
                'Add_User' => 1,
                'Update_User' => 1,
                'Delete_User' => 1,
                'Add_General_Informations' => 1,
                'Update_General_Informations' => 1,
                'Delete_General_Informations' => 1,
                'Update_Set_Salary' => 1,
                'Delete_Set_Salary' => 1,
                'Update_Leave' => 1,
                'Delete_Leave' => 1,
                'Add_Attendance' => 1,
                'Update_Attendance' => 1,
                'Add_Core_HR' => 1,
                'Update_Core_HR' => 1,
                'Delete_Core_HR' => 1,
                'Add_Project_Task' => 1,
                'Update_Project_Task' => 1,
                'Delete_Project_Task' => 1,
                'Add_Payslip' => 1,
                'Update_Payslip' => 1,
                'Delete_Payslip' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'Add_Set_Salary' => 1,
                'Add_Leave' => 1,
                'Delete_Attendance' => 1
            ];

            \Log::info('Attempting to insert permissions with data:', ['Employee_id' => $Employee_id]);

            $permissions = DB::table('user_permissions')->insert($permissionsData);

            if (!$permissions) {
                // If permissions insert fails, log it but continue
                \Log::warning('Failed to insert permissions data');
            }
        } catch (\Exception $e) {
            // If permissions insert throws an exception, log it but continue
            \Log::error('Error inserting permissions data: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
        }

        return response()->json([
            'success' => true,
            'Message' => 'Registration success',
            'F_name' => $F_name,
            'L_name' => $L_name,
            'Employee_id' => $Employee_id,
            'Password' => $Password,
        ]);
    } catch (\Exception $e) {
        // Catch any other exceptions
        return response()->json([
            'success' => false,
            'Message' => 'Unexpected error during registration',
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }
}

}

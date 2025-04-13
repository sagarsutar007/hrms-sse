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



public function add_user(Request $request)
{
    try {
        // Get only the first and last name
        $F_name = $request->f_name;
        $L_name = $request->l_name;

        // Get the next Employee_id
        try {
            $lastEmployee = DB::table('all_users')->latest('Employee_id')->first();
            $Employee_id = $lastEmployee ? $lastEmployee->Employee_id + 1 : 1;
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'Message' => 'Error getting last employee ID',
                'error' => $e->getMessage()
            ]);
        }

        // Generate a random password
        $Password = rand(100000, 999999);

        // Generate a random mobile number if not provided
        $mobile_number = $request->m_number ?: $this->generateRandomMobileNumber();

        // Get the current user's ID
        $created_by = session()->get('EmployeeID') ?? 1;

        // Prepare data for insertion with correct field mappings
        $userData = [
            'f_name' => $F_name,
            'l_name' => $L_name,
            'm_name' => $request->m_name ?? "",
            'email' => $request->email ?? "",
            'mobile_number' => $mobile_number,
            'dob' => $request->dob ?? null,
            'password' => $Password,
            'Employee_id' => $Employee_id,
            'current_address' => $request->c_address ?? "",
            'permanent_address' => $request->p_address ?? "",
            'gender' => $request->gender ?? "",
            'marital_status' => $request->marital_status ?? "",
            'aadhaar_number' => $request->aadhaar_number ?: null,
            'voter_id_number' => $request->voter_ID ?? "",
            'pan_number' => $request->Pan_number ?? "",
            'photo_name' => "",
            'ration_card_number'=> $request->rasancard_number ?? "",
            'salary' => $request->Salary ?? 0,
            'role' => $request->role ?? 3,
            'employee_type' => $request->emp_type ?? 1,
            'Department' => $request->department_master ?? 1,
            'shift_time' => $request->shift ?? 1,
            'created_by' => $created_by,
            'updated_by' => $created_by,
            'can_login' => $request->can_login ?? 0,
            'DOJ' => $request->DOJ ?? now()->toDateString(),
            'highest_qualification' => $request->qualification ?? "",
            'QR_Code' => "",
            'reason_of_termination' => "",
            'gender' => in_array($request->gender, ['Male', 'Female', 'Other']) ? $request->gender : 'Other',
            'marital_status' => in_array($request->marital_status, ['Single', 'Married', 'Divorced', 'Widowed']) ? $request->marital_status : null,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Log the data we're trying to insert
        \Log::info('Attempting to insert user with data:', $userData);

        // Insert the user data into the all_users table
        try {
            $users = DB::table('all_users')->insert($userData);
            if (!$users) {
                return response()->json([
                    'success' => false,
                    'Message' => 'Failed to insert user data'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'Message' => 'Error inserting user data: ' . $e->getMessage()
            ]);
        }

        // Create an account record with form data (optional)
        try {
            $accountData = [
                'Employee_id' => $Employee_id,
                'Account_Holder_Name' => $request->Bank_Hoalder_Name ?? ($F_name . ' ' . $L_name),
                'Bank_Name' => $request->Bank_Name ?? "",
                'Account_Number' => $request->Account_Number ?? "",
                'IFSC_Code' => $request->IFSC_Code ?? "",
                'created_by' => $created_by,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            DB::table('accounts')->insert($accountData);
        } catch (\Exception $e) {
            \Log::error('Error inserting account data: ' . $e->getMessage());
        }

        // Insert permissions (optional)
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

            DB::table('user_permissions')->insert($permissionsData);
        } catch (\Exception $e) {
            \Log::error('Error inserting permissions data: ' . $e->getMessage());
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
        return response()->json([
            'success' => false,
            'Message' => 'Unexpected error during registration: ' . $e->getMessage()
        ]);
    }
}

// Helper function to generate random mobile number
private function generateRandomMobileNumber()
{
    // Generate a random mobile number starting with a typical country code (e.g., India: +91)
    $country_code = "+91";
    $mobile_number = $country_code . rand(1000000000, 9999999999);
    return $mobile_number;
}


}

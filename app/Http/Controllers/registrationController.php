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
        $role = session()->get('role');
        $Email_ID = $add->email;
        $F_name = $add->f_name;
        $M_name = $add->m_name;
        $L_name = $add->l_name;
        $mobile_number = $add->m_number;
        $dob = $add->dob;
        $Email = $add->reg_email;
        $C_address = $add->c_address;
        $P_address = $add->p_address;
        $Gender = $add->gender;
        $Status = $add->Status;
        $login_Status = $add->login_Status;
        $aadhaar_number = $add->aadhaar_number;
        $Pan_number = $add->Pan_number;
        $voter_ID = $add->voter_ID;
        $Salary = $add->Salary;
        $shift = $add->shift;
        $emp_type = $add->emp_type;
        $srasancard_number = $add->rasancard_number;
        $department_master = $add->department_master;
        $role = $add->role;
        $Employee_id = DB::table('all_users')->get()->last()->Employee_id + 1;

        $r = rand(1, 9);
        $s = rand(1, 9);
        $t = rand(1, 9);
        $u = rand(1, 9);
        $v = rand(1, 9);
        $w = rand(1, 9);
        $x = rand(1, 9);

        $created_by = session()->get('EmployeeID');
        $Password = $r . $s . $t . $u . $v . $x;

        $users = DB::table('all_users')
            ->insertOrIgnore([
                'f_name' => $F_name,
                'm_name' => $M_name,
                'l_name' => $L_name,
                'email' => $Email_ID,
                'mobile_number' => $mobile_number,
                'dob' => $dob,
                'created_by' => $created_by,
                'password' => $Password,
                'Employee_id' => $Employee_id,
                'current_address' => $C_address,
                'permanent_address' => $P_address,
                'gender' => $Gender,
                 'marital_status' => $Status,
                 'aadhaar_number' => $aadhaar_number,
                 'voter_id_number' => $voter_ID,
                 'pan_number' => $Pan_number,
                 'salary' => $Salary,
                 'shift_time' => $shift,
            
                 'role' =>$role,
                 'employee_type' =>$emp_type,
                 'created_by' => $created_by ,
                 'updated_by' => $created_by ,
                 'Department' => $department_master ,
                 
                 'can_login' =>$login_Status ,
                'created_at' => now(),
                'updated_at' => now(),

            ]);

            $emp_id =  $Employee_id;
            $Holder_Name = $add->Bank_Hoalder_Name;
            $Bank_Name = $add->Bank_Name;
            $Account_Number = $add->Account_Number;
            $IFSC_Code = $add->IFSC_Code;

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
            if($users){

                $users = DB::table('user_permissions')
                ->insertOrIgnore([
                   
                    'Employee_id' => $Employee_id,
                    'Add_User' => 1, 
                    'Update_User'=> 1, 
                    'Delete_User'=> 1, 
                    'Add_General_Informations'=> 1,
                     'Update_General_Informations'=> 1, 
                     'Delete_General_Informations'=> 1, 
                     'Update_Set_Salary'=> 1,
                      'Delete_Set_Salary'=> 1,
                       'Update_Leave'=> 1,
                        'Delete_Leave'=> 1, 
                        'Add_Attendance'=> 1, 
                        'Update_Attendance'=> 1, 
                        'Add_Core_HR'=> 1,
                         'Update_Core_HR'=> 1, 
                         'Delete_Core_HR'=> 1, 
                         'Add_Project_Task'=> 1, 
                         'Update_Project_Task'=> 1,
                          'Delete_Project_Task'=> 1,
                           'Add_Payslip'=> 1, 
                           'Update_Payslip'=> 1,
                            'Delete_Payslip'=> 1,
                             'created_at'=> 1, 
                             'updated_at'=> 1, 
                             'Add_Set_Salary'=> 1,
                              'Add_Leave'=> 1,
                               'Delete_Attendance'=> 1 
                               
                ]);


?>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box
}

.pupup_reg_div {
    width: 100vw;
    height: 100vh;

    position: fixed;
    top: 0;
    left: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #e4e3e3a6;
}

.pupup_Inner_reg_div {
    width: 300px;
    height: 250px;
    padding: 20px;
    display: flex;


    background: white;
    flex-direction: column;
    border-radius: 4px;
}

p {
    margin-top: 7px;
}

button {
    margin-top: 10px;
    padding: 7px;
}

h2 {
    margin: 4px;
}
</style>
<div class="pupup_reg_div">
    <div class="pupup_Inner_reg_div">
        <h2 style="text-align: center">congratulations</h2>
        <hr>
        <p><b>Name : </b><?php echo $F_name . " " . $M_name . " ". $L_name ?></p>
        <p><b>Email :</b> <?php echo $Email_ID ?></p>
        <p><b>Mobile :</b> <?php echo $mobile_number ?></p>
        <p><b>User ID :</b> <?php echo $Employee_id  ?> </p>
        <p><b>Password : </b> <?php echo $Password ?></p>
        <button onclick="history.back();">Close</button>

    </div>

</div>



<?php




               
            }else{
                ?>
<script>
alert("Registration faield")
history.back()
</script>
<?php
            }

       

    }

}
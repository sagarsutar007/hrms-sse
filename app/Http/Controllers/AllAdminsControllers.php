<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AllAdminsControllers extends Controller
{



  public function admin() {
    $EmployeesID = session()->get('EmployeeID');
    $role = session()->get('role');
    if(isset( $EmployeesID)){ 

      $roler_permissions = DB::table('roler_permissions')
      ->get();

      $dbData = DB::table('all_users')
->join('role_masrer', 'role_masrer.id', '=', 'all_users.role')
->select('all_users.*', 'role_masrer.roles')
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



      
     return view("Admin")
     ->with('roler_permissions',$roler_permissions)
     ->with('shift_master',$shift_master)
     ->with('employee_type_master',$employee_type_master)
     ->with('role_masrer',$role_masrer)
     ->with( 'users' ,$dbData)
     ->with('role',$role);
    }else{
      return redirect()->route('login');
    }
}


    public function all_admins() {
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
        if(isset( $EmployeesID)){
if($role == "Super admin"){
  $dbData = DB::table('all_users')
  ->join('role_masrer', 'role_masrer.id', '=', 'all_users.role')
  ->select('all_users.*', 'role_masrer.roles')
  ->get();
return view("all_admin")
->with( 'users' ,$dbData)
->with('role',$role);
}else{
  ?>
<script>
alert("you have no permission for this page")
history.back()
</script>
<?php

}



           
        }else{
          return redirect()->route('login');
        }
    } 




    public function search_users(Request $req) {
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');
      if(isset( $EmployeesID)){
if($role == "Super admin"){
$dbData = DB::table('all_users')
->join('role_masrer', 'role_masrer.id', '=', 'all_users.role')
->select('all_users.*', 'role_masrer.roles')
->whereAny([
  'all_users.id','all_users.f_name','all_users.m_name','all_users.l_name','all_users.email',
  'all_users.Employee_id','all_users.mobile_number','all_users.aadhaar_number','all_users.pan_number',
  'all_users.dob','all_users.shift_time','all_users.employee_type','all_users.role',
], 'like', '%'. $req->search_input.'%')
->get();
return view("all_admin")
->with( 'users' ,$dbData)
->with('role',$role);
}else{
?>
<script>
alert("you have no permission for this page")
history.back()
</script>
<?php

}
  
      }else{
        return redirect()->route('login');
      }
  } 

    public function edit_permissions_view(Request $req) {
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
        if(isset( $EmployeesID)){

          $emp_id = $req->employee_id;
            $dbData = DB::table('all_users')
            ->join('role_masrer', 'role_masrer.id', '=', 'all_users.role')
            ->select('all_users.*', 'role_masrer.roles')
            ->get();
            
            $permissionData = DB::table('user_permissions')
            ->where('Employee_id',$emp_id)
            ->get();

            if(isset($dbData) && isset($permissionData)){
              return view("edit_permissions")
              ->with( 'users' ,$dbData)
              ->with( 'permission' ,$permissionData)
              ->with('role',$role)
              ->with('EmployeesID',$emp_id);
            }else{
              ?>
<script>
alert("Server Error")
history.back()
</script>
<?php       
            }
        }else{
          return redirect()->route('login');
        }
    }

    public function edit_permissions(Request $req) {
if($req->Add_User == "on"){
  $Add_User = 1;
}else{
  $Add_User = 0;
}
if($req->Update_User == "on"){
  $Update_User = 1;
}else{
  $Update_User = 0;
}

if($req->Delete_User == "on"){
  $Delete_User = 1;
}else{
  $Delete_User = 0;
}

if($req->Add_General_Informations == "on"){
  $Add_General_Informations = 1;
}else{
  $Add_General_Informations = 0;
}

if($req->Update_General_Informations == "on"){
  $Update_General_Informations = 1;
}else{
  $Update_General_Informations = 0;
}

if($req->Delete_General_Informations == "on"){
  $Delete_General_Informations = 1;
}else{
  $Delete_General_Informations = 0;
}
if($req->Add_Set_Salary == "on"){
  $Add_Set_Salary = 1;
}else{
  $Add_Set_Salary = 0;
}

if($req->Update_Set_Salary == "on"){
  $Update_Set_Salary = 1;
}else{
  $Update_Set_Salary = 0;
}

if($req->Delete_Set_Salary == "on"){
  $Delete_Set_Salary = 1;
}else{
  $Delete_Set_Salary = 0;
}


if($req->Add_Leave == "on"){
  $Add_Leave = 1;
}else{
  $Add_Leave = 0;
}
if($req->Update_Leave == "on"){
  $Update_Leave = 1;
}else{
  $Update_Leave = 0;
}
if($req->Delete_Leave == "on"){
  $Delete_Leave = 1;
}else{
  $Delete_Leave = 0;
}


if($req->Add_Attendance == "on"){
  $Add_Attendance = 1;
}else{
  $Add_Attendance = 0;
}
if($req->Update_Attendance == "on"){
  $Update_Attendance = 1;
}else{
  $Update_Attendance = 0;
}
if($req->Delete_Attendance == "on"){
  $Delete_Attendance= 1;
}else{
  $Delete_Attendance = 0;
}



if($req->Add_Core_HR == "on"){
  $Add_Core_HR = 1;
}else{
  $Add_Core_HR = 0;
}
if($req->Update_Core_HR == "on"){
  $Update_Core_HR = 1;
}else{
  $Update_Core_HR = 0;
}
if($req->Delete_Core_HR == "on"){
  $Delete_Core_HR= 1;
}else{
  $Delete_Core_HR  = 0;
}

if($req->Add_Project_Task == "on"){
  $Add_Project_Task = 1;
}else{
  $Add_Project_Task = 0;
}
if($req->Update_Project_Task == "on"){
  $Update_Project_Task = 1;
}else{
  $Update_Project_Task = 0;
}
if($req->Delete_Project_Task == "on"){
  $Delete_Project_Task= 1;
}else{
  $Delete_Project_Task  = 0;
}


if($req->Add_Project_Task == "on"){
  $Add_Project_Task = 1;
}else{
  $Add_Project_Task = 0;
}
if($req->Update_Project_Task == "on"){
  $Update_Project_Task = 1;
}else{
  $Update_Project_Task = 0;
}
if($req->Delete_Project_Task == "on"){
  $Delete_Project_Task= 1;
}else{
  $Delete_Project_Task  = 0;
}


if($req->Add_Payslip == "on"){
  $Add_Payslip = 1;
}else{
  $Add_Payslip = 0;
}
if($req->Update_Payslip == "on"){
  $Update_Payslip = 1;
}else{
  $Update_Payslip = 0;
}
if($req->Delete_Payslip == "on"){
  $Delete_Payslip = 1;
}else{
  $Delete_Payslip  = 0;
}
if($req->view_menu_items == "on"){
  $view_menu_items = 1;
}else{
  $view_menu_items  = 0;
}
if($req->view_home_page_options == "on"){
  $view_home_page_options = 1;
}else{
  $view_home_page_options  = 0;
}



$update_basic_info = DB::table('user_permissions') 
->where('Employee_id', $req->Employee_ID) 
 ->update( [ 
 'Add_User' => $Add_User, 
 'Update_User' => $Update_User, 
 'Delete_User' => $Delete_User, 

 'Add_General_Informations' => $Add_General_Informations, 
 'Update_General_Informations' =>$Update_General_Informations, 
 'Delete_General_Informations' =>$Delete_General_Informations, 
 
 'Add_Set_Salary' => $Add_Set_Salary, 
 'Update_Set_Salary' => $Update_Set_Salary, 
 'Delete_Set_Salary' => $Delete_Set_Salary, 

 'Add_Leave' => $Add_Leave, 
 'Update_Leave' => $Update_Leave, 
 'Delete_Leave' => $Delete_Leave, 

 'Add_Attendance' => $Add_Attendance, 
 'Update_Attendance' => $Update_Attendance, 
 'Delete_Attendance' => $Delete_Attendance, 

 'Add_Core_HR' => $Add_Core_HR, 
 'Update_Core_HR' => $Update_Core_HR, 
 'Delete_Core_HR' => $Delete_Core_HR, 

 'Add_Project_Task' => $Add_Project_Task, 
 'Update_Project_Task' => $Update_Project_Task, 
 'Delete_Project_Task' => $Delete_Project_Task, 

 'Add_Payslip' => $Add_Payslip, 
 'Update_Payslip' => $Update_Payslip, 
 'Delete_Payslip' => $Delete_Payslip, 

 'view_menu_items' => $view_menu_items, 
 'view_home_page_options' => $view_home_page_options, 

 
 
]);

if(isset($update_basic_info)){
  ?>
<script>
alert("data updated")
history.back()
</script>
<?php
 
}






  
      
  }




  // admin permissions
  public function edit_admin_permissions (Request $req) {

    
    if($req->Add_HR == "on"){
      $Add_HR = 1;
    }else{
      $Add_HR = 0;
    }
    if($req->Update_HR == "on"){
      $Update_HR = 1;
    }else{
      $Update_HR = 0;
    }

    if($req->Delete_HR == "on"){
      $Delete_HR = 1;
    }else{
      $Delete_HR = 0;
    }
    
    if($req->Add_Employee == "on"){
      $Add_Employee = 1;
    }else{
      $Add_Employee = 0;
    }
    
    if($req->Update_Employee == "on"){
      $Update_Employee = 1;
    }else{
      $Update_Employee = 0;
    }
    
    if($req->Delete_Employee == "on"){
      $Delete_Employee = 1;
    }else{
      $Delete_Employee = 0;
    }
    
    if($req->Add_Guard == "on"){
      $Add_Guard = 1;
    }else{
      $Add_Guard = 0;
    }
    if($req->Update_Guard == "on"){
      $Update_Guard = 1;
    }else{
      $Update_Guard = 0;
    }
    
    if($req->Delete_Guard == "on"){
      $Delete_Guard = 1;
    }else{
      $Delete_Guard = 0;
    }
    
    if($req->Add_Admin == "on"){
      $Add_Admin = 1;
    }else{
      $Add_Admin = 0;
    }
    
    
    if($req->Update_Admin == "on"){
      $Update_Admin = 1;
    }else{
      $Update_Admin = 0;
    }
    if($req->Delete_Admin == "on"){
      $Delete_Admin = 1;
    }else{
      $Delete_Admin = 0;
    }
    if($req->view_General_Informations == "on"){
      $view_General_Informations = 1;
    }else{
      $view_General_Informations = 0;
    }
    
    
    if($req->view_Profile == "on"){
      $view_Profile = 1;
    }else{
      $view_Profile = 0;
    }
    if($req->view_Set_Salary == "on"){
      $view_Set_Salary = 1;
    }else{
      $view_Set_Salary = 0;
    }
    if($req->view_Project_Task == "on"){
      $view_Project_Task= 1;
    }else{
      $view_Project_Task = 0;
    }
    if($req->view_Payslip == "on"){
      $view_Payslip = 1;
    }else{
      $view_Payslip = 0;
    }
    if($req->view_Core_HR == "on"){
      $view_Core_HR = 1;
    }else{
      $view_Core_HR = 0;
    }

    if($req->Edit_Shift == "on"){
      $Edit_Shift = 1;
    }else{
      $Edit_Shift = 0;
    }
    if($req->Add_Shift == "on"){
      $Add_Shift = 1;
    }else{
      $Add_Shift = 0;
    }
    if($req->Delete_Shift == "on"){
      $Delete_Shift = 1;
    }else{
      $Delete_Shift = 0;
    }
    if($req->Add_Employee_Type == "on"){
      $Add_Employee_Type = 1;
    }else{
      $Add_Employee_Type = 0;
    }
    if($req->Edit_Employee_Type == "on"){
      $Edit_Employee_Type = 1;
    }else{
      $Edit_Employee_Type = 0;
    }
    if($req->Delete_Employee_Type == "on"){
      $Delete_Employee_Type = 1;
    }else{
      $Delete_Employee_Type = 0;
    }
    if($req->Add_Role == "on"){
      $Add_Role = 1;
    }else{
      $Add_Role = 0;
    }
    if($req->Edit_Role == "on"){
      $Edit_Role = 1;
    }else{
      $Edit_Role = 0;
    }
    if($req->Delete_Role == "on"){
      $Delete_Role = 1;
    }else{
      $Delete_Role = 0;
    }
    if($req->Change_Password == "on"){
      $Change_Password = 1;
    }else{
      $Change_Password = 0;
    }


    $update_basic_info = DB::table('roler_permissions') 
->where('role_name', $req->role_name) 
 ->update( [ 
'Add_HR' => $Add_HR,
 'Update_HR' => $Update_HR, 
     'Delete_HR' => $Delete_HR, 
    
     'Add_Employee' => $Add_Employee, 
     'Update_Employee' =>$Update_Employee, 
     'Delete_Employee' =>$Delete_Employee, 
     
     'Add_Guard' => $Add_Guard, 
     'Update_Guard' => $Update_Guard, 
     'Delete_Guard' => $Delete_Guard, 
    
     'Add_Admin' => $Add_Admin, 
     'Update_Admin' => $Update_Admin, 
     'Delete_Admin' => $Delete_Admin, 
    
     'view_General_Informations' => $view_General_Informations, 
     'view_Profile' => $view_Profile, 
     'view_Set_Salary' => $view_Set_Salary, 
    
     'view_Payslip' => $view_Project_Task, 
     'view_Project_Task' => $view_Payslip, 
     'view_Core_HR' => $view_Core_HR, 

     'Add_Shift' => $Add_Shift, 
     'Edit_Shift' => $Edit_Shift, 
     'Delete_Shift' => $Delete_Shift, 
     'Add_Employee_Type' => $Add_Employee_Type, 
     'Edit_Employee_Type' => $Edit_Employee_Type, 
     'Delete_Employee_Type' => $Delete_Employee_Type, 
     'Add_Role' => $Add_Role, 
     'Edit_Role' => $Edit_Role, 
     'Delete_Role' => $Delete_Role, 
     'Change_Password' => $Change_Password, 
     
 ]);


if($update_basic_info){
  ?>
<script>
alert("data Updated")
history.back();
</script>
<?php
}else{
  ?>
<script>
alert("data Not Updated")
history.back();
</script>
<?php
}
 
   
    
  
    
  
    
      }

  

}
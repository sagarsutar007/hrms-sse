<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HR_setting_controller extends Controller
{
    public function HR_page() {
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
        if(isset( $EmployeesID)){
if($role == "HR"){
    $dbData = DB::table('all_users')
    ->join('role_masrer', 'role_masrer.id', '=', 'all_users.role')
    ->select('all_users.*', 'role_masrer.roles')
    ->get();
 return view("hr_page")
 ->with( 'users' ,$dbData)
 ->with('role',$role);
}else{

?>
<script>
alert("Not Permission")
</script>
<?php

}

        }else{
          return redirect()->route('login');
        }
    }


    // add_Department_form
    public function add_Department_form(Request $req){
        $EmployeesID = session()->get('EmployeeID');
        $role_sec = session()->get('role');
        if(isset( $EmployeesID)){

if ($req->Department_input_id != "") {


    $update_Department=DB::table('department_master')
    ->where('id',  $req->Department_input_id)
     ->update( [
        'Department_name'=>$req->Department,

    ]);

    if( $update_Department){
        return response()->json([
            'status' => 'success',
            'message' => 'Department Updated successfully.',
        ]);
    }else{
        return response()->json([
            'status' => 'error',
            'message' => "erro Department Not Updated .",
        ]);
    }
} else {

            $add_Department=DB::table('department_master')
            ->insertOrIgnore([
                'Department_name'=>$req->Department,
                'created_at'=>now(),
                'updated_at'=>now()

            ]);

            if($add_Department){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Department added successfully.',
                ]);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => "erro",
                ]);
            }
        }

        }else{
          return redirect()->route('login');
        }
    }


     // add_Leave_Master_Form
     public function add_Leave_Master_Form(Request $req){

        $EmployeesID = session()->get('EmployeeID');
        $role_sec = session()->get('role');
        if(isset( $EmployeesID)){

$leave_id =  $req->leav_master_id;
if(isset($leave_id)){
    $add_Department=DB::table('leave_type_master')
    ->where('id', $req->leav_master_id)
    ->update( [
        'Name'=>$req->Leave_Type,
        'Payment_Status'=>$req->Payment_Status,
        'Short_Name'=>$req->Short_Name,
        'Color'=>$req->Color,
    ]);

    if($add_Department){
        return response()->json([
            'status' => 'success',
            'message' => 'Leave Master Updated successfully.',
        ]);
    }else{
        return response()->json([
            'status' => 'error',
            'message' => "erro",
        ]);
    }
}else {

            $add_Department=DB::table('leave_type_master')
            ->insertOrIgnore([

                'Name'=>$req->Leave_Type,
        'Payment_Status'=>$req->Payment_Status,
        'Short_Name'=>$req->Short_Name,
        'Color'=>$req->Color,


            ]);

            if($add_Department){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Leave Master added successfully.',
                ]);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => "erro",
                ]);
            }
        }

        }else{
          return redirect()->route('login');
        }
    }
    public function delet_Leave_Master_Form(Request $req){
$Delet_leave = DB::table('leave_type_master')
        ->where('id',$req->id)
        ->delete();

        if($Delet_leave){
            ?>
<script>
alert("Leave Type Deleted")
history.back().reload();
</script>
<?php
        }else{
            ?>
<script>
alert("Leave Type Not Deleted")
history.back();
</script>
<?php
        }

    }
// Leave Master View API
public function Leave_Master_view(Request $req)
{
    $leave_type = DB::table('leave_type_master')
        ->where('id', $req->id)
        ->first();

    if ($leave_type) {
        return response()->json([
            'status' => 'success',
            'data' => $leave_type,
        ], 200);
    } else {
        return response()->json([
            'status' => 'error',
            'message' => 'Leave type not found',
        ], 404);
    }
}
public function depaetment_Master_view(Request $req)
{
    $leave_type = DB::table('department_master')
        ->where('id', $req->id)
        ->first();

    if ($leave_type) {
        return response()->json([
            'status' => 'success',
            'data' => $leave_type,
        ], 200);
    } else {
        return response()->json([
            'status' => 'error',
            'message' => 'Leave type not found',
        ], 404);
    }
}

    public function add_role_form(Request $req) {
        $EmployeesID = session()->get('EmployeeID');
        $role_sec = session()->get('role');
        if(isset( $EmployeesID)){

   $role = $req->role;

   if($role ==""){
    ?>
<script>
alert("please Provide role data")
history.back();
</script>
<?php

   }else{

    try
    {

  //roler_permissions
  $roler_permissions_qr = DB::table('roler_permissions')

  ->where('role_name', $role_sec)
  ->get();
  $add_shift = 0;
  foreach($roler_permissions_qr as $roler_p){
      $add_shift = $roler_p->Add_Role ;

  }

if($add_shift == 1){

        $roleQuri=DB::table('role_masrer')
        ->insertOrIgnore([
            'roles'=>$role,
            'updated_by'=>$EmployeesID,
            'created_by'=>$EmployeesID,
            'created_at'=>now(),
            'updated_at'=>now()

        ]);


        $role_permissions_Quri=DB::table('roler_permissions')
        ->insertOrIgnore([


            'created_at'=>now(),
            'updated_at'=>now(),
            'role_name' =>$role,
             'Add_Employee'=> 0,
             'Update_Employee'=> 0,
             'Delete_Employee'=> 0,
             'Add_HR'=> 0,
             'Update_HR'=> 0,
             'Delete_HR'=> 0,
             'Update_Admin'=> 0,
             'Delete_Admin'=> 0,
              'Add_Guard'=> 0,
                'Update_Guard'=> 0,
                'Delete_Guard'=> 0,
                'Add_Admin'=> 0,
                'view_General_Informations'=> 0,
                'view_Profile'=> 0,
                'view_Set_Salary'=> 0,
                'view_Leave'=> 0,
                'view_Attendance'=> 0,
                'view_Core_HR'=> 0,
                'view_Project_Task'=> 0,
                'Add_Shift'=> 0,
                'Edit_Shift'=> 0,
                'Delete_Shift'=> 0,
                'Add_Employee_Type'=> 0,
                'Edit_Employee_Type'=> 0,
                'Delete_Employee_Type'=> 0,
                'Add_Role'=> 0,
                'Edit_Role'=> 0,
                'Delete_Role'=> 0,
                'Change_Password'=> 0,
                'view_Payslip'=> 0

        ]);
    }else{

        ?>
<script>
alert("Not Permission")
</script>
<?php

        }



        if($roleQuri){

            ?>
<script>
alert("role added")
history.back();
</script>
<?php
      echo "please Provide role data" ;
        }else{
            ?>
<script>
alert("Error Data not inserted")
history.back();
</script>
<?php

            dd($roleQuri);
            echo "Error Data not inserted";
        }
    }
    catch(Exception $e)
    {
       dd($e->getMessage());
    }
   }

        }else{
          return redirect()->route('login');
        }
    }
    public function change_Password(Request $req) {
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
        if(isset( $EmployeesID)){


   if($req->Password ==""){
    ?>
<script>
alert("please Provide change password data")
history.back();
</script>
<?php

   }else{
    try
    {
if($req->Password == $req->CPassword){
 //roler_permissions
 $roler_permissions_qr = DB::table('roler_permissions')
 ->where('role_name',$role)
 ->get();
 $add_shift = 0;
 foreach($roler_permissions_qr as $roler_p){
     $add_shift = $roler_p->Change_Password ;
 }

if($add_shift == 1){

    $change_password = DB::table('all_users')
    ->where('Employee_id', $req->Employee_Id)
     ->update( [
     'password' => $req->Password,
     'updated_at' => now(),
    ]);

}else{
    ?>
<script>
alert("Not Permission")
history.back();
</script>
<?php
  }

    if($change_password){
        ?>
<script>
alert("Data inserted")
history.back();
</script>
<?php
        echo "Data inserted" ;
      }else{
        ?>
<script>
alert("Error Data not inserted")
history.back();
</script>
<?php
          dd($roleQuri);
          echo "Error Data not inserted";
      }

}else{
    ?>
<script>
alert("Password and conform password are note same")
history.back();
</script>
<?php
    echo "Password and conform password are note same";
}
    }
    catch(Exception $e)
    {
       dd($e->getMessage());
    }
   }

        }else{
          return redirect()->route('login');
        }
    }





   //add emploee type
    public function add_employee_type(Request $req) {
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
        if(isset( $EmployeesID)){
   $emp_m = $req->emp_m;
   $Daily_Wages = $req->Daily_Wages;
   $Eligible_for_OverTime = $req->Eligible_for_OverTime;
   if(isset($emp_m)){

  //roler_permissions
  $roler_permissions_qr = DB::table('roler_permissions')
  ->where('role_name',$role)
  ->get();
  $add_shift = 0;
  foreach($roler_permissions_qr as $roler_p){
      $add_shift = $roler_p->Add_Employee_Type ;
  }

if($add_shift == 1){
    $roleQuri=DB::table('shift__employee_type_master')
    ->insertOrIgnore([
        'EmpTypeName'=>$emp_m,
        'Daily_Wages'=>$Daily_Wages,
        'Eligible_for_OverTime'=>$Eligible_for_OverTime,
        'updated_by'=>$EmployeesID,
        'created_by'=>$EmployeesID,
        'created_at'=>now(),
        'updated_at'=>now()
    ]);
}else{
    ?>
<script>
alert("Not Permission")
history.back();
</script>
<?php
  }


    if($roleQuri){
        ?>
<script>
alert("data Inserted")
history.back();
</script>
<?php

    }else{
        ?>
<script>
alert("data Not Inserted")
history.back();
</script>
<?php
    }

   }

        }else{
          return redirect()->route('login');
        }
    }






}

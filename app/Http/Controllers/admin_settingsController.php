<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class admin_settingsController extends Controller
{
 public function super_admin_settings() {
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
//role_masrer

$depatrment_master = DB::table('department_master')
->get();

$leave_type_master = DB::table('leave_type_master')
->get();






         return view("super_admin_settings_view")
         ->with('roler_permissions',$roler_permissions)
         ->with('shift_master',$shift_master)
         ->with('employee_type_master',$employee_type_master)
         ->with('role_masrer',$role_masrer)
         ->with( 'users' ,$dbData)
         ->with( 'depatrment_master' ,$depatrment_master)
         ->with( 'leave_type_master' ,$leave_type_master)
         ->with('role',$role);
        }else{
          return redirect()->route('login');
        }
    }











    public function admin_settings(Request $req) {
      $EmployeesID = session()->get('EmployeeID');
      $role = session()->get('role');
      if(isset( $EmployeesID)){
        $admin_permissionData = DB::table('roler_permissions')
        ->where('role_name',$req->role_name)
        ->get();

if( $admin_permissionData){
  return view("admin_settings")
  ->with('role',$role)
  ->with('role_name',$req->role_name)
  ->with('admin_permissionData',$admin_permissionData);

}else{
  ?>
<script>
alert("Role Permission is not define");
history.back();
</script>
<?php
}
  }else{
  return redirect()->route('login');
}
  }

  public function HR_settings() {
    $EmployeesID = session()->get('EmployeeID');
    $role = session()->get('role');
    if(isset( $EmployeesID)){
     return view("HR_settings")
     ->with('role',$role);
    }else{
      return redirect()->route('login');
    }
}


public function delete_role(Request $req) {
  $EmployeesID = session()->get('EmployeeID');
  $role = session()->get('role');
  if(isset( $EmployeesID)){
if($req->id == 1){

  ?>
<script>
alert("You can not Delete Super Admin")
history.back()
</script>
<?php
  echo "You can not Delete Super Admin";
}else{

//roler_permissions
$roler_permissions_qr = DB::table('roler_permissions')

->where('role_name',$role)
->get();
$add_shift = 0;
foreach($roler_permissions_qr as $roler_p){
    $add_shift = $roler_p->Delete_Role ;

}

if($add_shift == 1){
$deleteQuri =  DB::table('role_masrer')->where('id', $req->id)->delete();
}else{
?>
<script>
alert("Not Permission")
history.back();
</script>
<?php
}






   if($deleteQuri){
    ?>
<script>
alert("data deleted")
history.back()
</script>
<?php
   }else{
    ?>
<script>
alert("data not deleted")
history.back()
</script>
<?php
    echo "data not deleted";
   }
  }
  }else{
    ?>
<script>
alert("you cant Delete")
history.back()
</script>
<?php
    echo "you cant Delete";
  }
}


public function delete_department_type(Request $req) {
  // Attempt to delete the record
  $deleteQuery = DB::table('department_master')->where('id', $req->id)->delete();

  if ($deleteQuery) {
      // Return a success JSON response
      ?>
<script>
alert("Department deleted successfully.")
history.back()
</script>
<?php

  } else {
      // Return a not found JSON response
      ?>
<script>
alert("Department not found or already deleted.")
history.back()
</script>
<?php

  }
}


public function delete_employee_type(Request $req) {
  $EmployeesID = session()->get('EmployeeID');
  $role = session()->get('role');
  if(isset( $EmployeesID)){
if($req->id == 1){
  ?>
<script>
alert("You can not Delete this Eemployee type")
history.back()
</script>
<?php
  echo "You can not Delete this Eemployee type";
}else{


 //roler_permissions



 $roler_permissions_qr = DB::table('roler_permissions')

 ->where('role_name',$role)
 ->get();
 $add_shift = 0;
 foreach($roler_permissions_qr as $roler_p){
     $add_shift = $roler_p->Delete_Employee_Type ;

 }

if($add_shift == 1){
  $deleteQuri =  DB::table('shift__employee_type_master')->where('id', $req->id)->delete();
}else{
?>
<script>
alert("Not Permission")
history.back();
</script>
<?php
}




   if($deleteQuri){
    ?>
<script>
alert("data deleted")
history.back()
</script>
<?php
   }else{
    ?>
<script>
alert("data not deleted")
history.back()
</script>
<?php
    echo "data not deleted";
   }}
  }else{
    ?>
<script>
alert("you can't Delete")
history.back()
</script>
<?php
    echo "you can't Delete";
  }
}

public function delete_shift(Request $req) {
  $EmployeesID = session()->get('EmployeeID');
  $role = session()->get('role');
  if(isset( $EmployeesID)){
if($req->id == 1){
  ?>
<script>
alert("You can not Delete this Shift")
history.back()
</script>
<?php
  echo "You can not Delete this Shift";
}else{

//roler_permissions
$roler_permissions_qr = DB::table('roler_permissions')

->where('role_name',$role)
->get();
$add_shift = 0;
foreach($roler_permissions_qr as $roler_p){
    $add_shift = $roler_p->Delete_Shift ;

}

if($add_shift == 1){
  $deleteQuri =  DB::table('shift_master')->where('id', $req->id)->delete();
}else{
?>
<script>
alert("Not Permission")
history.back();
</script>
<?php
}




   if($deleteQuri){
    ?>
<script>
alert("data deleted")
history.back()
</script>
<?php
   }else{
    ?>
<script>
alert("data not deleted")
history.back()
</script>
<?php
    echo "";
   }}
  }else{
    ?>
<script>
alert("you can't Delete")
history.back()
</script>
<?php
    echo "";
  }
}

// delet any data

public function delete_any_data(Request $req) {
  $EmployeesID = session()->get('EmployeeID');
  $role = session()->get('role');
  if(isset( $EmployeesID)){

  $deleteQuri =  DB::table($req->table_name)->where('id', $req->id)->delete();

   if($deleteQuri){
    ?>
<script>
alert("data deleted")
history.back()
</script>
<?php
   }else{
    ?>
<script>
alert("data not deleted")
history.back()
</script>
<?php
    echo "";
   }
  }else{
    ?>
<script>
alert("you can't Delete")
history.back()
</script>
<?php
    echo "";
  }
}


public function edit_employee_type(Request $req) {
  $EmployeesID = session()->get('EmployeeID');
  $role = session()->get('role');
  if(isset( $EmployeesID)){
    $emp_type_Data = DB::table('shift__employee_type_master')
    ->where('id',$req->id)
    ->get();
    return view("edit_employee_type")
    ->with('emp_type_Data',$emp_type_Data)
    ->with('role',$role);
   }else{
     return redirect()->route('login');
   }
}
public function edit_role(Request $req) {
  $EmployeesID = session()->get('EmployeeID');
  $role = session()->get('role');
  if(isset( $EmployeesID)){
    $admin_Data = DB::table('role_masrer')
    ->where('id',$req->id)
    ->get();
    return view("edit_role")
    ->with('role_data', $admin_Data)
    ->with('role',$role);
   }else{
     return redirect()->route('login');
   }
}
public function edit_shift(Request $req) {
  $EmployeesID = session()->get('EmployeeID');
  $role = session()->get('role');
  if(isset( $EmployeesID)){
    $shift_Data = DB::table('shift_master')
    ->where('id',$req->id)
    ->get();

//roler_permissions
$roler_permissions_qr = DB::table('roler_permissions')
->where('role_name',$role)
->get();
$Edit_Shift = 0;
foreach($roler_permissions_qr as $roler_p){
    $Edit_Shift = $roler_p->Edit_Shift ;

}
if($Edit_Shift == 1){


    return view("edit_shift")
    ->with('shift_data', $shift_Data )
    ->with('role',$role);
}else{
  ?>
<script>
alert("Not Permission")
history.back();
</script>
<?php
}
   }else{
     return redirect()->route('login');
   }
}
public function update_employee_type(Request $req) {
  $EmployeesID = session()->get('EmployeeID');
  $role = session()->get('role');


  if(isset( $EmployeesID)){
//roler_permissions
$roler_permissions_qr = DB::table('roler_permissions')
->where('role_name',$role)
->get();
$Edit_Shift = 0;
foreach($roler_permissions_qr as $roler_p){
    $Edit_Shift = $roler_p->Edit_Employee_Type ;

}
if($Edit_Shift == 1){



    $update_emp_tyoe = DB::table('shift__employee_type_master')
    ->where('id', $req->id)
     ->update( [
     'EmpTypeName' =>$req->emp_type,
     'Daily_Wages' =>$req->Daily_Wages,
     'Eligible_for_OverTime' => $req->Eligible_for_OverTime,
     'updated_by' =>$EmployeesID,
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


    if($update_emp_tyoe){
      ?>
<script>
alert("data updated");
history.back();
</script>
<?php
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
public function update_role(Request $req) {
  $EmployeesID = session()->get('EmployeeID');
  $role = session()->get('role');
  if(isset( $EmployeesID)){
//roler_permissions
$roler_permissions_qr = DB::table('roler_permissions')
->where('role_name',$role)
->get();
$Edit_Role = 0;
foreach($roler_permissions_qr as $roler_p){
    $Edit_Role = $roler_p->Edit_Role ;

}
if($Edit_Role == 1){

    $update_roles = DB::table('role_masrer')
    ->where('id', $req->id)
     ->update( [
     'roles' =>$req->role_inp,
     'updated_by' =>$EmployeesID,
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

    if($update_roles){
      ?>
<script>
alert("data updated");
history.back();
</script>
<?php
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
public function update_shift(Request $req) {
  $EmployeesID = session()->get('EmployeeID');
  $role = session()->get('role');
  if(isset( $EmployeesID)){
//roler_permissions
$roler_permissions_qr = DB::table('roler_permissions')
->where('role_name',$role)
->get();
$Edit_Shift = 0;
foreach($roler_permissions_qr as $roler_p){
    $Edit_Shift = $roler_p->Edit_Shift ;

}
if($Edit_Shift == 1){

    $update_shift = DB::table('shift_master')
    ->where('id', $req->id)
     ->update( [
     'Shift_Start_Time' =>$req->Shift_Start_Time,
     'Shift_End_Time' =>$req->Shift_End_Time,
     'Lunch_Start_Time' =>$req->Lunch_Start_Time,
     'Lunch_end_Time' =>$req->Lunch_end_Time,
     'Shift_Name' =>$req->Shift_Name,
     'Shift_hours' =>$req->Shift_hours,
     'updated_by' =>$EmployeesID,
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

    if( $update_shift){
      ?>
<script>
alert("data updated");
history.back();
</script>
<?php
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


}

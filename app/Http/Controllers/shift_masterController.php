<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class shift_masterController extends Controller
{
    public function add_shift(Request $req) {
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');
        if(isset( $EmployeesID)){

    //roler_permissions
    $roler_permissions_qr = DB::table('roler_permissions')
                    
    ->where('role_name',$role)
    ->get();  
    $add_shift = 0;
    foreach($roler_permissions_qr as $roler_p){
        $add_shift = $roler_p->Add_Shift ;

    }

if($add_shift == 1){
  
   if($req->Shift_Name ==""){
    ?>
<script>
alert("please Provide role data")
history.back();
</script>
<?php
   
   }else{
    try
    {
        $roleQuri=DB::table('shift_master')
        ->insertOrIgnore([
            'Shift_Name'=>$req->Shift_Name,
            'Shift_Start_Time'=>$req->Shift_Start_Time,
            'Shift_End_Time'=>$req->Shift_End_Time,
            'Lunch_Start_Time'=>$req->Lunch_Start_Timee,
            'Lunch_end_Time'=>$req->Lunch_end_Time,
            'Shift_hours'=>$req->Shift_hours,
            // 'updated_by'=>$EmployeesID,
            // 'created_by'=>$EmployeesID,
            'created_at'=>now(),
            'updated_at'=>now()

        ]);
        if($roleQuri){
            ?>
<script>
alert("Shift inserted")
history.back();
</script>
<?php
          
        }else{
            ?>
<script>
alert("Error Shift not inserted")
history.back();
</script>
<?php

           // dd($roleQuri);
            echo "Error Data not inserted";
        }
    }
    catch(Exception $e)
    {
       dd($e->getMessage());
    }
   }
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

}
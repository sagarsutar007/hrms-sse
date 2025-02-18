<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class holiday_master_controller extends Controller
{
     // add holiday
  public function  add_holiday_api(Request $req){
    $EmployeesID = session()->get('EmployeeID');
    $role = session()->get('role');
    $swipe_date =$req->swipe_date;
    if ($req->swipe_date=="") {
      $swipe_date = "0000-00-00";
    }

    $holiday_get_Data=DB::table('holiday_master')
                ->where('holiday_Date' , $req->holiday_date )
                ->get();

                $permCounr = count($holiday_get_Data);

                if($permCounr == 1){
                  $holiday_get_Data=DB::table('holiday_master')
                ->where('holiday_Date' , $req->holiday_date )
                ->update( [ 
                  'Holiday_name' => $req->holiday_name,
                 
                 ]);

                }else{
                  
  

    $users = DB::table('holiday_master')
    ->insertOrIgnore([
        'Holiday_name' => $req->holiday_name,
        'holiday_Date' => $req->holiday_date,
        'Swap_with_Date' =>$req->swipe_date,
        'Public_Holiday' =>$req->public_holiday,
        
        'created_at' => now(),
        'updated_at' => now(),

    ]);
  }

  
      $arr = array(
        'status'=>'true',
        'message' => $req->name,  
        'all_users'=>'',
        'role'=> $role
         ); 
      echo json_encode($arr);
   
 
  }
}
// {holiday_name}/{holiday_date}/{swipe_date}/{public_holiday}
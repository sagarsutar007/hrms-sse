<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class EmployeeController extends Controller
{
 public function view_employee()
    {
        $role = session()->get('role');
        $users = DB::table('all_users')
        ->join('shift_master', 'shift_master.id', '=', 'all_users.shift_time')
        ->join('role_masrer', 'role_masrer.id', '=', 'all_users.Role')
        ->join('shift__employee_type_master', 'shift__employee_type_master.id', '=', 'all_users.employee_type')
        ->select('all_users.*', 'role_masrer.roles', 'shift_master.Shift_Name' ,'shift__employee_type_master.EmpTypeName')
        ->paginate(10);
        return view('employees')
        ->with('role',$role)
        ->with('r',1)
        ->with('users',$users);
    }


    public function view_swipe_users()
    {
        $role = session()->get('role');
        $users = DB::table('all_users')
        ->join('shift_master', 'shift_master.id', '=', 'all_users.shift_time')
        ->join('role_masrer', 'role_masrer.id', '=', 'all_users.Role')
        ->join('shift__employee_type_master', 'shift__employee_type_master.id', '=', 'all_users.employee_type')
        ->select('all_users.*', 'role_masrer.roles', 'shift_master.Shift_Name' ,'shift__employee_type_master.EmpTypeName')
        ->paginate(10);
        return view('swipe_date_list')
        ->with('role',$role)
        ->with('r',1)
        ->with('users',$users);
    }


    
    public function calendar()
    {
        $role = session()->get('role');
        if (isset($role)) {
            return view('calander')
            ->with('role',$role)
            ->with('r',1);
           
        }
        
        
    }



    public function view_details(Request $view_req){

$view_id = $view_req->id;
if (isset($view_id)) {
    $role = session()->get('role');
    $users = DB::table('all_users')
    ->join('shift_master', 'shift_master.id', '=', 'all_users.shift_time')
    ->join('role_masrer','role_masrer.id', '=', 'all_users.Role')
    ->join('shift__employee_type_master', 'shift__employee_type_master.id', '=', 'all_users.employee_type')
        ->select('all_users.*', 'role_masrer.roles', 'shift_master.Shift_Name' ,'shift__employee_type_master.EmpTypeName')
    ->where('all_users.id',$view_id  )
    ->get();
    return view('view_details')
    ->with('role',$role)
    ->with('users',$users);
}else{
    ?>
<script>
alert("Please Set Id");
history.back();
</script>
<?php
}


        
    }

    public function search_employee(Request $setch_req){
       $inputSValue =  $setch_req->search_val;
       $role = session()->get('role');
if(isset($inputSValue)){
    $users = DB::table('all_users')
    ->join('shift_master', 'shift_master.id', '=', 'all_users.shift_time')
    ->join('role_masrer', 'role_masrer.id', '=', 'all_users.Role')
    ->join('shift__employee_type_master', 'shift__employee_type_master.id', '=', 'all_users.employee_type')
        ->select('all_users.*', 'role_masrer.roles', 'shift_master.Shift_Name' ,'shift__employee_type_master.EmpTypeName')
    ->whereAny([
        'all_users.id','all_users.f_name','all_users.m_name','all_users.l_name','all_users.email',
        'all_users.Employee_id','all_users.mobile_number','all_users.aadhaar_number','all_users.pan_number',
        'all_users.dob','all_users.shift_time','all_users.employee_type','all_users.role',
    ], 'like', '%'. $inputSValue.'%')
   ->paginate(10);

    $usersCount = count($users);
    if($usersCount  == 1){
       
        return view('employees')
        ->with('role',$role)
        ->with('users',$users);
        
    }else{

       ?>
<script>
alert("No Record Found");
history.back();
</script>
<?php
    }
    
}    

    }
public function delete_employee(Request $delete_req){
$ids = $delete_req->ids;

 foreach ($ids as $id) {
    DB::table('all_users')->where('id', $id)->delete();
}
return response()->json(['success'=>'Data Deleted']);
    }

    public function add_holiday(Request $delete_req){
        $ids = $delete_req->ids;
        $created_by = session()->get('EmployeeID');
        $swap_date =  $delete_req->swap_date;
        if($swap_date == ''){
            $swap_date = '0000-00-00';
        }else{
            $swap_date = $delete_req->swap_date;
        }
        $Public_Holiday =  $delete_req->Public_Holiday;
        $message_inpu =  $delete_req->message_inpu;
        if($message_inpu == ''){
            $message_inpu = ' ';
        }else{
            $message_inpu = $delete_req->message_inpu;
        }

         foreach ($ids as $id) {

            $get_holiday = DB::table('All_Holiday')
            ->where('Employee_id',  $id )
            ->where('Holiday_Date',  $delete_req->holiday_date )
            ->get()
            ->toArray();
            $permCounr = count($get_holiday);
            
            if($permCounr == 1){
                $update_emp_tyoe = DB::table('All_Holiday') 
                ->where('Employee_id', $id) 
                 ->update( [ 
                    'Swap_Date' =>  $swap_date,
                    
                
                ]);
            }else{
                $users = DB::table('All_Holiday')
                ->insertOrIgnore([
                    'Employee_id' => $id,
                    'Holiday_Date' => $delete_req->holiday_date,
                    'Swap_Date' =>  $swap_date,
                    'Public_Holiday' => $Public_Holiday ,
                    'Message' => $message_inpu ,
                    'created_by' => $created_by ,
                    'updated_by' => $created_by ,
                ]);
            
            }

            
               



          




            
        }
        return response()->json(['success'=>'Holiday Added']);
            }


    



    public function set_limit(Request $limit_req){
              if(isset($limit_req->limit_num))  {
                $role = session()->get('role');
                $users = DB::table('all_users')
                ->join('shift_master', 'shift_master.id', '=', 'all_users.shift_time')
                ->join('role_masrer', 'role_masrer.id', '=', 'all_users.Role')
                ->join('shift__employee_type_master', 'shift__employee_type_master.id', '=', 'all_users.employee_type')
        ->select('all_users.*', 'role_masrer.roles', 'shift_master.Shift_Name' ,'shift__employee_type_master.EmpTypeName')
                ->paginate($limit_req->limit_num, $pageName = 'users')
                ->appends(['limit' => $limit_req->limit_num]);
              
                
                return view('employees')
                ->with('role',$role)
                ->with('users',$users);
              }else{
                $role = session()->get('role');
                $users = DB::table('all_users')
                ->join('shift_master', 'shift_master.id', '=', 'all_users.shift_time')
                ->join('role_masrer', 'role_masrer.id', '=', 'all_users.Role')
                ->join('shift__employee_type_master', 'shift__employee_type_master.id', '=', 'all_users.employee_type')
        ->select('all_users.*', 'role_masrer.roles', 'shift_master.Shift_Name' ,'shift__employee_type_master.EmpTypeName')
                ->paginate($limit_req->limit)
                ->appends(['limit' => $limit_req->limit]);
              
                
                return view('employees')
                ->with('role',$role)
                ->with('users',$users);
              }
                
      
            }


            

            public function all_employees_api(Request $req)
            {
                $role = session()->get('role');
                $users = DB::table('all_users')
                ->join('shift_master', 'shift_master.id', '=', 'all_users.shift_time')
                ->join('role_masrer', 'role_masrer.id', '=', 'all_users.Role')
                ->join('department_master', 'department_master.id', '=', 'all_users.Department')
                ->join('shift__employee_type_master', 'shift__employee_type_master.id', '=', 'all_users.employee_type')
                ->select('all_users.*', 'role_masrer.roles', 'shift_master.Shift_Name' ,'shift__employee_type_master.EmpTypeName','department_master.Department_name')
                ->paginate($req->limit);
                
                $arr = array(
                    'status'=>'true',
                    'message' => 'data Found',  
                    'all_users'=> $users,
                    'role'=> $role
                     ); 
                  echo json_encode($arr);
               
            }


            

            public function show_all_employees_api()
            {
                $role = session()->get('role');
                $number = DB::table('all_users')
                ->get()
                ->toArray();
                $permCounr = count($number);


                $users = DB::table('all_users')
                ->join('shift_master', 'shift_master.id', '=', 'all_users.shift_time')
                ->join('role_masrer', 'role_masrer.id', '=', 'all_users.Role')
                ->join('department_master', 'department_master.id', '=', 'all_users.Department')
                ->join('shift__employee_type_master', 'shift__employee_type_master.id', '=', 'all_users.employee_type')
                ->select('all_users.*', 'role_masrer.roles', 'shift_master.Shift_Name' ,'shift__employee_type_master.EmpTypeName','department_master.Department_name')
                ->paginate($permCounr);
                
                $arr = array(
                    'status'=>'true',
                    'message' => 'data Found',  
                    'all_users'=> $users,
                    'role'=> $role
                     ); 
                  echo json_encode($arr);
               
            }



            public function show_all_employees_weeak_off_day_api(Request $req){
                $role = session()->get('role');
                $number = DB::table('all_users')
                ->where('Weekly_Off',  $req->weak_off_day )
                ->get()
                ->toArray();
                $permCounr = count($number);

                if($permCounr > 0){
                    $users = DB::table('all_users')
                    ->join('shift_master', 'shift_master.id', '=', 'all_users.shift_time')
                    ->join('role_masrer', 'role_masrer.id', '=', 'all_users.Role')
                    ->join('department_master', 'department_master.id', '=', 'all_users.Department')
                    ->join('shift__employee_type_master', 'shift__employee_type_master.id', '=', 'all_users.employee_type')
                    ->select('all_users.*', 'role_masrer.roles', 'shift_master.Shift_Name' ,'shift__employee_type_master.EmpTypeName','department_master.Department_name')
                    ->where('Weekly_Off',  $req->weak_off_day )
                    ->paginate($permCounr);
                    
                    $arr = array(
                        'status'=>'true',
                        'message' => 'data Found',  
                        'all_users'=> $users,
                        'role'=> $role
                         ); 
                }else{
                    $arr = array(
                        'status'=>'false',
                        'message' => 'data not Found',  
                        'all_users'=> '',
                        'role'=> $role
                         ); 
                }


             
                  echo json_encode($arr);
            }

            
            public function all_employees_short_api(Request $req)
            {
                $role = session()->get('role');
                $users = DB::table('all_users')
                ->join('shift_master', 'shift_master.id', '=', 'all_users.shift_time')
                ->join('role_masrer', 'role_masrer.id', '=', 'all_users.Role')
                ->join('department_master', 'department_master.id', '=', 'all_users.Department')
                ->join('shift__employee_type_master', 'shift__employee_type_master.id', '=', 'all_users.employee_type')
                ->select('all_users.*', 'role_masrer.roles', 'shift_master.Shift_Name' ,'shift__employee_type_master.EmpTypeName','department_master.Department_name')
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

            

            public function all_employees_search_api(Request $req)
            
            {
                $search_by_inp = $req->search_inp;
                $role = session()->get('role');
                $users = DB::table('all_users')
                ->join('shift_master', 'shift_master.id', '=', 'all_users.shift_time')
                ->join('role_masrer', 'role_masrer.id', '=', 'all_users.Role')
                ->join('department_master', 'department_master.id', '=', 'all_users.Department')
                ->join('shift__employee_type_master', 'shift__employee_type_master.id', '=', 'all_users.employee_type')
                ->select('all_users.*', 'role_masrer.roles', 'shift_master.Shift_Name' ,'shift__employee_type_master.EmpTypeName','department_master.Department_name')

                ->whereAny([
                    'f_name',
                    'l_name',
                    'm_name',
                    'Employee_id',
                    'email',
                    'mobile_number',
                    'current_address',
                    'voter_id_number',
                    'aadhaar_number',
                    'DOJ',
                    'department_master.Department_name',
                    'shift__employee_type_master.EmpTypeName',
                    'shift_master.Shift_Name',
                    'role_masrer.roles',
                    'pan_number',
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


            
            public function search_when_holiday_selected(Request $req)
            {

                $number = DB::table('all_users')
                ->get()
                ->toArray();
                $permCounr = count($number);

                $search_by_inp = $req->search_inp;
                $role = session()->get('role');
                $users = DB::table('all_users')
                ->join('shift_master', 'shift_master.id', '=', 'all_users.shift_time')
                ->join('role_masrer', 'role_masrer.id', '=', 'all_users.Role')
                ->join('department_master', 'department_master.id', '=', 'all_users.Department')
                ->join('shift__employee_type_master', 'shift__employee_type_master.id', '=', 'all_users.employee_type')
                ->select('all_users.*', 'role_masrer.roles', 'shift_master.Shift_Name' ,'shift__employee_type_master.EmpTypeName','department_master.Department_name')
                ->where('Weekly_Off',  $req->select_date_day )
                ->whereAny([
                    'f_name',
                    'l_name',
                    'm_name',
                    'Employee_id',
                    'email',
                    'department_master.Department_name',
                    'shift__employee_type_master.EmpTypeName',
                    'shift_master.Shift_Name',
                    'role_masrer.roles',
                    'mobile_number',
                    'current_address',
                    'voter_id_number',
                    'aadhaar_number',
                    'DOJ',
                    'pan_number',
                ], 'like', '%'.$search_by_inp.'%')
                ->paginate( $permCounr);
                
                $arr = array(
                    'status'=>'true',
                    'message' => 'data Found',  
                    'all_users'=> $users,
                    'role'=> $role
                     ); 
                  echo json_encode($arr);
               
            }


            public function all_employees_search_wid_limit_api(Request $req)
            {

                $number = DB::table('all_users')
                ->get()
                ->toArray();
                $permCounr = count($number);

                $search_by_inp = $req->search_inp;
                $role = session()->get('role');
                $users = DB::table('all_users')
                ->join('shift_master', 'shift_master.id', '=', 'all_users.shift_time')
                ->join('role_masrer', 'role_masrer.id', '=', 'all_users.Role')
                ->join('department_master', 'department_master.id', '=', 'all_users.Department')
                ->join('shift__employee_type_master', 'shift__employee_type_master.id', '=', 'all_users.employee_type')
                ->select('all_users.*', 'role_masrer.roles', 'shift_master.Shift_Name' ,'shift__employee_type_master.EmpTypeName','department_master.Department_name')
                ->whereAny([
                    'f_name',
                    'l_name',
                    'm_name',
                    'Employee_id',
                    'email',
                    'department_master.Department_name',
                    'shift__employee_type_master.EmpTypeName',
                    'shift_master.Shift_Name',
                    'role_masrer.roles',
                    'mobile_number',
                    'current_address',
                    'voter_id_number',
                    'aadhaar_number',
                    'DOJ',
                    'pan_number',
                ], 'like', '%'.$search_by_inp.'%')
                ->paginate( $permCounr);
                
                $arr = array(
                    'status'=>'true',
                    'message' => 'data Found',  
                    'all_users'=> $users,
                    'role'=> $role
                     ); 
                  echo json_encode($arr);
               
            }
            public function  update_col_visibility(Request $request){
                $page_name = $request->page_name;
                $col_number = $request->col_number;
                $col_value = $request->col_value;
                $Employee_id = session()->get('EmployeeID');
if(isset($page_name) && isset($col_number) && isset($col_value) && isset($Employee_id)  ){
    $update_col_visibility = DB::table('column_visibility') 
    ->where('Employee_id',  $Employee_id)
    ->where('page_name',  $page_name)
     ->update( [ 
        $col_number =>$col_value,
             
     ]);

    if($update_col_visibility){
        $arr = array(
            'status'=>'true',
            'message' => 'data updated',   
            
             ); 
          echo json_encode($arr);
    }else{
        $arr = array(
            'status'=>'true',
            'message' => 'data not updated',   
            
             ); 
          echo json_encode($arr);
        }
}

  }
           

          
           public function col_visibility(Request $request){
            $role = session()->get('role');
            $page_name = $request->page_name;
            $Employee_id = session()->get('EmployeeID');
            if(isset($Employee_id) && isset($page_name) ){

                $col_visibility_data = DB::table('column_visibility')
                ->where('Employee_id',  $Employee_id)
                ->where('page_name',  $page_name)
                ->get()
                ->toArray();

                if (isset($col_visibility_data)){

                    $permCounr = count($col_visibility_data);

                    if($permCounr == 1){
                        $arr = array(
                            'status'=>'true',
                            'message' => 'data Found',   
                            'data' => $col_visibility_data,   
                             ); 
                          echo json_encode($arr);
                    }else{
                        $add_col_visibility=DB::table('column_visibility')
                        ->insertOrIgnore([
                            'Employee_id'=>session()->get('EmployeeID'), 
                            'page_name'=>$page_name, 
                            'col1'=>2, 
                            'col2'=>2, 
                            'col3'=>2, 
                            'col4'=>2, 
                            'col5'=>2, 
                            'col7'=>2, 
                            'col8'=>1, 
                            'col9'=>1, 
                            'col10'=>1, 
                            'col11'=>1, 
                            'col12'=>1, 
                            'col13'=>1, 
                            'col14'=>1, 
                            'col15'=>1, 
                            'col16'=>1, 
                            'col17'=>1, 
                            'col18'=>1, 
                            'col19'=>1, 
                            'col20'=>1, 
                            'created_at'=>now(),
                            'updated_at'=>now()
                     
                        ]);
                        $col_visibility_data = DB::table('column_visibility')
                        ->where('Employee_id', session()->get('EmployeeID'))
                        ->where('page_name',  $page_name)
                        ->get()
                        ->toArray(); 
                        $arr = array(
                            'status'=>'true',
                            'message' => 'data Found',   
                            'data' => $col_visibility_data,   
                            'data2' => $add_col_visibility,   
                             ); 
                          echo json_encode($arr); 
                    }


                    
                }else{
                    $arr = array(
                        'status'=>'true',
                        'message' => 'data Found',   
                        'data' => "2",   
                         ); 
                      echo json_encode($arr);
                }

               
               
            }else{
                $arr = array(
                    'status'=>'False',
                    'message' => 'You Cant Assec this',  
                   
                     ); 
                  echo json_encode($arr);
                
            }
        }
            


    
}
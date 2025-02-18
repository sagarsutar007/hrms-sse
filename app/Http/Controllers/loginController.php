<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class loginController extends Controller
{
    public function login_view(Request $req) {
        $Attendance_id = $req->Attendance_id;
        if(isset($Attendance_id )){
            $EmployeesID = session()->get('EmployeeID');
            $role = session()->get('role');
            if(isset($EmployeesID) && isset($role)){



                $user_permissionsData=DB::table('user_permissions')
                ->select('user_permissions.Add_Attendance')
                ->where('Employee_id' ,  $EmployeesID )
                ->get()
                ->toArray();
                if($user_permissionsData){

                    $permCounr = count($user_permissionsData);

                    if($permCounr == 1){
                        foreach($user_permissionsData as $user_p){

                            $cant_add_attendence =$user_p->Add_Attendance ;

                            if( $cant_add_attendence == 1){
                                $return = url("/")."/push-attendance/". $Attendance_id."/1" ;
                                return redirect($return) ;
                            }else{
                                $arr = array(
                                    'result' => "You are not allowed to mark attendance ",
                                  );

                                  echo json_encode($arr);
                            }

                        }


                    }else{
                        $arr = array(
                            'result' => " Oops, something went wrong ",
                          );

                          echo json_encode($arr);
                    }


                }else{
                    $arr = array(
                        'result' => " You Can't Punch Attendance " .   $EmployeesID,
                      );

                      echo json_encode($arr);
                }


                // if($role == "Guard"){
                //    $return = url("/")."/push-attendance/". $Attendance_id."/1" ;
                //     return  $return;
                // }else{
                //     $arr = array(
                //         'result' => " You can't punch Attendance as a gard ",
                //       );

                //       echo json_encode($arr);
                // }

               }else{
                return redirect()->route('login');

                $arr = array(
                    'result' =>"You can't punch Attendance Please Login ",
                  );

                  echo json_encode($arr);
               }



        }else{
            return view("login");
        }




    }
    public function login_req(Request $login_req) {
        $email = $login_req->email;
        $Password = $login_req->Password;

        if (isset($email) && isset($Password)) {
            $guserData = DB::table('users')
            ->join('role_masrer', 'users.role', '=', 'role_masrer.id')
            ->select('users.*', 'role_masrer.roles')
            ->where('users.email', '=', $email)
            ->first();

            if($guserData){
                if($guserData->password == $Password){
                    // Login success: Set session data
                 $name = $guserData->f_name . " " . $guserData->m_name . " " . $guserData->l_name;
                 $EmployeesID = $guserData->Employee_id;
               $role = $guserData->roles;
               $role_number = $guserData->role;

                $login_req->session()->put('EmployeeID', $EmployeesID);
                $login_req->session()->put('name', $name);
                $login_req->session()->put('role', $role);
                $login_req->session()->put('role_number', $role_number);

                if($role == "Guard"){
                    return view('guard_view');
                }else{
                    return redirect()->route('dashboard');
                }




                }else{
                    echo "<script>
                    alert('Wrong Password');
                    history.back();
                </script>";
                }



            }else{
                echo "<script>
            alert('User Not Found');
            history.back();
        </script>";
            }
        }else{
            echo "<script>
            alert('Please Fill Fields');
            history.back();
        </script>";
        }





    }

    public function login_reqwww(Request $login_req) {


        try {
            $email = $login_req->email;
            $Password = $login_req->Password;
            if (isset($email) && isset($Password)) {
                $guserData = DB::table('users')
                ->join('role_masrer', 'users.role', '=', 'role_masrer.id')
                ->select('users.*', 'role_masrer.roles')
                ->where('users.email', '=', $email)
                ->first();
                if ($guserData) {
                     // Check if the password matches
                if ($guserData->password !== $Password) {
                    echo "<script>
                        alert('Wrong Password');
                        history.back();
                    </script>";
                    return;
                }

                // Check if the user has permission to log in
                if ($guserData->can_login != 1) {
                    echo "<script>
                        alert('You don\\'t have login permission');
                        history.back();
                    </script>";
                    return;
                }

                // Login success: Set session data
                $name = $guserData->f_name . " " . $guserData->m_name . " " . $guserData->l_name;
                $EmployeesID = $guserData->Employee_id;
                $role = $guserData->roles;
                $role_number = $guserData->role;

                $login_req->session()->put('EmployeeID', $EmployeesID);
                $login_req->session()->put('name', $name);
                $login_req->session()->put('role', $role);
                $login_req->session()->put('role_number', $role_number);

                return redirect()->route('dashboard')
                    ->with('success', 'Login successful!');



                }else {
                    // Email not found
                    echo "<script>
                        alert('User Not Found');
                        history.back();
                    </script>";
                    return;
                }





            }else {
                echo "<script>
                    alert('Please fill in all fields');
                    history.back();
                </script>";
            }



    } catch (\Exception $e) {

    }

    ///try




//         $email=  $login_req->email;
//         $Password=  $login_req->Password;
//         $remberme=  $login_req->remberme;
//         if(isset($email ) && isset($Password)){


//             $guserData=DB::table('all_users')
//             ->join('role_masrer', 'all_users.role', '=', 'role_masrer.id')
//             ->select('all_users.*', 'role_masrer.roles')
//             ->orWhere([['all_users.password','=',$Password] ,['all_users.email','=',$email],['can_login','=',1]])
//             ->get()
//             ->toArray();
//             if(isset($guserData)){
//                 $userCount = count($guserData);

//                 if($userCount == 1){
//                     foreach($guserData as $user){


//                     $name =$user-> f_name ." " .$user-> m_name . " " . $user-> l_name  ;
//                     $EmployeesID =$user->Employee_id ;
//                     $role =$user->roles ;
//                     $role_number =$user->role ;
//                      $login_req->session()->put('EmployeeID', $EmployeesID);
//                      $login_req->session()->put('name', $name);
//                      $login_req->session()->put('role', $role);
//                      $login_req->session()->put('role_number', $role_number);
//                     $dbData =array("EmployeesID"=>$EmployeesID, "name"=>$name );

//                     return redirect()->route('dashboard')
//                     ->with( 'Apidata' ,$dbData);
//                     }
//                 }else{
//                     ?>
// <script>
// alert("User Not Found")
// history.back()
//
</script>
// <?php
//                     }
//             }else{
//                 ?>
// <script>
// alert("User Not Found")
// history.back()
//
</script>
// <?php
//                 }






//         }else{
//             ?>
// <script>
// alert("please Fill all fields")
// history.back()
//
</script>
// <?php
//             }


   }


   public function logout(Request $reqLogout){

    $reqLogout->session()->flush();
    return redirect()->route('login');
  }

}

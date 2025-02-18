<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class forgot_password_controller extends Controller
{
    public function forgot_password_view(Request $request){
        return view("forgot_password");
    }
    public function change_Password_view(Request $request){
        $Employee_id = $request->Employee_id;
        if (isset( $Employee_id)) {
            return view("change_password_view")
            ->with('Employee_id',$Employee_id);
        }else{
            ?>
<script>
alert("You Cant Forgot Your Password")
history.back()
</script>
<?php   
        }
       
    }

    public function change_Password_with_link(Request $req) {
      
        $Password = $req->Password;
        $CPassword =  $req->Password == $req->CPassword;
        $Employee_Id = $req->Employee_Id;
        if(isset($Password) && isset($CPassword) && isset($Employee_Id)){

     if ($CPassword == $Password) {
       
     
    $change_password = DB::table('all_users') 
    ->where('Employee_id', $req->Employee_Id) 
     ->update( [ 
     'password' => $req->Password, 
     'updated_at' => now(), 
    ]); 



    if($change_password){
        ?>
<script>
alert("Your Password has been changed successfully.")
</script>
<?php
return view("login");
      }else{
        ?>
<script>
alert("Your Password Not Change")
history.back();
</script>
<?php
      }
    }else{
        ?>
<script>
alert("Password And Comfirm Password are not same")
history.back();
</script>
<?php   
    }

    }else {
        ?>
<script>
alert("Please Provide All Data")
history.back();
</script>
<?php     
    }
      

    }






    public function forgot_password(Request $req)
    {
    
     $email_id = $req->email;
     if(isset($email_id)){
           
        $userData=DB::table('all_users')
      ->where('email',$email_id )
      ->get()
      ->toArray();
      if(isset($userData )){
        $Employee_id = '';
        
        foreach ($userData as $userData) {
            $Employee_id = $userData->Employee_id;
        }

       $change_password_url =   url("change-Password/" .$Employee_id );
       $to =  $email_id; // Recipient's email address
       $subject = "Password Reset Mail";
       $message = "Your Forgot Password Link Is : ".$change_password_url.", Click On Link And Change Your Password!";
       $headers = "From: info@shrisaielectricals.com\r\n"; // Sender's email address
       if (mail($to, $subject, $message, $headers)) {
       ?>
<script>
alert("Link has been sent to your Email");
history.back();
</script>
<?php
       } else {
       ?>
<script>
alert("Link Not Genrated Try After Some Time");
history.back();
</script>
<?php
       }
      
      }else{
        ?>
<script>
alert("This Email Is Not Register")
history.back()
</script>
<?php
     
      }
          
           


     }else{
        ?>
<script>
alert("please Provide All Data")
history.back()
</script>
<?php




      
     }

    }
}
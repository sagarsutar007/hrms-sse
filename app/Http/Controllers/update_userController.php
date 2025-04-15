<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class update_userController extends Controller
{

    public function update_basic_info(Request $update_req)
{
    $updated_by = session()->get('EmployeeID');

    // Validate the gender before saving it
    $gender = in_array($update_req->Gender, ['Male', 'Female', 'Other']) ? $update_req->Gender : null;


    $update_data = [
        'f_name' => $update_req->First_Name ?? '',
        'l_name' => $update_req->Last_Name ?? '',
        'email' => $update_req->Email ?? '',
        'mobile_number' => $update_req->Phone ?? '',
        'pan_number' => $update_req->PAN_Number ?? '',
        'dob' => $update_req->DOB ?? null,
        'current_address' => $update_req->Current_Address ?? '',
        'permanent_address' => $update_req->Parment_Addtess ?? '',
        'aadhaar_number' => $update_req->Aadhar_Number ?? '',
        'voter_id_number' => $update_req->Voter_id_Number ?? '',
        'gender' => $gender,
        'ration_card_number' => $update_req->Ration_Card_Number ?? '',
        'salary' => $update_req->Salary ?? '',
        'shift_time' => $update_req->Shift_Number ?? '',
        'employee_type' => $update_req->Employee_Type ?? '',
        'termination_date' => $update_req->termination_date ?: null,
        'reason_of_termination' => $update_req->reason_of_termination ?: null,
        'updated_at' => now(),
    ];

    $update_basic_info = DB::table('all_users')
        ->where('Employee_id', $update_req->Employee_Id)
        ->update($update_data);

    if ($update_basic_info) {
        return redirect()->route('view_employee')->with('success', 'Data Updated Successfully');
    } else {
        return redirect()->route('view_employee')->with('error', 'Failed to update data');
    }
}


//    edit_emergency_contact

    public function  edit_emergency_contact(Request $update_req) {
        $updated_by =  session()->get('EmployeeID') ;
        $update_basic_info = DB::table('_emergency__contacts')
        ->where('Employee_id', $update_req->Employee_Id)
         ->update( [
         'Relation' => $update_req->Relation,
         'Email' => $update_req->Email,
         'Name' => $update_req->Name,
         'Address' => $update_req->Address,
         'mobile' => $update_req->mobile,
         'updated_by' => $updated_by,
         'updated_at' => now(),
        ]);
        if($update_basic_info){
            ?>
<script>
alert("Data Updated Successfully")
history.back();
</script>
<?php
                  }else{
                ?>
<script>
alert("faield")
history.back()
</script>
<?php
        }
    }

    //update_Social_Profile
    public function  update_Social_Profile(Request $update_req) {
        $updated_by = session()->get('EmployeeID');
        $update_basic_info = DB::table('_social__profile')
        ->where('Employee_id', $update_req->Employee_Id)
         ->update( [
         'Facebook_Profile' => $update_req->Facebook,
         'LinkedIn_Profile' => $update_req->LinkedIn,
         'Twitter_Profile' => $update_req->Twitter,
         'Whats_App_Profile' => $update_req->WhatsApp,
         'updated_by' => $updated_by,
         'updated_at' => now(),
        ]);
        if($update_basic_info){

            ?>
<script>
alert("Data Updated Successfully")
history.back();
</script>
<?php
      }else{
    ?>
<script>
alert("faield")
history.back()
</script>
<?php
      }

    }

    //update_document
     public function  update_document(Request $update_req) {
        $updated_by = session()->get('EmployeeID');

        $file = $update_req->file('Front_path');
        $update_req->validate([
            'Front_path' => 'required|mimes:jpg,png,pdf|max:3072',
        ]);
        $path =  $update_req->file('Front_path')->store('file_fronte', 'public');

  if($update_req->file('Back_path')){
    $file = $update_req->file('Back_path');
    $update_req->validate([
        'Back_path' => 'required|mimes:jpg,png,pdf|max:3072',
    ]);
    $path2 =  $update_req->file('Back_path')->store('file_back', 'public');

  }else{
    $path2 =  "";
  }



       $update_basic_info = DB::table('all__document')
        ->where('Employee_id', $update_req->Employee_Id)
         ->update( [
         'Document_Type' => $update_req->Document_Type,
         'Title' => $update_req->Title,
         'Expired_Date' => $update_req->Expired_Date,
         'Description' => $update_req->Description,
         'Document_path' => $path ,
         'Document_path_back' => $path2 ,
         'updated_by' => $updated_by,
         'updated_at' => now(),
        ]);
        if($update_basic_info){

                ?>
<script>
alert("Data Updated Success")
history.back();
</script>
<?php
          }else{
        ?>
<script>
alert("Data Not Updated ")
history.back()
</script>
<?php
          }
    }


    //edit-qualifications
    public function  update_qualifications(Request $update_req) {
        $updated_by = session()->get('EmployeeID');
        $update_basic_info = DB::table('_qualifications')
        ->where('Employee_id', $update_req->Employee_Id)
         ->update( [
         'School_University' => $update_req->School_University,
         'Education_Level' => $update_req->Education_Level,
         'From' => $update_req->From,
         'Description' => $update_req->Description,
         'to' => $update_req->to,
         'Language' => $update_req->Language,
         'Professional_Skills' => $update_req->Professional_Skills,
         'updated_by' => $updated_by,
         'updated_at' => now(),
        ]);
        if($update_basic_info){

                ?>
<script>
alert("Data Updated Success")
history.back();
</script>
<?php
          }else{
        ?>
<script>
alert("Data Not Updated faield")
history.back()
</script>
<?php
          }
    }

    //update_Work_Experience
    public function  update_Work_Experience(Request $update_req) {
        $updated_by = session()->get('EmployeeID');
        $update_basic_info = DB::table('_work__experience')
        ->where('Employee_id', $update_req->Employee_Id)
         ->update( [
         'Company' => $update_req->Company_Name,
         'Pos' => $update_req->Post,
         'From' => $update_req->From,
         'Description' => $update_req->Description,
         'to' => $update_req->to,
         'updated_by' => $updated_by,
         'updated_at' => now(),
        ]);
        if($update_basic_info){

            ?>
<script>
alert("Data uploaded successfully!")
history.back();
</script>
<?php
      }else{
        ?>
<script>
alert("Data not uploaded Faield!")
history.back()
</script>
<?php
          }
    }
    public function update_bank_account(Request $update_req)
    {
        // Update the bank account information
        $update_basic_info = DB::table('accounts')
            ->where('id', $update_req->bank_account_input_id)
            ->update([
                'Account_Holder_Name' => $update_req->Holder_Name,
                'Bank_Name' => $update_req->Bank_Name,
                'Account_Number' => $update_req->Account_Number,
                'IFSC_Code' => $update_req->IFSC_Code,
                'updated_at' => now(),
            ]);

        // Return JSON response
        if ($update_basic_info) {
            return response()->json([
                'success' => true,
                'message' => 'Bank account updated successfully!',
            ], 200); // HTTP 200 OK
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update the bank account.',
            ], 500); // HTTP 500 Internal Server Error
        }
    }





    public function  uploade_test_image_view() {

      $images = Storage::files('public/images'); // Get all images in the directory
      $imageUrls = array_map(fn($path) => storage::url($path), $images);

      return view('uploade_test', compact('imageUrls'));



    }
    public function  uploade_test_image(Request $request) {
      $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Store the image in 'public/images'
    $imagePath = $request->file('image')->store('images', 'public');

    return back()->with('success', 'Image uploaded successfully!')->with('imagePath', $imagePath);

    }
    public function update_Profile_image(Request $update_req)
    {
        $updated_by = session()->get('EmployeeID');

        $file = $update_req->file('Front_path');
        $file_name = $file->getClientOriginalName();
        $update_req->validate([
            'Front_path' => 'required|mimes:jpg,png|max:3072', // Validate image types
        ]);

        // Save the original image
        $originalPath = $update_req->file('Front_path')->move(public_path('/storage/profile_image'), $file_name);
        $full_path = "/storage/profile_image/" . $file_name;

        // Generate thumbnail
        $thumbnailName = 'thumbnail_' . $file_name;
        $thumbnailPath = public_path('/storage/profile_image/' . $thumbnailName);
        $this->createThumbnail($originalPath, $thumbnailPath, 200); // Thumbnail with a width of 200px

        // Update the database
        $update_basic_info = DB::table('all_users')
            ->where('Employee_id', $update_req->Employee_Id)
            ->update([
                'photo_name' => '/profile_image/' . $thumbnailName, // Save thumbnail path
                'updated_at' => now(),
            ]);

        if ($update_basic_info) {
            return back()->with('success', 'File uploaded and thumbnail created successfully!');
        } else {
            return back()->with('error', 'Failed to upload the file!');
        }
    }

    /**
     * Create a simple thumbnail without any external library.
     *
     * @param string $sourcePath Full path of the original image.
     * @param string $destinationPath Full path to save the thumbnail.
     * @param int $thumbWidth Desired thumbnail width (height will adjust proportionally).
     */
    private function createThumbnail($sourcePath, $destinationPath, $thumbWidth)
    {
        // Get original image dimensions and type
        list($originalWidth, $originalHeight, $imageType) = getimagesize($sourcePath);

        // Load the image based on its type
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $sourceImage = imagecreatefromjpeg($sourcePath);
                break;
            case IMAGETYPE_PNG:
                $sourceImage = imagecreatefrompng($sourcePath);
                break;
            default:
                throw new Exception("Unsupported image type.");
        }

        // Calculate the new height maintaining the aspect ratio
        $aspectRatio = $originalHeight / $originalWidth;
        $thumbHeight = $thumbWidth * $aspectRatio;

        // Create a blank canvas for the thumbnail
        $thumbnail = imagecreatetruecolor($thumbWidth, $thumbHeight);

        // Resize the original image into the thumbnail
        imagecopyresampled(
            $thumbnail,
            $sourceImage,
            0,
            0,
            0,
            0,
            $thumbWidth,
            $thumbHeight,
            $originalWidth,
            $originalHeight
        );

        // Save the thumbnail
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                imagejpeg($thumbnail, $destinationPath, 90); // 90 is the quality
                break;
            case IMAGETYPE_PNG:
                imagepng($thumbnail, $destinationPath);
                break;
        }

        // Free up memory
        imagedestroy($sourceImage);
        imagedestroy($thumbnail);
    }


 //alloweance_update
 public function  alloweance_update(Request $update_req) {
  $updated_by = session()->get('EmployeeID');

if(isset($updated_by)){
  $update_basic_salary = DB::table('alloweance')
  ->where('Employee_id', $update_req->Employee_Id)
  ->where('id', $update_req->Id)
   ->update( [
   'month' =>$update_req->Month,
   'year' =>$update_req->Year,
   'Alloweance_Titel' =>$update_req->Alloweance_Titel,
   'Allowance_Ammount_in_INR' =>$update_req->Allowance_Ammount_in_INR,
   'updated_by' => $updated_by,
   'updated_at' => now(),
  ]);
}else{
  ?>
<script>
alert("please login")
history.back()
</script>
<?php
}


  if($update_basic_salary){
      ?>
<script>
alert("Data Updated successfully!")
history.back();
</script>
<?php
}else{
  ?>
<script>
alert("Data not updated Faield!")
history.back()
</script>
<?php
    }
}

//loan_update
public function  update_loan(Request $update_req) {
  $updated_by = session()->get('EmployeeID');

if(isset($updated_by)){
  $update_basic_salary = DB::table('loan')
  ->where('Employee_id', $update_req->Employee_Id)
  ->where('id', $update_req->Id)
   ->update( [
            "Month" => $update_req->Month,
                "year" => $update_req->Year,
                "Title" => $update_req->Title,
                "Loan_type" => $update_req->Loan_type,
                "Number_of_installment" => $update_req->Number_of_installment,
                "Loan_Amount_in_INR" => $update_req->Loan_Amount_in_INR,
                "Loan_duration" => $update_req->Loan_duration,
                "Reason" => $update_req->Reason,
                "Loan_Remaining" => $update_req->Loan_Remaining,

             "updated_by" => $updated_by,
             "updated_at" => now(),
  ]);
}else{
  ?>
<script>
alert("please login")
history.back()
</script>
<?php
}


  if($update_basic_salary){
      ?>
<script>
alert("Data Updated successfully!")
history.back();
</script>
<?php
}else{
  ?>
<script>
alert("Data not updated Faield!")
history.back()
</script>
<?php
    }
}


//update_deductions

public function update_deductions(Request $update_req) {
  $updated_by = session()->get('EmployeeID');
if(isset($updated_by)){
  $update_basic_salary = DB::table('deductions')
  ->where('Employee_id', $update_req->Employee_Id)
  ->where('id', $update_req->Id)
   ->update( [
                "Month" => $update_req->Month,
                "Year" => $update_req->Year,
                "deduction_Titel" => $update_req->Title,
                "deduction_Amount_in_INR" => $update_req->deduction_Amount_in_INR,
                "updated_by" => $updated_by,
                "updated_at" => now(),
  ]);
}else{
  ?>
<script>
alert("please login")
history.back()
</script>
<?php
}


  if($update_basic_salary){
      ?>
<script>
alert("Data Updated successfully!")
history.back();
</script>
<?php
}else{
  ?>
<script>
alert("Data not updated Faield!")
history.back()
</script>
<?php
    }
}


//update_other_payments
public function update_other_payments(Request $update_req) {
  $updated_by = session()->get('EmployeeID');
if(isset($updated_by)){
  $update_basic_salary = DB::table('other_payments')
  ->where('Employee_id', $update_req->Employee_Id)
  ->where('id', $update_req->Id)
   ->update( [
                "Month" => $update_req->Month,
                "Year" => $update_req->Year,
                "Titel" => $update_req->Title,
                "Amount_in_INR" => $update_req->Amount_in_INR,
                "updated_by" => $updated_by,
                "updated_at" => now(),
  ]);
}else{
  ?>
<script>
alert("please login")
history.back()
</script>
<?php
}


  if($update_basic_salary){
      ?>
<script>
alert("Data Updated successfully!")
history.back();
</script>
<?php
}else{
  ?>
<script>
alert("Data not updated Faield!")
history.back()
</script>
<?php
    }
}

//basic_salary_update
public function  basic_salary_update(Request $update_req) {
  $updated_by =session()->get('EmployeeID');
  $update_basic_salary = DB::table('basic_salary')
        ->where('Employee_id', $update_req->Employee_Id)
        ->where('id', $update_req->Id)
         ->update( [
         'month' =>$update_req->Month,
         'year' =>$update_req->Year,
         'Payslip_Type' =>$update_req->Payslip_Type,
         'Basic_Salary' =>$update_req->Basic_Salary,
         'updated_by' => $updated_by,
         'updated_at' => now(),
        ]);
  if($update_basic_salary){
      ?>
<script>
alert("Data Updated successfully!")
history.back();
</script>
<?php
}else{
  ?>
<script>
alert("Data not updated Faield!")
history.back()
</script>
<?php
    }
}


}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class formsController extends Controller
{
    public function Emergency_Contact(Request $Contact_req)
    {
        $id = $Contact_req->id;
        if (isset($id)) {

            $emergency__contactsData = DB::table('_emergency__contacts')
            ->join('all_users', '_emergency__contacts.Employee_id', '=', 'all_users.Employee_id')
                    ->select('_emergency__contacts.*', 'all_users.f_name', 'all_users.m_name', 'all_users.l_name')
                    ->where('_emergency__contacts.id', $id)
                    ->get();

            $Employee_id = "";
            if (isset($emergency__contactsData)) {
                $emergency__contactsCount = count($emergency__contactsData);
                if ($emergency__contactsCount == 1) {
                    foreach ($emergency__contactsData as $c_data) {
                        $Employee_id = $c_data->Employee_id;
                    }
                }
            }
            if ($Employee_id == "") {
                ?>
<script>
alert("data not found")
history.back()
</script>
<?php
               
            } else {

                $emergency__contactsData2 = DB::table('_emergency__contacts')

                    ->join('all_users', '_emergency__contacts.Employee_id', '=', 'all_users.Employee_id')
                    ->select('_emergency__contacts.*', 'all_users.f_name', 'all_users.m_name', 'all_users.l_name')
                    ->where('_emergency__contacts.id', $id)
                    ->get();

                if (isset($emergency__contactsData2)) {
                    $role = session()->get('role');
                    $emergency__contactsData2Count = count($emergency__contactsData2);
                    if ($emergency__contactsCount == 1) {
                        foreach ($emergency__contactsData2 as $c_data) {
                            $id = $c_data->id;
                            $Employee_name = $c_data->f_name . " " . $c_data->m_name . " " . $c_data->l_name;
                            $Employee_id = $c_data->Employee_id;
                            $Name = $c_data->Name;
                            $Relation = $c_data->Relation;
                            $Email = $c_data->Email;
                            $Address = $c_data->Address;
                            $mobile = $c_data->mobile;
                            $City = $c_data->City;
                            $State = $c_data->State;
                            $ZIP = $c_data->ZIP;

                            $em_data = array("id" => $id,
                                "Employee_name" => $Employee_name,
                                "Employee_id" => $Employee_id,
                                "Name" => $Name,
                                "Relation" => $Relation,
                                "Email" => $Email,
                                "Address" => $Address,
                                "mobile" => $mobile,
                                "City" => $City,
                                "State" => $State,
                                "ZIP" => $ZIP,
                            );

                            return view("Emergency_Contact_view")
                            ->with('role',$role)
                                ->with('em_data', $em_data);
                        }

                    } else {
                        ?>
<script>
alert("data not found")
history.back()
</script>
<?php
                        
                    }
                }

            }

        }

    }
    public function edit_Emergency_Contact(Request $Contact_req)
    {
        $id = $Contact_req->id;
        $EmployeesID = session()->get('EmployeeID');
    $role = session()->get('role');
    if(isset( $EmployeesID)){
    
        if (isset($id)) {

            $emergency__contactsData = DB::table('_emergency__contacts')
            ->join('all_users', '_emergency__contacts.Employee_id', '=', 'all_users.Employee_id')
            ->select('_emergency__contacts.*', 'all_users.f_name', 'all_users.m_name', 'all_users.l_name')
            ->where('_emergency__contacts.id', $id)
            ->get();

            if (isset($emergency__contactsData)) {
                $emergency__contactsCount = count($emergency__contactsData);
                if ($emergency__contactsCount == 1) {
                    foreach ($emergency__contactsData as $c_data) {
                        $id = $c_data->id;
                        $Employee_name = $c_data->f_name . " " . $c_data->m_name . " " . $c_data->l_name;
                        $Employee_id = $c_data->Employee_id;
                        $Name = $c_data->Name;
                        $Relation = $c_data->Relation;
                        $Email = $c_data->Email;
                        $Address = $c_data->Address;
                        $mobile = $c_data->mobile;
                        $City = $c_data->City;
                        $State = $c_data->State;
                        $ZIP = $c_data->ZIP;

                        $em_data = array("id" => $id,
                            "Employee_name" => $Employee_name,
                            "Employee_id" => $Employee_id,
                            "Name" => $Name,
                            "Relation" => $Relation,
                            "Email" => $Email,
                            "Address" => $Address,
                            "mobile" => $mobile,
                            "City" => $City,
                            "State" => $State,
                            "ZIP" => $ZIP,
                        );

                        return view("Emergency_Contact_edit")
                        ->with('role',$role)
                            ->with('em_data', $em_data);
                    }

                } else {
                    ?>
<script>
alert("data not found")
history.back()
</script>
<?php
                    

                }
            }

        }
    }else{
        return redirect()->route('login');
      }
    }
    public function delete_Emergency_Contact(Request $Contact_req)
    {

    }

    public function qualifications(Request $Contact_req)
    {
        $id = $Contact_req->id;
        $role = session()->get('role');
        if (isset($id)) {

            $emergency__contactsData = DB::table('_qualifications')
                ->where('id', $id)
                ->get();

            $Employee_id = "";
            if (isset($emergency__contactsData)) {
                $emergency__contactsCount = count($emergency__contactsData);
                if ($emergency__contactsCount == 1) {
                    foreach ($emergency__contactsData as $c_data) {
                        $Employee_id = $c_data->Employee_id;
                    }
                }
            }
            if ($Employee_id == "") {
                ?>
<script>
alert("data not found")
history.back()
</script>
<?php
               
            } else {

                $emergency__contactsData2 = DB::table('_qualifications')

                    ->join('all_users', '_qualifications.Employee_id', '=', 'all_users.Employee_id')
                    ->select('_qualifications.*', 'all_users.f_name', 'all_users.m_name', 'all_users.l_name')
                    ->where('_qualifications.id', $id)
                    ->get();

                if (isset($emergency__contactsData2)) {
                    $emergency__contactsData2Count = count($emergency__contactsData2);
                    if ($emergency__contactsData2Count == 1) {
                        foreach ($emergency__contactsData2 as $c_data) {
                            $id = $c_data->id;
                            $Employee_name = $c_data->f_name . " " . $c_data->m_name . " " . $c_data->l_name;
                            $Employee_id = $c_data->Employee_id;
                            $School_University = $c_data->School_University;
                            $Education_Level = $c_data->Education_Level;
                            $From = $c_data->From;
                            $to = $c_data->to;
                            $Language = $c_data->Language;
                            $Professional_Skills = $c_data->Professional_Skills;
                            $Description = $c_data->Description;
    
                            $em_data = array("id" => $id,
                                "Employee_name" => $Employee_name,
                                "Employee_id" => $Employee_id,
                                "School_University" => $School_University,
                                "Education_Level" => $Education_Level,
                                "From" => $From,
                                "to" => $to,
                                "Language" => $Language,
                                "Professional_Skills" => $Professional_Skills,
                                "Description" => $Description,
    
                            );
    
                            return view("qualifications_view")
                            ->with('role',$role)
                                ->with('em_data', $em_data);
                        }

                    } else {
                        ?>
<script>
alert("data not found")
history.back()
</script>
<?php
                        
                    }
                }

            }

        }



















     

    }
    public function edit_qualifications(Request $Contact_req)
    {
        $id = $Contact_req->id;
        $role = session()->get('role');
        if (isset($id)) {
            $emergency__contactsData = DB::table('_qualifications')
            ->join('all_users', '_qualifications.Employee_id', '=', 'all_users.Employee_id')
                    ->select('_qualifications.*', 'all_users.f_name', 'all_users.m_name', 'all_users.l_name')
                    ->where('_qualifications.id', $id)
          
                ->get();

            if (isset($emergency__contactsData)) {
                $emergency__contactsCount = count($emergency__contactsData);
                if ($emergency__contactsCount == 1) {
                    foreach ($emergency__contactsData as $c_data) {
                        $id = $c_data->id;
                        $Employee_name = $c_data->f_name . " " . $c_data->m_name . " " . $c_data->l_name;
                        $Employee_id = $c_data->Employee_id;
                        $School_University = $c_data->School_University;
                        $Education_Level = $c_data->Education_Level;
                        $From = $c_data->From;
                        $to = $c_data->to;
                        $Language = $c_data->Language;
                        $Professional_Skills = $c_data->Professional_Skills;
                        $Description = $c_data->Description;

                        $em_data = array("id" => $id,
                            "Employee_name" => $Employee_name,
                            "Employee_id" => $Employee_id,
                            "School_University" => $School_University,
                            "Education_Level" => $Education_Level,
                            "From" => $From,
                            "to" => $to,
                            "Language" => $Language,
                            "Professional_Skills" => $Professional_Skills,
                            "Description" => $Description,

                        );

                        return view("qualifactions_edit")
                        ->with('role',$role)
                            ->with('em_data', $em_data);
                    }

                } else {
                    ?>
<script>
alert("data not found")
history.back()
</script>
<?php
                    
                }
            }

        }
    }
    public function delete_qualifications(Request $Contact_req)
    {

    }

    //

    public function document(Request $Contact_req)
    {
        $role = session()->get('role');
        $id = $Contact_req->id;
        if (isset($id)) {

            $emergency__contactsData = DB::table('all__document')
                ->where('id', $id)
                ->get();

            $Employee_id = "";
            if (isset($emergency__contactsData)) {
                $emergency__contactsCount = count($emergency__contactsData);
                if ($emergency__contactsCount == 1) {
                    foreach ($emergency__contactsData as $c_data) {
                        $Employee_id = $c_data->Employee_id;
                    }
                }
            }
            if ($Employee_id == "") {
                ?>
<script>
alert("data not found")
history.back()
</script>
<?php
               
            } else {

                $emergency__contactsData2 = DB::table('all__document')

                    ->join('all_users', 'all__document.Employee_id', '=', 'all_users.Employee_id')
                    ->select('all__document.*', 'all_users.f_name', 'all_users.m_name', 'all_users.l_name')
                    ->where('all__document.id', $id)
                    ->get();


                if (isset($emergency__contactsData2)) {
                    $emergency__contactsData2Count = count($emergency__contactsData2);
                    if ($emergency__contactsData2Count == 1) {
                        foreach ($emergency__contactsData2 as $c_data) {
                            $id = $c_data->id;
                            $Employee_name = $c_data->f_name . " " . $c_data->m_name . " " . $c_data->l_name;
                            $Employee_id = $c_data->Employee_id;
                            $Document_Type = $c_data->Document_Type;
                            $Title = $c_data->Title;
                            $Expired_Date = $c_data->Expired_Date;
                            $Description = $c_data->Description;
                            $Document_path = $c_data->Document_path;
                            $Document_path_back = $c_data->Document_path_back;
    
                            $em_data = array("id" => $id,
                                "Employee_name" => $Employee_name,
                                "Employee_id" => $Employee_id,
                                "Document_Type" => $Document_Type,
                                "Title" => $Title,
                                "Expired_Date" => $Expired_Date,
                                "Document_path" => $Document_path,
                                "Document_path_back" => $Document_path_back,
    
                                "Description" => $Description,
    
                            );
    
                            return view("document_view")
                                ->with('role',$role)
                                ->with('em_data', $em_data);
                        }

                    } else {
                        ?>
<script>
alert("data not found")
history.back()
</script>
<?php
                        
                    }
                }

            }

        }




    }
    public function edit_document(Request $Contact_req)
    {
        $id = $Contact_req->id;
        $role = session()->get('role');
        if (isset($id)) {
            $emergency__contactsData = DB::table('all__document')
            ->join('all_users', 'all__document.Employee_id', '=', 'all_users.Employee_id')
            ->select('all__document.*', 'all_users.f_name', 'all_users.m_name', 'all_users.l_name')
            ->where('all__document.id', $id)
        
                ->get();

            if (isset($emergency__contactsData)) {
                $emergency__contactsCount = count($emergency__contactsData);
                if ($emergency__contactsCount == 1) {
                    foreach ($emergency__contactsData as $c_data) {
                        $id = $c_data->id;
                        $Employee_name = $c_data->f_name . " " . $c_data->m_name . " " . $c_data->l_name;
                        $Employee_id = $c_data->Employee_id;
                        $Document_Type = $c_data->Document_Type;
                        $Title = $c_data->Title;
                        $Expired_Date = $c_data->Expired_Date;
                        $Description = $c_data->Description;
                        $Document_path = $c_data->Document_path;

                        $em_data = array("id" => $id,
                            "Employee_name" => $Employee_name,
                            "Employee_id" => $Employee_id,
                            "Document_Type" => $Document_Type,
                            "Title" => $Title,
                            "Expired_Date" => $Expired_Date,
                            "Document_path" => $Document_path,

                            "Description" => $Description,

                        );

                        return view("document_edit")
                        ->with('role',$role)
                            ->with('em_data', $em_data);
                    }

                } else {
                    ?>
<script>
alert("data not found")
history.back()
</script>
<?php
                    
                }
            }

        }

    }
    public function delete_document(Request $Contact_req)
    {

    }

//Work_Experience
    public function Work_Experience(Request $Contact_req)
    {
        $id = $Contact_req->id;
        $role = session()->get('role');
        if (isset($id)) {

            $emergency__contactsData = DB::table('_work__experience')
                ->where('id', $id)
                ->get();

            $Employee_id = "";
            if (isset($emergency__contactsData)) {
                $emergency__contactsCount = count($emergency__contactsData);
                if ($emergency__contactsCount == 1) {
                    foreach ($emergency__contactsData as $c_data) {
                        $Employee_id = $c_data->Employee_id;
                    }
                }
            }
            if ($Employee_id == "") {
                ?>
<script>
alert("data not found")
history.back()
</script>
<?php
               
            } else {

                $emergency__contactsData2 = DB::table('_work__experience')

                    ->join('all_users', '_work__experience.Employee_id', '=', 'all_users.Employee_id')
                    ->select('_work__experience.*', 'all_users.f_name', 'all_users.m_name', 'all_users.l_name')
                    ->where('_work__experience.id', $id)
                    ->get();

                if (isset($emergency__contactsData2)) {
                    $emergency__contactsData2Count = count($emergency__contactsData2);
                    if ($emergency__contactsData2Count == 1) {
                        foreach ($emergency__contactsData2 as $c_data) {
                            $id = $c_data->id;
                            $Employee_name = $c_data->f_name . " " . $c_data->m_name . " " . $c_data->l_name;
                            $Employee_id = $c_data->Employee_id;
                            $Company = $c_data->Company;
                            $Pos = $c_data->Pos;
                            $From = $c_data->From;
                            $Description = $c_data->Description;
                            $to = $c_data->to;
    
                            $em_data = array("id" => $id,
                                "Employee_name" => $Employee_name,
                                "Employee_id" => $Employee_id,
                                "Company" => $Company,
                                "Post" => $Pos,
                                "From" => $From,
                                "to" => $to,
                                "Description" => $Description,
    
                            );
    
                            return view("work_expreance_view")
                            ->with('role',$role)
                                ->with('em_data', $em_data);
                        }  

                    } else {
                        ?>
<script>
alert("data not found")
history.back()
</script>
<?php
                        
                    }
                }

            }

        }


    }
    public function edit_Work_Experience(Request $Contact_req)
    {
        $id = $Contact_req->id;
        $role = session()->get('role');
        if (isset($id)) {
            $emergency__contactsData = DB::table('_work__experience')
            ->join('all_users', '_work__experience.Employee_id', '=', 'all_users.Employee_id')
    ->select('_work__experience.*', 'all_users.f_name', 'all_users.m_name', 'all_users.l_name')
    ->where('_work__experience.id', $id)
              
                ->get();

            if (isset($emergency__contactsData)) {
                $emergency__contactsCount = count($emergency__contactsData);
                if ($emergency__contactsCount == 1) {
                    foreach ($emergency__contactsData as $c_data) {
                        $id = $c_data->id;
                        $Employee_name = $c_data->f_name . " " . $c_data->m_name . " " . $c_data->l_name;
                        $Employee_id = $c_data->Employee_id;
                        $Company = $c_data->Company;
                        $Pos = $c_data->Pos;
                        $From = $c_data->From;
                        $Description = $c_data->Description;
                        $to = $c_data->to;

                        $em_data = array("id" => $id,
                            "Employee_name" => $Employee_name,
                            "Employee_id" => $Employee_id,
                            "Company" => $Company,
                            "Post" => $Pos,
                            "From" => $From,
                            "to" => $to,
                            "Description" => $Description,

                        );

                        return view("work_expreance_edit")
                        ->with('role',$role)
                            ->with('em_data', $em_data);
                    }

                } else {
                    ?>
<script>
alert("data not found")
history.back()
</script>
<?php
                    
                }
            }

        }

    }
    public function delete_Work_Experience(Request $Contact_req)
    {

    }

    //Bank Account
    public function Bank_Account(Request $Contact_req)
    {
        $id = $Contact_req->id;
        $role = session()->get('role');

        if (isset($id)) {

            $emergency__contactsData = DB::table('accounts')
                ->where('id', $id)
                ->get();

            $Employee_id = "";
            if (isset($emergency__contactsData)) {
                $emergency__contactsCount = count($emergency__contactsData);
                if ($emergency__contactsCount == 1) {
                    foreach ($emergency__contactsData as $c_data) {
                        $Employee_id = $c_data->Employee_id;
                    }
                }
            }
            if ($Employee_id == "") {
                ?>
<script>
alert("data not found")
history.back()
</script>
<?php
               
            } else {

                $emergency__contactsData2 = DB::table('accounts')

                    ->join('all_users', 'accounts.Employee_id', '=', 'all_users.Employee_id')
                    ->select('accounts.*', 'all_users.f_name', 'all_users.m_name', 'all_users.l_name')
                    ->where('accounts.id', $id)
                    ->get();

                if (isset($emergency__contactsData2)) {
                    $emergency__contactsData2Count = count($emergency__contactsData2);
                    if ($emergency__contactsData2Count == 1) {
                        foreach ($emergency__contactsData2 as $c_data) {
                            $id = $c_data->id;
                            $Employee_name = $c_data->f_name . " " . $c_data->m_name . " " . $c_data->l_name;
                            $Employee_id = $c_data->Employee_id;
                            $Account_Holder_Name = $c_data->Account_Holder_Name;
                            $Bank_Name = $c_data->Bank_Name;
                            $Account_Number = $c_data->Account_Number;
                            $IFSC_Code = $c_data->IFSC_Code;
    
                            $em_data = array("id" => $id,
                                "Employee_name" => $Employee_name,
                                "Employee_id" => $Employee_id,
                                "Account_Holder_Name" => $Account_Holder_Name,
                                "Bank_Name" => $Bank_Name,
                                "Account_Number" => $Account_Number,
                                "IFSC_Code" => $IFSC_Code,
    
                            );
                            return view("bank_account_view")
                            ->with('role',$role)
                                ->with('em_data', $em_data);
                        }

                    } else {
                        ?>
<script>
alert("data not found")
history.back()
</script>
<?php
                        
                    }
                }

            }

        }




    }
    public function edit_Bank_Account(Request $Contact_req)
    {
        $id = $Contact_req->id;
        $role = session()->get('role');
        if (isset($id)) {
            $emergency__contactsData = DB::table('accounts')
            ->join('all_users', 'accounts.Employee_id', '=', 'all_users.Employee_id')
            ->select('accounts.*', 'all_users.f_name', 'all_users.m_name', 'all_users.l_name')
            ->where('accounts.id', $id)
                ->get();

            if (isset($emergency__contactsData)) {
                $emergency__contactsCount = count($emergency__contactsData);
                if ($emergency__contactsCount == 1) {
                    foreach ($emergency__contactsData as $c_data) {
                        $id = $c_data->id;
                        $Employee_name = $c_data->f_name . " " . $c_data->m_name . " " . $c_data->l_name;
                        $Employee_id = $c_data->Employee_id;
                        $Account_Holder_Name = $c_data->Account_Holder_Name;
                        $Bank_Name = $c_data->Bank_Name;
                        $Account_Number = $c_data->Account_Number;
                        $IFSC_Code = $c_data->IFSC_Code;

                        $em_data = array("id" => $id,
                            "Employee_name" => $Employee_name,
                            "Employee_id" => $Employee_id,
                            "Account_Holder_Name" => $Account_Holder_Name,
                            "Bank_Name" => $Bank_Name,
                            "Account_Number" => $Account_Number,
                            "IFSC_Code" => $IFSC_Code,

                        );

                        return view("bank_account_edit")
                        ->with('role',$role)
                        ->with('em_data', $em_data);
                    }

                } else {
                    ?>
<script>
alert("data not found")
history.back()
</script>
<?php
                    
                }
            }

        }

    }
    public function delete_Bank_Account(Request $Contact_req)
    {

    }


  // Basic Salary 
public function Basic_Salary(Request $request)
{
    $id = $request->id;
    $role = session()->get('role'); // Retrieve role from session (if required)


    
        // Fetch data from the database
        $basicSalaryData = DB::table('basic_salary')
            ->join('all_users', 'basic_salary.Employee_id', '=', 'all_users.Employee_id')
            ->select(
                'basic_salary.*',
                'all_users.f_name',
                'all_users.m_name',
                'all_users.l_name'
            )
            ->where('basic_salary.id', $id)
            ->first(); // Use 'first()' for a single record instead of 'get'

        // Check if the record exists
        if ($basicSalaryData) {
            return response()->json([
                'success' => true,
                'message' => 'Basic salary details retrieved successfully.',
                'data' => $basicSalaryData,
            ], 200); // Return 200 OK
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No data found for the provided ID.',
            ], 404); // Return 404 Not Found
        }
  
}
























    public function edit_Basic_Salary(Request $Contact_req)
    {
    $id = $Contact_req->id;
    $role = session()->get('role');
    if (isset($id)) {
    $emergency__contactsData = DB::table('basic_salary')
    ->join('all_users', 'basic_salary.Employee_id', '=', 'all_users.Employee_id')
    ->select('basic_salary.*', 'all_users.f_name', 'all_users.m_name', 'all_users.l_name')
    ->where('basic_salary.id', $id)
    ->get();
    
    if (isset($emergency__contactsData)) {
    $emergency__contactsCount = count($emergency__contactsData);
    if ($emergency__contactsCount == 1) {
    foreach ($emergency__contactsData as $c_data) {
    $id = $c_data->id;
    $Employee_name = $c_data->f_name . " " . $c_data->m_name . " " . $c_data->l_name;
    $Employee_id = $c_data->Employee_id;
     $month = $c_data->month;
     $year = $c_data->year;
     $Payslip_Type = $c_data->Payslip_Type;
     $Basic_Salary = $c_data->Basic_Salary;
    
    $em_data = array("id" => $id,
    "Employee_name" => $Employee_name,
    "Employee_id" => $Employee_id,
     "month" => $month,
    "year" => $year,
     "Payslip_Type" => $Payslip_Type,
     "Basic_Salary" => $Basic_Salary,
    
    );
    
    return view("edit_basic_salary")
    ->with('role',$role)
    ->with('em_data', $em_data);
    }
    
    } else {
        ?>
<script>
alert("data not found")
history.back()
</script>
<?php
    
    }
    }
    
    }
    
    }
    public function delete_Basic_Salary(Request $Contact_req)
    {
    
    }
    
    public function delete_holiday(Request $Contact_req)
    {
        

        $id = $Contact_req->id;
        
        if (isset($id)) {

            $delete_holiday =  DB::table('holiday_master')->where('id', $id)->delete();

            if ( $delete_holiday) {
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
            }

        }else{
            echo "please Provide ID";
        }
    }



    // alloweance
    public function alloweance(Request $Contact_req)
    {
    $id = $Contact_req->id;
    $role = session()->get('role');


    // Fetch the data from the database
    $allowanceData = DB::table('alloweance')
        ->join('all_users', 'alloweance.Employee_id', '=', 'all_users.Employee_id')
        ->select(
            'alloweance.*',
            'all_users.f_name',
            'all_users.m_name',
            'all_users.l_name'
        )
        ->where('alloweance.id', $id)
        ->first(); // Use 'first()' for a single result

    // Check if data exists
    if ($allowanceData) {
        return response()->json([
            'success' => true,
            'message' => 'Allowance details retrieved successfully.',
            'data' => $allowanceData,
        ], 200); // Return 200 OK
    } else {
        return response()->json([
            'success' => false,
            'message' => 'No data found for the provided ID.',
        ], 404); // Return 404 Not Found
    }
   
    
    
    
    }
    public function edit_alloweance(Request $Contact_req)
    {
    $id = $Contact_req->id;
    $role = session()->get('role');
    if (isset($id)) {
        $emergency__contactsData = DB::table('alloweance')
        ->join('all_users', 'alloweance.Employee_id', '=', 'all_users.Employee_id')
        ->select('alloweance.*', 'all_users.f_name', 'all_users.m_name', 'all_users.l_name')
        ->where('alloweance.id', $id)
        ->get();
    
    if (isset($emergency__contactsData)) {
    $emergency__contactsCount = count($emergency__contactsData);
    if ($emergency__contactsCount == 1) {
    foreach ($emergency__contactsData as $c_data) {
    $id = $c_data->id;
    $Employee_name = $c_data->f_name . " " . $c_data->m_name . " " . $c_data->l_name;
    $Employee_id = $c_data->Employee_id;
    $Month = $c_data->Month;
    $Alloweance_Titel = $c_data->Alloweance_Titel;
    $Allowance_Ammount_in_INR = $c_data->Allowance_Ammount_in_INR;
    $year = $c_data->year;
    $em_data = array("id" => $id,
    "Employee_name" => $Employee_name,
    "Employee_id" => $Employee_id,
    "Month" => $Month,
    "Alloweance_Titel" => $Alloweance_Titel,
    "Allowance_Ammount_in_INR" => $Allowance_Ammount_in_INR,
    "year" => $year,
    );
    
    return view("edit_alloweance")
    ->with('role',$role)
    ->with('em_data', $em_data);
    }
    
    } else {
        ?>
<script>
alert("data not found")
history.back()
</script>
<?php
    
    }
    }
    
    }else{
        echo "error";
    }
    
    }
    public function delete_alloweance(Request $Contact_req)
    {
    
    }






    public function Loan(Request $request)
{

        $id = $request->id;
        $role = session()->get('role'); // Get the role from session if needed

        // Retrieve the loan data with related user information
        $loanData = DB::table('loan')
            ->join('all_users', 'loan.Employee_id', '=', 'all_users.Employee_id')
            ->select(
                'loan.*',
                'all_users.f_name',
                'all_users.m_name',
                'all_users.l_name'
            )
            ->where('loan.Loan_id', $id)
            ->first(); // Fetch a single result

        // Check if data exists
        if ($loanData) {
            return response()->json([
                'success' => true,
                'message' => 'Loan details retrieved successfully.',
                'data' => $loanData,
            ], 200); // HTTP 200 OK
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No loan data found for the provided ID.',
            ], 404); // HTTP 404 Not Found
        }
  
}






    public function edit_loan(Request $Contact_req)
    {
    $id = $Contact_req->id;
    $role = session()->get('role');
    if (isset($id)) {
    
        $emergency__contactsData = DB::table('loan')
        ->where('id', $id)
        ->get();
        $Employee_id = "";
        if (isset($emergency__contactsData)) {
        $emergency__contactsCount = count($emergency__contactsData);
        if ($emergency__contactsCount == 1) {
        foreach ($emergency__contactsData as $c_data) {
        $Employee_id = $c_data->Employee_id;
        }
        }
        }
        if ($Employee_id == "") {
            ?>
<script>
alert("data not found")
history.back()
</script>
<?php
       
        } else {
        
        $emergency__contactsData2 = DB::table('loan')
        
        ->join('all_users', 'loan.Employee_id', '=', 'all_users.Employee_id')
        ->select('loan.*', 'all_users.f_name', 'all_users.m_name', 'all_users.l_name')
        ->where('loan.id', $id)
        ->get();
        
        if (isset($emergency__contactsData2)) {
        $emergency__contactsData2Count = count($emergency__contactsData2);
        if ($emergency__contactsData2Count == 1) {
            foreach ($emergency__contactsData2 as $c_data) {
                $id = $c_data->id;
                $Employee_name = $c_data->f_name . " " . $c_data->m_name . " " . $c_data->l_name;
                $Employee_id = $c_data->Employee_id;
                $month = $c_data->Month;
                $year = $c_data->Year;
                $Title = $c_data->Title;
                $Loan_type = $c_data->Loan_type;
                $Number_of_installment = $c_data->Number_of_installment;
                $Loan_Amount_in_INR = $c_data->Loan_Amount_in_INR;
                $Loan_duration = $c_data->Loan_duration;
                $Reason = $c_data->Reason;
                $Loan_Remaining = $c_data->Loan_Remaining;
             
                
                $em_data = array("id" => $id,
                "Employee_name" => $Employee_name,
                "Employee_id" => $Employee_id,
                "Month" => $month,
                "year" => $year,
                "Title" => $Title,
                "Loan_type" => $Loan_type,
                "Number_of_installment" => $Number_of_installment,
                "Loan_Amount_in_INR" => $Loan_Amount_in_INR,
                "Loan_duration" => $Loan_duration,
                "Reason" => $Reason,
                "Loan_Remaining" => $Loan_Remaining,
                
                );
                return view("edit_lone")
                ->with('role',$role)
                ->with('em_data', $em_data);
                
                }
        
        } else {
            ?>
<script>
alert("data not found")
history.back()
</script>
<?php
        
        }
        }
        
        }
        
        }
    }

    public function Deductions(Request $request)
    {
            $id = $request->id;
            $role = session()->get('role'); // Get the role from the session if needed
            // Fetch deduction data along with user information
            $deductionData = DB::table('deductions')
                ->join('all_users', 'deductions.Employee_id', '=', 'all_users.Employee_id')
                ->select(
                    'deductions.*',
                    'all_users.f_name',
                    'all_users.m_name',
                    'all_users.l_name'
                )
                ->where('deductions.id', $id)
                ->first(); // Fetch a single record
    
            // Check if data exists
            if ($deductionData) {
                return response()->json([
                    'success' => true,
                    'message' => 'Deduction details retrieved successfully.',
                    'data' => $deductionData,
                ], 200); // HTTP 200 OK
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No deduction data found for the provided ID.',
                ], 404); // HTTP 404 Not Found
            }
       
    }
    

      // Deductions
      public function edit_deductions(Request $Contact_req)
      {
      $id = $Contact_req->id;
      $role = session()->get('role');
      if (isset($id)) {
      
          $emergency__contactsData = DB::table('deductions')
          ->where('id', $id)
          ->get();
          
          $Employee_id = "";
          if (isset($emergency__contactsData)) {
          $emergency__contactsCount = count($emergency__contactsData);
          if ($emergency__contactsCount == 1) {
          foreach ($emergency__contactsData as $c_data) {
          $Employee_id = $c_data->Employee_id;
          }
          }
          }
          if ($Employee_id == "") {
             ?>
<script>
alert("data not found")
history.back()
</script>
<?php
         
          } else {
          
          $emergency__contactsData2 = DB::table('deductions')
          
          ->join('all_users', 'deductions.Employee_id', '=', 'all_users.Employee_id')
          ->select('deductions.*', 'all_users.f_name', 'all_users.m_name', 'all_users.l_name')
          ->where('deductions.id', $id)
          ->get();
          
          if (isset($emergency__contactsData2)) {
          $emergency__contactsData2Count = count($emergency__contactsData2);
          if ($emergency__contactsData2Count == 1) {
              foreach ($emergency__contactsData2 as $c_data) {
                  $id = $c_data->id;
                  $Employee_name = $c_data->f_name . " " . $c_data->m_name . " " . $c_data->l_name;
                  $Employee_id = $c_data->Employee_id;
                  $month = $c_data->Month;
                  $year = $c_data->Year;
                  $Title = $c_data->deduction_Titel;
                  $deduction_Amount_in_INR = $c_data->deduction_Amount_in_INR;
                  $em_data = array("id" => $id,
                  "Employee_name" => $Employee_name,
                  "Employee_id" => $Employee_id,
                  "Month" => $month,
                  "year" => $year,
                  "Title" => $Title,
                  "deduction_Amount_in_INR" => $deduction_Amount_in_INR,
                  );
                  return view("edit_deductions")
                  ->with('role',$role)
                  ->with('em_data', $em_data);
                  }
          
          } else {
             ?>
<script>
alert("data not found")
history.back()
</script>
<?php
          
          }
          }
          
          }
          
          }
      
      }

     // Deductions
public function view_deductions_api(Request $Contact_req)
{
  

    // Fetch data from the database
    $deductionsData = DB::table('deductions')
        ->join('all_users', 'deductions.Employee_id', '=', 'all_users.Employee_id')
        ->select(
            'deductions.*',
            'all_users.f_name',
            'all_users.m_name',
            'all_users.l_name'
        )

        ->paginate($Contact_req->limit);

    // Check if data exists
    if ($deductionsData->isEmpty()) {
        return response()->json([
            'status' => 'error',
            'message' => 'deductions data not found '
        ], 404);
    }

    // Return the data as a JSON response
    return response()->json([
        'status' => 'success',
        'all_users' => $deductionsData
    ], 200);
}

 



     
     // Other Payment
     public function Other_Payment_function(Request $Contact_req)
     {
     $id = $Contact_req->id;
     $role = session()->get('role');
     if (isset($id)) {
         $emergency__contactsData = DB::table('other_payments')
         ->where('id', $id)
         ->get();
         $Employee_id = "";
         if (isset($emergency__contactsData)) {
         $emergency__contactsCount = count($emergency__contactsData);
         if ($emergency__contactsCount == 1) {
         foreach ($emergency__contactsData as $c_data) {
         $Employee_id = $c_data->Employee_id;
         }
         }
         }
         if ($Employee_id == "") {
            ?>
<script>
alert("data not found")
history.back()
</script>
<?php
        
         } else {
         
         $emergency__contactsData2 = DB::table('other_payments')
         
         ->join('all_users', 'other_payments.Employee_id', '=', 'all_users.Employee_id')
         ->select('other_payments.*', 'all_users.f_name', 'all_users.m_name', 'all_users.l_name')
         ->where('other_payments.id', $id)
         ->get();
         
         if (isset($emergency__contactsData2)) {
         $emergency__contactsData2Count = count($emergency__contactsData2);
         if ($emergency__contactsData2Count == 1) {
             foreach ($emergency__contactsData2 as $c_data) {
                 $id = $c_data->id;
                 $Employee_name = $c_data->f_name . " " . $c_data->m_name . " " . $c_data->l_name;
                 $Employee_id = $c_data->Employee_id;
                 $month = $c_data->Month;
                 $year = $c_data->Year;
                 $Title = $c_data->Titel;
                 $Amount_in_INR = $c_data->Amount_in_INR;
                 $em_data = array("id" => $id,
                 "Employee_name" => $Employee_name,
                 "Employee_id" => $Employee_id,
                 "month" => $month,
                 "year" => $year,
                 "Title" => $Title,
                 "Amount_in_INR" => $Amount_in_INR,
                 );
                 return view("other_payments_View")
                 ->with('role',$role)
                 ->with('em_data', $em_data);
                 }
         
         } else {
            ?>
<script>
alert("data not found")
history.back()
</script>
<?php

         
         }
         }
         
         }
         
         }
     
     }




     // over time
     public function over_time(Request $Contact_req)
     {
     $id = $Contact_req->id;
     $role = session()->get('role');
     if (isset($id)) {
         $emergency__contactsData = DB::table('overtime')
         ->where('id', $id)
         ->get();
         $Employee_id = "";
         if (isset($emergency__contactsData)) {
         $emergency__contactsCount = count($emergency__contactsData);
         if ($emergency__contactsCount == 1) {
         foreach ($emergency__contactsData as $c_data) {
         $Employee_id = $c_data->Employee_id;
         }
         }
         }
         if ($Employee_id == "") {
            ?>
<script>
alert("data not found")
history.back()
</script>
<?php
        
         } else {
         
         $emergency__contactsData2 = DB::table('overtime')
         
         ->join('all_users', 'overtime.Employee_id', '=', 'all_users.Employee_id')
         ->select('overtime.*', 'all_users.f_name', 'all_users.m_name', 'all_users.l_name')
         ->where('overtime.id', $id)
         ->get();
         
         if (isset($emergency__contactsData2)) {
         $emergency__contactsData2Count = count($emergency__contactsData2);
         if ($emergency__contactsData2Count == 1) {
             foreach ($emergency__contactsData2 as $c_data) {
                 $id = $c_data->id;
                 $Employee_name = $c_data->f_name . " " . $c_data->m_name . " " . $c_data->l_name;
                 $Employee_id = $c_data->Employee_id;
                 $month = $c_data->Month;
                 $year = $c_data->Year;
                 $Total_Hours = $c_data->Total_Hours;
                 $Rate = $c_data->Rate;
                 $Title = $c_data->Titel;
                 $Total_Amount = $c_data->Total_Amount;
                 $em_data = array("id" => $id,
                 "Employee_name" => $Employee_name,
                 "Employee_id" => $Employee_id,
                 "month" => $month,
                 "year" => $year,
               
                 "Total_Hours" => $Total_Hours,
                 "Rate" => $Rate,
                 "Title" => $Title,
                 "Amount_in_INR" => $Total_Amount,
                 );
                 return view("over_time_View")
                 ->with('role',$role)
                 ->with('em_data', $em_data);
                 }
                
         } else {
            ?>
<script>
alert("data not found")
history.back()
</script>
<?php
         
         }
         }
         
         }
         
         }
     
     }



     // edit_Other_Payment
     public function edit_Other_Payment(Request $Contact_req)
     {
     $id = $Contact_req->id;
     $role = session()->get('role');
     if (isset($id)) {
         $emergency__contactsData = DB::table('other_payments')
         ->where('id', $id)
         ->get();
         $Employee_id = "";
         if (isset($emergency__contactsData)) {
         $emergency__contactsCount = count($emergency__contactsData);
         if ($emergency__contactsCount == 1) {
         foreach ($emergency__contactsData as $c_data) {
         $Employee_id = $c_data->Employee_id;
         }
         }
         }
         if ($Employee_id == "") {
            ?>
<script>
alert("data not found")
history.back()
</script>
<?php
        
         } else {
         
         $emergency__contactsData2 = DB::table('overtime')
         
         ->join('all_users', 'overtime.Employee_id', '=', 'all_users.Employee_id')
         ->select('overtime.*', 'all_users.f_name', 'all_users.m_name', 'all_users.l_name')
         ->where('overtime.id', $id)
         ->get();
         
         if ($emergency__contactsData2) {
         $emergency__contactsData2Count = count($emergency__contactsData2);
         if ($emergency__contactsData2Count == 1) {
             foreach ($emergency__contactsData2 as $c_data) {
                 $id = $c_data->id;
                 $Employee_name = $c_data->f_name . " " . $c_data->m_name . " " . $c_data->l_name;
                 $Employee_id = $c_data->Employee_id;
                 $month = $c_data->Month;
                 $year = $c_data->Year;
                 $Total_Hours = $c_data->Total_Hours;
                 $Rate = $c_data->Rate;
                 $Title = $c_data->Titel;
                 $Total_Amount = $c_data->Total_Amount;
                 $em_data = array("id" => $id,
                 "Employee_name" => $Employee_name,
                 "Employee_id" => $Employee_id,
                 "Month" => $month,
                 "year" => $year,
                 "Total_Hours" => $Total_Hours,
                 "Rate" => $Rate,
                 "Title" => $Title,
                 "Amount_in_INR" => $Total_Amount,
                 );
                 return view("edit_other_paymrnt")
                 ->with('role',$role)
                 ->with('em_data', $em_data);
                 }
                
         } else {
            ?>
<script>
alert("data not found")
history.back()
</script>
<?php
         
         }
         }
         
         }
         
         }
     
     }

     //edit_over_time
// 
public function edit_over_time(Request $Contact_req)
{
$id = $Contact_req->id;
$role = session()->get('role');
if (isset($id)) {
    $emergency__contactsData = DB::table('overtime')
    ->where('id', $id)
    ->get();
    $Employee_id = "";
    if (isset($emergency__contactsData)) {
    $emergency__contactsCount = count($emergency__contactsData);
    if ($emergency__contactsCount == 1) {
    foreach ($emergency__contactsData as $c_data) {
    $Employee_id = $c_data->Employee_id;
    }
    }
    }
    if ($Employee_id == "") {
       ?>
<script>
alert("data not found")
history.back()
</script>
<?php
   
    } else {
    
    $emergency__contactsData2 = DB::table('overtime')
    
    ->join('all_users', 'overtime.Employee_id', '=', 'all_users.Employee_id')
    ->select('overtime.*', 'all_users.f_name', 'all_users.m_name', 'all_users.l_name')
    ->where('overtime.id', $id)
    ->get();
    
    if (isset($emergency__contactsData2)) {
    $emergency__contactsData2Count = count($emergency__contactsData2);
    if ($emergency__contactsData2Count == 1) {
        foreach ($emergency__contactsData2 as $c_data) {
            $id = $c_data->id;
            $Employee_name = $c_data->f_name . " " . $c_data->m_name . " " . $c_data->l_name;
            $Employee_id = $c_data->Employee_id;
            $month = $c_data->Month;
            $year = $c_data->Year;
            $Total_Hours = $c_data->Total_Hours;
            $Rate = $c_data->Rate;
            $Title = $c_data->Titel;
            $Total_Amount = $c_data->Total_Amount;
            $em_data = array("id" => $id,
            "Employee_name" => $Employee_name,
            "Employee_id" => $Employee_id,
            "month" => $month,
            "year" => $year,
          
            "Total_Hours" => $Total_Hours,
            "Rate" => $Rate,
            "Title" => $Title,
            "Amount_in_INR" => $Total_Amount,
            );
            return view("edit_over_time")
            ->with('role',$role)
            ->with('em_data', $em_data);
            }
           
    } else {
       ?>
<script>
alert("data not found")
history.back()
</script>
<?php
    
    }
    }
    
    }
    
    }

}



    // Leave 
    public function leave_view(Request $request)
    {
       
    
            $id = $request->id;
            $role = session()->get('role'); // Retrieve the user's role from the session (if needed)
    
            // Fetch leave data along with user information
            $leaveData = DB::table('_leave')
                ->join('all_users', '_leave.Employee_id', '=', 'all_users.Employee_id')
                ->join('leave_type_master', '_leave.Leave_Type', '=', 'leave_type_master.id')
                ->select(
                    '_leave.*',
                    'all_users.f_name',
                    'all_users.m_name',
                    'all_users.l_name',
                    'leave_type_master.Name as Leave_Type_name'
                )
                ->where('_leave.id', $id)
                ->first(); // Retrieve a single record
    
            // Check if data exists
            if ($leaveData) {
                return response()->json([
                    'success' => true,
                    'message' => 'Leave details retrieved successfully.',
                    'data' => $leaveData,
                ], 200); // HTTP 200 OK
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No leave data found for the provided ID.',
                ], 404); // HTTP 404 Not Found
            }
        
    }
    

           // award info 
           public function award_view(Request $Contact_req)
           {
           $id = $Contact_req->id;
           $role = session()->get('role');
           if (isset($id)) {
               $emergency__contactsData = DB::table('award_info')
               ->where('id', $id)
               ->get();
               $Employee_id = "";
               if (isset($emergency__contactsData)) {
               $emergency__contactsCount = count($emergency__contactsData);
               if ($emergency__contactsCount == 1) {
               foreach ($emergency__contactsData as $c_data) {
               $Employee_id = $c_data->Employee_id;
               }
               }
               }
               if ($Employee_id == "") {
                ?>
<script>
alert("data not found")
history.back()
</script>
<?php
              
               } else {
               
               $emergency__contactsData2 = DB::table('award_info')
               
               ->join('all_users', 'award_info.Employee_id', '=', 'all_users.Employee_id')
               ->select('award_info.*', 'all_users.f_name', 'all_users.m_name', 'all_users.l_name')
               ->where('award_info.id', $id)
               ->get();
               if (isset($emergency__contactsData2)) {
               $emergency__contactsData2Count = count($emergency__contactsData2);
               if ($emergency__contactsData2Count == 1) {
                   foreach ($emergency__contactsData2 as $c_data) {
                       $id = $c_data->id;
                       $Employee_name = $c_data->f_name . " " . $c_data->m_name . " " . $c_data->l_name;
                       $Employee_id = $c_data->Employee_id;
                       $Award_Name = $c_data->Award_Name;
                       $Gift = $c_data->Gift;
                       $Award_date = $c_data->Award_date;
                       $Award_by = $c_data->Award_by;
                       $em_data = array("id" => $id,
                       "Employee_name" => $Employee_name,
                       "Employee_id" => $Employee_id,
                       "Award_Name" => $Award_Name,
                       "Gift" => $Gift,
                       "Award_date" => $Award_date, 
                       "Award_by" => $Award_by, 
                       );
                       return view("award_view")
                       ->with('role',$role)
                       ->with('em_data', $em_data);
                       }
                    
               } else {
                ?>
<script>
alert("data not found")
history.back()
</script>
<?php
               
               }
               }
               
               }
               
               }
           
           }


           // Travel info 
           public function Travel_view(Request $Contact_req)
           {
           $id = $Contact_req->id;
           $role = session()->get('role');
           if (isset($id)) {
               $emergency__contactsData = DB::table('travel_info')
               ->where('id', $id)
               ->get();
               $Employee_id = "";
               if (isset($emergency__contactsData)) {
               $emergency__contactsCount = count($emergency__contactsData);
               if ($emergency__contactsCount == 1) {
               foreach ($emergency__contactsData as $c_data) {
               $Employee_id = $c_data->Employee_id;
               }
               }
               }
               if ($Employee_id == "") {
                ?>
<script>
alert("data not found")
history.back()
</script>
<?php
              
               } else {
               
               $emergency__contactsData2 = DB::table('travel_info')
               
               ->join('all_users', 'travel_info.Employee_id', '=', 'all_users.Employee_id')
               ->select('travel_info.*', 'all_users.f_name', 'all_users.m_name', 'all_users.l_name')
               ->where('travel_info.id', $id)
               ->get();
               if (isset($emergency__contactsData2)) {
               $emergency__contactsData2Count = count($emergency__contactsData2);
               if ($emergency__contactsData2Count == 1) {
                   foreach ($emergency__contactsData2 as $c_data) {
                       $id = $c_data->id;
                       $Employee_name = $c_data->f_name . " " . $c_data->m_name . " " . $c_data->l_name;
                       $Employee_id = $c_data->Employee_id;
                       $Summary = $c_data->Summary;
                       $Place_Of_Visit = $c_data->Place_Of_Visit;
                       $Travel_start_date = $c_data->Travel_start_date;
                       $Travel_end_date = $c_data->Travel_end_date;
                       $em_data = array("id" => $id,
                       "Employee_name" => $Employee_name,
                       "Employee_id" => $Employee_id,
                       "Summary" => $Summary,
                       "Place_Of_Visit" => $Place_Of_Visit,
                       "Travel_start_date" => $Travel_start_date, 
                       "Travel_end_date" => $Travel_end_date, 
                       );
                       return view("travel_view")
                       ->with('role',$role)
                       ->with('em_data', $em_data);
                       
                       }
                    
               } else {
                ?>
<script>
alert("data not found")
history.back()
</script>
<?php
               
               }
               }
               
               }
               
               }
           
           }



            // Training info 
            public function Training_view(Request $Contact_req)
            {
            $id = $Contact_req->id;
            $role = session()->get('role');
            if (isset($id)) {
                $emergency__contactsData = DB::table('training_info')
                ->where('id', $id)
                ->get();
                $Employee_id = "";
                if (isset($emergency__contactsData)) {
                $emergency__contactsCount = count($emergency__contactsData);
                if ($emergency__contactsCount == 1) {
                foreach ($emergency__contactsData as $c_data) {
                $Employee_id = $c_data->Employee_id;
                }
                }
                }
                if ($Employee_id == "") {
                    ?>
<script>
alert("data not found")
history.back()
</script>
<?php
               
                } else {
                
                $emergency__contactsData2 = DB::table('training_info')
                
                ->join('all_users', 'training_info.Employee_id', '=', 'all_users.Employee_id')
                ->select('training_info.*', 'all_users.f_name', 'all_users.m_name', 'all_users.l_name')
                ->where('training_info.id', $id)
                ->get();
                if (isset($emergency__contactsData2)) {
                $emergency__contactsData2Count = count($emergency__contactsData2);
                if ($emergency__contactsData2Count == 1) {
                    foreach ($emergency__contactsData2 as $c_data) {
                        $id = $c_data->id;
                        $Employee_name = $c_data->f_name . " " . $c_data->m_name . " " . $c_data->l_name;
                        $Employee_id = $c_data->Employee_id;
                        $Training_Typ = $c_data->Training_Typ;
                        $Trainer = $c_data->Trainer;
                        $Travel_start_date = $c_data->Training_start_date;
                        $Travel_end_date = $c_data->Training_end_date;
                        $em_data = array("id" => $id,
                        "Employee_name" => $Employee_name,
                        "Employee_id" => $Employee_id,
                        "Training_Typ" => $Training_Typ,
                        "Trainer" => $Trainer,
                        "Travel_start_date" => $Travel_start_date, 
                        "Travel_end_date" => $Travel_end_date, 
                        );
                        return view("Training_view")
                        ->with('role',$role)
                        ->with('em_data', $em_data);
                        }
                     
                } else {
                    ?>
<script>
alert("data not found")
history.back()
</script>
<?php
                
                }
                }
                
                }
                
                }
            
            }
     



















}

var genral_page = document.getElementById("genral_info_main_div");
var Profile_page = document.getElementById("profile_mane_div");
var Salary_page = document.getElementById("salary_main_div");
var Leave_page = document.getElementById("leave_mane_div");
var Attendance_page = document.getElementById("Attendance_main_div");
var Core_HR_page = document.getElementById("core_hr_main_div");
var Project_task_page = document.getElementById("task_main_div");
var Payslip_page = document.getElementById("payslip_main_div");
var Remaining_Leave_page = document.getElementById("remaning_main_div");
open_genral_page();
function open_genral_page() {
    document.getElementById("genral_info_main_div").style.display = "block";
    document.getElementById("profile_mane_div").style.display = "none";
    document.getElementById("salary_main_div").style.display = "none";
    document.getElementById("leave_mane_div").style.display = "none";
    document.getElementById("Attendance_main_div").style.display = "none";
    document.getElementById("core_hr_main_div").style.display = "none";
    document.getElementById("task_main_div").style.display = "none";
    document.getElementById("payslip_main_div").style.display = "none";
    document.getElementById("remaning_main_div").style.display = "none";
    
    document.getElementById("genral_p").classList.add("active_emp_deiail_p");
    document.getElementById("profile_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Salary_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Leave_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Attendance_p").classList.remove("active_emp_deiail_p");
    document.getElementById("core_hr_p").classList.remove("active_emp_deiail_p");
    document.getElementById("priject_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Payslip-p").classList.remove("active_emp_deiail_p");
    document.getElementById("remanini_leave_p").classList.remove("active_emp_deiail_p");
}
function open_Profile_page() {

    document.getElementById("profile_mane_div").style.display = "block";
    document.getElementById("genral_info_main_div").style.display = "none";
    document.getElementById("salary_main_div").style.display = "none";
    document.getElementById("leave_mane_div").style.display = "none";
    document.getElementById("Attendance_main_div").style.display = "none";
    document.getElementById("core_hr_main_div").style.display = "none";
    document.getElementById("task_main_div").style.display = "none";
    document.getElementById("payslip_main_div").style.display = "none";
    document.getElementById("remaning_main_div").style.display = "none";

    document.getElementById("genral_p").classList.remove("active_emp_deiail_p");
    document.getElementById("profile_p").classList.add("active_emp_deiail_p");
    document.getElementById("Salary_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Leave_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Attendance_p").classList.remove("active_emp_deiail_p");
    document.getElementById("core_hr_p").classList.remove("active_emp_deiail_p");
    document.getElementById("priject_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Payslip-p").classList.remove("active_emp_deiail_p");
    document.getElementById("remanini_leave_p").classList.remove("active_emp_deiail_p");



}
function open_Salary_page() {
    document.getElementById("profile_mane_div").style.display = "none";
    document.getElementById("genral_info_main_div").style.display = "none";
    document.getElementById("salary_main_div").style.display = "block";
    document.getElementById("leave_mane_div").style.display = "none";
    document.getElementById("Attendance_main_div").style.display = "none";
    document.getElementById("core_hr_main_div").style.display = "none";
    document.getElementById("task_main_div").style.display = "none";
    document.getElementById("payslip_main_div").style.display = "none";
    document.getElementById("remaning_main_div").style.display = "none";

    document.getElementById("genral_p").classList.remove("active_emp_deiail_p");
    document.getElementById("profile_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Salary_p").classList.add("active_emp_deiail_p");
    document.getElementById("Leave_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Attendance_p").classList.remove("active_emp_deiail_p");
    document.getElementById("core_hr_p").classList.remove("active_emp_deiail_p");
    document.getElementById("priject_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Payslip-p").classList.remove("active_emp_deiail_p");
    document.getElementById("remanini_leave_p").classList.remove("active_emp_deiail_p");
}
function open_Leave_page() {
    document.getElementById("profile_mane_div").style.display = "none";
    document.getElementById("genral_info_main_div").style.display = "none";
    document.getElementById("salary_main_div").style.display = "none";
    document.getElementById("leave_mane_div").style.display = "block";
    document.getElementById("Attendance_main_div").style.display = "none";
    document.getElementById("core_hr_main_div").style.display = "none";
    document.getElementById("task_main_div").style.display = "none";
    document.getElementById("payslip_main_div").style.display = "none";
    document.getElementById("remaning_main_div").style.display = "none";

    document.getElementById("genral_p").classList.remove("active_emp_deiail_p");
    document.getElementById("profile_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Salary_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Leave_p").classList.add("active_emp_deiail_p");
    document.getElementById("Attendance_p").classList.remove("active_emp_deiail_p");
    document.getElementById("core_hr_p").classList.remove("active_emp_deiail_p");
    document.getElementById("priject_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Payslip-p").classList.remove("active_emp_deiail_p");
    document.getElementById("remanini_leave_p").classList.remove("active_emp_deiail_p");
}
function open_Attendance_page() {
    document.getElementById("profile_mane_div").style.display = "none";
    document.getElementById("genral_info_main_div").style.display = "none";
    document.getElementById("salary_main_div").style.display = "none";
    document.getElementById("leave_mane_div").style.display = "none";
    document.getElementById("Attendance_main_div").style.display = "block";
    document.getElementById("core_hr_main_div").style.display = "none";
    document.getElementById("task_main_div").style.display = "none";
    document.getElementById("payslip_main_div").style.display = "none";
    document.getElementById("remaning_main_div").style.display = "none";

    document.getElementById("genral_p").classList.remove("active_emp_deiail_p");
    document.getElementById("profile_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Salary_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Leave_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Attendance_p").classList.add("active_emp_deiail_p");
    document.getElementById("core_hr_p").classList.remove("active_emp_deiail_p");
    document.getElementById("priject_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Payslip-p").classList.remove("active_emp_deiail_p");
    document.getElementById("remanini_leave_p").classList.remove("active_emp_deiail_p");
}
function open_Core_HR_page() {
    document.getElementById("profile_mane_div").style.display = "none";
    document.getElementById("genral_info_main_div").style.display = "none";
    document.getElementById("salary_main_div").style.display = "none";
    document.getElementById("leave_mane_div").style.display = "none";
    document.getElementById("Attendance_main_div").style.display = "none";
    document.getElementById("core_hr_main_div").style.display = "block";
    document.getElementById("task_main_div").style.display = "none";
    document.getElementById("payslip_main_div").style.display = "none";
    document.getElementById("remaning_main_div").style.display = "none";

    document.getElementById("genral_p").classList.remove("active_emp_deiail_p");
    document.getElementById("profile_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Salary_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Leave_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Attendance_p").classList.remove("active_emp_deiail_p");
    document.getElementById("core_hr_p").classList.add("active_emp_deiail_p");
    document.getElementById("priject_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Payslip-p").classList.remove("active_emp_deiail_p");
    document.getElementById("remanini_leave_p").classList.remove("active_emp_deiail_p");
}
function open_Project_task_page() {
    document.getElementById("profile_mane_div").style.display = "none";
    document.getElementById("genral_info_main_div").style.display = "none";
    document.getElementById("salary_main_div").style.display = "none";
    document.getElementById("leave_mane_div").style.display = "none";
    document.getElementById("Attendance_main_div").style.display = "none";
    document.getElementById("core_hr_main_div").style.display = "none";
    document.getElementById("task_main_div").style.display = "block";
    document.getElementById("payslip_main_div").style.display = "none";
    document.getElementById("remaning_main_div").style.display = "none";

    document.getElementById("genral_p").classList.remove("active_emp_deiail_p");
    document.getElementById("profile_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Salary_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Leave_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Attendance_p").classList.remove("active_emp_deiail_p");
    document.getElementById("core_hr_p").classList.remove("active_emp_deiail_p");
    document.getElementById("priject_p").classList.add("active_emp_deiail_p");
    document.getElementById("Payslip-p").classList.remove("active_emp_deiail_p");
    document.getElementById("remanini_leave_p").classList.remove("active_emp_deiail_p");
}
function open_Payslip_page() {
    document.getElementById("profile_mane_div").style.display = "none";
    document.getElementById("genral_info_main_div").style.display = "none";
    document.getElementById("salary_main_div").style.display = "none";
    document.getElementById("leave_mane_div").style.display = "none";
    document.getElementById("Attendance_main_div").style.display = "none";
    document.getElementById("core_hr_main_div").style.display = "none";
    document.getElementById("task_main_div").style.display = "none";
    document.getElementById("payslip_main_div").style.display = "block";
    document.getElementById("remaning_main_div").style.display = "none";

    document.getElementById("genral_p").classList.remove("active_emp_deiail_p");
    document.getElementById("profile_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Salary_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Leave_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Attendance_p").classList.remove("active_emp_deiail_p");
    document.getElementById("core_hr_p").classList.remove("active_emp_deiail_p");
    document.getElementById("priject_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Payslip-p").classList.add("active_emp_deiail_p");
    document.getElementById("remanini_leave_p").classList.remove("active_emp_deiail_p");
}
function open_Remaining_Leave_page() {
    document.getElementById("profile_mane_div").style.display = "none";
    document.getElementById("genral_info_main_div").style.display = "none";
    document.getElementById("salary_main_div").style.display = "none";
    document.getElementById("leave_mane_div").style.display = "none";
    document.getElementById("Attendance_main_div").style.display = "none";
    document.getElementById("core_hr_main_div").style.display = "none";
    document.getElementById("task_main_div").style.display = "none";
    document.getElementById("payslip_main_div").style.display = "none";
    document.getElementById("remaning_main_div").style.display = "block";

    document.getElementById("genral_p").classList.remove("active_emp_deiail_p");
    document.getElementById("profile_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Salary_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Leave_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Attendance_p").classList.remove("active_emp_deiail_p");
    document.getElementById("core_hr_p").classList.remove("active_emp_deiail_p");
    document.getElementById("priject_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Payslip-p").classList.remove("active_emp_deiail_p");
    document.getElementById("remanini_leave_p").classList.add("active_emp_deiail_p");
}

// tab 1 










function open_Basic_info_page() {
    document.getElementById("Basic_info_page").style.display = "flex";
    document.getElementById("Emergency_Contacts_page").style.display = "none";
    document.getElementById("Social_Profile_page").style.display = "none";
    document.getElementById("Document_page").style.display = "none";
    document.getElementById("Qualification_page").style.display = "none";
    document.getElementById("Work_Experience_page").style.display = "none";
    document.getElementById("Bank_Account_page").style.display = "none";
    document.getElementById("Employee_Immigration_page").style.display = "none";

    document.getElementById("basic_p").classList.add("active_emp_deiail_p");
    document.getElementById("em_Icontacts_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Social_profile_p").classList.remove("active_emp_deiail_p");
    document.getElementById("document_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Qualification_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Work_Experience_p").classList.remove("active_emp_deiail_p");
    document.getElementById("bank_acc_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Employee_Immigration_p").classList.remove("active_emp_deiail_p");


}
function open_Emergency_Contacts_page() {
    document.getElementById("Basic_info_page").style.display = "none";
    document.getElementById("Emergency_Contacts_page").style.display = "flex";
    document.getElementById("Social_Profile_page").style.display = "none";
    document.getElementById("Document_page").style.display = "none";
    document.getElementById("Qualification_page").style.display = "none";
    document.getElementById("Work_Experience_page").style.display = "none";
    document.getElementById("Bank_Account_page").style.display = "none";
    document.getElementById("Employee_Immigration_page").style.display = "none";

    document.getElementById("basic_p").classList.remove("active_emp_deiail_p");
    document.getElementById("em_Icontacts_p").classList.add("active_emp_deiail_p");
    document.getElementById("Social_profile_p").classList.remove("active_emp_deiail_p");
    document.getElementById("document_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Qualification_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Work_Experience_p").classList.remove("active_emp_deiail_p");
    document.getElementById("bank_acc_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Employee_Immigration_p").classList.remove("active_emp_deiail_p");
}
function open_Social_Profile_page() {
    document.getElementById("Basic_info_page").style.display = "none";
    document.getElementById("Emergency_Contacts_page").style.display = "none";
    document.getElementById("Social_Profile_page").style.display = "flex";
    document.getElementById("Document_page").style.display = "none";
    document.getElementById("Qualification_page").style.display = "none";
    document.getElementById("Work_Experience_page").style.display = "none";
    document.getElementById("Bank_Account_page").style.display = "none";
    document.getElementById("Employee_Immigration_page").style.display = "none";

    document.getElementById("basic_p").classList.remove("active_emp_deiail_p");
    document.getElementById("em_Icontacts_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Social_profile_p").classList.add("active_emp_deiail_p");
    document.getElementById("document_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Qualification_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Work_Experience_p").classList.remove("active_emp_deiail_p");
    document.getElementById("bank_acc_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Employee_Immigration_p").classList.remove("active_emp_deiail_p");
}
function open_Document_page() {
    document.getElementById("Basic_info_page").style.display = "none";
    document.getElementById("Emergency_Contacts_page").style.display = "none";
    document.getElementById("Social_Profile_page").style.display = "none";
    document.getElementById("Document_page").style.display = "flex";
    document.getElementById("Qualification_page").style.display = "none";
    document.getElementById("Work_Experience_page").style.display = "none";
    document.getElementById("Bank_Account_page").style.display = "none";
    document.getElementById("Employee_Immigration_page").style.display = "none";

    document.getElementById("basic_p").classList.remove("active_emp_deiail_p");
    document.getElementById("em_Icontacts_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Social_profile_p").classList.remove("active_emp_deiail_p");
    document.getElementById("document_p").classList.add("active_emp_deiail_p");
    document.getElementById("Qualification_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Work_Experience_p").classList.remove("active_emp_deiail_p");
    document.getElementById("bank_acc_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Employee_Immigration_p").classList.remove("active_emp_deiail_p");
}
function open_Qualification_page() {
    document.getElementById("Basic_info_page").style.display = "none";
    document.getElementById("Emergency_Contacts_page").style.display = "none";
    document.getElementById("Social_Profile_page").style.display = "none";
    document.getElementById("Document_page").style.display = "none";
    document.getElementById("Qualification_page").style.display = "flex";
    document.getElementById("Work_Experience_page").style.display = "none";
    document.getElementById("Bank_Account_page").style.display = "none";
    document.getElementById("Employee_Immigration_page").style.display = "none";

    document.getElementById("basic_p").classList.remove("active_emp_deiail_p");
    document.getElementById("em_Icontacts_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Social_profile_p").classList.remove("active_emp_deiail_p");
    document.getElementById("document_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Qualification_p").classList.add("active_emp_deiail_p");
    document.getElementById("Work_Experience_p").classList.remove("active_emp_deiail_p");
    document.getElementById("bank_acc_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Employee_Immigration_p").classList.remove("active_emp_deiail_p");
}
function open_Work_Experience_page() {
    document.getElementById("Basic_info_page").style.display = "none";
    document.getElementById("Emergency_Contacts_page").style.display = "none";
    document.getElementById("Social_Profile_page").style.display = "none";
    document.getElementById("Document_page").style.display = "none";
    document.getElementById("Qualification_page").style.display = "none";
    document.getElementById("Work_Experience_page").style.display = "flex";
    document.getElementById("Bank_Account_page").style.display = "none";
    document.getElementById("Employee_Immigration_page").style.display = "none";

    document.getElementById("basic_p").classList.remove("active_emp_deiail_p");
    document.getElementById("em_Icontacts_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Social_profile_p").classList.remove("active_emp_deiail_p");
    document.getElementById("document_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Qualification_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Work_Experience_p").classList.add("active_emp_deiail_p");
    document.getElementById("bank_acc_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Employee_Immigration_p").classList.remove("active_emp_deiail_p");
}
function open_Bank_Account_page() {
    document.getElementById("Basic_info_page").style.display = "none";
    document.getElementById("Emergency_Contacts_page").style.display = "none";
    document.getElementById("Social_Profile_page").style.display = "none";
    document.getElementById("Document_page").style.display = "none";
    document.getElementById("Qualification_page").style.display = "none";
    document.getElementById("Work_Experience_page").style.display = "none";
    document.getElementById("Bank_Account_page").style.display = "flex";
    document.getElementById("Employee_Immigration_page").style.display = "none";

    document.getElementById("basic_p").classList.remove("active_emp_deiail_p");
    document.getElementById("em_Icontacts_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Social_profile_p").classList.remove("active_emp_deiail_p");
    document.getElementById("document_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Qualification_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Work_Experience_p").classList.remove("active_emp_deiail_p");
    document.getElementById("bank_acc_p").classList.add("active_emp_deiail_p");
    document.getElementById("Employee_Immigration_p").classList.remove("active_emp_deiail_p");
}
function open_Employee_Immigration_page() {
    document.getElementById("Basic_info_page").style.display = "none";
    document.getElementById("Emergency_Contacts_page").style.display = "none";
    document.getElementById("Social_Profile_page").style.display = "none";
    document.getElementById("Document_page").style.display = "none";
    document.getElementById("Qualification_page").style.display = "none";
    document.getElementById("Work_Experience_page").style.display = "none";
    document.getElementById("Bank_Account_page").style.display = "none";
    document.getElementById("Employee_Immigration_page").style.display = "flex";

    document.getElementById("basic_p").classList.remove("active_emp_deiail_p");
    document.getElementById("em_Icontacts_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Social_profile_p").classList.remove("active_emp_deiail_p");
    document.getElementById("document_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Qualification_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Work_Experience_p").classList.remove("active_emp_deiail_p");
    document.getElementById("bank_acc_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Employee_Immigration_p").classList.add("active_emp_deiail_p");
}

// 

function open_Basic_Salary_page() {
    document.getElementById("Basic_Salary_page").style.display = "flex";
    document.getElementById("Allowances_page").style.display = "none";
    document.getElementById("Loan_page").style.display = "none";
    document.getElementById("Deductions_page").style.display = "none";
    document.getElementById("Other_Paymentn_page").style.display = "none";
    document.getElementById("Overtime_page").style.display = "none";

    document.getElementById("Basic_Salary_p").classList.add("active_emp_deiail_p");
    document.getElementById("Allowances_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Loan_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Deductions_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Other_Paymentn_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Overtime_p").classList.remove("active_emp_deiail_p");


}
function open_Allowances_page() {
    document.getElementById("Basic_Salary_page").style.display = "none";
    document.getElementById("Allowances_page").style.display = "flex";
    document.getElementById("Loan_page").style.display = "none";
    document.getElementById("Deductions_page").style.display = "none";
    document.getElementById("Other_Paymentn_page").style.display = "none";
    document.getElementById("Overtime_page").style.display = "none";

    document.getElementById("Basic_Salary_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Allowances_p").classList.add("active_emp_deiail_p");
    document.getElementById("Loan_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Deductions_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Other_Paymentn_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Overtime_p").classList.remove("active_emp_deiail_p");
}
function open_Loan_page() {
    document.getElementById("Basic_Salary_page").style.display = "none";
    document.getElementById("Allowances_page").style.display = "none";
    document.getElementById("Loan_page").style.display = "flex";
    document.getElementById("Deductions_page").style.display = "none";
    document.getElementById("Other_Paymentn_page").style.display = "none";
    document.getElementById("Overtime_page").style.display = "none";

    document.getElementById("Basic_Salary_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Allowances_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Loan_p").classList.add("active_emp_deiail_p");
    document.getElementById("Deductions_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Other_Paymentn_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Overtime_p").classList.remove("active_emp_deiail_p");
}
function open_Deductions_page() {
    document.getElementById("Basic_Salary_page").style.display = "none";
    document.getElementById("Allowances_page").style.display = "none";
    document.getElementById("Loan_page").style.display = "none";
    document.getElementById("Deductions_page").style.display = "flex";
    document.getElementById("Other_Paymentn_page").style.display = "none";
    document.getElementById("Overtime_page").style.display = "none";

    document.getElementById("Basic_Salary_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Allowances_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Loan_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Deductions_p").classList.add("active_emp_deiail_p");
    document.getElementById("Other_Paymentn_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Overtime_p").classList.remove("active_emp_deiail_p");
}
function open_Other_Paymentn_page() {
    document.getElementById("Basic_Salary_page").style.display = "none";
    document.getElementById("Allowances_page").style.display = "none";
    document.getElementById("Loan_page").style.display = "none";
    document.getElementById("Deductions_page").style.display = "none";
    document.getElementById("Other_Paymentn_page").style.display = "flex";
    document.getElementById("Overtime_page").style.display = "none";

    document.getElementById("Basic_Salary_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Allowances_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Loan_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Deductions_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Other_Paymentn_p").classList.add("active_emp_deiail_p");
    document.getElementById("Overtime_p").classList.remove("active_emp_deiail_p");
}
function open_Overtime_page() {
    document.getElementById("Basic_Salary_page").style.display = "none";
    document.getElementById("Allowances_page").style.display = "none";
    document.getElementById("Loan_page").style.display = "none";
    document.getElementById("Deductions_page").style.display = "none";
    document.getElementById("Other_Paymentn_page").style.display = "none";
    document.getElementById("Overtime_page").style.display = "flex";

    document.getElementById("Basic_Salary_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Allowances_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Loan_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Deductions_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Other_Paymentn_p").classList.remove("active_emp_deiail_p");
    document.getElementById("Overtime_p").classList.add("active_emp_deiail_p");
}




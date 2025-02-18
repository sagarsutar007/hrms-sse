<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\roughtController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\registrationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\user_details_Controller;
use App\Http\Controllers\formsController;
use App\Http\Controllers\update_userController;
use App\Http\Controllers\allAttendenceController;
use App\Http\Controllers\admin_settingsController;
use App\Http\Controllers\AllAdminsControllers;
use App\Http\Controllers\HR_setting_controller;
use App\Http\Controllers\shift_masterController;
use App\Http\Controllers\bulk_uoploade_controller;
use App\Http\Controllers\downloade_id_cards_controller;
use App\Http\Controllers\Salary_CalculationsController;
use App\Http\Controllers\forgot_password_controller;
use App\Http\Controllers\update_all_controller;
use App\Http\Controllers\leaveController;
use App\Http\Controllers\holiday_master_controller;
//attendance controller
use App\Http\Controllers\attendance;

route::get('/', [roughtController::class,'dashboard'])->name('dashboard');
Route::get('/absent-employee-list/{date?}', [RoughtController::class, 'absent_employee_list'])->name('absent_employee_list');
Route::get('/present-employee-list/{date?}', [RoughtController::class, 'present_employee_list'])->name('present_employee_list');
Route::get('/let-Commers-list/{date?}', [RoughtController::class, 'Let_commers_list'])->name('Let_commers_list');
Route::get('/attandance_100_list_api/{date?}', [RoughtController::class, 'attandance_100_list_api'])->name('attandance_100_list_api');
Route::get('/attandance_100_top_10_list_api/{date?}', [RoughtController::class, 'attandance_100_top_10_list_api'])->name('attandance_100_top_10_list_api');
Route::get('/association_time_api', [RoughtController::class, 'association_time_api'])->name('association_time_api');
Route::get('/top-10-present-list/{date?}', [RoughtController::class, 'top_10_present_list'])->name('top_10_present_list');
Route::get('/Default-Absentees-By-Month/{date?}', [RoughtController::class, 'Default_Absentees_By_Month'])->name('Default_Absentees_By_Month');
Route::get('/totall-salary-amount/{date?}', [RoughtController::class, 'totall_salary_amount'])->name('totall_salary_amount');
Route::get('/totall-salary-amount_department_wise/{date?}', [RoughtController::class, 'totall_salary_amount_department_wise'])->name('totall_salary_amount_department_wise');
Route::get('/totall-salary-amount_role_wise/{date?}', [RoughtController::class, 'totall_salary_amount_role_wise'])->name('totall_salary_amount_role_wise');
Route::get('/totall-salary-amount-employ-type-wise/{date?}', [RoughtController::class, 'totall_salary_amount_employ_wise'])->name('totall_salary_amount_employ_wise');

//
Route::get('/totall-salary-amount_year/{year?}', [RoughtController::class, 'totall_salary_amount_year'])->name('totall_salary_amount_year');
Route::get('/totall-salary-amount_department_wise_year/{year?}', [RoughtController::class, 'totall_salary_amount_department_wise_year'])->name('totall_salary_amount_department_wise_year');
Route::get('/totall-salary-amount_role_wise_year/{year?}', [RoughtController::class, 'totall_salary_amount_role_wise_year'])->name('totall_salary_amount_role_wise_year');
Route::get('/totall-salary-amount-employ-type-wise_year/{year?}', [RoughtController::class, 'totall_salary_amount_employ_wise_year'])->name('totall_salary_amount_employ_wise_year');




Route::get('/company_lable_data/{date?}', [RoughtController::class, 'company_lable_data'])->name('company_lable_data');

Route::get('/role_lable_data/{date?}', [RoughtController::class, 'role_lable_data'])->name('role_lable_data');

Route::get('/department_lable_data/{date?}', [RoughtController::class, 'department_lable_data'])->name('department_lable_data');

Route::get('/emptype_type_lable_data/{date?}', [RoughtController::class, 'emptype_type_lable_data'])->name('emptype_type_lable_data');


Route::get('/company_data_all_parms/{year}/{month}/{role}/{department}/{emp_type}', [RoughtController::class, 'company_data_all_parms'])->name('company_data_all_parms');
Route::get('/company_data_all_parms_2/{date}/{role}/{department}/{emp_type}', [RoughtController::class, 'company_data_all_parms_2'])->name('company_data_all_parms_2');




Route::get('/login/{Attendance_id?}',[loginController::class,'login_view'])->name('login');
Route::post('/login',[loginController::class,'login_req'])->name('login_req');

Route::get('/logout',[loginController::class,'logout'])->name('logout');

Route::get('/registration',[registrationController::class,'add_user_view'])->name('add_user_view');
Route::get('/add-admin',[registrationController::class,'add_admin_view'])->name('add_admin_view');
Route::get('/add-HR',[registrationController::class,'add_HR_view'])->name('add_HR_view');
Route::get('/add-guard',[registrationController::class,'add_guard'])->name('add_guard_view');
Route::get('/add-super-admin',[registrationController::class,'add_super_admin_view'])->name('add_super_admin_view');
Route::post('/registration',[registrationController::class,'add_user'])->name('add_user');
Route::post('/Add-Users',[registrationController::class,'Add_Users'])->name('Add_Users');
Route::get('/Forgot-Password',[forgot_password_controller::class,'forgot_password_view'])->name('forgot_password_view');
Route::post('/Forgot-Password',[forgot_password_controller::class,'forgot_password'])->name('forgot_password');


Route::get('/employees',[EmployeeController::class,'view_employee'])->name('view_employee');
Route::get('/swipe-list',[EmployeeController::class,'view_swipe_users'])->name('view_swipe_users');
Route::get('/view-details/{id}',[EmployeeController::class,'view_details'])->name('view_details');
Route::get('/all-attendance-p',[allAttendenceController::class,'all_attendence'])->name('all_attendence');
Route::post('/all-attendance-p',[allAttendenceController::class,'search_attendence'])->name('search_attendence');
Route::post('/delete-attendence',[allAttendenceController::class,'delete_attendence'])->name('delete_attendence');
Route::post('/employees-limit',[EmployeeController::class,'set_limit'])->name('set_limit');
Route::get('/employees-limit',[EmployeeController::class,'set_limit'])->name('set_limit');

Route::get('/calendar',[EmployeeController::class,'calendar'])->name('calendar');

Route::get('/user-details/{id}',[user_details_Controller::class,'one_user'])->name('one_user');

//users ke liye
Route::get('/all-users',[user_details_Controller::class,'all_users'])->name('all_users');
Route::get('/all-users-api/{limit}',[user_details_Controller::class,'all_users_api'])->name('all_users_api');
Route::get('/all-users-short-api/{limit}/{short_by}/{method}',[user_details_Controller::class,'all_users_short_api'])->name('all_users_short_api');
Route::get('/all-users-search-api/{limit}/{input}',[user_details_Controller::class,'all_users_search_api'])->name('all_users_search_api');
Route::get('/one-user-data-with-id/{id}',[user_details_Controller::class,'one_user_data_with_id'])->name('one_user_data_with_id');
Route::get('/delet-user-with-id/{id}',[user_details_Controller::class,'delet_user_with_id'])->name('delet_user_with_id');

//lock arrer data
Route::get('/luck-arrear-data/{emp_id}/{arrear_month}/{paid_amount}/{net_amount}/{OT_Amount}/{OT_Hours}',[user_details_Controller::class,'lock_arrear_data'])->name('lock_arrear_data');
Route::get('/luck-one-clic-arrear-data/{arrear_month}',[user_details_Controller::class,'lock_one_click_arrear_data'])->name('lock_one_click_arrear_data');

//Route::get('/user-details/{id}',[user_details_Controller::class,'single_user'])->name('single_user');
Route::post('/user-details',[user_details_Controller::class,'form_request'])->name('form_request');
Route::post('/employees',[EmployeeController::class,'search_employee'])->name('search_employee');
Route::post('/delete-employee',[EmployeeController::class,'delete_employee'])->name('delete_employee');
Route::post('/add-holiday',[EmployeeController::class,'add_holiday'])->name('add_holiday');
Route::get('/emergency-contact/{id}',[formsController::class,'Emergency_Contact'])->name('Emergency_Contact');
Route::get('/edit-emergency-contact/{id}',[formsController::class,'edit_Emergency_Contact'])->name('edit_Emergency_Contact');
Route::get('/delete-emergency-contact/{id}',[formsController::class,'delete_Emergency_Contact'])->name('delete_Emergency_Contact');

//
Route::get('/qualifications-view/{id}',[formsController::class,'qualifications'])->name('qualifications');
Route::get('/edit-qualifications/{id}',[formsController::class,'edit_qualifications'])->name('edit_qualifications');
Route::get('/delete-qualifications/{id}',[formsController::class,'delete_qualifications'])->name('delete_qualifications');

// Document
Route::get('/document-view/{id}',[formsController::class,'document'])->name('document');
Route::get('/edit-document/{id}',[formsController::class,'edit_document'])->name('edit_document');
Route::get('/delete-document/{id}',[formsController::class,'delete_document'])->name('delete_document');

//Work_Experience
Route::get('/Work_Experience/{id}',[formsController::class,'Work_Experience'])->name('Work_Experience');
Route::get('/edit-Work_Experience/{id}',[formsController::class,'edit_Work_Experience'])->name('edit_Work_Experience');
Route::get('/delete-Work_Experience/{id}',[formsController::class,'delete_Work_Experience'])->name('delete_Work_Experience');

//Bank_Account
Route::get('/bank-account/{id}',[formsController::class,'Bank_Account'])->name('Work_Bank_Account');
Route::get('/edit-bank-account/{id}',[formsController::class,'edit_Bank_Account'])->name('edit_Bank_Account');
Route::get('/delete-bank-account/{id}',[formsController::class,'delete_Bank_Account'])->name('delete_Bank_Account');

//Basic_Salary
Route::get('/basic-salary/{id}',[formsController::class,'Basic_Salary'])->name('Basic_Salary');
Route::get('/edit-basic-salary/{id}',[formsController::class,'edit_Basic_Salary'])->name('edit_Basic_Salary');
Route::get('/delete-basic-salary/{id}',[formsController::class,'delete_Basic_Salary'])->name('delete_Basic_Salary');

//Basic_Salary
Route::get('/alloweance/{id}',[formsController::class,'alloweance'])->name('alloweance');
Route::get('/edit-alloweance/{id}',[formsController::class,'edit_alloweance'])->name('edit_alloweance');
Route::get('/delete-alloweance/{id}',[formsController::class,'delete_alloweance'])->name('delete_alloweance');
Route::get('/delete-holiday/{id}',[formsController::class,'delete_holiday'])->name('delete_holiday');

//loan
Route::get('/Loan/{id}',[formsController::class,'Loan'])->name('Loan');
Route::get('/edit-loan/{id}',[formsController::class,'edit_loan'])->name('edit_loan');
Route::get('/Deductions/{id}',[formsController::class,'Deductions'])->name('Deductions');
Route::get('/edit-deductions/{id}',[formsController::class,'edit_deductions'])->name('edit_deductions');
Route::get('/deductions-api/{limit}',[formsController::class,'view_deductions_api'])->name('view_deductions_api');

Route::get('/other-payments/{id}',[formsController::class,'Other_Payment_function'])->name('Other_Payment_function');


Route::get('/over-time/{id}',[formsController::class,'over_time'])->name('over_time');
Route::get('/edit-over-time/{id}',[formsController::class,'edit_over_time'])->name('edit_over_time');

Route::get('/leave-view/{id}',[formsController::class,'leave_view'])->name('leave_view');
Route::get('/award-view/{id}',[formsController::class,'award_view'])->name('award_view');
Route::get('/travel-view/{id}',[formsController::class,'Travel_view'])->name('Travel_view');
Route::get('/training-view/{id}',[formsController::class,'Training_view'])->name('Training_view');


// settings and permissions
Route::get('/super-admin-settings',[admin_settingsController::class,'super_admin_settings'])->name('super_admin_settings');
Route::get('/admin-settings/{role_name}',[admin_settingsController::class,'admin_settings'])->name('admin_settings');
Route::get('/HR-settings',[admin_settingsController::class,'HR_settings'])->name('HR_settings');
Route::get('/delete-employee-type/{id}',[admin_settingsController::class,'delete_employee_type'])->name('delete_employee_type');
Route::get('/delete-department-type/{id}',[admin_settingsController::class,'delete_department_type'])->name('delete_department_type');
Route::get('/delete-role/{id}',[admin_settingsController::class,'delete_role'])->name('delete_role');
Route::get('/delete-shift/{id}',[admin_settingsController::class,'delete_shift'])->name('delete_shift');
//delet any data
Route::get('/delete/{id}/{table_name}',[admin_settingsController::class,'delete_any_data'])->name('delete_any_data');

Route::get('/edit-employee-type/{id}',[admin_settingsController::class,'edit_employee_type'])->name('edit_employee_type');
Route::get('/edit-role/{id}',[admin_settingsController::class,'edit_role'])->name('edit_role');
Route::get('/edit-shift/{id}',[admin_settingsController::class,'edit_shift'])->name('edit_shift');
Route::post('/edit-employee-type',[admin_settingsController::class,'update_employee_type'])->name('update_employee_type');
Route::post('/edit-role',[admin_settingsController::class,'update_role'])->name('update_role');
Route::post('/edit-shift',[admin_settingsController::class,'update_shift'])->name('update_shift');

// admin
Route::get('/all-admins',[AllAdminsControllers::class,'all_admins'])->name('all_admins');
Route::post('/all-admins',[AllAdminsControllers::class,'search_users'])->name('search_users');
Route::get('/edit-permissions/{employee_id}',[AllAdminsControllers::class,'edit_permissions_view'])->name('edit_permissions_view');
Route::post('/edit-permissions}',[AllAdminsControllers::class,'edit_permissions'])->name('edit_permissions');
Route::post('/edit-admin-permissions',[AllAdminsControllers::class,'edit_admin_permissions'])->name('edit_admin_permissions');
Route::get('/admin',[AllAdminsControllers::class,'admin'])->name('admin');

//HR
Route::get('/HR-page',[HR_setting_controller::class,'HR_page'])->name('HR_page');
Route::post('/add-role-form',[HR_setting_controller::class,'add_role_form'])->name('add_role_form');
Route::post('/add-Department-form',[HR_setting_controller::class,'add_Department_form'])->name('add_Department_form');
Route::post('/add-Leave-Master-Form',[HR_setting_controller::class,'add_Leave_Master_Form'])->name('add_Leave_Master_Form');
Route::get('/delete-Leave-Master-Form/{id}',[HR_setting_controller::class,'delet_Leave_Master_Form'])->name('delete_Leave_Master_Form');
Route::get('/Leave-Master-view/{id}',[HR_setting_controller::class,'Leave_Master_view'])->name('Leave_Master_view');
Route::get('/depaetment-Master-view/{id}',[HR_setting_controller::class,'depaetment_Master_view'])->name('depaetment_Master_view');
Route::post('/add-employee-type',[HR_setting_controller::class,'add_employee_type'])->name('add_employee_type');
Route::post('/add-shift',[shift_masterController::class,'add_shift'])->name('add_shift');
Route::post('/change-Password',[HR_setting_controller::class,'change_Password'])->name('change_Password');
Route::get('/change-Password/{Employee_id}',[forgot_password_controller::class,'change_Password_view'])->name('change_Password_view');
Route::post('/change-Password-with-link',[forgot_password_controller::class,'change_Password_with_link'])->name('change_Password_with_link');

//update fields
Route::post('/update-basic-info',[update_userController::class,'update_basic_info'])->name('update_basic_info');
Route::post('/edit-emergency-contact',[update_userController::class,'edit_emergency_contact'])->name('edit_emergency_contact');
Route::post('/update-Social-Profile',[update_userController::class,'update_Social_Profile'])->name('update_Social_Profile');
Route::post('/edit-document',[update_userController::class,'update_document'])->name('update_document');
Route::post('/edit-qualifications',[update_userController::class,'update_qualifications'])->name('update_qualifications');
Route::post('/edit-Work_Experience',[update_userController::class,'update_Work_Experience'])->name('update_Work_Experience');
Route::post('/edit-bank-account',[update_userController::class,'update_bank_account'])->name('update_bank_account');
Route::post('/update-profile-image',[update_userController::class,'update_Profile_image'])->name('update_Profile_image');
Route::post('/edit-basic-salary',[update_userController::class,'basic_salary_update'])->name('basic_salary_update');
Route::post('/edit-alloweance',[update_userController::class,'alloweance_update'])->name('alloweance_update');
Route::post('/edit-loan',[update_userController::class,'update_loan'])->name('update_loan');
Route::post('/edit-deductions',[update_userController::class,'update_deductions'])->name('update_deductions');
Route::post('/edit-other-payments',[update_userController::class,'update_other_payments'])->name('update_other_payments');


Route::get('/uploade-test-image',[update_userController::class,'uploade_test_image_view'])->name('uploade_test_image_view');
Route::post('/uploade-test-image',[update_userController::class,'uploade_test_image'])->name('uploade_test_image');

//attendance api
Route::get('/push-attendance/{employee_id}/{inserter_id}',[attendance::class,'insert_attendance2'])->name('insert_attendance2');
//attendance api2
Route::get('/push-attendance2/{employee_id}/{inserter_id}',[attendance::class,'insert_attendance'])->name('insert_attendance');



//bulk uploade
Route::get('/bulk-uploade',[bulk_uoploade_controller::class,'bulk_uoploade_view'])->name('bulk_uoploade_view');
Route::post('/bulk-uploade',[bulk_uoploade_controller::class,'bulk_uoploade_request'])->name('bulk_uoploade_request');
//downloade Id cards
Route::get('/downloade-Id-cards',[downloade_id_cards_controller::class,'downloade_Id_cards'])->name('downloade_Id_cards');
Route::post('/downloade-Id-cards',[downloade_id_cards_controller::class,'limit_for_daownload_id'])->name('limit_for_daownload_id');
Route::get('/downloade-selected-id-cards/{search_input}',[downloade_id_cards_controller::class,'downloade_selected_id_cards'])->name('downloade_selected_id_cards');
Route::get('/dounloade-user-id-catd/{id}',[downloade_id_cards_controller::class,'dounloade_user_id_catd'])->name('dounloade_user_id_catd');
Route::get('/salary-calculations',[Salary_CalculationsController::class,'Salary_Calculations'])->name('Salary_Calculations');
Route::get('/salary-calculations-api/{limit}/{month}/{year}',[Salary_CalculationsController::class,'Salary_Calculations_api'])->name('Salary_Calculations_api');
Route::get('/salary-calculations-short-api/{limit}/{month}/{year}/{short_by}/{method}',[Salary_CalculationsController::class,'salary_calculations_short_api'])->name('salary_calculations_short_api');
Route::get('/salary-calculations-short-search-api/{limit}/{month}/{year}/{search_inp}',[Salary_CalculationsController::class,'Salary_Calculations_search_api'])->name('Salary_Calculations_search_api');
// report
Route::get('/report-1',[Salary_CalculationsController::class,'report_1'])->name('report_1');


//update data
Route::get('/edit-leave/{id}',[update_all_controller::class,'edit_leave'])->name('edit_leave');
Route::get('/edit-award/{id}',[update_all_controller::class,'edit_award'])->name('edit_role');
Route::get('/edit-travel/{id}',[update_all_controller::class,'edit_travel'])->name('edit_travel');
Route::get('/edit-training/{id}',[update_all_controller::class,'edit_training'])->name('edit_training');
Route::get('/edit-ticket/{id}',[update_all_controller::class,'edit_ticket'])->name('edit_ticket');
Route::get('/edit-transfer/{id}',[update_all_controller::class,'edit_transfer'])->name('edit_transfer');
Route::get('/edit-promotion/{id}',[update_all_controller::class,'edit_promotion'])->name('edit_promotion');
Route::get('/edit-complaints/{id}',[update_all_controller::class,'edit_complaints'])->name('edit_complaints');
Route::get('/edit-warning/{id}',[update_all_controller::class,'edit_warning'])->name('edit_warning');
Route::get('/edit-projects/{id}',[update_all_controller::class,'edit_projects'])->name('edit_projects');
Route::get('/edit-tasks/{id}',[update_all_controller::class,'edit_tasks'])->name('edit_tasks');
Route::get('/edit-payslip/{id}',[update_all_controller::class,'edit_payslip'])->name('edit_payslip');
Route::get('/edit-attendance/{id}',[update_all_controller::class,'edit_attendance'])->name('edit_attendance');
Route::get('/view-attendance/{id}',[update_all_controller::class,'view_attendance'])->name('view_attendance');
Route::get('/edit-qualification/{id}',[update_all_controller::class,'edit_qualification'])->name('edit-qualification');
Route::get('/edit-other-payments/{id}',[update_all_controller::class,'edit_Other_Payment'])->name('edit_Other_Payment');
Route::get('/edit-attamdance-data/{id}',[update_all_controller::class,'edit_attamdance_data'])->name('edit_attamdance_data');

//view
Route::get('/view-ticket/{id}',[update_all_controller::class,'view_ticket'])->name('view_ticket');
Route::get('/view-transfer/{id}',[update_all_controller::class,'view_transfer'])->name('view_transfer');
Route::get('/view-promotion/{id}',[update_all_controller::class,'view_promotion'])->name('view_promotion');
Route::get('/view-complaints/{id}',[update_all_controller::class,'view_complaints'])->name('view_complaints');
Route::get('/view-warning/{id}',[update_all_controller::class,'view_warning'])->name('view_warning');
Route::get('/view-projects/{id}',[update_all_controller::class,'view_projects'])->name('view_projects');
Route::get('/view-tasks/{id}',[update_all_controller::class,'view_tasks'])->name('edit-qualification');
Route::get('/view-payslip/{id}',[update_all_controller::class,'view_payslip'])->name('view_payslip');
Route::post('/update-leave',[update_all_controller::class,'update_leave'])->name('update_leave');
Route::post('/update-award',[update_all_controller::class,'update_award'])->name('update_award');
Route::post('/update-travel',[update_all_controller::class,'update_travel'])->name('update_travel');
Route::post('/update-training',[update_all_controller::class,'update_training'])->name('update_training');
Route::post('/update-ticket',[update_all_controller::class,'update_ticket'])->name('update_ticket');
Route::post('/update-transfer',[update_all_controller::class,'update_transfer'])->name('update_transfer');
Route::post('/update-promotion',[update_all_controller::class,'update_promotion'])->name('update_promotion');
Route::post('/update-complaints',[update_all_controller::class,'update_complaints'])->name('update_complaints');
Route::post('/update-warning',[update_all_controller::class,'update_warning'])->name('update_warning');
Route::post('/update-projects',[update_all_controller::class,'update_projects'])->name('update_projects');
Route::post('/update-tasks',[update_all_controller::class,'update_tasks'])->name('update_tasks');
Route::post('/update-payslip',[update_all_controller::class,'update_payslip'])->name('update_payslip');
Route::post('/update-attendance',[update_all_controller::class,'update_attendance'])->name('update_attendance');
Route::post('/update-qualification',[update_all_controller::class,'update_qualification'])->name('update_qualification');
Route::post('/edit-attamdance-data',[update_all_controller::class,'update_attamdance_data'])->name('update_attamdance_data');

Route::post('/edit-employee-type',[admin_settingsController::class,'update_employee_type'])->name('update_employee_type');
Route::post('/edit-role',[admin_settingsController::class,'update_role'])->name('update_role');
Route::post('/edit-shift',[admin_settingsController::class,'update_shift'])->name('update_shift');
Route::get('/total-leave',[leaveController::class,'total_leave'])->name('total_leave');
Route::get('/total-deducations',[leaveController::class,'total_deducations'])->name('total_deducations');
Route::get('/total-Loan',[leaveController::class,'total_Loan'])->name('total_Loan');
Route::post('/total-leave',[leaveController::class,'search_leave'])->name('search_leave');

//reports
Route::get('/total-salary',[leaveController::class,'total_salary'])->name('total_salary');
Route::get('/Absent-List',[leaveController::class,'Absent_List'])->name('Absent_List');
Route::get('/Defult-Absent-List',[leaveController::class,'Defult_Absent_List'])->name('Defult_Absent_List');
Route::get('/Present-List',[leaveController::class,'Present_List'])->name('Present_List');
Route::get('/Let-Commers-List',[leaveController::class,'Let_Commers_List'])->name('Let_Commers_List');
Route::get('/attandance-100%-list',[leaveController::class,'attandance_100_list'])->name('attandance_100_list');
Route::get('/attandance-100%-top-10-list',[leaveController::class,'attandance_100_top_10_list'])->name('attandance_100_top_10_list');
Route::get('/association-time',[leaveController::class,'association_time'])->name('association_time');
Route::get('/total_salary_summary',[leaveController::class,'total_salary_summary'])->name('total_salary_summary');

// view All Reports
route::get('/all-attendance', [roughtController::class,'all_attendance'])->name('all_attendance');
route::get('/all-holidays', [roughtController::class,'all_holidays'])->name('all_holidays');
route::get('/all-leave', [roughtController::class,'all_leave'])->name('all_leave');
route::get('/all-travel', [roughtController::class,'all_travel'])->name('all_travel');
route::get('/all-tranings', [roughtController::class,'all_tranings'])->name('all_tranings');
route::get('/all-projects', [roughtController::class,'all_projects'])->name('all_projects');
route::get('/all-tasks', [roughtController::class,'all_tasks'])->name('all_tasks');
route::get('/all-allowances', [roughtController::class,'all_allowances'])->name('all_allowances');
route::get('/all-loan', [roughtController::class,'all_loan'])->name('all_loan');
route::get('/all-deductions', [roughtController::class,'all_deductions'])->name('all_deductions');
route::get('/all-other-payment', [roughtController::class,'all_other_payment'])->name('all_other_payment');
route::get('/all-overtime', [roughtController::class,'all_overtime'])->name('all_overtime');
route::get('/all-award', [roughtController::class,'all_award'])->name('all_award');
route::get('/all-ticket', [roughtController::class,'all_ticket'])->name('all_ticket');
route::get('/all-transfer', [roughtController::class,'all_transfer'])->name('all_transfer');
route::get('/all-promotion', [roughtController::class,'all_promotion'])->name('all_promotion');
route::get('/all-complaints', [roughtController::class,'all_complaints'])->name('all_complaints');
route::get('/all-warning', [roughtController::class,'all_warning'])->name('all_warning');
route::get('/all-payslip', [roughtController::class,'all_payslip'])->name('all_payslip');
route::get('/all-swap-day-list', [roughtController::class,'all_swap_day_list'])->name('all_swap_day_list');
route::get('/  ', [roughtController::class,'holiday_report'])->name('holiday_report');

//Search All Reports
route::post('/all-attendance', [roughtController::class,'all_attendance_search'])->name('all_attendance_search');
route::post('/all-holidays', [roughtController::class,'all_holidays_search'])->name('all_holidays_search');
route::post('/all-leave', [roughtController::class,'all_leave_search'])->name('all_leave_search');
route::post('/all-travel', [roughtController::class,'all_travel_search'])->name('all_travel_search');
route::post('/all-tranings', [roughtController::class,'all_tranings_search'])->name('all_tranings_search');
route::post('/all-projects', [roughtController::class,'all_projects_search'])->name('all_projects_search');
route::post('/all-tasks', [roughtController::class,'all_tasks_search'])->name('all_tasks_search');
route::post('/all-allowances', [roughtController::class,'all_allowances_search'])->name('all_allowances_search');
route::post('/all-loan', [roughtController::class,'all_loan_search'])->name('all_loan_search');
route::post('/all-deductions', [roughtController::class,'all_deductions_search'])->name('all_deductions_search');
route::post('/all-other-payment', [roughtController::class,'all_other_payment_search'])->name('all_other_payment_search');
route::post('/all-overtime', [roughtController::class,'all_overtime_search'])->name('all_overtime_search');
route::post('/all-award', [roughtController::class,'all_award_search'])->name('all_award_search');
route::post('/all-ticket', [roughtController::class,'all_ticket_search'])->name('all_ticket_search');
route::post('/all-transfer', [roughtController::class,'all_transfer_search'])->name('all_transfer_search');
route::post('/all-promotion', [roughtController::class,'all_promotion_search'])->name('all_promotion_search');
route::post('/all-complaints', [roughtController::class,'all_complaints_search'])->name('all_complaints_search');
route::post('/all-warning', [roughtController::class,'all_warning_search'])->name('all_warning_search');

route::post('/all-payslip', [roughtController::class,'all_payslip_search'])->name('all_payslip_search');
route::get('/single_account_data/{id}', [roughtController::class,'single_account_data'])->name('single_account_data');


//
Route::get('/attendance-response/{id}',[downloade_id_cards_controller::class,'attendance_response'])->name('attendance_response');
Route::get('/mark-as-absent/{id}',[attendance::class,'mark_as_absent'])->name('mark_as_absent');



//apis
// attendance reportcapis

Route::get('/get-attandence-data-api',[attendance::class,'get_attandence_data_api'])->name('get_attandence_data_api');
Route::get('/get-attandence-data-api/{short_by_key}/{method}',[attendance::class,'get_attandence_data_api_short_by'])->name('get_attandence_data_api_short_by');
Route::get('/get-attandence-data-search-api/{search_by}',[attendance::class,'get_attandence_data_search_api'])->name('get_attandence_data_search_api');
Route::get('/get-attandence-single-data-api/{id}/{date}',[attendance::class,'get_single_attandence_data_api'])->name('get_single_attandence_data_api');


// all attandance apis
Route::get('/all-attandence-api/{limit}',[allAttendenceController::class,'all_attandence_api'])->name('all_attandence_api');
Route::get('/all-attandence-short-api/{limit}/{short_by}/{method}',[allAttendenceController::class,'all_attandence_short_api'])->name('all_attandence_short_api');
Route::get('/all-attandence-search-api/{limit}/{search_inp}',[allAttendenceController::class,'all_attandence_search_api'])->name('all_attandence_search_api');



//all-swap-day-list-api

Route::get('/all-swap-day-list/{limit}',[allAttendenceController::class,'all_swap_day_list_api'])->name('all_swap_day_list_api');
Route::get('/all-swap-day-list-short-api/{limit}/{short_by}/{method}',[allAttendenceController::class,'all_swap_day_list_short_api'])->name('all_swap_day_list_short_api');
Route::get('/all-swap-day-list-search-api/{limit}/{search_inp}',[allAttendenceController::class,'all_swap_day_list_search_api'])->name('all_swap_day_list_search_api');
Route::get('/delete-swap-day-api/{id}',[allAttendenceController::class,'delete_swap_day_api'])->name('delete_swap_day_api');



//employee data apis
Route::get('/all-employees-api/{limit}',[EmployeeController::class,'all_employees_api'])->name('all_employees_api');
Route::get('/show-all-employees-api',[EmployeeController::class,'show_all_employees_api'])->name('show_all_employees_api');
Route::get('/show-all-employees-api/{weak_off_day}',[EmployeeController::class,'show_all_employees_weeak_off_day_api'])->name('show_all_employees_weeak_off_day_api');
Route::get('/all-employees-short-api/{limit}/{short_by}/{method}',[EmployeeController::class,'all_employees_short_api'])->name('all_employees_short_api');
Route::get('/all-employees-search-api/{limit}/{search_inp}',[EmployeeController::class,'all_employees_search_api'])->name('all_employees_search_api');
Route::get('/search-when-holiday-selected/{select_date_day}/{search_inp}',[EmployeeController::class,'search_when_holiday_selected'])->name('search_when_holiday_selected');
Route::get('/all-employees-search-wid-limit_api/{search_inp}',[EmployeeController::class,'all_employees_search_wid_limit_api'])->name('all_employees_search_wid_limit_api');


Route::get('/col-visibility/{page_name}',[EmployeeController::class,'col_visibility'])->name('col_visibility');
Route::get('/update-col-visibility/{page_name}/{col_number}/{col_value}',[EmployeeController::class,'update_col_visibility'])->name('update_col_visibility');

//all_leaves api

Route::get('/all-leaves-api/{limit}',[leaveController::class,'all_leaves_api'])->name('all_leaves_api');
Route::get('/all-leaves-short-api/{limit}/{short_by}/{method}',[leaveController::class,'all_leaves_short_api'])->name('all_leaves_short_api');
Route::get('/deducations-short-api/{limit}/{short_by}/{method}',[leaveController::class,'deducations_short_api'])->name('deducations_short_api');
Route::get('/all-leaves-search-api/{limit}/{search_inp}',[leaveController::class,'all_leaves_search_api'])->name('all_leaves_search_api');
Route::get('/search-deductions-api/{limit}/{search_inp}',[leaveController::class,'search_deductions'])->name('search_deductions');

//attandence details api
Route::get('/all-attandance-detail-with-let-api',[allAttendenceController::class,'all_attandance_detail_with_let_api'])->name('all_attandance_detail_with_let_api');
Route::get('/Get-Employee-Type-Wise-Current-Date-Data-api',[allAttendenceController::class,'Get_Employee_Type_Wise_Current_Date_Data_api'])->name('Get_Employee_Type_Wise_Current_Date_Data_api');
Route::get('/Late-Commer-Current-Date-Data-api',[allAttendenceController::class,'Late_Commer_Current_Date_Data_api'])->name('Late_Commer_Current_Date_Data_api');
Route::get('/Daily-Ot-Hrs-api',[allAttendenceController::class,'daily_ot_hrs_api'])->name('daily_ot_hrs_api');
//all_holiday api
//Route::get('/deducations-short-api/{limit}/{short_by}/{method}',[leaveController::class,'deducations_short_api'])->name('deducations_short_api');
//Route::get('/search-deductions-api/{limit}/{search_inp}',[leaveController::class,'search_deductions'])->name('search_deductions');

//loan api
Route::get('/all-holiday-api/{limit}',[leaveController::class,'all_holiday_api'])->name('all_holiday_api');
Route::get('/all-holiday-short-api/{limit}/{short_by}/{method}',[leaveController::class,'all_holiday_short_api'])->name('all_holiday_short_api');
Route::get('/all-holiday-search-api/{limit}/{search_inp}',[leaveController::class,'all_holiday_search_api'])->name('all_holiday_search_api');

Route::get('/add-holiday-api/{holiday_name}/{holiday_date}/{swipe_date}/{public_holiday}',[holiday_master_controller::class,'add_holiday_api'])->name('add_holiday_api');
Route::get('/for-me',[roughtController::class,'for_me'])->name('for_me');
// Route::post('/genrate-attandance',[allAttendenceController::class,'insertAttendanceForAll'])->name('insertAttendanceForAll');
Route::get('/genrate-attandance/{start_date}/{end_date}/{employeeID}',[allAttendenceController::class,'insertAttendanceForAll'])->name('insertAttendanceForAll');

//save salary data api
Route::post('/save-salary-data',[Salary_CalculationsController::class,'save_salary_data'])->name('save_salary_data');


//view apis

Route::get('/bank_account_api/{Employee_id}',[roughtController::class,'bank_account_api'])->name('bank_account_api');
Route::get('/basic_salary_api/{Employee_id}',[roughtController::class,'basic_salary_api'])->name('basic_salary_api');
Route::get('/allowances_view_api/{Employee_id}',[roughtController::class,'allowances_view_api'])->name('allowances_view_api');
Route::get('/loan_view_api/{Employee_id}',[roughtController::class,'loan_view_api'])->name('loan_view_api');
Route::get('/Deductions_view_api/{Employee_id}',[roughtController::class,'Deductions_view_api'])->name('Deductions_view_api');
Route::get('/Leave_view_api/{Employee_id}',[roughtController::class,'Leave_view_api'])->name('Leaves_view_api');
Route::get('/Attendance_view_user_api/{Employee_id}',[roughtController::class,'Attendance_view_api'])->name('Attendance_view_api');

Route::post('/add-arrear-api',[roughtController::class,'add_arrear_api'])->name('add_arrear_api');



// Route::get('/user-details', function () {
//     return view('user_details');
// });
Route::get('/attendance', function () {
    return view('attendance');
});
Route::get('/leaves', function () {
    return view('leaves');
});

Route::get('/guard', function () {
    return view('guard_view');
});

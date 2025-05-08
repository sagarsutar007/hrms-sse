<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class downloade_id_cards_controller extends Controller
{


    public function downloade_Id_cards($id = null) {
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');

        if(isset($EmployeesID)) {
            $user_data = DB::table('all_users')
                ->join('role_masrer', 'role_masrer.id', '=', 'all_users.Role')
                ->select('all_users.*', 'role_masrer.roles')
                ->where('all_users.role', '>', 1);

            // Apply filter only if $id is provided
            if ($id !== null && $id !== 'all') {
                $selectedIds = explode(',', $id);
                $user_data = $user_data->whereIn('all_users.id', $selectedIds);
            }

            $user_data = $user_data->get();

            return view("downloade_Id_cards")
                ->with('user_data', $user_data)
                ->with('role', $role)
                ->with('selectedIds', $id !== null && $id !== 'all' ? explode(',', $id) : []);
        } else {
            return redirect()->route('login');
        }
    }


    // Updated method to handle both single and multiple IDs
    public function dounloade_user_id_catd($id) {
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');

        if(isset($EmployeesID)) {
            // Split the ID parameter by comma to handle multiple IDs
            $ids = explode(',', $id);

            // Fetch all the requested users
            $user_data = DB::table('all_users')
                ->join('role_masrer', 'role_masrer.id', '=', 'all_users.Role')
                ->select('all_users.*', 'role_masrer.roles')
                ->whereIn('all_users.id', $ids)
                ->get();

            // Check if any users were found
            if($user_data->isEmpty()) {
                return back()->with('error', 'No users found');
            }

            return view("dounloade_user_id_catd")
                ->with('user_data', $user_data)
                ->with('role', $role);
        } else {
            return redirect()->route('login');
        }
    }

    public function attendance_response(Request $req) {
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');

        if(isset($EmployeesID)) {
            $user_data = DB::table('all_users')
                ->join('role_masrer', 'role_masrer.id', '=', 'all_users.Role')
                ->select('all_users.*', 'role_masrer.roles')
                ->where('all_users.Employee_id', $req->id)
                ->get();

            $response_message = '';
            $color_name = "black";
            $att_date = now()->toDateString();
            $all_attendance_data = DB::table('attendance_info')
                ->where('Employee_id', $req->id)
                ->where('attendance_Date', $att_date)
                ->get();

            if($all_attendance_data) {
                $all_attendance_count = count($all_attendance_data);

                if($all_attendance_count % 2 == 0) {
                    $response_message = 'Punch Out Ok';
                    $color_name = "red";
                } else {
                    $response_message = 'Punch In Ok';
                    $color_name = "Green";
                }
            }

            return view("attendance_response")
                ->with('user_data', $user_data)
                ->with('response_message', $response_message)
                ->with('color_name', $color_name)
                ->with('role', $role);
        } else {
            return redirect()->route('login');
        }
    }

    public function limit_for_daownload_id(Request $req) {
        $search_input = $req->search_input;
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');

        if(!isset($EmployeesID)) {
            return redirect()->route('login');
        }

        // Check if input contains commas (multiple employee IDs)
        if(strpos($search_input, ',') !== false) {
            $employee_ids = array_map('trim', explode(',', $search_input));

            $user_data = DB::table('all_users')
                ->join('role_masrer', 'role_masrer.id', '=', 'all_users.Role')
                ->select('all_users.*', 'role_masrer.roles')
                ->whereIn('all_users.Employee_id', $employee_ids)
                ->get();
        } else {
            // Single search term
            $user_data = DB::table('all_users')
                ->join('role_masrer', 'role_masrer.id', '=', 'all_users.Role')
                ->select('all_users.*', 'role_masrer.roles')
                ->where(function($query) use ($search_input) {
                    $query->where(DB::raw("CONCAT(all_users.f_name, ' ', all_users.m_name, ' ', all_users.l_name)"), 'like', '%' . $search_input . '%')
                        ->orWhere('all_users.email', 'like', '%' . $search_input . '%')
                        ->orWhere('all_users.Employee_id', 'like', '%' . $search_input . '%')
                        ->orWhere('all_users.mobile_number', 'like', '%' . $search_input . '%')
                        ->orWhere('all_users.aadhaar_number', 'like', '%' . $search_input . '%')
                        ->orWhere('all_users.pan_number', 'like', '%' . $search_input . '%')
                        ->orWhere('all_users.dob', 'like', '%' . $search_input . '%')
                        ->orWhere('all_users.shift_time', 'like', '%' . $search_input . '%')
                        ->orWhere('all_users.employee_type', 'like', '%' . $search_input . '%')
                        ->orWhere('all_users.DOJ', 'like', '%' . $search_input . '%')
                        ->orWhere('role_masrer.roles', 'like', '%' . $search_input . '%');
                })
                ->get();
        }

        if($user_data->isNotEmpty()) {
            return view("downloade_Id_cards")
                ->with('user_data', $user_data)
                ->with('role', $role);
        } else {
            return back()->with('error', 'Data not found');
        }
    }

    public function downloade_selected_id_cards(Request $req) {
        $search_input = $req->search_input;
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');

        if(!isset($EmployeesID)) {
            return redirect()->route('login');
        }

        if(strpos($search_input, ',') !== false) {
            $employee_ids = array_map('trim', explode(',', $search_input));

            $user_data = DB::table('all_users')
                ->join('role_masrer', 'role_masrer.id', '=', 'all_users.Role')
                ->select('all_users.*', 'role_masrer.roles')
                ->whereIn('all_users.Employee_id', $employee_ids)
                ->get();

            if($user_data->isNotEmpty()) {
                return view("downloade_Id_cards")
                    ->with('user_data', $user_data)
                    ->with('role', $role);
            } else {
                return back()->with('error', 'Data not found');
            }
        }
    }
}

<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class holiday_master_controller extends Controller
{
    /**
     * Add a new holiday or update an existing one
     */
    public function add_holiday_api(Request $request)
    {
        $EmployeesID = session()->get('EmployeeID');
        $role = session()->get('role');

        // Validate the request
        $request->validate([
            'Holiday_Name' => 'required|string',
            'Holiday_Date' => 'required|date',
            'status' => 'required|in:0,1'  // We'll keep this as status in the form but map it to Public_Holiday
        ]);

        $holiday_name = $request->Holiday_Name;
        $holiday_date = $request->Holiday_Date;
        $swipe_date = $request->Swap_with_Date ?? "0000-00-00";
        $public_holiday = $request->status;  // This is named 'status' in the form

        $holiday_get_Data = DB::table('holiday_master')
            ->where('holiday_Date', $holiday_date)
            ->get();

        if (count($holiday_get_Data) == 1) {
            DB::table('holiday_master')
                ->where('holiday_Date', $holiday_date)
                ->update([
                    'Holiday_name' => $holiday_name,
                    'Swap_with_Date' => $swipe_date,
                    'Public_Holiday' => $public_holiday,  // Changed from 'status' to 'Public_Holiday'
                    'updated_at' => now(),
                    'updated_by' => $EmployeesID ?? null
                ]);
            $message = "Holiday updated successfully!";
        } else {
            DB::table('holiday_master')->insertOrIgnore([
                'Holiday_name' => $holiday_name,
                'holiday_Date' => $holiday_date,
                'Swap_with_Date' => $swipe_date,
                'Public_Holiday' => $public_holiday,  // Changed from 'status' to 'Public_Holiday'
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => $EmployeesID ?? null,
                'updated_by' => $EmployeesID ?? null
            ]);
            $message = "Holiday added successfully!";
        }

        return response()->json([
            'status' => true,
            'message' => $message,
            'holiday_name' => $holiday_name,
            'role' => $role
        ]);
    }

    /**
     * Get all holidays with optional limit
     */
    public function all_holiday_api($limit)
    {
        $all_holidays = DB::table('holiday_master')
            ->orderBy('holiday_Date', 'desc')
            ->limit($limit)
            ->get();

        return response()->json([
            'status' => true,
            'all_users' => [
                'data' => $all_holidays
            ]
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\CompanyBasicInfo;
use App\GroupCategory;
use App\AdditionStaff;
use App\Exports\AdditionStaffExport;
use Illuminate\Http\Request;

use Excel;
use DB;

class AdditionStaffController extends Controller
{
    // public function Export(Request $req)
    // {
    //     $start_time = "";
    //     $end_time   = "";
    //     try {
    //         $start_time = $req->start_time;
    //         $end_time   = $req->end_time;
    //     } catch (\Throwable $th) {}
        
    //     return Excel::download(new AdditionStaffExport($start_time, $end_time), 'staff.xlsx');
    // }

    public function Export(Request $req)
    {
        $start_time = $req->start_time;
        $end_time   = $req->end_time;
        
        $cids = DB::select("
            SELECT 
                distinct(cid)
            FROM addition_staff AS X
            WHERE 1 = 1
            AND date_time >= '".$start_time."'
            AND date_time <= '".$end_time."' 
        ");

        $cases = DB::select("
            SELECT 
                *, X.staff as monthStaff
            FROM addition_staff AS X
            LEFT JOIN 
            company_basic_info AS Y 
            ON X.cid = Y.cid
            WHERE 1 = 1
            AND date_time >= '".$start_time."'
            AND date_time <= '".$end_time."' 
            -- ORDER BY Y.group_category DESC
        ");

        $cals = DB::select("
            SELECT 
                Y.group_category AS GroupName,
                SUM(X.staff) AS Staff
            FROM addition_staff AS X
            LEFT JOIN 
            company_basic_info AS Y 
            ON X.cid = Y.cid
            WHERE 1
            AND date_time >= '".$start_time."'
            AND date_time <= '".$end_time."' 
            GROUP BY Y.group_category
            -- ORDER BY Y.group_category DESC
        ");
        return Excel::download(new AdditionStaffExport($cids, $cases, $cals), '就業人數查詢及維護.xlsx');
    }
}

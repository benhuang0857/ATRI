<?php

namespace App\Http\Controllers;

use App\AdditionRevenue;
use App\CompanyBasicInfo;
use App\GroupCategory;
use App\Exports\AdditionRevenueExport;
use Illuminate\Http\Request;

use Excel;
use DB;

class AdditionRevenueController extends Controller
{
    // public function Export(Request $req)
    // {
    //     $start_time = "";
    //     $end_time   = "";
    //     try {
    //         $start_time = $req->start_time;
    //         $end_time   = $req->end_time;
    //     } catch (\Throwable $th) {}
        
    //     return Excel::download(new AdditionRevenueExport($start_time, $end_time), 'Revenue.xlsx');
    // }

    public function Export(Request $req)
    {
        $start_time = $req->start_time;
        $end_time   = $req->end_time;
        
        $cids = DB::select("
            SELECT 
                distinct(cid)
            FROM addition_revenue AS X
            WHERE 1 = 1
            AND date_time >= '".$start_time."'
            AND date_time <= '".$end_time."' 
        ");

        $cases = DB::select("
            SELECT 
                *
            FROM addition_revenue AS X
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
                SUM(X.price) AS Price
            FROM addition_revenue AS X
            LEFT JOIN 
            company_basic_info AS Y 
            ON X.cid = Y.cid
            WHERE 1
            AND date_time >= '".$start_time."'
            AND date_time <= '".$end_time."' 
            GROUP BY Y.group_category
            -- ORDER BY Y.group_category DESC
        ");

        return Excel::download(new AdditionRevenueExport($cids, $cases, $cals), '營業額異動查詢及維護.xlsx');
    }
}

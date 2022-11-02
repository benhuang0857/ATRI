<?php

namespace App\Http\Controllers;

use App\AdditionInvest;
use App\CompanyBasicInfo;
use App\GroupCategory;
use App\Exports\AwardExport;
use Illuminate\Http\Request;

use DB;
use Excel;

class AwardController extends Controller
{
    public function Export(Request $req)
    {
        $start_time = $req->start_time;
        $end_time   = $req->end_time;
        
        $cids = DB::select("
            SELECT 
                distinct(cid)
            FROM award AS X
            WHERE 1 = 1
            AND award_time >= '".$start_time."'
            AND award_time <= '".$end_time."' 
        ");

        $cases = DB::select("
            SELECT 
                *
            FROM award AS X
            LEFT JOIN 
            company_basic_info AS Y 
            ON X.cid = Y.cid
            WHERE 1 = 1
            AND award_time >= '".$start_time."'
            AND award_time <= '".$end_time."' 
            -- ORDER BY Y.group_category DESC
        ");

        $cals = DB::select("
            SELECT 
                Y.group_category AS GroupName,
                SUM(1) AS Price
            FROM award AS X
            LEFT JOIN 
            company_basic_info AS Y 
            ON X.cid = Y.cid
            WHERE 1
            AND award_time >= '".$start_time."'
            AND award_time <= '".$end_time."' 
            GROUP BY Y.group_category
            -- ORDER BY Y.group_category DESC
        ");

        return Excel::download(new AwardExport($cids, $cases, $cals), '申請取得獎項.xlsx');
    }
}

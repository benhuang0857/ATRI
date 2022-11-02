<?php

namespace App\Http\Controllers;

use App\AdditionInvest;
use App\CompanyBasicInfo;
use App\GroupCategory;
use App\Exports\GovGrantExport;
use Illuminate\Http\Request;

use DB;
use Excel;

class GovGrantController extends Controller
{
    public function Export(Request $req)
    {
        $start_time = $req->start_time;
        $end_time   = $req->end_time;
        
        $cids = DB::select("
            SELECT 
                distinct(cid)
            FROM gov_grant AS X
            WHERE 1 = 1
            AND grant_time >= '".$start_time."'
            AND grant_time <= '".$end_time."' 
        ");

        $cases = DB::select("
            SELECT 
                *
            FROM gov_grant AS X
            LEFT JOIN 
            company_basic_info AS Y 
            ON X.cid = Y.cid
            WHERE 1 = 1
            AND grant_time >= '".$start_time."'
            AND grant_time <= '".$end_time."' 
            -- ORDER BY Y.group_category DESC
        ");

        $cals = DB::select("
            SELECT 
                Y.group_category AS GroupName,
                SUM(X.grant_price) AS Price
            FROM gov_grant AS X
            LEFT JOIN 
            company_basic_info AS Y 
            ON X.cid = Y.cid
            WHERE 1
            AND grant_time >= '".$start_time."'
            AND grant_time <= '".$end_time."' 
            GROUP BY Y.group_category
            -- ORDER BY Y.group_category DESC
        ");

        return Excel::download(new GovGrantExport($cids, $cases, $cals), '申請取得政府補助資源.xlsx');
    }
}

<?php

namespace App\Http\Controllers;

use App\CompanyBasicInfo;
use App\GroupCategory;
use App\TechTransfer;
use App\Exports\TechTransferExport;
use Illuminate\Http\Request;

use Excel;
use DB;

class TechTransferController extends Controller
{
    public function Export(Request $req)
    {
        $start_time = $req->start_time;
        $end_time   = $req->end_time;

        $cases1 = DB::select("
                SELECT 
                    *
                FROM tech_transfer AS X
                LEFT JOIN 
                company_basic_info AS Y 
                ON X.cid = Y.cid
                WHERE 1 = 1
                AND start_time >= '".$start_time."'
                AND start_time <= '".$end_time."' 
                ORDER BY Y.group_category DESC
            ");

            $cases2 = DB::select("
                SELECT 
                    Y.group_category AS GroupName,
                    SUM(X.price) AS Price
                FROM tech_transfer AS X
                LEFT JOIN 
                company_basic_info AS Y 
                ON X.cid = Y.cid
                WHERE 1
                AND start_time >= '".$start_time."'
                AND start_time <= '".$end_time."' 
                GROUP BY Y.group_category
                ORDER BY Y.group_category DESC
            ");

        if($start_time == "" || $end_time == "")
        {
            $cases1 = DB::select("
                SELECT 
                    *
                FROM tech_transfer AS X
                LEFT JOIN 
                company_basic_info AS Y 
                ON X.cid = Y.cid
                WHERE 1 = 1
                ORDER BY Y.group_category DESC
            ");

            $cases2 = DB::select("
                SELECT 
                    Y.group_category AS GroupName,
                    SUM(X.price) AS Price
                FROM tech_transfer AS X
                LEFT JOIN 
                company_basic_info AS Y 
                ON X.cid = Y.cid
                WHERE 1
                GROUP BY Y.group_category
                ORDER BY Y.group_category DESC
            ");

        }        
        return Excel::download(new TechTransferExport($cases1, $cases2), 'tech-trans.xlsx');
    }
}

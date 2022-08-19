<?php

namespace App\Http\Controllers;

use App\CompanyBasicInfo;
use App\GroupCategory;
use App\IndustryAcademiaCoop;
use App\Exports\IndustryAcademiaCoopExport;
use Illuminate\Http\Request;

use Excel;
use DB;

class IndustryAcademiaCoopController extends Controller
{
    public function Export(Request $req)
    {
        $start_time = $req->start_time;
        $end_time   = $req->end_time;

        if($start_time == null || $end_time == null)
        {
            $cases1 = DB::select("
                SELECT 
                    *
                FROM industry_academia_cooperation AS X
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
                FROM industry_academia_cooperation AS X
                LEFT JOIN 
                company_basic_info AS Y 
                ON X.cid = Y.cid
                WHERE 1
                GROUP BY Y.group_category
                ORDER BY Y.group_category DESC
            ");
        }
        else
        {
            $cases1 = DB::select("
                SELECT 
                    *
                FROM industry_academia_cooperation AS X
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
                FROM industry_academia_cooperation AS X
                LEFT JOIN 
                company_basic_info AS Y 
                ON X.cid = Y.cid
                WHERE 1
                AND start_time >= '".$start_time."'
                AND start_time <= '".$end_time."' 
                GROUP BY Y.group_category
                ORDER BY Y.group_category DESC
            ");
        }
        
        return Excel::download(new IndustryAcademiaCoopExport($cases1, $cases2), 'industry-academia-coop.xlsx');
    }
}

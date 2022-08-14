<?php

namespace App\Http\Controllers;

use App\AdditionInvest;
use App\CompanyBasicInfo;
use App\GroupCategory;
use App\Exports\AdditionInvestExport;
use Illuminate\Http\Request;

use DB;
use Excel;

class AdditionInvestController extends Controller
{
    public function Export(Request $req)
    {
        $start_time = $req->start_time;
        $end_time   = $req->end_time;

        dd($start_time);

        $cases1 = DB::select("
            SELECT 
                *
            FROM addition_invest AS X
            LEFT JOIN 
            company_basic_info AS Y 
            ON X.cid = Y.cid
            WHERE 1 = 1
            AND date_time >= '".$start_time."'
            AND date_time <= '".$end_time."' 
            ORDER BY Y.group_category DESC
        ");

        $cases2 = DB::select("
            SELECT 
                Y.group_category AS GroupName,
                SUM(X.price) AS Price
            FROM addition_invest AS X
            LEFT JOIN 
            company_basic_info AS Y 
            ON X.cid = Y.cid
            WHERE 1
            AND date_time >= '".$start_time."'
            AND date_time <= '".$end_time."' 
            GROUP BY Y.group_category
            ORDER BY Y.group_category DESC
        ");

        if($req->start_time == null || $req->end_time == null)
        {
            $cases1 = DB::select("
                SELECT 
                    *
                FROM addition_invest AS X
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
                FROM addition_invest AS X
                LEFT JOIN 
                company_basic_info AS Y 
                ON X.cid = Y.cid
                WHERE 1
                GROUP BY Y.group_category
                ORDER BY Y.group_category DESC
            ");

        }
        
        return Excel::download(new AdditionInvestExport($cases1, $cases2), 'Invest.xlsx');
    }
}

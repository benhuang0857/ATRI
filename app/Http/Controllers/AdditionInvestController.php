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
    public function QueryTable(Request $req)
    {
        $start_time = $req->start_time;
        $end_time   = $req->end_time;

        $cases = AdditionInvest::where('date_time', '>=',$start_time)
                                ->where('date_time', '<=',$end_time)
                                ->get();

        return view('addition_invest_table', ['Cases' => $cases]);
    }

    public function Export(Request $req) 
    {
        $cellData = [
            ['進駐單位','自然人/組織/公司名稱','投資/增資','金額','日期']
        ];

        $cases = DB::select("
            SELECT 
                *
            FROM addition_invest AS X
            LEFT JOIN 
            company_basic_info AS Y 
            ON X.cid = Y.cid
            WHERE 1
            ORDER BY Y.group_category DESC
        ");

        $sum = 0;
        foreach ($cases as $case) {
            $tmpArr = [];
            $groupName = GroupCategory::where('slug', $case->group_category)->first()->name;
            
            array_push($tmpArr, $groupName);
            array_push($tmpArr, $case->company_name);

            if ($case->type == 'invest') {
                array_push($tmpArr, '投資');
            }elseif ($case->type == 'increase') {
                array_push($tmpArr, '增資');
            }else{
                array_push($tmpArr, '未知');
            }
            
            array_push($tmpArr, $case->price);
            array_push($tmpArr, $case->date_time);

            array_push($cellData, $tmpArr);

            $sum += intval($case->price);
        }

        array_push($cellData, ['','','','','']);

        array_push($cellData, ['','','','','']);
        array_push($cellData, ['各所小記', '','','金額','']);

        $cases = DB::select("
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

        $sum = 0;
        foreach ($cases as $case) {
            $tmpArr = [];
            $groupName = GroupCategory::where('slug', $case->GroupName)->first()->name;

            array_push($tmpArr, $groupName);
            array_push($tmpArr, '');
            array_push($tmpArr, '');
            array_push($tmpArr, $case->Price);
            array_push($tmpArr, '');

            array_push($cellData, $tmpArr);

            $sum += intval($case->Price);
        }

        array_push($cellData, ['','','','','']);
        array_push($cellData, ['','','總計',$sum,'']);

        Excel::create('投增資額明細表',function($excel) use ($cellData){
            $excel->sheet('score', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xlsx');
    }
}

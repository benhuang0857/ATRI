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
    public function Export(Request $req)
    {
        $start_time = "";
        $end_time   = "";
        try {
            $start_time = $req->start_time;
            $end_time   = $req->end_time;
        } catch (\Throwable $th) {}
        
        return Excel::download(new AdditionRevenueExport($start_time, $end_time), 'Revenue.xlsx');
    }
}

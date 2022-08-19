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
    public function Export(Request $req)
    {
        $start_time = "";
        $end_time   = "";
        try {
            $start_time = $req->start_time;
            $end_time   = $req->end_time;
        } catch (\Throwable $th) {}
        
        return Excel::download(new AdditionStaffExport($start_time, $end_time), 'staff.xlsx');
    }
}

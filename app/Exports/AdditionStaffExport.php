<?php

namespace App\Exports;

use App\AdditionStaff;
use App\CompanyBasicInfo;
use App\GroupCategory;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use DB;

class MyCase {
    public $group   = '';
    public $company = '';
    public $ini_staff = 0;
    public $diff_staff = 0;
};

class groupTotalPrice {
    public $group = '';
    public $sum   = 0;
}

class AdditionStaffExport implements FromView
{
    protected $start_time;
    protected $end_time;
    protected $companies;
    protected $additionStaff;
    protected $cids = array();

    public function __construct($start_time, $end_time)
    {
        $this->start_time = $start_time;
        $this->end_time = $end_time;
    }

    private function cooking()
    {
        if ($this->start_time == "" || $this->end_time == "") 
        {
            $distinctCid = DB::select('select distinct(cid) from addition_staff');
            foreach ($distinctCid as $value) {
                array_push($this->cids, $value->cid);
            }

            $this->additionStaff = AdditionStaff::all();
            $this->companies = CompanyBasicInfo::whereIn('cid', $this->cids)->get();
        }
        else
        {
            $distinctCid = DB::select('select distinct(cid) from addition_staff where 1=1 and date_time >= "'. $this->start_time.'" and date_time < "'. $this->end_time.'"');
            foreach ($distinctCid as $value) {
                array_push($this->cids, $value->cid);
            }

            $this->additionStaff = AdditionStaff::whereIn('cid', $this->cids)
                                                ->where('date_time', '>=', $this->start_time)
                                                ->where('date_time', '<', $this->end_time)
                                                ->get();

            $this->companies = CompanyBasicInfo::whereIn('cid', $this->cids)
                                                ->where('contract_start_time', '>=', $this->start_time)
                                                ->where('contract_start_time', '<', $this->end_time)
                                                ->get();
        }

    }

    public function view(): View
    {
        // Group by data to table
        $this->cooking();
        $cellData = array();

        $companies = $this->companies;

        foreach ($companies as $company) 
        {
            // $ini_staff = 0;
            $sumOfStaff = 0;
            $myCase = new MyCase();
            $groupName = GroupCategory::where('slug', $company->group_category)->first()->name;
            
            $myCase->group = $groupName;
            $myCase->company = $company->company_name;
            $myCase->ini_staff = $company->staff;

            $Set = $this->additionStaff;

            foreach ($Set as $ele) {
                $sumOfStaff += $ele->staff;
            }

            $myCase->diff_staff = $sumOfStaff - $company->staff;
            array_push($cellData, $myCase);
        }

        return view('adv-excel.staff', [
            'cases'     => $cellData
        ]);
    }
}

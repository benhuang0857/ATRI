<?php

namespace App\Exports;

use App\AdditionRevenue;
use App\CompanyBasicInfo;
use App\GroupCategory;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use DB;

class MyCase {
    public $group   = '';
    public $company = '';
    public $revenue   = 0;
    public $diff_revenue =0;
    public $date_time  = '';
};

class groupTotalPrice {
    public $group = '';
    public $sum   = 0;
}

class AdditionRevenueExport implements FromView
{
    protected $start_time;
    protected $end_time;
    protected $companies;
    protected $additionRevenue;
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
            $distinctCid = DB::select('select distinct(cid) from addition_revenue');
            foreach ($distinctCid as $value) {
                array_push($this->cids, $value->cid);
            }

            $this->additionRevenue = AdditionRevenue::all();
            $this->companies = CompanyBasicInfo::whereIn('cid', $this->cids)->get();
        }
        else
        {
            $distinctCid = DB::select('select distinct(cid) from addition_revenue where 1=1 and date_time >= "'. $this->start_time.'" and date_time < "'. $this->end_time.'"');
            foreach ($distinctCid as $value) {
                array_push($this->cids, $value->cid);
            }

            $this->additionRevenue = AdditionRevenue::whereIn('cid', $this->cids)
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
            $sumOfRevenue = 0;
            $myCase = new MyCase();
            $groupName = GroupCategory::where('slug', $company->group_category)->first()->name;
            
            $myCase->group = $groupName;
            $myCase->company = $company->company_name;
            $myCase->revenue = $company->revenue;

            $Set = $this->additionRevenue;

            foreach ($Set as $ele) {
                $sumOfRevenue += $ele->price;
            }

            $myCase->diff_revenue = $sumOfRevenue - $company->revenue;
            array_push($cellData, $myCase);
        }

        return view('adv-excel.revenue', [
            'cases'     => $cellData
        ]);
    }
}

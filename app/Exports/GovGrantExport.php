<?php

namespace App\Exports;

use App\AdditionInvest;
use App\CompanyBasicInfo;
use App\GroupCategory;
use App\GovGrant;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use DB;

class CaseCompany {
    public $group   = '';
    public $name = '';
    public $govgrant;
};

class groupTotalPrice {
    public $group = '';
    public $sum   = 0;
}

class GovGrantExport implements FromView
{
    protected $cids;
    protected $cases;
    protected $cals;

    public function __construct($cids, $cases, $cals)
    {
        $this->cids = $cids;
        $this->cases = $cases;
        $this->cals = $cals;
    }

    public function view(): View
    {
        // Group by data to table
        $companies = array();
        $setMonth = date('m');

        $cidsArray = array();
        foreach ($this->cids as $_cid) 
        {
            array_push($cidsArray, $_cid->cid);
        }

        
        foreach ($cidsArray as $key => $_cid) 
        {
            $CaseCompany = new CaseCompany();
            $Company = CompanyBasicInfo::where('cid', $_cid)->first();
            $groupName = GroupCategory::where('slug', $Company->group_category)->first()->name;
            $CaseCompany->name = $Company->company_name;
            $CaseCompany->group = $groupName;
            $CaseCompany->govgrant = GovGrant::where('cid', $_cid)->first();

            array_push($companies, $CaseCompany);
        }

        // Caculate each group total price
        $groupTotalPriceData = array();

        $sum = 0;
        foreach ($this->cals as $case) {
            
            $groupTotalPrice = new groupTotalPrice();

            $groupName = GroupCategory::where('slug', $case->GroupName)->first()->name;

            $groupTotalPrice->group = $groupName;
            $groupTotalPrice->sum = $case->Price;

            array_push($groupTotalPriceData, $groupTotalPrice);

            $sum += intval($case->Price);
        }

        $resultSum = $sum;

        return view('adv-excel.govgrant', [
            'month' => 12,
            'cases' => $companies,
            'groupCals' => $groupTotalPriceData  
        ]);
    }
}

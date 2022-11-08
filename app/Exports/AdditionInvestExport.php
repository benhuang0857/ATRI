<?php

namespace App\Exports;

use App\AdditionInvest;
use App\CompanyBasicInfo;
use App\GroupCategory;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use DB;

class CaseCompany {
    public $group   = '';
    public $name = '';
};

class groupTotalPrice {
    public $group = '';
    public $sum   = 0;
}

class AdditionInvestExport implements FromView
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
        $company = array();
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

            $company[$key][0] = $CaseCompany;
            for ($i=1; $i <= 6; $i++) 
            { 
                $company[$key][$i] = 0;
            }
            foreach ($this->cases as $_case) 
            {
                if ($_case->cid == $_cid) 
                {
                    $caseMonth = (int)date_format(date_create($_case->date_time), 'm')/2;
                    $caseMonth = intval(ceil($caseMonth));
                    $company[$key][$caseMonth] += intval($_case->price);
                }
            }  
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

        return view('adv-excel.invest', [
            'month' => 6,
            'cases' => $company,
            'groupCals' => $groupTotalPriceData  
        ]);
    }
}

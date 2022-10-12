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

    public function __construct($cids, $cases)
    {
        $this->cids = $cids;
        $this->cases = $cases;
    }

    /*
    public function view(): View
    {
        // Group by data to table
        $cellData = array();

        $sum = 0;
        foreach ($this->cases1 as $case) {

            $myCase = new MyCase();
            $groupName = GroupCategory::where('slug', $case->group_category)->first()->name;
            
            $myCase->group = $groupName;
            $myCase->company = $case->company_name;

            if ($case->type == 'invest') {
                $myCase->type = '投資';
            }elseif ($case->type == 'increase') {
                $myCase->type = '增資';
            }else{
                $myCase->type = '未知';
            }
            
            $myCase->price      = $case->price;
            $myCase->date_time  = date('Y-m-d', strtotime($case->date_time));

            array_push($cellData, $myCase);

            $sum += intval($case->price);
        }

        // Caculate each group total price
        $groupTotalPriceData = array();

        $sum = 0;
        foreach ($this->cases2 as $case) {
            
            $groupTotalPrice = new groupTotalPrice();

            $groupName = GroupCategory::where('slug', $case->GroupName)->first()->name;

            $groupTotalPrice->group = $groupName;
            $groupTotalPrice->sum = $case->Price;

            array_push($groupTotalPriceData, $groupTotalPrice);

            $sum += intval($case->Price);
        }

        $resultSum = $sum;

        return view('adv-excel.invest', [
            'cases'     => $cellData,
            'groupCase' => $groupTotalPriceData,
            'resultSum' => $resultSum  
        ]);
    }
    */

    public function view(): View
    {
        // Group by data to table
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
            for ($i=1; $i <= $setMonth; $i++) 
            { 
                $company[$key][$i] = 0;
            }
            foreach ($this->cases as $_case) 
            {
                if ($_case->cid == $_cid) 
                {
                    $caseMonth = (int)date_format(date_create($_case->date_time), 'm');
                    $company[$key][$caseMonth] = $_case->price;
                }
            }  
        }

        return view('adv-excel.invest', [
            'month' => $setMonth,
            'cases' => $company
        ]);
    }
}

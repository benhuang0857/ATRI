<?php

namespace App\Exports;

use App\AdditionInvest;
use App\CompanyBasicInfo;
use App\GroupCategory;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use DB;

class MyCase {
    public $group   = '';
    public $company = '';
    public $type    = '';
    public $price   = 0;
    public $date_time  = '';
};

class groupTotalPrice {
    public $group = '';
    public $sum   = 0;
}

class AdditionInvestExport implements FromView
{
    protected $cases1;
    protected $cases2;

    public function __construct($cases1, $cases2)
    {
        $this->cases1 = $cases1;
        $this->cases2 = $cases2;
    }

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
}

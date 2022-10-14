<?php

namespace App\Admin\Controllers;

use App\AdditionRevenue;
use App\AdditionInvest;
use App\CompanyBasicInfo;
use App\GroupCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
Use Encore\Admin\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use DB;

class AdditionInvestExcelController extends Controller
{
    // public function index(Content $content)
    public function index(Request $req)
    {
        $setYear = date('Y');
        if (isset($req->setYear)) {
            $setYear = $req->setYear;
        }

        $datasets       = array();
        $colorSet = ['blue', 'red', 'green'];
        $companies = AdditionInvest::with('CompanyBasicInfo')->get();

        $groups = array();
        foreach($companies as $key => $c)
        {
            if (!in_array($c->CompanyBasicInfo->group_category, $groups, true)) {
                array_push($groups, $c->CompanyBasicInfo->group_category);
            }
        }

        $jscode = "
        var visitorsChart = new Chart($('#visitors-chart'), {
            data: {
                labels: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
                datasets: [ ";

        $groupNames = array();
        $totalList = array();
        foreach ($groups as $key => $group) {
            $total = 0;
            $revenuesQueue  = array();
            for ($i=1; $i <= 12 ; $i++) { 
                $calPrice = DB::select("
                    SELECT 
                        sum(price) price
                    FROM addition_invest AS X
                    LEFT JOIN 
                    company_basic_info AS Y 
                    ON X.cid = Y.cid
                    WHERE 1 = 1
                    AND group_category = '".$group."'
                    AND date_time >= '".$setYear.'-'.$i.'-01'."'
                    AND date_time < '".$setYear.'-'.($i+1).'-01'."' 
                ");

                $sum = (int)array_pop($calPrice)->price;
                if ($sum == null) {
                    $sum = 0;
                }
                $total += $sum;
                
                array_push($revenuesQueue, $sum);
            }

            array_push($totalList, $total);
            
            $revenuesStr = '[';
            foreach ($revenuesQueue as $value) {
                $revenuesStr .= "'".strval($value)."',";
            }
            $revenuesStr .= ']';

            $group = GroupCategory::where('slug', $group)->first();

            array_push($groupNames, "'".$group->name."'");
            $jscode .= "{
                            label: '".$group->name."',
                            type: 'line',
                            data: ".$revenuesStr.",
                            backgroundColor: 'transparent',
                            borderColor: '".$colorSet[$key]."',
                            //pointBorderColor: '#007bff',
                            fill: false
                        },";
        }

        $jscode .= "
            ]},
            options: {
                maintainAspectRatio: false,
                responsive: true,
                title: {
                    display: true,
                    text: '營業額明細表'
                },
                legend: {
                    display: true
                },
                scales: {
                    yAxes: [{}],
                    xAxes: [{}]
                }
            }
        });";

        $jscode .= "
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [".implode(',', $groupNames)."],
                datasets: [{
                    label: '投增資金額管理',
                    data: [".implode(',', $totalList)."],
                    borderWidth: 1,
                    backgroundColor: ['Red', 'Blue', 'Yellow'],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
        ";

        $content = new Content();
        return $content
            ->title('投增資金額管理')
            ->description('統計各所投增資金額')
            ->view('adv-excel.invests-export', [
                'title' => '營業額明細表',
                'dataset' => $datasets,
                'jscode'  => $jscode
            ]);;
    }
}

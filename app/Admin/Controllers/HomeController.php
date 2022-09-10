<?php

namespace App\Admin\Controllers;

use App\AdditionRevenue;
use App\CompanyBasicInfo;
use App\CompanyStatus;
use App\GroupCategory;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

use DB;

class HomeController extends Controller
{
    public function index(Content $content)
    {

        return redirect('/admin/gov-support-projects'); 
        
        $datasets       = array();
        $colorSet = ['blue', 'red', 'green'];
        $groups = AdditionRevenue::select('group_category')->distinct()->get();

        $jscode = "
        var visitorsChart = new Chart($('#visitors-chart'), {
            data: {
                labels: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
                datasets: [ ";

        foreach ($groups as $key => $group) {
            $revenuesQueue  = array();
            for ($i=1; $i <= 12 ; $i++) { 
                $sum = 0;
                $sum = AdditionRevenue::where('group_category', $group->group_category)
                            ->where('date_time', '>=' ,date("Y").'-'.$i.'-01')
                            ->where('date_time', '<' ,date("Y").'-'.($i+1).'-01')
                            ->sum('price');
                array_push($revenuesQueue, $sum);
            }
            
            $revenuesStr = '[';
            foreach ($revenuesQueue as $value) {
                $revenuesStr .= "'".strval($value)."',";
            }
            $revenuesStr .= ']';

            $group = GroupCategory::where('slug', $group->group_category)->first();
            
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

        return $content
            ->title('營業額明細表')
            ->description('統計各所營業額')
            ->view('chart', [
                'title' => '營業額明細表',
                'dataset' => $datasets,
                'jscode'  => $jscode
            ]);
    }
}

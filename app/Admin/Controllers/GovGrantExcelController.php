<?php

namespace App\Admin\Controllers;

use App\AdditionRevenue;
use App\AdditionInvest;
use App\CompanyBasicInfo;
use App\GroupCategory;
use App\GovGrant;
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

class GovGrantExcelController extends Controller
{
    public function index(Request $req)
    {
        $setYear = date('Y');
        if (isset($req->setYear)) {
            $setYear = $req->setYear;
        }

        $datasets       = array();
        $colorSet = ['blue', 'red', 'green', 'yellow', 'orange'];
        $companies = GovGrant::with('CompanyBasicInfo')
                                ->where('grant_time', '>=',  $setYear.'-01-01')
                                ->where('grant_time', '<=',  $setYear.'-12-31')
                                ->get();

        $groups = array();
        foreach($companies as $key => $c)
        {
            if (!in_array($c->CompanyBasicInfo->group_category, $groups, true)) {
                array_push($groups, $c->CompanyBasicInfo->group_category);
            }
        }

        $groupNames = array();
        $totalList = array();

        foreach ($groups as $key => $group) {
            
            $cnt = 0;
            foreach ($companies as $item) {
                $tmpGroup = $item->CompanyBasicInfo->group_category;
                if($tmpGroup == $group)
                {
                    $cnt++;
                }
            }
            array_push($totalList, $cnt);

            $group = GroupCategory::where('slug', $group)->first();
            array_push($groupNames, "'".$group->name."'");
            
        }

        // dd($groupNames);

        $jscode = "
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [".implode(',', $groupNames)."],
                datasets: [{
                    label: '申請/取得政府補助資源',
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
            ->title('申請/取得政府補助資源')
            ->description('統計各所政府補助資源')
            ->view('adv-excel.govgrant-export', [
                'title' => '政府補助資源',
                'dataset' => $datasets,
                'jscode'  => $jscode
            ]);;
    }
}

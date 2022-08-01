<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Award;
use App\AdditionInvest;
use App\CompanyBasicInfo;
use App\CompanyStatus;
use App\GroupCategory;
use App\GovGrant;
use App\GovSupportProject;
use App\IndustryAcademiaCoop;
use App\TechTransfer;

use PDF;

class CompanyBasicInfoController extends Controller
{
    # 投增資金額表格渲染
    public function InvestTableRender($additionInvest)
    {
        $invest_table = '';
        try {
            $invest_table .= "<table style='padding:10px ;text-align: center;width: 100%;font-size:10px' border=1 cellspacing=0 cellpadding=0>
                <thead>
                    <tr>
                        <th>類型</th>
                        <th>日期</th>
                        <th>金額</th>
                        <th>用途</th>
                        <th>輔導內容</th>
                    </tr>
                </thead>
                <tbody>";
            foreach ($additionInvest as $case) 
            {
                $invest_table .= "
                    <tr>
                        <td>".$case->type."</td>
                        <td>".$case->date_time."</td>
                        <td>".$case->price."</td>
                        <td>".$case->reason."</td>
                        <td>".$case->note."</td>
                    </tr>";
            }

            $invest_table .= "
                </tbody>
            </table>";
        } catch (\Throwable $th) {
            //throw $th;
        }
        return $invest_table;
    }
        
    # 取得政府補助資源表格渲染
    public function GovGrantTableRender($additionGovGrant)
    {
        $govgrant_table = '';
        try {
            $govgrant_table .= "<table style='padding:10px ;text-align: center;width: 100%;font-size:10px' border=1 cellspacing=0 cellpadding=0>
                <thead>
                    <tr>
                        <th>政府補助資源名稱</th>
                        <th>計畫名稱</th>
                        <th>申請日期</th>
                        <th>核定補助日期</th>
                        <th>輔導內容說明</th>
                    </tr>
                </thead>
                <tbody>";

            foreach ($additionGovGrant as $case) 
            {
                $govgrant_table .= "
                    <tr>
                        <td>".$case->gov_grant_name."</td>
                        <td>".$case->plan_name."</td>
                        <td>".$case->application_time."</td>
                        <td>".$case->grant_time."</td>
                        <td>".$case->note."</td>
                    </tr>";
            }

            $govgrant_table .= "
                </tbody>
            </table>";
            } catch (\Throwable $th) {
                //throw $th;
            }
        return $govgrant_table;
    }

    # 獎項表格渲染
    public function AwardTableRender($additionAward)
    {
        $award_table = '';
        try {
            $award_table .= "<table style='padding:10px ;text-align: center;width: 100%;font-size:10px' border=1 cellspacing=0 cellpadding=0>
                <thead>
                    <tr>
                        <th>獎項名稱</th>
                        <th>申請日期</th>
                        <th>獲獎日期</th>
                        <th>輔導內容說明</th>
                    </tr>
                </thead>
                <tbody>";

            foreach ($additionAward as $case) 
            {
                $award_table .= "
                    <tr>
                        <td>".$case->award_name."</td>
                        <td>".$case->application_time."</td>
                        <td>".$case->award_time."</td>
                        <td>".$case->note."</td>
                    </tr>";
            }

            $award_table .= "
                </tbody>
            </table>";
            } catch (\Throwable $th) {
                //throw $th;
            }
        return $award_table;
    }

    # 取得技術移轉表格渲染
    public function TechTransferTableRender($additionTechTransfer)
    {
        $techtransfer_table = '';
        try {
            $techtransfer_table .= "<table style='padding:10px ;text-align: center;width: 100%;font-size:10px' border=1 cellspacing=0 cellpadding=0>
                <thead>
                    <tr>
                        <th>技轉名稱</th>
                        <th>技轉金額(千)</th>
                        <th>合約起始日期</th>
                        <th>合約終止日期</th>
                        <th>輔導內容說明</th>
                    </tr>
                </thead>
                <tbody>";

            foreach ($additionTechTransfer as $case) 
            {
                $techtransfer_table .= "
                    <tr>
                        <td>".$case->tech_transfer_name."</td>
                        <td>".$case->price."</td>
                        <td>".$case->start_time."</td>
                        <td>".$case->end_time."</td>
                        <td>".$case->note."</td>
                    </tr>";
            }

            $techtransfer_table .= "
                </tbody>
            </table>";
            } catch (\Throwable $th) {
                //throw $th;
            }
        return $techtransfer_table;
    }

    # 取得產學合作表格渲染
    public function IndustryAcademiaCoopTableRender($additionIndustryAcademiaCoop)
    {
        $industryAcademia_table = '';
        try {
            $industryAcademia_table .= "<table style='padding:10px ;text-align: center;width: 100%;font-size:10px' border=1 cellspacing=0 cellpadding=0>
                <thead>
                    <tr>
                        <th>計畫名稱</th>
                        <th>計畫類別</th>
                        <th>金額(千元)</th>
                        <th>開始時間</th>
                        <th>結束時間</th>
                        <th>輔導內容說明</th>
                    </tr>
                </thead>
                <tbody>";

            foreach ($additionIndustryAcademiaCoop as $case) 
            {
                $industryAcademia_table .= "
                    <tr>
                        <td>".$case->project_name."</td>
                        <td>".$case->project_category."</td>
                        <td>".$case->price."</td>
                        <td>".$case->start_time."</td>
                        <td>".$case->end_time."</td>
                        <td>".$case->note."</td>
                    </tr>";
            }

            $industryAcademia_table .= "
                </tbody>
            </table>";
            } catch (\Throwable $th) {
                //throw $th;
            }
        return $industryAcademia_table;
    }

    public function CompanyInfoView($cid)
    {       
        $group_name         = '';
        $graduate_date      = '';
        $leave_date         = '';
        $invest_table       = '';
        $govgrant_table     = '';
        $award_table        = '';
        $techtransfer_table = '';
        $industryAcademia_table = '';

        $graduateStatus = CompanyStatus::where('cid', $cid)
                                        ->where('status', 'graduate')->first();
        $leaveStatus    = CompanyStatus::where('cid', $cid)
                                        ->where('status', 'leave')->first();
        $company        = CompanyBasicInfo::where('cid', $cid)->first();
        $groupCategory  = GroupCategory::where('slug', $company->group_category)->first();

        /**
         * 條列式 列出投資、增資額明細表、申請暨取得政府補助資源、獎項、技術移轉、產學合作等績效資料表
         */
        $additionInvest         = AdditionInvest::where('cid', $cid)->get();
        $additionGovGrant       = GovGrant::where('cid', $cid)->get();
        $additionAward          = Award::where('cid', $cid)->get();
        $additionTechTransfer   = TechTransfer::where('cid', $cid)->get();
        $additionIndustryAcademiaCoop = IndustryAcademiaCoop::where('cid', $cid)->get();

        // 將表資料注入
        $invest_table       = $this->InvestTableRender($additionInvest);
        $govgrant_table     = $this->GovGrantTableRender($additionGovGrant);
        $award_table        = $this->AwardTableRender($additionAward);
        $techtransfer_table = $this->TechTransferTableRender($additionTechTransfer);
        $industryAcademia_table = $this->IndustryAcademiaCoopTableRender($additionIndustryAcademiaCoop);
        
        try {
            $group_name  = $groupCategory->name;
            $graduate_date  = $graduateStatus->date_time;
            $leave_date     = $leaveStatus->date_time;
        } catch (\Throwable $th) {
            //throw $th;
        }
        // return view('companypdf', array(
        //     'company'           => $company,
        //     'groupName'         => $group_name,
        //     'graduateDate'      => $graduate_date,
        //     'leaveDate'         => $leave_date,
        //     'investTable'       => $invest_table,
        //     'govgrantTable'     => $govgrant_table,
        //     'awardTable'        => $award_table,
        //     'techTransferTable' => $techtransfer_table,
        //     'industryAcademiaTable' => $industryAcademia_table
        // ));     

        $pdf = PDF::loadView('companypdf', array(
            'company'           => $company,
            'groupName'         => $group_name,
            'graduateDate'      => $graduate_date,
            'leaveDate'         => $leave_date,
            'investTable'       => $invest_table,
            'govgrantTable'     => $govgrant_table,
            'awardTable'        => $award_table,
            'techTransferTable' => $techtransfer_table,
            'industryAcademiaTable' => $industryAcademia_table
        ));
        return $pdf->stream('atri.pdf');

    }

    public function GovProjectView($cid)
    {       
        $govProject = GovSupportProject::where('id', $cid)->first();

        $pdf = PDF::loadView('govproject', ['case' => $govProject]);
        return $pdf->stream('gov-project.pdf');

        return view('govproject', ['case' => $govProject]);     

    }

}

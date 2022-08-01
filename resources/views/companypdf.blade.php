<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            * {
                font-family: 'MINGLIU';
            }
        </style>
    </head>

    <body>

    <div style="text-align:center">
        <h2>農業創新育成中心</h2>
        <h4>{{$company->company_name}}基本資料表暨輔導歷程</h4>
    </div>

    <table style="text-align: center;table-layout:fixed; width:700px;font-size:10px" border=1 cellspacing=0 cellpadding=0>
        <tr style="height:35px">
            <td style="background-color:#D9D8D8" width=113 rowspan=2 valign=center>
                進駐育成中心
            </td>
            <td width=121 rowspan=2 valign=center>
                {{$groupName}}
            </td>
            <td style="background-color:#D9D8D8" width=81 height=20 valign=center>
                畢業日期
            </td>
            <td width=237 height=20 colspan=3 valign=center>
                {{$graduateDate}}
            </td>
        </tr>
        <tr style="height:35px">
            <td style="background-color:#D9D8D8" width=81 height=20 valign=center>
                遷離日期
            </td>
            <td width=237 colspan=3 valign=center>
                {{$leaveDate}}
            </td>
        </tr>
        <tr style="height:35px">
            <td style="background-color:#D9D8D8" width=113 valign=center>
                自然人/組織/公司名稱
            </td>
            <td width=121 valign=center>
                {{$company->company_name}}
            </td>
            <td style="background-color:#D9D8D8" width=81 valign=center>
                負責人
            </td>
            <td width=78 valign=center>
                {{$company->owner_name}}
            </td>
            <td style="background-color:#D9D8D8" width=81 valign=center>
                聯絡人
            </td>
            <td width=78 valign=center>
                {{$company->contact_name}}
            </td>
        </tr>
        <tr style="height:35px">
            <td style="background-color:#D9D8D8" width=113 valign=center>
                營運專案名稱
            </td>
            <td width=440 colspan=5 valign=center>
                {{$company->project_name}}
            </td>
        </tr>
        <tr style="height:35px">
            <td style="background-color:#D9D8D8" width=113 valign=center>
                主要產品/服務項目
            </td>
            <td width=440 colspan=5 valign=center>
                {{$company->service}}
            </td>
        </tr>
        <tr style="height:35px">
            <td style="background-color:#D9D8D8" width=113 valign=center>
                合約日期
            </td>
            <td width=440 colspan=5 valign=center>
                {{$company->contract_start_time}}至{{$company->contract_end_time}}
            </td>
        </tr>
        <tr style="background-color:#D9D8D8; height:35px">
            <td valign=center>
                項目
            </td>
            <td colspan=2 valign=center>
                進駐時
            </td>
            <td colspan=3 valign=center>
                畢業或遷離時
            </td>
        </tr>
        <tr style="height:35px">
            <td style="background-color:#D9D8D8;" valign=center>
                實收資本額(元)
            </td>
            <td colspan=2 valign=center>
                {{$company->capital}}
            </td>
            <td colspan=3 valign=center>
            </td>
        </tr>
        <tr style="height:35px">
            <td style="background-color:#D9D8D8;" valign=center>
                員工人數
            </td>
            <td colspan=2 valign=center>
                {{$company->staff}}
            </td>
            <td colspan=3 valign=center>
            </td>
        </tr>
        <tr style="height:35px">
            <td style="background-color:#D9D8D8;" valign=center>
                年營業額(元)
            </td>
            <td colspan=2 valign=center>
                {{$company->revenue}}
            </td>
            <td colspan=3 valign=center>
            </td>
        </tr>

        <tr style="background-color:#D9D8D8; height:35px">
            <td colspan=6 valign=center>
                輔導歷程
            </td>
        </tr>
        <tr style="height:35px">
            <td colspan=6 valign=center>
                <span style="color:red">條列式 列出投資、增資額明細表、申請暨取得政府補助資源、獎項、技術移轉、產學合作等績效資料表含說明</span>
                <BR>
                <p>投增資金額</p>
                {!!$investTable!!}
                <p>政府補助資源</p>
                {!!$govgrantTable!!}
                <p>獎項</p>
                {!!$awardTable!!}
                <p>技術轉移</p>
                {!!$techTransferTable!!}
                <p>產學合作</p>
                {!!$industryAcademiaTable!!}
            </td>
        </tr>

    </table>

    </body>
</html>
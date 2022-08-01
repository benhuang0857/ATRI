<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            * {
                font-family: 'MINGLIU';
                /*font-size: 12px;*/
            }
            td {
                font-size: 12px;
            }
        </style>
    </head>

<body>
    <div style="text-align:center">
        <h2>政府補助資源</h2>
        <h4>{{$case->company_name}}</h4>
    </div>
    <table border=1 cellspacing=0 cellpadding=0 style="table-layout:fixed; width:700px">
        <tr style="text-align:center;">
            <td rowspan=11 style="width:20px">
                <span>農業科技產學合作計畫</span>
            </td>
            <td style="width:30px">
                計畫名稱
            </td>
            <td colspan=3 style="width:650px">
                {{$case->plan_title}}
            </td>
        </tr>
        <tr style="text-align:center;">
            <td>
                執行單位
            </td>
            <td colspan=3>
                {{$case->plan_group}}
            </td>
        </tr>
        <tr>
            <td style="text-align:center">
                聯絡人
            </td>
            <td style="text-align:center">
                {{$case->contact_name}}
            </td>
            <td style="text-align:center">
                聯絡電話
            </td>
            <td style="text-align:center">
                {{$case->phone}}
            </td>
        </tr>
        <tr>
            <td style="text-align:center">
                E-mail
            </td>
            <td style="text-align:center">
                {{$case->email}}
            </td>
            <td style="text-align:center">
                傳真
            </td>
            <td style="text-align:center">
                {{$case->fax}}
            </td>
        </tr>
        <tr>
            <td style="text-align:center">
                申請資格/<br>申請對象
            </td>
            <td colspan=3 style="padding-left:10px">
                <span >{{$case->qualification_description}}<span>
            </td>
        </tr>
        <tr>
            <td style="text-align:center">
                標的
            </td>
            <td colspan=3 style="padding-left:10px">
                {{$case->plan_description}}
            </td>
        </tr>
        <tr>
            <td style="text-align:center">
                產業別/<br>屬性
            </td>
            <td colspan=3 style="padding-left:10px">
                {{$case->industry_description}}
            </td>
        </tr>
        <tr>
            <td style="text-align:center">
                審查重點
            </td>
            <td colspan=3 style="padding-left:10px">
                {{$case->review_point_description}}
            </td>
        </tr>
        <tr>
            <td style="text-align:center">
                研提額度
            </td>
            <td colspan=3 style="padding-left:10px">
                {{$case->amount_description}}
            </td>
        </tr>
        <tr>
            <td style="text-align:center">
                申請日期
            </td>
            <td colspan=3 style="padding-left:10px">
                {{$case->date_end_time}}
            </td>
        </tr>
        <tr>
            <td style="text-align:center">
                網站連結
            </td>
            <td colspan=3 style="padding-left:10px">
                {{$case->web}}
            </td>
        </tr>
    </table>
</body>

</html>

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
    <table border=1 cellspacing=0 cellpadding=0 style="table-layout:fixed; width:700px;margin:auto">
        <tr style="text-align:center">
            <td width=30 rowspan=11 style="border: 0px;padding:20px" >
                <p>農<br>業<br>科<br>技<br>產<br>學<br>合<br>作<br>計<br>畫<br><br><br></p>
            </td>
            <td>
                <p>計畫名稱</p>
            </td>
            <td colspan=3>
                {{$case->plan_title}}
            </td>
        </tr>
        <tr style="text-align:center">
            <td>
                執行單位
            </td>
            <td colspan=3>
                <p>{{$case->plan_group}}</p>
            </td>
        </tr>
        <tr>
            <td style="text-align:center">
                <p>聯絡人</p>
            </td>
            <td style="text-align:center">
                <p>{{$case->contact_name}}</p>
            </td>
            <td style="text-align:center">
                <p>聯絡電話</p>
            </td>
            <td style="text-align:center">
                <p>{{$case->phone}}</p>
            </td>
        </tr>
        <tr>
            <td style="text-align:center">
                <p>E-mail</p>
            </td>
            <td style="text-align:center">
                <p>{{$case->email}}</p>
            </td>
            <td style="text-align:center">
                <p>傳真</p>
            </td>
            <td style="text-align:center">
                <p>{{$case->fax}}</p>
            </td>
        </tr>
        <tr>
            <td style="text-align:center">
                <p>申請資格/<br>申請對象</p>
            </td>
            <td colspan=3 style="padding-left:10px">
                <p>{!!$case->qualification_description!!}<p>
            </td>
        </tr>
        <tr>
            <td style="text-align:center">
                <p>標的</p>
            </td>
            <td colspan=3 style="padding-left:10px">
                <p>{!!$case->plan_description!!}</p>
            </td>
        </tr>
        <tr>
            <td style="text-align:center">
                <p>產業別/<br>屬性</p>
            </td>
            <td colspan=3 style="padding-left:10px">
                <p>{!!$case->industry_description!!}</p>
            </td>
        </tr>
        <tr>
            <td style="text-align:center">
                <p>審查重點</p>
            </td>
            <td colspan=3 style="padding-left:10px">
                <p>{!!$case->review_point_description!!}</p>
            </td>
        </tr>
        <tr>
            <td style="text-align:center">
                <p>研提額度</p>
            </td>
            <td colspan=3 style="padding-left:10px">
                <p>{!!$case->amount_description!!}</p>
            </td>
        </tr>
        <tr>
            <td style="text-align:center">
                <p>申請日期</p>
            </td>
            <td colspan=3 style="padding-left:10px">
                <p>{{$case->date_end_time}}</p>
            </td>
        </tr>
        <tr>
            <td style="text-align:center">
                <p>網站連結</p>
            </td>
            <td colspan=3 style="padding-left:10px">
                <p>{{$case->web}}</p>
            </td>
        </tr>
    </table>
</body>

</html>

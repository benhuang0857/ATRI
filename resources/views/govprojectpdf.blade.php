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
        <!--
            <td width=30 rowspan=11 style="border: 0px;padding:20px" >
                <p>農<br>業<br>科<br>技<br>產<br>學<br>合<br>作<br>計<br>畫<br><br><br></p>
            </td>
        -->
            <td>
                <p>計畫名稱</p>
            </td>
            <td colspan=3>
                {{$case->plan_title}}
            </td>
        </tr>

        <tr style="text-align:center">
            <td>
                主辦單位
            </td>
            <td colspan=3>
                <p>{{$case->organizer}}</p>
            </td>
        </tr>
        <tr>
            <td style="text-align:center">
                <p>聯絡人</p>
            </td>
            <td style="text-align:center">
                <p>{{$case->organizer_contact_name}}</p>
            </td>
            <td style="text-align:center">
                <p>聯絡電話</p>
            </td>
            <td style="text-align:center">
                <p>{{$case->organizer_phone}}</p>
            </td>
        </tr>
        <tr>
            <td style="text-align:center">
                <p>E-mail</p>
            </td>
            <td style="text-align:center">
                <p>{{$case->organizer_email}}</p>
            </td>
            <td style="text-align:center">
                <p>傳真</p>
            </td>
            <td style="text-align:center">
                <p>{{$case->organizer_fax}}</p>
            </td>
        </tr>

        <tr style="text-align:center">
            <td>
                執行單位
            </td>
            <td colspan=3>
                <p>{{$case->coorganizer}}</p>
            </td>
        </tr>
        <tr>
            <td style="text-align:center">
                <p>聯絡人</p>
            </td>
            <td style="text-align:center">
                <p>{{$case->coorganizer_contact_name}}</p>
            </td>
            <td style="text-align:center">
                <p>聯絡電話</p>
            </td>
            <td style="text-align:center">
                <p>{{$case->coorganizer_phone}}</p>
            </td>
        </tr>
        <tr>
            <td style="text-align:center">
                <p>E-mail</p>
            </td>
            <td style="text-align:center">
                <p>{{$case->coorganizer_email}}</p>
            </td>
            <td style="text-align:center">
                <p>傳真</p>
            </td>
            <td style="text-align:center">
                <p>{{$case->coorganizer_fax}}</p>
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
        <?php
            $start_time = date("Y", strtotime($case->date_start_time));
            $start_year = $start_time - 1911;
            $date_start_time = $start_year.date("-m-d", strtotime($case->date_start_time));

            $end_time = date("Y", strtotime($case->date_end_time));
            $end_year = $end_time - 1911;
            $date_end_time = $end_year.date("-m-d", strtotime($case->date_end_time));
        ?>
        <tr>
            <td style="text-align:center">
                <p>申請日期</p>
            </td>
            <td colspan=3 style="padding-left:10px">
                <p>自{{$date_start_time}}至{{$date_end_time}}截止</p>
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

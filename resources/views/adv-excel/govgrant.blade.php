<table>
    <thead>
    <tr>
        <th>編號</th>
        <th>進駐單位</th>
        <th>自然人/組織/公司名稱</th>
        <th>政府補助資源名稱</th>
        <th>計畫名稱</th>
        <th>申請日期</th>
        <th>申請狀態</th>
        <th>補助核定日期</th>
        <th>核定補助金額</th>
        <th>佐證文件</th>
    </tr>
    </thead>
    <tbody>
    @foreach($cases as $key => $case)
    <tr>
        <td>{{ $key+1 }}</td>
        <td>{{ $case->group }}</td>
        <td>{{ $case->name }}</td>
        <td>{{ $case->govgrant['gov_grant_name'] }}</td>
        <td>{{ $case->govgrant['plan_name'] }}</td>
        <td>{{ $case->govgrant['application_time'] }}</td>
        <td>{{ $case->govgrant['application_status'] }}</td>
        <td>{{ $case->govgrant['grant_time'] }}</td>
        <td>{{ $case->govgrant['grant_price'] }}</td>
        <td>{{ $case->govgrant['document'] }}</td>
    </tr>
    @endforeach
    </tbody>
</table>

<table>
    <thead>
    <tr>
        <th>進駐單位</th>
        <th>統計</th>
    </tr>
    </thead>
    <tbody>
    @foreach($groupCals as $key => $cal)
    <tr>
        <td>{{ $cal->group }}</td>
        <td>{{ $cal->sum }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
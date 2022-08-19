<table>
    <thead>
    <tr>
        <th>進駐單位</th>
        <th>自然人/組織/公司名稱</th>
        <th>技轉金額</th>
        <th>合約起迄日</th>
        <th>金額(元)</th>
    </tr>
    </thead>
    <tbody>
    @foreach($cases as $key => $case)
        <tr>
            <td>{{ $case->group }}</td>
            <td>{{ $case->company }}</td>
            <td>{{ $case->tech_transfer_name }}</td>
            <td>{{ $case->date_time }}</td>
            <td>{{ $case->price }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<table>
    <tbody>
    @foreach($groupCase as $key => $case)
        <tr>
            <td>{{ $case->group }}</td>
            <td></td>
            <td></td>
            <td>{{ $case->sum }}</td>
            <td></td>
        </tr>
    @endforeach
    </tbody>
</table>

<table>
    <tbody>
        <tr>
            <td>總計</td>
            <td></td>
            <td></td>
            <td>{{ $resultSum }}</td>
            <td></td>
        </tr>
    </tbody>
</table>
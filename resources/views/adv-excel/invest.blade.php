<table>
    <thead>
    <tr>
        <th>進駐單位</th>
        <th>自然人/組織/公司名稱</th>
        <th>投資/增資</th>
        <th>金額</th>
        <th>日期</th>
    </tr>
    </thead>
    <tbody>
    @foreach($cases as $key => $case)
        <tr>
            <td>{{ $case->group }}</td>
            <td>{{ $case->company }}</td>
            <td>{{ $case->type }}</td>
            <td>{{ $case->price }}</td>
            <td>{{ $case->date_time }}</td>
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
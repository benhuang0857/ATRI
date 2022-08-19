<table>
    <thead>
    <tr>
        <th>進駐單位</th>
        <th>自然人/組織/公司名稱</th>
        <th>進駐時</th>
        <th>增加人數</th>
    </tr>
    </thead>
    <tbody>
    @foreach($cases as $key => $case)
        <tr>
            <td>{{ $case->group }}</td>
            <td>{{ $case->company }}</td>
            <td>{{ $case->ini_staff }}</td>
            <td>{{ $case->diff_staff }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
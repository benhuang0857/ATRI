<table>
    <thead>
    <tr>
        <th>進駐單位</th>
        <th>自然人/組織/公司名稱</th>
        <th>初始營業額</th>
        <th>營業額差額</th>
    </tr>
    </thead>
    <tbody>
    @foreach($cases as $key => $case)
        <tr>
            <td>{{ $case->group }}</td>
            <td>{{ $case->company }}</td>
            <td>{{ $case->revenue }}</td>
            <td>{{ $case->diff_revenue }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
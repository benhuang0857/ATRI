<table>
    <thead>
    <tr>
        <th>進駐單位</th>
        <th>自然人/組織/公司名稱</th>
        @for ($i = 1; $i < $month; $i++)
            <th>{{$i}}月-{{$i+1}}月</th>
        @endfor
        <th>總計</th>
    </tr>
    </thead>
    <tbody>
    @foreach($cases as $key => $case)
    <tr>
        <?php 
            $sum = 0;
        ?>
        @for ($i = 0; $i < $month; $i++)
            @if ($i==0)
            
                <td>{{ $case[$i]->group }}</td>
                <td>{{ $case[$i]->name }}</td>
            @else
                <?php
                    $sum += (int)$case[$i];
                ?>
                <td>{{ $case[$i] }}</td>
            @endif
        @endfor
            <td>{{ $sum }}</td>
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
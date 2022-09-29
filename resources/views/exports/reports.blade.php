<table class="table user_table">
    <thead class="table-light">
    <tr>
        <th scope="col">#</th>
        <th scope="col">اسم الموظف</th>
        <th scope="col" colspan="2">تاريخ العملية</th>
        <th scope="col" colspan="2">رقم التتبع</th>
        <th scope="col">نوع الحوالة</th>
        <th scope="col">نوع المعاملة</th>
        <th scope="col">نوع العملة</th>
        <th scope="col" colspan="2">المبلغ</th>
        <th scope="col" colspan="2">تسليم بالدولار</th>
        <th scope="col" colspan="2">تسليم بالشيكل</th>
        <th class="table-active" scope="col" colspan="2">الربح بالدولار</th>
        <th class="table-active" scope="col" colspan="2">الربح بالشيكل</th>
        <th class="table-active" scope="col" colspan="2">سعر الدولار</th>
        <th class="table-active" scope="col" colspan="2">نسبة مئوية</th>
        <th class="table-active" scope="col" colspan="2">قيمة رقمية</th>
        @foreach($reports as $key => $report)

            @if($report->updated_by == null)
            @else
                    <th scope="col">تعديل بواسطة</th>
            @endif
        @endforeach

    </tr>

    </thead>
    <tbody>
    @foreach($reports as $key => $report)
        <tr>
            <th>{{++$key}}</th>
            <td>{{$report->UserReport->name}}</td>
            <td colspan="2">{{$report->created_at}}</td>
            <td colspan="2">{{$report->transaction_NO}}</td>
            <td>{{$report->remittance_type}}</td>
            <td>{{$report->transaction_type}}</td>
            <td>{{$report->currency_type}}</td>
            <td colspan="2">{{$report->amount}}</td>
            <td colspan="2">{{$report->delivery_USD}}</td>
            <td colspan="2">{{$report->delivery_ILS}}</td>
            @if($report->currency_type == 'دولار' && $report->delivery_USD == 0)
                <td class="table-active" colspan="2">{{$report->profit_USD}}</td>
                <td class="table-active" colspan="2">0</td>
            @elseif($report->currency_type == 'شيكل' && $report->profit_ILS == 0)
                <td class="table-active" colspan="2">0</td>
                <td class="table-active" colspan="2">{{$report->profit_ILS}}</td>
            @elseif($report->currency_type == 'دولار')
                <td class="table-active" colspan="2">{{$report->profit_USD}}</td>
                <td class="table-active" colspan="2">0</td>
            @else
                <td class="table-active" colspan="2">0</td>
                <td class="table-active" colspan="2">{{$report->profit_ILS}}</td>
            @endif
            <th class="table-active" scope="col" colspan="2">{{$report->dollar}}</th>
            <th class="table-active" scope="col" colspan="2">{{$report->percent}}</th>
            <th class="table-active" scope="col" colspan="2">{{$report->numerical}}</th>
            @if($report->updated_by == null)
            @else
                <td >{{$report->UserUpdateReport->name}}</td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
